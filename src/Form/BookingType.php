<?php

namespace App\Form;

use App\Entity\Booking;
use App\Form\ApplicationType;
use App\Form\DataTransformer\FrenchToDateTimeTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BookingType extends ApplicationType
{
    private $transformer;
    public function __construct(FrenchToDateTimeTransformer $transformer)
    {
        $this->transformer = $transformer;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate', TextType::class,[
                'label'=> 'Date d\'arrivée',
                'attr' => [
                    'placeholder' => "Choisissez la date du début de votre séjour"
                ]

                ])
            ->add('endDate', TextType::class, [
                'label'=> 'Date de départ',
                'attr' => [
                    'placeholder' => "Choisissez la date de la fin de votre séjour"
                ]

            ])
            ->add('comment', TextareaType::class, $this->getConfiguration(false,"Si vous avez un commentaire, n'hésitez pas à en faire part!",""))
        ;
        $builder->get('startDate')->addModelTransformer($this->transformer);
        $builder->get('endDate')->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
