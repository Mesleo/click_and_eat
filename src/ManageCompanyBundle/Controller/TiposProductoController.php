<?php
namespace ManageCompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class TiposProductoController extends Controller
{

    /**
     * @Route("/json/tipos_producto", name="tipos_producto_json")
     * Muestra las tipos_producto a partir de una consulta pasada a JSON
     * @Security("has_role('ROLE_ADMIN')")
     * @return [type]              [description]
     */
    public function getTiposproducto(){
        $this->initialize();
        $params['tipos_producto'] = $this->em->getRepository('AppBundle:TipoProducto')
            ->findAll();
        return $this->render('ManageCompanyBundle:Json:tipos_producto.json.twig', $params);
    }


    private function initialize(){
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }

}