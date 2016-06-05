<?php
/**
 * Created by PhpStorm.
 * User: anonimo1
 * Date: 01/06/2016
 * Time: 19:04
 */

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
     * Obtengo el id del usuario logeado (Tabla Usuarios)
     *
     * @return mixed
     */
    private function getIdUser()
    {
        $user = $this->em->getRepository("AppBundle:Usuario")
            ->findOneBy([
                "id" => $this->getUser()->getId()
            ]);
        return $this->getIdRestaurante($user->getId());
    }

    /**
     * Obtengo el id del restaurante logeado (Tabla Restaurante)
     *
     * @return mixed
     */
    private function getIdRestaurante(){
        $user = $this->em->getRepository("AppBundle:Usuario")
            ->findOneBy([
                "id" => $this->getUser()->getId()
            ]);
        return  $this->em->getRepository('AppBundle:Restaurante')
            ->findOneBy([
                'id' => $user->getIdRestaurante()->getId()
            ])->getId();
    }

    /**
     * Compruebo que id del usuario logeado sea el id del restaurante con el que estoy trabajando
     *
     * @param $trabajador
     * @return bool
     */
    private function checkIdRestauranteIdUserLog($trabajador){
        return $trabajador->getRestaurante()->getId() == $this->getIdRestaurante();
    }

    private function initialize()
    {
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }

}