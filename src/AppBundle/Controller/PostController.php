<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Post;

class PostController extends Controller {
  /**
   * @Route("/", name="homepage")
   * @Method("GET")
   */
  public function listAction(){
    $em = $this->getDoctrine()->getManager();
    $repository = $em->getRepository('AppBundle:Post');
    
    $posts = $repository->findAll();
    
    return $this->render(
      'post/list.html.twig',
      array(
        'posts' => $posts
      )
    );
  }
}
