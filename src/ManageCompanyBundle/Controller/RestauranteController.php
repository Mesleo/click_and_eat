<?php
// src/ManageCompanyBundle/Controller/RestauranteController.php

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
    
    /**
     * Genera el formulario de registro
     *
     * @Route("/registro", name="registro")
     * @Security("has_role('ROLE_EDITOR')")
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function registerAction(Request $request)
    {
        $restaurante = new Restaurante();
        $form = $this->createForm(RestauranteType::class, $restaurante);
        $form->handleRequest($request);
        $restaurante->setCoordenadas('102,30');
        $restaurante->setMapa('mapa');
        $localidad = $this->getLocalidad(1025);
        $restaurante->setLocalidad($localidad);
        if ($form->isValid()) {
            $this->initialize();
            $em->persist($restaurante);
            $em->flush();
            return $this->redirectToRoute('homepage');
        }
        return $this->render('ManageCompanyBundle:Restaurante:registro.html.twig', array(
            'restaurante' => $restaurante,
            'form'    => $form->createView()
        ));
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

    
    private function initialize(){
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }

}