# script SQL à passer pour gérer la MAJ de la base (FIX gestion i18n)


# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

ALTER TABLE `se_media_file`
    ADD `name` VARCHAR(250) AFTER `category_id`;

ALTER TABLE `se_media_file_i18n`
    ADD `online` TINYINT(1) AFTER `copyright`;

ALTER TABLE `se_media_file_i18n` CHANGE `locale` `locale` VARCHAR(5) DEFAULT 'fr_FR' NOT NULL;

UPDATE `se_media_file_i18n` as i18n, `se_media_file` as base
SET base.name = i18n.name
WHERE i18n.id = base.id;


UPDATE `se_media_file_i18n` as i18n, `se_media_file` as base
SET i18n.online = base.online
WHERE i18n.id = base.id;

# /!\ non testé
UPDATE `se_media_file_i18n` as i18n
SET i18n.locale = 'fr_FR'
WHERE i18n.locale = 'fr';


ALTER TABLE `se_media_file_i18n` DROP `name`;

ALTER TABLE `se_media_file` DROP `online`;


# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
