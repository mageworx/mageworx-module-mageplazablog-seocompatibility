<?php
/**
 * Copyright © MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MageWorx\MageplazaBlogSeoCompatibility\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use MageWorx\MageplazaBlogSeoCompatibility\Model\Generator;

/**
 * Class AddBlogPages
 *
 */
class AddBlogPagesObserver implements ObserverInterface
{
    /**
     * @var Generator
     */
    protected $generator;

    /**
     * AddBlogPagesObserver constructor.
     *
     * @param Generator $generator
     */
    public function __construct(
        Generator $generator
    ) {
        $this->generator = $generator;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $storeId = $observer->getData('storeId');
        if (!$storeId) {
            return;
        }

        $excludeMetaRobots = $this->getExcludeMetaRobots($observer);
        $container         = $observer->getEvent()->getContainer();
        $generators        = $container->getGenerators();
        $generators        = array_merge($generators, $this->generator->generate($storeId, $excludeMetaRobots));

        $container->setGenerators($generators);
    }

    /**
     * @param Observer $observer
     * @return array
     */
    protected function getExcludeMetaRobots($observer)
    {
        $metaRobots = $observer->getData('exclude_meta_robots');
        $metaRobots = is_array($metaRobots) ? $metaRobots : [$metaRobots];

        foreach ($metaRobots as $key => $item) {
            $metaRobots[$key] = str_replace(' ', '', strtoupper($item));
        }

        return $metaRobots;
    }
}