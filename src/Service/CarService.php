<?php


namespace App\Service;


use App\Entity\Brand;
use App\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CarService
{
    private $em;
    private $validator;
    private $brandService;

    /**
     * Очищать ли делать ли EntityManager->clear(Car::class) после вставки
     * @var bool
     */
    private $clearEntityManager = false;

    public function __construct(EntityManagerInterface $em, ValidatorInterface $validator, BrandService $brandService)
    {
        $this->em = $em;
        $this->validator = $validator;
        $this->brandService = $brandService;
    }

    /**
     * Загрузка одного автомобиля
     * @param array $car
     * @param bool|null $clearEntityManager
     */
    public function create(array $car, ?bool $clearEntityManager = null)
    {
        if($clearEntityManager !== null) $this->setClearEntityManager($clearEntityManager);

        $this->addCar($car);
        $this->em->flush();
        $this->clearEntityManager();
    }

    /**
     * Загрузка нескольких автомобилей автомобиля
     * @param array $cars массив автомобилей
     * @param bool|null $clearEntityManager
     */
    public function createChunk(array $cars, ?bool $clearEntityManager = null)
    {
        if($clearEntityManager !== null) $this->setClearEntityManager($clearEntityManager);

        foreach ($cars as $car) {
            $this->addCar($car);
        }
        $this->em->flush();
        $this->clearEntityManager();
    }

    public function clearEntityManager() {
        if($this->isClearEntityManager()) {
            $this->em->clear(Car::class);
        }
    }

    private function addCar(array $car) {
        $this->validateArrayData($car);
        $brand = $this->brandService->findBrand($car['brand']);

        $entityCar = $this->getEntityCar($car);

        if(!$brand) {
            $this->brandService->create($car['brand']);
            $brand = $this->brandService->findBrand($car['brand']);
        }

        $car['brand'] = $brand;

        $entityCar = $this->prepareCar($car, $entityCar);
        $this->validateCar($entityCar);
        $this->em->persist($entityCar);
    }

    private function getEntityCar(array $car)
    {
        $entityCar = $this->findCar($car);
        if(!$entityCar) $entityCar = new Car();
        return $entityCar;
    }

    /**
     * Провяем правильность заполнения данных об автомобиле в json файле
     * @param array $car данных об автомобиле в массиве
     */
    private function validateArrayData(array $car):void
    {

        if(empty($car['name'])) throw new \LogicException("not found or empty name");
        if(empty($car['vin'])) throw new \LogicException("not found or empty vin");
        if(empty($car['price'])) throw new \LogicException("not found or empty price");
        if(empty($car['model'])) throw new \LogicException("not found or empty model");
        if(empty($car['status'])) throw new \LogicException("not found or empty status");

        // используем in_array так как может быть всего два значения status, если их будет много рациональние изменить на поиск по ключам, для приближения к константному времени
        if(!in_array($car['status'], Car::STATUS_VALUES)) throw new \LogicException("invalid value status");

        if(empty($car['brand'])) throw new \LogicException("not found or empty brand");
        if(empty($car['brand']['name'])) throw new \LogicException("not found or empty name brand");

    }

    /**
     * @param array $car @param array $car данных об автомобиле в массиве
     * @param Car $entityCar
     * @return Car
     */
    private function prepareCar(array $car, Car $entityCar) :Car
    {

        $entityCar->setName($car['name']);
        $entityCar->setModel($car['model']);
        $entityCar->setVin($car['vin']);
        $entityCar->setPrice($car['price']);
        $entityCar->setStatus($car['status']);
        $entityCar->setBrand($car['brand']);

        return $entityCar;
    }

    private function findCar(array $car):?Car
    {
        if(!empty($car['id'])) $carEntity = $this->em->find(Car::class, (int)$car['id']);
        if(empty($carEntity) && !empty($car['vin'])) $carEntity = $this->em->getRepository(Car::class)->findOneBy(['vin' => $car['vin']]);
        return isset($carEntity) && $carEntity instanceof Car ? $carEntity : null;
    }

    private function validateCar(Car $car)
    {
        return $this->validator->validate($car);
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