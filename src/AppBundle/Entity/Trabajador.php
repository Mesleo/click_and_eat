<?php

namespace AppBundle\Entity;

/**
 * Trabajador
 */
class Trabajador
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $apellidos;

    /**
     * @var integer
     */
    private $telefono;

    /**
     * @var integer
     */
    private $idtrabajador;

    /**
     * @var \AppBundle\Entity\Restaurante
     */
    private $restauranterestaurante;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Trabajador
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellidos
     *
     * @param string $apellidos
     *
     * @return Trabajador
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set telefono
     *
     * @param integer $telefono
     *
     * @return Trabajador
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return integer
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set idtrabajador
     *
     * @param integer $idtrabajador
     *
     * @return Trabajador
     */
    public function setIdtrabajador($idtrabajador)
    {
        $this->idtrabajador = $idtrabajador;

        return $this;
    }

    /**
     * Get idtrabajador
     *
     * @return integer
     */
    public function getIdtrabajador()
    {
        return $this->idtrabajador;
    }

    /**
     * Set restauranterestaurante
     *
     * @param \AppBundle\Entity\Restaurante $restauranterestaurante
     *
     * @return Trabajador
     */
    public function setRestauranterestaurante(\AppBundle\Entity\Restaurante $restauranterestaurante)
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
