<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Account
 *
 * @ORM\Table(name="account")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AccountRepository")
 * @UniqueEntity("id")
 */
class Account
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
     * @var int
     *
     * @ORM\Column(name="userId", type="integer")
     * @Assert\NotBlank()
     */
    // TODO to link with User
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="accountName", type="string", length=255, nullable=false)
     */
    private $accountName;

    /**
     * @var string
     *
     * @ORM\Column(name="accountReference", type="string", length=255, nullable=false)
     */
    private $accountReference;

    public function __construct()
    {
    }    
    
    public function __toString()
    {
           return "{$this->getAccountName()}";
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
     * Set userId
     *
     * @param string userId
     *
     * @return userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set accountName
     *
     * @param string accountName
     *
     * @return Account
     */
    public function setAccountName($accountName)
    {
        $this->accountName = $accountName;

        return $this;
    }

    /**
     * Get executionDate
     *
     * @return string
     */
    public function getAccountName()
    {
        return $this->accountName;
    }
    
    /**
     * Set accountReference
     *
     * @param string accountReference
     *
     * @return Account
     */
    public function setAccountReference($accountReference)
    {
        $this->accountReference = $accountReference;

        return $this;
    }

    /**
     * Get accountReference
     *
     * @return string
     */
    public function getAccountReference()
    {
        return $this->accountReference;
    }
    
}
