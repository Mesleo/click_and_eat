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
     * @var integer
     *
     * @ORM\Column(name="tipo_usuario", type="integer", nullable=false)
     */
    protected $typeUser;

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
		
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());

        $this->setTrash(false);
    }

    /**
     * Set $typeUser
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
     * Get $typeUser
     *
     * @return integer
     */
    public function getTypeUser()
    {
        return $this->$typeUser;
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
