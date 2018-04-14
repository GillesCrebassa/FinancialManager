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
     * @var user
     *
     * @ORM\ManyToOne(targetEntity="User",inversedBy="accounts")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")     
     * @Assert\NotBlank()
     */
    private $user;

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


    /**
     * @ORM\OneToMany(targetEntity="Transfer", mappedBy="account")
     */
    private $transfers;





    public function __construct()
    {
        $this->transfers = new ArrayCollection();
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
     * Set user
     *
     * @param string user
     *
     * @return user
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
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
    
    public function getTransfers()
    {
        return $this->transfers;
    }

    
}
