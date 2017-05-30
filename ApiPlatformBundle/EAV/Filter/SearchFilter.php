<?php

namespace CleverAge\EAVManager\ApiPlatformBundle\EAV\Filter;

use ApiPlatform\Core\Exception\InvalidArgumentException;
use Doctrine\ORM\QueryBuilder;
use Sidus\EAVModelBundle\Doctrine\EAVQueryBuilder;
use Sidus\EAVModelBundle\Model\AttributeInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter as BaseSearchFilter;

/**
 * Filter the collection by given properties.
 */
class SearchFilter extends AbstractEAVFilter
{
    /**
     * Passes a property through the filter.
     *
     * @param QueryBuilder       $queryBuilder
     * @param AttributeInterface $attribute
     * @param mixed              $value
     * @param null               $strategy
     * @param string|null        $operationName
     *
     * @throws \ApiPlatform\Core\Exception\InvalidArgumentException
     */
    protected function filterAttribute(
        QueryBuilder $queryBuilder,
        AttributeInterface $attribute,
        $value,
        $strategy = null,
        string $operationName = null
    ) {
        switch ($strategy) {
            case null:
            case BaseSearchFilter::STRATEGY_EXACT:
                $value = trim($value, '%');
                break;
            case BaseSearchFilter::STRATEGY_PARTIAL:
                $value = '%'.trim($value, '%').'%';
                break;
            case BaseSearchFilter::STRATEGY_START:
                $value = trim($value, '%').'%';
                break;
            case BaseSearchFilter::STRATEGY_END:
                $value = '%'.trim($value, '%');
                break;
            case BaseSearchFilter::STRATEGY_WORD_START:
                $value = '%'.trim($value, '%').'%'; // No, we are not going to implement this
                break;
            default:
                throw new InvalidArgumentException("strategy {$strategy} does not exist.");
        }

        $eavQb = new EAVQueryBuilder($queryBuilder, 'o');
        $eavQb->apply($eavQb->attribute($attribute)->like($value));
    }
}