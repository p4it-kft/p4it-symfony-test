<?php

namespace App\Form\Type;

use App\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class MessageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('title')
            ->add('text', TextareaType::class)
            ->add('authorEmail')
            ->add('messageTags', EntityType::class, [
                'class' => Tag::class,
                'multiple' => true,
                'expanded' => false,
            ])
            ->add('save', SubmitType::class, ['label' => 'Send']);

    }
}