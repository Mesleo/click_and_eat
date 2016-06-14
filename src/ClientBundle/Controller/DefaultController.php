<?php
// src/ClientBundle/Controller/DefaultController.php
namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Producto;
use AppBundle\Entity\TipoProducto;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DefaultController extends Controller
{

    private $params = null;
    private $em = null;

    /**
     * @Route("/", name="home_client")
     */
    public function indexAction()
    {
        $this->initialize();
        if(!is_null($this->getUser())){
            $this->params['user'] = $this->em->getRepository("AppBundle:Usuario")
                ->findOneBy([
                    'id' => $this->getUser()->getId()
                ]);
            $this->params['cliente'] = $this->em->getRepository("AppBundle:Cliente")
                ->findOneBy([
                    'usuario' => $this->getUser()->getId()
                ]);
        }
        return $this->render('ClientBundle:Page:index.html.twig', $this->params);
    }

    /**
     * @Route("/restaurantes", name="show_restaurantes")
     *
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function showAction(Request $request)
    {
        $this->initialize();
        $this->params['restaurantes'] = $this->em->getRepository("AppBundle:Restaurante")
                ->showRestaurantes($request->request->get('direccion'));

        return $this->render('ClientBundle:Restaurante:show.html.twig', $this->params);
    }

    /**
     * @Route("/{id_restaurante}/menu", name="menu_restaurante")
     *
     * @param  [type] $id_restaurante [description]
     * @return [type]           [description]
     */
    public function menuAction($id_restaurante)
    {
        $this->initialize();

        //print_r($this->get('session')->all());
        //exit();

        $restaurante = $this->em->getRepository("AppBundle:Restaurante")
            ->findOneBy([
                'id' => $id_restaurante
            ]);

        if (!$restaurante) {
            throw $this->createNotFoundException(
                'No se encontró el restaurante con id '.$id_restaurante
            );
        }

        $productos = $this->em->getRepository("AppBundle:Restaurante")
            ->showProductos($id_restaurante);
        $tiposProductos = array();
        foreach ($productos as $value) {
            if (!in_array($value['tipoProducto'], $tiposProductos)) {
                array_push($tiposProductos, $value['tipoProducto']);
            }
        }

        $this->params['productos'] = $productos;
        $this->params['tiposProductos'] = $tiposProductos;
        $this->params['restaurante'] = $restaurante;

        return $this->render('ClientBundle:Restaurante:menu.html.twig', $this->params);
    }

    /**
     * @Route("/{id_restaurante}/menu/add/", name="add_menu")
     *
     * @param  [type] $id_restaurante [description]
     * @return [type]           [description]
     */
    public function addAction(Request $request, $id_restaurante)
    {
        $this->initialize();
        $session = $request->getSession();
        $producto = $this->em->getRepository("AppBundle:Producto")
            ->getProducto($request->request->get('id_producto'));
        $session->set('producto'.count($session->all()), $producto);
        $this->params['id_restaurante'] = $id_restaurante;
        return $this->redirectToRoute('menu_restaurante', $this->params);
    }

    private function initialize()
    {
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }
}
