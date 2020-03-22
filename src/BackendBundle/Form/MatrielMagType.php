<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 21/03/2020
 * Time: 00:04
 */

namespace BackendBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class MatrielMagType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type',TextType::class,array('attr' => array('class' => 'form-control'),'constraints' => array(
                new NotBlank(),
                new Length(array('min' =>3)),
                new Length(array('max' => 20)),
            )))
            ->add('reference', TextType::class,array('attr' => array('class' => 'form-control'),'constraints' => array(
                new NotBlank(),
                new Length(array('min' =>4)),
                new Length(array('max' => 20)),
            )))
            ->add('photo', FileType::class, array('data_class'=>null, 'required'=>false));
    }/**
 * {@inheritdoc}
 */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackendBundle\Entity\MatrielMag'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'BackendBundle_matrielmag';
    }
}