<?php

namespace ExpressLibrary\Forms;

use Symfony\Component\Form\AbstractType;
use SYmfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Silex\Application;
use ExpressLibrary\Helpers\GetAllCategoriesHelper;

class BookForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title', 'text',
                    [
                        'constraints' => new Assert\NotBlank()
                    ])

                ->add('category', 'choice',
                    [
                        'constraints' => new Assert\NotBlank(),
                        'choices' => GetAllCategoriesHelper::help()
                    ])

                ->add('author', 'text',
                    [
                        'constraints' => new Assert\NotBlank()
                    ])

                ->add('totalPage', 'integer',
                    [
                        'constraints' => new Assert\NotBlank()
                    ])
                ->add('image', 'file',
                    [
                        'constraints' => new Assert\NotBlank()
                    ])
                ->add('description', 'textarea',
                    [
                        'constraints' => new Assert\NotBlank()
                    ]);
    }


}
