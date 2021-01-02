<?php

namespace App\Controller;

use App\Service\MemeSerialization;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="api")
     * @Method({"GET"})
     */
    public function index(EntityManagerInterface $entityManagerInterface, MemeSerialization $memeSerialization): Response
    {
        
        $serializedMemes = $memeSerialization->getSerializedMemes($entityManagerInterface);

        return new JsonResponse([
            'data' => $serializedMemes,
            'items' => count($serializedMemes)
        ]);
    }
}
