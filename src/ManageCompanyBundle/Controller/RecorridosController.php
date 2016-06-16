<?php

namespace ManageCompanyBundle\Controller;

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
     * Muestra todos los recorridos
     *
     * @Route("/recorridos", name="gestion_recorridos_restaurante")
     * @Security("has_role('ROLE_MANAGE')")
     */
    public function indexTravelsAction(Request $request, $estado = 0)
    {
        $this->initialize();
        if($request->query->has("estado") and $request->query->get("estado")!= null) {
            $estado = $request->query->get("estado");
        }
         $recorridos = $this->em->getRepository("AppBundle:Recorrido")
            ->getOrdersAndTravels($this->getIdRestaurante(), $estado);
        $arrayCountOrderTravel = [];
        $restaurante = $this->getRestaurante($this->getIdRestaurante());
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
        $this->params['total_pedidos'] = $arrayCountOrderTravel;
        $this->params['total_recorrido'] = $arrayOrderTravel;
        $this->params['estados'] = $this->getEstados();
        $this->params['recorridos'] = $recorridos;
        return $this->render('ManageCompanyBundle:Restaurante:recorridos.html.twig', $this->params);
    }


    /**
     * Añade un recorrido
     *
     * @Route("/recorridos/insertar", name="add_recorrido")
     */
    public function saveTravelAction(Request $request)
    {
        if($request->request->has("num-recorrido") and strlen(trim($request->request->get("num-recorrido")))>0){
            $this->initialize();
            $recorrido = new Recorrido();
            $recorrido->setNumRecorrido($request->request->get("num-recorrido"));
            $recorrido->setRestaurante($this->getRestaurante($this->getIdRestaurante()));
            $this->em->persist($recorrido);
            $this->em->flush();
        }
        return $this->redirectToRoute("gestion_recorridos_restaurante");
    }


    /**
     * Muestra la vista de los pedidos de un recorrido
     *
     * @Route("/recorridos/recorrido/{id_recorrido}", name="gestion_pedidos_recorrido_restaurante")
     */
    public function showOrdersByTravelAction($id_recorrido)
    {
        $this->initialize();
        $this->params['estados'] = $this->getEstados();
        $this->params['pedidos'] = $this->getOrdersByTravels($id_recorrido);
        return $this->render('ManageCompanyBundle:Restaurante:pedidos.html.twig', $this->params);
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

    private function getOrdersByTravels($idRecorrido){
        return $this->em->getRepository("AppBundle:Recorrido")
            ->getOrdersByTravelRestaurant($this->getIdRestaurante(), $idRecorrido);
    }

    /**
     * Obtengo el id del trabajador logeado
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
     * Devuelve un trabajador
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
