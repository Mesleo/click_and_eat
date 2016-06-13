<?php
// src/AppBundle/Entity/Pedido.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Pedido
 *
 * @ORM\Entity
 * @ORM\Table(name="pedido")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PedidoRepository")
 */
class Pedido
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
     * @ORM\Column(name="numPedido", type="string", nullable=true)
     */
    protected $numPedido;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_hora_realizado", type="datetime", nullable=false)
     */
    protected $fechaHoraRealizado;

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
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100, nullable=true)
     */
    protected $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="domicilio", type="string", length=255, nullable=true)
     */
    protected $domicilio;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=15, nullable=false)
     */
    protected $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=true)
     */
    protected $email;

    /**
     * @var boolean
     *
     * @ORM\Column(name="pagado", type="boolean", length=100, nullable=false, options={"default":false})
     */
    protected $pagado;

    /**
     * @ORM\ManyToOne(targetEntity="Estado")
     * @ORM\JoinColumn(name="estado_id", referencedColumnName="id")
     */
    protected $estado;

    /**
     * @ORM\ManyToOne(targetEntity="Restaurante", inversedBy="pedidos")
     * @ORM\JoinColumn(name="idRestaurante", referencedColumnName="id", nullable=false)
     */
    protected $restaurante;

    /**
     * @ORM\ManyToOne(targetEntity="Trabajador", inversedBy="pedidos")
     * @ORM\JoinColumn(name="idTrabajador", referencedColumnName="id", nullable=false)
     */
    protected $trabajador;

    /**
     * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="pedidos")
     * @ORM\JoinColumn(name="idCliente", referencedColumnName="id", nullable=true)
     */
    protected $cliente;

    /**
     * @ORM\OneToMany(targetEntity="PedidoProducto", mappedBy="pedido")
     */
    protected $pedido_producto;

    /**
     * @ORM\OneToOne(targetEntity="Ticket", mappedBy="pedido")
     */
    protected $ticket;

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
        $this->pedido_producto = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set numPedido
     *
     * @param integer $numPedido
     *
     * @return Pedido
     */
    public function setNumPedido($numPedido)
    {
        $this->numPedido = $numPedido;

        return $this;
    }

    /**
     * Get numPedido
     *
     * @return integer
     */
    public function getNumPedido()
    {
        return $this->numPedido;
    }

    /**
     * Set fechaHoraSalida
     *
     * @param \DateTime $fechaHoraSalida
     *
     * @return Pedido
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
     * @return Pedido
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Pedido
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
     * Set domicilio
     *
     * @param string $domicilio
     *
     * @return Pedido
     */
    public function setDomicilio($domicilio)
    {
        $this->domicilio = $domicilio;

        return $this;
    }

    /**
     * Get domicilio
     *
     * @return string
     */
    public function getDomicilio()
    {
        return $this->domicilio;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     *
     * @return Pedido
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
     * @return Pedido
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
     * Set estado
     *
     * @param string $estado
     *
     * @return Pedido
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Pedido
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
     * @return Pedido
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
     * @return Pedido
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
     * @return Pedido
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
     * @return Pedido
     */
    public function setCliente(\AppBundle\Entity\Cliente $cliente)
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
     * Set trabajador
     *
     * @param \AppBundle\Entity\Trabajador $trabajador
     *
     * @return Pedido
     */
    public function setTrabajador(\AppBundle\Entity\Trabajador $trabajador)
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
     * Add pedidoProducto
     *
     * @param \AppBundle\Entity\PedidoProducto $pedidoProducto
     *
     * @return Pedido
     */
    public function addPedidoProducto(\AppBundle\Entity\PedidoProducto $pedidoProducto)
    {
        $this->pedido_producto[] = $pedidoProducto;

        return $this;
    }

    /**
     * Remove pedidoProducto
     *
     * @param \AppBundle\Entity\PedidoProducto $pedidoProducto
     */
    public function removePedidoProducto(\AppBundle\Entity\PedidoProducto $pedidoProducto)
    {
        $this->pedido_producto->removeElement($pedidoProducto);
    }

    /**
     * Get pedidoProducto
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPedidoProducto()
    {
        return $this->pedido_producto;
    }

    /**
     * Set ticket
     *
     * @param \AppBundle\Entity\Ticket $ticket
     *
     * @return Pedido
     */
    public function setTicket(\AppBundle\Entity\Ticket $ticket = null)
    {
        $this->ticket = $ticket;

        return $this;
    }

    /**
     * Get ticket
     *
     * @return \AppBundle\Entity\Ticket
     */
    public function getTicket()
    {
        return $this->ticket;
    }
}
