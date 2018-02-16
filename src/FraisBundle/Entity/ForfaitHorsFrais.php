<?php
namespace FraisBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * ForfaitHorsFrais
 *
 * @ORM\Table(name="forfait_hors_frais")
 * @ORM\Entity(repositoryClass="FraisBundle\Repository\ForfaitHorsFraisRepository")
 * @ORM\HasLifecycleCallbacks
 */
class ForfaitHorsFrais
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
     * @var string [le Libellé du frais hors forfait]
     *
     * @ORM\Column(name="wording", type="string", length=255)
     */
    private $wording;
    /**
     * @var string [le montant du frais hors forfait]
     *
     * @ORM\Column(name="price", type="string", length=255)
     */
    private $price;
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
     * @ORM\Column(name="last_update", type="datetime")
     */
    private $lastUpdate;
    /**
     * @var string [le commentaire du frais hors forfait]
     *
     * @ORM\Column(name="comment", type="string", length=255)
     */
    private $comment;

    private $pieceJointe;
    private $tempFilename;
    // l'extension de piece jointe
    private $extension;
    // LIAISON ENTITEES

    /*
     * @ORM\ManyToMany(targetEntity="FraisBundle\Entity\Etat")
     * @ORM\JoinColumn(nullable=false)
     *
     *
    private $etat;*/
    /**
     * @ORM\ManyToOne(targetEntity="FraisBundle\Entity\FicheFrais", inversedBy="horsFrais", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $ficheFrais;


    public function __construct(){
        $this->created = new \DateTime();
        $this->lastUpdate = new\DateTime();
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
     * Set wording
     *
     * @param string $wording
     *
     * @return ForfaitHorsFrais
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
     * Set price
     *
     * @param string $price
     *
     * @return ForfaitHorsFrais
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }
    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }
    /**
     * Set dateDuFrais
     *
     * @param string $dateDuFrais
     *
     * @return ForfaitHorsFrais
     */
    public function setDateDuFrais($dateDuFrais)
    {
        $this->dateDuFrais = $dateDuFrais;
        return $this;
    }
    /**
     * Get dateDuFrais
     *
     * @return string
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
     * @return ForfaitHorsFrais
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
    public function getPieceJointe()
    {
        return $this->pieceJointe;
    }
    public function setPieceJointe(UploadedFile $pieceJointe)
    {
        $this->pieceJointe = $pieceJointe;
        // On vérifie si on avait déjà un fichier pour cette entité
        /*if (null !== $this->extension) {
          /* On sauvegarde l'extension du fichier pour le supprimer plus tard
          $this->tempFilename = $this->extension;
          // On réinitialise les valeurs des attributs url et alt
          $this->extension=null;*/

    }
    /*
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     *
    public function preUpload()
    {
      // Si jamais il n'y a pas de fichier (champ facultatif), on ne fait rien
      if (null === $this->pieceJointe) {
        return;
        }
      $this->extension = $this->pieceJointe->guessExtension();
    }*/
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        // Si jamais il n'y a pas de fichier (champ facultatif), on ne fait rien
        if (null === $this->pieceJointe) {
            return;
        }
        // Si on avait un ancien fichier, on le supprime
        /*if (null !== $this->tempFilename) {
          $oldFile = $this->getUploadRootDir().'/'.$this->wording.'.'.$this->tempFilename;
          if (file_exists($oldFile)) {
            unlink($oldFile);
          }

        // On déplace le fichier envoyé dans le répertoire de notre choix
        $this->pieceJointe->move(
          $this->getUploadRootDir(), // Le répertoire de destination
          $this->wording.'.'.$this->extension   // Le nom du fichier à créer, ici « id.extension »
        );*/
        $name = $this->getWording()."_".$this->pieceJointe->getClientOriginalName();
        // On déplace le fichier envoyé dans le répertoire de notre choix
        $this->pieceJointe->move($this->getUploadRootDir(), $name);
        // On sauvegarde le nom de fichier dans notre attribut $url
        $this->extension = $name;



    }
    /*
     * @ORM\PreRemove()
     *
    public function preRemoveUpload()
    {
      // On sauvegarde temporairement le nom du fichier, car il dépend de l'id
      $this->tempFilename = $this->getUploadRootDir().'/'.$this->wording.'.'.$this->extension;
    }
    /**
     * @ORM\PostRemove()
     *
    public function removeUpload()
    {
      // En PostRemove, on n'a pas accès à l'id, on utilise notre nom sauvegardé
      if (file_exists($this->tempFilename)) {
        // On supprime le fichier
        unlink($this->tempFilename);
      }
    }*/
    public function getUploadDir()
    {
        // On retourne le chemin relatif vers l'image pour un navigateur (relatif au répertoire /web donc)
        return 'uploads/pieceJointe';
    }
    protected function getUploadRootDir()
    {
        // On retourne le chemin relatif vers l'image pour notre code PHP
        //return __DIR__.'/../../../web/'.$this->getUploadDir();
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    /**
     * Set lastUpdate
     *
     * @param \DateTime $lastUpdate
     *
     * @return ForfaitHorsFrais
     */
    public function setLastUpdate($lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;
        return $this;
    }
    /**
     * Get lastUpdate
     *
     * @return \DateTime
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }
    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return ForfaitHorsFrais
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
     * Set ficheFrais
     *
     * @param \FraisBundle\Entity\FicheFrais $ficheFrais
     *
     * @return ForfaitHorsFrais
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
}
