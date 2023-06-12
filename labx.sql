 -- DROP DATABASE IF NOT EXISTS `labx`;
 -- CREATE DATABASE IF NOT EXISTS `labx` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
 -- USE 'labx';
 
 DROP TABLE IF EXISTS `users`;
 CREATE TABLE `users` (
   `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT '1',
  `username` varchar(25) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL UNIQUE,
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `banned` tinyint(1)  DEFAULT '0',
  `ban_reason` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `newpass` varchar(34) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `newpass_key` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `newpass_time` datetime DEFAULT NULL,
  `last_ip` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin ,
  `last_login` datetime  DEFAULT '0000-00-00 00:00:00',
  `created` datetime  DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



 INSERT INTO `users` (`id`, `role_id`, `username`, `password`, `email`, `banned`, `ban_reason`, `newpass`, `newpass_key`, `newpass_time`, `last_ip`, `last_login`, `created`, `modified`) VALUES
 (1, 2, 'admin', '$2y$10$EF0ra.eaoMLxUvqxfyC8BOKlyHL8E9gg1k6cj/Zgu7/03hyQwSxjy', 'admin@localhost.com', 0, NULL, NULL, NULL, NULL, '37.212.31.11', '2023-03-14 12:39:00', '2008-11-30 04:56:32', '2023-03-14 09:39:00'),
 (2, 1, 'user', '$2y$10$EF0ra.eaoMLxUvqxfyC8BOKlyHL8E9gg1k6cj/Zgu7/03hyQwSxjy', 'admin@localhost.com', 0, NULL, NULL, NULL, NULL, '127.0.0.1', '2018-02-15 20:32:36', '2008-11-30 04:56:32', '2018-02-19 18:50:16');

 DROP TABLE IF EXISTS `instock`;
 CREATE TABLE IF NOT EXISTS `instock` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `model` char(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(8,2) DEFAULT NULL,
  `length_in` smallint(5) UNSIGNED DEFAULT NULL,
  `length_out` smallint(5) UNSIGNED DEFAULT NULL,
  `width_in` smallint(5) UNSIGNED DEFAULT NULL,
  `width_out` smallint(5) UNSIGNED DEFAULT NULL,
  `board_height` smallint(5) UNSIGNED DEFAULT NULL,
  `awning_height_tn` smallint(5) UNSIGNED DEFAULT NULL,
  `awning_height_fl` smallint(5) UNSIGNED DEFAULT NULL,
  `total_height` smallint(5) UNSIGNED DEFAULT NULL,
  `total_weight` smallint(5) UNSIGNED DEFAULT NULL,
  `self_weight` smallint(5) UNSIGNED DEFAULT NULL,
  `tires` bigint(20) UNSIGNED NOT NULL,
  `image` char(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_type` bigint(20) UNSIGNED NOT NULL,
  `color` bigint(20) UNSIGNED NOT NULL,
  `made` year(4) DEFAULT NULL,
  `win` char(17) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visibility` tinyint(1) DEFAULT '1',
  `viewnum` int(10) UNSIGNED DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `addinfo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `instock` (`id`, `model`, `price`, `length_in`, `length_out`, `width_in`, `width_out`, `board_height`, `awning_height_tn`, `awning_height_fl`, 
`total_height`, `total_weight`, `self_weight`, `tires`, `image`, `id_type`, `color`, `made`, `win`, `visibility`, `viewnum`, `user_id`, `modified`, `addinfo`) VALUES
(48, 'Rydwan Euro B3500/G6', '8200.00', 5060, 6500, 2100, 2150, 0, 0, 0, 650, 3500, 800, 1, 'IMG_4858.JPG', 9, 3, 2021, '', 1, 102, 1, '2022-05-06 05:02:19', ''),
(49, 'EURO B2600/3/G5 PLATFORMA', '4400.00', 4100, 4150, 1950, 2000, 0, 0, 0, 800, 2600, 570, 2, 'IMG_5069.JPG', 6, 1, 2022, '', 1, 68, 1, '2022-05-06 05:02:46', ''),
(50, 'Rydwan Euro B3500/G6', '9999.00', 8700, 9999, 2100, 2150, 0, 0, 0, 720, 3500, 999, 2, 'IMG_5232.JPG', 9, 1, 2022, '', 1, 45, 1, '2022-05-06 05:02:57', ''),
(51, 'EURO C750/L4', '3900.00', 4000, 4600, 1500, 1600, 350, 1400, 1700, 2350, 750, 460, 1, '09_11_2015_022.jpg', 2, 1, 2022, '', 1, 53, 1, '2022-05-06 05:05:53',
 'длина 4,0м,ширина-1,50м,высота под тентом-1,7м,резина R14C.\r\nОткрывается передний и задний борта, тент открывается на 4 стороны.\r\nУстановлены 2 оси Knott (Германия)'),
(52, 'EURO B2600/3/K6 PLATFORMA', '4600.00', 4600, 4650, 2050, 2100, 0, 0, 0, 800, 2600, 620, 2, '31_08_2014_002.jpg', 6, 1, 2022, '', 1, 51, 1, '2022-05-06 05:07:33', ''),
(53, 'EURO B2600/3/K6 PLATFORMA', '5250.00', 4600, 4650, 2050, 2100, 0, 0, 0, 800, 3000, 650, 2, '31_08_2014_002.jpg', 6, 3, 2022, '', 1, 42, 1, '2022-10-22 07:57:12', ''),
(54, 'EURO B2600/3/G8', '5700.00', 4000, 4060, 1950, 2000, 200, 0, 0, 0, 3000, 750, 2, '31_08_2014_006.jpg', 5, 1, 2022, '', NULL, 0, 1, '2022-06-01 09:58:17', ''),
(55, 'EURO B2600/0/E3', '4700.00', 3500, 3560, 1500, 1560, 350, 1400, 1700, 2350, 2600, 620, 2, '31_08_2014_77.jpg', 4, 3, 2022, '', 1, 23, 1, '2022-10-22 07:56:03', ''),
(56, 'EURO B2600/0/E3', '4700.00', 3500, 3560, 1500, 1560, 350, 1400, 1700, 2350, 2600, 620, 2, '31_08_2014_77.jpg', 4, 1, 2022, '', 1, 21, 1, '2022-10-22 07:59:02', '');
ALTER TABLE `users` ADD PRIMARY KEY (`id`);
ALTER TABLE `users` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;



