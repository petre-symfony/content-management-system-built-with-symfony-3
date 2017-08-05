<?php
namespace AppBundle\Controller\Admin;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\CategoryFormType;
use AppBundle\Entity\Category;
use AppBundle\Form\PostFormType;
use AppBundle\Entity\Post;


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
  
  /**
   * @Route("/post/new", name="admin_new_post")
   * 
   */
  public function newAction(Request $request){
    $post = new Post();
    $form = $this->createForm(PostFormType::class, $post);
  
    
    // only handles data on POST
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $post = $form->getData();
      $em = $this->getDoctrine()->getManager();
      $em->persist($post);
      $em->flush();
      
      $this->addFlash('success', 'Post created');
      
      return $this->redirectToRoute('admin_list_posts');
    }  else if ($form->isSubmitted() && !$form->isValid()){
      $this->addFlash('failed', "fail to create post");
    }
    
    return $this->render(
      'admin/post/new.html.twig', 
      array(
        'postForm' => $form->createView()
      )
    );
  }
  
  
  /**
   * @Route("/post/{id}/edit", name="admin_edit_post")
   * 
   */
  public function editAction(Request $request, Post $post){
    $form = $this->createForm(PostFormType::class, $post);
  
    $postImage = $post->getPostImage();
    // only handles data on POST
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $post = $form->getData();
      if (!$post->getPostImage()){
        $post->setPostImage($postImage);
      }
      $em = $this->getDoctrine()->getManager();
      
      $em->persist($post);
      $em->flush();
      $this->addFlash('success', 'Post created');
      
      return $this->redirectToRoute('admin_list_posts');
    } else if ($form->isSubmitted() && !$form->isValid()){
      $this->addFlash('failed', "fail to create post");
    }
    
    
    return $this->render(
      'admin/post/edit.html.twig', 
      array(
        'postForm' => $form->createView()
      )
    );
  }
}