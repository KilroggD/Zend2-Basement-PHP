<?php

namespace Organization\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrganizationProfile
 *
 * @ORM\Table(name="organization_profile", indexes={@ORM\Index(name="organization_profile_type_idx", columns={"type"}), @ORM\Index(name="IDX_4C85224CC1EE637C", columns={"organization"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class OrganizationProfile {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="organization_profile_id_seq", allocationSize=1, initialValue=1)
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
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */
    private $created;

    /**
     * @var \Organization\Entity\Organizations
     *
     * @ORM\ManyToOne(targetEntity="Organization\Entity\Organizations")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="organization", referencedColumnName="id")
     * })
     */
    private $organization;

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
     * @return OrganizationProfile
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
     * Set shortName
     *
     * @param string $shortName
     * @return OrganizationProfile
     */
    public function setShortName($shortName) {
        $this->shortName = $shortName;

        return $this;
    }

    /**
     * Get shortName
     *
     * @return string 
     */
    public function getShortName() {
        return $this->shortName;
    }

    /**
     * Set inn
     *
     * @param string $inn
     * @return OrganizationProfile
     */
    public function setInn($inn) {
        $this->inn = $inn;

        return $this;
    }

    /**
     * Get inn
     *
     * @return string 
     */
    public function getInn() {
        return $this->inn;
    }

    /**
     * Set kpp
     *
     * @param string $kpp
     * @return OrganizationProfile
     */
    public function setKpp($kpp) {
        $this->kpp = $kpp;

        return $this;
    }

    /**
     * Get kpp
     *
     * @return string 
     */
    public function getKpp() {
        return $this->kpp;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return OrganizationProfile
     */
    public function setAddress($address) {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress() {
        return $this->address;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return OrganizationProfile
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
     * Set organization
     *
     * @param \Organization\Entity\Organizations $organization
     * @return OrganizationProfile
     */
    public function setOrganization(\Organization\Entity\Organizations $organization = null) {
        $this->organization = $organization;

        return $this;
    }

    /**
     * Get organization
     *
     * @return \Organization\Entity\Organizations 
     */
    public function getOrganization() {
        return $this->organization;
    }

    /**
     * Set type
     *
     * @param \Organization\Entity\OrganizationTypes $type
     * @return OrganizationProfile
     */
    public function setType(\Organization\Entity\OrganizationTypes $type = null) {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \Organization\Entity\OrganizationTypes 
     */
    public function getType() {
        return $this->type;
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
