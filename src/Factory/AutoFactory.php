<?php

namespace App\Factory;

use App\Entity\Auto;
use App\Entity\Brand;
use App\Repository\AutoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static Auto|Proxy createOne(array $attributes = [])
 * @method static Auto[]|Proxy[] createMany(int $number, $attributes = [])
 * @method static Auto|Proxy findOrCreate(array $attributes)
 * @method static Auto|Proxy random(array $attributes = [])
 * @method static Auto|Proxy randomOrCreate(array $attributes = [])
 * @method static Auto[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Auto[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static AutoRepository|RepositoryProxy repository()
 * @method Auto|Proxy create($attributes = [])
 */
final class AutoFactory extends ModelFactory
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

        return [
            'name' => self::faker()->name(),
            'status' => self::faker()->randomElement(['available', 'on_order']),
            'model' => self::faker()->name(),
            'price' => self::faker()->randomFloat(2, 100000, 2000000),
            'brand' => self::faker()->randomElement($brands),
            'vin' => mb_substr(md5(uniqid()), 0, 17)
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
        return Auto::class;
    }
}
