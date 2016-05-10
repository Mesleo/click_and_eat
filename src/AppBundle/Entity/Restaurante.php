<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * Restaurante
 *
 * @ORM\Entity
 * @ORM\Table(name="restaurante")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RestauranteRepository")
 */
class Restaurante extends BaseUser
{

    const QUESTION_1 = 'Nombre de tu primera mascota';
    const QUESTION_2 = 'Nombre de tu primer colegio';
    const QUESTION_3 = 'Nombre del mejor amigo de tu infancia';
    const QUESTION_4 = 'Superhéroe favorito';
    const QUESTION_5 = 'Tu color favorito';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
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
     * @ORM\Column(name="email_2", type="string", length=100)
     */
    protected $email_2;

    /**
     * @var string
     *
     * @ORM\Column(name="cif", type="string", length=9, nullable=false)
     */
    protected $cif;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono_1", type="string", nullable=false)
     */
    protected $telefono1;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono_2", type="string")
     */
    protected $telefono2;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255, nullable=false)
     */
    protected $direccion;

    /**
     * @ORM\ManyToOne(targetEntity="Localidad", inversedBy="localidades")
     * @ORM\JoinColumn(name="idLocalidad", referencedColumnName="id")
     */
    protected $localidad;


    /**
     * @var integer
     *
     * @ORM\Column(name="codigo_postal", type="string", length=100, nullable=false)
     */
    protected $codigoPostal;

    /**
     * @var string
     *
     * @ORM\Column(name="coordenadas", type="string", length=100)
     */
    protected $coordenadas;

    /**
     * @ORM\ManyToMany(targetEntity="TipoComida")
     * @ORM\JoinTable(name="restaurante_tipo_comida",
     *      joinColumns={@ORM\JoinColumn(name="restaurante_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tipo_comida_id", referencedColumnName="id")}
     *      )
     */
    protected $tipo_comida;

    /**
     * @var blob
     *
     *  @ORM\Column(name="mapa", type="blob", length=100)
     */
    protected $mapa;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_alta", type="datetime",  nullable=false)
     */
    protected $fecha_alta;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_baja", type="datetime",  nullable=false)
     */
    protected $fecha_baja;

    /**
     * @var float
     *
     * @ORM\Column(name="envio", type="float", nullable=false, options={"default" = "0.0"})
     */
    protected $envio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_nacimiento", type="datetime")
     */
    protected $fechaNacimiento;

    /**
     * @var string
     *
     * @ORM\Column(name="question_security", type="string", nullable=false)
     */
    protected $questionSecurity;

    /**
     * @var string
     *
     * @ORM\Column(name="answer_security", type="string", nullable=false)
     */
    protected $answerSecurity;

    /**
     * @ORM\ManyToMany(targetEntity="Horario")
     * @ORM\JoinTable(name="horario_restaurante",
     *      joinColumns={@ORM\JoinColumn(name="restaurante_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="horario_id", referencedColumnName="id")}
     *      )
     */
    protected $horario;

    /**
     * @ORM\OneToMany(targetEntity="Mesa", mappedBy="idRestaurante")
     */
    protected $mesas;

    /**
     * @ORM\OneToMany(targetEntity="Comentario", mappedBy="idRestaurante")
     */
    protected $comentarios;

    /**
     * @ORM\OneToMany(targetEntity="Producto", mappedBy="idRestaurante")
     */
    protected $productos;

    /**
     * @ORM\OneToMany(targetEntity="Trabajador", mappedBy="idRestaurante")
     */
    protected $trabajadores;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime",  nullable=false)
     */
    protected $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime",  nullable=false)
     */
    protected $updated;

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
        $this->fecha_alta = new \DateTime();
        $this->tipo_comida = new \Doctrine\Common\Collections\ArrayCollection();
        $this->horario = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Restaurante
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
     * Set mapa
     *
     * @param string $mapa
     *
     * @return Restaurante
     */
    public function setMapa($mapa)
    {
        $this->mapa = $mapa;

        return $this;
    }

    /**
     * Get mapa
     *
     * @return string
     */
    public function getMapa()
    {
        return $this->mapa;
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
     * Set envio
     *
     * @param float $envio
     *
     * @return Restaurante
     */
    public function setEnvio($envio)
    {
        $this->envio = $envio;

        return $this;
    }

    /**
     * Get envio
     *
     * @return float
     */
    public function getEnvio()
    {
        return $this->envio;
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
        $this->tipo_comida[] = $tipoComida;

        return $this;
    }

    /**
     * Remove tipoComida
     *
     * @param \AppBundle\Entity\TipoComida $tipoComida
     */
    public function removeTipoComida(\AppBundle\Entity\TipoComida $tipoComida)
    {
        $this->tipo_comida->removeElement($tipoComida);
    }

    /**
     * Get tipoComida
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTipoComida()
    {
        return $this->tipo_comida;
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
        $this->horario[] = $horario;

        return $this;
    }

    /**
     * Remove horario
     *
     * @param \AppBundle\Entity\Horario $horario
     */
    public function removeHorario(\AppBundle\Entity\Horario $horario)
    {
        $this->horario->removeElement($horario);
    }

    /**
     * Get horario
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHorario()
    {
        return $this->horario;
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
     * Set telefono1
     *
     * @param string $telefono1
     *
     * @return Restaurante
     */
    public function setTelefono1($telefono1)
    {
        $this->telefono1 = $telefono1;

        return $this;
    }

    /**
     * Get telefono1
     *
     * @return string
     */
    public function getTelefono1()
    {
        return $this->telefono1;
    }

    /**
     * Set telefono2
     *
     * @param string $telefono2
     *
     * @return Restaurante
     */
    public function setTelefono2($telefono2)
    {
        $this->telefono2 = $telefono2;

        return $this;
    }

    /**
     * Get telefono2
     *
     * @return string
     */
    public function getTelefono2()
    {
        return $this->telefono2;
    }

    /**
     * Set codigoPostal
     *
     * @param string $codigoPostal
     *
     * @return Restaurante
     */
    public function setCodigoPostal($codigoPostal)
    {
        $this->codigoPostal = $codigoPostal;

        return $this;
    }

    /**
     * Get codigoPostal
     *
     * @return string
     */
    public function getCodigoPostal()
    {
        return $this->codigoPostal;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Restaurante
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Restaurante
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set localidad
     *
     * @param \AppBundle\Entity\Localidad $localidad
     *
     * @return Restaurante
     */
    public function setLocalidad(\AppBundle\Entity\Localidad $localidad = null)
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
     * Set fechaNacimiento
     *
     * @param \DateTime $fechaNacimiento
     *
     * @return Restaurante
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    /**
     * Get fechaNacimiento
     *
     * @return \DateTime
     */
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    /**
     * Set questionSecurity
     *
     * @param string $questionSecurity
     *
     * @return Restaurante
     */
    public function setQuestionSecurity($questionSecurity)
    {
        $this->questionSecurity = $questionSecurity;

        return $this;
    }

    /**
     * Get questionSecurity
     *
     * @return string
     */
    public function getQuestionSecurity()
    {
        return $this->questionSecurity;
    }

    /**
     * Set answerSecurity
     *
     * @param string $answerSecurity
     *
     * @return Restaurante
     */
    public function setAnswerSecurity($answerSecurity)
    {
        $this->answerSecurity = $answerSecurity;

        return $this;
    }

    /**
     * Get answerSecurity
     *
     * @return string
     */
    public function getAnswerSecurity()
    {
        return $this->answerSecurity;
    }

    /**
     * Set email2
     *
     * @param string $email2
     *
     * @return Restaurante
     */
    public function setEmail2($email2)
    {
        $this->email_2 = $email2;

        return $this;
    }

    /**
     * Get email2
     *
     * @return string
     */
    public function getEmail2()
    {
        return $this->email_2;
    }
}
