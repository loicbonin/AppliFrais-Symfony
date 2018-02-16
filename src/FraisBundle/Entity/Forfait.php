<?php
namespace FraisBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Forfait
 *
 * @ORM\Table(name="forfait")
 * @ORM\Entity(repositoryClass="FraisBundle\Repository\ForfaitRepository")
 */
class Forfait
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
     * @var float
     *
     * @ORM\Column(name="unit_price", type="float", nullable=true)
     */
    private $unitPrice;
    /**
     * @var string
     *
     * @ORM\Column(name="wording", type="string", length=255)
     */
    private $wording;
    // LIAISON ENTITEES

    /*
     * @ORM\ManyToMany(targetEntity="FraisBundle\Entity\ForfaitFrais")
     * @ORM\JoinColumn(nullable=false)
     *
     *
    private $forfaitFrais;
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
     * Set unitPrice
     *
     * @param float $unitPrice
     *
     * @return Forfait
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;
        return $this;
    }
    /**
     * Get unitPrice
     *
     * @return float
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }
    /**
     * Set wording
     *
     * @param string $wording
     *
     * @return Forfait
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
}
