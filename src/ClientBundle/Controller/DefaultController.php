<?php
// src/ClientBundle/Controller/DefaultController.php
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
        return $this->render('ClientBundle:Page:index.html.twig', $this->params);
    }

    /**
     * @Route("/restaurantes", name="show_restaurantes")
     */
    public function showAction()
    {
        $this->initialize();
        $this->params['restaurantes'] = $this->em->getRepository("AppBundle:Restaurante")
                ->showRestaurantes();

        return $this->render('ClientBundle:Restaurante:show.html.twig', $this->params);

    }

    private function initialize()
    {
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }
}
