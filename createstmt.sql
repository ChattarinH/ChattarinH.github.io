CREATE TABLE `courses` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `subject` varchar(16) NOT NULL,
  `title` varchar(256) NOT NULL,
  `price` float unsigned NOT NULL,
  `hour` int(3) unsigned NOT NULL,
  `lecturer` varchar(32) NOT NULL,
  `description` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4;