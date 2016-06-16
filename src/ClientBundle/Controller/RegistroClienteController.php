<?php

namespace ClientBundle\Controller;

use AppBundle\Entity\Cliente;
use AppBundle\Entity\Domicilio;
use AppBundle\Entity\Localidad;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Restaurante;
use RegisterBundle\Form\RestauranteType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;


class RegistroClienteController extends Controller
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
     * @Route("/cliente", name="registro_cliente")
     */
    public function registerClientAction(Request $request)
    {
        $this->initialize();
        $usuario = new \AppBundle\Entity\Usuario();
        $form = $this->createForm(RestauranteType::class, $usuario);
        $form->handleRequest($request);
        $this->params['provincias'] =$this->getProvincias();

        if ($form->isSubmitted() && $form->isValid()) {
            $localidad = $this->em->getRepository("AppBundle:Localidad")
                ->findOneBy([
                    "id" => $request->request->get("localidad")
                ]);
            $domicilio = new Domicilio();
            $domicilio->setDomicilio($request->request->get("direccion"));
            $domicilio->setDireccionExtra($request->request->get("direccion-extra"));
            $domicilio->setLocalidad($localidad);
            $domicilio->setCodigoPostal($localidad->getCodigoPostal());
            $cliente = new Cliente();
            $cliente->addDomicilio($domicilio);
            $cliente->setNombre($request->request->get("nombre"));
            $cliente->setApellidos($request->request->get("apellidos"));
            $cliente->setTelefono($request->request->get("telefono"));
            $domicilio->setCliente($cliente);
            $password = $this->get('security.password_encoder')
                ->encodePassword($usuario, $usuario->getPassword());
            $usuario->setPassword($password);
            $usuario->addRole(3);
            $usuario->setTypeUser(3);
            $cliente->setUsuario($usuario);

            $this->em->persist($cliente);
            $this->em->persist($usuario);
            $this->em->flush();
            return $this->redirectToRoute('homepage');
        }

        return $this->render('ClientBundle:Cliente:registro_cliente.html.twig', array(
            'restaurante' => $usuario,
            'provincias' => $this->params['provincias'],
            'form'    => $form->createView()
        ));

    }

    /**
     * Muestra las localidades a partir de una consulta pasada a JSON
     *
     * @Route("/localidad", name="show_localidades")
     */
    public function getLocalidades(Request $request){
        $this->initialize();
        $this->params['localidades'] = $this->em->getRepository('AppBundle:Localidad')
            ->findBy(
                array('provincia' => $request->query->get('provincia')),
                array('nombre' => 'ASC')
            );
        return $this->render('ClientBundle:FilesJson:localidades_cliente.json.twig', $this->params);
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
