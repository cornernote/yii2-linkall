/**
 * MySQL
 */

DROP TABLE IF EXISTS `post`;

CREATE TABLE `post` (
  `id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `body` TEXT NOT NULL
);

DROP TABLE IF EXISTS `tag`;

CREATE TABLE `tag` (
  `id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL
);

DROP TABLE IF EXISTS `post_to_tag`;

CREATE TABLE `post_to_tag` (
  `post_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`post_id`,`tag_id`)
);

