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

}