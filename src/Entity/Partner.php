<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * Partner
 *
 * @ORM\Table(name="partners")
 * @ORM\Entity(repositoryClass="App\Repository\PartnerRepository")
 */
class Partner implements UserInterface
{
    //const ROLE_USER=0;
    const ROLE_PREMIUM=1;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_partner", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=6)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=255)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255)
     */
    private $salt;

    /**
     * @var int
     *
     * @ORM\Column(name="role", type="integer")
     */
    private $role=1;

    /**
     * @var int
     *
     * @ORM\Column(name="active", type="integer")
     */
    private $active=1;

    /**
     * @var string
     *
     * @ORM\Column(name="cdate", type="datetime")
     */
    private $cdate;

    /**
     * @var string
     *
     * @ORM\Column(name="mdate", type="datetime")
     */
    private $mdate;





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
     * Set code
     *
     * @param string $code
     *
     * @return Partner
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Partner
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
     * Set surname
     *
     * @param string $surname
     *
     * @return Partner
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Partner
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
     * Set password
     *
     * @param string $password
     *
     * @return Admin
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
     * Set salt
     *
     * @param string $salt
     *
     * @return Admin
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
     * Get Roles
     *
     * @return array
     */
    function getRoles()
    {
        switch ($this->role){
            //case self::ROLE_USER: return array('ROLE_USER');
            case self::ROLE_PREMIUM: return array('ROLE_PREMIUM');
        }
    }

    /**
     * Set role
     *
     * @param integer $role
     *
     * @return Partner
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return integer
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set active
     *
     * @param integer $active
     *
     * @return Partner
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return integer
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set cdate
     *
     * @param \DateTime $cdate
     *
     * @return Partner
     */
    public function setCdate($cdate)
    {
        $this->cdate = $cdate;

        return $this;
    }

    /**
     * Get cdate
     *
     * @return \DateTime
     */
    public function getCdate()
    {
        return $this->cdate;
    }

    /**
     * Set mdate
     *
     * @param \DateTime $mdate
     *
     * @return Partner
     */
    public function setMdate($mdate)
    {
        $this->mdate = $mdate;

        return $this;
    }

    /**
     * Get mdate
     *
     * @return \DateTime
     */
    public function getMdate()
    {
        return $this->mdate;
    }

    /**
     * eraseCredentials
     */
    function eraseCredentials()
    {

    }

    /**
     * Get Username
     *
     * @return string
     */
    function getUsername()
    {
        return $this->getEmail();
    }
}
