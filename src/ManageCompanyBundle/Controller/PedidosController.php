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

        $this->params['pedidos'] = $this->em->getRepository('AppBundle:Pedido')
            ->getGeneralInfoOrders($this->getRestaurante());
        return $this->render('ManageCompanyBundle:Restaurante:pedidos.html.twig', $this->params);
    }

    /**
     * Muestra toda la información de un pedido
     *
     * @Route("/pedidos/{id_pedido}", name="edit_pedido")
     */
    public function showOrderAction($id_pedido){
        $total = 0;
        $this->initialize();
        $pedido = $this->em->getRepository('AppBundle:Pedido')
            ->getInfoOrder($id_pedido);
        $lineasPedido = $this->em->getRepository('AppBundle:Pedido')
            ->getInfoProductOrder($id_pedido);
        $this->params['trabajadores'] = $this->em->getRepository("AppBundle:Trabajador")
            ->showEmployeesRestaurant($this->getRestaurante());

        for($i = 0; $i < count($lineasPedido); $i++){
            foreach($lineasPedido[$i] as $key => $lp) {
                if ($key == 'total') {
                    $total += $lp;
                }
            }
        }
        $this->params['total'] = $total;

        $this->params['estados'] = $this->em->getRepository("AppBundle:Estado")
            ->findAll([],[
                "estado" => "ASC"
            ]);

        if($lineasPedido[0]['pedido_id'] == $pedido[0]['id'] ){
            $this->params['pedido'] = $pedido[0];
            $this->params['linea_pedido'] = $lineasPedido;
            return $this->render('ManageCompanyBundle:Restaurante:pedido.html.twig', $this->params);
        }else{
            throw new InvalidResourceException("Pedido no encontrado");
        }
    }

    /**
     * Guarda los cambios en el pedido (campos "estado" y "fecha_envio")
     *
     * @Route("/pedido/guardar}", name="guardar_info_pedido")
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
        $fechaSalida = \DateTime::createFromFormat('Y-m-d H:i', $request->request->get('fecha-salida'));
        $fechaLlegada = \DateTime::createFromFormat('Y-m-d H:i', $request->request->get('fecha-llegada'));
        $pedido->setFechaHoraSalida($fechaSalida);
        $pedido->setFechaHoraLlegada($fechaLlegada);
        $this->em->persist($pedido);
        $this->em->flush();
        return $this->redirectToRoute("edit_pedido", array('id_pedido' => $request->request->get("pedido-id")));
    }

    /**
     * Obtengo el restaurante logeado (Tabla Restaurante)
     *
     * @return mixed
     */
    private function getRestaurante(){
        $user = $this->em->getRepository("AppBundle:Usuario")
            ->findOneBy([
                "id" => $this->getUser()->getId()
            ]);
        return  $this->em->getRepository('AppBundle:Restaurante')
            ->findOneBy([
                'id' => $user->getIdRestaurante()->getId()
            ])->getId();
    }

    private function initialize(){
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }
}