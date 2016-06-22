<?php

namespace Acl\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AclRoles
 *
 * @ORM\Table(name="acl_roles")
 * @ORM\Entity(repositoryClass="\Acl\Repository\AclRolesRepository")
 */
class AclRoles {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="acl_roles_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=140, nullable=false)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="built_in", type="smallint", nullable=true)
     */
    private $builtIn = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="hidden", type="smallint", nullable=true)
     */
    private $hidden = '0';

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="User\Entity\Users", mappedBy="roles")
     */
    private $users;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Acl\Entity\AclPermissions", inversedBy="roles")
     * @ORM\JoinTable(name="acl_roles_to_permissions",
     *   joinColumns={
     *     @ORM\JoinColumn(name="roles", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="permissions", referencedColumnName="id")
     *   }
     * )
     */
    private $permissions;

    /**
     * Constructor
     */
    public function __construct() {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->permissions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return AclRoles
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set builtIn
     * 
     * @param integer $builtIn
     * @return AclRoles
     */
    public function setBuiltIn($builtIn) {
        $this->builtIn = $builtIn;
        return $this;
    }

    /**
     * Get builtIn
     *
     * @return integer 
     */
    public function getBuiltIn() {
        return $this->builtIn;
    }

    /**
     * Set hidden
     * 
     * @param integer $hidden
     * @return AclRoles
     */
    public function setHidden($hidden) {
        $this->hidden = $hidden;
        return $this;
    }

    /**
     * Get hidden
     *
     * @return integer 
     */
    public function getHidden() {
        return $this->hidden;
    }

    /**
     * Add users
     *
     * @param \User\Entity\Users $users
     * @return AclRoles
     */
    public function addUser(\User\Entity\Users $users) {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \User\Entity\Users $users
     */
    public function removeUser(\User\Entity\Users $users) {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers() {
        return $this->users;
    }

    /**
     * Add permissions
     *
     * @param \Acl\Entity\AclPermissions $permissions
     * @return AclRoles
     */
    public function addPermission(\Acl\Entity\AclPermissions $permissions) {
        $this->permissions[] = $permissions;

        return $this;
    }

    /**
     * Remove permissions
     *
     * @param \Acl\Entity\AclPermissions $permissions
     */
    public function removePermission(\Acl\Entity\AclPermissions $permissions) {
        $this->permissions->removeElement($permissions);
    }

    /**
     * Get permissions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPermissions() {
        return $this->permissions;
    }

}
