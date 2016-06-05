<?php
// src/ManageCompanyBundle/Controller/ProductoController.php
namespace ManageCompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Producto;
use ManageCompanyBundle\Form\ProductoType;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ProductoController extends Controller
{
	private $em = null;
	private $params = null;

	/**
     * Muestra la lista de productos del restaurante
     *
     * @Route("/productos", name="gestion_productos")
     * @return [type]              [description]
     */
    public function showAction(Request $request){
        $this->initialize();
        $this->params['productos'] = $this->em->getRepository('AppBundle:Producto')
            ->findBy([
                "restaurante" => $this->getIdRestaurante()
                ], [
                "nombre" => "ASC"
            ]);

        return $this->render('ManageCompanyBundle:Restaurante:productos.html.twig', $this->params);
    }

    /**
     * @Route("/productos/insertar", name="add_producto")
     *
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function addAction(Request $request)
    {
        $this->initialize();

        $producto = new Producto();
        $form = $this->createForm(ProductoType::class, $producto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $restaurante = $this->em->getRepository('AppBundle:Restaurante')
                ->findOneBy([
                    "id" => $this->getIdRestaurante()
                ]);
            if($request->request->get("producto-id") != null) {
                $producto = $this->em->getRepository("AppBundle:Producto")
                    ->findOneBy([
                        "id" => $request->request->get('producto-id')
                    ]);
            }
            $producto->setFoto(' ');
            $this->addTiposProducto($request, $producto);
            $producto->setRestaurante($restaurante);
            $restaurante->addProducto($producto);
            $this->em->persist($producto);
            $this->em->flush();

            return $this->redirectToRoute('gestion_productos');
        }

        return $this->render('ManageCompanyBundle:Restaurante:producto.html.twig', array(
            'form'	=> $form->createView()
        ));

    }

    /**
     * @Route("/productos/edit", name="edit_producto")
     *
     * @param  Request $request    [description]
     * @param  [type]  $id_producto [description]
     * @return [type]              [description]
     * Method({POST})
     */
    public function updateAction(Request $request)
    {
        $this->initialize();
        $producto = $this->em->getRepository('AppBundle:Producto')
            ->findOneBy([
                "id" => $request->request->get('producto-id'),
            ]);

        if (!$producto) {
            throw $this->createNotFoundException(
                'No se encontró el producto con id '.$request->request->get('producto-id')
            );
        }
        if($this->checkIdRestauranteIdUserLog($producto)) {
            $form = $this->createForm(ProductoType::class, $producto);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->addTiposProducto($request, $producto);
                $this->em->flush();
                return $this->redirectToRoute('gestion_productos');
            }

            return $this->render('ManageCompanyBundle:Restaurante:producto.html.twig', array(
                'producto' => $producto,
                'form' => $form->createView()
            ));
        }
        return $this->redirectToRoute('gestion_productos');
    }

    /**
     * @Route("/productos/{id_producto}/delete", name="delete_producto")
     *
     * @param  Request $request    [description]
     * @param  [type]  $id_producto [description]
     * @return [type]              [description]
     */
    public function deleteAction(Request $request, $id_producto)
    {
        $this->initialize();

        $producto = $this->em->getRepository('AppBundle:Producto')
            ->findOneBy([
                "id" => $id_producto,
            ]);

        if (!$producto) {
            throw $this->createNotFoundException(
                'No se encontró el producto con id '.$id_producto
            );
        }
        if($this->checkIdRestauranteIdUserLog($producto)) {
            $this->em->remove($producto);
            $this->em->flush();
        }
        return $this->redirectToRoute('gestion_productos');
    }

    /**
     * @Route("/productos/{id_producto}/{value}", name="activar_producto")
     *
     * @param  [type]  $id_trabajador [description]
     * @return [type]              [description]
     */
    public function activarAction($id_producto, $value)
    {
        $this->initialize();
        $producto = $this->em->getRepository('AppBundle:Producto')
            ->findOneBy([
                'id' => $id_producto
            ]);
        if (!$producto) {
            throw $this->createNotFoundException(
                'No se encontró el producto con id ' .$id_producto
            );
        }
        if($this->checkIdRestauranteIdUserLog($producto)) {
            $producto->setDisponible($value);
            $this->em->persist($producto);
            $this->em->flush();
        }
        return $this->redirectToRoute('gestion_productos');
    }

    /**
     * Obtengo el id del restaurante logeado (Tabla Restaurante)
     *
     * @return mixed
     */
    private function getIdRestaurante(){
        $user = $this->em->getRepository("AppBundle:Usuario")
            ->findOneBy([
                "id" => $this->getUser()->getId()
            ]);
        return  $this->em->getRepository('AppBundle:Restaurante')
            ->findOneBy([
                'id' => $user->getIdRestaurante()->getId()
            ])->getId();
    }

    /**
     * Compruebo que id del usuario logeado sea el id del restaurante con el que estoy trabajando
     *
     * @param $producto
     * @return bool
     */
    private function checkIdRestauranteIdUserLog($producto){
        return $producto->getRestaurante()->getId() == $this->getIdRestaurante();
    }



    private function initialize(){
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }

    /**
     * @param Request $request
     * @param $producto
     */
    public function addTiposProducto(Request $request, $producto)
    {
        $tiposProductos = $producto->getTipoProducto();
        $repoTiposProductos = $this->em->getRepository('AppBundle:TipoProducto');
        $tiPro = $request->request->get('hidden-tipo-producto');
        $tiposProductoArray = explode(',', $tiPro);
        foreach ($tiposProductoArray as $tc) {
            $dbTiposProducto = $repoTiposProductos->findOneBy([
                'nombre' => $tc,
            ]);
            if (empty($dbTiposProducto)) {
                $dbTiposProducto = new \AppBundle\Entity\TipoProducto();
                $dbTiposProducto->setNombre($tc);
                $this->em->persist($dbTiposProducto);
            }
            if (!$tiposProductos->contains($dbTiposProducto)) {
                $producto->addTipoProducto($dbTiposProducto);
            }
        }
        foreach ($tiposProductos as $tipProducto) {
            if (!in_array($tipProducto->getNombre(), $tiposProductoArray)) {
                $producto->removeTipoProducto($tipProducto);
            }
        }
    }
}