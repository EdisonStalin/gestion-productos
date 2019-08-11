<?php
// src/App/Form/RegistrationType.php

namespace App\Form;

use App\Form\EventListener\AddCityFieldListener;
use App\Form\EventListener\AddCountryFieldListener;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')
        ->addEventSubscriber(new AddCountryFieldListener())
            ->addEventSubscriber(new AddCityFieldListener());
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';

        // Or for Symfony < 2.8
        // return 'fos_user_registration';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
