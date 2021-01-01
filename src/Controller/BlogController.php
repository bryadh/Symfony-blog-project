<?php

namespace App\Controller;

use App\Entity\Article;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class BlogController extends AbstractController
{
    /**
     * @Route("/", name="blog")
     * @Method({"GET"})
     */
    public function index(): Response
    {

        $articles = $this->getDoctrine()->getRepository(Article::class)->findBy(array(), array('updated' => 'DESC'));

        return $this->render('blog/index.html.twig', 
            array('articles' => $articles)
        );
    }
}
