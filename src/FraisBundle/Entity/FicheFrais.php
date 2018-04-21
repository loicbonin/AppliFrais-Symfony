<?php
namespace FraisBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * FicheFrais
 *
 * @ORM\Table(name="fiche_frais")
 * @ORM\Entity(repositoryClass="FraisBundle\Repository\FicheFraisRepository")
 */
class FicheFrais
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
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;
    /**
     * @var string
     *
     * @ORM\Column(name="derniere_edition", type="datetime", nullable=true)
     */
    private $derniereEdition;
    /**
     * @var string
     *
     * @ORM\Column(name="monthyear", type="string", length=255)
     */
    private $monthyear;
    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=255, nullable=true)
     */
    private $comment;

    /**
     * @var string
     *
     * @ORM\Column(name="payement", type="string", nullable=true)
     */
    private $payement;

    // LIAISON ENTITEES

    /**
     * @ORM\ManyToOne(targetEntity="FraisBundle\Entity\Etat", inversedBy="ficheFrais", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     *
     */
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="ficheFrais", cascade={"persist"})
     *
     *
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="FraisBundle\Entity\ForfaitHorsFrais", mappedBy="ficheFrais", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(nullable=true)
     *
     */
    private $horsFrais;

    /**
     * @ORM\OneToMany(targetEntity="FraisBundle\Entity\ForfaitFrais", mappedBy="ficheFrais", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(nullable=true)
     *
     */
    private $frais;

    //FONCTIONS

    /**
     *
     */
    public function __construct()
    {
        $this->created = new \DateTime();
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
     * Set url
     *
     * @param string $url
     *
     * @return FicheFrais
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }
    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
    /**
     * Set payement
     *
     * @param string $payement
     *
     * @return FicheFrais
     */
    public function setPayement($payement)
    {
        $this->payement = $payement;
        return $this;
    }
    /**
     * Get payement
     *
     * @return string
     */
    public function getPayement()
    {
        return $this->payement;
    }
    /**
     * Set title
     *
     * @param string $title
     *
     * @return FicheFrais
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }
    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return FicheFrais
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
     * @param string $derniereEdition
     *
     * @return FicheFrais
     */
    public function setDerniereEdition($derniereEdition)
    {
        $this->derniereEdition = $derniereEdition;
        return $this;
    }
    /**
     * Get derniereEdition
     *
     * @return string
     */
    public function getDerniereEdition()
    {
        return $this->derniereEdition;
    }
    /**
     * Set monthyear
     *
     * @param string $monthyear
     *
     * @return FicheFrais
     */
    public function setMonthyear($monthyear)
    {
        $this->monthyear = $monthyear;
        return $this;
    }
    /**
     * Get monthyear
     *
     * @return string
     */
    public function getMonthyear()
    {
        return $this->monthyear;
    }
    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return FicheFrais
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
     * Set User
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return FicheFrais
     */
    public function setUser(\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get User
     *
     * @return \UserBundle\Entity\User $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add horsFrai
     *
     * @param \FraisBundle\Entity\ForfaitHorsFrais $horsFrai
     *
     * @return FicheFrais
     */
    public function addHorsFrai(\FraisBundle\Entity\ForfaitHorsFrais $horsFrai)
    {
        $this->horsFrais[] = $horsFrai;

        return $this;
    }

    /**
     * Remove horsFrai
     *
     * @param \FraisBundle\Entity\ForfaitHorsFrais $horsFrai
     */
    public function removeHorsFrai(\FraisBundle\Entity\ForfaitHorsFrais $horsFrai)
    {
        $this->horsFrais->removeElement($horsFrai);
    }

    /**
     * Get horsFrais
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHorsFrais()
    {
        return $this->horsFrais;
    }

    /**
     * Add frai
     *
     * @param \FraisBundle\Entity\ForfaitFrais $frai
     *
     * @return FicheFrais
     */
    public function addFrai(\FraisBundle\Entity\ForfaitFrais $frai)
    {
        $this->frais[] = $frai;

        return $this;
    }

    /**
     * Remove frai
     *
     * @param \FraisBundle\Entity\ForfaitFrais $frai
     */
    public function removeFrai(\FraisBundle\Entity\ForfaitFrais $frai)
    {
        $this->frais->removeElement($frai);
    }

    /**
     * Get frais
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFrais()
    {
        return $this->frais;
    }

    /**
     * Set etat
     *
     * @param \FraisBundle\Entity\Etat $etat
     *
     * @return FicheFrais
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

    /**
     * Get nbFraisValide
     *
     * @return int
     */
    public function getNbFraisValide()
    {
        $nbFraisForfaitValide = 0;
        $nbFraisHorsForfaitValide = 0;

        $listFraisHorsForfait = $this->getHorsFrais();
        foreach ( $listFraisHorsForfait as $hf){
            if($hf->getEtat()->getWording() == "validée"){
                $nbFraisHorsForfaitValide = $nbFraisHorsForfaitValide +1;
            }

        }
        $listFraisForfait = $this->getFrais();
        foreach ($listFraisForfait as $ff){
            if($ff->getEtat()->getWording() == "validée") {
                $nbFraisForfaitValide = $nbFraisForfaitValide + 1;
            }
        }

        $nbTotalValide = $nbFraisForfaitValide + $nbFraisHorsForfaitValide;
        return $nbTotalValide;
    }

    /**
     * Get nbFrais
     *
     * @return int
     */
    public function getNbFrais()
    {
        $nbFraisForfait = 0;
        $nbFraisHorsForfait = 0;

        $listFraisHorsForfait = $this->getHorsFrais();
        foreach ( $listFraisHorsForfait as $hf){
            $nbFraisHorsForfait = $nbFraisHorsForfait +1;
        }
        $listFraisForfait = $this->getFrais();
        foreach ($listFraisForfait as $ff){
            $nbFraisForfait = $nbFraisForfait + 1;
        }

        $nbTotal = $nbFraisForfait + $nbFraisHorsForfait;
        return $nbTotal;
    }
}
