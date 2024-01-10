<?php

namespace App\Form;

use App\Entity\VendorPart;
use App\Entity\Vendor;
use App\Entity\Part;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class VendorPartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('part', EntityType::class, [
                'class' => Part::class,
                'choice_label' => 'partNumber',
                'attr' => ['class' => 'form-select']
            ])
            ->add('vendor', EntityType::class, [
                'class' => Vendor::class,
                'choice_label' => 'vendorName',
                'attr' => ['class' => 'form-select']
            ])
            ->add('vendorPartNumber', TextType::class,[
                'attr' => ['class' => 'form-control']
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VendorPart::class,
            'attr' => ['class' => 'p-3 m-5 bg-light border rounded']
        ]);
    }
}
