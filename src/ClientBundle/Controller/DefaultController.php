<?php

namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        if(!is_null($this->getUser())){
            $this->params['user'] = $this->em->getRepository("AppBundle:Usuario")
                ->findOneBy([
                    "id" => $this->getUser()->getId()
                ]);
        }
        return $this->render('ClientBundle:Cliente:cliente.html.twig', $this->params);
    }

    /**
     * @Route("/loginClientes", name="client_login")
     */
    public function loginAction(){
        return $this->render('FOSUserBundle:Security:login_cliente.html.twig');
    }

    private function initialize()
    {
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }
}
