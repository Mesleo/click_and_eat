<?php
namespace ManageCompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class TiposComidaController extends Controller
{

    /**
     * @Route("/json/tipos_comida", name="tipos_comida_json")
     * Muestra las tipos_comida a partir de una consulta pasada a JSON
     * @Security("has_role('ROLE_ADMIN')")
     * @return [type]              [description]
     */
    public function getTiposComida(){
        $this->initialize();
        $params['tipos_comida'] = $this->em->getRepository('AppBundle:TipoComida')
            ->findAll();
        return $this->render('ManageCompanyBundle:Json:tipos_comida.json.twig', $params);
    }


    private function initialize(){
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }

}