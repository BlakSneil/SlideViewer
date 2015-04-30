<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 */
class Person
{
    /**
     * @ORM\Id()
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="first_name", type="string", length=50)
     */
    protected $firstName;

    /**
     * @ORM\Column(name="surname", type="string", length=50)
     */
    protected $surname;

    /**
     * @ORM\Column(name="fiscal_code", type="string", length=16, nullable=true)
     */
    protected $fiscalCode;

    /**
     * @ORM\Column(name="birthday", type="date", nullable=true)
     */
    protected $birthday;

    /**
     * @ORM\Column(name="street_name", type="string", length=50, nullable=true)
     */
    private $streetName;

    /**
     * @ORM\Column(name="street_number", type="string", length=10, nullable=true)
     */
    protected $streetNumber;

    /**
     * @ORM\Column(name="locality", type="string", length=50, nullable=true)
     */
    protected $locality;

    /**
     * @ORM\Column(name="zip_code", type="string", length=10, nullable=true)
     */
    protected $zipCode;

    /**
     * @ORM\Column(name="state", type="string", length=50, nullable=true)
     */
    protected $state;

    /**
     * @ORM\Column(name="telephone_number", type="string", length=50, nullable=true)
     */
    protected $telephoneNumber;

    /**
     * @ORM\Column(name="cellular_number", type="string", length=50, nullable=true)
     */
    protected $cellularNumber;

    /**
     * @ORM\Column(name="email", type="string", length=50, nullable=true)
     */
    protected $email;

    /**
     * @ORM\Column(name="notes", type="string", nullable=true)
     */
    protected $notes;

    /**
     * @ORM\Column(name="date_creation", type="date", nullable=true)
     */
    protected $dateCreation;

    /**
     * @ORM\Column(name="date_edit", type="date", nullable=true)
     */
    protected $dateEdit;


    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

   /**
     * @return string
     */
    public function getFiscalCode()
    {
        return $this->fiscalCode;
    }

    /**
     * @param string $fiscalCode
     */
    public function setFiscalCode($fiscalCode)
    {
        $this->fiscalCode = $fiscalCode;
    }

    /**
     * @return string
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param string $surname
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getDateEdit()
    {
        return $this->dateEdit;
    }

    /**
     * @param mixed $dateEdit
     */
    public function setDateEdit($dateEdit)
    {
        $this->dateEdit = $dateEdit;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getStreetName()
    {
        return $this->streetName;
    }

    /**
     * @param mixed $streetName
     */
    public function setStreetName($streetName)
    {
        $this->streetName = $streetName;
    }

    /**
     * @return mixed
     */
    public function getStreetNumber()
    {
        return $this->streetNumber;
    }

    /**
     * @param mixed $streetNumber
     */
    public function setStreetNumber($streetNumber)
    {
        $this->streetNumber = $streetNumber;
    }

    /**
     * @return string
     */
    public function getLocality()
    {
        return $this->locality;
    }

    /**
     * @param string $locality
     */
    public function setLocality($locality)
    {
        $this->locality = $locality;
    }

    /**
     * @return mixed
     */
    public function getTelephoneNumber()
    {
        return $this->telephoneNumber;
    }

    /**
     * @param mixed $telephoneNumber
     */
    public function setTelephoneNumber($telephoneNumber)
    {
        $this->telephoneNumber = $telephoneNumber;
    }

    /**
     * @return mixed
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * @param mixed $zipCode
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
    }

    /**
     * @return string
     */
    public function getCellularNumber()
    {
        return $this->cellularNumber;
    }

    /**
     * @param string $cellularNumber
     */
    public function setCellularNumber($cellularNumber)
    {
        $this->cellularNumber = $cellularNumber;
    }

    /**
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param string $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    /**
     * @return date
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @param date $dateCreation
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
    } 

    /**
     * @return string
     */
    public function getName()
    {
        return $this->firstName . ' ' . $this->surname;
    }
}