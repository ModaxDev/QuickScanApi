<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => ['product:read']]),
        new GetCollection(normalizationContext: ['groups' => ['product:collection:read']]),
    ]
)]
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
    #[Groups(['product:read', 'product:collection:read'])]
    private ?string $barCodeNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['product:read', 'product:collection:read'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['product:read'])]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['product:read', 'product:collection:read'])]
    private ?string $thumbnail = null;

    #[Vich\UploadableField(mapping: "product_file", fileNameProperty: "thumbnail")]
    private ?File $picture = null;
    #[Groups(['product:read'])]
    private ?string $fileUrl = null;

    #[ORM\Column(type: 'datetime')]
    private mixed $uploadedAt;

    #[ORM\Column(nullable: true)]
    #[Groups(['product:read'])]
    private ?bool $isFixable = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Range(min: 0, max: 10)]
    #[Groups(['product:read'])]
    private ?int $reparabilityIndex = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductAccessories::class, cascade: ['persist', 'remove'])]
    #[Groups(['product:read'])]
    private Collection $productAccessories;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['product:read'])]
    private ?string $company = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['product:read'])]
    private ?string $companyLogo = null;

    #[Vich\UploadableField(mapping: "product_company_file", fileNameProperty: "companyLogo")]
    private ?File $pictureCompany = null;

    #[Groups(['product:read'])]
    private ?string $fileUrlCompanyLogo = null;

    public function __construct()
    {
        $this->productAccessories = new ArrayCollection();
    }

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
        if ($picture) {
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

    public function isIsFixable(): ?bool
    {
        return $this->isFixable;
    }

    public function setIsFixable(?bool $isFixable): self
    {
        $this->isFixable = $isFixable;

        return $this;
    }

    public function getReparabilityIndex(): ?int
    {
        return $this->reparabilityIndex;
    }

    public function setReparabilityIndex(?int $reparabilityIndex): self
    {
        $this->reparabilityIndex = $reparabilityIndex;

        return $this;
    }

    /**
     * @return Collection<int, ProductAccessories>
     */
    public function getProductAccessories(): Collection
    {
        return $this->productAccessories;
    }

    public function addProductAccessory(ProductAccessories $productAccessory): self
    {
        if (!$this->productAccessories->contains($productAccessory)) {
            $this->productAccessories->add($productAccessory);
            $productAccessory->setProduct($this);
        }

        return $this;
    }

    public function removeProductAccessory(ProductAccessories $productAccessory): self
    {
        if ($this->productAccessories->removeElement($productAccessory)) {
            // set the owning side to null (unless already changed)
            if ($productAccessory->getProduct() === $this) {
                $productAccessory->setProduct(null);
            }
        }

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(?string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getCompanyLogo(): ?string
    {
        return $this->companyLogo;
    }

    public function setCompanyLogo(?string $companyLogo): self
    {
        $this->companyLogo = $companyLogo;

        return $this;
    }

    /**
     * @return File|null
     */
    public function getPictureCompany(): ?File
    {
        return $this->pictureCompany;
    }

    /**
     * @param File|null $pictureCompany
     */
    public function setPictureCompany(?File $pictureCompany): void
    {
        $this->pictureCompany = $pictureCompany;
        if ($pictureCompany) {
            $this->uploadedAt = new \DateTime('now');
        }
    }

    /**
     * @return string|null
     */
    public function getFileUrlCompanyLogo(): ?string
    {
        return $this->fileUrlCompanyLogo;
    }

    /**
     * @param string|null $fileUrlCompanyLogo
     */
    public function setFileUrlCompanyLogo(?string $fileUrlCompanyLogo): void
    {
        $this->fileUrlCompanyLogo = $fileUrlCompanyLogo;
    }

}
