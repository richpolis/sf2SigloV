<?php

namespace Richpolis\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
//use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use JMS\Serializer\Annotation as Serializer;



/**
 * Usuarios
 *
 * @ORM\Table(name="usuarios")
 * @ORM\Entity(repositoryClass="Richpolis\BackendBundle\Repository\UsuariosRepository")
 * @ORM\HasLifecycleCallbacks()
 * 
 * @Serializer\ExclusionPolicy("all")
 */
class Usuario implements UserInterface, \Serializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * 
     * @Serializer\Expose
     * @Serializer\Type("integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=100, nullable=false)
     * @Assert\NotBlank()
     * 
     * @Serializer\Expose
     * @Serializer\Type("string")
     * 
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=false)
     * @Assert\NotBlank()
     * 
     * @Serializer\Expose
     * @Serializer\Type("string")
     */
    private $email;
    
    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255)
     */
    private $salt;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     * 
     * @Serializer\Expose
     * @Serializer\Type("string")
     * 
     */
    private $nombre;
    
    /**
     * @var string
     *
     * @ORM\Column(name="twitter", type="string", length=255, nullable=true)
     * 
     * @Serializer\Expose
     * @Serializer\Type("string")
     * 
     */
    private $twitter;
    
    /**
     * @var string
     *
     * @ORM\Column(name="facebook", type="string", length=255, nullable=true)
     * 
     * @Serializer\Expose
     * @Serializer\Type("string")
     * 
     */
    private $facebook;
    
    /**
     * @var string
     *
     * @ORM\Column(name="grupo", type="string", length=100, nullable=false)
     * 
     * @Serializer\Expose
     * @Serializer\Type("integer")
     * 
     */
    private $grupo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     * 
     * @Serializer\Expose
     * @Serializer\Type("DateTime")
     * 
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     * 
     * @Serializer\Expose
     * @Serializer\Type("DateTime")
     * 
     */
    private $updatedAt;
    
    /**
     * @var integer
     *
     * @ORM\OneToMany(targetEntity="Richpolis\PublicacionesBundle\Entity\Publicacion", mappedBy="usuario")
     */
    private $publicaciones;
    
    
    const GRUPO_USUARIOS=1;
    const GRUPO_ADMIN=2;
    const GRUPO_SUPER_ADMIN=3;
    
 
    public function __toString(){
        return $this->getUsername();
    }
    
    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("stringGrupo")
     * 
     */
    public function getStringTipoGrupo(){
        $arreglo = $this->getArrayTipoGrupo();
        return $arreglo[$this->getGrupo()];
    }

    static function getArrayTipoGrupo(){
        $sTipoGrupo=array(
            self::GRUPO_USUARIOS=>'Usuarios',
            self::GRUPO_ADMIN=>'Administrador',
            self::GRUPO_SUPER_ADMIN=>'Superadmin',
        );
        return $sTipoGrupo;
    }

    static function getPreferedTipoGrupo(){
        return array(self::GRUPO_USUARIOS);
    }


    public function __construct()
    {
        // may not be needed, see section on salt below
        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
    }
    
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
     * Set username
     *
     * @param string $username
     * @return Usuarios
     */
    public function setUsername($username)
    {
        $this->username = $username;
    
        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Usuarios
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Usuarios
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Usuarios
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    
        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set grupo
     *
     * @param string $grupo
     * @return Usuarios
     */
    public function setGrupo($grupo)
    {
        $this->grupo = $grupo;
    
        return $this;
    }

    /**
     * Get grupo
     *
     * @return string 
     */
    public function getGrupo()
    {
        return $this->grupo;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Usuarios
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Usuarios
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /*
     * Timestable
     */
    
    /**
     ** @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        if(!$this->getCreatedAt())
        {
          $this->createdAt = new \DateTime();
        }
        if(!$this->getUpdatedAt())
        {
          $this->updatedAt = new \DateTime();
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->updatedAt = new \DateTime();
    }
    
    function eraseCredentials()
    {
    }

    function getRoles()
    {
        if($this->getGrupo() == self::GRUPO_USUARIOS){
            return array('ROLE_USER','ROLE_API');
        }elseif($this->getGrupo() == self::GRUPO_SUPER_ADMIN){
            return array('ROLE_SUPER_ADMIN','ROLE_API');
        }else{
            return array('ROLE_ADMIN','ROLE_API');
        }
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return Usuario
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    
        return $this;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->twitter,
            $this->facebook,
            $this->email
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->twitter,
            $this->facebook,
            $this->email
        ) = unserialize($serialized);
    }

    /**
     * Set twitter
     *
     * @param string $twitter
     * @return Usuario
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Get twitter
     *
     * @return string 
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * Set facebook
     *
     * @param string $facebook
     * @return Usuario
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get facebook
     *
     * @return string 
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Add publicaciones
     *
     * @param \Richpolis\PublicacionesBundle\Entity\Publicacion $publicaciones
     * @return Usuario
     */
    public function addPublicacione(\Richpolis\PublicacionesBundle\Entity\Publicacion $publicaciones)
    {
        $this->publicaciones[] = $publicaciones;

        return $this;
    }

    /**
     * Remove publicaciones
     *
     * @param \Richpolis\PublicacionesBundle\Entity\Publicacion $publicaciones
     */
    public function removePublicacione(\Richpolis\PublicacionesBundle\Entity\Publicacion $publicaciones)
    {
        $this->publicaciones->removeElement($publicaciones);
    }

    /**
     * Get publicaciones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPublicaciones()
    {
        return $this->publicaciones;
    }
}