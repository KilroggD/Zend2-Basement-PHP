<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserActivation
 *
 * @ORM\Table(name="user_activation")
 * @ORM\Entity
 */
class UserActivation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="user_activation_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=140, nullable=true)
     */
    private $token;

    /**
     * @var \User\Entity\Users
     *
      * @ORM\OneToOne(targetEntity="User\Entity\Users", inversedBy="userActivation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;



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
     * Set token
     *
     * @param string $token
     * @return UserActivation
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set user
     *
     * @param \User\Entity\Users $user
     * @return UserActivation
     */
    public function setUser(\User\Entity\Users $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \User\Entity\Users 
     */
    public function getUser()
    {
        return $this->user;
    }
}
