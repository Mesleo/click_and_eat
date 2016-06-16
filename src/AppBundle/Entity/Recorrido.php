<?php
// src/AppBundle/Entity/Recorrido.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recorrido
 *
 * @ORM\Entity
 * @ORM\Table(name="recorrido")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RecorridoRepository")
 */
class Recorrido
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
     * @ORM\Column(name="numRecorrido", type="string", nullable=true)
     */
    protected $numRecorrido;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_hora_salida", type="datetime", nullable=true)
     */
    protected $fechaHoraSalida;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_hora_llegada", type="datetime", nullable=true)
     */
    protected $fechaHoraLlegada;

    /**
     * @ORM\ManyToOne(targetEntity="Trabajador", inversedBy="recorridos")
     * @ORM\JoinColumn(name="idTrabajador", referencedColumnName="id", nullable=true)
     */
    protected $trabajador;

    /**
     * @ORM\ManyToOne(targetEntity="Restaurante", inversedBy="recorridos")
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
     * Constructor
     */
    public function __construct()
    {
        $this->pedidos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
        $this->setTrash(false);
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
     * Set numRecorrido
     *
     * @param \DateTime $numRecorrido
     *
     * @return Recorrido
     */
    public function setNumRecorrido($numRecorrido)
    {
        $this->numRecorrido = $numRecorrido;

        return $this;
    }

    /**
     * Get numRecorrido
     *
     * @return \DateTime
     */
    public function getNumRecorrido()
    {
        return $this->numRecorrido;
    }

    /**
     * Set fechaHoraSalida
     *
     * @param \DateTime $fechaHoraSalida
     *
     * @return Recorrido
     */
    public function setFechaHoraSalida($fechaHoraSalida)
    {
        $this->fechaHoraSalida = $fechaHoraSalida;

        return $this;
    }

    /**
     * Get fechaHoraSalida
     *
     * @return \DateTime
     */
    public function getFechaHoraSalida()
    {
        return $this->fechaHoraSalida;
    }

    /**
     * Set fechaHoraLlegada
     *
     * @param \DateTime $fechaHoraLlegada
     *
     * @return Recorrido
     */
    public function setFechaHoraLlegada($fechaHoraLlegada)
    {
        $this->fechaHoraLlegada = $fechaHoraLlegada;

        return $this;
    }

    /**
     * Get fechaHoraLlegada
     *
     * @return \DateTime
     */
    public function getFechaHoraLlegada()
    {
        return $this->fechaHoraLlegada;
    }

    /**
     * Set trabajador
     *
     * @param \AppBundle\Entity\Trabajador $trabajador
     *
     * @return Recorrido
     */
    public function setTrabajador(\AppBundle\Entity\Trabajador $trabajador = null)
    {
        $this->trabajador = $trabajador;

        return $this;
    }

    /**
     * Get trabajador
     *
     * @return \AppBundle\Entity\Trabajador
     */
    public function getTrabajador()
    {
        return $this->trabajador;
    }

    /**
     * Set restaurante
     *
     * @param \AppBundle\Entity\Restaurante $restaurante
     *
     * @return Recorrido
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
     * Add pedido
     *
     * @param \AppBundle\Entity\Pedido $pedido
     *
     * @return Recorrido
     */
    public function addPedido(\AppBundle\Entity\Pedido $pedido)
    {
        $this->pedidos[] = $pedido;

        return $this;
    }

    /**
     * Remove pedido
     *
     * @param \AppBundle\Entity\Pedido $pedido
     */
    public function removePedido(\AppBundle\Entity\Pedido $pedido)
    {
        $this->pedidos->removeElement($pedido);
    }

    /**
     * Get pedidos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPedidos()
    {
        return $this->pedidos;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Recorrido
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
     * @return Recorrido
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
     * @return Recorrido
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
