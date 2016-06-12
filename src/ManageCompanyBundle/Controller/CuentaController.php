<?php
// src/ManageCompanyBundle/Controller/CuentaController.php
namespace ManageCompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\TipoComida;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class CuentaController extends Controller
{
    private $em = null;
    private $params = null;

    /**
     * @Route("/cuenta", name="cuenta")
     */
    public function configAccoutAction()
	{
        $this->initialize();
        $this->params['user'] = $this->em->getRepository("AppBundle:Usuario")
            ->findOneBy([
                'id' => $this->getUser()->getId()
            ]);
        $restaurante = $this->getRestaurante();
        if ($this->checkRestaurante($restaurante)) {
            $this->params['restaurante'] = $restaurante;
            $this->params['provincias'] = $this->getProvincias();
            return $this->render('ManageCompanyBundle:Restaurante:cuenta.html.twig', $this->params);
        }
        return $this->render('ManageCompanyBundle:Page:base.htm.twig', $this->params);
    }

    /**
     * @Route("/cuenta/guardar", name="cuenta_guardar")
     */
    public function accountSaveAction(Request $request)
	{
        if ($request->request->has('save-account')) {
            $this->initialize();
            $usuario = $this->em->getRepository("AppBundle:Usuario")
                ->findOneBy([
                    'id' => $this->getUser()->getId()
                ]);
            $restaurante = $this->em->getRepository("AppBundle:Restaurante")
                ->findOneBy([
                    'id' => $this->getRestaurante()
                ]);
				
            if ($this->checkRestaurante($restaurante)) {
				$usuario->setUsername($request->request->get('inputUserName'));
				$usuario->setEmail($request->request->get('inputEmail'));
				
                $restaurante->setCif($request->request->get('inputCIF'));
                $restaurante->setNombre($request->request->get('inputNombre'));
                $restaurante->setDireccion($request->request->get('inputDireccion'));
                $restaurante->setTelefono($request->request->get('inputTelefono'));
                $provincia = $this->em->getRepository("AppBundle:Provincia")
                    ->findOneBy([
                        'id' => $request->request->get('provincia')
                    ]);
                $localidad = $this->em->getRepository("AppBundle:Localidad")
                    ->findOneBy([
                        'id' => $request->request->get('localidad')
                    ]);
                $restaurante->setProvincia($provincia);
                $restaurante->setLocalidad($localidad);
                $restaurante->setPrecioEnvio($request->request->get('inputEnvio'));
				if ($request->files->get('foto') != null) {
					$restaurante->setImg($request->files->get('foto'));
				}
				$restaurante->uploadImg();

                $tiposComidaRestaurante = $restaurante->getTipoComida();
                $repoTiposComida = $this->em->getRepository("AppBundle:TipoComida");
                $tiposComida = $request->request->get('hidden-tipo-comida');
                $tiposComidaArray = explode(',', $tiposComida);
                foreach ($tiposComidaArray as $tc) {
                    $dbTiposComidas = $repoTiposComida->findOneBy([
                        'nombre' => $tc,
                    ]);
                    if (empty($dbTiposComidas)) {
                        $dbTiposComidas = new TipoComida();
                        $dbTiposComidas->setNombre($tc);
                        $this->em->persist($dbTiposComidas);
                    }
                    if (!$tiposComidaRestaurante->contains($dbTiposComidas)) {
                        $restaurante->addTipoComida($dbTiposComidas);
                    }
                }
                foreach ($tiposComidaRestaurante as $catNot) {
                    if (!in_array($catNot->getNombre(), $tiposComidaArray)) {
                        $restaurante->removeTipoComida($catNot);
                    }
                }

                $this->em->flush();
            }
        }
        return $this->render('ManageCompanyBundle:Page:base.html.twig');
    }


    /**
     * Muestra las localidades a partir de una consulta pasada a JSON
     *
     * @Route("/localidades", name="cuenta_localidades_json")
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
        $provincia = $request->request->get("idProvincia");
        $this->params['localidades'] = $this->em->getRepository("AppBundle:Localidad")
            ->findAll([],[
                'idProvincia' => $provincia,
                'nombre' => "DESC"
            ]);
        return $this->render('RegisterBundle:Json:localidades.json.twig', $this->params);
    }

    private function getProvincias()
	{
        return $this->em->getRepository("AppBundle:Provincia")
            ->findAll([],[
                'nombre' => 'DESC'
            ]);
    }

    /**
     * Obtengo el id del restaurante logeado
     *
     * @return mixed
     */
    private function getRestaurante()
	{
        $user = $this->em->getRepository("AppBundle:Usuario")
            ->findOneBy([
                'id' => $this->getUser()->getId()
            ]);
        return  $this->em->getRepository("AppBundle:Restaurante")
            ->findOneBy([
                'usuario' => $user->getId()
            ]);
    }

    /**
     * Compruebo que id del usuario logeado sea el id del restaurante con el que estoy trabajando
     *
     * @param $restaurante
     * @return bool
     */
    private function checkRestaurante($restaurante)
	{
        return $restaurante->getId() == $this->getRestaurante()->getId();
    }

    private function initialize()
	{
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }
}