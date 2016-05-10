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
 */
class Pedido
{

    const STATUS_ESPERA_PAGO = 'espera de pago';
    const STATUS_PAGO = 'pagado';
    const STATUS_CANCELADO = 'cancelado';
    const STATUS_EN_CURSO = 'en curso';
    const STATUS_ENTREGADO = 'entregado';
    const STATUS_REEMBOLSADO = 'reembolsado';
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_hora_salida", type="datetime", nullable=false)
     */
    protected $fechaHoraSalida;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_hora_llegada", type="datetime", nullable=false)
     */
    protected $fechaHoraLlegada;

    /**
     * @var integer
     *
     * @ORM\Column(name="numPedido", type="integer", nullable=false)
     */
    protected $numPedido;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="domicilio", type="string", length=255, nullable=false)
     */
    protected $domicilio;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=100)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string")
     */
    protected $estado;

    /**
     * @ORM\ManyToOne(targetEntity="Restaurante", inversedBy="pedidos")
     * @ORM\JoinColumn(name="restaurante_id", referencedColumnName="id")
     */
    protected $restaurante;

    /**
     * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="pedidos")
     * @ORM\JoinColumn(name="idCliente", referencedColumnName="id")
     */
    protected $cliente;

    /**
     * @ORM\ManyToOne(targetEntity="Trabajador", inversedBy="pedidos")
     * @ORM\JoinColumn(name="idTrabajador", referencedColumnName="id")
     */
    protected $trabajador;

    /**
     * @ORM\ManyToMany(targetEntity="Producto")
     * @ORM\JoinTable(name="pedido_producto",
     *      joinColumns={@ORM\JoinColumn(name="pedido_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="producto_id", referencedColumnName="id")}
     *      )
     */
    private $pedido_producto;

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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Pedido
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
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
     * Set estado
     *
     * @param boolean $estado
     *
     * @return Pedido
     */
    public function setEstado($estado)
    {
        if (!in_array($estado, array(self::STATUS_REEMBOLSADO, self::STATUS_PAGO, self::STATUS_CANCELADO, self::STATUS_ESPERA_PAGO,
            self::STATUS_EN_CURSO, self::STATUS_ENTREGADO))) {
            throw new \InvalidArgumentException("Estado inválido");
        }
        $this->estado = $estado;
        return $this;
    }

    /**
     * Get estado
     *
     * @return boolean
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set restaurante
     *
     * @param \AppBundle\Entity\Restaurante $restaurante
     *
     * @return Pedido
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
     * Set cliente
     *
     * @param \AppBundle\Entity\Cliente $cliente
     *
     * @return Pedido
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
     * Set trabajador
     *
     * @param \AppBundle\Entity\Trabajador $trabajador
     *
     * @return Pedido
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
     * Constructor
     */
    public function __construct()
    {
        $this->pedido_producto = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add pedidoProducto
     *
     * @param \AppBundle\Entity\Producto $pedidoProducto
     *
     * @return Pedido
     */
    public function addPedidoProducto(\AppBundle\Entity\Producto $pedidoProducto)
    {
        $this->pedido_producto[] = $pedidoProducto;

        return $this;
    }

    /**
     * Remove pedidoProducto
     *
     * @param \AppBundle\Entity\Producto $pedidoProducto
     */
    public function removePedidoProducto(\AppBundle\Entity\Producto $pedidoProducto)
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
     * Set fechaSalida
     *
     * @param \DateTime $fechaSalida
     *
     * @return Pedido
     */
    public function setFechaSalida($fechaSalida)
    {
        $this->fechaSalida = $fechaSalida;

        return $this;
    }

    /**
     * Get fechaSalida
     *
     * @return \DateTime
     */
    public function getFechaSalida()
    {
        return $this->fechaSalida;
    }

    /**
     * Set fechaLlegada
     *
     * @param \DateTime $fechaLlegada
     *
     * @return Pedido
     */
    public function setFechaLlegada($fechaLlegada)
    {
        $this->fechaLlegada = $fechaLlegada;

        return $this;
    }

    /**
     * Get fechaLlegada
     *
     * @return \DateTime
     */
    public function getFechaLlegada()
    {
        return $this->fechaLlegada;
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
}
