<?php
// src/RegisterBundle/Controller/RegistroRestauranteController.php
namespace RegisterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Restaurante;
use RegisterBundle\Form\UsuarioType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

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
     *
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function registerRestaurantAction(Request $request)
    {
        $this->initialize();

        $usuario = new \AppBundle\Entity\Usuario();
        $form = $this->createForm(UsuarioType::class, $usuario);

        $form->handleRequest($request);

        $this->params['provincias'] = $this->getProvincias();
        $this->params['info'] = null;

        if ($form->isSubmitted() && $form->isValid()) {

            $password = $this->get('security.password_encoder')
                ->encodePassword($usuario, $usuario->getPassword());
            $usuario->setPassword($password);
            $usuario->addRole(1);
            $usuario->setTypeUser(1);

            $restaurante = new Restaurante();

            if (!$this->isValidCif($request->request->get('cif'))) {
                $this->params['info'] = "Formato CIF no válido.";
            } else {
                $restaurante->setCif($request->request->get('cif'));
            }

            if (strlen($request->request->get('nombre')) < 3) {
                $this->params['info'] = "El nombre debe tener al menos 3 caracteres.";
            } else {
                $restaurante->setNombre($request->request->get('nombre'));
            }

            $restaurante->setDireccion($request->request->get('direccion'));
            $restaurante->setTelefono($request->request->get('telefono'));
            $restaurante->setCoordenadas($request->request->get('coordenadas'));
            $restaurante->setPrecioEnvio($request->request->get('precioEnvio'));

            $localidad = $this->em->getRepository("AppBundle:Localidad")
                ->findOneBy([
                    'id' => $request->request->get('localidad')
                ]);
            $restaurante->setLocalidad($localidad);
          
            $provincia = $this->em->getRepository("AppBundle:Provincia")
                ->findOneBy([
                    'id' => $request->request->get('provincia')
                ]);
            $restaurante->setProvincia($provincia);
            
            if ($request->files->get('foto') != null) {
                $restaurante->setImg($request->files->get('foto'));
            }
            $restaurante->uploadImg();

            $restaurante->setUsuario($usuario);

            if ($this->params['info'] == null) {

                $this->em->persist($usuario);
                $this->em->persist($restaurante);
                $this->em->flush();

                $this->sendEmail($usuario->getEmail());
                return $this->redirectToRoute('admin_login');
            }  
        }

        return $this->render('RegisterBundle:Web:registro.html.twig', array(
            'usuario' => $usuario,
            'provincias' => $this->params['provincias'],
            'info' => $this->params['info'],
            'form' => $form->createView(),
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
        $this->params['localidades'] = $this->em->getRepository("AppBundle:Localidad")
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
        $this->params['localidades'] = $this->em->getRepository("AppBundle:Localidad")
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

    private function sendEmail($to)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Bienvenido a Click&Eat')
            ->setFrom('register@clickandeat.com')
            ->setTo($to)
            ->setBody(
                $this->renderView(
                    // app/Resources/views/Emails/registration.html.twig
                    'Emails/registration.html.twig',
                    array('email' => $to)
                ),
                'text/html'
            )
        ;
        $this->get('mailer')->send($message);
    }

    /**
     * @Route("/{email}/check", name="check_user")
     *
     * @param  [type] $email [description]
     * @return [type]           [description]
     */
    public function checkUser($email) 
    {
        $this->initialize();
            
        $usuario = $this->em->getRepository("AppBundle:Usuario")
            ->findOneBy([
                'email' => $email
            ]);

        $usuario->setEnabled(true);
        $this->em->flush();
        return $this->redirectToRoute('admin_login');
    }

    private function isValidCif($string)
    {
        return preg_match("/^[a|b|c|d|e|f|g|h|j|n|p|q|r|s|u|v|w]{1}\\d{7}[\\d|\\w]{1}$/i", $string);
    }

    private function initialize()
    {
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }
}
