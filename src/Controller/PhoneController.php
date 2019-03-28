<?php

namespace App\Controller;

use App\Entity\Phone;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

class PhoneController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/phones", name="article_list")
     * @Rest\View(statusCode=Response::HTTP_OK, serializerGroups={"list"})
     */
    public function list()
    {
        $phones = $this->getDoctrine()
            ->getRepository(Phone::class)
            ->findAll();

        return $phones;
    }

    /**
     * @Rest\Get(
     *     path = "/phones/{id}",
     *     name = "phone_show",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View(statusCode=Response::HTTP_OK, serializerGroups={"details"})
     */
    public function show(Phone $phone)
    {
        return $phone;
    }
}
