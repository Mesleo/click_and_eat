<?php
// src/AppBundle/Entity/Plato.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Plato
 *
 * @ORM\Entity
 * @ORM\Table(name="plato")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlatoRepository")
 */
class Plato
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100, nullable=false)
     */
    protected $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=false)
     */
    protected $descripcion;

    /**
     * @var float
     *
     * @ORM\Column(name="precio", type="float", nullable=false)
     */
    protected $precio;

    /**
     * @var string
     *
     * @ORM\Column(name="foto", type="string", length=255, nullable=false)
     */
    protected $foto;

    /**
     * @var boolean 
     *
     * @ORM\Column(name="disponible", type="boolean", options={"default":1})
     */
    protected $disponible;

    /**
     * @ORM\ManyToOne(targetEntity="Restaurante", inversedBy="platos")
     * @ORM\JoinColumn(name="idRestaurante", referencedColumnName="id", nullable=false)
     */
    protected $restaurante;

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
     * @ORM\OneToMany(targetEntity="PedidoPlato", mappedBy="plato")
     */
    protected $pedido_plato;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pedido_plato = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Plato
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
     * @return Plato
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
     * @return Plato
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
     * @return Plato
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
     * @return Plato
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Plato
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
     * @return Plato
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
     * @return Plato
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

    /**
     * Set restaurante
     *
     * @param \AppBundle\Entity\Restaurante $restaurante
     *
     * @return Plato
     */
    public function setRestaurante(\AppBundle\Entity\Restaurante $restaurante = null)
    {
        $this->restaurante = $restaurante;

        return $this;
    }

    /**
     * Get restaurante
     *
     * @return \AppBundle\Entity\Restaurante
     */
    public function getRestaurante()
    {
        return $this->restaurante;
    }

    /**
     * Add pedidoPlato
     *
     * @param \AppBundle\Entity\PedidoPlato $pedidoPlato
     *
     * @return Plato
     */
    public function addPedidoPlato(\AppBundle\Entity\PedidoPlato $pedidoPlato)
    {
        $this->pedido_plato[] = $pedidoPlato;

        return $this;
    }

    /**
     * Remove pedidoPlato
     *
     * @param \AppBundle\Entity\PedidoPlato $pedidoPlato
     */
    public function removePedidoPlato(\AppBundle\Entity\PedidoPlato $pedidoPlato)
    {
        $this->pedido_plato->removeElement($pedidoPlato);
    }

    /**
     * Get pedidoPlato
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPedidoPlato()
    {
        return $this->pedido_plato;
    }
}
