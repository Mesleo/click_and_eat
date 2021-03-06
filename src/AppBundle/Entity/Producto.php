<?php
// src/AppBundle/Entity/Producto.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Producto
 *
 * @ORM\Entity
 * @ORM\Table(name="producto")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductoRepository")
 */
class Producto{

    const TIPO_ENTRANTE = 'Entrante';
    const TIPO_HAMBURGUESA = 'Hamburguesa';
    const TIPO_SANDWICHES = 'Sandwich';
    const TIPO_BOCADILLO = 'Bocadillo';
    const TIPO_MONTADO = 'Montado';
    const TIPO_PLATO_COMBINADO = 'Plato combinado';
    const TIPO_CARNES = 'Carne';
    const TIPO_PESCADOS = 'Pescado';
    const TIPO_ENSALADAS = 'Ensalada';
    const TIPO_KEBAB = 'Kebab';
    const TIPO_DURUM = 'Durum';
    const TIPO_FALAFEL = 'Falafel';
    const TIPO_ARROCES = 'Arroz';
    const TIPO_PASTA = 'Pasta';
    const TIPO_SOPAS = 'Sopa';
    const TIPO_REVUELTOS = 'Revuelto';
    const TIPO_PIZZAS = 'Pizza';

    const TIPO_REFRESCOS = 'Refresco';
    const TIPO_CERVEZAS = 'Cerveza';
    const TIPO_VINOS = 'Vino';
    const TIPO_OTRO = 'Otro';

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
     * @ORM\Column(name="foto", type="string", length=255, nullable=true)
     */
    protected $foto;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=255)
     */
    protected $tipo;

    /**
     * @var boolean 
     *
     * @ORM\Column(name="disponible", type="boolean", options={"default":1})
     */
    protected $disponible;

    /**
     * @ORM\ManyToOne(targetEntity="Restaurante", inversedBy="productos",  cascade={"persist"})
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
    protected $pedidoProducto;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pedidoProducto = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param float $precio
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
        $this->pedidoProducto[] = $pedidoProducto;

        return $this;
    }

    /**
     * Remove pedidoProducto
     *
     * @param \AppBundle\Entity\PedidoProducto $pedidoProducto
     */
    public function removePedidoProducto(\AppBundle\Entity\PedidoProducto $pedidoProducto)
    {
        $this->pedidoProducto->removeElement($pedidoProducto);
    }

    /**
     * Get pedidoProducto
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPedidoProducto()
    {
        return $this->pedidoProducto;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     *
     * @return Producto
     */
    public function setTipo($tipo)
    {
//        if (!in_array($tipo, array(self::TIPO_ARROCES, self::TIPO_CARNES, self::TIPO_CERVEZAS, self::TIPO_DURUM,
//            self::TIPO_ENSALADAS, self::TIPO_ENTRANTE, self::TIPO_FALAFEL, self::TIPO_KEBAB, self::TIPO_HAMBURGUESA,
//            self::TIPO_PASTA, self::TIPO_PESCADOS, self::TIPO_PLATO_COMBINADO, self::TIPO_PESCADOS, self::TIPO_OTRO,
//            self::TIPO_REVUELTOS, self::TIPO_REFRESCOS, self::TIPO_SANDWICHES, self::TIPO_SOPAS, self::TIPO_VINOS),
//            self::TIPO_BOCADILLO, self::TIPO_MONTADO)) {
//            throw new \InvalidArgumentException("Tipo de producto inválido");
//        }
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }
}
