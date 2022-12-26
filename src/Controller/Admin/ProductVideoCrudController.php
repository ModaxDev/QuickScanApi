<?php

namespace App\Controller\Admin;

use App\Entity\ProductVideo;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class ProductVideoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductVideo::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Vidéo')
            ->setEntityLabelInPlural('Vidéos');
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title')->setLabel("Titre"),
            ChoiceField::new('category')->setChoices([
                'Tutoriel' => 'tutorial',
                'Présentation' => 'presentation',
                'Démonstration' => 'demonstration',
            ])->setLabel("Catégorie"),
            UrlField::new('link')->setLabel("Lien de la vidéo"),
            IntegerField::new('orderNumber')->setLabel("Ordre d'affichage"),
        ];
    }

}
