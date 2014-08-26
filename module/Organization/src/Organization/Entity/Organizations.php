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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=512, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="short_name", type="string", length=255, nullable=true)
     */
    private $shortName;

    /**
     * @var string
     *
     * @ORM\Column(name="inn", type="string", length=12, nullable=true)
     */
    private $inn;

    /**
     * @var string
     *
     * @ORM\Column(name="kpp", type="string", length=12, nullable=true)
     */
    private $kpp;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var \Organization\Entity\OrganizationTypes
     *
     * @ORM\ManyToOne(targetEntity="Organization\Entity\OrganizationTypes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type", referencedColumnName="id")
     * })
     */
    private $type;
    
    /**
     *
     * @var type 
     * @ORM\OneToMany(targetEntity="User\Entity\Users", mappedBy="grp")
     * 
     */
    private $users;


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
        return $this->shortName;
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
        return $this->inn;
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
        return $this->kpp;
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
        return $this->address;
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
        return $this->type;
    }
    
    
    public function getUsers(){
        return $this->users;
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
* @ORM\PrePersist
*/
    public function prePersist() {
    if(!$this->created){
        $this->setCreated(new \DateTime());
    }
    }
    /**
     * @var integer
     */
    private $builtIn=0;


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
}
