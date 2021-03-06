# Dump of table countries
# ------------------------------------------------------------

DROP TABLE IF EXISTS `countries`;
CREATE TABLE `countries` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `abbreviation` varchar(10) NOT NULL DEFAULT '',
    `name` varchar(255) NOT NULL DEFAULT '',
    `date_added` datetime NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

# Dump of table items
# ------------------------------------------------------------

DROP TABLE IF EXISTS `items`;

CREATE TABLE `items` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `country_id` int(11) unsigned NOT NULL,
    `keyword_id` int(11) unsigned NOT NULL,
    `external_id` bigint(20) NOT NULL,
    `title` varchar(255) NOT NULL DEFAULT '',
    `image` varchar(255) NOT NULL DEFAULT '',
    `link` varchar(255) NOT NULL DEFAULT '',
    `price` varchar(255) NOT NULL DEFAULT '',
    `shipping` varchar(255) NOT NULL DEFAULT '',
    `order` int(11) NOT NULL,
    `seen` tinyint(1) NOT NULL DEFAULT 0,
    `date_added` datetime NOT NULL,
    PRIMARY KEY (`id`),
    KEY `item_country` (`country_id`),
    KEY `item_keyword` (`keyword_id`),
    CONSTRAINT `item_country` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `item_keyword` FOREIGN KEY (`keyword_id`) REFERENCES `keywords` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

# Dump of table keywords
# ------------------------------------------------------------

DROP TABLE IF EXISTS `keywords`;

CREATE TABLE `keywords` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `date_added` datetime NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
