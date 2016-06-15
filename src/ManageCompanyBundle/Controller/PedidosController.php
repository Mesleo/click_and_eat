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
     * Muestra la lista de pedidos
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
        $this->initialize();
        $pedido = $this->em->getRepository('AppBundle:Pedido')
            ->getInfoOrder($id_pedido);
        if($this->checkRestaurante($pedido[0])) {
            $lineasPedido = $this->em->getRepository('AppBundle:Pedido')
                ->getInfoProductOrder($id_pedido);
            $this->params['trabajadores'] = $this->em->getRepository("AppBundle:Trabajador")
                ->showEmployeesRestaurant($this->getIdRestaurante());

            for ($i = 0; $i < count($lineasPedido); $i++) {
                foreach ($lineasPedido[$i] as $key => $lp) {
                    if ($key == 'total') {
                        $total += $lp;
                    }
                }
            }
            $this->params['total'] = $total;
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
     * Guarda los cambios en el pedido (campos "estado" y "fecha_envio")
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
        $pedido->setEstado($estado);
        $pedido->setTrabajador($trabajador);
        if(!$request->request->has('fecha-llegada') or $request->request->get('fecha-salida') == null){
            $fechaSalida = null;
        } else $fechaSalida = \DateTime::createFromFormat('d-m-Y H:i', $request->request->get('fecha-salida'));
        if(!$request->request->has('fecha-llegada') or $request->request->get('fecha-llegada') == ""){
            $fechaLlegada = null;
        } else $fechaLlegada = \DateTime::createFromFormat('d-m-Y H:i', $request->request->get('fecha-llegada'));
        $pedido->setFechaHoraSalida($fechaSalida);
        $pedido->setFechaHoraLlegada($fechaLlegada);
        $this->em->persist($pedido);
        $this->em->flush();
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
            if($request->request->get('desde')!= null ) {
                $fechaDesde = \DateTime::createFromFormat("d-m-Y", $request->request->get('desde'));
            }
            if($request->request->get('hasta')!= null){
                $fechaHasta = \DateTime::createFromFormat("d-m-Y", $request->request->get('hasta'));
            }
            $this->params['pedidos'] = $this->em->getRepository('AppBundle:Pedido')
                ->getGeneralInfoOrdersBetweenDates($this->getIdRestaurante(), $fechaDesde, $fechaHasta);
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
        $pedido->setEstado($estado = $this->setState(3));
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
        $pedido->setEstado($estado = $this->setState(5));
        $this->em->persist($pedido);
        $this->em->flush();
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
     * Compruebo que id del usuario logeado sea el id del restaurante con el que estoy trabajando
     *
     * @param $trabajador
     * @return bool
     */
    private function checkRestaurante($pedido)
    {
        return $pedido['idRestaurante'] == $this->getIdRestaurante();
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