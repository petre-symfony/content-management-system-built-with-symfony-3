<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Category;


class CategoryController extends Controller {
  /**
   * @Route("/categories", name="list_categories")
   * @Method("GET")
   */
  public function listAction(){
    $em = $this->getDoctrine()->getManager();
    $repository = $em->getRepository('AppBundle:Category');
    
    $categories = $repository->findAll();
    
    return $this->render(
      'category/list.html.twig',
      array(
        'categories' => $categories
      )
    );
  }

}
