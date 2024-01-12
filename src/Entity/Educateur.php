<?php

namespace App\Entity;

use App\Repository\EducateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: EducateurRepository::class)]
class Educateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToOne(inversedBy: 'educateur')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Licencie $licencie = null;

    #[ORM\ManyToMany(targetEntity: MailEdu::class, mappedBy: 'educateurs')]
    private Collection $mailEdus;

    #[ORM\OneToMany(mappedBy: 'educateur', targetEntity: MailEdu::class, orphanRemoval: true)]
    private Collection $mailEdusEnvoi;

    #[ORM\OneToMany(mappedBy: 'educateur', targetEntity: MailContact::class, orphanRemoval: true)]
    private Collection $mailContacts;

    public function __construct()
    {
        $this->mailEdus = new ArrayCollection();
        $this->mailEdusEnvoi = new ArrayCollection();
        $this->mailContacts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getLicencie(): ?Licencie
    {
        return $this->licencie;
    }

    public function setLicencie(Licencie $licencie): static
    {
        $this->licencie = $licencie;

        return $this;
    }

    /**
     * @return Collection<int, MailEdu>
     */
    public function getMailEdus(): Collection
    {
        return $this->mailEdus;
    }

    public function addMailEdu(MailEdu $mailEdu): static
    {
        if (!$this->mailEdus->contains($mailEdu)) {
            $this->mailEdus->add($mailEdu);
            $mailEdu->addEducateur($this);
        }

        return $this;
    }

    public function removeMailEdu(MailEdu $mailEdu): static
    {
        if ($this->mailEdus->removeElement($mailEdu)) {
            $mailEdu->removeEducateur($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, MailEdu>
     */
    public function getMailEdusEnvoi(): Collection
    {
        return $this->mailEdusEnvoi;
    }

    public function addMailEdusEnvoi(MailEdu $mailEdusEnvoi): static
    {
        if (!$this->mailEdusEnvoi->contains($mailEdusEnvoi)) {
            $this->mailEdusEnvoi->add($mailEdusEnvoi);
            $mailEdusEnvoi->setEducateur($this);
        }

        return $this;
    }

    public function removeMailEdusEnvoi(MailEdu $mailEdusEnvoi): static
    {
        if ($this->mailEdusEnvoi->removeElement($mailEdusEnvoi)) {
            // set the owning side to null (unless already changed)
            if ($mailEdusEnvoi->getEducateur() === $this) {
                $mailEdusEnvoi->setEducateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MailContact>
     */
    public function getMailContacts(): Collection
    {
        return $this->mailContacts;
    }

    public function addMailContact(MailContact $mailContact): static
    {
        if (!$this->mailContacts->contains($mailContact)) {
            $this->mailContacts->add($mailContact);
            $mailContact->setEducateur($this);
        }

        return $this;
    }

    public function removeMailContact(MailContact $mailContact): static
    {
        if ($this->mailContacts->removeElement($mailContact)) {
            // set the owning side to null (unless already changed)
            if ($mailContact->getEducateur() === $this) {
                $mailContact->setEducateur(null);
            }
        }

        return $this;
    }
}
