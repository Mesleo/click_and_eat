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
            $producto->setFoto(' ');
            $disponible = $request->request->has("producto_disponible");
            $producto->setRestaurante($restaurante);
            if(!$request->request->has('producto-tipo')){
                $tipo = "Entrante";
            }else $tipo = $request->request->get("producto_tipo");
            $producto->setTipo($tipo);
            $restaurante->addProducto($producto);
            $producto->setDisponible($disponible);
            $this->em->persist($producto);
            $this->em->flush();

            return $this->redirectToRoute('gestion_productos');
        }

        return $this->render('ManageCompanyBundle:Restaurante:productos_restaurante.html.twig', array(
            'form'	=> $form->createView()
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
                "id" => $id_producto,
            ]);

        if (!$producto) {
            throw $this->createNotFoundException(
                'No se encontró el producto con id '.$id_producto
            );
        }

        $form = $this->createForm(ProductoType::class, $producto);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $this->em->flush();
            return $this->redirectToRoute('gestion_productos');
        }

        return $this->render('ManageCompanyBundle:Restaurante:productos_restaurante.html.twig', array(
            'producto'	=> $producto,
            'form'  => $form->createView()
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
                "id" => $id_producto,
            ]);

        if (!$producto) {
            throw $this->createNotFoundException(
                'No se encontró el producto con id '.$id_producto
            );
        }

        $this->em->remove($producto);
        $this->em->flush();
        return $this->redirectToRoute('gestion_productos');
    }

    /**
     * @Route("/listar/imagenes", name="listar_imagenes")
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function findImages(Request $request){
        $baseUrl = $request->getSchemeAndHttpHost();
        $directory = new \RecursiveDirectoryIterator($this->container->getParameter('kernel.root_dir') .'/../web/uploads/');
        $iterator = new \RecursiveIteratorIterator($directory);
        $regex = new \RegexIterator($iterator, '/.[(png)|(jpg)|(gif)]+$/i', \RecursiveRegexIterator::GET_MATCH);

        $toRet = [
            'f' => '',
        ];

        foreach ($regex as $url => $value) {
            $toRet['f'][] = $baseUrl . substr($url, strpos($url, '/web') + 4);
        }

        return new JsonResponse($toRet);
    }

    /**
     * @Route("/subir/imagen", name="subir_imagen")
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function uploadImage(Request $request){
        $toRet = [
            'Ok' => false
        ];
        $allowed = array('png', 'jpg', 'gif');

        if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){

            $extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);

            if(in_array(strtolower($extension), $allowed)){
                $date = new \DateTime();
                $destinationFolder = $this->container->getParameter('kernel.root_dir') .'/../web/uploads/' . $date->format('Y')  . '/' . $date->format('m');
                if (!file_exists($destinationFolder)){
                    mkdir($destinationFolder, 0774, true);
                }

                if(move_uploaded_file($_FILES['upl']['tmp_name'], $destinationFolder . "/" . $_FILES['upl']['name'])){
                    $toRet['Ok'] = true;
                    $toRet['route'] = $request->getSchemeAndHttpHost() . '/uploads/' . $date->format('Y')  . '/' . $date->format('m') . '/' . $_FILES['upl']['name'];
                }
            }
        }

        return new JsonResponse($toRet);
    }

    private function getIdRestaurante(){
        $user = $this->getUser()->getId();
        return $user;
    }

    private function initialize(){
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }
}