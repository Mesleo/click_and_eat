<?php
// src/AppBundle/Entity/Reserva.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Reserva
 *
 * @ORM\Entity
 * @ORM\Table(name="reserva")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReservaRepository")
 */
class Reserva
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
     * @var integer
     *
     * @ORM\Column(name="numReserva", type="integer", nullable=true)
     */
    protected $numReserva;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_hora", type="datetime", nullable=false)
     * @Assert\NotBlank(message="Por favor introduce la fecha de reserva.")
     */
    protected $fechaHora;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_hora_realizada", type="datetime", nullable=false)
     */
    protected $fechaHoraRealizada;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100, nullable=false)
     * @Assert\NotBlank(message="Por favor introduce tu nombre.")
     * @Assert\Length(
     *     min=3,
     *     max=100,
     *     minMessage="El nombre introducido es demasiado corto.",
     *     maxMessage="El nombre introducido es demasiado largo."
     * )
     */
    protected $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=15, nullable=false)
     * @Assert\NotBlank(message="Por favor introduce tu telefono.")
     * @Assert\Length(
     *     min=9,
     *     max=15,
     *     minMessage="El numero de telefono introducido es demasiado corto.",
     *     maxMessage="El numero de telefono introducido es demasiado largo."
     * )
     */
    protected $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=false)
     * @Assert\NotBlank(message="Por favor introduce tu email.")
     * @Assert\Length(
     *     min=3,
     *     max=100,
     *     minMessage="El email introducido es demasiado corto.",
     *     maxMessage="El email introducido es demasiado largo."
     * )
     */
    protected $email;

    /**
     * @var integer
     *
     * @ORM\Column(name="numPersonas", type="integer", nullable=false)
     * @Assert\NotBlank(message="Por favor introduce el numero de personas.")
     */
    protected $numPersonas;

    /**
     * @ORM\ManyToOne(targetEntity="Restaurante", inversedBy="reservas")
     * @ORM\JoinColumn(name="idRestaurante", referencedColumnName="id", nullable=false)
     */
    protected $restaurante;

    /**
     * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="reservas")
     * @ORM\JoinColumn(name="idCliente", referencedColumnName="id", nullable=true)
     */
    protected $cliente;

    /**
     * @ORM\ManyToMany(targetEntity="Mesa", inversedBy="reserva")
     * @ORM\JoinTable(name="mesa_reserva",
     *      joinColumns={@ORM\JoinColumn(name="idReserva", referencedColumnName="id", nullable=false)},
     *      inverseJoinColumns={@ORM\JoinColumn(name="idMesa", referencedColumnName="id", nullable=false)}
     *      )
     */
    protected $mesa;

    /**
     * @ORM\ManyToOne(targetEntity="EstadoReserva")
     * @ORM\JoinColumn(name="estado_id", referencedColumnName="id", nullable=false)
     */
    protected $estado;

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
        $this->mesa = new \Doctrine\Common\Collections\ArrayCollection();

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
     * Set numReserva
     *
     * @param integer $numReserva
     *
     * @return Reserva
     */
    public function setNumReserva($numReserva)
    {
        $this->numReserva = $numReserva;

        return $this;
    }

    /**
     * Get numReserva
     *
     * @return integer
     */
    public function getNumReserva()
    {
        return $this->numReserva;
    }

    /**
     * Set fechaHora
     *
     * @param \DateTime $fechaHora
     *
     * @return Reserva
     */
    public function setFechaHora($fechaHora)
    {
        $this->fechaHora = $fechaHora;

        return $this;
    }

    /**
     * Get fechaHora
     *
     * @return \DateTime
     */
    public function getFechaHora()
    {
        return $this->fechaHora;
    }

    /**
     * Set fechaHoraRealizada
     *
     * @param \DateTime $fechaHoraRealizada
     *
     * @return Reserva
     */
    public function setFechaHoraRealizada($fechaHoraRealizada)
    {
        $this->fechaHoraRealizada = $fechaHoraRealizada;

        return $this;
    }

    /**
     * Get fechaHoraRealizada
     *
     * @return \DateTime
     */
    public function getFechaHoraRealizada()
    {
        return $this->fechaHoraRealizada;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Reserva
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
     * Set telefono
     *
     * @param string $telefono
     *
     * @return Reserva
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
     * Set email
     *
     * @param string $email
     *
     * @return Reserva
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set numPersonas
     *
     * @param integer $numPersonas
     *
     * @return Reserva
     */
    public function setNumPersonas($numPersonas)
    {
        $this->numPersonas = $numPersonas;

        return $this;
    }

    /**
     * Get numPersonas
     *
     * @return integer
     */
    public function getNumPersonas()
    {
        return $this->numPersonas;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Reserva
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
     * @return Reserva
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
     * @return Reserva
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
     * @return Reserva
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
     * Set cliente
     *
     * @param \AppBundle\Entity\Cliente $cliente
     *
     * @return Reserva
     */
    public function setCliente(\AppBundle\Entity\Cliente $cliente = null)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return \AppBundle\Entity\Cliente
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Add mesa
     *
     * @param \AppBundle\Entity\Mesa $mesa
     *
     * @return Reserva
     */
    public function addMesa(\AppBundle\Entity\Mesa $mesa)
    {
        $this->mesa[] = $mesa;

        return $this;
    }

    /**
     * Remove mesa
     *
     * @param \AppBundle\Entity\Mesa $mesa
     */
    public function removeMesa(\AppBundle\Entity\Mesa $mesa)
    {
        $this->mesa->removeElement($mesa);
    }

    /**
     * Get mesa
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMesa()
    {
        return $this->mesa;
    }

    /**
     * Set estado
     *
     * @param \AppBundle\Entity\EstadoReserva $estado
     *
     * @return Reserva
     */
    public function setEstado(\AppBundle\Entity\EstadoReserva $estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return \AppBundle\Entity\EstadoReserva
     */
    public function getEstado()
    {
        return $this->estado;
    }
}
