<?php

namespace EbayCrawler\Model\Table\Factory;

use EbayCrawler\Model\Country;
use EbayCrawler\Model\Table\CountriesTable;
use Interop\Container\ContainerInterface;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Hydrator\ArraySerializableHydrator;
use Laminas\ServiceManager\Factory\FactoryInterface;


class CountriesTableGatewayFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $dbAdapter = $container->get('Laminas\Db\Adapter\Adapter');
        $hydrator = new ArraySerializableHydrator();
        $rowObjectPrototype = new Country();
        $resultSet = new HydratingResultSet($hydrator, $rowObjectPrototype);

        return new TableGateway(CountriesTable::TABLE_NAME, $dbAdapter, null, $resultSet);
    }
}
