<?php

namespace App\Controller;

use App\Entity\User;
use App\Exception\ResourceValidationException;
use App\Representation\Users;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/** @Route("/api") */
class UserController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(
     *     path = "/users",
     *     name = "user_list",
     * )
     *
     * @Rest\QueryParam(
     *     name="keyword",
     *     requirements="[a-zA-Z0-9]+",
     *     nullable=true,
     *     description="The keyword to search for."
     * )
     * @Rest\QueryParam(
     *     name="order",
     *     requirements="asc|desc",
     *     default="asc",
     *     description="Sort order (asc or desc)."
     * )
     * @Rest\QueryParam(
     *     name="limit",
     *     requirements="\d+",
     *     default="10",
     *     description="Max number of results per page."
     * )
     * @Rest\QueryParam(
     *     name="offset",
     *     requirements="\d+",
     *     default="0",
     *     description="The pagination offset."
     * )
     *
     * @Rest\View(
     *     statusCode=Response::HTTP_OK,
     *     serializerGroups={"list", "customer"}
     * )
     */
    public function list(Security $security, ParamFetcherInterface $paramFetcher)
    {
        $customer = $security->getUser();

        $pager = $this->getDoctrine()
            ->getRepository(User::class)
            ->search(
                $customer,
                $paramFetcher->get('keyword'),
                $paramFetcher->get('order'),
                $paramFetcher->get('limit'),
                $paramFetcher->get('offset')
            );

        return new Users($pager);
    }

    /**
     * @Rest\Get(
     *     path = "/users/{id}",
     *     name = "user_show",
     *     requirements = {"id"="\d+"}
     * )
     *
     * @Rest\View(
     *     statusCode=Response::HTTP_OK,
     *     serializerGroups={"details", "customer"}
     * )
     */
    public function show(Security $security, User $user)
    {
        $customer = $security->getUser();

        if ($customer !== $user->getCustomer()) {
            throw new AccessDeniedException('Unable to access this resource!');
        }

        return $user;
    }

    /**
     * @Rest\Post(
     *     path = "/users",
     *     name = "user_create",
     * )
     *
     * @ParamConverter(
     *     "user",
     *      converter="fos_rest.request_body",
     *      options={
     *         "validator"={"groups"="create"}
     *     }
     * )
     *
     * @Rest\View(
     *     statusCode=Response::HTTP_CREATED,
     *     serializerGroups={"details", "customer"}
     * )
     */
    public function create(Security $security, User $user, ConstraintViolationListInterface $violations)
    {
        if (count($violations) > 0) {
            $message = 'The JSON sent contains invalid data. Here are the errors you need to correct: ';
            foreach ($violations as $violation) {
                $message .= sprintf('Field %s: %s ', $violation->getPropertyPath(), $violation->getMessage());
            }

            throw new ResourceValidationException($message);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $customer = $security->getUser();
        $user->setCustomer($customer);
        $entityManager->persist($user);
        $entityManager->flush();

        return $user;
    }

    /**
     * @Rest\Delete(
     *     path = "/users/{id}",
     *     name = "user_delete",
     *     requirements = {"id"="\d+"}
     * )
     *
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     */
    public function deleteAction(Security $security, User $user)
    {
        $customer = $security->getUser();

        if ($customer !== $user->getCustomer()) {
            throw new AccessDeniedException('Unable to access this resource!');
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();

        return;
    }
}
