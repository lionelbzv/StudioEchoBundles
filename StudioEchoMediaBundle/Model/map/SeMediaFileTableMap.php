<?php

namespace StudioEchoBundles\StudioEchoMediaBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'se_media_file' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.src.StudioEchoBundles.StudioEchoMediaBundle.Model.map
 */
class SeMediaFileTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.StudioEchoBundles.StudioEchoMediaBundle.Model.map.SeMediaFileTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('se_media_file');
        $this->setPhpName('SeMediaFile');
        $this->setClassname('StudioEchoBundles\\StudioEchoMediaBundle\\Model\\SeMediaFile');
        $this->setPackage('src.StudioEchoBundles.StudioEchoMediaBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('category_id', 'CategoryId', 'INTEGER', true, null, 1);
        $this->addColumn('name', 'Name', 'VARCHAR', false, 250, null);
        $this->addColumn('extension', 'Extension', 'VARCHAR', false, 10, null);
        $this->addColumn('type', 'Type', 'VARCHAR', false, 250, null);
        $this->addColumn('mime_type', 'MimeType', 'VARCHAR', false, 250, null);
        $this->addColumn('size', 'Size', 'INTEGER', false, null, null);
        $this->addColumn('height', 'Height', 'INTEGER', false, null, null);
        $this->addColumn('width', 'Width', 'INTEGER', false, null, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('ActivityDocLib', 'MontcalmAventure\\Model\\ActivityDocLib', RelationMap::ONE_TO_MANY, array('id' => 'se_media_file_id', ), 'CASCADE', 'CASCADE', 'ActivityDocLibs');
        $this->addRelation('ActivitySubDocLib', 'MontcalmAventure\\Model\\ActivitySubDocLib', RelationMap::ONE_TO_MANY, array('id' => 'se_media_file_id', ), 'CASCADE', 'CASCADE', 'ActivitySubDocLibs');
        $this->addRelation('ActivityInsertDocLib', 'MontcalmAventure\\Model\\ActivityInsertDocLib', RelationMap::ONE_TO_MANY, array('id' => 'se_media_file_id', ), 'CASCADE', 'CASCADE', 'ActivityInsertDocLibs');
        $this->addRelation('ContentProfileDocLib', 'MontcalmAventure\\Model\\ContentProfileDocLib', RelationMap::ONE_TO_MANY, array('id' => 'se_media_file_id', ), 'CASCADE', 'CASCADE', 'ContentProfileDocLibs');
        $this->addRelation('ContentWishDocLib', 'MontcalmAventure\\Model\\ContentWishDocLib', RelationMap::ONE_TO_MANY, array('id' => 'se_media_file_id', ), 'CASCADE', 'CASCADE', 'ContentWishDocLibs');
        $this->addRelation('ContentNewsDocLib', 'MontcalmAventure\\Model\\ContentNewsDocLib', RelationMap::ONE_TO_MANY, array('id' => 'se_media_file_id', ), 'CASCADE', 'CASCADE', 'ContentNewsDocLibs');
        $this->addRelation('ContentGenericDocLib', 'MontcalmAventure\\Model\\ContentGenericDocLib', RelationMap::ONE_TO_MANY, array('id' => 'se_media_file_id', ), 'CASCADE', 'CASCADE', 'ContentGenericDocLibs');
        $this->addRelation('ContentOfferDocLib', 'MontcalmAventure\\Model\\ContentOfferDocLib', RelationMap::ONE_TO_MANY, array('id' => 'se_media_file_id', ), 'CASCADE', 'CASCADE', 'ContentOfferDocLibs');
        $this->addRelation('ContentStayDocLib', 'MontcalmAventure\\Model\\ContentStayDocLib', RelationMap::ONE_TO_MANY, array('id' => 'se_media_file_id', ), 'CASCADE', 'CASCADE', 'ContentStayDocLibs');
        $this->addRelation('SeObjectHasFile', 'StudioEchoBundles\\StudioEchoMediaBundle\\Model\\SeObjectHasFile', RelationMap::ONE_TO_MANY, array('id' => 'se_media_file_id', ), 'CASCADE', 'CASCADE', 'SeObjectHasFiles');
        $this->addRelation('SeMediaFileI18n', 'StudioEchoBundles\\StudioEchoMediaBundle\\Model\\SeMediaFileI18n', RelationMap::ONE_TO_MANY, array('id' => 'id', ), 'CASCADE', null, 'SeMediaFileI18ns');
        $this->addRelation('Activity', 'MontcalmAventure\\Model\\Activity', RelationMap::MANY_TO_MANY, array(), 'CASCADE', 'CASCADE', 'Activities');
        $this->addRelation('ActivitySub', 'MontcalmAventure\\Model\\ActivitySub', RelationMap::MANY_TO_MANY, array(), 'CASCADE', 'CASCADE', 'ActivitySubs');
        $this->addRelation('ActivityInsert', 'MontcalmAventure\\Model\\ActivityInsert', RelationMap::MANY_TO_MANY, array(), 'CASCADE', 'CASCADE', 'ActivityInserts');
        $this->addRelation('ContentProfile', 'MontcalmAventure\\Model\\ContentProfile', RelationMap::MANY_TO_MANY, array(), 'CASCADE', 'CASCADE', 'ContentProfiles');
        $this->addRelation('ContentWish', 'MontcalmAventure\\Model\\ContentWish', RelationMap::MANY_TO_MANY, array(), 'CASCADE', 'CASCADE', 'ContentWishes');
        $this->addRelation('ContentNews', 'MontcalmAventure\\Model\\ContentNews', RelationMap::MANY_TO_MANY, array(), 'CASCADE', 'CASCADE', 'ContentNewss');
        $this->addRelation('ContentGeneric', 'MontcalmAventure\\Model\\ContentGeneric', RelationMap::MANY_TO_MANY, array(), 'CASCADE', 'CASCADE', 'ContentGenerics');
        $this->addRelation('ContentOffer', 'MontcalmAventure\\Model\\ContentOffer', RelationMap::MANY_TO_MANY, array(), 'CASCADE', 'CASCADE', 'ContentOffers');
        $this->addRelation('ContentStay', 'MontcalmAventure\\Model\\ContentStay', RelationMap::MANY_TO_MANY, array(), 'CASCADE', 'CASCADE', 'ContentStays');
        $this->addRelation('SeMediaObject', 'StudioEchoBundles\\StudioEchoMediaBundle\\Model\\SeMediaObject', RelationMap::MANY_TO_MANY, array(), 'CASCADE', 'CASCADE', 'SeMediaObjects');
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'i18n' =>  array (
  'i18n_table' => '%TABLE%_i18n',
  'i18n_phpname' => '%PHPNAME%I18n',
  'i18n_columns' => 'title, description, copyright, online',
  'i18n_pk_name' => NULL,
  'locale_column' => 'locale',
  'default_locale' => 'fr_FR',
  'locale_alias' => '',
),
            'timestampable' =>  array (
  'create_column' => 'created_at',
  'update_column' => 'updated_at',
  'disable_updated_at' => 'false',
),
            'event' =>  array (
),
            'extend' =>  array (
),
        );
    } // getBehaviors()

} // SeMediaFileTableMap
