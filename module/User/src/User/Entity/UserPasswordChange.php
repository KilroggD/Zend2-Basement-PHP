<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserPasswordChange
 *
 * @ORM\Table(name="user_password_change")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class UserPasswordChange {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="user_password_change_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=256, nullable=false)
     */
    private $token;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var \User\Entity\Users
     *
     * @ORM\OneToOne(targetEntity="User\Entity\Users", inversedBy="passwordChange")
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
    public function getId() {
        return $this->id;
    }

    /**
     * Set token
     *
     * @param string $token
     * @return UserPasswordChange
     */
    public function setToken($token) {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken() {
        return $this->token;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return UserPasswordChange
     */
    public function setCreated($created) {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated() {
        return $this->created;
    }

    /**
     * Set user
     *
     * @param \User\Entity\Users $user
     * @return UserPasswordChange
     */
    public function setUser(\User\Entity\Users $user = null) {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \User\Entity\Users 
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist() {
        if (!$this->created) {
            $this->setCreated(new \DateTime());
        }
    }

}
