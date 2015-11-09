<?php

namespace ExpressLibrary\Forms;

use Symfony\Component\Form\AbstractType;
use SYmfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class AddAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('username', 'text',
                [
                    'constraints' => new Assert\NotBlank()
                ]
            )
            ->add('email', 'text',
                [
                    'constraints' =>
                        [
                            new Assert\NotBlank(),
                            new Assert\Email()
                        ]

                ]
            )
            ->add('password', 'password',
                [
                    'constraints' => new Assert\NotBlank()

                ]
            )
            ->add('submit', 'submit');
    }
}
