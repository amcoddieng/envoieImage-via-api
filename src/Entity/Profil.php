<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use App\Controller\UploadProfilImageController;

#[ApiResource(
    operations: [
        // Opération POST pour uploader une image
        new \ApiPlatform\Metadata\Post(
            uriTemplate: '/uploads/images/profiles',
            controller: UploadProfilImageController::class,
            deserialize: false
        ),
        // Opération GET pour récupérer tous les profils
        new \ApiPlatform\Metadata\Get(),
        // Opération GET pour récupérer un profil spécifique
        new \ApiPlatform\Metadata\Get(
            uriTemplate: '/profils/{id}',
        )
    ]
)]
#[ORM\Entity(repositoryClass: "App\Repository\ProfilRepository")]
#[Vich\Uploadable]
class Profil
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    private string $nom;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $image = null;

    /**
     * @Vich\UploadableField(mapping="profil_images", fileNameProperty="image")
     * @Assert\File(
     *     maxSize="8M",
     *     mimeTypes={"image/jpeg", "image/png", "image/gif"},
     *     mimeTypesMessage="Veuillez télécharger une image valide (jpeg, png, gif)."
     * )
     */
    private ?File $imageFile = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;
        return $this;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;
        if ($imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}
