<?php
namespace AppBundle\Controller\Admin;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\CategoryFormType;
use AppBundle\Entity\Category;


/**
 * @Route("/admin")
 */
class PostAdminController extends Controller{
  /**
   * @Route("/", name="admin_list_posts")
   * @Method("GET")
   */
  public function listAction(){
    $em = $this->getDoctrine()->getManager();
    $repository = $em->getRepository('AppBundle:Post');
    
    $posts = $repository->findAll();
    
    return $this->render(
      'admin/post/list.html.twig',
      array(  
        'posts' => $posts    
      )
    ); 
  }
}