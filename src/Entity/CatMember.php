<?php

namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CatMemberRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields={"libelle"},message="Une autre catégorie possède déjà ce nom, merci de modifier")
 */
class CatMember
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=10, max=255, minMessage="Le libellé doit faire au moins 10 caractères",maxMessage="Le libellé doit faire tout au plus 255 caractères")
     */
    private $libelle;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Member", mappedBy="category")
     */
    private $members;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CatPaiement", mappedBy="category")
     */
    private $catPaiements;

    public function __construct()
    {
        $this->members = new ArrayCollection();
        $this->catPaiements = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist
     *
     * @return void
     */
    public function setCreatedAtValue() {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * @return Collection|Member[]
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(Member $member): self
    {
        if (!$this->members->contains($member)) {
            $this->members[] = $member;
            $member->setCategory($this);
        }

        return $this;
    }

    public function removeMember(Member $member): self
    {
        if ($this->members->contains($member)) {
            $this->members->removeElement($member);
            // set the owning side to null (unless already changed)
            if ($member->getCategory() === $this) {
                $member->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CatPaiement[]
     */
    public function getCatPaiements(): Collection
    {
        return $this->catPaiements;
    }

    public function addCatPaiement(CatPaiement $catPaiement): self
    {
        if (!$this->catPaiements->contains($catPaiement)) {
            $this->catPaiements[] = $catPaiement;
            $catPaiement->setCategory($this);
        }

        return $this;
    }

    public function removeCatPaiement(CatPaiement $catPaiement): self
    {
        if ($this->catPaiements->contains($catPaiement)) {
            $this->catPaiements->removeElement($catPaiement);
            // set the owning side to null (unless already changed)
            if ($catPaiement->getCategory() === $this) {
                $catPaiement->setCategory(null);
            }
        }

        return $this;
    }
}
