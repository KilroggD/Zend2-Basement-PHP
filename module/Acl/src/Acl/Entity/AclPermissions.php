<?php

namespace Acl\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;
/**
 * AclPermissions
 *
 * @ORM\Table(name="acl_permissions")
 * @ORM\Entity(repositoryClass="\Acl\Repository\AclPermissionsRepository")
 */
class AclPermissions
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="acl_permissions_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="controller", type="string", length=255, nullable=false)
     */
    private $controller;

    /**
     * @var string
     *
     * @ORM\Column(name="action", type="string", length=255, nullable=true)
     */
    private $action;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="system", type="smallint", nullable=true)
     */
    private $system = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="exclude", type="smallint", nullable=true)
     */
    private $exclude = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="grp", type="string", length=140, nullable=true)
     */
    private $grp;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Acl\Entity\AclRoles", mappedBy="permissions")
     */
    private $roles;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set controller
     *
     * @param string $controller
     * @return AclPermissions
     */
    public function setController($controller)
    {
        $this->controller = $controller;

        return $this;
    }

    /**
     * Get controller
     *
     * @return string 
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Set action
     *
     * @param string $action
     * @return AclPermissions
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return string 
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return AclPermissions
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set system
     *
     * @param integer $system
     * @return AclPermissions
     */
    public function setSystem($system)
    {
        $this->system = $system;

        return $this;
    }

    /**
     * Get system
     *
     * @return integer 
     */
    public function getSystem()
    {
        return $this->system;
    }

    /**
     * Set exclude
     *
     * @param integer $exclude
     * @return AclPermissions
     */
    public function setExclude($exclude)
    {
        $this->exclude = $exclude;

        return $this;
    }

    /**
     * Get exclude
     *
     * @return integer 
     */
    public function getExclude()
    {
        return $this->exclude;
    }

    /**
     * Set grp
     *
     * @param string $grp
     * @return AclPermissions
     */
    public function setGrp($grp)
    {
        $this->grp = $grp;

        return $this;
    }

    /**
     * Get grp
     *
     * @return string 
     */
    public function getGrp()
    {
        return $this->grp;
    }

    /**
     * Add roles
     *
     * @param \Acl\Entity\AclRoles $roles
     * @return AclPermissions
     */
    public function addRole(\Acl\Entity\AclRoles $roles)
    {
        $this->roles[] = $roles;

        return $this;
    }

    /**
     * Remove roles
     *
     * @param \Acl\Entity\AclRoles $roles
     */
    public function removeRole(\Acl\Entity\AclRoles $roles)
    {
        $this->roles->removeElement($roles);
    }

    /**
     * Get roles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRoles()
    {
        return $this->roles;
    }
}
