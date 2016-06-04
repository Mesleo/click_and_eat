<?php
// src/AppBundle/Entity/Trabajador.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Trabajador
 *
 * @ORM\Entity
 * @ORM\Table(name="trabajador")
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TrabajadorRepository")
 */
class Trabajador
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", length=100, nullable=false)
     */
    protected $apellidos;

    /**
     * @ORM\OneToMany(targetEntity="Pedido", mappedBy="trabajador")
     */
    protected $pedidos;

    /**
     * @ORM\OneToMany(targetEntity="Recorrido", mappedBy="trabajador")
     */
    protected $recorridos;

    /**
     * @ORM\ManyToOne(targetEntity="Restaurante", inversedBy="trabajadores")
     * @ORM\JoinColumn(name="idRestaurante", referencedColumnName="id", nullable=false)
     */
    protected $restaurante;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pedidos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->recorridos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Trabajador
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
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
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set typeUser
     *
     * @param integer $typeUser
     *
     * @return Trabajador
     */
    public function setTypeUser($typeUser)
    {
        $this->typeUser = $typeUser;

        return $this;
    }

    /**
     * Get typeUser
     *
     * @return integer
     */
    public function getTypeUser()
    {
        return $this->typeUser;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Trabajador
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
     * @return Trabajador
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
     * @return Trabajador
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
     * Add pedido
     *
     * @param \AppBundle\Entity\Pedido $pedido
     *
     * @return Trabajador
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
     * Add recorrido
     *
     * @param \AppBundle\Entity\Recorrido $recorrido
     *
     * @return Trabajador
     */
    public function addRecorrido(\AppBundle\Entity\Recorrido $recorrido)
    {
        $this->recorridos[] = $recorrido;

        return $this;
    }

    /**
     * Remove recorrido
     *
     * @param \AppBundle\Entity\Recorrido $recorrido
     */
    public function removeRecorrido(\AppBundle\Entity\Recorrido $recorrido)
    {
        $this->recorridos->removeElement($recorrido);
    }

    /**
     * Get recorridos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecorridos()
    {
        return $this->recorridos;
    }

    /**
     * Set restaurante
     *
     * @param \AppBundle\Entity\Restaurante $restaurante
     *
     * @return Trabajador
     */
    public function setRestaurante(\AppBundle\Entity\Restaurante $restaurante)
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
