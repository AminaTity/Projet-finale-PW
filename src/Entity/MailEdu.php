<?php

namespace App\Entity;

use App\Repository\MailEduRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
date_default_timezone_set('Europe/Paris');

#[ORM\Entity(repositoryClass: MailEduRepository::class)]
class MailEdu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateEnvoi = null;

    #[ORM\Column(length: 255)]
    private ?string $objet = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $message = null;

    #[ORM\ManyToMany(targetEntity: Educateur::class, inversedBy: 'mailEdus')]
    private Collection $educateurs;

    #[ORM\ManyToOne(inversedBy: 'mailEdusEnvoi')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Educateur $educateur = null;

    public function __construct(\DateTimeInterface $date = new \DateTime("now"))
    {
        $this->educateurs = new ArrayCollection();
        $this->dateEnvoi = $date;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEnvoi(): ?\DateTimeInterface
    {
        return $this->dateEnvoi;
    }

    public function setDateEnvoi(\DateTimeInterface $dateEnvoi): static
    {
        $this->dateEnvoi = $dateEnvoi;

        return $this;
    }

    public function getObjet(): ?string
    {
        return $this->objet;
    }

    public function setObjet(string $objet): static
    {
        $this->objet = $objet;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return Collection<int, Educateur>
     */
    public function getEducateurs(): Collection
    {
        return $this->educateurs;
    }

    public function addEducateur(Educateur $educateur): static
    {
        if (!$this->educateurs->contains($educateur)) {
            $this->educateurs->add($educateur);
        }

        return $this;
    }

    public function removeEducateur(Educateur $educateur): static
    {
        $this->educateurs->removeElement($educateur);

        return $this;
    }

    public function getEducateur(): ?Educateur
    {
        return $this->educateur;
    }

    public function setEducateur(?Educateur $educateur): static
    {
        $this->educateur = $educateur;

        return $this;
    }
}
