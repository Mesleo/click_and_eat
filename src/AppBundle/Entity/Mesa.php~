<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Mesa
 *
 * @ORM\Entity
 * @ORM\Table(name="mesa")
 */
class Mesa
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idmesa;

    /**
     * @var integer
     *
     * @ORM\Column(name="numpersonas", type="integer")
     */
    private $numpersonas;

    /**
     * @var boolean
     * @ORM\Column(name="reservada", type="boolean", length=255, nullable=false, options={"default" = 0})
     */
    private $reservada = '0';

    /**
     * @ORM\OneToMany(targetEntity="Restaurante", mappedBy="id")
     */
    private $idRestaurante;

    /**
     * @ORM\ManyToOne(targetEntity="Reserva", inversedBy="mesas")
     * @ORM\JoinColumn(name="idReserva", referencedColumnName="id")
     */
    private  $reserva;

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
        $this->idRestaurante = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get idmesa
     *
     * @return \integer
     */
    public function getIdmesa()
    {
        return $this->idmesa;
    }

    /**
     * Set numpersonas
     *
     * @param integer $numpersonas
     *
     * @return Mesa
     */
    public function setNumpersonas($numpersonas)
    {
        $this->numpersonas = $numpersonas;

        return $this;
    }

    /**
     * Get numpersonas
     *
     * @return integer
     */
    public function getNumpersonas()
    {
        return $this->numpersonas;
    }

    /**
     * Set reservada
     *
     * @param boolean $reservada
     *
     * @return Mesa
     */
    public function setReservada($reservada)
    {
        $this->reservada = $reservada;

        return $this;
    }

    /**
     * Get reservada
     *
     * @return boolean
     */
    public function getReservada()
    {
        return $this->reservada;
    }

    /**
     * Set trash
     *
     * @param boolean $trash
     *
     * @return Mesa
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
     * Add idRestaurante
     *
     * @param \AppBundle\Entity\Restaurante $idRestaurante
     *
     * @return Mesa
     */
    public function addIdRestaurante(\AppBundle\Entity\Restaurante $idRestaurante)
    {
        $this->idRestaurante[] = $idRestaurante;

        return $this;
    }

    /**
     * Remove idRestaurante
     *
     * @param \AppBundle\Entity\Restaurante $idRestaurante
     */
    public function removeIdRestaurante(\AppBundle\Entity\Restaurante $idRestaurante)
    {
        $this->idRestaurante->removeElement($idRestaurante);
    }

    /**
     * Get idRestaurante
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdRestaurante()
    {
        return $this->idRestaurante;
    }

    /**
     * Set reserva
     *
     * @param \AppBundle\Entity\Reserva $reserva
     *
     * @return Mesa
     */
    public function setReserva(\AppBundle\Entity\Reserva $reserva = null)
    {
        $this->reserva = $reserva;

        return $this;
    }

    /**
     * Get reserva
     *
     * @return \AppBundle\Entity\Reserva
     */
    public function getReserva()
    {
        return $this->reserva;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Mesa
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
     * @return Mesa
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
}
