<?php

namespace Organization\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Organizations
 *
 * @ORM\Table(name="organizations", indexes={@ORM\Index(name="IDX_427C1C7F8CDE5729", columns={"type"})})
 * @ORM\Entity(repositoryClass="\Organization\Repository\OrganizationsRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Organizations
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="organizations_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

  /**
   *
   * @var string 
   * @ORM\Column(name="name", type="string", length=512, nullable=false)
   */
    
    private $name;
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
     * Set name
     *
     * @param string $name
     * @return Organizations
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
     * Set shortName
     *
     * @param string $shortName
     * @return Organizations
     */
    public function setShortName($shortName)
    {
        $this->shortName = $shortName;

        return $this;
    }

    /**
     * Get shortName
     *
     * @return string 
     */
    public function getShortName()
    {
        return $this->getActualVersion()->getShortName();
    }

    /**
     * Set inn
     *
     * @param string $inn
     * @return Organizations
     */
    public function setInn($inn)
    {
        $this->inn = $inn;

        return $this;
    }

    /**
     * Get inn
     *
     * @return string 
     */
    public function getInn()
    {
        return $this->getActualVersion()->getInn();
    }

    /**
     * Set kpp
     *
     * @param string $kpp
     * @return Organizations
     */
    public function setKpp($kpp)
    {
        $this->kpp = $kpp;

        return $this;
    }

    /**
     * Get kpp
     *
     * @return string 
     */
    public function getKpp()
    {
        return $this->getActualVersion()->getKpp();
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Organizations
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->getActualVersion()->getAddress();
    }

    /**
     * Set type
     *
     * @param \Organization\Entity\OrganizationTypes $type
     * @return Organizations
     */
    public function setType(\Organization\Entity\OrganizationTypes $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \Organization\Entity\OrganizationTypes 
     */
    public function getType()
    {
        return $this->getActualVersion()->getType();
    }
    
    
    /**
     * @var \DateTime
     */
    private $created;


    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Organizations
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
     * @var integer
     *
     * @ORM\Column(name="built_in", type="smallint", nullable=true)
     */
    private $builtIn='0';


    /**
     * Set builtIn
     *
     * @param integer $builtIn
     * @return Organizations
     */
    public function setBuiltIn($builtIn)
    {
        $this->builtIn = $builtIn;

        return $this;
    }

    /**
     * Get builtIn
     *
     * @return integer 
     */
    public function getBuiltIn()
    {
        return $this->builtIn;
    }
  
        /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="User\Entity\Users", mappedBy="organizations")
     */
    private $users;
   

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->activities = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add users
     *
     * @param \User\Entity\Users $users
     * @return Organizations
     */
    public function addUser(\User\Entity\Users $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \User\Entity\Users $users
     */
    public function removeUser(\User\Entity\Users $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }
 
   
    /**
     * @var \Organization\Entity\OrganizationProfile
     *
     * @ORM\OneToOne(targetEntity="Organization\Entity\OrganizationProfile", cascade={"all"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="actual_version", referencedColumnName="id",  unique=true)
     * })
     */
    private $actualVersion;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Organization\Entity\OrganizationProfile", mappedBy="organization", cascade={"all"}, orphanRemoval=true)
     */
    private $versions;


    /**
     * Set actualVersion
     *
     * @param \Organization\Entity\OrganizationProfile $actualVersion
     * @return Organizations
     */
    public function setActualVersion(\Organization\Entity\OrganizationProfile $actualVersion = null)
    {  	
	
	$this->actualVersion=$actualVersion;
	if($actualVersion){
                $this->setName($actualVersion->getName());
		$actualVersion->setOrganization($this);
		}
   //     $this->addVersion($actualVersion);    
        return $this;
    }

    /**
     * Get actualVersion
     *
     * @return \Organization\Entity\OrganizationProfile 
     */
    public function getActualVersion()
    {
        return $this->actualVersion;
    }

    /**
     * Add versions
     *
     * @param \Organization\Entity\OrganizationProfile $versions
     * @return Organizations
     */
    public function addVersion(\Organization\Entity\OrganizationProfile $versions)
    {
        $this->versions[] = $versions;
		$versions->setOrganization($this);
        return $this;
    }

    /**
     * Remove versions
     *
     * @param \Organization\Entity\OrganizationProfile $versions
     */
    public function removeVersion(\Organization\Entity\OrganizationProfile $versions)
    {
        $this->versions->removeElement($versions);
    }

    /**
     * Get versions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVersions()
    {
        return $this->versions;
    }
    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="smallint", nullable=false)
     */
    private $status=1;


    /**
     * Set status
     *
     * @param integer $status
     * @return Organizations
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
* @ORM\PrePersist
*/
    public function prePersist() {
    if(!$this->created){
        $this->setCreated(new \DateTime());
    }
    }     
       /**
* @ORM\PrePersist
* @ORM\PreUpdate
*/ 
   /* public function actual(){
	$this->actualVersion=end($this->versions);
	}*/
	
}
