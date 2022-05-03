<?php

namespace App\Entity;

use App\Repository\ResumeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResumeRepository::class)]
#[ORM\Table(name: 'resumes')]
class Resume
{
    public const STATUS_DRAFT = 'draft';
    public const STATUS_SUBMITTED = 'submitted';
    public const STATUS_COMPLETED = 'completed';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $firstName = '';

    #[ORM\Column(type: 'string', length: 255)]
    private string $lastName = '';

    #[ORM\Column(type: 'string', length: 255)]
    private string $email = '';

    #[ORM\Column(type: 'string', length: 20)]
    private string $phone = '';

    #[ORM\OneToOne(mappedBy: 'parent', targetEntity: ResumeAddress::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?ResumeAddress $address = null;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: ResumeExperience::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private $experiences;

    #[ORM\Column(type: 'string', length: 255)]
    private string $hash;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'string', length: 50)]
    private string $status = self::STATUS_DRAFT;

    #[ORM\Column(type: 'text')]
    private string $skills = '';

    public function __construct()
    {
        $this->experiences = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?ResumeAddress
    {
        return $this->address;
    }

    public function setAddress(?ResumeAddress $address): self
    {
        // set the owning side of the relation if necessary
        if ($address->getParent() !== $this) {
            $address->setParent($this);
        }

        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection<int, ResumeExperience>
     */
    public function getExperiences(): Collection
    {
        return $this->experiences;
    }

    public function setExperiences(Collection $experiences): self
    {
        $this->experiences = $experiences;

        return $this;
    }

    public function addExperience(ResumeExperience $experience): self
    {
        if (!$this->experiences->contains($experience)) {
            $this->experiences[] = $experience;
            $experience->setParent($this);
        }

        return $this;
    }

    public function removeExperience(ResumeExperience $experience): self
    {
        if ($this->experiences->removeElement($experience)) {
            // set the owning side to null (unless already changed)
            if ($experience->getParent() === $this) {
                $experience->setParent(null);
            }
        }

        return $this;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getSkills(): ?string
    {
        return $this->skills;
    }

    public function setSkills(string $skills): self
    {
        $this->skills = $skills;

        return $this;
    }
}
