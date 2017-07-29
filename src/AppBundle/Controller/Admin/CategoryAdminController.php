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
   * @Route("/category", name="admin_list_categories")
   * @Method("GET")
   */
  public function listAction(){
    $em = $this->getDoctrine()->getManager();
    $repository = $em->getRepository('AppBundle:Category');
    $form = $this->createForm(CategoryFormType::class);
    
    $categories = $repository->findAll();
    
    return $this->render(
      'admin/category/list.html.twig',
      array(
        'categoryForm' => $form->createView(),   
        'categories' => $categories    
      )
    ); 
  }
  
  /**
   * @Route("/category/new", name="admin_new_category")
   * @Method("POST")
   */
  public function newAction(Request $request){
    $category = new Category();
    $form = $this->createForm(CategoryFormType::class, $category, array('action' => $this->generateUrl('admin_new_category')));
  
    
    // only handles data on POST
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $category = $form->getData();
      $em = $this->getDoctrine()->getManager();
      $em->persist($category);
      $em->flush();
      $this->addFlash('success', 'Category created');
      
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
   * @Route("/category/{catTitle}/edit", name="admin_edit_category")
   * @Method({"GET", "POST"})
   * 
   */
  public function editAction(Request $request, $catTitle){
    $em = $this->getDoctrine()->getManager();
    $repository = $em->getRepository('AppBundle:Category');
    
    $category = $repository->findOneBy(['catTitle' => $catTitle ]); 
    
    
    if(!$category){
      $this->addFlash('failed', 'Not found category ' . $catTitle);
      return $this->redirectToRoute('admin_list_categories');
    }
    
    $initialCategoryName = $category->getCatTitle();
    
    $form = $this->createForm(CategoryFormType::class, $category);
    // only handles data on POST
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $category = $form->getData();
      
      $em->persist($category);
      $em->flush();
      $this->addFlash('success', 'Category ' . $initialCategoryName . ' changed');
      
      return $this->redirectToRoute('admin_list_categories');
    }
    
    return $this->render('admin/category/edit.html.twig', [
      'categoryForm' => $form->createView()    
    ]);
  }
  
  /**
   * @Route("/category/{catTitle}/delete", name="admin_delete_category")
   * 
   */
  public function deleteAction($catTitle){
    $em = $this->getDoctrine()->getManager();
    $repository = $em->getRepository('AppBundle:Category');
    
    $category = $repository->findOneBy(['catTitle' => $catTitle ]); 
    
    if(!$category){
      $this->addFlash('failed', 'Not found category ' . $catTitle);
      return $this->redirectToRoute('admin_list_categories');
    }
    
    $em->remove($category);
    $em->flush();
    $this->addFlash('success', 'Category '. $category->getCatTitle() . ' deleted');
    
    return $this->redirectToRoute('admin_list_categories');
  }
}