<?php
// src/AppBundle/Entity/Provincia.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Provincia
 *
 * @ORM\Entity
 * @ORM\Table(name="provincia")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProvinciaRepository")
 */
class Provincia 
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
     * @ORM\OneToMany(targetEntity="Localidad", mappedBy="provincia")
     */
    protected $localidades;

    /**
     * @ORM\OneToMany(targetEntity="Restaurante", mappedBy="provincia")
     */
    protected $restaurantes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->localidades = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Provincia
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
     * Add localidade
     *
     * @param \AppBundle\Entity\Localidad $localidade
     *
     * @return Provincia
     */
    public function addLocalidade(\AppBundle\Entity\Localidad $localidade)
    {
        $this->localidades[] = $localidade;

        return $this;
    }

    /**
     * Remove localidade
     *
     * @param \AppBundle\Entity\Localidad $localidade
     */
    public function removeLocalidade(\AppBundle\Entity\Localidad $localidade)
    {
        $this->localidades->removeElement($localidade);
    }

    /**
     * Get localidades
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLocalidades()
    {
        return $this->localidades;
    }

    /**
     * Add provincium
     *
     * @param \AppBundle\Entity\Restaurante $provincium
     *
     * @return Provincia
     */
    public function addProvincium(\AppBundle\Entity\Restaurante $provincium)
    {
        $this->provincia[] = $provincium;

        return $this;
    }

    /**
     * Remove provincium
     *
     * @param \AppBundle\Entity\Restaurante $provincium
     */
    public function removeProvincium(\AppBundle\Entity\Restaurante $provincium)
    {
        $this->provincia->removeElement($provincium);
    }

    /**
     * Get provincia
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * Add restaurante
     *
     * @param \AppBundle\Entity\Restaurante $restaurante
     *
     * @return Provincia
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
}
