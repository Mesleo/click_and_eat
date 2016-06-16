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
        $this->getUsuario();
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
        $this->getUsuario();
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
        $this->getUsuario();

        //$this->get('session')->clear();
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
     * @param  Request $request    [description]
     * @param  [type] $id_restaurante [description]
     * @return [type]           [description]
     */
    public function addAction(Request $request, $id_restaurante)
    {
        $this->initialize();
        $this->getUsuario();

        $session = $request->getSession();

        $id_producto = $request->request->get('id_producto');

        $producto = $this->em->getRepository("AppBundle:Producto")
            ->getProducto($id_producto);
        
        if ($session->has('producto'.$id_producto)) {
            $producto = $session->get('producto'.$id_producto);
            $producto[1]['cantidad'] += 1;
        } else {
            array_push($producto, array('cantidad' => 1));
        }

        $session->set('producto'.$id_producto, $producto);

        $session->remove('subtotal');
        $subtotal = 0.00;
        foreach ($session->all() as $key => $value) {
            if ($key != '_csrf/pedido' && $key != '_csrf/authenticate' && $key != '_security_gestion') {
                $subtotal += $value[0]['precio'] * $value[1]['cantidad'];
            }
        }
        $session->set('subtotal', array(array('subtotal' => number_format($subtotal,2))));

        $this->params['id_restaurante'] = $id_restaurante;
        return $this->redirectToRoute('menu_restaurante', $this->params);
    }

    /**
     * @Route("/{id_restaurante}/{key}/delete", name="delete_menu")
     * 
     * @param  Request $request    [description]
     * @param  [type]  $id_restaurante [description]
     * @param  [type]  $key [description]
     * @return [type]              [description]
     */
    public function deleteAction(Request $request, $id_restaurante, $key)
    {
        $this->initialize();
        $this->getUsuario();

        $producto = $this->get('session')->get($key);

        if ($producto[1]['cantidad'] > 1) {
            $producto[1]['cantidad'] -= 1;
            $this->get('session')->set($key, $producto);
        } else {
            $this->get('session')->remove($key);
        }

        $this->get('session')->remove('subtotal');

        if (count($this->get('session')->all()) != 0) {
            $subtotal = 0.00;
            foreach ($this->get('session')->all() as $key => $value) {
                if ($key != '_csrf/pedido' && $key != '_csrf/authenticate' && $key != '_security_gestion') {
                    $subtotal += $value[0]['precio'] * $value[1]['cantidad'];
                }
            }
            $this->get('session')->set('subtotal', array(array('subtotal' => number_format($subtotal,2))));
        }

        $this->params['id_restaurante'] = $id_restaurante;
        return $this->redirectToRoute('menu_restaurante', $this->params);
    }

    private function getUsuario()
    {
        if (!is_null($this->getUser())) {
            $this->params['user'] = $this->em->getRepository("AppBundle:Usuario")
                ->findOneBy([
                    'id' => $this->getUser()->getId()
                ]);
            $this->params['cliente'] = $this->em->getRepository("AppBundle:Cliente")
                ->findOneBy([
                    'usuario' => $this->getUser()->getId()
                ]);
        }
    }

    private function initialize()
    {
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }
}
