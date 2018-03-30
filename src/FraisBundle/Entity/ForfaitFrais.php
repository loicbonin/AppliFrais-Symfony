<?php
namespace FraisBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * ForfaitFrais
 *
 * @ORM\Table(name="forfait_frais")
 * @ORM\Entity(repositoryClass="FraisBundle\Repository\ForfaitFraisRepository")
 */
class ForfaitFrais
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
     * @ORM\Column(name="quantity", type="string", length=255)
     */
    private $quantity;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_du_frais", type="datetime")
     */
    private $dateDuFrais;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="derniere_edition", type="datetime")
     */
    private $derniereEdition;

    /**
     * @var string [le commentaire du frais forfait]
     *
     * @ORM\Column(name="comment", type="string", length=255, nullable=true)
     */
    private $comment;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;

    // LIAISON ENTITEES

    /**
     * @ORM\ManyToOne(targetEntity="FraisBundle\Entity\Forfait", inversedBy="forfaitFrais", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     *
     */
    private $forfait;

    /**
     * @ORM\ManyToOne(targetEntity="FraisBundle\Entity\FicheFrais", inversedBy="frais", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     *
     */
    private $ficheFrais;

    /**
     * @ORM\ManyToOne(targetEntity="FraisBundle\Entity\Etat", inversedBy="forfaitFrais", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     *
     */
    private $etat;

     public function __construct(){
        $this->created = new \DateTime();
        $this->derniereEdition = new\DateTime();
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
     * Set quantity
     *
     * @param string $quantity
     *
     * @return ForfaitFrais
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }
    /**
     * Get quantity
     *
     * @return string
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
    /**
     * Set dateDuFrais
     *
     * @param \DateTime $dateDuFrais
     *
     * @return ForfaitFrais
     */
    public function setDateDuFrais($dateDuFrais)
    {
        $this->dateDuFrais = $dateDuFrais;
        return $this;
    }
    /**
     * Get dateDuFrais
     *
     * @return \DateTime
     */
    public function getDateDuFrais()
    {
        return $this->dateDuFrais;
    }
    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return ForfaitFrais
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }
    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }
    /**
     * Set derniereEdition
     *
     * @param \DateTime $derniereEdition
     *
     * @return ForfaitFrais
     */
    public function setDerniereEdition($derniereEdition)
    {
        $this->derniereEdition = $derniereEdition;
        return $this;
    }
    /**
     * Get derniereEdition
     *
     * @return \DateTime
     */
    public function getDerniereEdition()
    {
        return $this->derniereEdition;
    }

    /**
     * Set ficheFrais
     *
     * @param \FraisBundle\Entity\FicheFrais $ficheFrais
     *
     * @return ForfaitFrais
     */
    public function setFicheFrais(\FraisBundle\Entity\FicheFrais $ficheFrais)
    {
        $this->ficheFrais = $ficheFrais;

        return $this;
    }

    /**
     * Get ficheFrais
     *
     * @return \FraisBundle\Entity\FicheFrais
     */
    public function getFicheFrais()
    {
        return $this->ficheFrais;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return ForfaitFrais
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return ForfaitFrais
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add forfait
     *
     * @param \FraisBundle\Entity\Forfait $forfait
     *
     * @return ForfaitFrais
     */
    public function addForfait(\FraisBundle\Entity\Forfait $forfait)
    {
        $this->forfait[] = $forfait;

        return $this;
    }

    /**
     * Remove forfait
     *
     * @param \FraisBundle\Entity\Forfait $forfait
     */
    public function removeForfait(\FraisBundle\Entity\Forfait $forfait)
    {
        $this->forfait->removeElement($forfait);
    }

    /**
     * Get forfait
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getForfait()
    {
        return $this->forfait;
    }

    /**
     * Set etat
     *
     * @param \FraisBundle\Entity\Etat $etat
     *
     * @return ForfaitFrais
     */
    public function setEtat(\FraisBundle\Entity\Etat $etat = null)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return \FraisBundle\Entity\Etat
     */
    public function getEtat()
    {
        return $this->etat;
    }
}
