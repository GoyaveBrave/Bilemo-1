<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PhoneRepository")
 *
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "phone_show",
 *          parameters = {"id"="expr(object.getId())"},
 *          absolute = true
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups={"list"})
 * )
 * @Hateoas\Relation(
 *      "authenticated_user",
 *      embedded = @Hateoas\Embedded("expr(service('security.token_storage').getToken().getUser())"),
 *      exclusion = @Hateoas\Exclusion(groups={"details"})
 * )
 */
class Phone
{
    /**
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
     * @ORM\Column(type="string", length=64, unique=true)
     *
     * @Serializer\Since("1.0")
     * @Serializer\Groups({"list", "details"})
     *
     * @SWG\Property(type="string", maxLength=64)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=8)
     *
     * @Serializer\Since("1.0")
     * @Serializer\Groups({"list", "details"})
     *
     * @SWG\Property(type="string", maxLength=8)
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=16)
     *
     * @Serializer\Since("1.0")
     * @Serializer\Groups({"list", "details"})
     *
     * @SWG\Property(type="string", maxLength=16)
     */
    private $brand;

    /**
     * @ORM\Column(type="string", length=16)
     *
     * @Serializer\Since("1.0")
     * @Serializer\Groups({"details"})
     *
     * @SWG\Property(type="string", maxLength=16)
     */
    private $operationSystem;

    /**
     * @ORM\Column(type="string", length=16)
     *
     * @Serializer\Since("1.0")
     * @Serializer\Groups({"details"})
     *
     * @SWG\Property(type="string", maxLength=16)
     */
    private $screenSize;

    /**
     * @ORM\Column(type="string", length=16)
     *
     * @Serializer\Since("1.0")
     * @Serializer\Groups({"details"})
     *
     * @SWG\Property(type="string", maxLength=16)
     */
    private $internalStorage;

    /**
     * @ORM\Column(type="string", length=16)
     *
     * @Serializer\Since("1.0")
     * @Serializer\Groups({"details"})
     *
     * @SWG\Property(type="string", maxLength=16)
     */
    private $color;

    /**
     * @ORM\Column(type="text")
     *
     * @Serializer\Since("1.0")
     * @Serializer\Groups({"details"})
     *
     * @SWG\Property(type="text")
     */
    private $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getOperationSystem(): ?string
    {
        return $this->operationSystem;
    }

    public function setOperationSystem(string $operationSystem): self
    {
        $this->operationSystem = $operationSystem;

        return $this;
    }

    public function getScreenSize(): ?string
    {
        return $this->screenSize;
    }

    public function setScreenSize(string $screenSize): self
    {
        $this->screenSize = $screenSize;

        return $this;
    }

    public function getInternalStorage(): ?string
    {
        return $this->internalStorage;
    }

    public function setInternalStorage(string $internalStorage): self
    {
        $this->internalStorage = $internalStorage;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
