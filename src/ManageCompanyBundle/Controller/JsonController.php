<?php
// src/ManageCompanyBundle/Controller/JsonController.php
namespace ManageCompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class JsonController extends Controller
{
    private $params = null;
    private $em = null;

    /**
     * Muestra las localidades a partir de una consulta pasada a JSON
     *
     * @Route("/json/localidades", name="localidades_json")
     * @Security("has_role('ROLE_EDITOR')")
     *
     * @return [type]              [description]
     */
    public function getLocalidades(){
        $this->initialize();
        $this->params['localidades'] = $this->em->getRepository('AppBundle:Localidad')
            ->findAll();
        return $this->render('ManageCompanyBundle:Json:localidades.json.twig', $this->params);
    }
    
    private function initialize(){
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }
}