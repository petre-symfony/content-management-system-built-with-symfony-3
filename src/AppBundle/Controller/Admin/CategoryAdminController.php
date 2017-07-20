<?php

namespace AppBundle\Controller\Admin;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
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
    return $this->render('admin/category/list.html.twig');
  }
}