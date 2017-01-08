<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 *
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace WellCommerce\Bundle\ProducerBundle\DataSet\Front;

use Doctrine\ORM\QueryBuilder;
use WellCommerce\Bundle\ProducerBundle\DataSet\Admin\ProducerDataSet as BaseDataSet;
use WellCommerce\Bundle\ProducerBundle\Entity\Producer;
use WellCommerce\Bundle\ProducerBundle\Entity\ProducerTranslation;
use WellCommerce\Bundle\ProductBundle\Entity\Product;
use WellCommerce\Component\DataSet\Cache\CacheOptions;
use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;

/**
 * Class ProducerDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerDataSet extends BaseDataSet
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        $configurator->setColumns([
            'id'       => 'producer.id',
            'name'     => 'producer_translation.name',
            'route'    => 'IDENTITY(producer_translation.route)',
            'shop'     => 'producer_shops.id',
            'products' => 'COUNT(producer_products.id)',
        ]);
        
        $configurator->setColumnTransformers([
            'route' => $this->manager->createTransformer('route'),
        ]);
        
        $configurator->setCacheOptions(new CacheOptions(true, 3600, [
            Product::class,
            Producer::class,
            ProducerTranslation::class,
        ]));
    }
    
    protected function createQueryBuilder(): QueryBuilder
    {
        $queryBuilder = $this->repository->getQueryBuilder();
        $queryBuilder->groupBy('producer.id');
        $queryBuilder->leftJoin('producer.translations', 'producer_translation');
        $queryBuilder->leftJoin('producer.products', 'producer_products');
        $queryBuilder->leftJoin('producer.shops', 'producer_shops');
        $queryBuilder->where($queryBuilder->expr()->eq('producer_shops.id', $this->getShopStorage()->getCurrentShopIdentifier()));
        
        return $queryBuilder;
    }
}
