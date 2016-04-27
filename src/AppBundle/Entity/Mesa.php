<?php

namespace AppBundle\Entity;

/**
 * Mesa
 */
class Mesa
{
    /**
     * @var string
     */
    private $numpersonas;

    /**
     * @var boolean
     */
    private $reservada = '0';

    /**
     * @var integer
     */
    private $idmesa;

    /**
     * @var \AppBundle\Entity\Restaurante
     */
    private $restauranterestaurante;


    /**
     * Set numpersonas
     *
     * @param string $numpersonas
     *
     * @return Mesa
     */
    public function setNumpersonas($numpersonas)
    {
        $this->numpersonas = $numpersonas;

        return $this;
    }

    /**
     * Get numpersonas
     *
     * @return string
     */
    public function getNumpersonas()
    {
        return $this->numpersonas;
    }

    /**
     * Set reservada
     *
     * @param boolean $reservada
     *
     * @return Mesa
     */
    public function setReservada($reservada)
    {
        $this->reservada = $reservada;

        return $this;
    }

    /**
     * Get reservada
     *
     * @return boolean
     */
    public function getReservada()
    {
        return $this->reservada;
    }

    /**
     * Get idmesa
     *
     * @return integer
     */
    public function getIdmesa()
    {
        return $this->idmesa;
    }

    /**
     * Set restauranterestaurante
     *
     * @param \AppBundle\Entity\Restaurante $restauranterestaurante
     *
     * @return Mesa
     */
    public function setRestauranterestaurante(\AppBundle\Entity\Restaurante $restauranterestaurante = null)
    {
        $this->restauranterestaurante = $restauranterestaurante;

        return $this;
    }

    /**
     * Get restauranterestaurante
     *
     * @return \AppBundle\Entity\Restaurante
     */
    public function getRestauranterestaurante()
    {
        return $this->restauranterestaurante;
    }
}
