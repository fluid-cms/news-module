ALTER TABLE `newsfeed_category` DROP `icon`;
DELETE FROM `core_setting` WHERE `variable` LIKE '%newsfeed%';