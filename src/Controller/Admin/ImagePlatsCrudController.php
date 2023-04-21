<?php

namespace App\Controller\Admin;

use App\Entity\ImagePlats;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ImagePlatsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ImagePlats::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            ImageField::new('url')
                ->setBasePath('images/plats')
                ->setUploadDir('public/images/plats')
        ];
    }
    
}
