<?php

namespace ExpressLibrary\Forms;

use Symfony\Component\Form\AbstractType;
use SYmfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class AdminLoginType extends AbstractType
{
    private $username;

    private $password;

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('username', 'text',
                [
                    'constraints' => new Assert\NotBlank()
                ]
            )
            ->add('password', 'password',
                [
                    'constraints' => new Assert\NotBlank()
                ]
            )
            ->add('login', 'submit');
    }
}
