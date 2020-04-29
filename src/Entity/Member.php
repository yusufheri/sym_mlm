<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="App\Repository\MemberRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *      fields={"token"},
 *      message="Une autre personne possède déjà ce token, prière de recommncer"
 * )
 */
class Member
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=3, max=255, minMessage="Le nom doit faire au moins 10 caractères",maxMessage="Le nom doit faire tout au plus 255 caractères")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(min=3, max=255, minMessage="Le postnom doit faire au moins 10 caractères",maxMessage="Le postnom doit faire tout au plus 255 caractères")
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prename;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(min=10, max=15, minMessage="Le champ doit faire au moins 10 caractères",maxMessage="Le champ doit faire tout au plus 15 caractères")
     */
    private $tel1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tel2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $rccm;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $id_national;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $num_impot;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Sexe", inversedBy="members")
     */
    private $sexe;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Province", inversedBy="members")
     */
    private $province;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Commune", inversedBy="members")
     */
    private $commune;

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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lieu_nais;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_nais;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Prière de saisir votre avenue, le numéro, la référence")
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $token;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Member", inversedBy="members")
     */
    private $parrain;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Member", mappedBy="parrain")
     */
    private $members;

    public function __construct()
    {
        $this->members = new ArrayCollection();
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

    /**
     * @ORM\PreUpdate
     *
     * @return void
     */
    public function setUpdatedAtValue() {
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getname(): ?string
    {
        return $this->name;
    }

    public function setname(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPrename(): ?string
    {
        return $this->prename;
    }

    public function setPrename(?string $prename): self
    {
        $this->prename = $prename;

        return $this;
    }

    public function getTel1(): ?string
    {
        return $this->tel1;
    }

    public function setTel1(?string $tel1): self
    {
        $this->tel1 = $tel1;

        return $this;
    }

    public function getTel2(): ?string
    {
        return $this->tel2;
    }

    public function setTel2(?string $tel2): self
    {
        $this->tel2 = $tel2;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getRccm(): ?string
    {
        return $this->rccm;
    }

    public function setRccm(?string $rccm): self
    {
        $this->rccm = $rccm;

        return $this;
    }

    public function getIdNational(): ?string
    {
        return $this->id_national;
    }

    public function setIdNational(?string $id_national): self
    {
        $this->id_national = $id_national;

        return $this;
    }

    public function getNumImpot(): ?string
    {
        return $this->num_impot;
    }

    public function setNumImpot(?string $num_impot): self
    {
        $this->num_impot = $num_impot;

        return $this;
    }

    public function getSexe(): ?Sexe
    {
        return $this->sexe;
    }

    public function setSexe(?Sexe $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getProvince(): ?Province
    {
        return $this->province;
    }

    public function setProvince(?Province $province): self
    {
        $this->province = $province;

        return $this;
    }

    public function getCommune(): ?Commune
    {
        return $this->commune;
    }

    public function setCommune(?Commune $commune): self
    {
        $this->commune = $commune;

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

    public function getLieuNais(): ?string
    {
        return $this->lieu_nais;
    }

    public function setLieuNais(?string $lieu_nais): self
    {
        $this->lieu_nais = $lieu_nais;

        return $this;
    }

    public function getDateNais(): ?\DateTimeInterface
    {
        return $this->date_nais;
    }

    public function setDateNais(?\DateTimeInterface $date_nais, $format = 'Y-m-d H:i:s'): self
    {
        //return $this->date_naissance->format($format);
        $this->date_nais = $date_nais;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getParrain(): ?self
    {
        return $this->parrain;
    }

    public function setParrain(?self $parrain): self
    {
        $this->parrain = $parrain;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(self $member): self
    {
        if (!$this->members->contains($member)) {
            $this->members[] = $member;
            $member->setParrain($this);
        }

        return $this;
    }

    public function removeMember(self $member): self
    {
        if ($this->members->contains($member)) {
            $this->members->removeElement($member);
            // set the owning side to null (unless already changed)
            if ($member->getParrain() === $this) {
                $member->setParrain(null);
            }
        }

        return $this;
    }
}
