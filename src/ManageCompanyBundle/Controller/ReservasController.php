<?php

namespace ManageCompanyBundle\Controller;

use Doctrine\Common\Proxy\Exception\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Translation\Exception\InvalidResourceException;
use Symfony\Component\Validator\Constraints\DateTime;

class ReservasController extends Controller{

    private $em = null;
    private $params = null;

    /**
     * Muestra la lista de reservas de hoy
     *
     * @Route("/reservas", name="gestion_reservas")
     * @Security("has_role('ROLE_MANAGE')")
     */
    public function reserveAction(){
        $this->initialize();
        $fecha = date('Y-m-d');
        $this->params['reservas'] = $this->em->getRepository('AppBundle:Reserva')
            ->getReservesBetweenDates($this->getIdRestaurante(), $fecha, $fecha);
        $this->params['mesas_reserva'] = $this->em->getRepository("AppBundle:Reserva")
            ->findBy([
                "restaurante" => $this->getIdRestaurante()
            ]);
        $this->params['estados_reservas'] = $this->getEstadoReservas();
        return $this->render('ManageCompanyBundle:Restaurante:reservas.html.twig', $this->params);
    }

    /**
     * Muestra toda la información de una reserva
     *
     * @Route("/reserva/editar/{id_reserva}", name="edit_reserva")
     */
    public function showReserveAction($id_reserva){
        $this->initialize();
        $reserva = $this->em->getRepository('AppBundle:Reserva')
            ->findOneBy([
                "id" => $id_reserva
            ]);
        if($reserva and $this->checkRestaurante($reserva->getRestaurante()->getId())) {
            $this->params['restaurante'] = $this->em->getRepository("AppBundle:Restaurante")
                ->findOneBy([
                    "id" => $this->getIdRestaurante()
                ]);
            $this->params['mesas_reserva'] = $this->em->getRepository("AppBundle:Reserva")
                ->getTablesInReserves($id_reserva);
            $this->params['mesas'] = $this->em->getRepository("AppBundle:Mesa")
                ->findBy([
                    "restaurante" => $this->getIdRestaurante()
                ]);
            $this->params['reserva'] = $reserva;
            $this->params['estados_reservas'] = $this->getEstadoReservas();
            return $this->render('ManageCompanyBundle:Restaurante:reserva.html.twig', $this->params);
        }else {
            throw new InvalidResourceException("Reserva no encontrada");
        }
        return $this->redirectToRoute("gestion_reservas");
    }

    /**
     * Guarda los cambios de la reserva (campos "estado_reserva", "fecha_salida", ·fecha_llegada)
     *
     * @Route("/reserva/guardar", name="guardar_info_reserva")
     */
    public function saveReserveInfoAction(Request $request){
        $this->initialize();
        $reserva = $this->em->getRepository('AppBundle:Reserva')
            ->findOneBy([
                "id" => $request->request->get("reserva-id")
            ]);
        $estado_reserva = $this->em->getRepository("AppBundle:EstadoReserva")
            ->findOneBy([
                "id" => $request->request->get("estado-reserva")
            ]);
        if($reserva and $this->checkRestaurante($reserva->getRestaurante()->getId())) {
            $reserva->setEstado($estado_reserva);
            $reserva->setNumReserva($request->request->get("num-reserva"));
            $reserva->setNumReserva($request->request->get("num-personas"));
            if (!$request->request->has('fecha-hora-prevista') or $request->request->get('fecha-hora-prevista') == "") {
                $fechaHoraPrevista = null;
            } else $fechaHoraPrevista = \DateTime::createFromFormat('d-m-Y H:i', $request->request->get('fecha-hora-prevista'));
            $reserva->setFechaHora($fechaHoraPrevista);
            $this->em->persist($reserva);
            $mesasReservas = $this->em->getRepository("AppBundle:Reserva")
                ->getTablesInReserves($reserva->getId());
            if($request->request->has("mesa")) {
                $arrayMesas = $request->request->get("mesa");
                $this->em->getRepository("AppBundle:Reserva")
                    ->deleteTablesInReserves($reserva->getId());
                for($i=0;$i<count($arrayMesas);$i++){
                    $this->em->getRepository("AppBundle:Reserva")
                        ->setTablesInReserves($reserva->getId(), $arrayMesas[$i]);
                }
            }
            $this->em->flush();
        }
        return $this->redirectToRoute("gestion_reservas");
    }

    /**
     * Muestra los reservas entre fechas
     *
     * @Route("/reservas/entre", name="reservas_entre_fechas")
     */
    public function showReservesBetweenDates(Request $request){
        $this->initialize();
        $this->params['estados_reservas'] = $this->getEstadoReservas();
        if($request->request->has("desde")  && $request->request->has('hasta')){
            $fechaDesde = '2000-01-01 00:00:00';
            $fechaHasta = '2100-12-31 23:59:59';
            if ($request->request->get('desde') != null) {
                $fechaDesde = $this->setFormatDate($request->request->get('desde')) . ' 00:00:00';
            }
            if ($request->request->get('hasta') != null) {
                $fechaHasta = $this->setFormatDate($request->request->get('hasta')) . ' 23:59:59';
            }
            $this->params['reservas'] = $this->em->getRepository('AppBundle:Reserva')
                ->getReservesBetweenDates($this->getIdRestaurante(), $fechaDesde, $fechaHasta);
            return $this->render('ManageCompanyBundle:Restaurante:reservas.html.twig', $this->params);
        }
        return $this->redirectToRoute('gestion_reservas');
    }

    /**
     * Archiva una reserva
     *
     * @Route("/reserva/archivada/{id_reserva}", name="archived_reserva")
     */
    public function setStateArchived($id_reserva){
        $this->initialize();
        $reserva = $this->em->getRepository('AppBundle:Reserva')
            ->findOneBy([
                "id" => $id_reserva
            ]);
        if($this->checkRestaurante($reserva->getRestaurante()->getID())) {
            $reserva->setEstado($estado_reserva = $this->setState(4));
            $this->em->persist($reserva);
            $this->em->flush();
        }
        return $this->redirectToRoute("gestion_reservas");
    }

    /**
     * Cancela una reserva
     *
     * @Route("/reserva/cancelada/{id_reserva}", name="cancel_reserva")
     */
    public function setStateCancel($id_reserva){
        $this->initialize();
        $reserva = $this->em->getRepository('AppBundle:Reserva')
            ->findOneBy([
                "id" => $id_reserva
            ]);
        if($this->checkRestaurante($reserva->getRestaurante()->getID())) {
            print_r($reserva->getRestaurante()->getId());
            $reserva->setEstado($estado_reserva = $this->setState(3));
            $this->em->persist($reserva);
            $this->em->flush();
        }
        return $this->redirectToRoute("gestion_reservas");
    }

    /**
     * Confirma una reserva
     *
     * @Route("/reserva/confirmada/{id_reserva}", name="confirm_reserva")
     */
    public function setStateDelivered($id_reserva){
        $this->initialize();
        $reserva = $this->em->getRepository('AppBundle:Reserva')
            ->findOneBy([
                "id" => $id_reserva
            ]);
        if($this->checkRestaurante($reserva->getRestaurante()->getID())) {
            print_r($reserva->getRestaurante()->getId());
            $reserva->setEstado($estado_reserva = $this->setState(2));
            $this->em->persist($reserva);
            $this->em->flush();
        }
        return $this->redirectToRoute("gestion_reservas");
    }

    /**
     * Muestro los reservas por estado_reserva
     *
     * @Route("/reservas/estado_reserva", name="show_reserves_state")
     */
    public function showReservesByState(Request $request){
        $this->initialize();
        $this->params['reservas'] = $this->em->getRepository('AppBundle:Reserva')
            ->getReservesByState($this->getIdRestaurante(), $request->query->get("estado"));
        $this->params['estados_reservas'] = $this->getEstadoReservas();

        return $this->render('ManageCompanyBundle:Restaurante:reservas.html.twig', $this->params);
    }

    /**
     * Obtengo el id del restaurante logeado
     *
     * @return mixed
     */
    private function getIdRestaurante()
    {
        $user = $this->em->getRepository("AppBundle:Usuario")
            ->findOneBy([
                'id' => $this->getUser()->getId()
            ]);
        return  $this->em->getRepository("AppBundle:Restaurante")
            ->findOneBy([
                'usuario' => $user->getId()
            ])->getId();
    }

    /**
     * Cambia el estado de la reserva
     *
     * @param $id
     * @return mixed
     */
    private function setState($id){
        return $this->em->getRepository('AppBundle:EstadoReserva')
            ->findOneBy([
                "id" => $id
            ]);
    }

    /**
     * Formatea la fecha pasada a formato americano
     * @param $string
     * @return string
     */
    private function setFormatDate($string){
        $arrayDate = explode("-", $string);
        $fechaFormat = $arrayDate[2].'-'.$arrayDate[1].'-'.$arrayDate[0];
        return $fechaFormat;
    }

    /**
     * Compruebo que id del usuario logeado sea el id del restaurante con el que estoy trabajando
     *
     * @param $trabajador
     * @return bool
     */
    private function checkRestaurante($reservaIdRestaurante)
    {
        return $reservaIdRestaurante == $this->getIdRestaurante();
    }

    private function getEstadoReservas(){
        return $this->em->getRepository("AppBundle:EstadoReserva")
            ->findAll([],[
                "estado" => "ASC"
            ]);
    }

    private function initialize(){
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }
}