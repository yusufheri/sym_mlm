<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PaiementRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Paiement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="Prière de saisir ce champ, il est obligatoire")
     */
    private $amount;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  @Assert\Length(min=10, max=500, minMessage="Ce champ doit faire au moins 10 caractères",maxMessage="Ce champ doit faire tout au plus 500 caractères")
     */
    private $amount_letter;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CatPaiement", inversedBy="paiements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Member", inversedBy="paiements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $payer;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Bonus", mappedBy="donor")
     */
    private $bonuses;

    /**
     * @ORM\Column(type="datetime")
     */
    private $paidAt;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    public function __construct()
    {
        $this->bonuses = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist
     *
     * @return void
     */
    public function setCreatedAtValue() {
        $date = new \DateTime();
        $this->createdAt = $date;
        $this->updatedAt = $date;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getAmountLetter(): ?string
    {
        return $this->amount_letter;
    }

    public function setAmountLetter(?string $amount_letter): self
    {
        $this->amount_letter = $amount_letter;

        return $this;
    }

    public function getCategory(): ?CatPaiement
    {
        return $this->category;
    }

    public function setCategory(?CatPaiement $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getPayer(): ?Member
    {
        return $this->payer;
    }

    public function setPayer(?Member $payer): self
    {
        $this->payer = $payer;

        return $this;
    }

    /**
     * @return Collection|Bonus[]
     */
    public function getBonuses(): Collection
    {
        return $this->bonuses;
    }

    public function addBonus(Bonus $bonus): self
    {
        if (!$this->bonuses->contains($bonus)) {
            $this->bonuses[] = $bonus;
            $bonus->setDonor($this);
        }

        return $this;
    }

    public function removeBonus(Bonus $bonus): self
    {
        if ($this->bonuses->contains($bonus)) {
            $this->bonuses->removeElement($bonus);
            // set the owning side to null (unless already changed)
            if ($bonus->getDonor() === $this) {
                $bonus->setDonor(null);
            }
        }

        return $this;
    }

    public function getPaidAt(): ?\DateTimeInterface
    {
        return $this->paidAt;
    }

    public function setPaidAt(\DateTimeInterface $paidAt): self
    {
        $this->paidAt = $paidAt;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }
}
