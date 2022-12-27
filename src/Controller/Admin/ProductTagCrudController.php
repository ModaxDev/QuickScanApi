<?php

namespace App\Controller\Admin;

use App\Entity\ProductTag;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductTagCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductTag::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name')->setLabel("Nom"),
        ];
    }

}
