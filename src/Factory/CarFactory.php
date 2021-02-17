<?php

namespace App\Factory;

use App\Entity\Car;
use App\Entity\Brand;
use App\Entity\Image;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static Car|Proxy createOne(array $attributes = [])
 * @method static Car[]|Proxy[] createMany(int $number, $attributes = [])
 * @method static Car|Proxy findOrCreate(array $attributes)
 * @method static Car|Proxy random(array $attributes = [])
 * @method static Car|Proxy randomOrCreate(array $attributes = [])
 * @method static Car[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Car[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static CarRepository|RepositoryProxy repository()
 * @method Car|Proxy create($attributes = [])
 */
final class CarFactory extends ModelFactory
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function getDefaults(): array
    {
        $brandRepository = $this->em->getRepository(Brand::class);

        $brands = $brandRepository->findAll();

        $image = new Image();
        $image->setImage('test.png');
        return [
            'name' => self::faker()->name(),
            'status' => self::faker()->randomElement(['available', 'on_order']),
            'model' => self::faker()->name(),
            'price' => self::faker()->randomFloat(2, 100000, 2000000),
            'brand' => self::faker()->randomElement($brands),
            'vin' => mb_substr(md5(uniqid()), 0, 17),
            'images' => [$image]
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->afterInstantiate(function(Auto $auto) {})
        ;
    }

    protected static function getClass(): string
    {
        return Car::class;
    }
}
