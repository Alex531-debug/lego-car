<?php


namespace App\Controller\Admin;


use App\Entity\Auto;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AutoCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return Auto::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Автомобиль')
            ->setEntityLabelInPlural('Автомобили');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('id', 'ID')->onlyOnIndex(),
            TextField::new('name', 'название'),
            TextField::new('model', 'модель'),
            MoneyField::new('price', 'цена')->setCurrency('RUB'),
            TextField::new('vin'),
            CollectionField::new('images'),
            ChoiceField::new('status')->setChoices(['в наличии'=>'available', 'подзаказ'=>'on_order'])
        ];
    }
}