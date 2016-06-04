<?php
// src/AppBundle/Entity/Cliente.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Cliente
 *
 * @ORM\Entity
 * @ORM\Table(name="cliente")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ClienteRepository")
 */
class Cliente
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
     * @ORM\OneToMany(targetEntity="Domicilio", mappedBy="cliente")
     */
    protected $domicilios;

    /**
     * @ORM\OneToMany(targetEntity="Pedido", mappedBy="cliente")
     */
    protected $pedidos;

    /**
     * @ORM\OneToMany(targetEntity="Reserva", mappedBy="cliente")
     */
    protected $reservas;

    /**
     * @ORM\OneToMany(targetEntity="Comentario", mappedBy="cliente") 
     */
    protected $comentarios;

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
        parent::__construct();
        $this->addRole("ROLE_CLIENT");
        $this->domicilios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->pedidos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->reservas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->comentarios = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set apellidos
     *
     * @param string $apellidos
     *
     * @return Cliente
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Cliente
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
     * @return Cliente
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
     * @return Cliente
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
     * Set name
     *
     * @param string $name
     *
     * @return Cliente
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
     * @return Cliente
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
     * @return Cliente
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
     * Add domicilio
     *
     * @param \AppBundle\Entity\Domicilio $domicilio
     *
     * @return Cliente
     */
    public function addDomicilio(\AppBundle\Entity\Domicilio $domicilio)
    {
        $this->domicilios[] = $domicilio;

        return $this;
    }

    /**
     * Remove domicilio
     *
     * @param \AppBundle\Entity\Domicilio $domicilio
     */
    public function removeDomicilio(\AppBundle\Entity\Domicilio $domicilio)
    {
        $this->domicilios->removeElement($domicilio);
    }

    /**
     * Get domicilios
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDomicilios()
    {
        return $this->domicilios;
    }

    /**
     * Add pedido
     *
     * @param \AppBundle\Entity\Pedido $pedido
     *
     * @return Cliente
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
     * Add reserva
     *
     * @param \AppBundle\Entity\Reserva $reserva
     *
     * @return Cliente
     */
    public function addReserva(\AppBundle\Entity\Reserva $reserva)
    {
        $this->reservas[] = $reserva;

        return $this;
    }

    /**
     * Remove reserva
     *
     * @param \AppBundle\Entity\Reserva $reserva
     */
    public function removeReserva(\AppBundle\Entity\Reserva $reserva)
    {
        $this->reservas->removeElement($reserva);
    }

    /**
     * Get reservas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReservas()
    {
        return $this->reservas;
    }

    /**
     * Add comentario
     *
     * @param \AppBundle\Entity\Comentario $comentario
     *
     * @return Cliente
     */
    public function addComentario(\AppBundle\Entity\Comentario $comentario)
    {
        $this->comentarios[] = $comentario;

        return $this;
    }

    /**
     * Remove comentario
     *
     * @param \AppBundle\Entity\Comentario $comentario
     */
    public function removeComentario(\AppBundle\Entity\Comentario $comentario)
    {
        $this->comentarios->removeElement($comentario);
    }

    /**
     * Get comentarios
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComentarios()
    {
        return $this->comentarios;
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
