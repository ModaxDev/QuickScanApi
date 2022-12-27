<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Produit')
            ->setEntityLabelInPlural('Produits');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('barCodeNumber'),
            TextField::new('name'),
            TextEditorField::new('description'),
            ImageField::new('thumbnail')->setBasePath('/files/products')->setUploadDir('public/files/products')->setLabel("Illustration")->hideOnForm(),
            TextareaField::new('picture')->setLabel("Illustration")->setFormType(VichImageType::class)->hideOnIndex(),
            TextField::new('company')->setLabel("Nom de l'entreprise"),
            ImageField::new('companyLogo')->setBasePath('/files/products')->setUploadDir('public/files/products')->setLabel("Logo de l'entreprise")->hideOnForm()->hideOnIndex(),
            TextareaField::new('pictureCompany')->setLabel("Logo de l'entreprise")->setFormType(VichImageType::class)->hideOnIndex()->hideOnIndex(),
            BooleanField::new('isFixable')->setLabel("Est-il réparable ?")->hideOnIndex(),
            IntegerField::new('reparabilityIndex')->setLabel("Indice de réparabilité")->hideOnIndex(),
            CollectionField::new('productAccessories')->setLabel("Accessoires")->useEntryCrudForm()->hideOnIndex(),
            CollectionField::new('productVideos')->setLabel("Vidéos")->useEntryCrudForm()->hideOnIndex(),
            CollectionField::new('productTags')->setLabel("Tags")->useEntryCrudForm()->hideOnIndex(),
        ];
    }

}
