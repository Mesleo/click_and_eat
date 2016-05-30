<?php

namespace RegisterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Restaurante;
use RegisterBundle\Form\RestauranteType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('RegisterBundle:Base:base.html.twig');
    }

    private $em = null;
    private $params = null;

    /**
     * @Route("/registro", name="registro_restaurante")
     */
    public function registerAction(Request $request)
    {
        $this->initialize();
        $restaurante = new Restaurante();
        $form = $this->createForm(RestauranteType::class, $restaurante);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $restaurante->setMapa('mapa');
            $restaurante->addRole(1);
            $localidad = $this->em->getRepository("AppBundle:Localidad")
                ->findOneBy([
                    "id" => $request->request->get("localidad")
                ]);
            $restaurante->setLocalidad($localidad);
            $password = $this->get('security.password_encoder')
                ->encodePassword($restaurante, $restaurante->getPassword());
            $restaurante->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($restaurante);
            $em->flush();
            return $this->redirectToRoute('homepage');
        }

        return $this->render('RegisterBundle:Web:registro.html.twig', array(
            'restaurante' => $restaurante,
            'form'    => $form->createView(),
        ));

    }


    /**
     * Muestra las localidades a partir de una consulta pasada a JSON
     *
     * @Route("/listar/localidades", name="localidades_json")
     * @return [type]              [description]
     */
    public function getLocalidad(){
        $this->initialize();
        $this->params['localidades'] = $this->em->getRepository('AppBundle:Localidad')
            ->findAll();
        return $this->render('RegisterBundle:Json:localidades.json.twig', $this->params);
    }

    /**
     * Muestra las localidades a partir de una consulta pasada a JSON
     *
     * @Route("/localidades", name="localidades_json")
     * @return [type]              [description]
     */
    public function getLocalidades(Request $request){
        $this->initialize();
        $this->params['localidades'] = $this->em->getRepository('AppBundle:Localidad')
            ->findBy(
                array('provincia' => $request->query->get('provincia')),
                array('nombre' => 'ASC')
            );
        return $this->render('RegisterBundle:Json:localidades.json.twig', $this->params);
    }

    /**
     * Muestra las localidades a partir de una consulta pasada a JSON
     *
     * @Route("/json/localidad", name="listar_localidades")
     * @return [type]              [description]
     */
    public function getLocalidadesProvincia(Request $request){
        $this->initialize();
        $provincia = $request->request->get("idProvincia");
        $this->params['localidades'] = $this->em->getRepository('AppBundle:Localidad')
            ->findAll([],[
                'idProvincia' => $provincia,
                "nombre" => "DESC"
            ]);
        return $this->render('RegisterBundle:Json:localidades.json.twig', $this->params);
    }

    private function initialize(){
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }
}
