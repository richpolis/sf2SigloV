<?php

namespace Richpolis\PublicacionesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GaleriaLinkVideoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo','text',array('label'=>'Titulo','attr'=>array(
                'class'=>'validate[required] form-control placeholder',
                'placeholder'=>'Titulo',
                'data-bind'=>'value: titulo'
             )))
            ->add('descripcion',null,array(
                'label'=>'Descripcion',
                'required'=>false,
                'attr'=>array(
                    'class'=>'cleditor form-control placeholder',
                    )
                ))
            ->add('archivo','text',array('label'=>'Link Video','attr'=>array(
                'class'=>'validate[required] form-control placeholder',
                'placeholder'=>'Link Video',
                'data-bind'=>'value: link video'
             )))
            ->add('publicacion',null,array(
                'label'=>'Publicacion',
                'required'=>true,
                'attr'=>array(
                    'class'=>'validate[required] form-control placeholder',
                    'placeholder'=>'Publicacion',
                    'data-bind'=>'value: publicacion'
                    )
                ))    
            ->add('isActive',null,array('label'=>'Activo?','attr'=>array(
                'class'=>'checkbox-inline',
                'placeholder'=>'Es activo',
                'data-bind'=>'value: isActive'
                )))
            ->add('tipoArchivo','hidden')    
            ->add('position','hidden')    
            ->add('thumbnail','hidden')
                
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Richpolis\PublicacionesBundle\Entity\Galeria',
            'csrf_protection' => false
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return '';
    }
}
