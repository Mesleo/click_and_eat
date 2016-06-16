<?php
// src/ClientBundle/Controller/CuentaController.php
namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Domicilio;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class CuentaController extends Controller
{
	private $params = null;
	private $em = null;

	/**
     * @Route("/cuenta/info", name="cuenta_info")
     */
    public function configAccountAction()
	{
        $this->initialize();

        $this->params['user'] = $this->em->getRepository("AppBundle:Usuario")
			->findOneBy([
				'id' => $this->getUser()->getId()
			]);
		$cliente = $this->getCliente();

        if ($this->checkCliente($cliente)) {
        	$this->params['cliente'] = $cliente;
            return $this->render('ClientBundle:Cliente:cuenta.html.twig', $this->params);
        }

        return $this->render('ClientBundle:Page:index.htm.twig', $this->params);
    }

    /**
     * @Route("/cuenta/direcciones", name="cuenta_direcciones")
     */
    public function configDireccionesAction()
	{
        $this->initialize();

        $this->params['user'] = $this->em->getRepository("AppBundle:Usuario")
			->findOneBy([
				'id' => $this->getUser()->getId()
			]);
		$cliente = $this->getCliente();

        if ($this->checkCliente($cliente)) {
        	$this->params['cliente'] = $cliente;
            return $this->render('ClientBundle:Cliente:direcciones.html.twig', $this->params);
        }

        return $this->render('ClientBundle:Page:index.htm.twig', $this->params);
    }

    /**
     * @Route("/cuenta/info/guardar", name="cuenta_info_guardar")
     *
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function accountSaveAction(Request $request)
    {
    	if ($request->request->has('save-account')) {
    		$this->initialize();
    		$usuario = $this->em->getRepository("AppBundle:Usuario")
                ->findOneBy([
                    'id' => $this->getUser()->getId()
                ]);
            $cliente = $this->getCliente();

            $this->params['info'] = null;

            if ($this->checkCliente($cliente)) {

            	if (strlen($request->request->get('inputUserName')) < 3) {
                	$this->params['info'] = "El usuario debe tener al menos 3 caracteres.";
            	} else {
                	$usuario->setUsername($request->request->get('inputUserName'));
            	}

            	if (!$this->isValidEmail($request->request->get('inputEmail'))) {
                	$this->params['info'] = "Formato de email no válido.";
            	} else {
                	$usuario->setEmail($request->request->get('inputEmail'));
            	}

				if (strlen($request->request->get('inputNombre')) < 3) {
                	$this->params['info'] = "El nombre debe tener al menos 3 caracteres.";
            	} else {
                	$cliente->setNombre($request->request->get('inputNombre'));
            	}

				$cliente->setApellidos($request->request->get('inputApellidos'));

				if (!$this->isValidTelefono($request->request->get('inputTelefono'))) {
                	$this->params['info'] = "Formato de teléfono no válido.";
            	} else {
                	$cliente->setTelefono($request->request->get('inputTelefono'));
            	}

            	if ($this->params['info'] == null) {
            		$this->em->flush();
            		return $this->redirectToRoute('cuenta_info');
            	}
            }
            $this->params['user'] = $usuario;
			$this->params['cliente'] = $cliente;
    	}
    	return $this->render('ClientBundle:Cliente:cuenta.html.twig', $this->params);
    }

    /**
     * @Route("/cuenta/direcciones/add", name="cuenta_direcciones_add")
     *
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function direccionesAddAction(Request $request)
    {
    	$this->initialize();

    	$usuario = $this->em->getRepository("AppBundle:Usuario")
            ->findOneBy([
                'id' => $this->getUser()->getId()
            ]);
        $cliente = $this->getCliente();

        $this->params['provincias'] = $this->getProvincias();

        if ($request->request->has('save-direcciones')) {
        	
            $this->params['info'] = null;

        	$localidad = $this->em->getRepository("AppBundle:Localidad")
                ->findOneBy([
                    'id' => $request->request->get('localidad')
                ]);

            $domicilio = new Domicilio();
            if (strlen($request->request->get('direccion')) < 3) {
                $this->params['info'] = "La dirección debe tener al menos 3 caracteres.";
            } else {
                $domicilio->setDomicilio($request->request->get('direccion'));
            }
            $domicilio->setDireccionExtra($request->request->get('direccion-extra'));
            $domicilio->setLocalidad($localidad);
            $domicilio->setCodigoPostal($localidad->getCodigoPostal());
            $domicilio->setCliente($cliente);
            $cliente->addDomicilio($domicilio);

            if ($this->params['info'] == null) {
            	$this->em->persist($domicilio);
            	$this->em->flush();
            	return $this->redirectToRoute('cuenta_direcciones');
            }
        }
        $this->params['user'] = $usuario;
		$this->params['cliente'] = $cliente;

        return $this->render('ClientBundle:Cliente:direccion.html.twig', $this->params);
    }

    /**
     * @Route("/cuenta/direcciones/{id_direccion}", name="cuenta_direcciones_guardar")
     *
     * @param  Request $request [description]
     * @param  [type] $id_direccion [description]
     * @return [type]           [description]
     */
    public function direccionesSaveAction(Request $request, $id_direccion)
    {
    	$this->initialize();
    	$usuario = $this->em->getRepository("AppBundle:Usuario")
            ->findOneBy([
                'id' => $this->getUser()->getId()
            ]);
        $cliente = $this->getCliente();
        $domicilio = $this->em->getRepository("AppBundle:Domicilio")
            ->findOneBy([
                'id' => $id_direccion
            ]);

        $this->params['provincias'] = $this->getProvincias();
        $this->params['direccion'] = $domicilio;

    	if ($request->request->has('save-direcciones')) {
    		
            $this->params['info'] = null;

            if ($this->checkCliente($cliente)) {

            	if (strlen($request->request->get('direccion')) < 3) {
                	$this->params['info'] = "La dirección debe tener al menos 3 caracteres.";
            	} else {
                	$domicilio->setDomicilio($request->request->get('direccion'));
            	}

            	$domicilio->setDireccionExtra($request->request->get('direccion-extra'));

            	$localidad = $this->em->getRepository("AppBundle:Localidad")
                	->findOneBy([
                    	'id' => $request->request->get('localidad')
                	]);
                $domicilio->setLocalidad($localidad);
                $domicilio->setCodigoPostal($localidad->getCodigoPostal());

            	if ($this->params['info'] == null) {
            		$this->em->flush();
            		return $this->redirectToRoute('cuenta_direcciones');
            	}
            }
    	}
    	$this->params['user'] = $usuario;
		$this->params['cliente'] = $cliente;

    	return $this->render('ClientBundle:Cliente:direccion.html.twig', $this->params);
    }

    /**
     * Muestra las localidades a partir de una consulta pasada a JSON
     *
     * @Route("/localidades", name="direcciones_localidades_json")
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
        return $this->render('ClientBundle:FilesJson:localidades_cliente.json.twig', $this->params);
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
        return $this->render('ClientBundle:FilesJson:localidades_cliente.json.twig', $this->params);
    }

    private function getProvincias()
    {
        $this->initialize();
        return $this->em->getRepository("AppBundle:Provincia")
            ->findAll([],[
                'nombre' => 'ASC'
            ]);
    }

    /**
     * Obtengo el cliente logueado
     *
     * @return mixed
     */
    private function getCliente()
	{
		return $this->em->getRepository("AppBundle:Cliente")
            ->findOneBy([
                'usuario' => $this->getUser()->getId()
            ]);
    }

    /**
     * 
     *
     * @param  [type]  $cliente [description]
     * @return [type]           [description]
     */
    private function checkCliente($cliente)
	{
        return $cliente->getId() == $this->getCliente()->getId();
    }

    private function isValidEmail($string)
    {
        return preg_match("/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/i", $string);
    }

    private function isValidTelefono($string)
    {
        return preg_match("/^\d{9}$/i", $string);
    }

    private function initialize()
	{
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }
}