<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Tag
 *
 * @ORM\Table(name="tag")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TagRepository")
 */
class Tag {
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
     * @ORM\Column(name="tag_name", type="string", length=255)
     * @Assert\NotBlank()
  */
  private $tagName;
  
  public function getTagName(){
    return $this->tagName;
  }
  
  public function setTagName($tagName){
    $this->tagName = $tagName;
  }
}