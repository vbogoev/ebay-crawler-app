<?php

namespace EbayCrawler\Model\Table\Factory;

use EbayCrawler\Model\Table\CountriesTable;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class CountriesTableFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $tableGateway = $container->get('EbayCrawler\Model\Table\CountriesTableGateway');

        return new CountriesTable($tableGateway);
    }
}
