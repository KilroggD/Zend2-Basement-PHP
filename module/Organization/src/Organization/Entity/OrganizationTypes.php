<?php

namespace Organization\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrganizationTypes
 *
 * @ORM\Table(name="organization_types")
 * @ORM\Entity
 */
class OrganizationTypes {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="organization_types_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=512, nullable=true)
     */
    private $name;

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
     * @return OrganizationTypes
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
     * @var integer
     */
    private $builtIn = 0;

    /**
     * Set builtIn
     *
     * @param integer $builtIn
     * @return OrganizationTypes
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

}
