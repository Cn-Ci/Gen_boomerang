<?php

namespace App\Entity;

use App\Repository\DocumentRepository;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DocumentRepository::class)
 * @Vich\Uploadable()
 * @ORM\HasLifecycleCallbacks()
 */
class Document
{

    public function __construct(){
        $this->documents = new ArrayCollection();
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    // Vich\UploadableField : gérer un téléchargement de fichier, stocker le fichier sur le système de fichiers et conserver le nom de fichier stocké dans la base de données.
    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="user_document", fileNameProperty="fileName")
     * 
     * @var File|null
     */
    private $docFile;

    /**
     * @ORM\Column(type="string")
     *
     * @var String|null
     */
    private $fileName;

    
    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTimeInterface|null
     */
    private $updatedAt;

   
    /**
     * @ORM\Column(type="string", length=50)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="documents")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=SansEmploi::class, inversedBy="documents")
     * 
     */
    private $sansEmploieDocument;


    public function getId(): ?int
    {
        return $this->id;
    }

    
    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  String|null
     */ 
    public function getFileName()
    {
        return $this->fileName;
    }

     /**
     * Set undocumented variable
     *
     * @param  String|null  
     *
     * @return  self
     */ 
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
        return $this;
    }
    /**
     * Get gestion de l'upload de la photo
     *
     * @return  File|null
     */ 
    public function getDocFile()
    {
        return $this->docFile;
    }

    /**
     * Set gestion de l'upload de la photo
     *
     * @param  File|null  
     *
     * @return  self
     */ 
    public function setDocFile($docFile)
    {
        $this->docFile = $docFile;
        if ($this->docFile instanceof UploadedFile){
            $this->updatedAt = new \DateTime('now');
        }
        return $this;
    }

    /**
     * Get the value of updatedAt
     *
     * @return  \DateTimeInterface|null
     */ 
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @param  \DateTimeInterface|null  $updatedAt
     *
     * @return  self
     */ 
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getSansEmploieDocument(): ?SansEmploi
    {
        return $this->sansEmploieDocument;
    }

    public function setSansEmploieDocument(?SansEmploi $sansEmploieDocument): self
    {
        $this->sansEmploieDocument = $sansEmploieDocument;

        return $this;
    }
}
