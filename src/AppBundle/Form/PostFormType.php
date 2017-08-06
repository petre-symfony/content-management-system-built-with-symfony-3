<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Category;
use AppBundle\Repository\CategoryRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\CallbackTransformer;
use AppBundle\Entity\Tag;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Collections\ArrayCollection;


class PostFormType extends AbstractType {
  private $em;
  
  public function __construct(EntityManager $em) {
    $this->em = $em;
  }
  
  public function buildForm(FormBuilderInterface $builder, array $options){
    $builder
      ->add('postTitle', TextType::class)
      ->add('postAuthor', TextType::class) 
      ->add('postContent', TextareaType::class)      
      ->add('postCategory', EntityType::class, [
        'placeholder' => 'Choose a Category',
        'class' => 'AppBundle:Category',
        'query_builder' => function(CategoryRepository $repo){
          return $repo->createAlphabeticalQueryBuilder();
        }  
      ])
      ->add('postStatus', ChoiceType::class, array(
        'choices' => array(
          'published' => 'published',
          'not_published' => 'draft'  
        ),
        'expanded' => TRUE  
      ))
      ->add('postImage', FileType::class, array(
        'data_class' => null, 
        'required' => false,
        'image' => 'postImage'  
      ))
      ->add('postTags', TextType::class, array('required' => false));
      
     
    $builder
      ->get('postTags')
      ->addModelTransformer(new CallbackTransformer(
        function ($tagsAsArray){
          //transform the ArrayCollection to an array of strings
          $tagStringsArray = array_map(function(Tag $tag){
            return $tag->getTagName();
          }, $tagsAsArray->toArray());
          return implode(', ', $tagStringsArray);
        },
        function ($tagsAsString){
          $tagNamesArray = explode(', ', $tagsAsString);
          $tagsArrayCollection = new ArrayCollection();
          
          foreach($tagNamesArray as $key => $tagName){
            $tag = $this->em->getRepository('AppBundle:Tag')->findOneBy(['tagName' => $tagName]);
            
            if (!$tag){
              $tag = new Tag();
              $tag->setTagName($tagName);
              $this->em->persist($tag);
              $this->em->flush();
            }
            
            $tagsArrayCollection->add($tag);
          }
          
          return $tagsArrayCollection;
        }
      ));        
  }
  /**
   * {@inheritdoc}
   */
  public function configureOptions(OptionsResolver $resolver){
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\Post'
    ));
  }
}