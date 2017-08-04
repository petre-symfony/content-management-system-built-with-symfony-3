<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Post
 *
 * @ORM\Table(name="post")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PostRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Post {
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
   *
   * @ORM\Column(name="post_title", type="string", length=255)
   */
  private $postTitle;

  /**
   * @var string
   *
   * @ORM\Column(name="post_author", type="string", length=255)
   */
  private $postAuthor;

  /**
   * @var string
   *
   * @ORM\Column(name="post_image", type="string", length=255)
   */
  private $postImage;

  /**
   * @var string
   *
   * @ORM\Column(name="post_content", type="text")
   */
  private $postContent;

  /**
   * @var \DateTime
   *
   * @ORM\Column(name="post_date", type="date")
   */
  private $postDate;

  /**
   * @var string
   *
   * @ORM\Column(name="post_status", type="string", length=100)
   */
  private $postStatus;
  
  /**
   * @ORM\ManyToOne(targetEntity="Category")
   */
  private $postCategory;
  
  /**
   * @ORM\ManyToMany(targetEntity="Tag", inversedBy="tagPosts", fetch="EXTRA_LAZY")
   * @ORM\JoinTable(name="post_tag")
   */
  private $postTags;
  
  public function __construct() {
    $this->postTags = new ArrayCollection();
  }

  /**
   * Get id
   *
   * @return int
   */
  public function getId(){
    return $this->id;
  }

  /**
   * Set postTitle
   *
   * @param string $postTitle
   *
   * @return Post
   */
  public function setPostTitle($postTitle){
    $this->postTitle = $postTitle;

    return $this;
  }

  /**
   * Get postTitle
   *
   * @return string
   */
  public function getPostTitle(){
    return $this->postTitle;
  }

  /**
   * Set postAuthor
   *
   * @param string $postAuthor
   *
   * @return Post
   */
  public function setPostAuthor($postAuthor){
    $this->postAuthor = $postAuthor;

    return $this;
  }

  /**
   * Get postAuthor
   *
   * @return string
   */
  public function getPostAuthor(){
    return $this->postAuthor;
  }

  /**
   * Set postImage
   *
   * @param string $postImage
   *
   * @return Post
   */
  public function setPostImage($postImage){
    $this->postImage = $postImage;

    return $this;
  }

  /**
   * Get postImage
   *
   * @return string
   */
  public function getPostImage(){
    return $this->postImage;
  }

  /**
   * Set postContent
   *
   * @param string $postContent
   *
   * @return Post
   */
  public function setPostContent($postContent){
    $this->postContent = $postContent;

    return $this;
  }

  /**
   * Get postContent
   *
   * @return string
   */
  public function getPostContent(){
    return $this->postContent;
  }

  /**
   * Set postDate
   *
   * @param \DateTime $postDate
   * @ORM\PrePersist
   * @return Post
   */
  public function setPostDate(){
    $this->postDate = new \DateTime();;

    return $this;
  }

  /**
   * Get postDate
   *
   * @return \DateTime
   */
  public function getPostDate(){
    return $this->postDate;
  }
  
  /**
   * Set postStatus
   *
   * @param string $postStatus
   *
   * @return Post
   */
  public function setPostStatus($postStatus){
    $this->postStatus = $postStatus;
    return $this;
  }
  /**
   * Get postStatus
   *
   * @return string
   */
  public function getPostStatus(){
    return $this->postStatus;
  }
  /**
   * Set Category
   * @param Category $category
   * @return Post
   */
  public function setPostCategory(Category $category = null){
    $this->postCategory = $category;
    return $this;
  } 
  
  /**
   * Get category
   * @return Category
   */
  public function getPostCategory() {
    return $this->postCategory;
  }
  
  
  public function getPostTags(){
    return $this->postTags;
  }
  
  public function setPostTags($tags){
    //start with this empty
    $this->postTags->clear();
    
    foreach ($tags->toArray() as $key => $tag){
      if ($this->postTags->contains($tag)){
        continue;
      }
      $this->addTag($tag);
    }
    
    return $this;
  }
  
  public function getPostTagsName(){
    $tagStringsArray = array_map(function(Tag $tag){
      return $tag->getTagName();
    }, $this->postTags->toArray());
    return implode(', ', $tagStringsArray);

  }
  
  public function addTag(Tag $tag){
    $this->postTags->add($tag);
  }
}

