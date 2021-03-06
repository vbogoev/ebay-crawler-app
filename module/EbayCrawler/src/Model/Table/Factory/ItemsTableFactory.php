<?php

namespace EbayCrawler\Model\Table\Factory;

use EbayCrawler\Model\Table\ItemsTable;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class ItemsTableFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $tableGateway = $container->get('EbayCrawler\Model\Table\ItemsTableGateway');

        return new ItemsTable($tableGateway);
    }
}
