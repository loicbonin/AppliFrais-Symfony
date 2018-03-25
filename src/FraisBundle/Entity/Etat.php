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
     * //le libellé
     * @ORM\Column(name="wording", type="string", length=255)
     */
    private $wording;
    /**
     * @var string
     * // la priorité
     * @ORM\Column(name="priority", type="string", length=255)
     */
    private $priority;

    /**
     * @ORM\OneToMany(targetEntity="FraisBundle\Entity\FicheFrais", mappedBy="etat", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     *
     */
    private $ficheFrais;

    /**
     * @ORM\OneToMany(targetEntity="FraisBundle\Entity\ForfaitFrais", mappedBy="etat", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     *
     */
    private $forfaitFrais;

    /**
     * @ORM\OneToMany(targetEntity="FraisBundle\Entity\ForfaitHorsFrais", mappedBy="etat", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     *
     */
    private $forfaitHorsFrais;

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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ficheFrais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->forfaitFrais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->forfaitHorsFrais = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add ficheFrai
     *
     * @param \FraisBundle\Entity\FicheFrais $ficheFrai
     *
     * @return Etat
     */
    public function addFicheFrai(\FraisBundle\Entity\FicheFrais $ficheFrai)
    {
        $this->ficheFrais[] = $ficheFrai;

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

    /**
     * Add forfaitFrai
     *
     * @param \FraisBundle\Entity\ForfaitFrais $forfaitFrai
     *
     * @return Etat
     */
    public function addForfaitFrai(\FraisBundle\Entity\ForfaitFrais $forfaitFrai)
    {
        $this->forfaitFrais[] = $forfaitFrai;

        return $this;
    }

    /**
     * Remove forfaitFrai
     *
     * @param \FraisBundle\Entity\ForfaitFrais $forfaitFrai
     */
    public function removeForfaitFrai(\FraisBundle\Entity\ForfaitFrais $forfaitFrai)
    {
        $this->forfaitFrais->removeElement($forfaitFrai);
    }

    /**
     * Get forfaitFrais
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getForfaitFrais()
    {
        return $this->forfaitFrais;
    }

    /**
     * Add forfaitHorsFrai
     *
     * @param \FraisBundle\Entity\ForfaitHorsFrais $forfaitHorsFrai
     *
     * @return Etat
     */
    public function addForfaitHorsFrai(\FraisBundle\Entity\ForfaitHorsFrais $forfaitHorsFrai)
    {
        $this->forfaitHorsFrais[] = $forfaitHorsFrai;

        return $this;
    }

    /**
     * Remove forfaitHorsFrai
     *
     * @param \FraisBundle\Entity\ForfaitHorsFrais $forfaitHorsFrai
     */
    public function removeForfaitHorsFrai(\FraisBundle\Entity\ForfaitHorsFrais $forfaitHorsFrai)
    {
        $this->forfaitHorsFrais->removeElement($forfaitHorsFrai);
    }

    /**
     * Get forfaitHorsFrais
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getForfaitHorsFrais()
    {
        return $this->forfaitHorsFrais;
    }
}
