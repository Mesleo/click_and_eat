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
     * @Route("/", name="gestion")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction()
    {
        return $this->render('ManageCompanyBundle:Page:base.html.twig');
    }

	/**
     * Muestra la lista de productos
     *
     * @Route("/productos", name="gestion_productos")
     */
    public function showAction()
	{
        $this->initialize();

        $this->params['productos'] = $this->em->getRepository('AppBundle:Producto')
            ->findBy(
				['restaurante' => $this->getIdRestaurante()], 
				['nombre' => 'ASC']
			);
		
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
					'id' => $this->getIdRestaurante()
				]);
			$producto->setFoto('');
			if (!$request->request->has('producto-tipo')) {
				$tipo = "Entrante";
			} else {
				$tipo = $request->request->get("producto_tipo");
			}
			$producto->setTipo($tipo);
			//$producto->setDisponible($request->request->has("producto_disponible"));
			$producto->setRestaurante($restaurante);
			$restaurante->addProducto($producto);

        	$this->em->persist($producto);
            $this->em->flush();
			
			$producto->uploadImg();
			$this->em->flush();

			return $this->redirectToRoute('gestion_productos');
        }
		
		return $this->render('ManageCompanyBundle:Restaurante:productos_restaurante.html.twig', array(
            'form' => $form->createView()
        ));
	}
	
	/**
     * @Route("/productos/{id_producto}/edit", name="edit_producto")
     * 
     * @param  Request $request    [description]
     * @param  [type]  $id_producto [description]
     * @return [type]              [description]
     */
	public function updateAction(Request $request, $id_producto)
	{
		$this->initialize();
		
		$producto = $this->em->getRepository('AppBundle:Producto')
			->findOneBy([
                'id' => $id_producto
            ]);
		
		if (!$producto) {
			throw $this->createNotFoundException(
				'No se encontró el producto con id '.$id_producto
			);
		}
		
		$form = $this->createForm(ProductoType::class, $producto);
		
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			$producto->uploadImg();
			$this->em->flush();
			return $this->redirectToRoute('gestion_productos');
		}
		
		return $this->render('ManageCompanyBundle:Restaurante:productos_restaurante.html.twig', array(
			'producto' => $producto,
            'form' => $form->createView()
        ));
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
                'id' => $id_producto
            ]);
		
		if (!$producto) {
			throw $this->createNotFoundException(
				'No se encontró el producto con id '.$id_producto
			);
		}
		
		$restaurante = $this->em->getRepository('AppBundle:Restaurante')
			->findOneBy([
				'id' => $this->getIdRestaurante()
			]);
		$restaurante->removeProducto($producto);
		
		$this->em->remove($producto);
		$this->em->flush();
		return $this->redirectToRoute('gestion_productos');
	}
	
	/**
     * @Route("/productos/{id_producto}", name="status_producto")
     * 
     * @param  Request $request    [description]
     * @param  [type]  $id_producto [description]
     * @return [type]              [description]
     */
	public function statusAction(Request $request, $id_producto)
	{
		$this->initialize();
		
		$producto = $this->em->getRepository('AppBundle:Producto')
			->findOneBy([
                'id' => $id_producto
            ]);
		
		if (!$producto) {
			throw $this->createNotFoundException(
				'No se encontró el producto con id '.$id_producto
			);
		}
		
		if ($producto->getDisponible()) {
			$producto->setDisponible(false);
		} else {
			$producto->setDisponible(true);
		}
		
		$this->em->flush();
		return $this->redirectToRoute('gestion_productos');
	}
	
	private function getIdRestaurante()
	{
		$user = $this->getUser()->getId();
		return $user;
    }

	private function initialize()
	{
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }
}