<?php
/**
 * @author Sébastien Rochat <percevalseb@gmail.com>
 */

namespace App\Representation;

use Pagerfanta\Pagerfanta;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class Users.
 *
 * @Hateoas\Relation(
 *      "create",
 *      href = @Hateoas\Route(
 *          "user_create",
 *          absolute = true
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups={"list"})
 * )
 * @Hateoas\Relation(
 *      "authenticated_user",
 *      embedded = @Hateoas\Embedded("expr(service('security.token_storage').getToken().getUser())"),
 *      exclusion = @Hateoas\Exclusion(groups={"list"})
 * )
 */
class Users
{
    /**
     * @var array|\Traversable
     *
     * @Serializer\Type("array<App\Entity\User>")
     * @Serializer\Groups("list")
     */
    public $data;

    /**
     * @var array
     *
     * @Serializer\Groups("list")
     */
    public $meta;

    /**
     * Users constructor.
     *
     * @param Pagerfanta $data
     */
    public function __construct(Pagerfanta $data)
    {
        $this->data = $data->getCurrentPageResults();

        $this->addMeta('current_items', count($data->getCurrentPageResults()));
        $this->addMeta('total_items', $data->getNbResults());
        if ($data->hasPreviousPage()) {
            $this->addMeta('previous_page', $data->getPreviousPage());
        }
        $this->addMeta('current_page', $data->getCurrentPage());
        if ($data->hasNextPage()) {
            $this->addMeta('next_page', $data->getNextPage());
        }
        $this->addMeta('total_pages', $data->getNbPages());
    }

    /**
     * @param $name
     * @param $value
     */
    public function addMeta($name, $value): void
    {
        if (isset($this->meta[$name])) {
            $message = 'This meta already exists. ';
            $message .= 'You are trying to override this meta, use the setMeta method instead for the %s meta.';
            throw new \LogicException(sprintf($message, $name));
        }

        $this->setMeta($name, $value);
    }

    /**
     * @param $name
     * @param $value
     */
    public function setMeta($name, $value): void
    {
        $this->meta[$name] = $value;
    }
}
