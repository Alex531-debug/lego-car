<?php


namespace App\Filter;



use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\AbstractContextAwareFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use Doctrine\DBAL\Types\Type as DBALType;
use Doctrine\ORM\QueryBuilder;

class UniqueFilter extends AbstractContextAwareFilter
{
    use UniqueFilterTrait;

    public const DOCTRINE_BOOLEAN_TYPES = [
        DBALType::BOOLEAN => true,
    ];

    /**
     * {@inheritdoc}
     */
    protected function filterProperty(string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {
        if (
            !$this->isPropertyEnabled($property, $resourceClass) ||
            !$this->isPropertyMapped($property, $resourceClass)
        ) {
            return;
        }

        $value = $this->normalizeValue($value, $property);
        if (null === $value) {
            return;
        }

        $alias = $queryBuilder->getRootAliases()[0];
        $field = $property;

        if ($this->isPropertyNested($property, $resourceClass)) {
            [$alias, $field] = $this->addJoinsForNestedProperty($property, $alias, $queryBuilder, $queryNameGenerator, $resourceClass);
        }

        if(!!$value) {

            $queryBuilder
                ->select(sprintf('%s.%s', $alias, $field))
                ->addGroupBy(sprintf('%s.%s', $alias, $field))
                ->orderBy(sprintf('%s.%s', $alias, $field));
        }
    }
}