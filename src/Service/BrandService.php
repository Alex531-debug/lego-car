<?php


namespace App\Service;


use App\Entity\Brand;
use App\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BrandService
{
    private $em;
    private $validator;
    /**
     * Очищать ли делать ли EntityManager->clear(Brand::class) после вставки
     * @var bool
     */
    private $clearEntityManager = false;
    public function __construct(EntityManagerInterface $em, ValidatorInterface $validator)
    {
        $this->em = $em;
        $this->validator = $validator;
    }

    /**
     * @param array $brand
     * @param bool|null $clearEntityManager если true то будет очищены сущности из entity manager после сохранения
     */
    public function create(array $brand, ?bool $clearEntityManager = null)
    {
        if($clearEntityManager !== null) $this->setClearEntityManager($clearEntityManager);

        $this->addBrand($brand);
        $this->em->flush();
        $this->clearEntityManager();
    }

    /**
     * сохранение данных о брендах в пакетами
     * @param array $brands
     * @param bool|null $clearEntityManager  если true то будет очищены сущности из entity manager после сохранения
     */
    public function createChunk(array $brands, ?bool $clearEntityManager = null)
    {
        if($clearEntityManager !== null) $this->setClearEntityManager($clearEntityManager);

        foreach ($brands as $brand) {
            $this->addBrand($brand);
        }
        $this->em->flush();
        $this->clearEntityManager();
    }

    public function clearEntityManager() {
        if($this->isClearEntityManager()) {
            $this->em->clear(Brand::class);
        }
    }

    private function addBrand(array $brand)
    {
        $this->validateArrayData($brand);
        $entityBrand = $this->getEntityBrand($brand);
        $entityBrand = $this->prepareBrand($brand, $entityBrand);
        $this->validateBrand($entityBrand);
        $this->em->persist($entityBrand);
    }

    private function getEntityBrand(array $brand)
    {
        $entityBrand = $this->findBrand($brand);
        if(!$entityBrand) $entityBrand = new Brand();
        return $entityBrand;
    }

    /**
     * Провяем правильность заполнения данных об автомобиле в json файле
     * @param array $brand данных об автомобиле в массиве
     */
    private function validateArrayData(array $brand):void
    {
        if(empty($brand['name'])) throw new \LogicException("not found or empty name");
    }

    private function prepareBrand(array $brand, Brand $entityBrand) :Brand
    {
        return $entityBrand->setName($brand['name']);
    }

    /**
     * @param array $brand
     * @return Brand|null
     */
    public function findBrand(array $brand):?Brand
    {
        if(!empty($brand['id'])) $brandEntity = $this->em->find(Brand::class, (int)$brand['id']);
        if(empty($brandEntity) && !empty($brand['name'])) $brandEntity = $this->em->getRepository(Brand::class)->findOneBy(['name' => $brand['name']]);
        return isset($brandEntity) && $brandEntity instanceof Brand ?  $brandEntity : null;
    }

    private function validateBrand(Brand $entityBrand) {
        return $this->validator->validate($entityBrand);
    }

    /**
     * @return bool
     */
    public function isClearEntityManager(): bool
    {
        return (bool)$this->clearEntityManager;
    }

    /**
     * @param bool $clearEntityManager
     */
    public function setClearEntityManager(bool $clearEntityManager): void
    {
        $this->clearEntityManager = $clearEntityManager;
    }
}