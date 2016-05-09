<?php

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Recorrido
 *
 * @ORM\Entity
 * @ORM\Table(name="recorrido")
 */
class Recorrido
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
     * @ORM\Column(name="fecha_hora_salida", type="datetime", nullable=false)
     */
    protected $fechaHoraSalida;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_hora_llegada", type="datetime", nullable=false)
     */
    protected $fechaHoraLlegada;

    /**
     * @ORM\ManyToOne(targetEntity="Trabajador", inversedBy="recorridos")
     * @ORM\JoinColumn(name="idTrabajador", referencedColumnName="id")
     */
    protected $idTrabajador;

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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fechaHoraSalida
     *
     * @param \DateTime $fechaHoraSalida
     *
     * @return Recorrido
     */
    public function setFechaHoraSalida($fechaHoraSalida)
    {
        $this->fechaHoraSalida = $fechaHoraSalida;

        return $this;
    }

    /**
     * Get fechaHoraSalida
     *
     * @return \DateTime
     */
    public function getFechaHoraSalida()
    {
        return $this->fechaHoraSalida;
    }

    /**
     * Set fechaHoraLlegada
     *
     * @param \DateTime $fechaHoraLlegada
     *
     * @return Recorrido
     */
    public function setFechaHoraLlegada($fechaHoraLlegada)
    {
        $this->fechaHoraLlegada = $fechaHoraLlegada;

        return $this;
    }

    /**
     * Get fechaHoraLlegada
     *
     * @return \DateTime
     */
    public function getFechaHoraLlegada()
    {
        return $this->fechaHoraLlegada;
    }

    /**
     * Set idTrabajador
     *
     * @param \AppBundle\Entity\Trabajador $idTrabajador
     *
     * @return Recorrido
     */
    public function setIdTrabajador(\AppBundle\Entity\Trabajador $idTrabajador = null)
    {
        $this->idTrabajador = $idTrabajador;

        return $this;
    }

    /**
     * Get idTrabajador
     *
     * @return \AppBundle\Entity\Trabajador
     */
    public function getIdTrabajador()
    {
        return $this->idTrabajador;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Recorrido
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
     * @return Recorrido
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
     * @return Recorrido
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