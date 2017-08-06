<?php

namespace AppBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

class ImageTypeExtension extends AbstractTypeExtension {
  /**
   * Returns the name of the type being extended
   * 
   * @return string The name of the type being extended
   */
  public function getExtendedType() {
    //use FormType::class to modify (nearly) every field in the system
    return FileType::class;
  }
  
  /**
   * Add the image option
   * 
   * @param OptionResolver $resolver
   */
  public function configureOptions(OptionsResolver $resolver){
    $resolver->setDefined(array('image'));
  }
  
  /**
   * Pass the image to the view
   * 
   * @param FormView $view
   * @param FormInterface $form
   * @param array $options
   */
  public function buildView(FormView $view, FormInterface $form, array $options){
    if (isset($options['image'])){
      $parentData = $form->getParent()->getData();
    }
    
    $image = null;
    if (null !== $parentData){
      $accessor = PropertyAccess::createPropertyAccessor();
      $image = $accessor->getValue($parentData, $options['image']);
    }
    
    //set an "image" variable that will be available when rendering this field
    $view->vars["image"] = $image;
  }
}

