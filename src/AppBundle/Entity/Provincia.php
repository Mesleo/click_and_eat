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
}
