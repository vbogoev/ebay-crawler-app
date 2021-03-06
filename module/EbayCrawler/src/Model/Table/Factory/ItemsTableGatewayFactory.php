<?php

namespace EbayCrawler\Model\Table\Factory;

use EbayCrawler\Model\Item;
use Interop\Container\ContainerInterface;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Hydrator\ArraySerializableHydrator;
use Laminas\ServiceManager\Factory\FactoryInterface;
use EbayCrawler\Model\Table\ItemsTable;


class ItemsTableGatewayFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $dbAdapter = $container->get('Laminas\Db\Adapter\Adapter');
        $hydrator = new ArraySerializableHydrator();
        $rowObjectPrototype = new Item();
        $resultSet = new HydratingResultSet($hydrator, $rowObjectPrototype);

        return new TableGateway(ItemsTable::TABLE_NAME, $dbAdapter, null, $resultSet);
    }
}
