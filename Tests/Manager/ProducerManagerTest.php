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

namespace WellCommerce\Bundle\ProducerBundle\Tests\Manager;

use WellCommerce\Bundle\CoreBundle\Test\Manager\AbstractManagerTestCase;
use WellCommerce\Bundle\DoctrineBundle\Manager\ManagerInterface;

/**
 * Class ProducerManagerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerManagerTest extends AbstractManagerTestCase
{
    protected function get() : ManagerInterface
    {
        return $this->container->get('producer.manager');
    }
}
