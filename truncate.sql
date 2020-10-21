ALTER TABLE `car_make` ADD PRIMARY KEY(`id`);
ALTER TABLE `car_make` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `car_year` ADD PRIMARY KEY(`id`);
ALTER TABLE `car_year` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;

-- START COMPANY CREATE
CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `company_id` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `is_sync` enum('0','1') NOT NULL DEFAULT '0',
  `logo` varchar(1000) DEFAULT NULL,
  `is_active` enum('0','1') NOT NULL DEFAULT '1',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--END COMPANY CREATE

ALTER TABLE `vehicle_info` ADD `company_id` INT NULL AFTER `vehicle_id`;