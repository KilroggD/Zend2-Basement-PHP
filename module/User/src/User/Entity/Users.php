<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="`users`")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Users
{
        /*
     * пользователь неактивен
     */
    const INACTIVE=0;
     /*
      * активен
      */
    const ACTIVE=1;
    /**
     * смена пароля
     */
    const CHANGEPWD=2;
    /*
     * блокирован
     */
    const BLOCKED=3;
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="user_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=64, nullable=false)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=256, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=64, nullable=false)
     */
    private $email;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="smallint", nullable=false)
     */
    private $status = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    private $lastLogin;

    /**
     * @ORM\OneToOne(targetEntity="User\Entity\UserPasswordChange", mappedBy="user", cascade={"remove"})
     */    
    private $passwordChange;
    
    /**
     *
     * @ORM\OneToOne(targetEntity="User\Entity\UserProfile", mappedBy="user", cascade={"persist","remove"})
     */
    private $profile;

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
     * Set login
     *
     * @param string $login
     * @return User
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string 
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
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
     * @return User
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
     * Set status
     *
     * @param integer $status
     * @return User
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return User
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set lastLogin
     *
     * @param \DateTime $lastLogin
     * @return User
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    /**
     * Get lastLogin
     *
     * @return \DateTime 
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }
    /**
     * Get password change request
     * @return User\Entity\UserPasswordChange
     */
    public function getPasswordChange(){
        return $this->passwordChange;
    }
    
    /**
     * Set password change request
     * @return User
     */   
    public function setPasswordChange(\User\Entity\UserPasswordChange $passwordChange){
        $this->passwordChange=$passwordChange;
        return $this;
    }
   
        /**
     * Get user profile
     * @return User\Entity\UserProfile
     */
    public function getProfile(){
        return $this->profile;
    }
    
    /**
     * Set password change request
     * @return User
     */   
    public function setProfile(\User\Entity\UserProfile $profile){
        $this->profile=$profile;
        return $this;
    }
/**
* @ORM\PrePersist
*/
    public function prePersist() {
    if(!$this->created){
        $this->setCreated(new \DateTime());
    }
    if(is_null($this->status)){
        $this->setStatus(self::INACTIVE);
    }
    if(!is_null($this->password)){
        $this->setPassword(md5($this->password));
    }
}
    
    
}
