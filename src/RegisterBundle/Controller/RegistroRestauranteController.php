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
use Symfony\Component\HttpFoundation\RedirectResponse;


class RegistroRestauranteController extends Controller
{

    private $em = null;
    private $params = null;

    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('RegisterBundle:Base:base.html.twig');
    }

    /**
     * @Route("/registro", name="registro_restaurante")
     */
    public function registerRestaurantAction(Request $request)
    {
        $this->initialize();
        $usuario = new \AppBundle\Entity\Usuario();
        $form = $this->createForm(RestauranteType::class, $usuario);
        $form->handleRequest($request);
        $this->params['provincias'] =$this->getProvincias();

        if ($form->isSubmitted() && $form->isValid()) {
            $restaurante = new Restaurante();
            $restaurante->setDireccion($request->request->get("direccion"));
            $restaurante->setCif($request->request->get("cif"));
            $usuario->setTelefono($request->request->get("telefono"));
            $restaurante->setCoordenadas($request->request->get("coordenadas"));
            $restaurante->setMapa($request->request->get('foto'));
            $restaurante->setPrecioEnvio($request->request->get('precioEnvio'));
            $usuario->addRole(1);

            $localidad = $this->em->getRepository("AppBundle:Localidad")
                ->findOneBy([
                    "id" => $request->request->get("localidad")
                ]);
            $provincia = $this->em->getRepository("AppBundle:Provincia")
                ->findOneBy([
                    "id" => $request->request->get("provincia")
                ]);

            $restaurante->setProvincia($provincia);
            $restaurante->setLocalidad($localidad);
            $this->em->persist($restaurante);

            $password = $this->get('security.password_encoder')
                ->encodePassword($usuario, $usuario->getPassword());
            $usuario->setPassword($password);
            $usuario->addRole(1);
            $usuario->setTypeUser(1);
            $usuario->setIdRestaurante($restaurante);

            $this->em->persist($usuario);
            $this->em->flush();
            return $this->redirectToRoute('homepage');
        }

        return $this->render('RegisterBundle:Web:registro.html.twig', array(
            'restaurante' => $usuario,
            'provincias' => $this->params['provincias'],
            'form'    => $form->createView()
        ));

    }

    /**
     * Muestra las localidades a partir de una consulta pasada a JSON
     *
     * @Route("/localidad", name="localidades_json")
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

    private function getProvincias(){
        $this->initialize();
        return $this->em->getRepository("AppBundle:Provincia")
            ->findAll([],[
                "nombre" => "ASC"
            ]);
    }

    private function initialize(){
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }
}
