<?php
// src/AppBundle/Entity/Horario.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Horario
 *
 * @ORM\Entity
 * @ORM\Table(name="horario")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HorarioRepository")
 */
class Horario
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
     * @var \DateTime
     *
     * @ORM\Column(name="horario_apertura_local", type="datetime", nullable=false)
     */
    protected $horario_apertura_local;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horario_cierre_local", type="datetime", nullable=false)
     */
    protected $horario_cierre_local;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horario_apertura_domicilio", type="datetime", nullable=false)
     */
    protected $horario_apertura_domicilio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horario_cierre_domicilio", type="datetime", nullable=false)
     */
    protected $horario_cierre_domicilio;

    /**
     * @var boolean 
     *
     * @ORM\Column(name="trash", type="boolean", options={"default":0})
     */
    protected $trash;

    /**
     * @ORM\ManyToMany(targetEntity="Restaurante", mappedBy="horarios")
     */
    protected $restaurantes;
    /**
     * Constructor
     */
    public function __construct()
    {
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
     * Set horarioAperturaLocal
     *
     * @param \DateTime $horarioAperturaLocal
     *
     * @return Horario
     */
    public function setHorarioAperturaLocal($horarioAperturaLocal)
    {
        $this->horario_apertura_local = $horarioAperturaLocal;

        return $this;
    }

    /**
     * Get horarioAperturaLocal
     *
     * @return \DateTime
     */
    public function getHorarioAperturaLocal()
    {
        return $this->horario_apertura_local;
    }

    /**
     * Set horarioCierreLocal
     *
     * @param \DateTime $horarioCierreLocal
     *
     * @return Horario
     */
    public function setHorarioCierreLocal($horarioCierreLocal)
    {
        $this->horario_cierre_local = $horarioCierreLocal;

        return $this;
    }

    /**
     * Get horarioCierreLocal
     *
     * @return \DateTime
     */
    public function getHorarioCierreLocal()
    {
        return $this->horario_cierre_local;
    }

    /**
     * Set horarioAperturaDomicilio
     *
     * @param \DateTime $horarioAperturaDomicilio
     *
     * @return Horario
     */
    public function setHorarioAperturaDomicilio($horarioAperturaDomicilio)
    {
        $this->horario_apertura_domicilio = $horarioAperturaDomicilio;

        return $this;
    }

    /**
     * Get horarioAperturaDomicilio
     *
     * @return \DateTime
     */
    public function getHorarioAperturaDomicilio()
    {
        return $this->horario_apertura_domicilio;
    }

    /**
     * Set horarioCierreDomicilio
     *
     * @param \DateTime $horarioCierreDomicilio
     *
     * @return Horario
     */
    public function setHorarioCierreDomicilio($horarioCierreDomicilio)
    {
        $this->horario_cierre_domicilio = $horarioCierreDomicilio;

        return $this;
    }

    /**
     * Get horarioCierreDomicilio
     *
     * @return \DateTime
     */
    public function getHorarioCierreDomicilio()
    {
        return $this->horario_cierre_domicilio;
    }

    /**
     * Set trash
     *
     * @param boolean $trash
     *
     * @return Horario
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
     * Add restaurante
     *
     * @param \AppBundle\Entity\Restaurante $restaurante
     *
     * @return Horario
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
