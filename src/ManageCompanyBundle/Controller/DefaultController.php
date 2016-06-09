<?php

namespace ManageCompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DefaultController extends Controller
{

    private $params = null;
    private $em = null;

    /**
     * @Route("/", name="gestion")
     * @Security("has_role('ROLE_MANAGE')")
     */
    public function indexAction()
    {
        $this->initialize();
        $this->params['userLog'] = $this->em->getRepository("AppBundle:Usuario")
            ->findOneBy([
                "id" => $this->getUser()->getId()
            ]);
        return $this->render('ManageCompanyBundle:Page:base.html.twig', $this->params);
    }

    /**
     * @Route("/registroClientes", name="controlador_registro_restaurante")
     */
    public function registerClienteAction()
    {

        return $this->redirectToRoute('registro_restaurante');
    }

    private function initialize()
    {
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }

}