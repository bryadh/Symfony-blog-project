<?php

namespace App\Service;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;

class MemeSerialization  
{

    public function getSerializedMemes(EntityManagerInterface $entityManagerInterface)
    {
        $memes = $entityManagerInterface->getRepository(Article::class)->findAll();

        $serializedMemes = [];

        foreach ($memes as $meme ) {
            $serializedMemes []= [
                'id' => $meme->getId(),
                'title' => $meme->getTitle(),
                'slug' => $meme->getSlug(),
                'content' => $meme->getContent(),
                'urlimage' => $meme->getUrlimage(),
                'created' => $meme->getCreated(),
                'updated' => $meme->getUpdated()
            ];
        }

        return $serializedMemes;
    }
    
}


?>