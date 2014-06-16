<?php

namespace MarincsakIstvan\ApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use MarincsakIstvan\ApiBundle\Form\DataTransformer\TextToTypeTransformer;

class RobotType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('year');

        $entityManager = $options['em'];
        $transformer = new TextToTypeTransformer($entityManager);

        $builder->add(
            $builder->create('type', 'text', array('invalid_message' => 'Not valid type'))
                ->addModelTransformer($transformer)
        );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MarincsakIstvan\ApiBundle\Entity\Robot',
            'csrf_protection' => false,
            'invalid_message' => 'The selected type does not exist',
        ))->setRequired(array(
                'em',
            ))->setAllowedTypes(array(
                'em' => 'Doctrine\Common\Persistence\ObjectManager',
            ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'marincsakistvan_apibundle_robot';
    }
}
