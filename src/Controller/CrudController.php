<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Post;
use DateTime;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;

class CrudController extends AbstractController
{

    /**
     * @Route("/crud/new", name="crud_new_post")
     * @Method({"GET", "POST"})
    */
    public function new(Request $request){
        
        $article = new Article();
        $form = $this->createFormBuilder($article)
        ->add('title', TextType::class,
            array('attr' => array('class' => 'form-control')))
        ->add('content', TextareaType::class,
            array('attr' => array('class' => 'form-control')))
        ->add('ajouter', SubmitType::class,
            array('attr' => array('class' => 'btn btn-success mt-2')))
        ->getForm();
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
    
            $article = $form->getData();

            // get project dir 
            $projdir = $this->getParameter('kernel.project_dir');
            $files = glob($projdir.'\public\images\*.jpg');
            
            // choose random image
            $file = array_rand($files);
            
            // trim for a valid url
            $trimmed = str_replace($projdir,'', $files[$file]);
            $parts = explode("\\", $trimmed);
            $urlimg = $parts[2] . '/' . $parts[3];
            
            $article->setUrlImage($urlimg);
           
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('blog');
        }

        return $this->render('crud/new.html.twig', array('form' => $form->createView()));
            
    }

    /**
    * @Route("/crud/edit/{id}", name="article_edit")
    * @Method({"GET","POST"})
    */
    public function edit(Request $request, $id){

        $article = new Article();

        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        $form = $this->createFormBuilder($article)
        ->add('title', TextType::class,
            array('attr' => array('class' => 'form-control')))
        ->add('content', TextareaType::class,
            array('attr' => array('class' => 'form-control')))
        ->add('Edit', SubmitType::class,
            array('attr' => array('class' => 'btn btn-primary mt-2')))
        ->getForm();
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->flush();

            return $this->redirectToRoute('blog');
        }

            return $this->render('crud/edit.html.twig', array('form' => $form->createView()));
    }

     /**
     * @Route("/crud/{id}", name="crud_show_post")
     */
    public function show($id): Response
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        return $this->render('crud/index.html.twig',
            array('article' => $article) 
        );
    }

    /**
    * @Route("/crud/delete/{id}", name="crud_delete_post")
    * @Method({"DELETE"})
    */
    public function delete(Request $request, $id){

        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($article);
        $entityManager->flush();

        $reponse = new Response();
        $reponse->send();
       
    }
  

}
