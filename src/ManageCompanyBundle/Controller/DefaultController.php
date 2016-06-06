<?php
// src/ManageCompanyBundle/Controller/DefaultController.php
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
                'id' => $this->getUser()->getId()
            ]);
        return $this->render('ManageCompanyBundle:Page:base.html.twig', $this->params);
    }
	
	/**
     * Obtengo el id del usuario logeado (Tabla Usuarios)
     *
     * @return mixed
     */
    private function getIdUser()
    {
        $user = $this->em->getRepository("AppBundle:Usuario")
            ->findOneBy([
                'id' => $this->getUser()->getId()
            ]);
        return $this->getIdRestaurante($user->getId());
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
                'id' => $user->getRestaurante()->getId()
            ])->getId();
    }
	
	/**
     * Compruebo que id del usuario logeado sea el id del restaurante con el que estoy trabajando
     *
     * @param $restaurante
     * @return bool
     */
    private function checkRestaurante($restaurante)
	{
        return $restaurante->getRestaurante()->getId() == $this->getIdRestaurante();
    }
	
	private function initialize()
	{
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }
}
