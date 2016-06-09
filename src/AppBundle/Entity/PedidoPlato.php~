<?php
// src/AppBundle/Entity/PedidoPlato.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PedidoPlato
 *
 * @ORM\Entity
 * @ORM\Table(name="pedido_plato")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PedidoPlatoRepository")
 */
class PedidoPlato
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
     * @ORM\ManyToOne(targetEntity="Pedido", inversedBy="pedido_plato")
     * @ORM\JoinColumn(name="idPedido", referencedColumnName="id", nullable=false)
     */
    protected $pedido;

    /**
     * @ORM\ManyToOne(targetEntity="Plato", inversedBy="pedido_plato")
     * @ORM\JoinColumn(name="idPlato", referencedColumnName="id", nullable=false)
     */
    protected $plato;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidad", type="integer", nullable=false)
     */
    protected $cantidad;

    /**
     * @var float
     *
     * @ORM\Column(name="precio", type="float", nullable=false)
     */
    protected $precio;

    /**
     * @var integer
     *
     * @ORM\Column(name="descuento", type="integer", nullable=false)
     */
    protected $descuento;

    /**
     * @var float
     *
     * @ORM\Column(name="total", type="float", nullable=false)
     */
    protected $total;

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
     * Set cantidad
     *
     * @param integer $cantidad
     *
     * @return PedidoPlato
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
     * Set precio
     *
     * @param float $precio
     *
     * @return PedidoPlato
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
     * Set descuento
     *
     * @param integer $descuento
     *
     * @return PedidoPlato
     */
    public function setDescuento($descuento)
    {
        $this->descuento = $descuento;

        return $this;
    }

    /**
     * Get descuento
     *
     * @return integer
     */
    public function getDescuento()
    {
        return $this->descuento;
    }

    /**
     * Set total
     *
     * @param float $total
     *
     * @return PedidoPlato
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set pedido
     *
     * @param \AppBundle\Entity\Pedido $pedido
     *
     * @return PedidoPlato
     */
    public function setPedido(\AppBundle\Entity\Pedido $pedido = null)
    {
        $this->pedido = $pedido;

        return $this;
    }

    /**
     * Get pedido
     *
     * @return \AppBundle\Entity\Pedido
     */
    public function getPedido()
    {
        return $this->pedido;
    }

    /**
     * Set plato
     *
     * @param \AppBundle\Entity\Plato $plato
     *
     * @return PedidoPlato
     */
    public function setPlato(\AppBundle\Entity\Plato $plato = null)
    {
        $this->plato = $plato;

        return $this;
    }

    /**
     * Get plato
     *
     * @return \AppBundle\Entity\Plato
     */
    public function getPlato()
    {
        return $this->plato;
    }
}
