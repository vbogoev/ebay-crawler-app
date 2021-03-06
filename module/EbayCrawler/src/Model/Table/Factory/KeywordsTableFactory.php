<?php

namespace EbayCrawler\Model\Table\Factory;

use EbayCrawler\Model\Table\KeywordsTable;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class KeywordsTableFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $tableGateway = $container->get('EbayCrawler\Model\Table\KeywordsTableGateway');

        return new KeywordsTable($tableGateway);
    }
}
