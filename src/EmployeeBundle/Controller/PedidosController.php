<?php

namespace EmployeeBundle\Controller;

use AppBundle\Entity\Recorrido;
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
     * Muestra todos los pedidos de un trabajador
     *
     * @Route("/pedidos/{estado_id}", name="empleado_gestion_pedidos")
     * @Security("has_role('ROLE_EMPLOYEE')")
     */
    public function orderAction($estado_id = null){
        $this->initialize();
        $this->params['pedidos'] = $this->em->getRepository('AppBundle:Pedido')
            ->getGeneralInfoOrdersByEmployee($this->getIdTrabajador(), $estado_id);
        $this->params['estados'] = $this->getEstados();
        return $this->render('EmployeeBundle:Empleado:pedidos.html.twig', $this->params);
    }

    /**
     * Muestra toda la información de un pedido
     *
     * @Route("/pedidos/pedido/editar/{id_pedido}", name="employee_edit_pedido")
     * @Security("has_role('ROLE_EMPLOYEE')")
     */
    public function showOrderAction($id_pedido){
        $total = 0;
        $totalDescuento = 0;
        $this->initialize();
        $pedido = $this->em->getRepository('AppBundle:Pedido')
            ->getInfoOrder($id_pedido);
        if($pedido and $this->checkOrderEmployee($pedido[0]['idTrabajador'])) {
            $lineasPedido = $this->em->getRepository('AppBundle:Pedido')
                ->getInfoProductOrder($id_pedido);
            $restaurante = $this->em->getRepository("AppBundle:Restaurante")
                ->findOneBy([
                    "id" => $this->getTrabajador()->getRestaurante()
                ]);

            for ($i = 0; $i < count($lineasPedido); $i++) {
                foreach ($lineasPedido[$i] as $key => $lp) {
                    if ($key == 'total') {
                        $total += $lp;
                    }else if ($key == 'totalDescuento'){
                        $totalDescuento += $lp;
                    }
                }
            }
            $this->params['restaurante'] = $restaurante;
            $this->params['total'] = $total;
            $this->params['totalDescuento'] = $totalDescuento;
            $this->params['totalPrecioEnvio'] = $totalDescuento + $restaurante->getPrecioEnvio();
            $this->params['estados'] = $this->getEstados();

            if ($lineasPedido[0]['pedido_id'] == $pedido[0]['id']) {
                $this->params['pedido'] = $pedido[0];
                $this->params['linea_pedido'] = $lineasPedido;
                return $this->render('EmployeeBundle:Empleado:pedido.html.twig', $this->params);
            } else {
                throw new InvalidResourceException("Pedido no encontrado");
            }
        }
        return $this->redirectToRoute("empleado_gestion_pedidos");
    }

    /**
     * Pone un pedido como "En reparto"
     *
     * @Route("/pedidos/pedido/enviado/{id_pedido}", name="employee_send_pedido")
     */
    public function setStateSend($id_pedido){
        $this->initialize();
        $pedido = $this->em->getRepository('AppBundle:Pedido')
            ->findOneBy([
                "id" => $id_pedido
            ]);
        $pedido->setEstado($this->setState(4));
        $date = date('Y-m-d');
        $fechaHoraActual = \DateTime::createFromFormat('Y-m-d', $date);
        $pedido->setFechaHoraSalida($fechaHoraActual);
        $pedido->setFechaHoraLlegada(null);
        $this->em->persist($pedido);
        $this->em->flush();
        return $this->redirectToRoute("empleado_gestion_pedidos_recorrido", array("id_recorrido"=> $pedido->getRecorrido()->getId()));
    }

    /**
     * Cancela un pedido
     *
     * @Route("/pedidos/pedido/cancelado/{id_pedido}", name="employee_cancel_pedido")
     */
    public function setStateCancel($id_pedido){
        $this->initialize();
        $pedido = $this->em->getRepository('AppBundle:Pedido')
            ->findOneBy([
                "id" => $id_pedido
            ]);
        $pedido->setEstado($estado = $this->setState(3));
        $date = date('Y-m-d');
        $fechaHoraActual = \DateTime::createFromFormat('Y-m-d', $date);
        $pedido->setEstado($this->setState(3));
        $pedido->setFechaHoraSalida($fechaHoraActual);
        $pedido->setFechaHoraLlegada($fechaHoraActual);
        $this->em->persist($pedido);
        $this->em->flush();
        return $this->redirectToRoute("empleado_gestion_pedidos_recorrido", array("id_recorrido"=> $pedido->getRecorrido()->getId()));
    }

    /**
     * Pone un pedido como entregado
     *
     * @Route("/pedidos/pedido/entregado/{id_pedido}", name="employee_deliver_pedido")
     */
    public function setStateDelivered($id_pedido){
        $this->initialize();
        $pedido = $this->em->getRepository('AppBundle:Pedido')
            ->findOneBy([
                "id" => $id_pedido
            ]);
        $pedido->setEstado($estado = $this->setState(5));
        $date = date('Y-m-d');
        $pedido->setEstado($this->setState(5));
        $fechaHoraActual = \DateTime::createFromFormat('Y-m-d', $date);
        $pedido->setFechaHoraLlegada($fechaHoraActual);
        $this->em->persist($pedido);
        $this->em->flush();
        $this->checkOrdersByTravel($pedido->getRecorrido()->getId());
        return $this->redirectToRoute("empleado_gestion_pedidos_recorrido", array("id_recorrido"=> $pedido->getRecorrido()->getId()));
    }

    /**
     * Elimina las fechas de un pedido
     *
     * @Route("/pedidos/pedido/limpiar/{id_pedido}", name="clean_dates")
     */
    public function cleanDatesOrder($id_pedido){
        $this->initialize();
        $pedido = $this->em->getRepository('AppBundle:Pedido')
            ->findOneBy([
                "id" => $id_pedido
            ]);
        $pedido->setEstado($estado = $this->setState(1));
        $pedido->setFechaHoraSalida(null);
        $pedido->setFechaHoraLlegada(null);
        $this->em->persist($pedido);
        $this->em->flush();
        return $this->redirectToRoute("employee_edit_pedido", array('id_pedido'=>$id_pedido));
    }

    /**
     * Compruebo si todos los pedidos de ese recorrido han sido entregados
     */
    private function checkOrdersByTravel($idRecorrido){
        $cont = 0;
        $arrayPedidos = $this->em->getRepository("AppBundle:Pedido")
            ->getOrdersByTravel($idRecorrido);
        foreach($arrayPedidos as $pedido){
            if($pedido['estado_id'] == 5) $cont++;
        }
        if($cont == count($arrayPedidos)){
            $arraySalidas = [];
            $arrayLlegadas = [];
            foreach($arrayPedidos as $pedido){
                if($pedido['salida']){
                    $arraySalidas[]= date($pedido['salida']);
                }
                if ($pedido['llegada']){
                    $arrayLlegadas[]= date($pedido['llegada']);
                }
                if($pedido['id']){
                    $ped = $this->em->getRepository("AppBundle:Pedido")
                        ->findOneBy(['id'=>$pedido['id']]);
                    $ped->setEstado($this->getState(8));
                    $this->em->persist($ped);
                }
            }
            if(count($arrayLlegadas)>1) {
                $aux = 99999999999999999;
                foreach ($arraySalidas as $salida) {
                    if ($salida <= $aux) {
                        $aux = $salida;
                    } else  $sal = date($aux);
                }
                $aux2 = 9999999999999999;
                foreach ($arrayLlegadas as $llegada) {
                    if ($llegada >= $aux2) {
                        $lle = date($llegada);
                    } else  $aux2 = $llegada;
                }
            }else{
                $sal = $arraySalidas[0];
                $lle = $arrayLlegadas[0];
            }
            $recorrido = $this->em->getRepository("AppBundle:Recorrido")
                ->findOneBy(['id' => $idRecorrido]);
            $recorrido->setFechaHoraSalida(\DateTime::createFromFormat('Y-m-d H:i:s', $sal));
            $recorrido->setFechaHoraLlegada(\DateTime::createFromFormat('Y-m-d H:i:s', $lle));
            $recorrido->setTrash(1);

            $this->em->persist($recorrido);
            $this->em->flush();
        }
    }

    /**
     * Modifico el estado de un pedido
     *
     * @param $id
     * @return mixed
     */
    private function setState($id){
        return $this->em->getRepository('AppBundle:Estado')
            ->findOneBy([
                "id" => $id
            ]);
    }

    /**
     * Obtengo los estados de los pedidos
     *
     * @return mixed
     */
    private function getEstados(){
        return $this->em->getRepository("AppBundle:Estado")
            ->getStatesOrdersByEmployee();
    }

    /**
     * Devuelvo un stado
     *
     * @param $id
     */
    private function getState($id){
        return $this->em->getRepository("AppBundle:Estado")
            ->findOneBy(["id"=>$id]);
    }

    /**
     * Obtengo el id del trabajador logeado
     *
     * @return mixed
     */
    private function getIdTrabajador()
    {
        $user = $this->em->getRepository("AppBundle:Usuario")
            ->findOneBy([
                'id' => $this->getUser()->getId()
            ]);
        return  $this->em->getRepository("AppBundle:Trabajador")
            ->findOneBy([
                'usuario' => $user->getId()
            ])->getId();
    }

    private function getTrabajador(){
        return  $this->em->getRepository("AppBundle:Trabajador")
            ->findOneBy([
                'usuario' => $this->getUser()->getId()
            ]);
    }

    /**
     * Compruebo que idTrabajador del pedido editado es el id del trabajador logeado
     *
     * @param $pedidoIdTrabajador
     * @return bool
     */
    private function checkOrderEmployee($pedidoIdTrabajador)
    {
        return $pedidoIdTrabajador == $this->getIdTrabajador();
    }

    private function initialize(){
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }
}