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
     * Muestra la lista de productos
     *
     * @Route("/productos", name="gestion_productos")
     */
    public function showAction()
	{
        $this->initialize();

        $this->params['productos'] = $this->em->getRepository("AppBundle:Producto")
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
			
			$restaurante = $this->em->getRepository("AppBundle:Restaurante")
				->findOneBy([
					'id' => $this->getIdRestaurante()
				]);
			$producto->setFoto('');
			$this->addTiposProducto($request, $producto);
			$producto->setRestaurante($restaurante);
			$restaurante->addProducto($producto);

        	$this->em->persist($producto);
            $this->em->flush();
			
			$producto->uploadImg();
			$this->em->flush();

			return $this->redirectToRoute('gestion_productos');
        }
		
		return $this->render('ManageCompanyBundle:Restaurante:producto.html.twig', array(
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
		
		$producto = $this->em->getRepository("AppBundle:Producto")
			->findOneBy([
                'id' => $id_producto
            ]);
		
		if (!$producto) {
			throw $this->createNotFoundException(
				'No se encontró el producto con id '.$id_producto
			);
		}
		
		if ($this->checkRestaurante($producto)) {

			$form = $this->createForm(ProductoType::class, $producto);
			$form->handleRequest($request);
			
			if ($form->isSubmitted() && $form->isValid()) {
				$producto->uploadImg();
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
		
		$producto = $this->em->getRepository("AppBundle:Producto")
			->findOneBy([
                'id' => $id_producto
            ]);
		
		if (!$producto) {
			throw $this->createNotFoundException(
				'No se encontró el producto con id '.$id_producto
			);
		}
		
		if ($this->checkRestaurante($producto)) {
			$restaurante = $this->em->getRepository("AppBundle:Restaurante")
				->findOneBy([
					'id' => $this->getIdRestaurante()
				]);
			$restaurante->removeProducto($producto);
			
			$this->em->remove($producto);
			$this->em->flush();
		}
		return $this->redirectToRoute('gestion_productos');
	}
	
	/**
     * @Route("/productos/{id_producto}/{value}", name="activar_producto")
     * 
     * @param  Request $request    [description]
     * @param  [type]  $id_producto [description]
	 * @param  [type]  $value [description]
     * @return [type]              [description]
     */
	public function activarAction(Request $request, $id_producto, $value)
	{
		$this->initialize();
		
		$producto = $this->em->getRepository("AppBundle:Producto")
			->findOneBy([
                'id' => $id_producto
            ]);
		
		if (!$producto) {
			throw $this->createNotFoundException(
				'No se encontró el producto con id '.$id_producto
			);
		}
		
		if ($this->checkRestaurante($producto)) {
			$producto->setDisponible($value);
			$this->em->flush();
		}
		return $this->redirectToRoute('gestion_productos');
	}
	
	/**
     * Obtengo el id del restaurante logeado (Tabla Restaurante)
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
     * Compruebo que id del usuario logeado sea el id del restaurante con el que estoy trabajando
     *
     * @param $producto
     * @return bool
     */
    private function checkRestaurante($producto)
	{
        return $producto->getRestaurante()->getId() == $this->getIdRestaurante();
    }

	private function initialize()
	{
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }
	
	/**
     * @param  Request $request    [description]
     * @param  [type]  $producto [description]
     */
    public function addTiposProducto(Request $request, $producto)
    {
        $tiposProductos = $producto->getTipoProducto();
        $repoTiposProductos = $this->em->getRepository("AppBundle:TipoProducto");
        $tipoProducto = $request->request->get('hidden-tipo-producto');
        $tiposProductoArray = explode(',', $tipoProducto);
        foreach ($tiposProductoArray as $tp) {
            $dbTiposProducto = $repoTiposProductos->findOneBy([
                'nombre' => $tp,
            ]);
            if (empty($dbTiposProducto)) {
                $dbTiposProducto = new \AppBundle\Entity\TipoProducto();
                $dbTiposProducto->setNombre($tp);
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