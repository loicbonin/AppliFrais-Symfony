<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="old_password", type="string", length=255, nullable=true)
     */
    protected $oldPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="job", type="string", length=255, nullable=true)
     */
    private $job;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="zip_code", type="string", length=255, nullable=true)
     */
    private $zipCode;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birth_date", type="date", nullable=true)
     */
    private $birthDate;

    /**
     * @var string
     *
     * @ORM\Column(name="fuel", type="string", length=255, nullable=true)
     */
    private $fuel;

    /**
     * @var string
     *
     * @ORM\Column(name="fiscal_power", type="string", length=255, nullable=true)
     */
    private $fiscalPower;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hiring_date", type="datetime", nullable=true)
     */
    private $hiringDate;

    /**
     * @ORM\OneToMany(targetEntity="FraisBundle\Entity\FicheFrais", mappedBy="user", cascade={"persist"})
     *
     *
     */
    private $ficheFrais;

    public function __construct()
    {
        $this->username = $this->firstName.$this->lastName;
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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set oldPassword
     *
     * @param string $oldPassword
     *
     * @return User
     */
    public function setOldPassword($oldPassword)
    {
        $this->oldPassword = $oldPassword;

        return $this;
    }

    /**
     * Get oldPassword
     *
     * @return string
     */
    public function getOldPassword()
    {
        return $this->oldPassword;
    }

    /**
     * Set job
     *
     * @param string $job
     *
     * @return User
     */
    public function setJob($job)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job
     *
     * @return string
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return User
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
     * Set zipCode
     *
     * @param string $zipCode
     *
     * @return User
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Get zipCode
     *
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return User
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set birthDate
     *
     * @param string $birthDate
     *
     * @return User
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return string
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set fuel
     *
     * @param string $fuel
     *
     * @return User
     */
    public function setFuel($fuel)
    {
        $this->fuel = $fuel;

        return $this;
    }

    /**
     * Get fuel
     *
     * @return string
     */
    public function getFuel()
    {
        return $this->fuel;
    }

    /**
     * Set fiscalPower
     *
     * @param string $fiscalPower
     *
     * @return User
     */
    public function setFiscalPower($fiscalPower)
    {
        $this->fiscalPower = $fiscalPower;

        return $this;
    }

    /**
     * Get fiscalPower
     *
     * @return string
     */
    public function getFiscalPower()
    {
        return $this->fiscalPower;
    }

    /**
     * Set hiringDate
     *
     * @param string $hiringDate
     *
     * @return User
     */
    public function setHiringDate($hiringDate)
    {
        $this->hiringDate = $hiringDate;

        return $this;
    }

    /**
     * Get hiringDate
     *
     * @return string
     */
    public function getHiringDate()
    {
        return $this->hiringDate;
    }

    /**
     * Add ficheFrai
     *
     * @param \FraisBundle\Entity\FicheFrais $ficheFrai
     *
     * @return User
     */
    public function addFicheFrai(\FraisBundle\Entity\FicheFrais $ficheFrai)
    {
        $this->ficheFrais[] = $ficheFrai;
        $ficheFrai->setUser($this);
        return $this;
    }

    /**
     * Remove ficheFrai
     *
     * @param \FraisBundle\Entity\FicheFrais $ficheFrai
     */
    public function removeFicheFrai(\FraisBundle\Entity\FicheFrais $ficheFrai)
    {
        $this->ficheFrais->removeElement($ficheFrai);
    }

    /**
     * Get ficheFrais
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFicheFrais()
    {
        return $this->ficheFrais;
    }
}
