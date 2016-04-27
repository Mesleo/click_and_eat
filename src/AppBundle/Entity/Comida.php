<?php

namespace AppBundle\Entity;

/**
 * Comida
 */
class Comida
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var float
     */
    private $precio;

    /**
     * @var string
     */
    private $foto;

    /**
     * @var boolean
     */
    private $disponible = '1';

    /**
     * @var integer
     */
    private $idcomida;

    /**
     * @var \AppBundle\Entity\Restaurante
     */
    private $restauranterestaurante;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Comida
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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Comida
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set precio
     *
     * @param float $precio
     *
     * @return Comida
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get precio
     *
     * @return float
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set foto
     *
     * @param string $foto
     *
     * @return Comida
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;

        return $this;
    }

    /**
     * Get foto
     *
     * @return string
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * Set disponible
     *
     * @param boolean $disponible
     *
     * @return Comida
     */
    public function setDisponible($disponible)
    {
        $this->disponible = $disponible;

        return $this;
    }

    /**
     * Get disponible
     *
     * @return boolean
     */
    public function getDisponible()
    {
        return $this->disponible;
    }

    /**
     * Get idcomida
     *
     * @return integer
     */
    public function getIdcomida()
    {
        return $this->idcomida;
    }

    /**
     * Set restauranterestaurante
     *
     * @param \AppBundle\Entity\Restaurante $restauranterestaurante
     *
     * @return Comida
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
