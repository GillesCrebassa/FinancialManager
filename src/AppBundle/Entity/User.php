<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Account", mappedBy="user")
     */
    private $accounts;

    /**
     * @ORM\OneToMany(targetEntity="TransferAccountsStatementFile", mappedBy="user")
     */
    private $transferFile;

    public function __construct()
    {
        parent::__construct();
        $this->accounts = new ArrayCollection();
        $this->transferFile = new ArrayCollection();
        // your own logic
    }

    public function getAccounts()
    {
        return $this->accounts;
    }

    public function getTransferFile()
    {
        return $this->transferFile;
    }

}
