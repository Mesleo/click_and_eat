<?php
// src/AppBundle/Entity/Usuario.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Usuario
 * @ORM\Entity
 * @ORM\Table(name="usuario")
 * @UniqueEntity(
 *     fields={"username"},
 *     message="Ese nombre de usuario ya existe."
 * )
 * @UniqueEntity(
 *     fields={"email"},
 *     message="Ese correo ya ha sido registrado."
 * )
 */
class Usuario extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="Please enter your name.")
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="The name is too short.",
     *     maxMessage="The name is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(name="telefono", type="string", length=255)
     *
     * @Assert\NotBlank(message="Please enter your phone.")
     * @Assert\Length(
     *     min=9,
     *     max=15,
     *     minMessage="The number phone is too short.",
     *     maxMessage="The number phone is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $telefono;

    /**
     * @var integer
     *
     * @ORM\Column(name="tipo_usuario", type="integer", length=255, nullable=true)
     */
    private $typeUser;

    /**
     * @var integer
     *
     * @ORM\OneToOne(targetEntity="Restaurante")
     * @ORM\JoinColumn(name="idRestaurante", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    private $idRestaurante;
    /**
     * @var integer
     *
     * @ORM\OneToOne(targetEntity="Trabajador")
     * @ORM\JoinColumn(name="idTrabajador", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    private $idTrabajador;
    /**
     * @var integer
     *
     * @ORM\OneToOne(targetEntity="Cliente")
     * @ORM\JoinColumn(name="idCliente", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    private $idCliente;

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
        parent::__construct();
        $this->addRole("ROLE_ADMIN");
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());

        $this->setTrash(false);
    }


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Usuario
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     *
     * @return Usuario
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set typeUser
     *
     * @param integer $typeUser
     *
     * @return Usuario
     */
    public function setTypeUser($typeUser)
    {
        $this->typeUser = $typeUser;

        return $this;
    }

    /**
     * Get typeUser
     *
     * @return integer
     */
    public function getTypeUser()
    {
        return $this->typeUser;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Usuario
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
     * @return Usuario
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
     * @return Usuario
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
     * Set idRestaurante
     *
     * @param \AppBundle\Entity\Restaurante $idRestaurante
     *
     * @return Usuario
     */
    public function setIdRestaurante(\AppBundle\Entity\Restaurante $idRestaurante = null)
    {
        $this->idRestaurante = $idRestaurante;

        return $this;
    }

    /**
     * Get idRestaurante
     *
     * @return \AppBundle\Entity\Restaurante
     */
    public function getIdRestaurante()
    {
        return $this->idRestaurante;
    }

    /**
     * Set idTrabajador
     *
     * @param \AppBundle\Entity\Trabajador $idTrabajador
     *
     * @return Usuario
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
     * Set idCliente
     *
     * @param \AppBundle\Entity\Cliente $idCliente
     *
     * @return Usuario
     */
    public function setIdCliente(\AppBundle\Entity\Cliente $idCliente = null)
    {
        $this->idCliente = $idCliente;

        return $this;
    }

    /**
     * Get idCliente
     *
     * @return \AppBundle\Entity\Cliente
     */
    public function getIdCliente()
    {
        return $this->idCliente;
    }

    /**
     * Agrega un rol al usuario.
     * @throws Exception
     * @param Rol $rol
     */
    public function addRole( $rol )
    {
        if($rol == 1) {
            array_push($this->roles, 'ROLE_ADMIN');
        }
        else if($rol == 2) {
            array_push($this->roles, 'ROLE_EMPLOYEE');
        }
        else if($rol == 3) {
            array_push($this->roles, 'ROLE_USER');
        }
    }
}
