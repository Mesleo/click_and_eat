<?php

namespace AppBundle\Entity;

/**
 * Reserva
 */
class Reserva
{
    /**
     * @var integer
     */
    private $idreserva;

    /**
     * @var \AppBundle\Entity\Mesa
     */
    private $mesamesa;


    /**
     * Get idreserva
     *
     * @return integer
     */
    public function getIdreserva()
    {
        return $this->idreserva;
    }

    /**
     * Set mesamesa
     *
     * @param \AppBundle\Entity\Mesa $mesamesa
     *
     * @return Reserva
     */
    public function setMesamesa(\AppBundle\Entity\Mesa $mesamesa = null)
    {
        $this->mesamesa = $mesamesa;

        return $this;
    }

    /**
     * Get mesamesa
     *
     * @return \AppBundle\Entity\Mesa
     */
    public function getMesamesa()
    {
        return $this->mesamesa;
    }
}
