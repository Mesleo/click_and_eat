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
    private $params = null;
    private $em = null;

    /**
     * @Route("/json/tiposComida", name="tipos_comida_json")
     * Muestra las tipos_comida a partir de una consulta pasada a JSON
     * @Security("has_role('ROLE_MANAGE')")
     * @return [type]              [description]
     */
    public function getTiposComida(){
        $this->initialize();
        $this->params['tipos_comida'] = $this->em->getRepository('AppBundle:TipoComida')
            ->findAll([],[
                "nombre" => "DESC"
            ]);
        return $this->render('ManageCompanyBundle:Json:tipos_comida.json.twig', $this->params);
    }


    private function initialize(){
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }

}