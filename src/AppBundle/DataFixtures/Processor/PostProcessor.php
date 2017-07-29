<?php

namespace AppBundle\DataFixtures\Processor;

use Nelmio\Alice\ProcessorInterface;
use AppBundle\Entity\Post;
use AppBundle\Entity\Category;
use Doctrine\ORM\EntityManager;

class PostProcessor implements ProcessorInterface{
  private $titleImagesArray = array(
    "cms" => "cms_img_placeholder.jpg",
    "javascript" => "javascript.jpg",
    "jQuery" =>  "jQuery.jpg",
    "laravel" => "laravel.jpg",
    "ruby" => "ruby.jpg",
    "rails" => "ruby_on_rails.jpg",
    "symfony" => "symfony.jpg",
    "ajax" => "AJAX.jpg",
    "python" => "python.jpg",
    "django" => "django.jpg",
    "drupal" => "drupal.jpg",
    "php"   => "php.jpg"
  );
  
  private $tagPostNames = array(
    "cms" => [ "cms" , "Web framework"],
    "javascript" => [ "javascript", "Client Browser Programming"],
    "jQuery" => [ "javascript", "jQuery", "ajax"],
    "laravel" => [ "laravel", "php", "ajax", "MVC",  "Web framework"],
    "ruby" => [ "ruby" , "Programming Language"],
    "rails" => [ "ruby", "rails", "MVC", "Web framework"],
    "symfony" => [ "symfony", "php", "MVC", "Web framework", "cms"],
    "ajax" => [ "ajax", "Asynchronous Javascript" ],
    "python" => ["python", "Programming Language"],
    "django" => [ "python", "django", "cms", "Web framework"],
    "drupal" => [ "drupal", "php", "cms", "Web framework", "MVC", "Asynchronous Javascript"],
    "php"    => [ "php", "Server Script Programming"]
  );
  
  private $em;
  
  public function __construct(EntityManager $em) {
    $this->em = $em;
  }


  public function preProcess($object){
    if (FALSE == $object instanceof Post){
      return;
    }
    
    $titles = array_keys($this->titleImagesArray);
    $underlinePos = strpos($object->getPostTitle(), '_');
    $stringToMatch = substr($object->getPostTitle(), 0, $underlinePos);
    $valueMatched = $this->titleImagesArray[$stringToMatch];
    $object->setPostImage($valueMatched);
    
  }
  
  public function postProcess($object){
    if (FALSE == $object instanceof Post){
      return;
    }
    
    $underlinePos = strpos($object->getPostTitle(), '_');
    $stringToMatch = substr($object->getPostTitle(), 0, $underlinePos);
    
    $category = $this->em->getRepository('AppBundle:Category')->findOneBy(['catTitle' => $stringToMatch]);
    $object->setPostCategory($category);
    
    $tags = $this->tagPostNames[$stringToMatch];
    foreach($tags as $key => $tagName){
      $tag = $this->em->getRepository('AppBundle:Tag')->findOneBy(["tagName" => $tagName]);
      $object->addTag($tag);
    };
    
    $this->em->persist($object);
    $this->em->flush();
  }
}
