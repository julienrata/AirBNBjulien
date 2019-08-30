<?php

namespace App\Form;

use App\Entity\Ad;
use App\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AdType extends AbstractType
{
    /**
     * Permet d'avoir la configuration de base d'un champ
     *
     * @param string $label
     * @param string $placeholder
     * @param string $options
     * @return array 
     */
    private function getConfiguration($label, $placeholder, $options = "required")
    {
        return  [
            'label'=> $label,
            'attr' => [
                'placeholder' => $placeholder
            ],
           'required' => $options                
        ];
    }

    // pour afficher correctement tt le champs désactiver AdBlock (Problème)
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration("Titre de l'annonce","Entrez le nom de l'annonce"))
            ->add('slug', TextType::class, $this->getConfiguration("Adresse web","Entrez l'adresse web (Automatique)",""))
            ->add('coverImage', UrlType::class, $this->getConfiguration("l'image principale","Entrez l'adresse de l'image"))
            ->add('introduction', TextType::class, $this->getConfiguration("Introduction","Donnez une brève description"))
            ->add('content', TextareaType::class, $this->getConfiguration("Description de l'annonce","Decrivez l'annonce"))
            ->add('rooms', IntegerType::class, $this->getConfiguration("Nombre de chambres","Entrez le nombre de chambre disponible"))
            ->add('price', MoneyType::class, $this->getConfiguration("Prix par nuit","Indiquez le prix"))
            ->add('images',CollectionType::class, [
                'entry_type' => ImageType::class,
                'allow_add' => true,
                'allow_delete' => true

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
