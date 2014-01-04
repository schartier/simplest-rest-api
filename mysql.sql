/*Table structure for table `friends` */
DROP TABLE IF EXISTS `friends`;

CREATE TABLE `friends` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `profession` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
);

/*Data for the table `containerelement` */
INSERT INTO `friends` VALUES (1, 'Veronique', 'Teacher');
INSERT INTO `friends` VALUES (2, 'Marcel', 'Janitor');
INSERT INTO `friends` VALUES (3, 'Bob', 'Hockey player');
INSERT INTO `friends` VALUES (4, 'Julie', 'Mom');
