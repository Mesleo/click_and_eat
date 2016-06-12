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
     * @ORM\Column(name="horario_apertura_local_mediodia_no_festivos", type="datetime", nullable=true)
     */
    protected $horarioAperturaLocalMediodiaNF;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horario_cierre_local_mediodia_no_festivos", type="datetime", nullable=true)
     */
    protected $horarioCierreLocalMediodiaNF;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horario_apertura_local_noche_no_festivos", type="datetime", nullable=true)
     */
    protected $horarioAperturaLocalNocheNF;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horario_cierre_local_noche_no_festivos", type="datetime", nullable=true)
     */
    protected $horarioCierreLocalNocheNF;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horario_apertura_local_mediodia_festivos", type="datetime", nullable=true)
     */
    protected $horarioAperturaLocalMediodiaF;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horario_cierre_local_mediodia_festivos", type="datetime", nullable=true)
     */
    protected $horarioCierreLocalMediodiaF;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horario_apertura_local_noche_festivos", type="datetime", nullable=true)
     */
    protected $horarioAperturaLocalNocheF;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horario_cierre_local_noche_festivos", type="datetime", nullable=true)
     */
    protected $horarioCierreLocalNocheF;


    // Domicilio


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horario_apertura_Domiclio_mediodia_no_festivos", type="datetime", nullable=true)
     */
    protected $horarioAperturaDomicilioMediodiaNF;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horario_cierre_domiclio_mediodia_no_festivos", type="datetime", nullable=true)
     */
    protected $horarioCierreDomicilioMediodiaNF;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horario_apertura_domiclio_noche_no_festivos", type="datetime", nullable=true)
     */
    protected $horarioAperturaDomicilioNocheNF;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horario_cierre_domiclio_noche_no_festivos", type="datetime", nullable=true)
     */
    protected $horarioCierreDomicilioNocheNF;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horario_apertura_domiclio_mediodia_festivos", type="datetime", nullable=true)
     */
    protected $horarioAperturaDomicilioMediodiaF;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horario_cierre_domiclio_mediodia_festivos", type="datetime", nullable=true)
     */
    protected $horarioCierreDomicilioMediodiaF;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horario_apertura_domiclio_noche_festivos", type="datetime", nullable=true)
     */
    protected $horarioAperturaDomicilioNocheF;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horario_cierre_domiclio_noche_festivos", type="datetime", nullable=true)
     */
    protected $horarioCierreDomicilioNocheF;
    
    // Final domicilio
        
    

    /**
     * @var boolean 
     *
     * @ORM\Column(name="trash", type="boolean", options={"default":0})
     */
    protected $trash;

    /**
     * @ORM\OneToMany(targetEntity="Restaurante", mappedBy="horario")
     */
    protected $restaurante;

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
     * Constructor
     */
    public function __construct()
    {
        $this->restaurantes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setTrash(false);
    }

    /**
     * Set horarioAperturaLocalMediodiaNF
     *
     * @param \DateTime $horarioAperturaLocalMediodiaNF
     *
     * @return Horario
     */
    public function setHorarioAperturaLocalMediodiaNF($horarioAperturaLocalMediodiaNF)
    {
        $this->horarioAperturaLocalMediodiaNF = $horarioAperturaLocalMediodiaNF;

        return $this;
    }

    /**
     * Get horarioAperturaLocalMediodiaNF
     *
     * @return \DateTime
     */
    public function getHorarioAperturaLocalMediodiaNF()
    {
        return $this->horarioAperturaLocalMediodiaNF;
    }

    /**
     * Set horarioCierreLocalMediodiaNF
     *
     * @param \DateTime $horarioCierreLocalMediodiaNF
     *
     * @return Horario
     */
    public function setHorarioCierreLocalMediodiaNF($horarioCierreLocalMediodiaNF)
    {
        $this->horarioCierreLocalMediodiaNF = $horarioCierreLocalMediodiaNF;

        return $this;
    }

    /**
     * Get horarioCierreLocalMediodiaNF
     *
     * @return \DateTime
     */
    public function getHorarioCierreLocalMediodiaNF()
    {
        return $this->horarioCierreLocalMediodiaNF;
    }

    /**
     * Set horarioAperturaLocalNocheNF
     *
     * @param \DateTime $horarioAperturaLocalNocheNF
     *
     * @return Horario
     */
    public function setHorarioAperturaLocalNocheNF($horarioAperturaLocalNocheNF)
    {
        $this->horarioAperturaLocalNocheNF = $horarioAperturaLocalNocheNF;

        return $this;
    }

    /**
     * Get horarioAperturaLocalNocheNF
     *
     * @return \DateTime
     */
    public function getHorarioAperturaLocalNocheNF()
    {
        return $this->horarioAperturaLocalNocheNF;
    }

    /**
     * Set horarioCierreLocalNocheNF
     *
     * @param \DateTime $horarioCierreLocalNocheNF
     *
     * @return Horario
     */
    public function setHorarioCierreLocalNocheNF($horarioCierreLocalNocheNF)
    {
        $this->horarioCierreLocalNocheNF = $horarioCierreLocalNocheNF;

        return $this;
    }

    /**
     * Get horarioCierreLocalNocheNF
     *
     * @return \DateTime
     */
    public function getHorarioCierreLocalNocheNF()
    {
        return $this->horarioCierreLocalNocheNF;
    }

    /**
     * Set horarioAperturaLocalMediodiaF
     *
     * @param \DateTime $horarioAperturaLocalMediodiaF
     *
     * @return Horario
     */
    public function setHorarioAperturaLocalMediodiaF($horarioAperturaLocalMediodiaF)
    {
        $this->horarioAperturaLocalMediodiaF = $horarioAperturaLocalMediodiaF;

        return $this;
    }

    /**
     * Get horarioAperturaLocalMediodiaF
     *
     * @return \DateTime
     */
    public function getHorarioAperturaLocalMediodiaF()
    {
        return $this->horarioAperturaLocalMediodiaF;
    }

    /**
     * Set horarioCierreLocalMediodiaF
     *
     * @param \DateTime $horarioCierreLocalMediodiaF
     *
     * @return Horario
     */
    public function setHorarioCierreLocalMediodiaF($horarioCierreLocalMediodiaF)
    {
        $this->horarioCierreLocalMediodiaF = $horarioCierreLocalMediodiaF;

        return $this;
    }

    /**
     * Get horarioCierreLocalMediodiaF
     *
     * @return \DateTime
     */
    public function getHorarioCierreLocalMediodiaF()
    {
        return $this->horarioCierreLocalMediodiaF;
    }

    /**
     * Set horarioAperturaLocalNocheF
     *
     * @param \DateTime $horarioAperturaLocalNocheF
     *
     * @return Horario
     */
    public function setHorarioAperturaLocalNocheF($horarioAperturaLocalNocheF)
    {
        $this->horarioAperturaLocalNocheF = $horarioAperturaLocalNocheF;

        return $this;
    }

    /**
     * Get horarioAperturaLocalNocheF
     *
     * @return \DateTime
     */
    public function getHorarioAperturaLocalNocheF()
    {
        return $this->horarioAperturaLocalNocheF;
    }

    /**
     * Set horarioCierreLocalNocheF
     *
     * @param \DateTime $horarioCierreLocalNocheF
     *
     * @return Horario
     */
    public function setHorarioCierreLocalNocheF($horarioCierreLocalNocheF)
    {
        $this->horarioCierreLocalNocheF = $horarioCierreLocalNocheF;

        return $this;
    }

    /**
     * Get horarioCierreLocalNocheF
     *
     * @return \DateTime
     */
    public function getHorarioCierreLocalNocheF()
    {
        return $this->horarioCierreLocalNocheF;
    }

    /**
     * Set horarioAperturaDomiclioMediodiaNF
     *
     * @param \DateTime $horarioAperturaDomiclioMediodiaNF
     *
     * @return Horario
     */
    public function setHorarioAperturaDomiclioMediodiaNF($horarioAperturaDomiclioMediodiaNF)
    {
        $this->horarioAperturaDomiclioMediodiaNF = $horarioAperturaDomiclioMediodiaNF;

        return $this;
    }

    /**
     * Get horarioAperturaDomiclioMediodiaNF
     *
     * @return \DateTime
     */
    public function getHorarioAperturaDomiclioMediodiaNF()
    {
        return $this->horarioAperturaDomiclioMediodiaNF;
    }

    /**
     * Set horarioCierreDomiclioMediodiaNF
     *
     * @param \DateTime $horarioCierreDomiclioMediodiaNF
     *
     * @return Horario
     */
    public function setHorarioCierreDomiclioMediodiaNF($horarioCierreDomiclioMediodiaNF)
    {
        $this->horarioCierreDomiclioMediodiaNF = $horarioCierreDomiclioMediodiaNF;

        return $this;
    }

    /**
     * Get horarioCierreDomiclioMediodiaNF
     *
     * @return \DateTime
     */
    public function getHorarioCierreDomiclioMediodiaNF()
    {
        return $this->horarioCierreDomiclioMediodiaNF;
    }

    /**
     * Set horarioAperturaDomiclioNocheNF
     *
     * @param \DateTime $horarioAperturaDomiclioNocheNF
     *
     * @return Horario
     */
    public function setHorarioAperturaDomiclioNocheNF($horarioAperturaDomiclioNocheNF)
    {
        $this->horarioAperturaDomiclioNocheNF = $horarioAperturaDomiclioNocheNF;

        return $this;
    }

    /**
     * Get horarioAperturaDomiclioNocheNF
     *
     * @return \DateTime
     */
    public function getHorarioAperturaDomiclioNocheNF()
    {
        return $this->horarioAperturaDomiclioNocheNF;
    }

    /**
     * Set horarioCierreDomiclioNocheNF
     *
     * @param \DateTime $horarioCierreDomiclioNocheNF
     *
     * @return Horario
     */
    public function setHorarioCierreDomiclioNocheNF($horarioCierreDomiclioNocheNF)
    {
        $this->horarioCierreDomiclioNocheNF = $horarioCierreDomiclioNocheNF;

        return $this;
    }

    /**
     * Get horarioCierreDomiclioNocheNF
     *
     * @return \DateTime
     */
    public function getHorarioCierreDomiclioNocheNF()
    {
        return $this->horarioCierreDomiclioNocheNF;
    }

    /**
     * Set horarioAperturaDomiclioMediodiaF
     *
     * @param \DateTime $horarioAperturaDomiclioMediodiaF
     *
     * @return Horario
     */
    public function setHorarioAperturaDomiclioMediodiaF($horarioAperturaDomiclioMediodiaF)
    {
        $this->horarioAperturaDomiclioMediodiaF = $horarioAperturaDomiclioMediodiaF;

        return $this;
    }

    /**
     * Get horarioAperturaDomiclioMediodiaF
     *
     * @return \DateTime
     */
    public function getHorarioAperturaDomiclioMediodiaF()
    {
        return $this->horarioAperturaDomiclioMediodiaF;
    }

    /**
     * Set horarioCierreDomiclioMediodiaF
     *
     * @param \DateTime $horarioCierreDomiclioMediodiaF
     *
     * @return Horario
     */
    public function setHorarioCierreDomiclioMediodiaF($horarioCierreDomiclioMediodiaF)
    {
        $this->horarioCierreDomiclioMediodiaF = $horarioCierreDomiclioMediodiaF;

        return $this;
    }

    /**
     * Get horarioCierreDomiclioMediodiaF
     *
     * @return \DateTime
     */
    public function getHorarioCierreDomiclioMediodiaF()
    {
        return $this->horarioCierreDomiclioMediodiaF;
    }

    /**
     * Set horarioAperturaDomiclioNocheF
     *
     * @param \DateTime $horarioAperturaDomiclioNocheF
     *
     * @return Horario
     */
    public function setHorarioAperturaDomiclioNocheF($horarioAperturaDomiclioNocheF)
    {
        $this->horarioAperturaDomiclioNocheF = $horarioAperturaDomiclioNocheF;

        return $this;
    }

    /**
     * Get horarioAperturaDomiclioNocheF
     *
     * @return \DateTime
     */
    public function getHorarioAperturaDomiclioNocheF()
    {
        return $this->horarioAperturaDomiclioNocheF;
    }

    /**
     * Set horarioCierreDomiclioNocheF
     *
     * @param \DateTime $horarioCierreDomiclioNocheF
     *
     * @return Horario
     */
    public function setHorarioCierreDomiclioNocheF($horarioCierreDomiclioNocheF)
    {
        $this->horarioCierreDomiclioNocheF = $horarioCierreDomiclioNocheF;

        return $this;
    }

    /**
     * Get horarioCierreDomiclioNocheF
     *
     * @return \DateTime
     */
    public function getHorarioCierreDomiclioNocheF()
    {
        return $this->horarioCierreDomiclioNocheF;
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

    /**
     * Set restaurante
     *
     * @param \AppBundle\Entity\Restaurante $restaurante
     *
     * @return Horario
     */
    public function setRestaurante(\AppBundle\Entity\Restaurante $restaurante = null)
    {
        $this->restaurante = $restaurante;

        return $this;
    }

    /**
     * Get restaurante
     *
     * @return \AppBundle\Entity\Restaurante
     */
    public function getRestaurante()
    {
        return $this->restaurante;
    }

    /**
     * Set horarioAperturaDomicilioMediodiaNF
     *
     * @param \DateDateTime $horarioAperturaDomicilioMediodiaNF
     *
     * @return Horario
     */
    public function setHorarioAperturaDomicilioMediodiaNF($horarioAperturaDomicilioMediodiaNF)
    {
        $this->horarioAperturaDomicilioMediodiaNF = $horarioAperturaDomicilioMediodiaNF;

        return $this;
    }

    /**
     * Get horarioAperturaDomicilioMediodiaNF
     *
     * @return \DateDateTime
     */
    public function getHorarioAperturaDomicilioMediodiaNF()
    {
        return $this->horarioAperturaDomicilioMediodiaNF;
    }

    /**
     * Set horarioCierreDomicilioMediodiaNF
     *
     * @param \DateDateTime $horarioCierreDomicilioMediodiaNF
     *
     * @return Horario
     */
    public function setHorarioCierreDomicilioMediodiaNF($horarioCierreDomicilioMediodiaNF)
    {
        $this->horarioCierreDomicilioMediodiaNF = $horarioCierreDomicilioMediodiaNF;

        return $this;
    }

    /**
     * Get horarioCierreDomicilioMediodiaNF
     *
     * @return \DateDateTime
     */
    public function getHorarioCierreDomicilioMediodiaNF()
    {
        return $this->horarioCierreDomicilioMediodiaNF;
    }

    /**
     * Set horarioAperturaDomicilioNocheNF
     *
     * @param \DateDateTime $horarioAperturaDomicilioNocheNF
     *
     * @return Horario
     */
    public function setHorarioAperturaDomicilioNocheNF($horarioAperturaDomicilioNocheNF)
    {
        $this->horarioAperturaDomicilioNocheNF = $horarioAperturaDomicilioNocheNF;

        return $this;
    }

    /**
     * Get horarioAperturaDomicilioNocheNF
     *
     * @return \DateDateTime
     */
    public function getHorarioAperturaDomicilioNocheNF()
    {
        return $this->horarioAperturaDomicilioNocheNF;
    }

    /**
     * Set horarioCierreDomicilioNocheNF
     *
     * @param \DateDateTime $horarioCierreDomicilioNocheNF
     *
     * @return Horario
     */
    public function setHorarioCierreDomicilioNocheNF($horarioCierreDomicilioNocheNF)
    {
        $this->horarioCierreDomicilioNocheNF = $horarioCierreDomicilioNocheNF;

        return $this;
    }

    /**
     * Get horarioCierreDomicilioNocheNF
     *
     * @return \DateDateTime
     */
    public function getHorarioCierreDomicilioNocheNF()
    {
        return $this->horarioCierreDomicilioNocheNF;
    }

    /**
     * Set horarioCierreDomicilioMediodiaF
     *
     * @param \DateDateTime $horarioCierreDomicilioMediodiaF
     *
     * @return Horario
     */
    public function setHorarioCierreDomicilioMediodiaF($horarioCierreDomicilioMediodiaF)
    {
        $this->horarioCierreDomicilioMediodiaF = $horarioCierreDomicilioMediodiaF;

        return $this;
    }

    /**
     * Get horarioCierreDomicilioMediodiaF
     *
     * @return \DateDateTime
     */
    public function getHorarioCierreDomicilioMediodiaF()
    {
        return $this->horarioCierreDomicilioMediodiaF;
    }

    /**
     * Set horarioAperturaDomicilioNocheF
     *
     * @param \DateDateTime $horarioAperturaDomicilioNocheF
     *
     * @return Horario
     */
    public function setHorarioAperturaDomicilioNocheF($horarioAperturaDomicilioNocheF)
    {
        $this->horarioAperturaDomicilioNocheF = $horarioAperturaDomicilioNocheF;

        return $this;
    }

    /**
     * Get horarioAperturaDomicilioNocheF
     *
     * @return \DateDateTime
     */
    public function getHorarioAperturaDomicilioNocheF()
    {
        return $this->horarioAperturaDomicilioNocheF;
    }

    /**
     * Set horarioCierreDomicilioNocheF
     *
     * @param \DateDateTime $horarioCierreDomicilioNocheF
     *
     * @return Horario
     */
    public function setHorarioCierreDomicilioNocheF($horarioCierreDomicilioNocheF)
    {
        $this->horarioCierreDomicilioNocheF = $horarioCierreDomicilioNocheF;

        return $this;
    }

    /**
     * Get horarioCierreDomicilioNocheF
     *
     * @return \DateDateTime
     */
    public function getHorarioCierreDomicilioNocheF()
    {
        return $this->horarioCierreDomicilioNocheF;
    }

    /**
     * Set horarioAperturaDomicilioMediodiaF
     *
     * @param \DateDateTime $horarioAperturaDomicilioMediodiaF
     *
     * @return Horario
     */
    public function setHorarioAperturaDomicilioMediodiaF($horarioAperturaDomicilioMediodiaF)
    {
        $this->horarioAperturaDomicilioMediodiaF = $horarioAperturaDomicilioMediodiaF;

        return $this;
    }

    /**
     * Get horarioAperturaDomicilioMediodiaF
     *
     * @return \DateDateTime
     */
    public function getHorarioAperturaDomicilioMediodiaF()
    {
        return $this->horarioAperturaDomicilioMediodiaF;
    }
}
