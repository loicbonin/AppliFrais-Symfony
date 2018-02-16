<?php
namespace FraisBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Etat
 *
 * @ORM\Table(name="etat")
 * @ORM\Entity(repositoryClass="FraisBundle\Repository\EtatRepository")
 */
class Etat
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
     * @ORM\Column(name="wording", type="string", length=255)
     */
    private $wording;
    /**
     * @var string
     *
     * @ORM\Column(name="priority", type="string", length=255)
     */
    private $priority;
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
     * Set wording
     *
     * @param string $wording
     *
     * @return Etat
     */
    public function setWording($wording)
    {
        $this->wording = $wording;
        return $this;
    }
    /**
     * Get wording
     *
     * @return string
     */
    public function getWording()
    {
        return $this->wording;
    }
    /**
     * Set priority
     *
     * @param string $priority
     *
     * @return Etat
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
        return $this;
    }
    /**
     * Get priority
     *
     * @return string
     */
    public function getPriority()
    {
        return $this->priority;
    }
}
