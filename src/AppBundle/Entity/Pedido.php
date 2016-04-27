<?php

namespace AppBundle\Entity;

/**
 * Pedido
 */
class Pedido
{
    /**
     * @var integer
     */
    private $cantidad;

    /**
     * @var integer
     */
    private $idpedido;

    /**
     * @var \AppBundle\Entity\Cliente
     */
    private $clientecliente;

    /**
     * @var \AppBundle\Entity\Restaurante
     */
    private $restauranterestaurante;

    /**
     * @var \AppBundle\Entity\Trabajador
     */
    private $trabajadortrabajador;


    /**
     * Set cantidad
     *
     * @param integer $cantidad
     *
     * @return Pedido
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Get idpedido
     *
     * @return integer
     */
    public function getIdpedido()
    {
        return $this->idpedido;
    }

    /**
     * Set clientecliente
     *
     * @param \AppBundle\Entity\Cliente $clientecliente
     *
     * @return Pedido
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

    /**
     * Set restauranterestaurante
     *
     * @param \AppBundle\Entity\Restaurante $restauranterestaurante
     *
     * @return Pedido
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

    /**
     * Set trabajadortrabajador
     *
     * @param \AppBundle\Entity\Trabajador $trabajadortrabajador
     *
     * @return Pedido
     */
    public function setTrabajadortrabajador(\AppBundle\Entity\Trabajador $trabajadortrabajador = null)
    {
        $this->trabajadortrabajador = $trabajadortrabajador;

        return $this;
    }

    /**
     * Get trabajadortrabajador
     *
     * @return \AppBundle\Entity\Trabajador
     */
    public function getTrabajadortrabajador()
    {
        return $this->trabajadortrabajador;
    }
}
