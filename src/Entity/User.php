<?php
/**
 * @author Sébastien Rochat <percevalseb@gmail.com>
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Swagger\Annotations as SWG;

/**
 * Class User.
 *
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks
 *
 * @UniqueEntity(fields="username", groups={"create"})
 * @UniqueEntity(fields="email", groups={"create"})
 *
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "user_show",
 *          parameters = {"id"="expr(object.getId())"},
 *          absolute = true
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups={"list"})
 * )
 * @Hateoas\Relation(
 *      "delete",
 *      href = @Hateoas\Route(
 *          "user_delete",
 *          parameters = {"id"="expr(object.getId())"},
 *          absolute = true
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups={"list", "details"})
 * )
 * @Hateoas\Relation(
 *      "authenticated_user",
 *      embedded = @Hateoas\Embedded("expr(service('security.token_storage').getToken().getUser())"),
 *      exclusion = @Hateoas\Exclusion(groups={"details"})
 * )
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Serializer\Since("1.0")
     * @Serializer\Groups({"list"})
     *
     * @SWG\Property(description="The unique identifier of the phone.")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=64)
     *
     * @Assert\NotBlank(groups={"create"})
     * @Assert\Length(
     *     min=2,
     *     max=64,
     *     groups={"create"}
     * )
     *
     * @Serializer\Since("2.0")
     * @Serializer\Groups({"list", "details"})
     *
     * @SWG\Property(type="string", minLength=2, maxLength=64)
     */
    private $fullname;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=64, unique=true)
     *
     * @Assert\NotBlank(groups={"create"})
     * @Assert\Length(
     *     min=2,
     *     max=64,
     *     groups={"create"}
     * )
     *
     * @Serializer\Since("1.0")
     * @Serializer\Groups({"list", "details"})
     *
     * @SWG\Property(type="string", maxLength=64)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, unique=true)
     *
     * @Assert\NotBlank(groups={"create"})
     * @Assert\Email(groups={"create"})
     *
     * @Serializer\Since("1.0")
     * @Serializer\Groups({"list", "details"})
     *
     * @SWG\Property(type="string", maxLength=255)
     */
    private $email;

    /**
     * @var \DateTimeInterface
     *
     * @ORM\Column(type="datetimetz")
     *
     * @Serializer\Since("1.0")
     * @Serializer\Groups({"details"})
     *
     * @SWG\Property(type="datetimete")
     */
    private $created;

    /**
     * @var Customer
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    /**
     * @param string $fullname
     *
     * @return User
     */
    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return User
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return User
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    /**
     * @param \DateTimeInterface $created
     *
     * @return User
     */
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
        $this->created = new \Datetime('now', new \DateTimeZone('Europe/Paris'));
    }

    /**
     * @return Customer|null
     */
    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    /**
     * @param Customer|null $customer
     *
     * @return User
     */
    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }
}
