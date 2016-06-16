<?php

namespace ManageCompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
     * Obtengo los datos del restaurante logeado, de ambas tablas, Usua
     *
     * @Route("/cuenta", name="cuenta")
     */
    public function configAccoutAction(){
        $this->initialize();
        $this->params['userLog'] = $this->getUserLog();
        $restaurante = $this->getRestaurante()[0];
        if($this->checkIdRestauranteIdUserLog($restaurante)) {
            $this->params['usuarioRestaurante'] = $restaurante;
            $this->params['provincias'] = $this->getProvincias();
            $this->params['tipos_comida'] = $this->getTiposComida($restaurante['restaurante_id']);
            return $this->render("ManageCompanyBundle:Restaurante:cuenta.html.twig", $this->params);
        }
        return $this->render("ManageCompanyBundle:Page:base.htm.twig", $this->params);
    }

    /**
     * Guardar los datos de la vista edición del restaurante
     *
     * @Route("/cuenta/guardar", name="cuenta_guardar")
     */
    public function accountSaveAction(Request $request){
        if($request->request->has('save-account')){
            $this->initialize();
            $this->params['info'] = null;
            $this->params['userLog'] = $this->getUserLog();
            $usuarioRestaurante = $this->getUserLog();
            $restaurante = $this->getRestaurante()[0];
            if($this->checkIdRestauranteIdUserLog($restaurante)) {
                $restaurante = $this->getRestauranteData();
                $usuarioRestaurante->setUsername($request->request->get('inputUserName'));
                if(filter_var($request->request->get('inputEmail'), FILTER_VALIDATE_EMAIL)) {
                    $usuarioRestaurante->setEmail($request->request->get('inputEmail'));
                }else {
                    $this->params['info'] = "Dirección de correo no válida";
                }
                $restaurante->setNombre($request->request->get('inputNombre'));
                $restaurante->setTelefono($request->request->get('inputTelefono'));
                if(!$this->isValidCif($request->request->get('inputCIF'))){
                    $this->params['info'] = "Formato CIF no válido";
                }else $restaurante->setCif($request->request->get('inputCIF'));
                $restaurante->setDireccion($request->request->get('inputDireccion'));
                if ($request->files->get('foto') != null) {
                    $restaurante->setImg($request->files->get('foto'));
                }
                $restaurante->uploadImg();
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
                $precioEnvio = $request->request->get('inputEnvio');
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
                $this->params['usuarioRestaurante'] = $restaurante;
                $this->params['provincias'] = $this->getProvincias();
                if($this->params['info'] == null){
                    $this->em->persist($restaurante);
                    $this->em->flush();
                    $this->params['info'] = "Datos actualizados correctamente";
                    $this->params['ok'] = true;
                }
                $restaurante = $this->getRestaurante()[0];
                $this->params['tipos_comida'] = $this->getTiposComida($restaurante['restaurante_id']);
                $this->params['usuarioRestaurante'] = $restaurante;
            }
        }
        return $this->render('ManageCompanyBundle:Restaurante:cuenta.html.twig', $this->params);
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
     * Valido el CIF introducido
     *
     * @param $string
     * @return int
     */
    private function isValidCif($string){
        return preg_match("/^[a|b|c|d|e|f|g|h|j|n|p|q|r|s|u|v|w]{1}\\d{7}[\\d|\\w]{1}$/i", $string);
    }

    private function getTiposComida($restaurante){
        return $this->em->getRepository('AppBundle:TipoComida')
            ->getTiposComidaRestaurante($restaurante);
    }

    /**
     * Obtengo el restaurante logeado (Tabla Usuarios)
     *
     * @return mixed
     */
    private function getUserLog(){
        return $this->em->getRepository("AppBundle:Usuario")
            ->findOneBy([
                "id" => $this->getUser()->getId()
            ]);
    }

    /**
     * Obtengo el restaurante logeado (Datos de ambas tablas: Usuario y Restaurante)
     *
     * @return mixed
     */
    private function getRestaurante(){
        return  $this->em->getRepository('AppBundle:Restaurante')
            ->getInfoRestauranteLogConfigAccount($this->getUser()->getId());
    }

    /**
     * Obtengo los datos del restaurante logeado (Tabla Restaurante)
     *
     * @return mixed
     */
    private function getRestauranteData(){
        return $this->em->getRepository("AppBundle:Restaurante")
            ->findOneBy([
                "usuario" => $this->getUserLog()->getId()
            ]);
    }

    /**
     * Compruebo que id del usuario logeado sea el id del restaurante con el que estoy trabajando
     *
     * @param $trabajador
     * @return bool
     */
    private function checkIdRestauranteIdUserLog($restaurante){
        return $restaurante['usuario_id'] == $this->getUser()->getId();
    }

    private function initialize(){
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }

}