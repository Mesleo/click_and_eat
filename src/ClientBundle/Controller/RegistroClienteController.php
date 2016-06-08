<?php
// src/ClientBundle/Controller/RegistroClienteController.php
namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Cliente;
use AppBundle\Entity\Domicilio;
use AppBundle\Entity\Localidad;
use RegisterBundle\Form\UsuarioType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class RegistroClienteController extends Controller
{
    private $em = null;
    private $params = null;

    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('Client:Page:base.html.twig');
    }

    /**
     * @Route("/registro", name="registro_cliente")
     *
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function registerClientAction(Request $request)
    {
        $this->initialize();

        $usuario = new \AppBundle\Entity\Usuario();
        $form = $this->createForm(UsuarioType::class, $usuario);

        $form->handleRequest($request);

        $this->params['provincias'] = $this->getProvincias();

        if ($form->isSubmitted() && $form->isValid()) {

            $localidad = $this->em->getRepository("AppBundle:Localidad")
                ->findOneBy([
                    'id' => $request->request->get('localidad')
                ]);

            $domicilio = new Domicilio();
            $domicilio->setDomicilio($request->request->get('direccion'));
            $domicilio->setLocalidad($localidad);
            $domicilio->setCodigoPostal($localidad->getCodigoPostal());

            $cliente = new Cliente();
            $cliente->setApellidos($request->request->get('apellidos'));
            $cliente->addDomicilio($domicilio);
            $domicilio->setCliente($cliente);

            $this->em->persist($domicilio);
            $this->em->persist($cliente);

            $password = $this->get('security.password_encoder')
                ->encodePassword($usuario, $usuario->getPassword());
            $usuario->setPassword($password);
            $usuario->addRole(3);
            $usuario->setTypeUser(3);
            $usuario->setCliente($cliente);

            $this->em->persist($usuario);
            $this->em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('ClientBundle:Cliente:registro_cliente.html.twig', array(
            'usuario' => $usuario,
            'provincias' => $this->params['provincias'],
            'form' => $form->createView()
        ));
    }

    /**
     * Muestra las localidades a partir de una consulta pasada a JSON
     *
     * @Route("/localidades", name="localidades_json")
     *
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getLocalidades(Request $request)
    {
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
     *
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getLocalidadesProvincia(Request $request)
    {
        $this->initialize();
        $provincia = $request->request->get('idProvincia');
        $this->params['localidades'] = $this->em->getRepository('AppBundle:Localidad')
            ->findAll([],[
                'idProvincia' => $provincia,
                'nombre' => 'DESC'
            ]);
        return $this->render('RegisterBundle:Json:localidades.json.twig', $this->params);
    }

    private function getProvincias()
    {
        $this->initialize();
        return $this->em->getRepository("AppBundle:Provincia")
            ->findAll([],[
                'nombre' => 'ASC'
            ]);
    }

    private function initialize()
    {
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }
}
