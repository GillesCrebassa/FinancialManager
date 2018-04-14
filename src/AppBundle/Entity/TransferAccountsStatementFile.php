<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Transfer
 *
 * @ORM\Table(name="transferAccountsStatementFile")
 * @ORM\Entity(repositoryClass="\AppBundle\Repository\TransferAccountsStatementFileRepository")
 * @UniqueEntity("id")
 */
class TransferAccountsStatementFile
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
     * @ORM\Column(name="transferAccountsStatementFileId", type="integer")
     * @Assert\NotBlank()
     */
    // TODO to link with AccountsStatementFile
    private $accountsStatementFileId;

    /**
     * @var string
     *
     * @ORM\Column(name="sequenceNumber", type="string", length=255, nullable=false)
     */
    private $sequenceNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="executionDate", type="string", length=255, nullable=false)
     */
    private $executionDate;

    /**
     * @var string
     *
     * @ORM\Column(name="valueDate", type="string", length=255, nullable=false)
     */
    private $valueDate;

    /**
     * @var string
     *
     * @ORM\Column(name="amount", type="string", length=255, nullable=false)
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string", length=20, nullable=false)
     */
    private $currency;

    /**
     * @var string
     *
     * @ORM\Column(name="counterpartment", type="string", length=50, nullable=false)
     */
    private $counterpartment;

    
    /**
     * @var string
     *
     * @ORM\Column(name="details", type="string", length=255, nullable=true)
     */
    private $details;

    /**
     * @var string
     *
     * @ORM\Column(name="accountNumber", type="string", length=20, nullable=false)
     */
    private $accountNumber;
    /**
     * @var user
     *
     * @ORM\ManyToOne(targetEntity="User",inversedBy="transferFile")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")     
     * @Assert\NotBlank()
     */
    private $user;



    public function __construct()
    {
    }    
    
    public function __toString()
    {
           return "{$this->getAccountId()}";
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
     * Set AccountsStatementFileId
     *
     * @param string AccountsStatementFileId
     *
     * @return TransferAccountsStatementFile
     */
    public function setAccountsStatementFileId($accountsStatementFileId)
    {
        $this->accountsStatementFileId = $accountsStatementFileId;

        return $this;
    }

    /**
     * Get accountsStatementFileId
     *
     * @return string
     */
    public function getAccountsStatementFileId()
    {
        return $this->accountsStatementFileId;
    }

    /**
     * Set sequenceNumber
     *
     * @param string sequenceNumber
     *
     * @return TransferAccountsStatementFile
     */
    public function setSequenceNumber($sequenceNumber)
    {
        $this->sequenceNumber = $sequenceNumber;

        return $this;
    }

    /**
     * Get sequenceNumber
     *
     * @return string
     */
    public function getSequenceNumber()
    {
        return $this->sequenceNumber;
    }
    

    /**
     * Set executionDate
     *
     * @param string executionDate
     *
     * @return TransferAccountsStatementFile
     */
    public function setExecutionDate($executionDate)
    {
        $this->executionDate = $executionDate;

        return $this;
    }

    /**
     * Get executionDate
     *
     * @return string
     */
    public function getExecutionDate()
    {
        return $this->executionDate;
    }
        
    /**
     * Set valueDate
     *
     * @param string valueDate
     *
     * @return TransferAccountsStatementFile
     */
    public function setValueDate($valueDate)
    {
        $this->valueDate = $valueDate;

        return $this;
    }

    /**
     * Get valueDate
     *
     * @return string
     */
    public function getValueDate()
    {
        return $this->valueDate;
    }
    
        
    /**
     * Set amount
     *
     * @param string amount
     *
     * @return TransferAccountsStatementFile
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }
    
    
        
    /**
     * Set currency
     *
     * @param string currency
     *
     * @return TransferAccountsStatementFile
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }
    
    /**
     * Set counterpartment
     *
     * @param string counterpartment
     *
     * @return TransferAccountsStatementFile
     */
    public function setCounterpartment($counterpartment)
    {
        $this->counterpartment = $counterpartment;

        return $this;
    }

    /**
     * Get counterpartment
     *
     * @return string
     */
    public function getCounterpartment()
    {
        return $this->counterpartment;
    }    
    
    
    
    /**
     * Set details
     *
     * @param string details
     *
     * @return TransferAccountsStatementFile
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get details
     *
     * @return string
     */
    public function getdetails()
    {
        return $this->details;
    }    
    
    /**
     * Set accountNumber
     *
     * @param string accountNumber
     *
     * @return TransferAccountsStatementFile
     */
    public function setAccountNumber($accountNumber)
    {
        $this->accountNumber = $accountNumber;

        return $this;
    }

    /**
     * Get accountNumber
     *
     * @return string
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    /**
     * Set user
     *
     * @param string user
     *
     * @return TransferAccountsStatementFile
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


}
