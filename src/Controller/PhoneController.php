<?php

namespace App\Controller;

use App\Entity\Phone;
use App\Representation\Phones;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/** @Route("/api") */
class PhoneController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(
     *     path = "/phones",
     *     name = "phone_list",
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
     *     default="5",
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
     */
    public function list(ParamFetcherInterface $paramFetcher)
    {
        $pager = $this->getDoctrine()
            ->getRepository(Phone::class)
            ->search(
                $paramFetcher->get('keyword'),
                $paramFetcher->get('order'),
                $paramFetcher->get('max_per_page'),
                $paramFetcher->get('current_page')
            );

        return new Phones($pager);
    }

    /**
     * @Rest\Get(
     *     path = "/phones/{id}",
     *     name = "phone_show",
     *     requirements = {"id"="\d+"}
     * )
     *
     * @Rest\View(
     *     statusCode=Response::HTTP_OK,
     *     serializerGroups={"details", "customer"}
     * )
     */
    public function show(Phone $phone)
    {
        return $phone;
    }
}
