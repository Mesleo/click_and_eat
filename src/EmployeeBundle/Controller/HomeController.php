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
class HomeController extends Controller
{

    private $em = null;
    private $params = null;

    /**
     * @Route("/pedidos", name="empleado_gestion_pedidos")
     * @Security("has_role('ROLE_EMPLOYEE')")
     */
    public function indexAction()
    {
        $this->initialize();
        $fecha = date ('Y-m-d');
        $this->params['pedidos'] = $this->em->getRepository("AppBundle:Trabajador")
            ->getGeneralInfoOrdersTodayByEmployee($this->getIdTrabajador(), $fecha.' 00:00:01', $fecha.' 23:59:59');
        $this->params['estados'] = $this->getEstados();
        return $this->render('EmployeeBundle:Empleado:pedidos.html.twig', $this->params);
    }

    /**
     * @Route("/pedidos/entregar", name="empleado_gestion_pedidos_entregar")
     * @Security("has_role('ROLE_MANAGE')")
     */
    public function ordersForDeliver()
    {
        $this->initialize();
        $this->params['pedidos'] = $this->em->getRepository("AppBundle:Pedido")
            ->findBy([
                "trabajador" => $this->getIdTrabajador()
            ],[
                "estado_id" => 1
            ]);
        return $this->redirectToRoute("gestion_pedidos");
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
     * Muestra los pedidos entre fechas
     *
     * @Route("/pedidos/entre", name="empleado_pedidos_entre_fechas")
     */
    public function showOrdersBetweenDates(Request $request){
        $this->initialize();
        $this->params['estados'] = $this->getEstados();
        if($request->request->has("desde")  && $request->request->has('hasta')){
            $fechaDesde = \DateTime::createFromFormat("Y-m-d", '2000-01-01');
            $fechaHasta = \DateTime::createFromFormat("Y-m-d", '2100-12-31');
            if($request->request->get('desde') == $request->request->get('hasta') and $request->request->get('desde')!= null){
                return $this->redirectToRoute("empleado_gestion_pedidos");
            }else {
                if ($request->request->get('desde') != null) {
                    $fechaDesde = \DateTime::createFromFormat("d-m-Y H:i:s", $request->request->get('desde') . ' 00:00:00');
                }
                if ($request->request->get('hasta') != null) {
                    $fechaHasta = \DateTime::createFromFormat("d-m-Y H:i:s", $request->request->get('hasta') . ' 23:59:59');
                }
                $this->params['pedidos'] = $this->em->getRepository('AppBundle:Trabajador')
                    ->getGeneralInfoOrdersBetweenByEmployee($this->getIdTrabajador(), $fechaDesde, $fechaHasta);
            }
            return $this->render('EmployeeBundle:Empleado:pedidos.html.twig', $this->params);
        }
        return $this->redirectToRoute('empleado_gestion_pedidos');
    }

    /**
     * Compruebo que id del usuario logeado sea el trabajador con el que estoy trabajando
     *
     * @param $trabajador
     * @return bool
     */
    private function checkTrabajador($trabajador)
    {
        return $trabajador == $this->getIdTrabajador();
    }


    private function getEstados(){
        return $this->em->getRepository("AppBundle:Estado")
            ->findAll([],[
                "estado" => "ASC"
            ]);
    }

    private function initialize()
    {
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }
}
