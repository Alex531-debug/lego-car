<?php

namespace App\Factory;

use App\Entity\Brand;
use App\Repository\BrandRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static Brand|Proxy createOne(array $attributes = [])
 * @method static Brand[]|Proxy[] createMany(int $number, $attributes = [])
 * @method static Brand|Proxy findOrCreate(array $attributes)
 * @method static Brand|Proxy random(array $attributes = [])
 * @method static Brand|Proxy randomOrCreate(array $attributes = [])
 * @method static Brand[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Brand[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static BrandRepository|RepositoryProxy repository()
 * @method Brand|Proxy create($attributes = [])
 */
final class BrandFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getDefaults(): array
    {
        return [
            'name' => self::faker()->name()
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->afterInstantiate(function(Brand $brand) {})
        ;
    }

    protected static function getClass(): string
    {
        return Brand::class;
    }
}
