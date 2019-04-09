<?php

namespace App\Representation;

use Pagerfanta\Pagerfanta;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;

/**
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
     * @Serializer\Type("array<App\Entity\User>")
     * @Serializer\Groups("list")
     */
    public $data;

    /**
     * @Serializer\Groups("list")
     */
    public $meta;

    public function __construct(Pagerfanta $data)
    {
        $this->data = $data->getCurrentPageResults();

        $this->addMeta('limit', $data->getMaxPerPage());
        $this->addMeta('current_items', count($data->getCurrentPageResults()));
        $this->addMeta('total_items', $data->getNbResults());
        $this->addMeta('offset', $data->getCurrentPageOffsetStart());
    }

    public function addMeta($name, $value): void
    {
        if (isset($this->meta[$name])) {
            $message = 'This meta already exists. ';
            $message .= 'You are trying to override this meta, use the setMeta method instead for the %s meta.';
            throw new \LogicException(sprintf($message, $name));
        }

        $this->setMeta($name, $value);
    }

    public function setMeta($name, $value): void
    {
        $this->meta[$name] = $value;
    }
}
