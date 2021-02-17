<?php


namespace App\Controller\Admin;


use App\Entity\Car;
use App\Form\ImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use phpDocumentor\Reflection\Types\Integer;

class CarCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return Car::class;
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
            IntegerField::new('id')->onlyOnIndex(),
            'name',
            'model',
             MoneyField::new('price', 'цена')->setCurrency('RUB'),
            'vin',
             ChoiceField::new('status')->setChoices(['в наличии'=>'available', 'подзаказ'=>'on_order']),
             CollectionField::new('images')
                ->setEntryType(ImageType::class)
                 ->setFormTypeOption('by_reference', false)
                ->onlyOnForms(),
        ];
    }
}