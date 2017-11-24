DROP TABLE IF EXISTS `newsfeed_article`;
DROP TABLE IF EXISTS `newsfeed_category`;

CREATE TABLE IF NOT EXISTS `newsfeed_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_czech_ci NOT NULL,
  `icon` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

CREATE TABLE IF NOT EXISTS `newsfeed_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `perex` text COLLATE utf8_czech_ci NOT NULL,
  `content` text COLLATE utf8_czech_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `category_id` int(11) DEFAULT NULL,
  `important` int(1) DEFAULT '0',
  `public` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

ALTER TABLE `newsfeed_article`
  ADD CONSTRAINT `newsfeed_article_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `newsfeed_category` (`id`) ON DELETE SET NULL;