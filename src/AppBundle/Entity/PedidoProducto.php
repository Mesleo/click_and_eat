<?php
// src/AppBundle/Entity/Pedidoproducto.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PedidoProducto
 *
 * @ORM\Entity
 * @ORM\Table(name="pedido_producto")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PedidoProductoRepository")
 */
class PedidoProducto
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
     * @ORM\ManyToOne(targetEntity="Producto", inversedBy="pedidoProducto")
     * @ORM\JoinColumn(name="idProducto", referencedColumnName="id", nullable=false)
     */
    protected $producto;

    /**
     * @ORM\ManyToOne(targetEntity="Pedido", inversedBy="pedidoProducto")
     * @ORM\JoinColumn(name="idPedido", referencedColumnName="id", nullable=false)
     */
    protected $pedido;

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
     * @return PedidoProdcuto
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
     * @return PedidoProdcuto
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
     * @return PedidoProdcuto
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
     * @return PedidoProdcuto
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
     * @return PedidoProdcuto
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
     * Set producto
     *
     * @param \AppBundle\Entity\Producto $producto
     *
     * @return PedidoProdcuto
     */
    public function setproducto(\AppBundle\Entity\Producto $producto = null)
    {
        $this->producto = $producto;

        return $this;
    }

    /**
     * Get producto
     *
     * @return \AppBundle\Entity\Producto
     */
    public function getproducto()
    {
        return $this->producto;
    }
}
