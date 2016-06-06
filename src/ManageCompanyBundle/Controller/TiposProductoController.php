<?php
// src/ManageCompanyBundle/Controller/TiposProductoController.php
namespace ManageCompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class TiposProductoController extends Controller
{
	private $em = null;
	private $params = null;
	
    /**
	 * Muestra los tipos_producto a partir de una consulta pasada a JSON
	 *
     * @Route("/json/tipos_producto", name="tipos_producto_json") 
     * @Security("has_role('ROLE_ADMIN')")
     * @return [type]              [description]
     */
    public function getTiposproducto()
	{
        $this->initialize();
        $params['tipos_producto'] = $this->em->getRepository("AppBundle:TipoProducto")
            ->findAll();
        return $this->render('ManageCompanyBundle:Json:tipos_producto.json.twig', $params);
    }

    private function initialize()
	{
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }
}