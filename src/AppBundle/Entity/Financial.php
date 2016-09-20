<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


use AppBundle\Entity\EnvDetails;
/**
 * Environment
 *
 * @ORM\Table(name="environment")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EnvironmentRepository")
 * @UniqueEntity("name")
 */
class Environment
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     * @Assert\NotBlank()     
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="EnvDetails", mappedBy="environment")
     */    
    private $envDetails;
    
    public function __construct()
    {
        $this->envDetails = new ArrayCollection();
    }    
    
    public function __toString()
    {
           return "{$this->getName()}";
    }
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Environment
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
     * Set description
     *
     * @param string $description
     *
     * @return Environment
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
     * Add env details
     *
     * @param \AppBundle\Entity\EnvDetails $envDetails
     *
     * @return Environment
     */
    public function addEnvDetails(\AppBundle\Entity\EnvDetails $envDetails)
    {
        $this->envDetails[] = $envDetails;

        return $this;
    }

    /**
     * Remove envDetails
     *
     * @param \AppBundle\Entity\EnvDetails $envDetails
     */
    public function removeEnvDetails(\AppBundle\Entity\EnvDetails $envDetails)
    {
        $this->envDetails->removeElement($envDetails);
    }

    /**
     * Get envDetails
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEnvDetails()
    {
        return $this->envDetails;
    }

    /**
     * Add envDetail
     *
     * @param \AppBundle\Entity\EnvDetails $envDetail
     *
     * @return Environment
     */
    public function addEnvDetail(\AppBundle\Entity\EnvDetails $envDetail)
    {
        $this->envDetails[] = $envDetail;

        return $this;
    }

    /**
     * Remove envDetail
     *
     * @param \AppBundle\Entity\EnvDetails $envDetail
     */
    public function removeEnvDetail(\AppBundle\Entity\EnvDetails $envDetail)
    {
        $this->envDetails->removeElement($envDetail);
    }
}
