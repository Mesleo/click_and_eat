<?php
// src/AppBundle/Entity/Localidad.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Localidad
 *
 * @ORM\Entity
 * @ORM\Table(name="localidad")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LocalidadRepository")
 */
class Localidad 
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
     * @ORM\Column(name="codigoPostal", type="string", length=100, nullable=false)
     */
    protected $codigoPostal;

    /**
     * @var string
     *
     * @ORM\Column(name="idComunidad", type="string")
     */
    protected $comunidad;

	/**
     * @ORM\ManyToOne(targetEntity="Provincia", inversedBy="localidades")
     * @ORM\JoinColumn(name="idProvincia", referencedColumnName="id")
     */
    protected $provincia;

    /**
     * @ORM\OneToMany(targetEntity="Restaurante", mappedBy="localidad")
     */
    private $restaurantes;

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
     * @return Localidad
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
     * Set provincia
     *
     * @param \AppBundle\Entity\Provincia $provincia
     *
     * @return Localidad
     */
    public function setProvincia(\AppBundle\Entity\Provincia $provincia = null)
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
     * Constructor
     */
    public function __construct()
    {
        $this->restaurantes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add restaurante
     *
     * @param \AppBundle\Entity\Restaurante $restaurante
     *
     * @return Localidad
     */
    public function addRestaurante(\AppBundle\Entity\Restaurante $restaurante)
    {
        $this->restaurantes[] = $restaurante;

        return $this;
    }

    /**
     * Remove restaurante
     *
     * @param \AppBundle\Entity\Restaurante $restaurante
     */
    public function removeRestaurante(\AppBundle\Entity\Restaurante $restaurante)
    {
        $this->restaurantes->removeElement($restaurante);
    }

    /**
     * Get restaurantes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRestaurantes()
    {
        return $this->restaurantes;
    }

    /**
     * Set codigoPostal
     *
     * @param string $codigoPostal
     *
     * @return Localidad
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
     * Set comunidad
     *
     * @param string $comunidad
     *
     * @return Localidad
     */
    public function setComunidad($comunidad)
    {
        $this->comunidad = $comunidad;

        return $this;
    }

    /**
     * Get comunidad
     *
     * @return string
     */
    public function getComunidad()
    {
        return $this->comunidad;
    }
}
