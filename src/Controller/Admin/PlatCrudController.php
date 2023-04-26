<?php

namespace App\Controller\Admin;

use App\Entity\Plat;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PlatCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Plat::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            TextareaField::new('description'),
            //choix possible pour les catégories de plat
            ChoiceField::new('category')->setChoices([
                'Entrées' => 'Entrées',
                'Plats' => 'Plats',
                'Desserts' => 'Desserts',
                'Burgers' => 'Burgers',
                'Salades' => 'Salades',
                'Apéritifs'=>'Apéritifs',
                'Vins' => 'Vins'
            ]),
            NumberField::new('price')
        ];
    }
    
}
