<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Horario
 *
 * @ORM\Entity
 * @ORM\Table(name="horario")
 */
class Horario
{

    /**
     * @var bigint
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horario_apertura_local", type="datetime", nullable=false)
     */
    private $horario_apertura_local;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horario_cierre_local", type="datetime", nullable=false)
     */
    private $horario_cierre_local;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horario_apertura_ldomicilio", type="datetime", nullable=false)
     */
    private $horario_apertura_domicilio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horario_cierre_domicilio", type="datetime", nullable=false)
     */
    private $horario_cierre_domicilio;


    /**
     * @var boolean
     *
     * @ORM\Column(name="trash", type="boolean", options={"default":0})
     */
    private $trash;

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
}