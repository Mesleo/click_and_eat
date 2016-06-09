<?php
// src/AppBundle/Entity/Usuario.php
namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Usuario
 *
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Por favor introduce tu nombre.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="El nombre introducido es demasiado corto.",
     *     maxMessage="El nombre introducido es demasiado largo.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $name;

    /**
     * @var string
	 * 
     * @ORM\Column(name="telefono", type="string", length=15, nullable=false)
     * @Assert\NotBlank(message="Por favor introduce tu telefono.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=9,
     *     max=15,
     *     minMessage="El numero de telefono introducido es demasiado corto.",
     *     maxMessage="El numero de telefono introducido es demasiado largo.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $telefono;

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
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return Usuario
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    public function addRole($rol)
    {
        if ($rol == 1) {
            array_push($this->roles, 'ROLE_ADMIN');
        }
        else if ($rol == 2) {
            array_push($this->roles, 'ROLE_EMPLOYEE');
        }
        else if ($rol == 3) {
            array_push($this->roles, 'ROLE_USER');
        }
    }
}
