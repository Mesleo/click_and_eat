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
class RecorridosController extends Controller
{

    private $em = null;
    private $params = null;

    /**
     * Muestra los recorridos adjudicados a un trabajador
     *
     * @Route("/", name="empleado_gestion_recorridos")
     * @Security("has_role('ROLE_EMPLOYEE')")
     */
    public function indexAction(Request $request, $estado = 0)
    {
        $this->initialize();
        if($request->query->has("estado") and $request->query->get("estado")!= null) {
            $estado = $request->query->get("estado");
        }
         $recorridos = $this->em->getRepository("AppBundle:Trabajador")
            ->getRecorridos($this->getIdTrabajador(), $estado);
        $arrayCountOrderTravel = [];
        $restaurante = $this->getRestaurante($this->getTrabajador()->getRestaurante());
        $this->params['restaurante'] = $restaurante;
        $arrayOrderTravel = [];
        foreach($recorridos as $recorrido){
            foreach($recorrido as $key => $value)
                if($key == 'id'){
                    $cont = $this->em->getRepository("AppBundle:Recorrido")
                        ->getCountOrderByTravel($value);
                    $pedidos = $this->em->getRepository("AppBundle:Recorrido")
                        ->getInfoProductOrderByTravel($value);
                    $arrayCountOrderTravel[] = $cont;
                    $arrayOrderTravel[] = $pedidos;
                }
        }
        if($cont[0]['COUNT(*)'] <= 0 ){
            $this->params['info'] = "No se han encontrado resultados";
        }else{
            $this->params['total_pedidos'] = $arrayCountOrderTravel;
            $this->params['total_recorrido'] = $arrayOrderTravel;
            $this->params['recorridos'] = $recorridos;
        }
        $this->params['estados'] = $this->getEstados();
        return $this->render('EmployeeBundle:Empleado:recorridos.html.twig', $this->params);
    }

    /**
     * Muestra la vista de los pedidos de un recorrido
     *
     * @Route("/recorrido/{id_recorrido}", name="empleado_gestion_pedidos_recorrido")
     * @Security("has_role('ROLE_EMPLOYEE')")
     */
    public function showOrdersByTravelAction($id_recorrido)
    {
        $this->initialize();
        $this->params['estados'] = $this->getEstados();
        $this->params['pedidos'] = $this->getOrdersByTravelsEmployee($id_recorrido);
        return $this->render('EmployeeBundle:Empleado:pedidos.html.twig', $this->params);
    }

    /**
     * Obtengo los estados de los pedidos
     *
     * @return mixed
     */
    private function getEstados(){
        return $this->em->getRepository("AppBundle:Estado")
            ->findAll([],[
                "estado" => "ASC"
            ]);
    }

    private function getOrdersByTravelsEmployee($idRecorrido, $trash = 0){
        return $this->em->getRepository("AppBundle:Recorrido")
            ->getOrdersByTravel($idRecorrido, $this->getIdTrabajador(), $trash);
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

    /**
     * Devuelve un trabjador
     *
     * @return mixed
     */
    private function getTrabajador(){
        return  $this->em->getRepository("AppBundle:Trabajador")
            ->findOneBy([
                'usuario' => $this->getUser()->getId()
            ]);
    }

    /**
     * Obtengo el restaurante del trabajador
     *
     * @param $idRestauranteTrabajador
     * @return mixed
     */
    private function getRestaurante($idRestauranteTrabajador){
        return $this->em->getRepository("AppBundle:Restaurante")
            ->findOneBy([
                "id" => $idRestauranteTrabajador
            ]);
    }

    private function initialize()
    {
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }
}
