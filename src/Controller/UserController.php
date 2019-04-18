<?php
/**
 * @author Sébastien Rochat <percevalseb@gmail.com>
 */

namespace App\Controller;

use App\Entity\User;
use App\Exception\ResourceValidationException;
use App\Representation\Users;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Nelmio\ApiDocBundle\Annotation as Doc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class UserController.
 *
 * @Route("/api")
 */
class UserController extends AbstractFOSRestController
{
    /**
     * @param Security              $security
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return Users
     *
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
     *     name="max_per_page",
     *     requirements="\d+",
     *     default="10",
     *     description="Max number of results per page."
     * )
     * @Rest\QueryParam(
     *     name="current_page",
     *     requirements="\d+",
     *     default="1",
     *     description="Pagination start page."
     * )
     *
     * @Rest\View(
     *     statusCode=Response::HTTP_OK,
     *     serializerGroups={"list", "customer"}
     * )
     *
     * @Doc\Operation(
     *     tags={"Users"},
     *     summary="Get the list of all user.",
     *     @SWG\Response(
     *         response=200,
     *         description="Returned when successful",
     *         @Doc\Model(type=User::class, groups={"list", "customer"})
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Returned when the JWT Token is expired or invalid"
     *     )
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
                $paramFetcher->get('max_per_page'),
                $paramFetcher->get('current_page')
            );

        return new Users($pager);
    }

    /**
     * @param Security $security
     * @param User     $user
     *
     * @return User
     *
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
     *
     * @Doc\Operation(
     *     tags={"Users"},
     *     summary="Get one user",
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         type="integer",
     *         description="The user unique identifier"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Returned when successful",
     *         @Doc\Model(type=User::class, groups={"details", "customer"})
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Returned when the JWT Token is expired or invalid"
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="returned when the authenticated customer is not allowed to access the selected user"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Returned when the user is not found"
     *     )
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
     * @param Security                         $security
     * @param User                             $user
     * @param ConstraintViolationListInterface $violations
     *
     * @return User
     *
     * @throws ResourceValidationException
     *
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
     *
     * @Doc\Operation(
     *     tags={"Users"},
     *     summary="Create one user",
     *     @SWG\Response(
     *         response=201,
     *         description="Returned when created",
     *         @Doc\Model(type=User::class, groups={"details", "customer"})
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Returned when a violation is raised by validation"
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Returned when the JWT Token is expired or invalid"
     *     )
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
     * @param Security $security
     * @param User     $user
     *
     * @Rest\Delete(
     *     path = "/users/{id}",
     *     name = "user_delete",
     *     requirements = {"id"="\d+"}
     * )
     *
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     *
     * @Doc\Operation(
     *     tags={"Users"},
     *     summary="Delete one user",
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         type="integer",
     *         description="The user unique identifier"
     *     ),
     *     @SWG\Response(
     *         response=204,
     *         description="Returned when deleted",
     *         @Doc\Model(type=User::class, groups={"details", "customer"})
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Returned when the JWT Token is expired or invalid"
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="returned when the authenticated customer is not allowed to access the selected user"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Returned when the user is not found"
     *     )
     * )
     */
    public function delete(Security $security, User $user)
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
