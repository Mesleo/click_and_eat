<?php
// src/RegisterBundle/Controller/RestauranteController.php

namespace ManageCompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Restaurante;
use ManageCompanyBundle\Form\RestauranteType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;


class RestauranteController extends Controller
{

    private $em = null;
    private $params = null;

    /**
     * Genera el formulario de registro
     *
     * @Route("/registro", name="registro")
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function registerAction(Request $request)
    {
        $restaurante = new Restaurante();
        $form = $this->createForm(RestauranteType::class, $restaurante);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $restaurante->setCoordenadas('102,30');
            $restaurante->setMapa('mapa');
            $restaurante->addRole("ROLE_ADMIN");

            $password = $this->get('security.password_encoder')
                ->encodePassword($restaurante, $restaurante->getPassword());
            $restaurante->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($restaurante);
            $em->flush();
            return $this->redirectToRoute('homepage');
        }

        return $this->render('ManageCompanyBundle:Restaurante:registro.html.twig', array(
            'restaurante' => $restaurante,
            'form'    => $form->createView()
        ));

    }

    public function getProvincia(){
        $this->initialize();
        $toRet = $this->getProvincias();
        if (!$toRet) {
            throw $this->createNotFoundException('No se ha podido localizar la provincia');
        }
        return new JsonResponse($toRet);
    }


    private function getLocalidad($localidad_id)
    {
        $this->initialize();
        $localidad = $this->em->getRepository('AppBundle:Localidad')
            ->find($localidad_id);
        if (!$localidad) {
            throw $this->createNotFoundException('No se ha podido localizar la localidad.');
        }
        return $localidad;
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


    /**
     * Pagina de prueba
     *
     * @Route("/index", name="index")
     * @Security("has_role('ROLE_EDITOR')")
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function indexAction(){
        return $this->render("ManageCompanyBundle:Pages:form.html.twig");
    }

    private function initialize(){
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }

}