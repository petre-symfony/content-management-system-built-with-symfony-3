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

class PostFormType extends AbstractType {
  /**
   * {@inheritdoc}
   */
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
      ->add('postImage', FileType::class);
      
        
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