<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks
 *
 * @UniqueEntity(fields="username", groups={"create"})
 * @UniqueEntity(fields="email", groups={"create"})
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Serializer\Groups({"list"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     *
     * @Assert\NotBlank(groups={"create"})
     * @Assert\Length(
     *     min=2,
     *     max=64,
     *     groups={"create"}
     * )
     *
     * @Serializer\Groups({"list", "details"})
     */
    private $fullname;

    /**
     * @ORM\Column(type="string", length=64, unique=true)
     *
     * @Assert\NotBlank(groups={"create"})
     * @Assert\Length(
     *     min=2,
     *     max=64,
     *     groups={"create"}
     * )
     *
     * @Serializer\Groups({"list", "details"})
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     *
     * @Assert\NotBlank(groups={"create"})
     * @Assert\Email(groups={"create"})
     *
     * @Serializer\Groups({"list", "details"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     *
     * @Serializer\Exclude
     */
    private $password;

    /**
     * @ORM\Column(type="datetimetz")
     *
     * @Serializer\Groups({"details"})
     */
    private $created;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedValue()
    {
        $this->created = new \Datetime("now", new \DateTimeZone('Europe/Paris'));
    }
}
