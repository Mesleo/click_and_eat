<?php

namespace AppBundle\Entity;

/**
 * Domicilio
 */
class Domicilio
{
    /**
     * @var string
     */
    private $domicilio;

    /**
     * @var string
     */
    private $direccionExtra;

    /**
     * @var string
     */
    private $localidad;

    /**
     * @var string
     */
    private $provincia;

    /**
     * @var integer
     */
    private $codigoPostal;

    /**
     * @var integer
     */
    private $iddomicilio;

    /**
     * @var \AppBundle\Entity\Cliente
     */
    private $clientecliente;


    /**
     * Set domicilio
     *
     * @param string $domicilio
     *
     * @return Domicilio
     */
    public function setDomicilio($domicilio)
    {
        $this->domicilio = $domicilio;

        return $this;
    }

    /**
     * Get domicilio
     *
     * @return string
     */
    public function getDomicilio()
    {
        return $this->domicilio;
    }

    /**
     * Set direccionExtra
     *
     * @param string $direccionExtra
     *
     * @return Domicilio
     */
    public function setDireccionExtra($direccionExtra)
    {
        $this->direccionExtra = $direccionExtra;

        return $this;
    }

    /**
     * Get direccionExtra
     *
     * @return string
     */
    public function getDireccionExtra()
    {
        return $this->direccionExtra;
    }

    /**
     * Set localidad
     *
     * @param string $localidad
     *
     * @return Domicilio
     */
    public function setLocalidad($localidad)
    {
        $this->localidad = $localidad;

        return $this;
    }

    /**
     * Get localidad
     *
     * @return string
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }

    /**
     * Set provincia
     *
     * @param string $provincia
     *
     * @return Domicilio
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia
     *
     * @return string
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * Set codigoPostal
     *
     * @param integer $codigoPostal
     *
     * @return Domicilio
     */
    public function setCodigoPostal($codigoPostal)
    {
        $this->codigoPostal = $codigoPostal;

        return $this;
    }

    /**
     * Get codigoPostal
     *
     * @return integer
     */
    public function getCodigoPostal()
    {
        return $this->codigoPostal;
    }

    /**
     * Get iddomicilio
     *
     * @return integer
     */
    public function getIddomicilio()
    {
        return $this->iddomicilio;
    }

    /**
     * Set clientecliente
     *
     * @param \AppBundle\Entity\Cliente $clientecliente
     *
     * @return Domicilio
     */
    public function setClientecliente(\AppBundle\Entity\Cliente $clientecliente = null)
    {
        $this->clientecliente = $clientecliente;

        return $this;
    }

    /**
     * Get clientecliente
     *
     * @return \AppBundle\Entity\Cliente
     */
    public function getClientecliente()
    {
        return $this->clientecliente;
    }
}
