<?php

namespace EbayCrawler;

use EbayCrawler\Model\Table\CountriesTable;
use EbayCrawler\Model\Table\Factory\CountriesTableFactory;
use EbayCrawler\Model\Table\Factory\CountriesTableGatewayFactory;
use EbayCrawler\Model\Table\Factory\ItemsTableFactory;
use EbayCrawler\Model\Table\Factory\ItemsTableGatewayFactory;
use EbayCrawler\Model\Table\Factory\KeywordsTableFactory;
use EbayCrawler\Model\Table\Factory\KeywordsTableGatewayFactory;
use EbayCrawler\Model\Table\ItemsTable;
use EbayCrawler\Model\Table\KeywordsTable;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'service_manager' => [
        'factories' => [
            ItemsTable::class => ItemsTableFactory::class,
            'EbayCrawler\Model\Table\ItemsTableGateway' => ItemsTableGatewayFactory::class,
            CountriesTable::class => CountriesTableFactory::class,
            'EbayCrawler\Model\Table\CountriesTableGateway' => CountriesTableGatewayFactory::class,
            KeywordsTable::class => KeywordsTableFactory::class,
            'EbayCrawler\Model\Table\KeywordsTableGateway' => KeywordsTableGatewayFactory::class,

            EbayCrawler::class => InvokableFactory::class
        ],
    ],
];
