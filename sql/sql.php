<?php
$table[]="
CREATE TABLE IF NOT EXISTS `wtc_compress` (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `provider` int(2) NOT NULL DEFAULT '1',
  `file_name` varchar(255) NOT NULL,
  `original_size` varchar(50) NOT NULL,
  `crank_size` varchar(50) NOT NULL,
  `ratio` varchar(50) NOT NULL,
  `status` varchar(255) NOT NULL,
  `json_resp` text NOT NULL,
  `date_created` varchar(50) NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
