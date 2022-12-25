<?php

namespace App\Controller\Admin;

use App\Entity\ProductAccessories;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProductAccessoriesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductAccessories::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Accessoire')
            ->setEntityLabelInPlural('Accessoires');
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name')->setLabel("Nom"),
            UrlField::new('link')->setLabel("Lien"),
            ImageField::new('illustration')->setBasePath('/files/products')->setUploadDir('public/files/products')->setLabel("Illustration")->hideOnForm(),
            TextareaField::new('picture')->setLabel("Illustration")->setFormType(VichImageType::class)->hideOnIndex(),
        ];
    }

}
