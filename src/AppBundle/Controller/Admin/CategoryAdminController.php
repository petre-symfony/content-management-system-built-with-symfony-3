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
class CategoryAdminController extends Controller{
  /**
   * @Route("/", name="admin_list_categories")
   * @Method("GET")
   */
  public function listAction(){
    $em = $this->getDoctrine()->getManager();
    $repository = $em->getRepository('AppBundle:Category');
    
    $categories = $repository->findAll();
    
    return $this->render(
      'admin/category/list.html.twig',
      array(
        'categories' => $categories    
      )
    ); 
  }
  
  /**
   * @Route("/category/new", name="admin_category_new")
   * @Method("POST")
   */
  public function newAction(Request $request){
    $category = new Category();
    $form = $this->createForm(CategoryFormType::class, $category, array('action' => $this->generateUrl('admin_category_new')));
  
    
    // only handles data on POST
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $category = $form->getData();
      $em = $this->getDoctrine()->getManager();
      $em->persist($category);
      $em->flush();
      
      return $this->redirectToRoute('admin_list_categories');
    }
    
    return $this->render(
      'admin/category/_form.html.twig', 
      array(
        'categoryForm' => $form->createView()
      )
    );
  }
  
  
  /**
   * @Route("/category/{catTitle}/delete", name="admin_category_delete")
   * 
   */
  public function deleteAction($catTitle){
    $em = $this->getDoctrine()->getManager();
    $repository = $em->getRepository('AppBundle:Category');
    
    $category = $repository->findOneBy(['catTitle' => $catTitle ]); 
    
    if(!$category){
      throw $this->createNotFoundException('Cannot find this category');
    }
    
    $em->remove($category);
    $em->flush();
    
    return $this->redirectToRoute('admin_list_categories');
  }
}