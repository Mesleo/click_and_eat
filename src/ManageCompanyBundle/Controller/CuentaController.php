<?php

namespace ManageCompanyBundle\Controller;
error_reporting(E_ALL);
ini_set('display_errors','On');
use AppBundle\AppBundle;
use AppBundle\Entity\Horario;
use AppBundle\Entity\TipoComida;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Producto;
use ManageCompanyBundle\Form\ProductoType;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Time;

class CuentaController extends Controller
{

    private $em = null;
    private $params = null;

    /**
     * @Route("/cuenta", name="cuenta")
     */
    public function configAccoutAction(){
        $this->initialize();
        $this->params['userLog'] = $this->em->getRepository("AppBundle:Usuario")
            ->findOneBy([
                "id" => $this->getUser()->getId()
            ]);
        $restaurante = $this->getRestaurante();
        if($this->checkIdRestauranteIdUserLog($restaurante)) {
            $this->params['usuarioRestaurante'] = $restaurante;
            $this->params['provincias'] = $this->getProvincias();
            return $this->render("ManageCompanyBundle:Restaurante:cuenta.html.twig", $this->params);
        }
        return $this->render("ManageCompanyBundle:Page:base.htm.twig", $this->params);
    }

    /**
     * @Route("/cuenta/guardar", name="cuenta_guardar")
     */
    public function accountSaveAction(Request $request){
        if($request->request->has('save-account')){
            $this->initialize();
            $usuarioRestaurante = $this->em->getRepository('AppBundle:Usuario')
                ->findOneBy([
                    "id" => $this->getUser()->getId()
                ]);
            $restaurante = $this->em->getRepository('AppBundle:Restaurante')
                ->findOneBy([
                    "id" => $this->getRestaurante()
                ]);
            if($this->checkIdRestauranteIdUserLog($restaurante)) {

                $precioEnvio = 0.00;
                $usuarioRestaurante->setUsername($request->request->get('inputUserName'));
                $usuarioRestaurante->setEmail($request->request->get('inputEmail'));
                $usuarioRestaurante->setName($request->request->get('inputNombre'));
                $usuarioRestaurante->setTelefono($request->request->get('inputTelefono'));
                $restaurante->setCif($request->request->get('inputCIF'));
                $restaurante->setDireccion($request->request->get('inputDireccion'));
                $provincia = $this->em->getRepository('AppBundle:Provincia')
                    ->findOneBy([
                        "id" => $request->request->get('provincia')
                    ]);
                $localidad = $this->em->getRepository('AppBundle:Localidad')
                    ->findOneBy([
                        "id" => $request->request->get('localidad')
                    ]);
                $restaurante->setProvincia($provincia);
                $restaurante->setLocalidad($localidad);
                if(is_float($request->request->get('inputEnvio'))){
                    $precioEnvio = $request->request->get('inputEnvio');
                }
                $restaurante->setPrecioEnvio($precioEnvio);

                $tiposComidaRestaurante = $restaurante->getTipoComida();
                $repoTiposComida = $this->em->getRepository('AppBundle:TipoComida');
                $tiposComida = $request->request->get('hidden-tipo-comida');
                $tiposComidaArray = explode(',', $tiposComida);
                foreach ($tiposComidaArray as $tc) {
                    $dbTiposComidas = $repoTiposComida->findOneBy([
                        'nombre' => $tc,
                    ]);
                    if (empty($dbTiposComidas)) {
                        $dbTiposComidas = new \AppBundle\Entity\TipoComida();
                        $dbTiposComidas->setNombre($tc);
                        $this->em->persist($dbTiposComidas);
                    }
                    if (!$tiposComidaRestaurante->contains($dbTiposComidas)) {
                        $restaurante->addTipoComida($dbTiposComidas);
                    }
                }
                foreach ($tiposComidaRestaurante as $tipComida) {
                    if (!in_array($tipComida->getNombre(), $tiposComidaArray)) {
                        $restaurante->removeTipoComida($tipComida);
                    }
                }

                $this->em->persist($restaurante);
                $this->em->flush();
            }
        }
        return $this->render('ManageCompanyBundle:Page:base.html.twig');
    }


    /**
     * Muestra las localidades a partir de una consulta pasada a JSON
     *
     * @Route("/localidad", name="cuenta_localidades_json")
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
        return $this->em->getRepository("AppBundle:Provincia")
            ->findAll([],[
                "nombre" => "DESC"
            ]);
    }

    /**
     * Prueba de envio de email
     *
     * @Route("/envioEmail", name="send_email")
     */
    public function sendEmail(){
        $para      = 'javierbenitezdelpozo@gmail.com';
        $titulo    = 'El título';
        $mensaje   = 'Hola';
        $cabeceras = 'From: register@clickandeat.com' . "\r\n" .
            'Reply-To: consultas@clickandeat.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        if(mail($para, $titulo, $mensaje, $cabeceras)){
            $params['info'] = "Se le ha enviado un mensaje para activar su cuenta";
            echo error_reporting(E_ALL);
        }else{
            $params['info'] = "Lo sentimos, no se ha podido enviar mensaje de activación";
            echo error_reporting(E_ALL);
        }
        return $this->render("ManageCompanyBundle:Restaurante:cuenta.html.twig", $params);
    }

    /**
     * Obtengo el id del restaurante logeado (Tabla Restaurante)
     *
     * @return mixed
     */
    private function getRestaurante(){
        $user = $this->em->getRepository("AppBundle:Usuario")
            ->findOneBy([
                "id" => $this->getUser()->getId()
            ]);
        return  $this->em->getRepository('AppBundle:Restaurante')
            ->findOneBy([
                'id' => $user->getIdRestaurante()->getId()
            ]);
    }

    /**
     * Compruebo que id del usuario logeado sea el id del restaurante con el que estoy trabajando
     *
     * @param $trabajador
     * @return bool
     */
    private function checkIdRestauranteIdUserLog($restaurante){
        return $restaurante->getId() == $this->getRestaurante()->getId();
    }

    private function initialize(){
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }

}