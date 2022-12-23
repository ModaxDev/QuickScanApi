<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource]
#[Vich\Uploadable]
#[UniqueEntity(fields: ["barCodeNumber"], message: "Ce code barre est déjà utilisé")]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[ApiProperty(identifier: false)]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[ApiProperty(identifier: true)]
    private ?string $barCodeNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $thumbnail = null;

    #[Vich\UploadableField(mapping: "product_file", fileNameProperty: "thumbnail")]
    private ?File $picture = null;

    private ?string $fileUrl = null;

    #[ORM\Column(type: 'datetime')]
    private mixed $uploadedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBarCodeNumber(): ?string
    {
        return $this->barCodeNumber;
    }

    public function setBarCodeNumber(string $barCodeNumber): self
    {
        $this->barCodeNumber = $barCodeNumber;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(?string $thumbnail): self
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * @return File|null
     */
    public function getPicture(): ?File
    {
        return $this->picture;
    }

    /**
     * @param File|null $picture
     */
    public function setPicture(?File $picture): void
    {
        $this->picture = $picture;
        if($picture){
            $this->uploadedAt = new \DateTime('now');
        }
    }

    /**
     * @return mixed
     */
    public function getUploadedAt()
    {
        return $this->uploadedAt;
    }

    /**
     * @param mixed $uploadedAt
     */
    public function setUploadedAt($uploadedAt): void
    {
        $this->uploadedAt = $uploadedAt;
    }

    /**
     * @return string|null
     */
    public function getFileUrl(): ?string
    {
        return $this->fileUrl;
    }

    /**
     * @param string|null $fileUrl
     */
    public function setFileUrl(?string $fileUrl): self
    {
        $this->fileUrl = $fileUrl;
        return $this;
    }

}
