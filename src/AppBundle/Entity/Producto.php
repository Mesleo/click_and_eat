<?php
// src/AppBundle/Entity/Producto.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Producto
 *
 * @ORM\Entity
 * @ORM\Table(name="producto")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductoRepository")
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
     * @var decimal
     *
     * @ORM\Column(name="precio", type="decimal", precision=10, scale=2, nullable=false, options={"default":"0.00"})
     */
    protected $precio;
	
	/**
     * @var UploadedFile
     */
    protected $img;

    /**
     * @var string
     *
     * @ORM\Column(name="foto", type="string", length=255, nullable=false)
     */
    protected $foto;
	
	/**
     * @ORM\ManyToMany(targetEntity="TipoProducto", inversedBy="productos")
     * @ORM\JoinTable(name="producto_tipo_producto",
     *      joinColumns={@ORM\JoinColumn(name="idProducto", referencedColumnName="id", nullable=false)},
     *      inverseJoinColumns={@ORM\JoinColumn(name="idTipoProducto", referencedColumnName="id", nullable=false)}
     *      )
     */
    protected $tipoProducto;

    /**
     * @var boolean 
     *
     * @ORM\Column(name="disponible", type="boolean", options={"default":1})
     */
    protected $disponible;

    /**
     * @ORM\ManyToOne(targetEntity="Restaurante", inversedBy="productos")
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
     * @ORM\OneToMany(targetEntity="PedidoProducto", mappedBy="producto")
     */
    protected $pedido_producto;
    
    /**
     * Constructor
     */
    public function __construct()
    {
		$this->tipoProducto = new \Doctrine\Common\Collections\ArrayCollection();
        $this->pedido_producto = new \Doctrine\Common\Collections\ArrayCollection();
		
		$this->setDisponible(true);
		
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Producto
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
     * @return Producto
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
     * @param decimal $precio
     *
     * @return Producto
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get precio
     *
     * @return decimal
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
     * @return Producto
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
     * @param mixed $img
     */
    public function setImg(UploadedFile $img)
    {
        $this->img = $img;
    }

    /**
     * @return mixed
     */
    public function getImg()
    {
        return $this->img;
    }

    public function uploadImg()
	{
        if (null === $this->img) {
            return;
        }
        $destiny = __DIR__.'/../../../web/uploads/restaurantes/productos/';
        $nameImg = $this->id.'.'.$this->img->getClientOriginalExtension();
        $this->img->move($destiny, $nameImg);
        $this->setFoto($nameImg);
    }

    /**
     * Set disponible
     *
     * @param boolean $disponible
     *
     * @return Producto
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

    /**
     * Set restaurante
     *
     * @param \AppBundle\Entity\Restaurante $restaurante
     *
     * @return Producto
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
     * Add pedidoProducto
     *
     * @param \AppBundle\Entity\PedidoProducto $pedidoProducto
     *
     * @return Producto
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
     * Add tipoProducto
     *
     * @param \AppBundle\Entity\TipoProducto $tipoProducto
     *
     * @return Producto
     */
    public function addTipoProducto(\AppBundle\Entity\TipoProducto $tipoProducto)
    {
        $this->tipoProducto[] = $tipoProducto;

        return $this;
    }

    /**
     * Remove tipoProducto
     *
     * @param \AppBundle\Entity\TipoProducto $tipoProducto
     */
    public function removeTipoProducto(\AppBundle\Entity\TipoProducto $tipoProducto)
    {
        $this->tipoProducto->removeElement($tipoProducto);
    }

    /**
     * Get tipoProducto
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTipoProducto()
    {
        return $this->tipoProducto;
    }
}
