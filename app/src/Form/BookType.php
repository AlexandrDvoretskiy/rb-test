<?php

namespace App\Form;

use App\Entity\Book;
use CategoryBundle\Domain\Service\CategoryService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class BookType extends AbstractType
{
    public function __construct(
        private readonly CategoryService $categoryService
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('author')
            ->add('publishedAt', null, [
                'widget' => 'single_text',
            ])
            ->add('description', TextareaType::class, [
                'trim' => true,
            ])
            ->add('isbn')
            ->add('categoryId', ChoiceType::class, [
                'choices' => $this->categoryService->getSelectItems(),
                'placeholder' => 'Choose a category',
            ])
        ;

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();

            // Update the event with the modified data
            $event->setData($data);
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
