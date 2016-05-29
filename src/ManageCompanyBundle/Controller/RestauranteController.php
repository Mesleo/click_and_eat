<?php
// src/ManageCompanyBundle/Controller/RestauranteController.php
namespace ManageCompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Restaurante;
use ManageCompanyBundle\Form\RestauranteType;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class RestauranteController extends Controller
{
    private $em = null;

    public function registerAction(Request $request)
    {
        $restaurante = new Restaurante();
        $form = $this->createForm(RestauranteType::class, $restaurante);

        $form->handleRequest($request);

        $restaurante->setCoordenadas('102,30');
        $restaurante->setMapa('mapa');

        if ($form->isSubmitted() && $form->isValid()) {

        	$password = $this->get('security.password_encoder')
                ->encodePassword($restaurante, $restaurante->getPlainPassword());
            $restaurante->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $restaurante->uploadImg();
            $em->persist($restaurante);
            $em->flush();

            //$this->get('session')->getFlashBag()->add('info', '¡Enhorabuena! Te has registrado correctamente.');

            //return $this->redirect($this->generateUrl('ManageCompanyBundle_homepage'));
            return $this->redirectToRoute('homepage');
        }

        return $this->render('ManageCompanyBundle:Restaurante:registro.html.twig', array(
            'restaurante' => $restaurante,
            'form'    => $form->createView()
        ));
    }

    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'ManageCompanyBundle:Page:index.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        );
    }

    public function getProvincia($provincia_id){
        $this->initialize();
        $toRet = false;
        $toRet = $this->getProvincias();
        if (!$toRet) {
            throw $this->createNotFoundException('No se ha podido localizar la provincia');
        }
        return new JsonResponse($toRet);
    }

    /**
     * Devuelve todas las provincias
     *
     * @return JsonResponse
     */
    private function getProvincias()
    {
        foreach (($this->em->getRepository('AppBundle:Provincia')
            ->findBy(
                ['nombre' => "ASC"]
            )) as $provincia) {
            $this->params['inscripciones'][] = [
                'nombre' => $provincia->getNombre()
            ];
        }
        return $this->params;
    }
    
    private function initialize(){
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }

    /*protected function getLocalidad($localidad_id)
    {
        $em = $this->getDoctrine()
                    ->getManager();

        $localidad = $em->getRepository('AppBundle:Localidad')->find($localidad_id);

        if (!$localidad) {
            throw $this->createNotFoundException('Unable to find localidad.');
        }

        return $localidad;
    }*/

    /*public function loginAction(Request $request)
    {

    }*/
}