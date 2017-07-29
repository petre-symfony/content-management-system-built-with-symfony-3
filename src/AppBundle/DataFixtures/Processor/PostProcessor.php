<?php

namespace AppBundle\DataFixtures\Processor;

use Nelmio\Alice\ProcessorInterface;
use AppBundle\Entity\Post;

class PostProcessor implements ProcessorInterface{
  private $titleImagesArray = array(
    "cms" => "cms_img_placeholder",
    "javascript" => "javascript",
    "jQuery" =>  "jQuery",
    "laravel" => "laravel",
    "ruby" => "ruby",
    "rails" => "ruby_on_rails",
    "symfony" => "symfony"    
  );
  
  public function preProcess($object){
    if (FALSE == $object instanceof Post){
      return;
    }
    
    $titles = array_keys($this->titleImagesArray);
    $underlinePos = strpos($object->getPostTitle(), '_');
    $stringToMatch = substr($object->getPostTitle(), 0, $underlinePos);
    $object->setPostImage($this->titleImagesArray[$stringToMatch]);
  }
  
  public function postProcess($object){
    
  }
}
