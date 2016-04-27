<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Restaurante
 *
 * @ORM\Entity
 * @ORM\Table(name="restaurante")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RestauranteRepository")
 */
class Restaurante
{
    /**
     * @var bigint
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100, nullable=false)
     */
    private $nombre;


    /**
     * @var string
     *
     * @ORM\Column(name="cif", type="string", length=9, nullable=false)
     */
    private $cif;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255, nullable=false)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="localidad", type="string", length=100, nullable=false)
     */
    private $localidad;


    /**
     * @ORM\ManyToMany(targetEntity="TipoComida")
     * @ORM\JoinTable(name="restaurante_tipo_comida",
     *      joinColumns={@ORM\JoinColumn(name="restaurante_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tipo_comida_id", referencedColumnName="id")}
     *      )
     */
    private $tipo_comida;

    /**
     * @var blob
     *
     *  @ORM\Column(name="mapa", type="blob", length=100)
     */
    private $mapa;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_alta", type="datetime",  nullable=false)
     */
    private $fecha_alta;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_baja", type="datetime",  nullable=false)
     */
    private $fecha_baja;

    /**
     * @var float
     *
     * @ORM\Column(name="envio", type="float", nullable=false, options={"default" = "0.0"})
     */
    private $envio;



    /**
     * @ORM\ManyToMany(targetEntity="Horario")
     * @ORM\JoinTable(name="horario_restaurante",
     *      joinColumns={@ORM\JoinColumn(name="restaurante_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="horario_id", referencedColumnName="id")}
     *      )
     */
    private $horario;

}