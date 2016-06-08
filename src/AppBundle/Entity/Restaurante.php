<?php
// src/AppBundle/Entity/Restaurante.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Restaurante
 *
 * @ORM\Entity
 * @ORM\Table(name="restaurante")
 * @UniqueEntity(
 *     fields={"cif"},
 *     message="Ese CIF ya ha sido registrado."
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RestauranteRepository")
 */
class Restaurante
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
     * @ORM\Column(name="cif", type="string", length=9, unique=true, nullable=false)
	 * @Assert\NotBlank(message="Por favor introduce el CIF.")
     * @Assert\Type(
     *     type="string",
     *     message="Este valor debería contener una letra seguida de 7 dígitos y una letra al final"
     * )
     * @Assert\Length(min=9, max=9)
     */
    protected $cif;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255, nullable=false)
     */
    protected $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="coordenadas", type="string", length=100, nullable=false)
     */
    protected $coordenadas;

    /**
     * @ORM\ManyToOne(targetEntity="Localidad", inversedBy="restaurantes")
     * @ORM\JoinColumn(name="idLocalidad", referencedColumnName="id", nullable=false)
     */
    protected $localidad;

    /**
     * @ORM\ManyToOne(targetEntity="Provincia",  inversedBy="restaurantes")
     * @ORM\JoinColumn(name="idProvincia", referencedColumnName="id", nullable=false)
     */
    protected $provincia;

    /**
     * @var UploadedFile
     */
    protected $img;

    /**
     * @var string
     *
     * @ORM\Column(name="foto", type="string", length=255, nullable=true)
     */
    protected $foto;

    /**
     * @ORM\ManyToMany(targetEntity="TipoComida", inversedBy="restaurantes")
     * @ORM\JoinTable(name="restaurante_tipo_comida",
     *      joinColumns={@ORM\JoinColumn(name="idRestaurante", referencedColumnName="id", nullable=false)},
     *      inverseJoinColumns={@ORM\JoinColumn(name="idTipoComida", referencedColumnName="id", nullable=false)}
     *      )
     */
    protected $tipoComida;

    /**
     * @var decimal
     *
     * @ORM\Column(name="precio_envio", type="decimal", nullable=false, options={"default":"0.0"})
     * @Assert\Type(
     *     type="decimal",
     *     message="Este valor debe ser un número"
     * )
     */
    protected $precio_envio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_alta", type="datetime", nullable=false)
     */
    protected $fecha_alta;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_baja", type="datetime", nullable=true)
     */
    protected $fecha_baja;

    /**
     * @ORM\OneToMany(targetEntity="Horario", mappedBy="restaurante")
     */
    protected $horarios;

    /**
     * @ORM\OneToMany(targetEntity="Comentario", mappedBy="restaurante")
     */
    protected $comentarios;

    /**
     * @ORM\OneToMany(targetEntity="Mesa", mappedBy="restaurante")
     */
    protected $mesas;

    /**
     * @ORM\OneToMany(targetEntity="Pedido", mappedBy="restaurante")
     */
    protected $pedidos;

    /**
     * @ORM\OneToMany(targetEntity="Producto", mappedBy="restaurante",  cascade={"persist"})
     */
    protected $productos;

    /**
     * @ORM\OneToMany(targetEntity="Reserva", mappedBy="restaurante")
     */
    protected $reservas;

    /**
     * @ORM\OneToMany(targetEntity="Trabajador", mappedBy="restaurante")
     */
    protected $trabajadores;

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
        $this->tipoComida = new \Doctrine\Common\Collections\ArrayCollection();
        $this->horarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->comentarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->mesas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->pedidos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->productos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->reservas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->trabajadores = new \Doctrine\Common\Collections\ArrayCollection();

        $this->setFechaAlta(new \DateTime());
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
     * Set name
     *
     * @param string $name
     *
     * @return Restaurante
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
     * Set cif
     *
     * @param string $cif
     *
     * @return Restaurante
     */
    public function setCif($cif)
    {
        $this->cif = $cif;

        return $this;
    }

    /**
     * Get cif
     *
     * @return string
     */
    public function getCif()
    {
        return $this->cif;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     *
     * @return Restaurante
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set coordenadas
     *
     * @param string $coordenadas
     *
     * @return Restaurante
     */
    public function setCoordenadas($coordenadas)
    {
        $this->coordenadas = $coordenadas;

        return $this;
    }

    /**
     * Get coordenadas
     *
     * @return string
     */
    public function getCoordenadas()
    {
        return $this->coordenadas;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     *
     * @return Restaurante
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
     * Set foto
     *
     * @param string $foto
     *
     * @return Restaurante
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
        $destiny = __DIR__.'/../../../web/uploads/restaurantes/images/';
        $nameImg = $this->cif.'image.'.$this->img->getClientOriginalExtension();
        $this->img->move($destiny, $nameImg);
        $this->setFoto($nameImg);
    }

    /**
     * Set precioEnvio
     *
     * @param decimal $precioEnvio
     *
     * @return Restaurante
     */
    public function setPrecioEnvio($precioEnvio)
    {
        $this->precio_envio = $precioEnvio;

        return $this;
    }

    /**
     * Get precioEnvio
     *
     * @return decimal
     */
    public function getPrecioEnvio()
    {
        return $this->precio_envio;
    }

    /**
     * Set fechaAlta
     *
     * @param \DateTime $fechaAlta
     *
     * @return Restaurante
     */
    public function setFechaAlta($fechaAlta)
    {
        $this->fecha_alta = $fechaAlta;

        return $this;
    }

    /**
     * Get fechaAlta
     *
     * @return \DateTime
     */
    public function getFechaAlta()
    {
        return $this->fecha_alta;
    }

    /**
     * Set fechaBaja
     *
     * @param \DateTime $fechaBaja
     *
     * @return Restaurante
     */
    public function setFechaBaja($fechaBaja)
    {
        $this->fecha_baja = $fechaBaja;

        return $this;
    }

    /**
     * Get fechaBaja
     *
     * @return \DateTime
     */
    public function getFechaBaja()
    {
        return $this->fecha_baja;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Restaurante
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
     * @return Restaurante
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
     * @return Restaurante
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
     * Set localidad
     *
     * @param \AppBundle\Entity\Localidad $localidad
     *
     * @return Restaurante
     */
    public function setLocalidad(\AppBundle\Entity\Localidad $localidad)
    {
        $this->localidad = $localidad;

        return $this;
    }

    /**
     * Get localidad
     *
     * @return \AppBundle\Entity\Localidad
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }
	
	/**
     * Set provincia
     *
     * @param \AppBundle\Entity\Provincia $provincia
     *
     * @return Restaurante
     */
    public function setProvincia(\AppBundle\Entity\Provincia $provincia)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia
     *
     * @return \AppBundle\Entity\Provincia
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * Add tipoComida
     *
     * @param \AppBundle\Entity\TipoComida $tipoComida
     *
     * @return Restaurante
     */
    public function addTipoComida(\AppBundle\Entity\TipoComida $tipoComida)
    {
        $this->tipoComida[] = $tipoComida;

        return $this;
    }

    /**
     * Remove tipoComida
     *
     * @param \AppBundle\Entity\TipoComida $tipoComida
     */
    public function removeTipoComida(\AppBundle\Entity\TipoComida $tipoComida)
    {
        $this->tipoComida->removeElement($tipoComida);
    }

    /**
     * Get tipoComida
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTipoComida()
    {
        return $this->tipoComida;
    }

    /**
     * Add horario
     *
     * @param \AppBundle\Entity\Horario $horario
     *
     * @return Restaurante
     */
    public function addHorario(\AppBundle\Entity\Horario $horario)
    {
        $this->horarios[] = $horario;

        return $this;
    }

    /**
     * Remove horario
     *
     * @param \AppBundle\Entity\Horario $horario
     */
    public function removeHorario(\AppBundle\Entity\Horario $horario)
    {
        $this->horarios->removeElement($horario);
    }

    /**
     * Get horarios
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHorarios()
    {
        return $this->horarios;
    }

    /**
     * Add comentario
     *
     * @param \AppBundle\Entity\Comentario $comentario
     *
     * @return Restaurante
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
     * Add mesa
     *
     * @param \AppBundle\Entity\Mesa $mesa
     *
     * @return Restaurante
     */
    public function addMesa(\AppBundle\Entity\Mesa $mesa)
    {
        $this->mesas[] = $mesa;

        return $this;
    }

    /**
     * Remove mesa
     *
     * @param \AppBundle\Entity\Mesa $mesa
     */
    public function removeMesa(\AppBundle\Entity\Mesa $mesa)
    {
        $this->mesas->removeElement($mesa);
    }

    /**
     * Get mesas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMesas()
    {
        return $this->mesas;
    }

    /**
     * Add pedido
     *
     * @param \AppBundle\Entity\Pedido $pedido
     *
     * @return Restaurante
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
     * Add producto
     *
     * @param \AppBundle\Entity\Producto $producto
     *
     * @return Restaurante
     */
    public function addProducto(\AppBundle\Entity\Producto $producto)
    {
        $this->productos[] = $producto;

        return $this;
    }

    /**
     * Remove producto
     *
     * @param \AppBundle\Entity\Producto $producto
     */
    public function removeProducto(\AppBundle\Entity\Producto $producto)
    {
        $this->productos->removeElement($producto);
    }

    /**
     * Get productos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductos()
    {
        return $this->productos;
    }

    /**
     * Add reserva
     *
     * @param \AppBundle\Entity\Reserva $reserva
     *
     * @return Restaurante
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
     * Add trabajadore
     *
     * @param \AppBundle\Entity\Trabajador $trabajadore
     *
     * @return Restaurante
     */
    public function addTrabajadore(\AppBundle\Entity\Trabajador $trabajadore)
    {
        $this->trabajadores[] = $trabajadore;

        return $this;
    }

    /**
     * Remove trabajadore
     *
     * @param \AppBundle\Entity\Trabajador $trabajadore
     */
    public function removeTrabajadore(\AppBundle\Entity\Trabajador $trabajadore)
    {
        $this->trabajadores->removeElement($trabajadore);
    }

    /**
     * Get trabajadores
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTrabajadores()
    {
        return $this->trabajadores;
    }

	/**
     * Set typeUser
     *
     * @param integer $typeUser
     *
     * @return Restaurante
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
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->username;
    }

	/**
     * Returns the password used to authenticate the user.
     *
     * @return string The password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }
}
