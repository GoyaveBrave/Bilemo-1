<?php
/**
 * @author Sébastien Rochat <percevalseb@gmail.com>
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;
use Swagger\Annotations as SWG;

/**
 * Class Phone.
 *
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
     * @ORM\Column(type="string", length=64, unique=true)
     *
     * @Serializer\Since("1.0")
     * @Serializer\Groups({"list", "details"})
     *
     * @SWG\Property(type="string", maxLength=64)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=8)
     *
     * @Serializer\Since("1.0")
     * @Serializer\Groups({"list", "details"})
     *
     * @SWG\Property(type="string", maxLength=8)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=16)
     *
     * @Serializer\Since("1.0")
     * @Serializer\Groups({"list", "details"})
     *
     * @SWG\Property(type="string", maxLength=16)
     */
    private $brand;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=16)
     *
     * @Serializer\Since("1.0")
     * @Serializer\Groups({"details"})
     *
     * @SWG\Property(type="string", maxLength=16)
     */
    private $operationSystem;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=16)
     *
     * @Serializer\Since("1.0")
     * @Serializer\Groups({"details"})
     *
     * @SWG\Property(type="string", maxLength=16)
     */
    private $screenSize;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=16)
     *
     * @Serializer\Since("1.0")
     * @Serializer\Groups({"details"})
     *
     * @SWG\Property(type="string", maxLength=16)
     */
    private $internalStorage;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=16)
     *
     * @Serializer\Since("1.0")
     * @Serializer\Groups({"details"})
     *
     * @SWG\Property(type="string", maxLength=16)
     */
    private $color;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     *
     * @Serializer\Since("1.0")
     * @Serializer\Groups({"details"})
     *
     * @SWG\Property(type="text")
     */
    private $description;

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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Phone
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPrice(): ?string
    {
        return $this->price;
    }

    /**
     * @param string $price
     *
     * @return Phone
     */
    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBrand(): ?string
    {
        return $this->brand;
    }

    /**
     * @param string $brand
     *
     * @return Phone
     */
    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOperationSystem(): ?string
    {
        return $this->operationSystem;
    }

    /**
     * @param string $operationSystem
     *
     * @return Phone
     */
    public function setOperationSystem(string $operationSystem): self
    {
        $this->operationSystem = $operationSystem;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getScreenSize(): ?string
    {
        return $this->screenSize;
    }

    /**
     * @param string $screenSize
     *
     * @return Phone
     */
    public function setScreenSize(string $screenSize): self
    {
        $this->screenSize = $screenSize;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getInternalStorage(): ?string
    {
        return $this->internalStorage;
    }

    /**
     * @param string $internalStorage
     *
     * @return Phone
     */
    public function setInternalStorage(string $internalStorage): self
    {
        $this->internalStorage = $internalStorage;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getColor(): ?string
    {
        return $this->color;
    }

    /**
     * @param string $color
     *
     * @return Phone
     */
    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return Phone
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
