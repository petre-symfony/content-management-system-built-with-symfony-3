<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 */
class Category {
  /**
   * @var int
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @var string
   * @ORM\Column(name="cat_title", type="string", length=255)
   * @Assert\NotBlank()
   */
  private $catTitle;


  /**
   * Get id
   *
   * @return int
   */
  public function getId(){
    return $this->id;
  }

  /**
   * Set catTitle
   *
   * @param string $catTitle
   *
   * @return Category
   */
  public function setCatTitle($catTitle){
    $this->catTitle = $catTitle;

    return $this;
  }

  /**
   * Get catTitle
   *
   * @return string
   */
  public function getCatTitle(){
    return $this->catTitle;
  }
}

