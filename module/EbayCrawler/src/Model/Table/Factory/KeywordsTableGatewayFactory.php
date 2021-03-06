<?php

namespace EbayCrawler\Model\Table\Factory;

use EbayCrawler\Model\Keyword;
use Interop\Container\ContainerInterface;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Hydrator\ArraySerializableHydrator;
use Laminas\ServiceManager\Factory\FactoryInterface;
use EbayCrawler\Model\Table\KeywordsTable;


class KeywordsTableGatewayFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $dbAdapter = $container->get('Laminas\Db\Adapter\Adapter');
        $hydrator = new ArraySerializableHydrator();
        $rowObjectPrototype = new Keyword();
        $resultSet = new HydratingResultSet($hydrator, $rowObjectPrototype);

        return new TableGateway(KeywordsTable::TABLE_NAME, $dbAdapter, null, $resultSet);
    }
}
