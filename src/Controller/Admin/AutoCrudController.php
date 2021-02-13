<?php


namespace App\Controller\Admin;


use App\Entity\Auto;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

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
        yield IntegerField::new('id', 'ID')->onlyOnIndex();
    }
}