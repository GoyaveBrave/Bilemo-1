<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PhoneRepository")
 *
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "phone_show",
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute = true
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups={"list"})
 * )
 */
class Phone
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
     * @ORM\Column(type="string", length=64, unique=true)
     *
     * @Serializer\Groups({"list", "details"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=8)
     *
     * @Serializer\Groups({"list", "details"})
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=16)
     *
     * @Serializer\Groups({"list", "details"})
     */
    private $brand;

    /**
     * @ORM\Column(type="string", length=16)
     *
     * @Serializer\Groups({"details"})
     */
    private $operationSystem;

    /**
     * @ORM\Column(type="string", length=16)
     *
     * @Serializer\Groups({"details"})
     */
    private $screenSize;

    /**
     * @ORM\Column(type="string", length=16)
     *
     * @Serializer\Groups({"details"})
     */
    private $internalStorage;

    /**
     * @ORM\Column(type="string", length=16)
     *
     * @Serializer\Groups({"details"})
     */
    private $color;

    /**
     * @ORM\Column(type="text")
     *
     * @Serializer\Groups({"details"})
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
