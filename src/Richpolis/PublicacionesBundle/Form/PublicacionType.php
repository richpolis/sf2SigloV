<?php

namespace Richpolis\PublicacionesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Richpolis\BackendBundle\Repository\UsuariosRepository;
use Richpolis\PublicacionesBundle\Entity\CategoriaRepository;

class PublicacionType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo','text',array(
                'label'=>'Titulo','required'=>true,'attr'=>array(
                    'class'=>'form-control placeholder',
                    'placeholder'=>'Titulo',
                    'data-bind'=>'value: titulo'
                    )
                ))    
            ->add('descripcionCorta',null,array(
                'label'=>'Descripcion corta',
                'required'=>true,
                'attr'=>array(
                    'class'=>'cleditor form-control placeholder',
                    )
                ))    
            ->add('contenido',null,array(
                'label'=>'Contenido',
                'required'=>true,
                'attr'=>array(
                    'class'=>'cleditor form-control placeholder',
                    )
                ))
            ->add('visitas','integer',array(
                'label'=>'Visitas','required'=>false,'attr'=>array(
                    'class'=>'form-control placeholder',
                    'placeholder'=>'Visitas',
                    'data-bind'=>'value: visitas',
                    'readonly'=>true,
                    )
                ))    
            ->add('categoria',null,array(
                'label'=>'Categoria',
                'required'=>true,
                'attr'=>array(
                    'class'=>'validate[required] form-control placeholder',
                    'placeholder'=>'Categoria',
                    'data-bind'=>'value: categoria'
                    )
                ))
            ->add('isActive',null,array('label'=>'Activo?','attr'=>array(
                'class'=>'checkbox-inline',
                'placeholder'=>'Es activo',
                'data-bind'=>'value: isActive'
                )))
            ->add('usuario','hidden')
            ->add('position','hidden')    
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Richpolis\PublicacionesBundle\Entity\Publicacion',
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
