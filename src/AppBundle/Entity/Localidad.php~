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
     * @var integer
     *
     * @ORM\Column(name="codigo_postal", type="integer", nullable=false)
     */
    protected $codigoPostal;

    /**
     * @var integer
     *
     * @ORM\Column(name="codigo_municipio", type="integer", nullable=false)
     */
    protected $codigoMunicipio;

	/**
     * @ORM\ManyToOne(targetEntity="Provincia", inversedBy="localidades")
     * @ORM\JoinColumn(name="idProvincia", referencedColumnName="id", nullable=false)
     */
    protected $provincia;

    /**
     * @ORM\OneToMany(targetEntity="Domicilio", mappedBy="localidad")
     */
	protected $domicilios;

    /**
     * @ORM\OneToMany(targetEntity="Restaurante", mappedBy="localidad")
     */
    protected $restaurantes;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->domicilios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->restaurantes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set codigoPostal
     *
     * @param integer $codigoPostal
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
     * @return integer
     */
    public function getCodigoPostal()
    {
        return $this->codigoPostal;
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
     * Add domicilio
     *
     * @param \AppBundle\Entity\Domicilio $domicilio
     *
     * @return Localidad
     */
    public function addDomicilio(\AppBundle\Entity\Domicilio $domicilio)
    {
        $this->domicilios[] = $domicilio;

        return $this;
    }

    /**
     * Remove domicilio
     *
     * @param \AppBundle\Entity\Domicilio $domicilio
     */
    public function removeDomicilio(\AppBundle\Entity\Domicilio $domicilio)
    {
        $this->domicilios->removeElement($domicilio);
    }

    /**
     * Get domicilios
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDomicilios()
    {
        return $this->domicilios;
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

    public function __toString()
    {
        return $this->getNombre();
    }

    /**
     * Set codigoMunicipio
     *
     * @param integer $codigoMunicipio
     *
     * @return Localidad
     */
    public function setCodigoMunicipio($codigoMunicipio)
    {
        $this->codigoMunicipio = $codigoMunicipio;

        return $this;
    }

    /**
     * Get codigoMunicipio
     *
     * @return integer
     */
    public function getCodigoMunicipio()
    {
        return $this->codigoMunicipio;
    }
}
