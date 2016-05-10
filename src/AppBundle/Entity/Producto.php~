<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Producto
 *
 * @ORM\Entity
 * @ORM\Table(name="producto")
 */
class Producto
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=100, nullable=false)
     */
    private $descripcion;

    /**
     * @var float
     *
     * @ORM\Column(name="precio", type="float", nullable=false)
     */
    private $precio;

    /**
     * @var string
     *
     * @ORM\Column(name="foto", type="string", nullable=false)
     */
    private $foto;

    /**
     * @var boolean
     *
     * @ORM\Column(name="disponible", type="boolean")
     */
    private $disponible = 1;

    /**
     * @ORM\ManyToOne(targetEntity="Restaurante", inversedBy="productos")
     * @ORM\JoinColumn(name="restaurante_id", referencedColumnName="id")
     */
    private $idRestaurante;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    protected $created_at;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    protected $updated_at;

    /**
     * @var boolean
     *
     * @ORM\Column(name="trash", type="boolean", options={"default":0})
     */
    protected $trash;


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

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idRestaurante
     *
     * @param \AppBundle\Entity\Restaurante $idRestaurante
     *
     * @return Producto
     */
    public function setIdRestaurante(\AppBundle\Entity\Restaurante $idRestaurante = null)
    {
        $this->idRestaurante = $idRestaurante;

        return $this;
    }

    /**
     * Get idRestaurante
     *
     * @return \AppBundle\Entity\Restaurante
     */
    public function getIdRestaurante()
    {
        return $this->idRestaurante;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Producto
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Producto
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set trash
     *
     * @param boolean $trash
     *
     * @return Producto
     */
    public function setTrash($trash)
    {
        $this->trash = $trash;

        return $this;
    }

    /**
     * Get trash
     *
     * @return boolean
     */
    public function getTrash()
    {
        return $this->trash;
    }
}
