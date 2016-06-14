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

class PedidosController extends Controller{

    private $em = null;
    private $params = null;

    /**
     * Muestra la lista de pedidos de hoy
     *
     * @Route("/pedidos", name="gestion_pedidos")
     * @Security("has_role('ROLE_MANAGE')")
     */
    public function orderAction(){
        $this->initialize();
        $fecha = date('Y-m-d');
        $this->params['pedidos'] = $this->em->getRepository('AppBundle:Pedido')
            ->getGeneralInfoOrdersToday($this->getIdRestaurante(), $fecha);
        $this->params['estados'] = $this->getEstados();
        return $this->render('ManageCompanyBundle:Restaurante:pedidos.html.twig', $this->params);
    }

    /**
     * Muestra toda la información de un pedido
     *
     * @Route("/pedido/editar/{id_pedido}", name="edit_pedido")
     */
    public function showOrderAction($id_pedido){
        $total = 0;
        $totalDescuento = 0;
        $this->initialize();
        $pedido = $this->em->getRepository('AppBundle:Pedido')
            ->getInfoOrder($id_pedido);
        if($pedido and $this->checkRestaurante($pedido[0]['idRestaurante'])) {
            $lineasPedido = $this->em->getRepository('AppBundle:Pedido')
                ->getInfoProductOrder($id_pedido);
            $this->params['restaurante'] = $this->em->getRepository("AppBundle:Restaurante")
                ->findOneBy([
                    "id" => $this->getIdRestaurante()
                ]);
            $this->params['trabajadores'] = $this->em->getRepository("AppBundle:Trabajador")
                ->showEmployeesRestaurant($this->getIdRestaurante());

            for ($i = 0; $i < count($lineasPedido); $i++) {
                foreach ($lineasPedido[$i] as $key => $lp) {
                    if ($key == 'total') {
                        $total += $lp;
                    }else if ($key == 'totalDescuento'){
                        $totalDescuento += $lp;
                    }
                }
            }
            $this->params['total'] = $total;
            $this->params['totalDescuento'] = $totalDescuento;
            $this->params['totalPrecioEnvio'] = $totalDescuento+$this->params['restaurante']->getPrecioEnvio();
            $this->params['estados'] = $this->getEstados();

            if ($lineasPedido[0]['pedido_id'] == $pedido[0]['id']) {
                $this->params['pedido'] = $pedido[0];
                $this->params['linea_pedido'] = $lineasPedido;
                return $this->render('ManageCompanyBundle:Restaurante:pedido.html.twig', $this->params);
            } else {
                throw new InvalidResourceException("Pedido no encontrado");
            }
        }
        return $this->redirectToRoute("gestion_pedidos");
    }

    /**
     * Guarda los cambios en el pedido (campos "estado", "fecha_salida", ·fecha_llegada)
     *
     * @Route("/pedido/guardar", name="guardar_info_pedido")
     */
    public function saveOrderInfoAction(Request $request){
        $this->initialize();
        $pedido = $this->em->getRepository('AppBundle:Pedido')
            ->findOneBy([
                "id" => $request->request->get("pedido-id")
            ]);
        $estado = $this->em->getRepository("AppBundle:Estado")
            ->findOneBy([
                "id" => $request->request->get("estado")
            ]);
        $trabajador = $this->em->getRepository("AppBundle:Trabajador")
            ->findOneBy([
                "id" => $request->request->get("trabajador-id")
            ]);
        if($pedido and $this->checkRestaurante($pedido->getRestaurante()->getId())) {
            $pedido->setEstado($estado);
            $pedido->setNumPedido($request->request->get("num-pedido"));
            $pedido->setTrabajador($trabajador);
            if (!$request->request->has('fecha-llegada') or $request->request->get('fecha-salida') == null) {
                $fechaSalida = null;
            } else $fechaSalida = \DateTime::createFromFormat('d-m-Y H:i', $request->request->get('fecha-salida'));
            if (!$request->request->has('fecha-llegada') or $request->request->get('fecha-llegada') == "") {
                $fechaLlegada = null;
            } else $fechaLlegada = \DateTime::createFromFormat('d-m-Y H:i', $request->request->get('fecha-llegada'));
            $pedido->setFechaHoraSalida($fechaSalida);
            $pedido->setFechaHoraLlegada($fechaLlegada);
            $this->em->persist($pedido);
            $this->em->flush();
        }
        return $this->redirectToRoute("gestion_pedidos");
    }

    /**
     * Muestra los pedidos entre fechas
     *
     * @Route("/pedidos/entre", name="pedidos_entre_fechas")
     */
    public function showOrdersBetweenDates(Request $request){
        $this->initialize();
        $this->params['estados'] = $this->getEstados();
        if($request->request->has("desde")  && $request->request->has('hasta')){
            $fechaDesde = \DateTime::createFromFormat("Y-m-d", '2000-01-01');
            $fechaHasta = \DateTime::createFromFormat("Y-m-d", '2100-12-31');
            if($request->request->get('desde') == $request->request->get('hasta')){
                $fecha = $this->setFormatDate($request->request->get('hasta'));
                $this->params['pedidos'] = $this->em->getRepository('AppBundle:Pedido')
                    ->getGeneralInfoOrdersToday($this->getIdRestaurante(), $fecha);
            }else {
                if ($request->request->get('desde') != null) {
                    $fechaDesde = \DateTime::createFromFormat("d-m-Y H:i:s", $request->request->get('desde') . ' 00:00:00');
                }
                if ($request->request->get('hasta') != null) {
                    $fechaHasta = \DateTime::createFromFormat("d-m-Y H:i:s", $request->request->get('hasta') . ' 23:59:59');
                }
                $this->params['pedidos'] = $this->em->getRepository('AppBundle:Pedido')
                    ->getGeneralInfoOrdersBetweenDates($this->getIdRestaurante(), $fechaDesde, $fechaHasta);
            }
            return $this->render('ManageCompanyBundle:Restaurante:pedidos.html.twig', $this->params);
        }
        return $this->redirectToRoute('gestion_pedidos');
    }

    /**
     * Pone un pedido como "Enviado"
     *
     * @Route("/pedido/enviar/{id_pedido}", name="send_pedido")
     */
    public function setStateSend($id_pedido){
        $this->initialize();
        $pedido = $this->em->getRepository('AppBundle:Pedido')
            ->findOneBy([
                "id" => $id_pedido
            ]);
        $pedido->setEstado($this->setState(4));
        $this->em->persist($pedido);
        $this->em->flush();
        return $this->redirectToRoute("gestion_pedidos");
    }

    /**
     * Cancela un pedido
     *
     * @Route("/pedido/cancelar/{id_pedido}", name="cancel_pedido")
     */
    public function setStateCancel($id_pedido){
        $this->initialize();
        $pedido = $this->em->getRepository('AppBundle:Pedido')
            ->findOneBy([
                "id" => $id_pedido
            ]);
        $pedido->setEstado($this->setState(3));
        $this->em->persist($pedido);
        $this->em->flush();
        return $this->redirectToRoute("gestion_pedidos");
    }

    /**
     * Pone un pedido como entregado
     *
     * @Route("/pedido/entregado/{id_pedido}", name="deliver_pedido")
     */
    public function setStateDelivered($id_pedido){
        $this->initialize();
        $pedido = $this->em->getRepository('AppBundle:Pedido')
            ->findOneBy([
                "id" => $id_pedido
            ]);
        $pedido->setEstado($this->setState(5));
        $this->em->persist($pedido);
        $this->em->flush();
        return $this->redirectToRoute("gestion_pedidos");
    }

    /**
     * Archiva un pedido
     *
     * @Route("/pedido/archivado/{id_pedido}", name="archived_pedido")
     */
    public function setStateArchived($id_pedido){
        $this->initialize();
        $pedido = $this->em->getRepository('AppBundle:Reserva')
            ->findOneBy([
                "id" => $id_pedido
            ]);
        if($this->checkRestaurante($pedido->getRestaurante()->getID())) {
            $pedido->setEstado($this->setState(8));
            $this->em->persist($pedido);
            $this->em->flush();
        }
        return $this->redirectToRoute("gestion_pedidos");
    }

    /**
     * Muestro los pedidos por estado
     *
     * @Route("/pedidos/estado", name="show_orders_state")
     */
    public function showOrdersByState(Request $request){
        $this->initialize();
        $this->params['pedidos'] = $this->em->getRepository('AppBundle:Pedido')
            ->getGeneralInfoOrdersByState($this->getIdRestaurante(), $request->query->get("estado"));
        $this->params['estados'] = $this->getEstados();
        return $this->render('ManageCompanyBundle:Restaurante:pedidos.html.twig', $this->params);
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

    private function setState($id){
        return $this->em->getRepository('AppBundle:Estado')
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
    private function checkRestaurante($pedidoIdRestaurante)
    {
        return $pedidoIdRestaurante == $this->getIdRestaurante();
    }

    private function getEstados(){
        return $this->em->getRepository("AppBundle:Estado")
            ->findAll([],[
                "estado" => "ASC"
            ]);
    }

    private function initialize(){
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }
}