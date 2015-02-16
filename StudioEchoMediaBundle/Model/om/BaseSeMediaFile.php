<?php

namespace StudioEchoBundles\StudioEchoMediaBundle\Model\om;

use \BaseObject;
use \BasePeer;
use \Criteria;
use \DateTime;
use \Exception;
use \PDO;
use \Persistent;
use \Propel;
use \PropelCollection;
use \PropelDateTime;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Glorpen\Propel\PropelBundle\Dispatcher\EventDispatcherProxy;
use Glorpen\Propel\PropelBundle\Events\ModelEvent;
use MontcalmAventure\Model\Activity;
use MontcalmAventure\Model\ActivityDocLib;
use MontcalmAventure\Model\ActivityDocLibQuery;
use MontcalmAventure\Model\ActivityInsert;
use MontcalmAventure\Model\ActivityInsertDocLib;
use MontcalmAventure\Model\ActivityInsertDocLibQuery;
use MontcalmAventure\Model\ActivityInsertQuery;
use MontcalmAventure\Model\ActivityQuery;
use MontcalmAventure\Model\ActivitySub;
use MontcalmAventure\Model\ActivitySubDocLib;
use MontcalmAventure\Model\ActivitySubDocLibQuery;
use MontcalmAventure\Model\ActivitySubQuery;
use MontcalmAventure\Model\ContentGeneric;
use MontcalmAventure\Model\ContentGenericDocLib;
use MontcalmAventure\Model\ContentGenericDocLibQuery;
use MontcalmAventure\Model\ContentGenericQuery;
use MontcalmAventure\Model\ContentNews;
use MontcalmAventure\Model\ContentNewsDocLib;
use MontcalmAventure\Model\ContentNewsDocLibQuery;
use MontcalmAventure\Model\ContentNewsQuery;
use MontcalmAventure\Model\ContentOffer;
use MontcalmAventure\Model\ContentOfferDocLib;
use MontcalmAventure\Model\ContentOfferDocLibQuery;
use MontcalmAventure\Model\ContentOfferQuery;
use MontcalmAventure\Model\ContentProfile;
use MontcalmAventure\Model\ContentProfileDocLib;
use MontcalmAventure\Model\ContentProfileDocLibQuery;
use MontcalmAventure\Model\ContentProfileQuery;
use MontcalmAventure\Model\ContentStay;
use MontcalmAventure\Model\ContentStayDocLib;
use MontcalmAventure\Model\ContentStayDocLibQuery;
use MontcalmAventure\Model\ContentStayQuery;
use MontcalmAventure\Model\ContentWish;
use MontcalmAventure\Model\ContentWishDocLib;
use MontcalmAventure\Model\ContentWishDocLibQuery;
use MontcalmAventure\Model\ContentWishQuery;
use StudioEchoBundles\StudioEchoMediaBundle\Model\SeMediaFile;
use StudioEchoBundles\StudioEchoMediaBundle\Model\SeMediaFileI18n;
use StudioEchoBundles\StudioEchoMediaBundle\Model\SeMediaFileI18nQuery;
use StudioEchoBundles\StudioEchoMediaBundle\Model\SeMediaFilePeer;
use StudioEchoBundles\StudioEchoMediaBundle\Model\SeMediaFileQuery;
use StudioEchoBundles\StudioEchoMediaBundle\Model\SeMediaObject;
use StudioEchoBundles\StudioEchoMediaBundle\Model\SeMediaObjectQuery;
use StudioEchoBundles\StudioEchoMediaBundle\Model\SeObjectHasFile;
use StudioEchoBundles\StudioEchoMediaBundle\Model\SeObjectHasFileQuery;

abstract class BaseSeMediaFile extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'StudioEchoBundles\\StudioEchoMediaBundle\\Model\\SeMediaFilePeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        SeMediaFilePeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the category_id field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $category_id;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the extension field.
     * @var        string
     */
    protected $extension;

    /**
     * The value for the type field.
     * @var        string
     */
    protected $type;

    /**
     * The value for the mime_type field.
     * @var        string
     */
    protected $mime_type;

    /**
     * The value for the size field.
     * @var        int
     */
    protected $size;

    /**
     * The value for the height field.
     * @var        int
     */
    protected $height;

    /**
     * The value for the width field.
     * @var        int
     */
    protected $width;

    /**
     * The value for the created_at field.
     * @var        string
     */
    protected $created_at;

    /**
     * The value for the updated_at field.
     * @var        string
     */
    protected $updated_at;

    /**
     * @var        PropelObjectCollection|ActivityDocLib[] Collection to store aggregation of ActivityDocLib objects.
     */
    protected $collActivityDocLibs;
    protected $collActivityDocLibsPartial;

    /**
     * @var        PropelObjectCollection|ActivitySubDocLib[] Collection to store aggregation of ActivitySubDocLib objects.
     */
    protected $collActivitySubDocLibs;
    protected $collActivitySubDocLibsPartial;

    /**
     * @var        PropelObjectCollection|ActivityInsertDocLib[] Collection to store aggregation of ActivityInsertDocLib objects.
     */
    protected $collActivityInsertDocLibs;
    protected $collActivityInsertDocLibsPartial;

    /**
     * @var        PropelObjectCollection|ContentProfileDocLib[] Collection to store aggregation of ContentProfileDocLib objects.
     */
    protected $collContentProfileDocLibs;
    protected $collContentProfileDocLibsPartial;

    /**
     * @var        PropelObjectCollection|ContentWishDocLib[] Collection to store aggregation of ContentWishDocLib objects.
     */
    protected $collContentWishDocLibs;
    protected $collContentWishDocLibsPartial;

    /**
     * @var        PropelObjectCollection|ContentNewsDocLib[] Collection to store aggregation of ContentNewsDocLib objects.
     */
    protected $collContentNewsDocLibs;
    protected $collContentNewsDocLibsPartial;

    /**
     * @var        PropelObjectCollection|ContentGenericDocLib[] Collection to store aggregation of ContentGenericDocLib objects.
     */
    protected $collContentGenericDocLibs;
    protected $collContentGenericDocLibsPartial;

    /**
     * @var        PropelObjectCollection|ContentOfferDocLib[] Collection to store aggregation of ContentOfferDocLib objects.
     */
    protected $collContentOfferDocLibs;
    protected $collContentOfferDocLibsPartial;

    /**
     * @var        PropelObjectCollection|ContentStayDocLib[] Collection to store aggregation of ContentStayDocLib objects.
     */
    protected $collContentStayDocLibs;
    protected $collContentStayDocLibsPartial;

    /**
     * @var        PropelObjectCollection|SeObjectHasFile[] Collection to store aggregation of SeObjectHasFile objects.
     */
    protected $collSeObjectHasFiles;
    protected $collSeObjectHasFilesPartial;

    /**
     * @var        PropelObjectCollection|SeMediaFileI18n[] Collection to store aggregation of SeMediaFileI18n objects.
     */
    protected $collSeMediaFileI18ns;
    protected $collSeMediaFileI18nsPartial;

    /**
     * @var        PropelObjectCollection|Activity[] Collection to store aggregation of Activity objects.
     */
    protected $collActivities;

    /**
     * @var        PropelObjectCollection|ActivitySub[] Collection to store aggregation of ActivitySub objects.
     */
    protected $collActivitySubs;

    /**
     * @var        PropelObjectCollection|ActivityInsert[] Collection to store aggregation of ActivityInsert objects.
     */
    protected $collActivityInserts;

    /**
     * @var        PropelObjectCollection|ContentProfile[] Collection to store aggregation of ContentProfile objects.
     */
    protected $collContentProfiles;

    /**
     * @var        PropelObjectCollection|ContentWish[] Collection to store aggregation of ContentWish objects.
     */
    protected $collContentWishes;

    /**
     * @var        PropelObjectCollection|ContentNews[] Collection to store aggregation of ContentNews objects.
     */
    protected $collContentNewss;

    /**
     * @var        PropelObjectCollection|ContentGeneric[] Collection to store aggregation of ContentGeneric objects.
     */
    protected $collContentGenerics;

    /**
     * @var        PropelObjectCollection|ContentOffer[] Collection to store aggregation of ContentOffer objects.
     */
    protected $collContentOffers;

    /**
     * @var        PropelObjectCollection|ContentStay[] Collection to store aggregation of ContentStay objects.
     */
    protected $collContentStays;

    /**
     * @var        PropelObjectCollection|SeMediaObject[] Collection to store aggregation of SeMediaObject objects.
     */
    protected $collSeMediaObjects;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInSave = false;

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInValidation = false;

    /**
     * Flag to prevent endless clearAllReferences($deep=true) loop, if this object is referenced
     * @var        boolean
     */
    protected $alreadyInClearAllReferencesDeep = false;

    // i18n behavior

    /**
     * Current locale
     * @var        string
     */
    protected $currentLocale = 'fr_FR';

    /**
     * Current translation objects
     * @var        array[SeMediaFileI18n]
     */
    protected $currentTranslations;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $activitiesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $activitySubsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $activityInsertsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $contentProfilesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $contentWishesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $contentNewssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $contentGenericsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $contentOffersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $contentStaysScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $seMediaObjectsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $activityDocLibsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $activitySubDocLibsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $activityInsertDocLibsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $contentProfileDocLibsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $contentWishDocLibsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $contentNewsDocLibsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $contentGenericDocLibsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $contentOfferDocLibsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $contentStayDocLibsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $seObjectHasFilesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $seMediaFileI18nsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
        $this->category_id = 1;
    }

    /**
     * Initializes internal state of BaseSeMediaFile object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
        EventDispatcherProxy::trigger(array('construct','model.construct'), new ModelEvent($this));
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [category_id] column value.
     *
     * @return int
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [extension] column value.
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Get the [type] column value.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get the [mime_type] column value.
     *
     * @return string
     */
    public function getMimeType()
    {
        return $this->mime_type;
    }

    /**
     * Get the [size] column value.
     *
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Get the [height] column value.
     *
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Get the [width] column value.
     *
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Get the [optionally formatted] temporal [created_at] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreatedAt($format = null)
    {
        if ($this->created_at === null) {
            return null;
        }

        if ($this->created_at === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->created_at);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->created_at, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [optionally formatted] temporal [updated_at] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getUpdatedAt($format = null)
    {
        if ($this->updated_at === null) {
            return null;
        }

        if ($this->updated_at === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->updated_at);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->updated_at, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = SeMediaFilePeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [category_id] column.
     *
     * @param int $v new value
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function setCategoryId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->category_id !== $v) {
            $this->category_id = $v;
            $this->modifiedColumns[] = SeMediaFilePeer::CATEGORY_ID;
        }


        return $this;
    } // setCategoryId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = SeMediaFilePeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [extension] column.
     *
     * @param string $v new value
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function setExtension($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->extension !== $v) {
            $this->extension = $v;
            $this->modifiedColumns[] = SeMediaFilePeer::EXTENSION;
        }


        return $this;
    } // setExtension()

    /**
     * Set the value of [type] column.
     *
     * @param string $v new value
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function setType($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->type !== $v) {
            $this->type = $v;
            $this->modifiedColumns[] = SeMediaFilePeer::TYPE;
        }


        return $this;
    } // setType()

    /**
     * Set the value of [mime_type] column.
     *
     * @param string $v new value
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function setMimeType($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->mime_type !== $v) {
            $this->mime_type = $v;
            $this->modifiedColumns[] = SeMediaFilePeer::MIME_TYPE;
        }


        return $this;
    } // setMimeType()

    /**
     * Set the value of [size] column.
     *
     * @param int $v new value
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function setSize($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->size !== $v) {
            $this->size = $v;
            $this->modifiedColumns[] = SeMediaFilePeer::SIZE;
        }


        return $this;
    } // setSize()

    /**
     * Set the value of [height] column.
     *
     * @param int $v new value
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function setHeight($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->height !== $v) {
            $this->height = $v;
            $this->modifiedColumns[] = SeMediaFilePeer::HEIGHT;
        }


        return $this;
    } // setHeight()

    /**
     * Set the value of [width] column.
     *
     * @param int $v new value
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function setWidth($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->width !== $v) {
            $this->width = $v;
            $this->modifiedColumns[] = SeMediaFilePeer::WIDTH;
        }


        return $this;
    } // setWidth()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            $currentDateAsString = ($this->created_at !== null && $tmpDt = new DateTime($this->created_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->created_at = $newDateAsString;
                $this->modifiedColumns[] = SeMediaFilePeer::CREATED_AT;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            $currentDateAsString = ($this->updated_at !== null && $tmpDt = new DateTime($this->updated_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->updated_at = $newDateAsString;
                $this->modifiedColumns[] = SeMediaFilePeer::UPDATED_AT;
            }
        } // if either are not null


        return $this;
    } // setUpdatedAt()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->category_id !== 1) {
                return false;
            }

        // otherwise, everything was equal, so return true
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
     * @param int $startcol 0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false)
    {
        try {

            $this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->category_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->name = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->extension = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->type = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->mime_type = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->size = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
            $this->height = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
            $this->width = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
            $this->created_at = ($row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
            $this->updated_at = ($row[$startcol + 10] !== null) ? (string) $row[$startcol + 10] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 11; // 11 = SeMediaFilePeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating SeMediaFile object", $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {

    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param boolean $deep (optional) Whether to also de-associated any related objects.
     * @param PropelPDO $con (optional) The PropelPDO connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getConnection(SeMediaFilePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = SeMediaFilePeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collActivityDocLibs = null;

            $this->collActivitySubDocLibs = null;

            $this->collActivityInsertDocLibs = null;

            $this->collContentProfileDocLibs = null;

            $this->collContentWishDocLibs = null;

            $this->collContentNewsDocLibs = null;

            $this->collContentGenericDocLibs = null;

            $this->collContentOfferDocLibs = null;

            $this->collContentStayDocLibs = null;

            $this->collSeObjectHasFiles = null;

            $this->collSeMediaFileI18ns = null;

            $this->collActivities = null;
            $this->collActivitySubs = null;
            $this->collActivityInserts = null;
            $this->collContentProfiles = null;
            $this->collContentWishes = null;
            $this->collContentNewss = null;
            $this->collContentGenerics = null;
            $this->collContentOffers = null;
            $this->collContentStays = null;
            $this->collSeMediaObjects = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param PropelPDO $con
     * @return void
     * @throws PropelException
     * @throws Exception
     * @see        BaseObject::setDeleted()
     * @see        BaseObject::isDeleted()
     */
    public function delete(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(SeMediaFilePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            EventDispatcherProxy::trigger(array('delete.pre','model.delete.pre'), new ModelEvent($this));
            $deleteQuery = SeMediaFileQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                // event behavior
                EventDispatcherProxy::trigger(array('delete.post', 'model.delete.post'), new ModelEvent($this));
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @throws Exception
     * @see        doSave()
     */
    public function save(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(SeMediaFilePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            // event behavior
            EventDispatcherProxy::trigger('model.save.pre', new ModelEvent($this));
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                if (!$this->isColumnModified(SeMediaFilePeer::CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(SeMediaFilePeer::UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
                // event behavior
                EventDispatcherProxy::trigger('model.insert.pre', new ModelEvent($this));
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(SeMediaFilePeer::UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
                // event behavior
                EventDispatcherProxy::trigger(array('update.pre', 'model.update.pre'), new ModelEvent($this));
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                    // event behavior
                    EventDispatcherProxy::trigger('model.insert.post', new ModelEvent($this));
                } else {
                    $this->postUpdate($con);
                    // event behavior
                    EventDispatcherProxy::trigger(array('update.post', 'model.update.post'), new ModelEvent($this));
                }
                $this->postSave($con);
                // event behavior
                EventDispatcherProxy::trigger('model.save.post', new ModelEvent($this));
                SeMediaFilePeer::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see        save()
     */
    protected function doSave(PropelPDO $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->activitiesScheduledForDeletion !== null) {
                if (!$this->activitiesScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    $pk = $this->getPrimaryKey();
                    foreach ($this->activitiesScheduledForDeletion->getPrimaryKeys(false) as $remotePk) {
                        $pks[] = array($remotePk, $pk);
                    }
                    ActivityDocLibQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);
                    $this->activitiesScheduledForDeletion = null;
                }

                foreach ($this->getActivities() as $activity) {
                    if ($activity->isModified()) {
                        $activity->save($con);
                    }
                }
            } elseif ($this->collActivities) {
                foreach ($this->collActivities as $activity) {
                    if ($activity->isModified()) {
                        $activity->save($con);
                    }
                }
            }

            if ($this->activitySubsScheduledForDeletion !== null) {
                if (!$this->activitySubsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    $pk = $this->getPrimaryKey();
                    foreach ($this->activitySubsScheduledForDeletion->getPrimaryKeys(false) as $remotePk) {
                        $pks[] = array($remotePk, $pk);
                    }
                    ActivitySubDocLibQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);
                    $this->activitySubsScheduledForDeletion = null;
                }

                foreach ($this->getActivitySubs() as $activitySub) {
                    if ($activitySub->isModified()) {
                        $activitySub->save($con);
                    }
                }
            } elseif ($this->collActivitySubs) {
                foreach ($this->collActivitySubs as $activitySub) {
                    if ($activitySub->isModified()) {
                        $activitySub->save($con);
                    }
                }
            }

            if ($this->activityInsertsScheduledForDeletion !== null) {
                if (!$this->activityInsertsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    $pk = $this->getPrimaryKey();
                    foreach ($this->activityInsertsScheduledForDeletion->getPrimaryKeys(false) as $remotePk) {
                        $pks[] = array($remotePk, $pk);
                    }
                    ActivityInsertDocLibQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);
                    $this->activityInsertsScheduledForDeletion = null;
                }

                foreach ($this->getActivityInserts() as $activityInsert) {
                    if ($activityInsert->isModified()) {
                        $activityInsert->save($con);
                    }
                }
            } elseif ($this->collActivityInserts) {
                foreach ($this->collActivityInserts as $activityInsert) {
                    if ($activityInsert->isModified()) {
                        $activityInsert->save($con);
                    }
                }
            }

            if ($this->contentProfilesScheduledForDeletion !== null) {
                if (!$this->contentProfilesScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    $pk = $this->getPrimaryKey();
                    foreach ($this->contentProfilesScheduledForDeletion->getPrimaryKeys(false) as $remotePk) {
                        $pks[] = array($remotePk, $pk);
                    }
                    ContentProfileDocLibQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);
                    $this->contentProfilesScheduledForDeletion = null;
                }

                foreach ($this->getContentProfiles() as $contentProfile) {
                    if ($contentProfile->isModified()) {
                        $contentProfile->save($con);
                    }
                }
            } elseif ($this->collContentProfiles) {
                foreach ($this->collContentProfiles as $contentProfile) {
                    if ($contentProfile->isModified()) {
                        $contentProfile->save($con);
                    }
                }
            }

            if ($this->contentWishesScheduledForDeletion !== null) {
                if (!$this->contentWishesScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    $pk = $this->getPrimaryKey();
                    foreach ($this->contentWishesScheduledForDeletion->getPrimaryKeys(false) as $remotePk) {
                        $pks[] = array($remotePk, $pk);
                    }
                    ContentWishDocLibQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);
                    $this->contentWishesScheduledForDeletion = null;
                }

                foreach ($this->getContentWishes() as $contentWish) {
                    if ($contentWish->isModified()) {
                        $contentWish->save($con);
                    }
                }
            } elseif ($this->collContentWishes) {
                foreach ($this->collContentWishes as $contentWish) {
                    if ($contentWish->isModified()) {
                        $contentWish->save($con);
                    }
                }
            }

            if ($this->contentNewssScheduledForDeletion !== null) {
                if (!$this->contentNewssScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    $pk = $this->getPrimaryKey();
                    foreach ($this->contentNewssScheduledForDeletion->getPrimaryKeys(false) as $remotePk) {
                        $pks[] = array($remotePk, $pk);
                    }
                    ContentNewsDocLibQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);
                    $this->contentNewssScheduledForDeletion = null;
                }

                foreach ($this->getContentNewss() as $contentNews) {
                    if ($contentNews->isModified()) {
                        $contentNews->save($con);
                    }
                }
            } elseif ($this->collContentNewss) {
                foreach ($this->collContentNewss as $contentNews) {
                    if ($contentNews->isModified()) {
                        $contentNews->save($con);
                    }
                }
            }

            if ($this->contentGenericsScheduledForDeletion !== null) {
                if (!$this->contentGenericsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    $pk = $this->getPrimaryKey();
                    foreach ($this->contentGenericsScheduledForDeletion->getPrimaryKeys(false) as $remotePk) {
                        $pks[] = array($remotePk, $pk);
                    }
                    ContentGenericDocLibQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);
                    $this->contentGenericsScheduledForDeletion = null;
                }

                foreach ($this->getContentGenerics() as $contentGeneric) {
                    if ($contentGeneric->isModified()) {
                        $contentGeneric->save($con);
                    }
                }
            } elseif ($this->collContentGenerics) {
                foreach ($this->collContentGenerics as $contentGeneric) {
                    if ($contentGeneric->isModified()) {
                        $contentGeneric->save($con);
                    }
                }
            }

            if ($this->contentOffersScheduledForDeletion !== null) {
                if (!$this->contentOffersScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    $pk = $this->getPrimaryKey();
                    foreach ($this->contentOffersScheduledForDeletion->getPrimaryKeys(false) as $remotePk) {
                        $pks[] = array($remotePk, $pk);
                    }
                    ContentOfferDocLibQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);
                    $this->contentOffersScheduledForDeletion = null;
                }

                foreach ($this->getContentOffers() as $contentOffer) {
                    if ($contentOffer->isModified()) {
                        $contentOffer->save($con);
                    }
                }
            } elseif ($this->collContentOffers) {
                foreach ($this->collContentOffers as $contentOffer) {
                    if ($contentOffer->isModified()) {
                        $contentOffer->save($con);
                    }
                }
            }

            if ($this->contentStaysScheduledForDeletion !== null) {
                if (!$this->contentStaysScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    $pk = $this->getPrimaryKey();
                    foreach ($this->contentStaysScheduledForDeletion->getPrimaryKeys(false) as $remotePk) {
                        $pks[] = array($remotePk, $pk);
                    }
                    ContentStayDocLibQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);
                    $this->contentStaysScheduledForDeletion = null;
                }

                foreach ($this->getContentStays() as $contentStay) {
                    if ($contentStay->isModified()) {
                        $contentStay->save($con);
                    }
                }
            } elseif ($this->collContentStays) {
                foreach ($this->collContentStays as $contentStay) {
                    if ($contentStay->isModified()) {
                        $contentStay->save($con);
                    }
                }
            }

            if ($this->seMediaObjectsScheduledForDeletion !== null) {
                if (!$this->seMediaObjectsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    $pk = $this->getPrimaryKey();
                    foreach ($this->seMediaObjectsScheduledForDeletion->getPrimaryKeys(false) as $remotePk) {
                        $pks[] = array($remotePk, $pk);
                    }
                    SeObjectHasFileQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);
                    $this->seMediaObjectsScheduledForDeletion = null;
                }

                foreach ($this->getSeMediaObjects() as $seMediaObject) {
                    if ($seMediaObject->isModified()) {
                        $seMediaObject->save($con);
                    }
                }
            } elseif ($this->collSeMediaObjects) {
                foreach ($this->collSeMediaObjects as $seMediaObject) {
                    if ($seMediaObject->isModified()) {
                        $seMediaObject->save($con);
                    }
                }
            }

            if ($this->activityDocLibsScheduledForDeletion !== null) {
                if (!$this->activityDocLibsScheduledForDeletion->isEmpty()) {
                    ActivityDocLibQuery::create()
                        ->filterByPrimaryKeys($this->activityDocLibsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->activityDocLibsScheduledForDeletion = null;
                }
            }

            if ($this->collActivityDocLibs !== null) {
                foreach ($this->collActivityDocLibs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->activitySubDocLibsScheduledForDeletion !== null) {
                if (!$this->activitySubDocLibsScheduledForDeletion->isEmpty()) {
                    ActivitySubDocLibQuery::create()
                        ->filterByPrimaryKeys($this->activitySubDocLibsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->activitySubDocLibsScheduledForDeletion = null;
                }
            }

            if ($this->collActivitySubDocLibs !== null) {
                foreach ($this->collActivitySubDocLibs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->activityInsertDocLibsScheduledForDeletion !== null) {
                if (!$this->activityInsertDocLibsScheduledForDeletion->isEmpty()) {
                    ActivityInsertDocLibQuery::create()
                        ->filterByPrimaryKeys($this->activityInsertDocLibsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->activityInsertDocLibsScheduledForDeletion = null;
                }
            }

            if ($this->collActivityInsertDocLibs !== null) {
                foreach ($this->collActivityInsertDocLibs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->contentProfileDocLibsScheduledForDeletion !== null) {
                if (!$this->contentProfileDocLibsScheduledForDeletion->isEmpty()) {
                    ContentProfileDocLibQuery::create()
                        ->filterByPrimaryKeys($this->contentProfileDocLibsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->contentProfileDocLibsScheduledForDeletion = null;
                }
            }

            if ($this->collContentProfileDocLibs !== null) {
                foreach ($this->collContentProfileDocLibs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->contentWishDocLibsScheduledForDeletion !== null) {
                if (!$this->contentWishDocLibsScheduledForDeletion->isEmpty()) {
                    ContentWishDocLibQuery::create()
                        ->filterByPrimaryKeys($this->contentWishDocLibsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->contentWishDocLibsScheduledForDeletion = null;
                }
            }

            if ($this->collContentWishDocLibs !== null) {
                foreach ($this->collContentWishDocLibs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->contentNewsDocLibsScheduledForDeletion !== null) {
                if (!$this->contentNewsDocLibsScheduledForDeletion->isEmpty()) {
                    ContentNewsDocLibQuery::create()
                        ->filterByPrimaryKeys($this->contentNewsDocLibsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->contentNewsDocLibsScheduledForDeletion = null;
                }
            }

            if ($this->collContentNewsDocLibs !== null) {
                foreach ($this->collContentNewsDocLibs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->contentGenericDocLibsScheduledForDeletion !== null) {
                if (!$this->contentGenericDocLibsScheduledForDeletion->isEmpty()) {
                    ContentGenericDocLibQuery::create()
                        ->filterByPrimaryKeys($this->contentGenericDocLibsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->contentGenericDocLibsScheduledForDeletion = null;
                }
            }

            if ($this->collContentGenericDocLibs !== null) {
                foreach ($this->collContentGenericDocLibs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->contentOfferDocLibsScheduledForDeletion !== null) {
                if (!$this->contentOfferDocLibsScheduledForDeletion->isEmpty()) {
                    ContentOfferDocLibQuery::create()
                        ->filterByPrimaryKeys($this->contentOfferDocLibsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->contentOfferDocLibsScheduledForDeletion = null;
                }
            }

            if ($this->collContentOfferDocLibs !== null) {
                foreach ($this->collContentOfferDocLibs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->contentStayDocLibsScheduledForDeletion !== null) {
                if (!$this->contentStayDocLibsScheduledForDeletion->isEmpty()) {
                    ContentStayDocLibQuery::create()
                        ->filterByPrimaryKeys($this->contentStayDocLibsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->contentStayDocLibsScheduledForDeletion = null;
                }
            }

            if ($this->collContentStayDocLibs !== null) {
                foreach ($this->collContentStayDocLibs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->seObjectHasFilesScheduledForDeletion !== null) {
                if (!$this->seObjectHasFilesScheduledForDeletion->isEmpty()) {
                    SeObjectHasFileQuery::create()
                        ->filterByPrimaryKeys($this->seObjectHasFilesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->seObjectHasFilesScheduledForDeletion = null;
                }
            }

            if ($this->collSeObjectHasFiles !== null) {
                foreach ($this->collSeObjectHasFiles as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->seMediaFileI18nsScheduledForDeletion !== null) {
                if (!$this->seMediaFileI18nsScheduledForDeletion->isEmpty()) {
                    SeMediaFileI18nQuery::create()
                        ->filterByPrimaryKeys($this->seMediaFileI18nsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->seMediaFileI18nsScheduledForDeletion = null;
                }
            }

            if ($this->collSeMediaFileI18ns !== null) {
                foreach ($this->collSeMediaFileI18ns as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param PropelPDO $con
     *
     * @throws PropelException
     * @see        doSave()
     */
    protected function doInsert(PropelPDO $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[] = SeMediaFilePeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . SeMediaFilePeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(SeMediaFilePeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(SeMediaFilePeer::CATEGORY_ID)) {
            $modifiedColumns[':p' . $index++]  = '`category_id`';
        }
        if ($this->isColumnModified(SeMediaFilePeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(SeMediaFilePeer::EXTENSION)) {
            $modifiedColumns[':p' . $index++]  = '`extension`';
        }
        if ($this->isColumnModified(SeMediaFilePeer::TYPE)) {
            $modifiedColumns[':p' . $index++]  = '`type`';
        }
        if ($this->isColumnModified(SeMediaFilePeer::MIME_TYPE)) {
            $modifiedColumns[':p' . $index++]  = '`mime_type`';
        }
        if ($this->isColumnModified(SeMediaFilePeer::SIZE)) {
            $modifiedColumns[':p' . $index++]  = '`size`';
        }
        if ($this->isColumnModified(SeMediaFilePeer::HEIGHT)) {
            $modifiedColumns[':p' . $index++]  = '`height`';
        }
        if ($this->isColumnModified(SeMediaFilePeer::WIDTH)) {
            $modifiedColumns[':p' . $index++]  = '`width`';
        }
        if ($this->isColumnModified(SeMediaFilePeer::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`created_at`';
        }
        if ($this->isColumnModified(SeMediaFilePeer::UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`updated_at`';
        }

        $sql = sprintf(
            'INSERT INTO `se_media_file` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id`':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case '`category_id`':
                        $stmt->bindValue($identifier, $this->category_id, PDO::PARAM_INT);
                        break;
                    case '`name`':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '`extension`':
                        $stmt->bindValue($identifier, $this->extension, PDO::PARAM_STR);
                        break;
                    case '`type`':
                        $stmt->bindValue($identifier, $this->type, PDO::PARAM_STR);
                        break;
                    case '`mime_type`':
                        $stmt->bindValue($identifier, $this->mime_type, PDO::PARAM_STR);
                        break;
                    case '`size`':
                        $stmt->bindValue($identifier, $this->size, PDO::PARAM_INT);
                        break;
                    case '`height`':
                        $stmt->bindValue($identifier, $this->height, PDO::PARAM_INT);
                        break;
                    case '`width`':
                        $stmt->bindValue($identifier, $this->width, PDO::PARAM_INT);
                        break;
                    case '`created_at`':
                        $stmt->bindValue($identifier, $this->created_at, PDO::PARAM_STR);
                        break;
                    case '`updated_at`':
                        $stmt->bindValue($identifier, $this->updated_at, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param PropelPDO $con
     *
     * @see        doSave()
     */
    protected function doUpdate(PropelPDO $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();
        BasePeer::doUpdate($selectCriteria, $valuesCriteria, $con);
    }

    /**
     * Array of ValidationFailed objects.
     * @var        array ValidationFailed[]
     */
    protected $validationFailures = array();

    /**
     * Gets any ValidationFailed objects that resulted from last call to validate().
     *
     *
     * @return array ValidationFailed[]
     * @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
    }

    /**
     * Validates the objects modified field values and all objects related to this table.
     *
     * If $columns is either a column name or an array of column names
     * only those columns are validated.
     *
     * @param mixed $columns Column name or an array of column names.
     * @return boolean Whether all columns pass validation.
     * @see        doValidate()
     * @see        getValidationFailures()
     */
    public function validate($columns = null)
    {
        $res = $this->doValidate($columns);
        if ($res === true) {
            $this->validationFailures = array();

            return true;
        }

        $this->validationFailures = $res;

        return false;
    }

    /**
     * This function performs the validation work for complex object models.
     *
     * In addition to checking the current object, all related objects will
     * also be validated.  If all pass then <code>true</code> is returned; otherwise
     * an aggreagated array of ValidationFailed objects will be returned.
     *
     * @param array $columns Array of column names to validate.
     * @return mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
     */
    protected function doValidate($columns = null)
    {
        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;

            $failureMap = array();


            if (($retval = SeMediaFilePeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collActivityDocLibs !== null) {
                    foreach ($this->collActivityDocLibs as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collActivitySubDocLibs !== null) {
                    foreach ($this->collActivitySubDocLibs as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collActivityInsertDocLibs !== null) {
                    foreach ($this->collActivityInsertDocLibs as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collContentProfileDocLibs !== null) {
                    foreach ($this->collContentProfileDocLibs as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collContentWishDocLibs !== null) {
                    foreach ($this->collContentWishDocLibs as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collContentNewsDocLibs !== null) {
                    foreach ($this->collContentNewsDocLibs as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collContentGenericDocLibs !== null) {
                    foreach ($this->collContentGenericDocLibs as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collContentOfferDocLibs !== null) {
                    foreach ($this->collContentOfferDocLibs as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collContentStayDocLibs !== null) {
                    foreach ($this->collContentStayDocLibs as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collSeObjectHasFiles !== null) {
                    foreach ($this->collSeObjectHasFiles as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collSeMediaFileI18ns !== null) {
                    foreach ($this->collSeMediaFileI18ns as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }


            $this->alreadyInValidation = false;
        }

        return (!empty($failureMap) ? $failureMap : true);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *               one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *               BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *               Defaults to BasePeer::TYPE_PHPNAME
     * @return mixed Value of field.
     */
    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = SeMediaFilePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getCategoryId();
                break;
            case 2:
                return $this->getName();
                break;
            case 3:
                return $this->getExtension();
                break;
            case 4:
                return $this->getType();
                break;
            case 5:
                return $this->getMimeType();
                break;
            case 6:
                return $this->getSize();
                break;
            case 7:
                return $this->getHeight();
                break;
            case 8:
                return $this->getWidth();
                break;
            case 9:
                return $this->getCreatedAt();
                break;
            case 10:
                return $this->getUpdatedAt();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     *                    BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                    Defaults to BasePeer::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to true.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['SeMediaFile'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['SeMediaFile'][$this->getPrimaryKey()] = true;
        $keys = SeMediaFilePeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getCategoryId(),
            $keys[2] => $this->getName(),
            $keys[3] => $this->getExtension(),
            $keys[4] => $this->getType(),
            $keys[5] => $this->getMimeType(),
            $keys[6] => $this->getSize(),
            $keys[7] => $this->getHeight(),
            $keys[8] => $this->getWidth(),
            $keys[9] => $this->getCreatedAt(),
            $keys[10] => $this->getUpdatedAt(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->collActivityDocLibs) {
                $result['ActivityDocLibs'] = $this->collActivityDocLibs->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collActivitySubDocLibs) {
                $result['ActivitySubDocLibs'] = $this->collActivitySubDocLibs->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collActivityInsertDocLibs) {
                $result['ActivityInsertDocLibs'] = $this->collActivityInsertDocLibs->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collContentProfileDocLibs) {
                $result['ContentProfileDocLibs'] = $this->collContentProfileDocLibs->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collContentWishDocLibs) {
                $result['ContentWishDocLibs'] = $this->collContentWishDocLibs->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collContentNewsDocLibs) {
                $result['ContentNewsDocLibs'] = $this->collContentNewsDocLibs->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collContentGenericDocLibs) {
                $result['ContentGenericDocLibs'] = $this->collContentGenericDocLibs->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collContentOfferDocLibs) {
                $result['ContentOfferDocLibs'] = $this->collContentOfferDocLibs->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collContentStayDocLibs) {
                $result['ContentStayDocLibs'] = $this->collContentStayDocLibs->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSeObjectHasFiles) {
                $result['SeObjectHasFiles'] = $this->collSeObjectHasFiles->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSeMediaFileI18ns) {
                $result['SeMediaFileI18ns'] = $this->collSeMediaFileI18ns->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name peer name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                     Defaults to BasePeer::TYPE_PHPNAME
     * @return void
     */
    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = SeMediaFilePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setCategoryId($value);
                break;
            case 2:
                $this->setName($value);
                break;
            case 3:
                $this->setExtension($value);
                break;
            case 4:
                $this->setType($value);
                break;
            case 5:
                $this->setMimeType($value);
                break;
            case 6:
                $this->setSize($value);
                break;
            case 7:
                $this->setHeight($value);
                break;
            case 8:
                $this->setWidth($value);
                break;
            case 9:
                $this->setCreatedAt($value);
                break;
            case 10:
                $this->setUpdatedAt($value);
                break;
        } // switch()
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     * The default key type is the column's BasePeer::TYPE_PHPNAME
     *
     * @param array  $arr     An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = SeMediaFilePeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setCategoryId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setName($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setExtension($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setType($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setMimeType($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setSize($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setHeight($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setWidth($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setCreatedAt($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setUpdatedAt($arr[$keys[10]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(SeMediaFilePeer::DATABASE_NAME);

        if ($this->isColumnModified(SeMediaFilePeer::ID)) $criteria->add(SeMediaFilePeer::ID, $this->id);
        if ($this->isColumnModified(SeMediaFilePeer::CATEGORY_ID)) $criteria->add(SeMediaFilePeer::CATEGORY_ID, $this->category_id);
        if ($this->isColumnModified(SeMediaFilePeer::NAME)) $criteria->add(SeMediaFilePeer::NAME, $this->name);
        if ($this->isColumnModified(SeMediaFilePeer::EXTENSION)) $criteria->add(SeMediaFilePeer::EXTENSION, $this->extension);
        if ($this->isColumnModified(SeMediaFilePeer::TYPE)) $criteria->add(SeMediaFilePeer::TYPE, $this->type);
        if ($this->isColumnModified(SeMediaFilePeer::MIME_TYPE)) $criteria->add(SeMediaFilePeer::MIME_TYPE, $this->mime_type);
        if ($this->isColumnModified(SeMediaFilePeer::SIZE)) $criteria->add(SeMediaFilePeer::SIZE, $this->size);
        if ($this->isColumnModified(SeMediaFilePeer::HEIGHT)) $criteria->add(SeMediaFilePeer::HEIGHT, $this->height);
        if ($this->isColumnModified(SeMediaFilePeer::WIDTH)) $criteria->add(SeMediaFilePeer::WIDTH, $this->width);
        if ($this->isColumnModified(SeMediaFilePeer::CREATED_AT)) $criteria->add(SeMediaFilePeer::CREATED_AT, $this->created_at);
        if ($this->isColumnModified(SeMediaFilePeer::UPDATED_AT)) $criteria->add(SeMediaFilePeer::UPDATED_AT, $this->updated_at);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(SeMediaFilePeer::DATABASE_NAME);
        $criteria->add(SeMediaFilePeer::ID, $this->id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of SeMediaFile (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setCategoryId($this->getCategoryId());
        $copyObj->setName($this->getName());
        $copyObj->setExtension($this->getExtension());
        $copyObj->setType($this->getType());
        $copyObj->setMimeType($this->getMimeType());
        $copyObj->setSize($this->getSize());
        $copyObj->setHeight($this->getHeight());
        $copyObj->setWidth($this->getWidth());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getActivityDocLibs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addActivityDocLib($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getActivitySubDocLibs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addActivitySubDocLib($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getActivityInsertDocLibs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addActivityInsertDocLib($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getContentProfileDocLibs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addContentProfileDocLib($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getContentWishDocLibs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addContentWishDocLib($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getContentNewsDocLibs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addContentNewsDocLib($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getContentGenericDocLibs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addContentGenericDocLib($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getContentOfferDocLibs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addContentOfferDocLib($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getContentStayDocLibs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addContentStayDocLib($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSeObjectHasFiles() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSeObjectHasFile($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSeMediaFileI18ns() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSeMediaFileI18n($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return SeMediaFile Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Returns a peer instance associated with this om.
     *
     * Since Peer classes are not to have any instance attributes, this method returns the
     * same instance for all member of this class. The method could therefore
     * be static, but this would prevent one from overriding the behavior.
     *
     * @return SeMediaFilePeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new SeMediaFilePeer();
        }

        return self::$peer;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('ActivityDocLib' == $relationName) {
            $this->initActivityDocLibs();
        }
        if ('ActivitySubDocLib' == $relationName) {
            $this->initActivitySubDocLibs();
        }
        if ('ActivityInsertDocLib' == $relationName) {
            $this->initActivityInsertDocLibs();
        }
        if ('ContentProfileDocLib' == $relationName) {
            $this->initContentProfileDocLibs();
        }
        if ('ContentWishDocLib' == $relationName) {
            $this->initContentWishDocLibs();
        }
        if ('ContentNewsDocLib' == $relationName) {
            $this->initContentNewsDocLibs();
        }
        if ('ContentGenericDocLib' == $relationName) {
            $this->initContentGenericDocLibs();
        }
        if ('ContentOfferDocLib' == $relationName) {
            $this->initContentOfferDocLibs();
        }
        if ('ContentStayDocLib' == $relationName) {
            $this->initContentStayDocLibs();
        }
        if ('SeObjectHasFile' == $relationName) {
            $this->initSeObjectHasFiles();
        }
        if ('SeMediaFileI18n' == $relationName) {
            $this->initSeMediaFileI18ns();
        }
    }

    /**
     * Clears out the collActivityDocLibs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return SeMediaFile The current object (for fluent API support)
     * @see        addActivityDocLibs()
     */
    public function clearActivityDocLibs()
    {
        $this->collActivityDocLibs = null; // important to set this to null since that means it is uninitialized
        $this->collActivityDocLibsPartial = null;

        return $this;
    }

    /**
     * reset is the collActivityDocLibs collection loaded partially
     *
     * @return void
     */
    public function resetPartialActivityDocLibs($v = true)
    {
        $this->collActivityDocLibsPartial = $v;
    }

    /**
     * Initializes the collActivityDocLibs collection.
     *
     * By default this just sets the collActivityDocLibs collection to an empty array (like clearcollActivityDocLibs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initActivityDocLibs($overrideExisting = true)
    {
        if (null !== $this->collActivityDocLibs && !$overrideExisting) {
            return;
        }
        $this->collActivityDocLibs = new PropelObjectCollection();
        $this->collActivityDocLibs->setModel('ActivityDocLib');
    }

    /**
     * Gets an array of ActivityDocLib objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this SeMediaFile is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|ActivityDocLib[] List of ActivityDocLib objects
     * @throws PropelException
     */
    public function getActivityDocLibs($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collActivityDocLibsPartial && !$this->isNew();
        if (null === $this->collActivityDocLibs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collActivityDocLibs) {
                // return empty collection
                $this->initActivityDocLibs();
            } else {
                $collActivityDocLibs = ActivityDocLibQuery::create(null, $criteria)
                    ->filterBySeMediaFile($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collActivityDocLibsPartial && count($collActivityDocLibs)) {
                      $this->initActivityDocLibs(false);

                      foreach($collActivityDocLibs as $obj) {
                        if (false == $this->collActivityDocLibs->contains($obj)) {
                          $this->collActivityDocLibs->append($obj);
                        }
                      }

                      $this->collActivityDocLibsPartial = true;
                    }

                    $collActivityDocLibs->getInternalIterator()->rewind();
                    return $collActivityDocLibs;
                }

                if($partial && $this->collActivityDocLibs) {
                    foreach($this->collActivityDocLibs as $obj) {
                        if($obj->isNew()) {
                            $collActivityDocLibs[] = $obj;
                        }
                    }
                }

                $this->collActivityDocLibs = $collActivityDocLibs;
                $this->collActivityDocLibsPartial = false;
            }
        }

        return $this->collActivityDocLibs;
    }

    /**
     * Sets a collection of ActivityDocLib objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $activityDocLibs A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function setActivityDocLibs(PropelCollection $activityDocLibs, PropelPDO $con = null)
    {
        $activityDocLibsToDelete = $this->getActivityDocLibs(new Criteria(), $con)->diff($activityDocLibs);

        $this->activityDocLibsScheduledForDeletion = unserialize(serialize($activityDocLibsToDelete));

        foreach ($activityDocLibsToDelete as $activityDocLibRemoved) {
            $activityDocLibRemoved->setSeMediaFile(null);
        }

        $this->collActivityDocLibs = null;
        foreach ($activityDocLibs as $activityDocLib) {
            $this->addActivityDocLib($activityDocLib);
        }

        $this->collActivityDocLibs = $activityDocLibs;
        $this->collActivityDocLibsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ActivityDocLib objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related ActivityDocLib objects.
     * @throws PropelException
     */
    public function countActivityDocLibs(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collActivityDocLibsPartial && !$this->isNew();
        if (null === $this->collActivityDocLibs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collActivityDocLibs) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getActivityDocLibs());
            }
            $query = ActivityDocLibQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySeMediaFile($this)
                ->count($con);
        }

        return count($this->collActivityDocLibs);
    }

    /**
     * Method called to associate a ActivityDocLib object to this object
     * through the ActivityDocLib foreign key attribute.
     *
     * @param    ActivityDocLib $l ActivityDocLib
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function addActivityDocLib(ActivityDocLib $l)
    {
        if ($this->collActivityDocLibs === null) {
            $this->initActivityDocLibs();
            $this->collActivityDocLibsPartial = true;
        }
        if (!in_array($l, $this->collActivityDocLibs->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddActivityDocLib($l);
        }

        return $this;
    }

    /**
     * @param	ActivityDocLib $activityDocLib The activityDocLib object to add.
     */
    protected function doAddActivityDocLib($activityDocLib)
    {
        $this->collActivityDocLibs[]= $activityDocLib;
        $activityDocLib->setSeMediaFile($this);
    }

    /**
     * @param	ActivityDocLib $activityDocLib The activityDocLib object to remove.
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function removeActivityDocLib($activityDocLib)
    {
        if ($this->getActivityDocLibs()->contains($activityDocLib)) {
            $this->collActivityDocLibs->remove($this->collActivityDocLibs->search($activityDocLib));
            if (null === $this->activityDocLibsScheduledForDeletion) {
                $this->activityDocLibsScheduledForDeletion = clone $this->collActivityDocLibs;
                $this->activityDocLibsScheduledForDeletion->clear();
            }
            $this->activityDocLibsScheduledForDeletion[]= clone $activityDocLib;
            $activityDocLib->setSeMediaFile(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SeMediaFile is new, it will return
     * an empty collection; or if this SeMediaFile has previously
     * been saved, it will retrieve related ActivityDocLibs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SeMediaFile.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ActivityDocLib[] List of ActivityDocLib objects
     */
    public function getActivityDocLibsJoinActivity($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ActivityDocLibQuery::create(null, $criteria);
        $query->joinWith('Activity', $join_behavior);

        return $this->getActivityDocLibs($query, $con);
    }

    /**
     * Clears out the collActivitySubDocLibs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return SeMediaFile The current object (for fluent API support)
     * @see        addActivitySubDocLibs()
     */
    public function clearActivitySubDocLibs()
    {
        $this->collActivitySubDocLibs = null; // important to set this to null since that means it is uninitialized
        $this->collActivitySubDocLibsPartial = null;

        return $this;
    }

    /**
     * reset is the collActivitySubDocLibs collection loaded partially
     *
     * @return void
     */
    public function resetPartialActivitySubDocLibs($v = true)
    {
        $this->collActivitySubDocLibsPartial = $v;
    }

    /**
     * Initializes the collActivitySubDocLibs collection.
     *
     * By default this just sets the collActivitySubDocLibs collection to an empty array (like clearcollActivitySubDocLibs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initActivitySubDocLibs($overrideExisting = true)
    {
        if (null !== $this->collActivitySubDocLibs && !$overrideExisting) {
            return;
        }
        $this->collActivitySubDocLibs = new PropelObjectCollection();
        $this->collActivitySubDocLibs->setModel('ActivitySubDocLib');
    }

    /**
     * Gets an array of ActivitySubDocLib objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this SeMediaFile is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|ActivitySubDocLib[] List of ActivitySubDocLib objects
     * @throws PropelException
     */
    public function getActivitySubDocLibs($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collActivitySubDocLibsPartial && !$this->isNew();
        if (null === $this->collActivitySubDocLibs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collActivitySubDocLibs) {
                // return empty collection
                $this->initActivitySubDocLibs();
            } else {
                $collActivitySubDocLibs = ActivitySubDocLibQuery::create(null, $criteria)
                    ->filterBySeMediaFile($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collActivitySubDocLibsPartial && count($collActivitySubDocLibs)) {
                      $this->initActivitySubDocLibs(false);

                      foreach($collActivitySubDocLibs as $obj) {
                        if (false == $this->collActivitySubDocLibs->contains($obj)) {
                          $this->collActivitySubDocLibs->append($obj);
                        }
                      }

                      $this->collActivitySubDocLibsPartial = true;
                    }

                    $collActivitySubDocLibs->getInternalIterator()->rewind();
                    return $collActivitySubDocLibs;
                }

                if($partial && $this->collActivitySubDocLibs) {
                    foreach($this->collActivitySubDocLibs as $obj) {
                        if($obj->isNew()) {
                            $collActivitySubDocLibs[] = $obj;
                        }
                    }
                }

                $this->collActivitySubDocLibs = $collActivitySubDocLibs;
                $this->collActivitySubDocLibsPartial = false;
            }
        }

        return $this->collActivitySubDocLibs;
    }

    /**
     * Sets a collection of ActivitySubDocLib objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $activitySubDocLibs A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function setActivitySubDocLibs(PropelCollection $activitySubDocLibs, PropelPDO $con = null)
    {
        $activitySubDocLibsToDelete = $this->getActivitySubDocLibs(new Criteria(), $con)->diff($activitySubDocLibs);

        $this->activitySubDocLibsScheduledForDeletion = unserialize(serialize($activitySubDocLibsToDelete));

        foreach ($activitySubDocLibsToDelete as $activitySubDocLibRemoved) {
            $activitySubDocLibRemoved->setSeMediaFile(null);
        }

        $this->collActivitySubDocLibs = null;
        foreach ($activitySubDocLibs as $activitySubDocLib) {
            $this->addActivitySubDocLib($activitySubDocLib);
        }

        $this->collActivitySubDocLibs = $activitySubDocLibs;
        $this->collActivitySubDocLibsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ActivitySubDocLib objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related ActivitySubDocLib objects.
     * @throws PropelException
     */
    public function countActivitySubDocLibs(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collActivitySubDocLibsPartial && !$this->isNew();
        if (null === $this->collActivitySubDocLibs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collActivitySubDocLibs) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getActivitySubDocLibs());
            }
            $query = ActivitySubDocLibQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySeMediaFile($this)
                ->count($con);
        }

        return count($this->collActivitySubDocLibs);
    }

    /**
     * Method called to associate a ActivitySubDocLib object to this object
     * through the ActivitySubDocLib foreign key attribute.
     *
     * @param    ActivitySubDocLib $l ActivitySubDocLib
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function addActivitySubDocLib(ActivitySubDocLib $l)
    {
        if ($this->collActivitySubDocLibs === null) {
            $this->initActivitySubDocLibs();
            $this->collActivitySubDocLibsPartial = true;
        }
        if (!in_array($l, $this->collActivitySubDocLibs->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddActivitySubDocLib($l);
        }

        return $this;
    }

    /**
     * @param	ActivitySubDocLib $activitySubDocLib The activitySubDocLib object to add.
     */
    protected function doAddActivitySubDocLib($activitySubDocLib)
    {
        $this->collActivitySubDocLibs[]= $activitySubDocLib;
        $activitySubDocLib->setSeMediaFile($this);
    }

    /**
     * @param	ActivitySubDocLib $activitySubDocLib The activitySubDocLib object to remove.
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function removeActivitySubDocLib($activitySubDocLib)
    {
        if ($this->getActivitySubDocLibs()->contains($activitySubDocLib)) {
            $this->collActivitySubDocLibs->remove($this->collActivitySubDocLibs->search($activitySubDocLib));
            if (null === $this->activitySubDocLibsScheduledForDeletion) {
                $this->activitySubDocLibsScheduledForDeletion = clone $this->collActivitySubDocLibs;
                $this->activitySubDocLibsScheduledForDeletion->clear();
            }
            $this->activitySubDocLibsScheduledForDeletion[]= clone $activitySubDocLib;
            $activitySubDocLib->setSeMediaFile(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SeMediaFile is new, it will return
     * an empty collection; or if this SeMediaFile has previously
     * been saved, it will retrieve related ActivitySubDocLibs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SeMediaFile.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ActivitySubDocLib[] List of ActivitySubDocLib objects
     */
    public function getActivitySubDocLibsJoinActivitySub($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ActivitySubDocLibQuery::create(null, $criteria);
        $query->joinWith('ActivitySub', $join_behavior);

        return $this->getActivitySubDocLibs($query, $con);
    }

    /**
     * Clears out the collActivityInsertDocLibs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return SeMediaFile The current object (for fluent API support)
     * @see        addActivityInsertDocLibs()
     */
    public function clearActivityInsertDocLibs()
    {
        $this->collActivityInsertDocLibs = null; // important to set this to null since that means it is uninitialized
        $this->collActivityInsertDocLibsPartial = null;

        return $this;
    }

    /**
     * reset is the collActivityInsertDocLibs collection loaded partially
     *
     * @return void
     */
    public function resetPartialActivityInsertDocLibs($v = true)
    {
        $this->collActivityInsertDocLibsPartial = $v;
    }

    /**
     * Initializes the collActivityInsertDocLibs collection.
     *
     * By default this just sets the collActivityInsertDocLibs collection to an empty array (like clearcollActivityInsertDocLibs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initActivityInsertDocLibs($overrideExisting = true)
    {
        if (null !== $this->collActivityInsertDocLibs && !$overrideExisting) {
            return;
        }
        $this->collActivityInsertDocLibs = new PropelObjectCollection();
        $this->collActivityInsertDocLibs->setModel('ActivityInsertDocLib');
    }

    /**
     * Gets an array of ActivityInsertDocLib objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this SeMediaFile is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|ActivityInsertDocLib[] List of ActivityInsertDocLib objects
     * @throws PropelException
     */
    public function getActivityInsertDocLibs($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collActivityInsertDocLibsPartial && !$this->isNew();
        if (null === $this->collActivityInsertDocLibs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collActivityInsertDocLibs) {
                // return empty collection
                $this->initActivityInsertDocLibs();
            } else {
                $collActivityInsertDocLibs = ActivityInsertDocLibQuery::create(null, $criteria)
                    ->filterBySeMediaFile($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collActivityInsertDocLibsPartial && count($collActivityInsertDocLibs)) {
                      $this->initActivityInsertDocLibs(false);

                      foreach($collActivityInsertDocLibs as $obj) {
                        if (false == $this->collActivityInsertDocLibs->contains($obj)) {
                          $this->collActivityInsertDocLibs->append($obj);
                        }
                      }

                      $this->collActivityInsertDocLibsPartial = true;
                    }

                    $collActivityInsertDocLibs->getInternalIterator()->rewind();
                    return $collActivityInsertDocLibs;
                }

                if($partial && $this->collActivityInsertDocLibs) {
                    foreach($this->collActivityInsertDocLibs as $obj) {
                        if($obj->isNew()) {
                            $collActivityInsertDocLibs[] = $obj;
                        }
                    }
                }

                $this->collActivityInsertDocLibs = $collActivityInsertDocLibs;
                $this->collActivityInsertDocLibsPartial = false;
            }
        }

        return $this->collActivityInsertDocLibs;
    }

    /**
     * Sets a collection of ActivityInsertDocLib objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $activityInsertDocLibs A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function setActivityInsertDocLibs(PropelCollection $activityInsertDocLibs, PropelPDO $con = null)
    {
        $activityInsertDocLibsToDelete = $this->getActivityInsertDocLibs(new Criteria(), $con)->diff($activityInsertDocLibs);

        $this->activityInsertDocLibsScheduledForDeletion = unserialize(serialize($activityInsertDocLibsToDelete));

        foreach ($activityInsertDocLibsToDelete as $activityInsertDocLibRemoved) {
            $activityInsertDocLibRemoved->setSeMediaFile(null);
        }

        $this->collActivityInsertDocLibs = null;
        foreach ($activityInsertDocLibs as $activityInsertDocLib) {
            $this->addActivityInsertDocLib($activityInsertDocLib);
        }

        $this->collActivityInsertDocLibs = $activityInsertDocLibs;
        $this->collActivityInsertDocLibsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ActivityInsertDocLib objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related ActivityInsertDocLib objects.
     * @throws PropelException
     */
    public function countActivityInsertDocLibs(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collActivityInsertDocLibsPartial && !$this->isNew();
        if (null === $this->collActivityInsertDocLibs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collActivityInsertDocLibs) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getActivityInsertDocLibs());
            }
            $query = ActivityInsertDocLibQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySeMediaFile($this)
                ->count($con);
        }

        return count($this->collActivityInsertDocLibs);
    }

    /**
     * Method called to associate a ActivityInsertDocLib object to this object
     * through the ActivityInsertDocLib foreign key attribute.
     *
     * @param    ActivityInsertDocLib $l ActivityInsertDocLib
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function addActivityInsertDocLib(ActivityInsertDocLib $l)
    {
        if ($this->collActivityInsertDocLibs === null) {
            $this->initActivityInsertDocLibs();
            $this->collActivityInsertDocLibsPartial = true;
        }
        if (!in_array($l, $this->collActivityInsertDocLibs->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddActivityInsertDocLib($l);
        }

        return $this;
    }

    /**
     * @param	ActivityInsertDocLib $activityInsertDocLib The activityInsertDocLib object to add.
     */
    protected function doAddActivityInsertDocLib($activityInsertDocLib)
    {
        $this->collActivityInsertDocLibs[]= $activityInsertDocLib;
        $activityInsertDocLib->setSeMediaFile($this);
    }

    /**
     * @param	ActivityInsertDocLib $activityInsertDocLib The activityInsertDocLib object to remove.
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function removeActivityInsertDocLib($activityInsertDocLib)
    {
        if ($this->getActivityInsertDocLibs()->contains($activityInsertDocLib)) {
            $this->collActivityInsertDocLibs->remove($this->collActivityInsertDocLibs->search($activityInsertDocLib));
            if (null === $this->activityInsertDocLibsScheduledForDeletion) {
                $this->activityInsertDocLibsScheduledForDeletion = clone $this->collActivityInsertDocLibs;
                $this->activityInsertDocLibsScheduledForDeletion->clear();
            }
            $this->activityInsertDocLibsScheduledForDeletion[]= clone $activityInsertDocLib;
            $activityInsertDocLib->setSeMediaFile(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SeMediaFile is new, it will return
     * an empty collection; or if this SeMediaFile has previously
     * been saved, it will retrieve related ActivityInsertDocLibs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SeMediaFile.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ActivityInsertDocLib[] List of ActivityInsertDocLib objects
     */
    public function getActivityInsertDocLibsJoinActivityInsert($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ActivityInsertDocLibQuery::create(null, $criteria);
        $query->joinWith('ActivityInsert', $join_behavior);

        return $this->getActivityInsertDocLibs($query, $con);
    }

    /**
     * Clears out the collContentProfileDocLibs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return SeMediaFile The current object (for fluent API support)
     * @see        addContentProfileDocLibs()
     */
    public function clearContentProfileDocLibs()
    {
        $this->collContentProfileDocLibs = null; // important to set this to null since that means it is uninitialized
        $this->collContentProfileDocLibsPartial = null;

        return $this;
    }

    /**
     * reset is the collContentProfileDocLibs collection loaded partially
     *
     * @return void
     */
    public function resetPartialContentProfileDocLibs($v = true)
    {
        $this->collContentProfileDocLibsPartial = $v;
    }

    /**
     * Initializes the collContentProfileDocLibs collection.
     *
     * By default this just sets the collContentProfileDocLibs collection to an empty array (like clearcollContentProfileDocLibs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initContentProfileDocLibs($overrideExisting = true)
    {
        if (null !== $this->collContentProfileDocLibs && !$overrideExisting) {
            return;
        }
        $this->collContentProfileDocLibs = new PropelObjectCollection();
        $this->collContentProfileDocLibs->setModel('ContentProfileDocLib');
    }

    /**
     * Gets an array of ContentProfileDocLib objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this SeMediaFile is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|ContentProfileDocLib[] List of ContentProfileDocLib objects
     * @throws PropelException
     */
    public function getContentProfileDocLibs($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collContentProfileDocLibsPartial && !$this->isNew();
        if (null === $this->collContentProfileDocLibs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collContentProfileDocLibs) {
                // return empty collection
                $this->initContentProfileDocLibs();
            } else {
                $collContentProfileDocLibs = ContentProfileDocLibQuery::create(null, $criteria)
                    ->filterBySeMediaFile($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collContentProfileDocLibsPartial && count($collContentProfileDocLibs)) {
                      $this->initContentProfileDocLibs(false);

                      foreach($collContentProfileDocLibs as $obj) {
                        if (false == $this->collContentProfileDocLibs->contains($obj)) {
                          $this->collContentProfileDocLibs->append($obj);
                        }
                      }

                      $this->collContentProfileDocLibsPartial = true;
                    }

                    $collContentProfileDocLibs->getInternalIterator()->rewind();
                    return $collContentProfileDocLibs;
                }

                if($partial && $this->collContentProfileDocLibs) {
                    foreach($this->collContentProfileDocLibs as $obj) {
                        if($obj->isNew()) {
                            $collContentProfileDocLibs[] = $obj;
                        }
                    }
                }

                $this->collContentProfileDocLibs = $collContentProfileDocLibs;
                $this->collContentProfileDocLibsPartial = false;
            }
        }

        return $this->collContentProfileDocLibs;
    }

    /**
     * Sets a collection of ContentProfileDocLib objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $contentProfileDocLibs A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function setContentProfileDocLibs(PropelCollection $contentProfileDocLibs, PropelPDO $con = null)
    {
        $contentProfileDocLibsToDelete = $this->getContentProfileDocLibs(new Criteria(), $con)->diff($contentProfileDocLibs);

        $this->contentProfileDocLibsScheduledForDeletion = unserialize(serialize($contentProfileDocLibsToDelete));

        foreach ($contentProfileDocLibsToDelete as $contentProfileDocLibRemoved) {
            $contentProfileDocLibRemoved->setSeMediaFile(null);
        }

        $this->collContentProfileDocLibs = null;
        foreach ($contentProfileDocLibs as $contentProfileDocLib) {
            $this->addContentProfileDocLib($contentProfileDocLib);
        }

        $this->collContentProfileDocLibs = $contentProfileDocLibs;
        $this->collContentProfileDocLibsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ContentProfileDocLib objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related ContentProfileDocLib objects.
     * @throws PropelException
     */
    public function countContentProfileDocLibs(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collContentProfileDocLibsPartial && !$this->isNew();
        if (null === $this->collContentProfileDocLibs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collContentProfileDocLibs) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getContentProfileDocLibs());
            }
            $query = ContentProfileDocLibQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySeMediaFile($this)
                ->count($con);
        }

        return count($this->collContentProfileDocLibs);
    }

    /**
     * Method called to associate a ContentProfileDocLib object to this object
     * through the ContentProfileDocLib foreign key attribute.
     *
     * @param    ContentProfileDocLib $l ContentProfileDocLib
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function addContentProfileDocLib(ContentProfileDocLib $l)
    {
        if ($this->collContentProfileDocLibs === null) {
            $this->initContentProfileDocLibs();
            $this->collContentProfileDocLibsPartial = true;
        }
        if (!in_array($l, $this->collContentProfileDocLibs->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddContentProfileDocLib($l);
        }

        return $this;
    }

    /**
     * @param	ContentProfileDocLib $contentProfileDocLib The contentProfileDocLib object to add.
     */
    protected function doAddContentProfileDocLib($contentProfileDocLib)
    {
        $this->collContentProfileDocLibs[]= $contentProfileDocLib;
        $contentProfileDocLib->setSeMediaFile($this);
    }

    /**
     * @param	ContentProfileDocLib $contentProfileDocLib The contentProfileDocLib object to remove.
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function removeContentProfileDocLib($contentProfileDocLib)
    {
        if ($this->getContentProfileDocLibs()->contains($contentProfileDocLib)) {
            $this->collContentProfileDocLibs->remove($this->collContentProfileDocLibs->search($contentProfileDocLib));
            if (null === $this->contentProfileDocLibsScheduledForDeletion) {
                $this->contentProfileDocLibsScheduledForDeletion = clone $this->collContentProfileDocLibs;
                $this->contentProfileDocLibsScheduledForDeletion->clear();
            }
            $this->contentProfileDocLibsScheduledForDeletion[]= clone $contentProfileDocLib;
            $contentProfileDocLib->setSeMediaFile(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SeMediaFile is new, it will return
     * an empty collection; or if this SeMediaFile has previously
     * been saved, it will retrieve related ContentProfileDocLibs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SeMediaFile.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ContentProfileDocLib[] List of ContentProfileDocLib objects
     */
    public function getContentProfileDocLibsJoinContentProfile($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ContentProfileDocLibQuery::create(null, $criteria);
        $query->joinWith('ContentProfile', $join_behavior);

        return $this->getContentProfileDocLibs($query, $con);
    }

    /**
     * Clears out the collContentWishDocLibs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return SeMediaFile The current object (for fluent API support)
     * @see        addContentWishDocLibs()
     */
    public function clearContentWishDocLibs()
    {
        $this->collContentWishDocLibs = null; // important to set this to null since that means it is uninitialized
        $this->collContentWishDocLibsPartial = null;

        return $this;
    }

    /**
     * reset is the collContentWishDocLibs collection loaded partially
     *
     * @return void
     */
    public function resetPartialContentWishDocLibs($v = true)
    {
        $this->collContentWishDocLibsPartial = $v;
    }

    /**
     * Initializes the collContentWishDocLibs collection.
     *
     * By default this just sets the collContentWishDocLibs collection to an empty array (like clearcollContentWishDocLibs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initContentWishDocLibs($overrideExisting = true)
    {
        if (null !== $this->collContentWishDocLibs && !$overrideExisting) {
            return;
        }
        $this->collContentWishDocLibs = new PropelObjectCollection();
        $this->collContentWishDocLibs->setModel('ContentWishDocLib');
    }

    /**
     * Gets an array of ContentWishDocLib objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this SeMediaFile is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|ContentWishDocLib[] List of ContentWishDocLib objects
     * @throws PropelException
     */
    public function getContentWishDocLibs($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collContentWishDocLibsPartial && !$this->isNew();
        if (null === $this->collContentWishDocLibs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collContentWishDocLibs) {
                // return empty collection
                $this->initContentWishDocLibs();
            } else {
                $collContentWishDocLibs = ContentWishDocLibQuery::create(null, $criteria)
                    ->filterBySeMediaFile($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collContentWishDocLibsPartial && count($collContentWishDocLibs)) {
                      $this->initContentWishDocLibs(false);

                      foreach($collContentWishDocLibs as $obj) {
                        if (false == $this->collContentWishDocLibs->contains($obj)) {
                          $this->collContentWishDocLibs->append($obj);
                        }
                      }

                      $this->collContentWishDocLibsPartial = true;
                    }

                    $collContentWishDocLibs->getInternalIterator()->rewind();
                    return $collContentWishDocLibs;
                }

                if($partial && $this->collContentWishDocLibs) {
                    foreach($this->collContentWishDocLibs as $obj) {
                        if($obj->isNew()) {
                            $collContentWishDocLibs[] = $obj;
                        }
                    }
                }

                $this->collContentWishDocLibs = $collContentWishDocLibs;
                $this->collContentWishDocLibsPartial = false;
            }
        }

        return $this->collContentWishDocLibs;
    }

    /**
     * Sets a collection of ContentWishDocLib objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $contentWishDocLibs A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function setContentWishDocLibs(PropelCollection $contentWishDocLibs, PropelPDO $con = null)
    {
        $contentWishDocLibsToDelete = $this->getContentWishDocLibs(new Criteria(), $con)->diff($contentWishDocLibs);

        $this->contentWishDocLibsScheduledForDeletion = unserialize(serialize($contentWishDocLibsToDelete));

        foreach ($contentWishDocLibsToDelete as $contentWishDocLibRemoved) {
            $contentWishDocLibRemoved->setSeMediaFile(null);
        }

        $this->collContentWishDocLibs = null;
        foreach ($contentWishDocLibs as $contentWishDocLib) {
            $this->addContentWishDocLib($contentWishDocLib);
        }

        $this->collContentWishDocLibs = $contentWishDocLibs;
        $this->collContentWishDocLibsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ContentWishDocLib objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related ContentWishDocLib objects.
     * @throws PropelException
     */
    public function countContentWishDocLibs(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collContentWishDocLibsPartial && !$this->isNew();
        if (null === $this->collContentWishDocLibs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collContentWishDocLibs) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getContentWishDocLibs());
            }
            $query = ContentWishDocLibQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySeMediaFile($this)
                ->count($con);
        }

        return count($this->collContentWishDocLibs);
    }

    /**
     * Method called to associate a ContentWishDocLib object to this object
     * through the ContentWishDocLib foreign key attribute.
     *
     * @param    ContentWishDocLib $l ContentWishDocLib
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function addContentWishDocLib(ContentWishDocLib $l)
    {
        if ($this->collContentWishDocLibs === null) {
            $this->initContentWishDocLibs();
            $this->collContentWishDocLibsPartial = true;
        }
        if (!in_array($l, $this->collContentWishDocLibs->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddContentWishDocLib($l);
        }

        return $this;
    }

    /**
     * @param	ContentWishDocLib $contentWishDocLib The contentWishDocLib object to add.
     */
    protected function doAddContentWishDocLib($contentWishDocLib)
    {
        $this->collContentWishDocLibs[]= $contentWishDocLib;
        $contentWishDocLib->setSeMediaFile($this);
    }

    /**
     * @param	ContentWishDocLib $contentWishDocLib The contentWishDocLib object to remove.
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function removeContentWishDocLib($contentWishDocLib)
    {
        if ($this->getContentWishDocLibs()->contains($contentWishDocLib)) {
            $this->collContentWishDocLibs->remove($this->collContentWishDocLibs->search($contentWishDocLib));
            if (null === $this->contentWishDocLibsScheduledForDeletion) {
                $this->contentWishDocLibsScheduledForDeletion = clone $this->collContentWishDocLibs;
                $this->contentWishDocLibsScheduledForDeletion->clear();
            }
            $this->contentWishDocLibsScheduledForDeletion[]= clone $contentWishDocLib;
            $contentWishDocLib->setSeMediaFile(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SeMediaFile is new, it will return
     * an empty collection; or if this SeMediaFile has previously
     * been saved, it will retrieve related ContentWishDocLibs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SeMediaFile.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ContentWishDocLib[] List of ContentWishDocLib objects
     */
    public function getContentWishDocLibsJoinContentWish($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ContentWishDocLibQuery::create(null, $criteria);
        $query->joinWith('ContentWish', $join_behavior);

        return $this->getContentWishDocLibs($query, $con);
    }

    /**
     * Clears out the collContentNewsDocLibs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return SeMediaFile The current object (for fluent API support)
     * @see        addContentNewsDocLibs()
     */
    public function clearContentNewsDocLibs()
    {
        $this->collContentNewsDocLibs = null; // important to set this to null since that means it is uninitialized
        $this->collContentNewsDocLibsPartial = null;

        return $this;
    }

    /**
     * reset is the collContentNewsDocLibs collection loaded partially
     *
     * @return void
     */
    public function resetPartialContentNewsDocLibs($v = true)
    {
        $this->collContentNewsDocLibsPartial = $v;
    }

    /**
     * Initializes the collContentNewsDocLibs collection.
     *
     * By default this just sets the collContentNewsDocLibs collection to an empty array (like clearcollContentNewsDocLibs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initContentNewsDocLibs($overrideExisting = true)
    {
        if (null !== $this->collContentNewsDocLibs && !$overrideExisting) {
            return;
        }
        $this->collContentNewsDocLibs = new PropelObjectCollection();
        $this->collContentNewsDocLibs->setModel('ContentNewsDocLib');
    }

    /**
     * Gets an array of ContentNewsDocLib objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this SeMediaFile is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|ContentNewsDocLib[] List of ContentNewsDocLib objects
     * @throws PropelException
     */
    public function getContentNewsDocLibs($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collContentNewsDocLibsPartial && !$this->isNew();
        if (null === $this->collContentNewsDocLibs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collContentNewsDocLibs) {
                // return empty collection
                $this->initContentNewsDocLibs();
            } else {
                $collContentNewsDocLibs = ContentNewsDocLibQuery::create(null, $criteria)
                    ->filterBySeMediaFile($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collContentNewsDocLibsPartial && count($collContentNewsDocLibs)) {
                      $this->initContentNewsDocLibs(false);

                      foreach($collContentNewsDocLibs as $obj) {
                        if (false == $this->collContentNewsDocLibs->contains($obj)) {
                          $this->collContentNewsDocLibs->append($obj);
                        }
                      }

                      $this->collContentNewsDocLibsPartial = true;
                    }

                    $collContentNewsDocLibs->getInternalIterator()->rewind();
                    return $collContentNewsDocLibs;
                }

                if($partial && $this->collContentNewsDocLibs) {
                    foreach($this->collContentNewsDocLibs as $obj) {
                        if($obj->isNew()) {
                            $collContentNewsDocLibs[] = $obj;
                        }
                    }
                }

                $this->collContentNewsDocLibs = $collContentNewsDocLibs;
                $this->collContentNewsDocLibsPartial = false;
            }
        }

        return $this->collContentNewsDocLibs;
    }

    /**
     * Sets a collection of ContentNewsDocLib objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $contentNewsDocLibs A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function setContentNewsDocLibs(PropelCollection $contentNewsDocLibs, PropelPDO $con = null)
    {
        $contentNewsDocLibsToDelete = $this->getContentNewsDocLibs(new Criteria(), $con)->diff($contentNewsDocLibs);

        $this->contentNewsDocLibsScheduledForDeletion = unserialize(serialize($contentNewsDocLibsToDelete));

        foreach ($contentNewsDocLibsToDelete as $contentNewsDocLibRemoved) {
            $contentNewsDocLibRemoved->setSeMediaFile(null);
        }

        $this->collContentNewsDocLibs = null;
        foreach ($contentNewsDocLibs as $contentNewsDocLib) {
            $this->addContentNewsDocLib($contentNewsDocLib);
        }

        $this->collContentNewsDocLibs = $contentNewsDocLibs;
        $this->collContentNewsDocLibsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ContentNewsDocLib objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related ContentNewsDocLib objects.
     * @throws PropelException
     */
    public function countContentNewsDocLibs(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collContentNewsDocLibsPartial && !$this->isNew();
        if (null === $this->collContentNewsDocLibs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collContentNewsDocLibs) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getContentNewsDocLibs());
            }
            $query = ContentNewsDocLibQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySeMediaFile($this)
                ->count($con);
        }

        return count($this->collContentNewsDocLibs);
    }

    /**
     * Method called to associate a ContentNewsDocLib object to this object
     * through the ContentNewsDocLib foreign key attribute.
     *
     * @param    ContentNewsDocLib $l ContentNewsDocLib
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function addContentNewsDocLib(ContentNewsDocLib $l)
    {
        if ($this->collContentNewsDocLibs === null) {
            $this->initContentNewsDocLibs();
            $this->collContentNewsDocLibsPartial = true;
        }
        if (!in_array($l, $this->collContentNewsDocLibs->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddContentNewsDocLib($l);
        }

        return $this;
    }

    /**
     * @param	ContentNewsDocLib $contentNewsDocLib The contentNewsDocLib object to add.
     */
    protected function doAddContentNewsDocLib($contentNewsDocLib)
    {
        $this->collContentNewsDocLibs[]= $contentNewsDocLib;
        $contentNewsDocLib->setSeMediaFile($this);
    }

    /**
     * @param	ContentNewsDocLib $contentNewsDocLib The contentNewsDocLib object to remove.
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function removeContentNewsDocLib($contentNewsDocLib)
    {
        if ($this->getContentNewsDocLibs()->contains($contentNewsDocLib)) {
            $this->collContentNewsDocLibs->remove($this->collContentNewsDocLibs->search($contentNewsDocLib));
            if (null === $this->contentNewsDocLibsScheduledForDeletion) {
                $this->contentNewsDocLibsScheduledForDeletion = clone $this->collContentNewsDocLibs;
                $this->contentNewsDocLibsScheduledForDeletion->clear();
            }
            $this->contentNewsDocLibsScheduledForDeletion[]= clone $contentNewsDocLib;
            $contentNewsDocLib->setSeMediaFile(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SeMediaFile is new, it will return
     * an empty collection; or if this SeMediaFile has previously
     * been saved, it will retrieve related ContentNewsDocLibs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SeMediaFile.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ContentNewsDocLib[] List of ContentNewsDocLib objects
     */
    public function getContentNewsDocLibsJoinContentNews($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ContentNewsDocLibQuery::create(null, $criteria);
        $query->joinWith('ContentNews', $join_behavior);

        return $this->getContentNewsDocLibs($query, $con);
    }

    /**
     * Clears out the collContentGenericDocLibs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return SeMediaFile The current object (for fluent API support)
     * @see        addContentGenericDocLibs()
     */
    public function clearContentGenericDocLibs()
    {
        $this->collContentGenericDocLibs = null; // important to set this to null since that means it is uninitialized
        $this->collContentGenericDocLibsPartial = null;

        return $this;
    }

    /**
     * reset is the collContentGenericDocLibs collection loaded partially
     *
     * @return void
     */
    public function resetPartialContentGenericDocLibs($v = true)
    {
        $this->collContentGenericDocLibsPartial = $v;
    }

    /**
     * Initializes the collContentGenericDocLibs collection.
     *
     * By default this just sets the collContentGenericDocLibs collection to an empty array (like clearcollContentGenericDocLibs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initContentGenericDocLibs($overrideExisting = true)
    {
        if (null !== $this->collContentGenericDocLibs && !$overrideExisting) {
            return;
        }
        $this->collContentGenericDocLibs = new PropelObjectCollection();
        $this->collContentGenericDocLibs->setModel('ContentGenericDocLib');
    }

    /**
     * Gets an array of ContentGenericDocLib objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this SeMediaFile is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|ContentGenericDocLib[] List of ContentGenericDocLib objects
     * @throws PropelException
     */
    public function getContentGenericDocLibs($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collContentGenericDocLibsPartial && !$this->isNew();
        if (null === $this->collContentGenericDocLibs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collContentGenericDocLibs) {
                // return empty collection
                $this->initContentGenericDocLibs();
            } else {
                $collContentGenericDocLibs = ContentGenericDocLibQuery::create(null, $criteria)
                    ->filterBySeMediaFile($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collContentGenericDocLibsPartial && count($collContentGenericDocLibs)) {
                      $this->initContentGenericDocLibs(false);

                      foreach($collContentGenericDocLibs as $obj) {
                        if (false == $this->collContentGenericDocLibs->contains($obj)) {
                          $this->collContentGenericDocLibs->append($obj);
                        }
                      }

                      $this->collContentGenericDocLibsPartial = true;
                    }

                    $collContentGenericDocLibs->getInternalIterator()->rewind();
                    return $collContentGenericDocLibs;
                }

                if($partial && $this->collContentGenericDocLibs) {
                    foreach($this->collContentGenericDocLibs as $obj) {
                        if($obj->isNew()) {
                            $collContentGenericDocLibs[] = $obj;
                        }
                    }
                }

                $this->collContentGenericDocLibs = $collContentGenericDocLibs;
                $this->collContentGenericDocLibsPartial = false;
            }
        }

        return $this->collContentGenericDocLibs;
    }

    /**
     * Sets a collection of ContentGenericDocLib objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $contentGenericDocLibs A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function setContentGenericDocLibs(PropelCollection $contentGenericDocLibs, PropelPDO $con = null)
    {
        $contentGenericDocLibsToDelete = $this->getContentGenericDocLibs(new Criteria(), $con)->diff($contentGenericDocLibs);

        $this->contentGenericDocLibsScheduledForDeletion = unserialize(serialize($contentGenericDocLibsToDelete));

        foreach ($contentGenericDocLibsToDelete as $contentGenericDocLibRemoved) {
            $contentGenericDocLibRemoved->setSeMediaFile(null);
        }

        $this->collContentGenericDocLibs = null;
        foreach ($contentGenericDocLibs as $contentGenericDocLib) {
            $this->addContentGenericDocLib($contentGenericDocLib);
        }

        $this->collContentGenericDocLibs = $contentGenericDocLibs;
        $this->collContentGenericDocLibsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ContentGenericDocLib objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related ContentGenericDocLib objects.
     * @throws PropelException
     */
    public function countContentGenericDocLibs(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collContentGenericDocLibsPartial && !$this->isNew();
        if (null === $this->collContentGenericDocLibs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collContentGenericDocLibs) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getContentGenericDocLibs());
            }
            $query = ContentGenericDocLibQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySeMediaFile($this)
                ->count($con);
        }

        return count($this->collContentGenericDocLibs);
    }

    /**
     * Method called to associate a ContentGenericDocLib object to this object
     * through the ContentGenericDocLib foreign key attribute.
     *
     * @param    ContentGenericDocLib $l ContentGenericDocLib
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function addContentGenericDocLib(ContentGenericDocLib $l)
    {
        if ($this->collContentGenericDocLibs === null) {
            $this->initContentGenericDocLibs();
            $this->collContentGenericDocLibsPartial = true;
        }
        if (!in_array($l, $this->collContentGenericDocLibs->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddContentGenericDocLib($l);
        }

        return $this;
    }

    /**
     * @param	ContentGenericDocLib $contentGenericDocLib The contentGenericDocLib object to add.
     */
    protected function doAddContentGenericDocLib($contentGenericDocLib)
    {
        $this->collContentGenericDocLibs[]= $contentGenericDocLib;
        $contentGenericDocLib->setSeMediaFile($this);
    }

    /**
     * @param	ContentGenericDocLib $contentGenericDocLib The contentGenericDocLib object to remove.
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function removeContentGenericDocLib($contentGenericDocLib)
    {
        if ($this->getContentGenericDocLibs()->contains($contentGenericDocLib)) {
            $this->collContentGenericDocLibs->remove($this->collContentGenericDocLibs->search($contentGenericDocLib));
            if (null === $this->contentGenericDocLibsScheduledForDeletion) {
                $this->contentGenericDocLibsScheduledForDeletion = clone $this->collContentGenericDocLibs;
                $this->contentGenericDocLibsScheduledForDeletion->clear();
            }
            $this->contentGenericDocLibsScheduledForDeletion[]= clone $contentGenericDocLib;
            $contentGenericDocLib->setSeMediaFile(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SeMediaFile is new, it will return
     * an empty collection; or if this SeMediaFile has previously
     * been saved, it will retrieve related ContentGenericDocLibs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SeMediaFile.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ContentGenericDocLib[] List of ContentGenericDocLib objects
     */
    public function getContentGenericDocLibsJoinContentGeneric($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ContentGenericDocLibQuery::create(null, $criteria);
        $query->joinWith('ContentGeneric', $join_behavior);

        return $this->getContentGenericDocLibs($query, $con);
    }

    /**
     * Clears out the collContentOfferDocLibs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return SeMediaFile The current object (for fluent API support)
     * @see        addContentOfferDocLibs()
     */
    public function clearContentOfferDocLibs()
    {
        $this->collContentOfferDocLibs = null; // important to set this to null since that means it is uninitialized
        $this->collContentOfferDocLibsPartial = null;

        return $this;
    }

    /**
     * reset is the collContentOfferDocLibs collection loaded partially
     *
     * @return void
     */
    public function resetPartialContentOfferDocLibs($v = true)
    {
        $this->collContentOfferDocLibsPartial = $v;
    }

    /**
     * Initializes the collContentOfferDocLibs collection.
     *
     * By default this just sets the collContentOfferDocLibs collection to an empty array (like clearcollContentOfferDocLibs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initContentOfferDocLibs($overrideExisting = true)
    {
        if (null !== $this->collContentOfferDocLibs && !$overrideExisting) {
            return;
        }
        $this->collContentOfferDocLibs = new PropelObjectCollection();
        $this->collContentOfferDocLibs->setModel('ContentOfferDocLib');
    }

    /**
     * Gets an array of ContentOfferDocLib objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this SeMediaFile is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|ContentOfferDocLib[] List of ContentOfferDocLib objects
     * @throws PropelException
     */
    public function getContentOfferDocLibs($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collContentOfferDocLibsPartial && !$this->isNew();
        if (null === $this->collContentOfferDocLibs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collContentOfferDocLibs) {
                // return empty collection
                $this->initContentOfferDocLibs();
            } else {
                $collContentOfferDocLibs = ContentOfferDocLibQuery::create(null, $criteria)
                    ->filterBySeMediaFile($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collContentOfferDocLibsPartial && count($collContentOfferDocLibs)) {
                      $this->initContentOfferDocLibs(false);

                      foreach($collContentOfferDocLibs as $obj) {
                        if (false == $this->collContentOfferDocLibs->contains($obj)) {
                          $this->collContentOfferDocLibs->append($obj);
                        }
                      }

                      $this->collContentOfferDocLibsPartial = true;
                    }

                    $collContentOfferDocLibs->getInternalIterator()->rewind();
                    return $collContentOfferDocLibs;
                }

                if($partial && $this->collContentOfferDocLibs) {
                    foreach($this->collContentOfferDocLibs as $obj) {
                        if($obj->isNew()) {
                            $collContentOfferDocLibs[] = $obj;
                        }
                    }
                }

                $this->collContentOfferDocLibs = $collContentOfferDocLibs;
                $this->collContentOfferDocLibsPartial = false;
            }
        }

        return $this->collContentOfferDocLibs;
    }

    /**
     * Sets a collection of ContentOfferDocLib objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $contentOfferDocLibs A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function setContentOfferDocLibs(PropelCollection $contentOfferDocLibs, PropelPDO $con = null)
    {
        $contentOfferDocLibsToDelete = $this->getContentOfferDocLibs(new Criteria(), $con)->diff($contentOfferDocLibs);

        $this->contentOfferDocLibsScheduledForDeletion = unserialize(serialize($contentOfferDocLibsToDelete));

        foreach ($contentOfferDocLibsToDelete as $contentOfferDocLibRemoved) {
            $contentOfferDocLibRemoved->setSeMediaFile(null);
        }

        $this->collContentOfferDocLibs = null;
        foreach ($contentOfferDocLibs as $contentOfferDocLib) {
            $this->addContentOfferDocLib($contentOfferDocLib);
        }

        $this->collContentOfferDocLibs = $contentOfferDocLibs;
        $this->collContentOfferDocLibsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ContentOfferDocLib objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related ContentOfferDocLib objects.
     * @throws PropelException
     */
    public function countContentOfferDocLibs(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collContentOfferDocLibsPartial && !$this->isNew();
        if (null === $this->collContentOfferDocLibs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collContentOfferDocLibs) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getContentOfferDocLibs());
            }
            $query = ContentOfferDocLibQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySeMediaFile($this)
                ->count($con);
        }

        return count($this->collContentOfferDocLibs);
    }

    /**
     * Method called to associate a ContentOfferDocLib object to this object
     * through the ContentOfferDocLib foreign key attribute.
     *
     * @param    ContentOfferDocLib $l ContentOfferDocLib
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function addContentOfferDocLib(ContentOfferDocLib $l)
    {
        if ($this->collContentOfferDocLibs === null) {
            $this->initContentOfferDocLibs();
            $this->collContentOfferDocLibsPartial = true;
        }
        if (!in_array($l, $this->collContentOfferDocLibs->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddContentOfferDocLib($l);
        }

        return $this;
    }

    /**
     * @param	ContentOfferDocLib $contentOfferDocLib The contentOfferDocLib object to add.
     */
    protected function doAddContentOfferDocLib($contentOfferDocLib)
    {
        $this->collContentOfferDocLibs[]= $contentOfferDocLib;
        $contentOfferDocLib->setSeMediaFile($this);
    }

    /**
     * @param	ContentOfferDocLib $contentOfferDocLib The contentOfferDocLib object to remove.
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function removeContentOfferDocLib($contentOfferDocLib)
    {
        if ($this->getContentOfferDocLibs()->contains($contentOfferDocLib)) {
            $this->collContentOfferDocLibs->remove($this->collContentOfferDocLibs->search($contentOfferDocLib));
            if (null === $this->contentOfferDocLibsScheduledForDeletion) {
                $this->contentOfferDocLibsScheduledForDeletion = clone $this->collContentOfferDocLibs;
                $this->contentOfferDocLibsScheduledForDeletion->clear();
            }
            $this->contentOfferDocLibsScheduledForDeletion[]= clone $contentOfferDocLib;
            $contentOfferDocLib->setSeMediaFile(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SeMediaFile is new, it will return
     * an empty collection; or if this SeMediaFile has previously
     * been saved, it will retrieve related ContentOfferDocLibs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SeMediaFile.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ContentOfferDocLib[] List of ContentOfferDocLib objects
     */
    public function getContentOfferDocLibsJoinContentOffer($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ContentOfferDocLibQuery::create(null, $criteria);
        $query->joinWith('ContentOffer', $join_behavior);

        return $this->getContentOfferDocLibs($query, $con);
    }

    /**
     * Clears out the collContentStayDocLibs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return SeMediaFile The current object (for fluent API support)
     * @see        addContentStayDocLibs()
     */
    public function clearContentStayDocLibs()
    {
        $this->collContentStayDocLibs = null; // important to set this to null since that means it is uninitialized
        $this->collContentStayDocLibsPartial = null;

        return $this;
    }

    /**
     * reset is the collContentStayDocLibs collection loaded partially
     *
     * @return void
     */
    public function resetPartialContentStayDocLibs($v = true)
    {
        $this->collContentStayDocLibsPartial = $v;
    }

    /**
     * Initializes the collContentStayDocLibs collection.
     *
     * By default this just sets the collContentStayDocLibs collection to an empty array (like clearcollContentStayDocLibs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initContentStayDocLibs($overrideExisting = true)
    {
        if (null !== $this->collContentStayDocLibs && !$overrideExisting) {
            return;
        }
        $this->collContentStayDocLibs = new PropelObjectCollection();
        $this->collContentStayDocLibs->setModel('ContentStayDocLib');
    }

    /**
     * Gets an array of ContentStayDocLib objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this SeMediaFile is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|ContentStayDocLib[] List of ContentStayDocLib objects
     * @throws PropelException
     */
    public function getContentStayDocLibs($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collContentStayDocLibsPartial && !$this->isNew();
        if (null === $this->collContentStayDocLibs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collContentStayDocLibs) {
                // return empty collection
                $this->initContentStayDocLibs();
            } else {
                $collContentStayDocLibs = ContentStayDocLibQuery::create(null, $criteria)
                    ->filterBySeMediaFile($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collContentStayDocLibsPartial && count($collContentStayDocLibs)) {
                      $this->initContentStayDocLibs(false);

                      foreach($collContentStayDocLibs as $obj) {
                        if (false == $this->collContentStayDocLibs->contains($obj)) {
                          $this->collContentStayDocLibs->append($obj);
                        }
                      }

                      $this->collContentStayDocLibsPartial = true;
                    }

                    $collContentStayDocLibs->getInternalIterator()->rewind();
                    return $collContentStayDocLibs;
                }

                if($partial && $this->collContentStayDocLibs) {
                    foreach($this->collContentStayDocLibs as $obj) {
                        if($obj->isNew()) {
                            $collContentStayDocLibs[] = $obj;
                        }
                    }
                }

                $this->collContentStayDocLibs = $collContentStayDocLibs;
                $this->collContentStayDocLibsPartial = false;
            }
        }

        return $this->collContentStayDocLibs;
    }

    /**
     * Sets a collection of ContentStayDocLib objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $contentStayDocLibs A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function setContentStayDocLibs(PropelCollection $contentStayDocLibs, PropelPDO $con = null)
    {
        $contentStayDocLibsToDelete = $this->getContentStayDocLibs(new Criteria(), $con)->diff($contentStayDocLibs);

        $this->contentStayDocLibsScheduledForDeletion = unserialize(serialize($contentStayDocLibsToDelete));

        foreach ($contentStayDocLibsToDelete as $contentStayDocLibRemoved) {
            $contentStayDocLibRemoved->setSeMediaFile(null);
        }

        $this->collContentStayDocLibs = null;
        foreach ($contentStayDocLibs as $contentStayDocLib) {
            $this->addContentStayDocLib($contentStayDocLib);
        }

        $this->collContentStayDocLibs = $contentStayDocLibs;
        $this->collContentStayDocLibsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ContentStayDocLib objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related ContentStayDocLib objects.
     * @throws PropelException
     */
    public function countContentStayDocLibs(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collContentStayDocLibsPartial && !$this->isNew();
        if (null === $this->collContentStayDocLibs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collContentStayDocLibs) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getContentStayDocLibs());
            }
            $query = ContentStayDocLibQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySeMediaFile($this)
                ->count($con);
        }

        return count($this->collContentStayDocLibs);
    }

    /**
     * Method called to associate a ContentStayDocLib object to this object
     * through the ContentStayDocLib foreign key attribute.
     *
     * @param    ContentStayDocLib $l ContentStayDocLib
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function addContentStayDocLib(ContentStayDocLib $l)
    {
        if ($this->collContentStayDocLibs === null) {
            $this->initContentStayDocLibs();
            $this->collContentStayDocLibsPartial = true;
        }
        if (!in_array($l, $this->collContentStayDocLibs->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddContentStayDocLib($l);
        }

        return $this;
    }

    /**
     * @param	ContentStayDocLib $contentStayDocLib The contentStayDocLib object to add.
     */
    protected function doAddContentStayDocLib($contentStayDocLib)
    {
        $this->collContentStayDocLibs[]= $contentStayDocLib;
        $contentStayDocLib->setSeMediaFile($this);
    }

    /**
     * @param	ContentStayDocLib $contentStayDocLib The contentStayDocLib object to remove.
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function removeContentStayDocLib($contentStayDocLib)
    {
        if ($this->getContentStayDocLibs()->contains($contentStayDocLib)) {
            $this->collContentStayDocLibs->remove($this->collContentStayDocLibs->search($contentStayDocLib));
            if (null === $this->contentStayDocLibsScheduledForDeletion) {
                $this->contentStayDocLibsScheduledForDeletion = clone $this->collContentStayDocLibs;
                $this->contentStayDocLibsScheduledForDeletion->clear();
            }
            $this->contentStayDocLibsScheduledForDeletion[]= clone $contentStayDocLib;
            $contentStayDocLib->setSeMediaFile(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SeMediaFile is new, it will return
     * an empty collection; or if this SeMediaFile has previously
     * been saved, it will retrieve related ContentStayDocLibs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SeMediaFile.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ContentStayDocLib[] List of ContentStayDocLib objects
     */
    public function getContentStayDocLibsJoinContentStay($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ContentStayDocLibQuery::create(null, $criteria);
        $query->joinWith('ContentStay', $join_behavior);

        return $this->getContentStayDocLibs($query, $con);
    }

    /**
     * Clears out the collSeObjectHasFiles collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return SeMediaFile The current object (for fluent API support)
     * @see        addSeObjectHasFiles()
     */
    public function clearSeObjectHasFiles()
    {
        $this->collSeObjectHasFiles = null; // important to set this to null since that means it is uninitialized
        $this->collSeObjectHasFilesPartial = null;

        return $this;
    }

    /**
     * reset is the collSeObjectHasFiles collection loaded partially
     *
     * @return void
     */
    public function resetPartialSeObjectHasFiles($v = true)
    {
        $this->collSeObjectHasFilesPartial = $v;
    }

    /**
     * Initializes the collSeObjectHasFiles collection.
     *
     * By default this just sets the collSeObjectHasFiles collection to an empty array (like clearcollSeObjectHasFiles());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSeObjectHasFiles($overrideExisting = true)
    {
        if (null !== $this->collSeObjectHasFiles && !$overrideExisting) {
            return;
        }
        $this->collSeObjectHasFiles = new PropelObjectCollection();
        $this->collSeObjectHasFiles->setModel('SeObjectHasFile');
    }

    /**
     * Gets an array of SeObjectHasFile objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this SeMediaFile is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|SeObjectHasFile[] List of SeObjectHasFile objects
     * @throws PropelException
     */
    public function getSeObjectHasFiles($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collSeObjectHasFilesPartial && !$this->isNew();
        if (null === $this->collSeObjectHasFiles || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSeObjectHasFiles) {
                // return empty collection
                $this->initSeObjectHasFiles();
            } else {
                $collSeObjectHasFiles = SeObjectHasFileQuery::create(null, $criteria)
                    ->filterBySeMediaFile($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collSeObjectHasFilesPartial && count($collSeObjectHasFiles)) {
                      $this->initSeObjectHasFiles(false);

                      foreach($collSeObjectHasFiles as $obj) {
                        if (false == $this->collSeObjectHasFiles->contains($obj)) {
                          $this->collSeObjectHasFiles->append($obj);
                        }
                      }

                      $this->collSeObjectHasFilesPartial = true;
                    }

                    $collSeObjectHasFiles->getInternalIterator()->rewind();
                    return $collSeObjectHasFiles;
                }

                if($partial && $this->collSeObjectHasFiles) {
                    foreach($this->collSeObjectHasFiles as $obj) {
                        if($obj->isNew()) {
                            $collSeObjectHasFiles[] = $obj;
                        }
                    }
                }

                $this->collSeObjectHasFiles = $collSeObjectHasFiles;
                $this->collSeObjectHasFilesPartial = false;
            }
        }

        return $this->collSeObjectHasFiles;
    }

    /**
     * Sets a collection of SeObjectHasFile objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $seObjectHasFiles A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function setSeObjectHasFiles(PropelCollection $seObjectHasFiles, PropelPDO $con = null)
    {
        $seObjectHasFilesToDelete = $this->getSeObjectHasFiles(new Criteria(), $con)->diff($seObjectHasFiles);

        $this->seObjectHasFilesScheduledForDeletion = unserialize(serialize($seObjectHasFilesToDelete));

        foreach ($seObjectHasFilesToDelete as $seObjectHasFileRemoved) {
            $seObjectHasFileRemoved->setSeMediaFile(null);
        }

        $this->collSeObjectHasFiles = null;
        foreach ($seObjectHasFiles as $seObjectHasFile) {
            $this->addSeObjectHasFile($seObjectHasFile);
        }

        $this->collSeObjectHasFiles = $seObjectHasFiles;
        $this->collSeObjectHasFilesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SeObjectHasFile objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related SeObjectHasFile objects.
     * @throws PropelException
     */
    public function countSeObjectHasFiles(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collSeObjectHasFilesPartial && !$this->isNew();
        if (null === $this->collSeObjectHasFiles || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSeObjectHasFiles) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getSeObjectHasFiles());
            }
            $query = SeObjectHasFileQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySeMediaFile($this)
                ->count($con);
        }

        return count($this->collSeObjectHasFiles);
    }

    /**
     * Method called to associate a SeObjectHasFile object to this object
     * through the SeObjectHasFile foreign key attribute.
     *
     * @param    SeObjectHasFile $l SeObjectHasFile
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function addSeObjectHasFile(SeObjectHasFile $l)
    {
        if ($this->collSeObjectHasFiles === null) {
            $this->initSeObjectHasFiles();
            $this->collSeObjectHasFilesPartial = true;
        }
        if (!in_array($l, $this->collSeObjectHasFiles->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddSeObjectHasFile($l);
        }

        return $this;
    }

    /**
     * @param	SeObjectHasFile $seObjectHasFile The seObjectHasFile object to add.
     */
    protected function doAddSeObjectHasFile($seObjectHasFile)
    {
        $this->collSeObjectHasFiles[]= $seObjectHasFile;
        $seObjectHasFile->setSeMediaFile($this);
    }

    /**
     * @param	SeObjectHasFile $seObjectHasFile The seObjectHasFile object to remove.
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function removeSeObjectHasFile($seObjectHasFile)
    {
        if ($this->getSeObjectHasFiles()->contains($seObjectHasFile)) {
            $this->collSeObjectHasFiles->remove($this->collSeObjectHasFiles->search($seObjectHasFile));
            if (null === $this->seObjectHasFilesScheduledForDeletion) {
                $this->seObjectHasFilesScheduledForDeletion = clone $this->collSeObjectHasFiles;
                $this->seObjectHasFilesScheduledForDeletion->clear();
            }
            $this->seObjectHasFilesScheduledForDeletion[]= clone $seObjectHasFile;
            $seObjectHasFile->setSeMediaFile(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SeMediaFile is new, it will return
     * an empty collection; or if this SeMediaFile has previously
     * been saved, it will retrieve related SeObjectHasFiles from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SeMediaFile.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|SeObjectHasFile[] List of SeObjectHasFile objects
     */
    public function getSeObjectHasFilesJoinSeMediaObject($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = SeObjectHasFileQuery::create(null, $criteria);
        $query->joinWith('SeMediaObject', $join_behavior);

        return $this->getSeObjectHasFiles($query, $con);
    }

    /**
     * Clears out the collSeMediaFileI18ns collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return SeMediaFile The current object (for fluent API support)
     * @see        addSeMediaFileI18ns()
     */
    public function clearSeMediaFileI18ns()
    {
        $this->collSeMediaFileI18ns = null; // important to set this to null since that means it is uninitialized
        $this->collSeMediaFileI18nsPartial = null;

        return $this;
    }

    /**
     * reset is the collSeMediaFileI18ns collection loaded partially
     *
     * @return void
     */
    public function resetPartialSeMediaFileI18ns($v = true)
    {
        $this->collSeMediaFileI18nsPartial = $v;
    }

    /**
     * Initializes the collSeMediaFileI18ns collection.
     *
     * By default this just sets the collSeMediaFileI18ns collection to an empty array (like clearcollSeMediaFileI18ns());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSeMediaFileI18ns($overrideExisting = true)
    {
        if (null !== $this->collSeMediaFileI18ns && !$overrideExisting) {
            return;
        }
        $this->collSeMediaFileI18ns = new PropelObjectCollection();
        $this->collSeMediaFileI18ns->setModel('SeMediaFileI18n');
    }

    /**
     * Gets an array of SeMediaFileI18n objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this SeMediaFile is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|SeMediaFileI18n[] List of SeMediaFileI18n objects
     * @throws PropelException
     */
    public function getSeMediaFileI18ns($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collSeMediaFileI18nsPartial && !$this->isNew();
        if (null === $this->collSeMediaFileI18ns || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSeMediaFileI18ns) {
                // return empty collection
                $this->initSeMediaFileI18ns();
            } else {
                $collSeMediaFileI18ns = SeMediaFileI18nQuery::create(null, $criteria)
                    ->filterBySeMediaFile($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collSeMediaFileI18nsPartial && count($collSeMediaFileI18ns)) {
                      $this->initSeMediaFileI18ns(false);

                      foreach($collSeMediaFileI18ns as $obj) {
                        if (false == $this->collSeMediaFileI18ns->contains($obj)) {
                          $this->collSeMediaFileI18ns->append($obj);
                        }
                      }

                      $this->collSeMediaFileI18nsPartial = true;
                    }

                    $collSeMediaFileI18ns->getInternalIterator()->rewind();
                    return $collSeMediaFileI18ns;
                }

                if($partial && $this->collSeMediaFileI18ns) {
                    foreach($this->collSeMediaFileI18ns as $obj) {
                        if($obj->isNew()) {
                            $collSeMediaFileI18ns[] = $obj;
                        }
                    }
                }

                $this->collSeMediaFileI18ns = $collSeMediaFileI18ns;
                $this->collSeMediaFileI18nsPartial = false;
            }
        }

        return $this->collSeMediaFileI18ns;
    }

    /**
     * Sets a collection of SeMediaFileI18n objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $seMediaFileI18ns A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function setSeMediaFileI18ns(PropelCollection $seMediaFileI18ns, PropelPDO $con = null)
    {
        $seMediaFileI18nsToDelete = $this->getSeMediaFileI18ns(new Criteria(), $con)->diff($seMediaFileI18ns);

        $this->seMediaFileI18nsScheduledForDeletion = unserialize(serialize($seMediaFileI18nsToDelete));

        foreach ($seMediaFileI18nsToDelete as $seMediaFileI18nRemoved) {
            $seMediaFileI18nRemoved->setSeMediaFile(null);
        }

        $this->collSeMediaFileI18ns = null;
        foreach ($seMediaFileI18ns as $seMediaFileI18n) {
            $this->addSeMediaFileI18n($seMediaFileI18n);
        }

        $this->collSeMediaFileI18ns = $seMediaFileI18ns;
        $this->collSeMediaFileI18nsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SeMediaFileI18n objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related SeMediaFileI18n objects.
     * @throws PropelException
     */
    public function countSeMediaFileI18ns(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collSeMediaFileI18nsPartial && !$this->isNew();
        if (null === $this->collSeMediaFileI18ns || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSeMediaFileI18ns) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getSeMediaFileI18ns());
            }
            $query = SeMediaFileI18nQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySeMediaFile($this)
                ->count($con);
        }

        return count($this->collSeMediaFileI18ns);
    }

    /**
     * Method called to associate a SeMediaFileI18n object to this object
     * through the SeMediaFileI18n foreign key attribute.
     *
     * @param    SeMediaFileI18n $l SeMediaFileI18n
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function addSeMediaFileI18n(SeMediaFileI18n $l)
    {
        if ($l && $locale = $l->getLocale()) {
            $this->setLocale($locale);
            $this->currentTranslations[$locale] = $l;
        }
        if ($this->collSeMediaFileI18ns === null) {
            $this->initSeMediaFileI18ns();
            $this->collSeMediaFileI18nsPartial = true;
        }
        if (!in_array($l, $this->collSeMediaFileI18ns->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddSeMediaFileI18n($l);
        }

        return $this;
    }

    /**
     * @param	SeMediaFileI18n $seMediaFileI18n The seMediaFileI18n object to add.
     */
    protected function doAddSeMediaFileI18n($seMediaFileI18n)
    {
        $this->collSeMediaFileI18ns[]= $seMediaFileI18n;
        $seMediaFileI18n->setSeMediaFile($this);
    }

    /**
     * @param	SeMediaFileI18n $seMediaFileI18n The seMediaFileI18n object to remove.
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function removeSeMediaFileI18n($seMediaFileI18n)
    {
        if ($this->getSeMediaFileI18ns()->contains($seMediaFileI18n)) {
            $this->collSeMediaFileI18ns->remove($this->collSeMediaFileI18ns->search($seMediaFileI18n));
            if (null === $this->seMediaFileI18nsScheduledForDeletion) {
                $this->seMediaFileI18nsScheduledForDeletion = clone $this->collSeMediaFileI18ns;
                $this->seMediaFileI18nsScheduledForDeletion->clear();
            }
            $this->seMediaFileI18nsScheduledForDeletion[]= clone $seMediaFileI18n;
            $seMediaFileI18n->setSeMediaFile(null);
        }

        return $this;
    }

    /**
     * Clears out the collActivities collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return SeMediaFile The current object (for fluent API support)
     * @see        addActivities()
     */
    public function clearActivities()
    {
        $this->collActivities = null; // important to set this to null since that means it is uninitialized
        $this->collActivitiesPartial = null;

        return $this;
    }

    /**
     * Initializes the collActivities collection.
     *
     * By default this just sets the collActivities collection to an empty collection (like clearActivities());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initActivities()
    {
        $this->collActivities = new PropelObjectCollection();
        $this->collActivities->setModel('Activity');
    }

    /**
     * Gets a collection of Activity objects related by a many-to-many relationship
     * to the current object by way of the activity_doc_lib cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this SeMediaFile is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param PropelPDO $con Optional connection object
     *
     * @return PropelObjectCollection|Activity[] List of Activity objects
     */
    public function getActivities($criteria = null, PropelPDO $con = null)
    {
        if (null === $this->collActivities || null !== $criteria) {
            if ($this->isNew() && null === $this->collActivities) {
                // return empty collection
                $this->initActivities();
            } else {
                $collActivities = ActivityQuery::create(null, $criteria)
                    ->filterBySeMediaFile($this)
                    ->find($con);
                if (null !== $criteria) {
                    return $collActivities;
                }
                $this->collActivities = $collActivities;
            }
        }

        return $this->collActivities;
    }

    /**
     * Sets a collection of Activity objects related by a many-to-many relationship
     * to the current object by way of the activity_doc_lib cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $activities A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function setActivities(PropelCollection $activities, PropelPDO $con = null)
    {
        $this->clearActivities();
        $currentActivities = $this->getActivities();

        $this->activitiesScheduledForDeletion = $currentActivities->diff($activities);

        foreach ($activities as $activity) {
            if (!$currentActivities->contains($activity)) {
                $this->doAddActivity($activity);
            }
        }

        $this->collActivities = $activities;

        return $this;
    }

    /**
     * Gets the number of Activity objects related by a many-to-many relationship
     * to the current object by way of the activity_doc_lib cross-reference table.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param boolean $distinct Set to true to force count distinct
     * @param PropelPDO $con Optional connection object
     *
     * @return int the number of related Activity objects
     */
    public function countActivities($criteria = null, $distinct = false, PropelPDO $con = null)
    {
        if (null === $this->collActivities || null !== $criteria) {
            if ($this->isNew() && null === $this->collActivities) {
                return 0;
            } else {
                $query = ActivityQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterBySeMediaFile($this)
                    ->count($con);
            }
        } else {
            return count($this->collActivities);
        }
    }

    /**
     * Associate a Activity object to this object
     * through the activity_doc_lib cross reference table.
     *
     * @param  Activity $activity The ActivityDocLib object to relate
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function addActivity(Activity $activity)
    {
        if ($this->collActivities === null) {
            $this->initActivities();
        }
        if (!$this->collActivities->contains($activity)) { // only add it if the **same** object is not already associated
            $this->doAddActivity($activity);

            $this->collActivities[]= $activity;
        }

        return $this;
    }

    /**
     * @param	Activity $activity The activity object to add.
     */
    protected function doAddActivity($activity)
    {
        $activityDocLib = new ActivityDocLib();
        $activityDocLib->setActivity($activity);
        $this->addActivityDocLib($activityDocLib);
    }

    /**
     * Remove a Activity object to this object
     * through the activity_doc_lib cross reference table.
     *
     * @param Activity $activity The ActivityDocLib object to relate
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function removeActivity(Activity $activity)
    {
        if ($this->getActivities()->contains($activity)) {
            $this->collActivities->remove($this->collActivities->search($activity));
            if (null === $this->activitiesScheduledForDeletion) {
                $this->activitiesScheduledForDeletion = clone $this->collActivities;
                $this->activitiesScheduledForDeletion->clear();
            }
            $this->activitiesScheduledForDeletion[]= $activity;
        }

        return $this;
    }

    /**
     * Clears out the collActivitySubs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return SeMediaFile The current object (for fluent API support)
     * @see        addActivitySubs()
     */
    public function clearActivitySubs()
    {
        $this->collActivitySubs = null; // important to set this to null since that means it is uninitialized
        $this->collActivitySubsPartial = null;

        return $this;
    }

    /**
     * Initializes the collActivitySubs collection.
     *
     * By default this just sets the collActivitySubs collection to an empty collection (like clearActivitySubs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initActivitySubs()
    {
        $this->collActivitySubs = new PropelObjectCollection();
        $this->collActivitySubs->setModel('ActivitySub');
    }

    /**
     * Gets a collection of ActivitySub objects related by a many-to-many relationship
     * to the current object by way of the activity_sub_doc_lib cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this SeMediaFile is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param PropelPDO $con Optional connection object
     *
     * @return PropelObjectCollection|ActivitySub[] List of ActivitySub objects
     */
    public function getActivitySubs($criteria = null, PropelPDO $con = null)
    {
        if (null === $this->collActivitySubs || null !== $criteria) {
            if ($this->isNew() && null === $this->collActivitySubs) {
                // return empty collection
                $this->initActivitySubs();
            } else {
                $collActivitySubs = ActivitySubQuery::create(null, $criteria)
                    ->filterBySeMediaFile($this)
                    ->find($con);
                if (null !== $criteria) {
                    return $collActivitySubs;
                }
                $this->collActivitySubs = $collActivitySubs;
            }
        }

        return $this->collActivitySubs;
    }

    /**
     * Sets a collection of ActivitySub objects related by a many-to-many relationship
     * to the current object by way of the activity_sub_doc_lib cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $activitySubs A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function setActivitySubs(PropelCollection $activitySubs, PropelPDO $con = null)
    {
        $this->clearActivitySubs();
        $currentActivitySubs = $this->getActivitySubs();

        $this->activitySubsScheduledForDeletion = $currentActivitySubs->diff($activitySubs);

        foreach ($activitySubs as $activitySub) {
            if (!$currentActivitySubs->contains($activitySub)) {
                $this->doAddActivitySub($activitySub);
            }
        }

        $this->collActivitySubs = $activitySubs;

        return $this;
    }

    /**
     * Gets the number of ActivitySub objects related by a many-to-many relationship
     * to the current object by way of the activity_sub_doc_lib cross-reference table.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param boolean $distinct Set to true to force count distinct
     * @param PropelPDO $con Optional connection object
     *
     * @return int the number of related ActivitySub objects
     */
    public function countActivitySubs($criteria = null, $distinct = false, PropelPDO $con = null)
    {
        if (null === $this->collActivitySubs || null !== $criteria) {
            if ($this->isNew() && null === $this->collActivitySubs) {
                return 0;
            } else {
                $query = ActivitySubQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterBySeMediaFile($this)
                    ->count($con);
            }
        } else {
            return count($this->collActivitySubs);
        }
    }

    /**
     * Associate a ActivitySub object to this object
     * through the activity_sub_doc_lib cross reference table.
     *
     * @param  ActivitySub $activitySub The ActivitySubDocLib object to relate
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function addActivitySub(ActivitySub $activitySub)
    {
        if ($this->collActivitySubs === null) {
            $this->initActivitySubs();
        }
        if (!$this->collActivitySubs->contains($activitySub)) { // only add it if the **same** object is not already associated
            $this->doAddActivitySub($activitySub);

            $this->collActivitySubs[]= $activitySub;
        }

        return $this;
    }

    /**
     * @param	ActivitySub $activitySub The activitySub object to add.
     */
    protected function doAddActivitySub($activitySub)
    {
        $activitySubDocLib = new ActivitySubDocLib();
        $activitySubDocLib->setActivitySub($activitySub);
        $this->addActivitySubDocLib($activitySubDocLib);
    }

    /**
     * Remove a ActivitySub object to this object
     * through the activity_sub_doc_lib cross reference table.
     *
     * @param ActivitySub $activitySub The ActivitySubDocLib object to relate
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function removeActivitySub(ActivitySub $activitySub)
    {
        if ($this->getActivitySubs()->contains($activitySub)) {
            $this->collActivitySubs->remove($this->collActivitySubs->search($activitySub));
            if (null === $this->activitySubsScheduledForDeletion) {
                $this->activitySubsScheduledForDeletion = clone $this->collActivitySubs;
                $this->activitySubsScheduledForDeletion->clear();
            }
            $this->activitySubsScheduledForDeletion[]= $activitySub;
        }

        return $this;
    }

    /**
     * Clears out the collActivityInserts collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return SeMediaFile The current object (for fluent API support)
     * @see        addActivityInserts()
     */
    public function clearActivityInserts()
    {
        $this->collActivityInserts = null; // important to set this to null since that means it is uninitialized
        $this->collActivityInsertsPartial = null;

        return $this;
    }

    /**
     * Initializes the collActivityInserts collection.
     *
     * By default this just sets the collActivityInserts collection to an empty collection (like clearActivityInserts());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initActivityInserts()
    {
        $this->collActivityInserts = new PropelObjectCollection();
        $this->collActivityInserts->setModel('ActivityInsert');
    }

    /**
     * Gets a collection of ActivityInsert objects related by a many-to-many relationship
     * to the current object by way of the activity_insert_doc_lib cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this SeMediaFile is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param PropelPDO $con Optional connection object
     *
     * @return PropelObjectCollection|ActivityInsert[] List of ActivityInsert objects
     */
    public function getActivityInserts($criteria = null, PropelPDO $con = null)
    {
        if (null === $this->collActivityInserts || null !== $criteria) {
            if ($this->isNew() && null === $this->collActivityInserts) {
                // return empty collection
                $this->initActivityInserts();
            } else {
                $collActivityInserts = ActivityInsertQuery::create(null, $criteria)
                    ->filterBySeMediaFile($this)
                    ->find($con);
                if (null !== $criteria) {
                    return $collActivityInserts;
                }
                $this->collActivityInserts = $collActivityInserts;
            }
        }

        return $this->collActivityInserts;
    }

    /**
     * Sets a collection of ActivityInsert objects related by a many-to-many relationship
     * to the current object by way of the activity_insert_doc_lib cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $activityInserts A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function setActivityInserts(PropelCollection $activityInserts, PropelPDO $con = null)
    {
        $this->clearActivityInserts();
        $currentActivityInserts = $this->getActivityInserts();

        $this->activityInsertsScheduledForDeletion = $currentActivityInserts->diff($activityInserts);

        foreach ($activityInserts as $activityInsert) {
            if (!$currentActivityInserts->contains($activityInsert)) {
                $this->doAddActivityInsert($activityInsert);
            }
        }

        $this->collActivityInserts = $activityInserts;

        return $this;
    }

    /**
     * Gets the number of ActivityInsert objects related by a many-to-many relationship
     * to the current object by way of the activity_insert_doc_lib cross-reference table.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param boolean $distinct Set to true to force count distinct
     * @param PropelPDO $con Optional connection object
     *
     * @return int the number of related ActivityInsert objects
     */
    public function countActivityInserts($criteria = null, $distinct = false, PropelPDO $con = null)
    {
        if (null === $this->collActivityInserts || null !== $criteria) {
            if ($this->isNew() && null === $this->collActivityInserts) {
                return 0;
            } else {
                $query = ActivityInsertQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterBySeMediaFile($this)
                    ->count($con);
            }
        } else {
            return count($this->collActivityInserts);
        }
    }

    /**
     * Associate a ActivityInsert object to this object
     * through the activity_insert_doc_lib cross reference table.
     *
     * @param  ActivityInsert $activityInsert The ActivityInsertDocLib object to relate
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function addActivityInsert(ActivityInsert $activityInsert)
    {
        if ($this->collActivityInserts === null) {
            $this->initActivityInserts();
        }
        if (!$this->collActivityInserts->contains($activityInsert)) { // only add it if the **same** object is not already associated
            $this->doAddActivityInsert($activityInsert);

            $this->collActivityInserts[]= $activityInsert;
        }

        return $this;
    }

    /**
     * @param	ActivityInsert $activityInsert The activityInsert object to add.
     */
    protected function doAddActivityInsert($activityInsert)
    {
        $activityInsertDocLib = new ActivityInsertDocLib();
        $activityInsertDocLib->setActivityInsert($activityInsert);
        $this->addActivityInsertDocLib($activityInsertDocLib);
    }

    /**
     * Remove a ActivityInsert object to this object
     * through the activity_insert_doc_lib cross reference table.
     *
     * @param ActivityInsert $activityInsert The ActivityInsertDocLib object to relate
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function removeActivityInsert(ActivityInsert $activityInsert)
    {
        if ($this->getActivityInserts()->contains($activityInsert)) {
            $this->collActivityInserts->remove($this->collActivityInserts->search($activityInsert));
            if (null === $this->activityInsertsScheduledForDeletion) {
                $this->activityInsertsScheduledForDeletion = clone $this->collActivityInserts;
                $this->activityInsertsScheduledForDeletion->clear();
            }
            $this->activityInsertsScheduledForDeletion[]= $activityInsert;
        }

        return $this;
    }

    /**
     * Clears out the collContentProfiles collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return SeMediaFile The current object (for fluent API support)
     * @see        addContentProfiles()
     */
    public function clearContentProfiles()
    {
        $this->collContentProfiles = null; // important to set this to null since that means it is uninitialized
        $this->collContentProfilesPartial = null;

        return $this;
    }

    /**
     * Initializes the collContentProfiles collection.
     *
     * By default this just sets the collContentProfiles collection to an empty collection (like clearContentProfiles());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initContentProfiles()
    {
        $this->collContentProfiles = new PropelObjectCollection();
        $this->collContentProfiles->setModel('ContentProfile');
    }

    /**
     * Gets a collection of ContentProfile objects related by a many-to-many relationship
     * to the current object by way of the content_profile_doc_lib cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this SeMediaFile is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param PropelPDO $con Optional connection object
     *
     * @return PropelObjectCollection|ContentProfile[] List of ContentProfile objects
     */
    public function getContentProfiles($criteria = null, PropelPDO $con = null)
    {
        if (null === $this->collContentProfiles || null !== $criteria) {
            if ($this->isNew() && null === $this->collContentProfiles) {
                // return empty collection
                $this->initContentProfiles();
            } else {
                $collContentProfiles = ContentProfileQuery::create(null, $criteria)
                    ->filterBySeMediaFile($this)
                    ->find($con);
                if (null !== $criteria) {
                    return $collContentProfiles;
                }
                $this->collContentProfiles = $collContentProfiles;
            }
        }

        return $this->collContentProfiles;
    }

    /**
     * Sets a collection of ContentProfile objects related by a many-to-many relationship
     * to the current object by way of the content_profile_doc_lib cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $contentProfiles A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function setContentProfiles(PropelCollection $contentProfiles, PropelPDO $con = null)
    {
        $this->clearContentProfiles();
        $currentContentProfiles = $this->getContentProfiles();

        $this->contentProfilesScheduledForDeletion = $currentContentProfiles->diff($contentProfiles);

        foreach ($contentProfiles as $contentProfile) {
            if (!$currentContentProfiles->contains($contentProfile)) {
                $this->doAddContentProfile($contentProfile);
            }
        }

        $this->collContentProfiles = $contentProfiles;

        return $this;
    }

    /**
     * Gets the number of ContentProfile objects related by a many-to-many relationship
     * to the current object by way of the content_profile_doc_lib cross-reference table.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param boolean $distinct Set to true to force count distinct
     * @param PropelPDO $con Optional connection object
     *
     * @return int the number of related ContentProfile objects
     */
    public function countContentProfiles($criteria = null, $distinct = false, PropelPDO $con = null)
    {
        if (null === $this->collContentProfiles || null !== $criteria) {
            if ($this->isNew() && null === $this->collContentProfiles) {
                return 0;
            } else {
                $query = ContentProfileQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterBySeMediaFile($this)
                    ->count($con);
            }
        } else {
            return count($this->collContentProfiles);
        }
    }

    /**
     * Associate a ContentProfile object to this object
     * through the content_profile_doc_lib cross reference table.
     *
     * @param  ContentProfile $contentProfile The ContentProfileDocLib object to relate
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function addContentProfile(ContentProfile $contentProfile)
    {
        if ($this->collContentProfiles === null) {
            $this->initContentProfiles();
        }
        if (!$this->collContentProfiles->contains($contentProfile)) { // only add it if the **same** object is not already associated
            $this->doAddContentProfile($contentProfile);

            $this->collContentProfiles[]= $contentProfile;
        }

        return $this;
    }

    /**
     * @param	ContentProfile $contentProfile The contentProfile object to add.
     */
    protected function doAddContentProfile($contentProfile)
    {
        $contentProfileDocLib = new ContentProfileDocLib();
        $contentProfileDocLib->setContentProfile($contentProfile);
        $this->addContentProfileDocLib($contentProfileDocLib);
    }

    /**
     * Remove a ContentProfile object to this object
     * through the content_profile_doc_lib cross reference table.
     *
     * @param ContentProfile $contentProfile The ContentProfileDocLib object to relate
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function removeContentProfile(ContentProfile $contentProfile)
    {
        if ($this->getContentProfiles()->contains($contentProfile)) {
            $this->collContentProfiles->remove($this->collContentProfiles->search($contentProfile));
            if (null === $this->contentProfilesScheduledForDeletion) {
                $this->contentProfilesScheduledForDeletion = clone $this->collContentProfiles;
                $this->contentProfilesScheduledForDeletion->clear();
            }
            $this->contentProfilesScheduledForDeletion[]= $contentProfile;
        }

        return $this;
    }

    /**
     * Clears out the collContentWishes collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return SeMediaFile The current object (for fluent API support)
     * @see        addContentWishes()
     */
    public function clearContentWishes()
    {
        $this->collContentWishes = null; // important to set this to null since that means it is uninitialized
        $this->collContentWishesPartial = null;

        return $this;
    }

    /**
     * Initializes the collContentWishes collection.
     *
     * By default this just sets the collContentWishes collection to an empty collection (like clearContentWishes());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initContentWishes()
    {
        $this->collContentWishes = new PropelObjectCollection();
        $this->collContentWishes->setModel('ContentWish');
    }

    /**
     * Gets a collection of ContentWish objects related by a many-to-many relationship
     * to the current object by way of the content_wish_doc_lib cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this SeMediaFile is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param PropelPDO $con Optional connection object
     *
     * @return PropelObjectCollection|ContentWish[] List of ContentWish objects
     */
    public function getContentWishes($criteria = null, PropelPDO $con = null)
    {
        if (null === $this->collContentWishes || null !== $criteria) {
            if ($this->isNew() && null === $this->collContentWishes) {
                // return empty collection
                $this->initContentWishes();
            } else {
                $collContentWishes = ContentWishQuery::create(null, $criteria)
                    ->filterBySeMediaFile($this)
                    ->find($con);
                if (null !== $criteria) {
                    return $collContentWishes;
                }
                $this->collContentWishes = $collContentWishes;
            }
        }

        return $this->collContentWishes;
    }

    /**
     * Sets a collection of ContentWish objects related by a many-to-many relationship
     * to the current object by way of the content_wish_doc_lib cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $contentWishes A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function setContentWishes(PropelCollection $contentWishes, PropelPDO $con = null)
    {
        $this->clearContentWishes();
        $currentContentWishes = $this->getContentWishes();

        $this->contentWishesScheduledForDeletion = $currentContentWishes->diff($contentWishes);

        foreach ($contentWishes as $contentWish) {
            if (!$currentContentWishes->contains($contentWish)) {
                $this->doAddContentWish($contentWish);
            }
        }

        $this->collContentWishes = $contentWishes;

        return $this;
    }

    /**
     * Gets the number of ContentWish objects related by a many-to-many relationship
     * to the current object by way of the content_wish_doc_lib cross-reference table.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param boolean $distinct Set to true to force count distinct
     * @param PropelPDO $con Optional connection object
     *
     * @return int the number of related ContentWish objects
     */
    public function countContentWishes($criteria = null, $distinct = false, PropelPDO $con = null)
    {
        if (null === $this->collContentWishes || null !== $criteria) {
            if ($this->isNew() && null === $this->collContentWishes) {
                return 0;
            } else {
                $query = ContentWishQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterBySeMediaFile($this)
                    ->count($con);
            }
        } else {
            return count($this->collContentWishes);
        }
    }

    /**
     * Associate a ContentWish object to this object
     * through the content_wish_doc_lib cross reference table.
     *
     * @param  ContentWish $contentWish The ContentWishDocLib object to relate
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function addContentWish(ContentWish $contentWish)
    {
        if ($this->collContentWishes === null) {
            $this->initContentWishes();
        }
        if (!$this->collContentWishes->contains($contentWish)) { // only add it if the **same** object is not already associated
            $this->doAddContentWish($contentWish);

            $this->collContentWishes[]= $contentWish;
        }

        return $this;
    }

    /**
     * @param	ContentWish $contentWish The contentWish object to add.
     */
    protected function doAddContentWish($contentWish)
    {
        $contentWishDocLib = new ContentWishDocLib();
        $contentWishDocLib->setContentWish($contentWish);
        $this->addContentWishDocLib($contentWishDocLib);
    }

    /**
     * Remove a ContentWish object to this object
     * through the content_wish_doc_lib cross reference table.
     *
     * @param ContentWish $contentWish The ContentWishDocLib object to relate
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function removeContentWish(ContentWish $contentWish)
    {
        if ($this->getContentWishes()->contains($contentWish)) {
            $this->collContentWishes->remove($this->collContentWishes->search($contentWish));
            if (null === $this->contentWishesScheduledForDeletion) {
                $this->contentWishesScheduledForDeletion = clone $this->collContentWishes;
                $this->contentWishesScheduledForDeletion->clear();
            }
            $this->contentWishesScheduledForDeletion[]= $contentWish;
        }

        return $this;
    }

    /**
     * Clears out the collContentNewss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return SeMediaFile The current object (for fluent API support)
     * @see        addContentNewss()
     */
    public function clearContentNewss()
    {
        $this->collContentNewss = null; // important to set this to null since that means it is uninitialized
        $this->collContentNewssPartial = null;

        return $this;
    }

    /**
     * Initializes the collContentNewss collection.
     *
     * By default this just sets the collContentNewss collection to an empty collection (like clearContentNewss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initContentNewss()
    {
        $this->collContentNewss = new PropelObjectCollection();
        $this->collContentNewss->setModel('ContentNews');
    }

    /**
     * Gets a collection of ContentNews objects related by a many-to-many relationship
     * to the current object by way of the content_news_doc_lib cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this SeMediaFile is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param PropelPDO $con Optional connection object
     *
     * @return PropelObjectCollection|ContentNews[] List of ContentNews objects
     */
    public function getContentNewss($criteria = null, PropelPDO $con = null)
    {
        if (null === $this->collContentNewss || null !== $criteria) {
            if ($this->isNew() && null === $this->collContentNewss) {
                // return empty collection
                $this->initContentNewss();
            } else {
                $collContentNewss = ContentNewsQuery::create(null, $criteria)
                    ->filterBySeMediaFile($this)
                    ->find($con);
                if (null !== $criteria) {
                    return $collContentNewss;
                }
                $this->collContentNewss = $collContentNewss;
            }
        }

        return $this->collContentNewss;
    }

    /**
     * Sets a collection of ContentNews objects related by a many-to-many relationship
     * to the current object by way of the content_news_doc_lib cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $contentNewss A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function setContentNewss(PropelCollection $contentNewss, PropelPDO $con = null)
    {
        $this->clearContentNewss();
        $currentContentNewss = $this->getContentNewss();

        $this->contentNewssScheduledForDeletion = $currentContentNewss->diff($contentNewss);

        foreach ($contentNewss as $contentNews) {
            if (!$currentContentNewss->contains($contentNews)) {
                $this->doAddContentNews($contentNews);
            }
        }

        $this->collContentNewss = $contentNewss;

        return $this;
    }

    /**
     * Gets the number of ContentNews objects related by a many-to-many relationship
     * to the current object by way of the content_news_doc_lib cross-reference table.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param boolean $distinct Set to true to force count distinct
     * @param PropelPDO $con Optional connection object
     *
     * @return int the number of related ContentNews objects
     */
    public function countContentNewss($criteria = null, $distinct = false, PropelPDO $con = null)
    {
        if (null === $this->collContentNewss || null !== $criteria) {
            if ($this->isNew() && null === $this->collContentNewss) {
                return 0;
            } else {
                $query = ContentNewsQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterBySeMediaFile($this)
                    ->count($con);
            }
        } else {
            return count($this->collContentNewss);
        }
    }

    /**
     * Associate a ContentNews object to this object
     * through the content_news_doc_lib cross reference table.
     *
     * @param  ContentNews $contentNews The ContentNewsDocLib object to relate
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function addContentNews(ContentNews $contentNews)
    {
        if ($this->collContentNewss === null) {
            $this->initContentNewss();
        }
        if (!$this->collContentNewss->contains($contentNews)) { // only add it if the **same** object is not already associated
            $this->doAddContentNews($contentNews);

            $this->collContentNewss[]= $contentNews;
        }

        return $this;
    }

    /**
     * @param	ContentNews $contentNews The contentNews object to add.
     */
    protected function doAddContentNews($contentNews)
    {
        $contentNewsDocLib = new ContentNewsDocLib();
        $contentNewsDocLib->setContentNews($contentNews);
        $this->addContentNewsDocLib($contentNewsDocLib);
    }

    /**
     * Remove a ContentNews object to this object
     * through the content_news_doc_lib cross reference table.
     *
     * @param ContentNews $contentNews The ContentNewsDocLib object to relate
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function removeContentNews(ContentNews $contentNews)
    {
        if ($this->getContentNewss()->contains($contentNews)) {
            $this->collContentNewss->remove($this->collContentNewss->search($contentNews));
            if (null === $this->contentNewssScheduledForDeletion) {
                $this->contentNewssScheduledForDeletion = clone $this->collContentNewss;
                $this->contentNewssScheduledForDeletion->clear();
            }
            $this->contentNewssScheduledForDeletion[]= $contentNews;
        }

        return $this;
    }

    /**
     * Clears out the collContentGenerics collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return SeMediaFile The current object (for fluent API support)
     * @see        addContentGenerics()
     */
    public function clearContentGenerics()
    {
        $this->collContentGenerics = null; // important to set this to null since that means it is uninitialized
        $this->collContentGenericsPartial = null;

        return $this;
    }

    /**
     * Initializes the collContentGenerics collection.
     *
     * By default this just sets the collContentGenerics collection to an empty collection (like clearContentGenerics());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initContentGenerics()
    {
        $this->collContentGenerics = new PropelObjectCollection();
        $this->collContentGenerics->setModel('ContentGeneric');
    }

    /**
     * Gets a collection of ContentGeneric objects related by a many-to-many relationship
     * to the current object by way of the content_generic_doc_lib cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this SeMediaFile is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param PropelPDO $con Optional connection object
     *
     * @return PropelObjectCollection|ContentGeneric[] List of ContentGeneric objects
     */
    public function getContentGenerics($criteria = null, PropelPDO $con = null)
    {
        if (null === $this->collContentGenerics || null !== $criteria) {
            if ($this->isNew() && null === $this->collContentGenerics) {
                // return empty collection
                $this->initContentGenerics();
            } else {
                $collContentGenerics = ContentGenericQuery::create(null, $criteria)
                    ->filterBySeMediaFile($this)
                    ->find($con);
                if (null !== $criteria) {
                    return $collContentGenerics;
                }
                $this->collContentGenerics = $collContentGenerics;
            }
        }

        return $this->collContentGenerics;
    }

    /**
     * Sets a collection of ContentGeneric objects related by a many-to-many relationship
     * to the current object by way of the content_generic_doc_lib cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $contentGenerics A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function setContentGenerics(PropelCollection $contentGenerics, PropelPDO $con = null)
    {
        $this->clearContentGenerics();
        $currentContentGenerics = $this->getContentGenerics();

        $this->contentGenericsScheduledForDeletion = $currentContentGenerics->diff($contentGenerics);

        foreach ($contentGenerics as $contentGeneric) {
            if (!$currentContentGenerics->contains($contentGeneric)) {
                $this->doAddContentGeneric($contentGeneric);
            }
        }

        $this->collContentGenerics = $contentGenerics;

        return $this;
    }

    /**
     * Gets the number of ContentGeneric objects related by a many-to-many relationship
     * to the current object by way of the content_generic_doc_lib cross-reference table.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param boolean $distinct Set to true to force count distinct
     * @param PropelPDO $con Optional connection object
     *
     * @return int the number of related ContentGeneric objects
     */
    public function countContentGenerics($criteria = null, $distinct = false, PropelPDO $con = null)
    {
        if (null === $this->collContentGenerics || null !== $criteria) {
            if ($this->isNew() && null === $this->collContentGenerics) {
                return 0;
            } else {
                $query = ContentGenericQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterBySeMediaFile($this)
                    ->count($con);
            }
        } else {
            return count($this->collContentGenerics);
        }
    }

    /**
     * Associate a ContentGeneric object to this object
     * through the content_generic_doc_lib cross reference table.
     *
     * @param  ContentGeneric $contentGeneric The ContentGenericDocLib object to relate
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function addContentGeneric(ContentGeneric $contentGeneric)
    {
        if ($this->collContentGenerics === null) {
            $this->initContentGenerics();
        }
        if (!$this->collContentGenerics->contains($contentGeneric)) { // only add it if the **same** object is not already associated
            $this->doAddContentGeneric($contentGeneric);

            $this->collContentGenerics[]= $contentGeneric;
        }

        return $this;
    }

    /**
     * @param	ContentGeneric $contentGeneric The contentGeneric object to add.
     */
    protected function doAddContentGeneric($contentGeneric)
    {
        $contentGenericDocLib = new ContentGenericDocLib();
        $contentGenericDocLib->setContentGeneric($contentGeneric);
        $this->addContentGenericDocLib($contentGenericDocLib);
    }

    /**
     * Remove a ContentGeneric object to this object
     * through the content_generic_doc_lib cross reference table.
     *
     * @param ContentGeneric $contentGeneric The ContentGenericDocLib object to relate
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function removeContentGeneric(ContentGeneric $contentGeneric)
    {
        if ($this->getContentGenerics()->contains($contentGeneric)) {
            $this->collContentGenerics->remove($this->collContentGenerics->search($contentGeneric));
            if (null === $this->contentGenericsScheduledForDeletion) {
                $this->contentGenericsScheduledForDeletion = clone $this->collContentGenerics;
                $this->contentGenericsScheduledForDeletion->clear();
            }
            $this->contentGenericsScheduledForDeletion[]= $contentGeneric;
        }

        return $this;
    }

    /**
     * Clears out the collContentOffers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return SeMediaFile The current object (for fluent API support)
     * @see        addContentOffers()
     */
    public function clearContentOffers()
    {
        $this->collContentOffers = null; // important to set this to null since that means it is uninitialized
        $this->collContentOffersPartial = null;

        return $this;
    }

    /**
     * Initializes the collContentOffers collection.
     *
     * By default this just sets the collContentOffers collection to an empty collection (like clearContentOffers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initContentOffers()
    {
        $this->collContentOffers = new PropelObjectCollection();
        $this->collContentOffers->setModel('ContentOffer');
    }

    /**
     * Gets a collection of ContentOffer objects related by a many-to-many relationship
     * to the current object by way of the content_offer_doc_lib cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this SeMediaFile is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param PropelPDO $con Optional connection object
     *
     * @return PropelObjectCollection|ContentOffer[] List of ContentOffer objects
     */
    public function getContentOffers($criteria = null, PropelPDO $con = null)
    {
        if (null === $this->collContentOffers || null !== $criteria) {
            if ($this->isNew() && null === $this->collContentOffers) {
                // return empty collection
                $this->initContentOffers();
            } else {
                $collContentOffers = ContentOfferQuery::create(null, $criteria)
                    ->filterBySeMediaFile($this)
                    ->find($con);
                if (null !== $criteria) {
                    return $collContentOffers;
                }
                $this->collContentOffers = $collContentOffers;
            }
        }

        return $this->collContentOffers;
    }

    /**
     * Sets a collection of ContentOffer objects related by a many-to-many relationship
     * to the current object by way of the content_offer_doc_lib cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $contentOffers A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function setContentOffers(PropelCollection $contentOffers, PropelPDO $con = null)
    {
        $this->clearContentOffers();
        $currentContentOffers = $this->getContentOffers();

        $this->contentOffersScheduledForDeletion = $currentContentOffers->diff($contentOffers);

        foreach ($contentOffers as $contentOffer) {
            if (!$currentContentOffers->contains($contentOffer)) {
                $this->doAddContentOffer($contentOffer);
            }
        }

        $this->collContentOffers = $contentOffers;

        return $this;
    }

    /**
     * Gets the number of ContentOffer objects related by a many-to-many relationship
     * to the current object by way of the content_offer_doc_lib cross-reference table.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param boolean $distinct Set to true to force count distinct
     * @param PropelPDO $con Optional connection object
     *
     * @return int the number of related ContentOffer objects
     */
    public function countContentOffers($criteria = null, $distinct = false, PropelPDO $con = null)
    {
        if (null === $this->collContentOffers || null !== $criteria) {
            if ($this->isNew() && null === $this->collContentOffers) {
                return 0;
            } else {
                $query = ContentOfferQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterBySeMediaFile($this)
                    ->count($con);
            }
        } else {
            return count($this->collContentOffers);
        }
    }

    /**
     * Associate a ContentOffer object to this object
     * through the content_offer_doc_lib cross reference table.
     *
     * @param  ContentOffer $contentOffer The ContentOfferDocLib object to relate
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function addContentOffer(ContentOffer $contentOffer)
    {
        if ($this->collContentOffers === null) {
            $this->initContentOffers();
        }
        if (!$this->collContentOffers->contains($contentOffer)) { // only add it if the **same** object is not already associated
            $this->doAddContentOffer($contentOffer);

            $this->collContentOffers[]= $contentOffer;
        }

        return $this;
    }

    /**
     * @param	ContentOffer $contentOffer The contentOffer object to add.
     */
    protected function doAddContentOffer($contentOffer)
    {
        $contentOfferDocLib = new ContentOfferDocLib();
        $contentOfferDocLib->setContentOffer($contentOffer);
        $this->addContentOfferDocLib($contentOfferDocLib);
    }

    /**
     * Remove a ContentOffer object to this object
     * through the content_offer_doc_lib cross reference table.
     *
     * @param ContentOffer $contentOffer The ContentOfferDocLib object to relate
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function removeContentOffer(ContentOffer $contentOffer)
    {
        if ($this->getContentOffers()->contains($contentOffer)) {
            $this->collContentOffers->remove($this->collContentOffers->search($contentOffer));
            if (null === $this->contentOffersScheduledForDeletion) {
                $this->contentOffersScheduledForDeletion = clone $this->collContentOffers;
                $this->contentOffersScheduledForDeletion->clear();
            }
            $this->contentOffersScheduledForDeletion[]= $contentOffer;
        }

        return $this;
    }

    /**
     * Clears out the collContentStays collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return SeMediaFile The current object (for fluent API support)
     * @see        addContentStays()
     */
    public function clearContentStays()
    {
        $this->collContentStays = null; // important to set this to null since that means it is uninitialized
        $this->collContentStaysPartial = null;

        return $this;
    }

    /**
     * Initializes the collContentStays collection.
     *
     * By default this just sets the collContentStays collection to an empty collection (like clearContentStays());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initContentStays()
    {
        $this->collContentStays = new PropelObjectCollection();
        $this->collContentStays->setModel('ContentStay');
    }

    /**
     * Gets a collection of ContentStay objects related by a many-to-many relationship
     * to the current object by way of the content_stay_doc_lib cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this SeMediaFile is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param PropelPDO $con Optional connection object
     *
     * @return PropelObjectCollection|ContentStay[] List of ContentStay objects
     */
    public function getContentStays($criteria = null, PropelPDO $con = null)
    {
        if (null === $this->collContentStays || null !== $criteria) {
            if ($this->isNew() && null === $this->collContentStays) {
                // return empty collection
                $this->initContentStays();
            } else {
                $collContentStays = ContentStayQuery::create(null, $criteria)
                    ->filterBySeMediaFile($this)
                    ->find($con);
                if (null !== $criteria) {
                    return $collContentStays;
                }
                $this->collContentStays = $collContentStays;
            }
        }

        return $this->collContentStays;
    }

    /**
     * Sets a collection of ContentStay objects related by a many-to-many relationship
     * to the current object by way of the content_stay_doc_lib cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $contentStays A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function setContentStays(PropelCollection $contentStays, PropelPDO $con = null)
    {
        $this->clearContentStays();
        $currentContentStays = $this->getContentStays();

        $this->contentStaysScheduledForDeletion = $currentContentStays->diff($contentStays);

        foreach ($contentStays as $contentStay) {
            if (!$currentContentStays->contains($contentStay)) {
                $this->doAddContentStay($contentStay);
            }
        }

        $this->collContentStays = $contentStays;

        return $this;
    }

    /**
     * Gets the number of ContentStay objects related by a many-to-many relationship
     * to the current object by way of the content_stay_doc_lib cross-reference table.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param boolean $distinct Set to true to force count distinct
     * @param PropelPDO $con Optional connection object
     *
     * @return int the number of related ContentStay objects
     */
    public function countContentStays($criteria = null, $distinct = false, PropelPDO $con = null)
    {
        if (null === $this->collContentStays || null !== $criteria) {
            if ($this->isNew() && null === $this->collContentStays) {
                return 0;
            } else {
                $query = ContentStayQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterBySeMediaFile($this)
                    ->count($con);
            }
        } else {
            return count($this->collContentStays);
        }
    }

    /**
     * Associate a ContentStay object to this object
     * through the content_stay_doc_lib cross reference table.
     *
     * @param  ContentStay $contentStay The ContentStayDocLib object to relate
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function addContentStay(ContentStay $contentStay)
    {
        if ($this->collContentStays === null) {
            $this->initContentStays();
        }
        if (!$this->collContentStays->contains($contentStay)) { // only add it if the **same** object is not already associated
            $this->doAddContentStay($contentStay);

            $this->collContentStays[]= $contentStay;
        }

        return $this;
    }

    /**
     * @param	ContentStay $contentStay The contentStay object to add.
     */
    protected function doAddContentStay($contentStay)
    {
        $contentStayDocLib = new ContentStayDocLib();
        $contentStayDocLib->setContentStay($contentStay);
        $this->addContentStayDocLib($contentStayDocLib);
    }

    /**
     * Remove a ContentStay object to this object
     * through the content_stay_doc_lib cross reference table.
     *
     * @param ContentStay $contentStay The ContentStayDocLib object to relate
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function removeContentStay(ContentStay $contentStay)
    {
        if ($this->getContentStays()->contains($contentStay)) {
            $this->collContentStays->remove($this->collContentStays->search($contentStay));
            if (null === $this->contentStaysScheduledForDeletion) {
                $this->contentStaysScheduledForDeletion = clone $this->collContentStays;
                $this->contentStaysScheduledForDeletion->clear();
            }
            $this->contentStaysScheduledForDeletion[]= $contentStay;
        }

        return $this;
    }

    /**
     * Clears out the collSeMediaObjects collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return SeMediaFile The current object (for fluent API support)
     * @see        addSeMediaObjects()
     */
    public function clearSeMediaObjects()
    {
        $this->collSeMediaObjects = null; // important to set this to null since that means it is uninitialized
        $this->collSeMediaObjectsPartial = null;

        return $this;
    }

    /**
     * Initializes the collSeMediaObjects collection.
     *
     * By default this just sets the collSeMediaObjects collection to an empty collection (like clearSeMediaObjects());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initSeMediaObjects()
    {
        $this->collSeMediaObjects = new PropelObjectCollection();
        $this->collSeMediaObjects->setModel('SeMediaObject');
    }

    /**
     * Gets a collection of SeMediaObject objects related by a many-to-many relationship
     * to the current object by way of the se_object_has_file cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this SeMediaFile is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param PropelPDO $con Optional connection object
     *
     * @return PropelObjectCollection|SeMediaObject[] List of SeMediaObject objects
     */
    public function getSeMediaObjects($criteria = null, PropelPDO $con = null)
    {
        if (null === $this->collSeMediaObjects || null !== $criteria) {
            if ($this->isNew() && null === $this->collSeMediaObjects) {
                // return empty collection
                $this->initSeMediaObjects();
            } else {
                $collSeMediaObjects = SeMediaObjectQuery::create(null, $criteria)
                    ->filterBySeMediaFile($this)
                    ->find($con);
                if (null !== $criteria) {
                    return $collSeMediaObjects;
                }
                $this->collSeMediaObjects = $collSeMediaObjects;
            }
        }

        return $this->collSeMediaObjects;
    }

    /**
     * Sets a collection of SeMediaObject objects related by a many-to-many relationship
     * to the current object by way of the se_object_has_file cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $seMediaObjects A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function setSeMediaObjects(PropelCollection $seMediaObjects, PropelPDO $con = null)
    {
        $this->clearSeMediaObjects();
        $currentSeMediaObjects = $this->getSeMediaObjects();

        $this->seMediaObjectsScheduledForDeletion = $currentSeMediaObjects->diff($seMediaObjects);

        foreach ($seMediaObjects as $seMediaObject) {
            if (!$currentSeMediaObjects->contains($seMediaObject)) {
                $this->doAddSeMediaObject($seMediaObject);
            }
        }

        $this->collSeMediaObjects = $seMediaObjects;

        return $this;
    }

    /**
     * Gets the number of SeMediaObject objects related by a many-to-many relationship
     * to the current object by way of the se_object_has_file cross-reference table.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param boolean $distinct Set to true to force count distinct
     * @param PropelPDO $con Optional connection object
     *
     * @return int the number of related SeMediaObject objects
     */
    public function countSeMediaObjects($criteria = null, $distinct = false, PropelPDO $con = null)
    {
        if (null === $this->collSeMediaObjects || null !== $criteria) {
            if ($this->isNew() && null === $this->collSeMediaObjects) {
                return 0;
            } else {
                $query = SeMediaObjectQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterBySeMediaFile($this)
                    ->count($con);
            }
        } else {
            return count($this->collSeMediaObjects);
        }
    }

    /**
     * Associate a SeMediaObject object to this object
     * through the se_object_has_file cross reference table.
     *
     * @param  SeMediaObject $seMediaObject The SeObjectHasFile object to relate
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function addSeMediaObject(SeMediaObject $seMediaObject)
    {
        if ($this->collSeMediaObjects === null) {
            $this->initSeMediaObjects();
        }
        if (!$this->collSeMediaObjects->contains($seMediaObject)) { // only add it if the **same** object is not already associated
            $this->doAddSeMediaObject($seMediaObject);

            $this->collSeMediaObjects[]= $seMediaObject;
        }

        return $this;
    }

    /**
     * @param	SeMediaObject $seMediaObject The seMediaObject object to add.
     */
    protected function doAddSeMediaObject($seMediaObject)
    {
        $seObjectHasFile = new SeObjectHasFile();
        $seObjectHasFile->setSeMediaObject($seMediaObject);
        $this->addSeObjectHasFile($seObjectHasFile);
    }

    /**
     * Remove a SeMediaObject object to this object
     * through the se_object_has_file cross reference table.
     *
     * @param SeMediaObject $seMediaObject The SeObjectHasFile object to relate
     * @return SeMediaFile The current object (for fluent API support)
     */
    public function removeSeMediaObject(SeMediaObject $seMediaObject)
    {
        if ($this->getSeMediaObjects()->contains($seMediaObject)) {
            $this->collSeMediaObjects->remove($this->collSeMediaObjects->search($seMediaObject));
            if (null === $this->seMediaObjectsScheduledForDeletion) {
                $this->seMediaObjectsScheduledForDeletion = clone $this->collSeMediaObjects;
                $this->seMediaObjectsScheduledForDeletion->clear();
            }
            $this->seMediaObjectsScheduledForDeletion[]= $seMediaObject;
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->category_id = null;
        $this->name = null;
        $this->extension = null;
        $this->type = null;
        $this->mime_type = null;
        $this->size = null;
        $this->height = null;
        $this->width = null;
        $this->created_at = null;
        $this->updated_at = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->alreadyInClearAllReferencesDeep = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volumne/high-memory operations.
     *
     * @param boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep && !$this->alreadyInClearAllReferencesDeep) {
            $this->alreadyInClearAllReferencesDeep = true;
            if ($this->collActivityDocLibs) {
                foreach ($this->collActivityDocLibs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collActivitySubDocLibs) {
                foreach ($this->collActivitySubDocLibs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collActivityInsertDocLibs) {
                foreach ($this->collActivityInsertDocLibs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collContentProfileDocLibs) {
                foreach ($this->collContentProfileDocLibs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collContentWishDocLibs) {
                foreach ($this->collContentWishDocLibs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collContentNewsDocLibs) {
                foreach ($this->collContentNewsDocLibs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collContentGenericDocLibs) {
                foreach ($this->collContentGenericDocLibs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collContentOfferDocLibs) {
                foreach ($this->collContentOfferDocLibs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collContentStayDocLibs) {
                foreach ($this->collContentStayDocLibs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSeObjectHasFiles) {
                foreach ($this->collSeObjectHasFiles as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSeMediaFileI18ns) {
                foreach ($this->collSeMediaFileI18ns as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collActivities) {
                foreach ($this->collActivities as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collActivitySubs) {
                foreach ($this->collActivitySubs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collActivityInserts) {
                foreach ($this->collActivityInserts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collContentProfiles) {
                foreach ($this->collContentProfiles as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collContentWishes) {
                foreach ($this->collContentWishes as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collContentNewss) {
                foreach ($this->collContentNewss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collContentGenerics) {
                foreach ($this->collContentGenerics as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collContentOffers) {
                foreach ($this->collContentOffers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collContentStays) {
                foreach ($this->collContentStays as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSeMediaObjects) {
                foreach ($this->collSeMediaObjects as $o) {
                    $o->clearAllReferences($deep);
                }
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        // i18n behavior
        $this->currentLocale = 'fr_FR';
        $this->currentTranslations = null;

        if ($this->collActivityDocLibs instanceof PropelCollection) {
            $this->collActivityDocLibs->clearIterator();
        }
        $this->collActivityDocLibs = null;
        if ($this->collActivitySubDocLibs instanceof PropelCollection) {
            $this->collActivitySubDocLibs->clearIterator();
        }
        $this->collActivitySubDocLibs = null;
        if ($this->collActivityInsertDocLibs instanceof PropelCollection) {
            $this->collActivityInsertDocLibs->clearIterator();
        }
        $this->collActivityInsertDocLibs = null;
        if ($this->collContentProfileDocLibs instanceof PropelCollection) {
            $this->collContentProfileDocLibs->clearIterator();
        }
        $this->collContentProfileDocLibs = null;
        if ($this->collContentWishDocLibs instanceof PropelCollection) {
            $this->collContentWishDocLibs->clearIterator();
        }
        $this->collContentWishDocLibs = null;
        if ($this->collContentNewsDocLibs instanceof PropelCollection) {
            $this->collContentNewsDocLibs->clearIterator();
        }
        $this->collContentNewsDocLibs = null;
        if ($this->collContentGenericDocLibs instanceof PropelCollection) {
            $this->collContentGenericDocLibs->clearIterator();
        }
        $this->collContentGenericDocLibs = null;
        if ($this->collContentOfferDocLibs instanceof PropelCollection) {
            $this->collContentOfferDocLibs->clearIterator();
        }
        $this->collContentOfferDocLibs = null;
        if ($this->collContentStayDocLibs instanceof PropelCollection) {
            $this->collContentStayDocLibs->clearIterator();
        }
        $this->collContentStayDocLibs = null;
        if ($this->collSeObjectHasFiles instanceof PropelCollection) {
            $this->collSeObjectHasFiles->clearIterator();
        }
        $this->collSeObjectHasFiles = null;
        if ($this->collSeMediaFileI18ns instanceof PropelCollection) {
            $this->collSeMediaFileI18ns->clearIterator();
        }
        $this->collSeMediaFileI18ns = null;
        if ($this->collActivities instanceof PropelCollection) {
            $this->collActivities->clearIterator();
        }
        $this->collActivities = null;
        if ($this->collActivitySubs instanceof PropelCollection) {
            $this->collActivitySubs->clearIterator();
        }
        $this->collActivitySubs = null;
        if ($this->collActivityInserts instanceof PropelCollection) {
            $this->collActivityInserts->clearIterator();
        }
        $this->collActivityInserts = null;
        if ($this->collContentProfiles instanceof PropelCollection) {
            $this->collContentProfiles->clearIterator();
        }
        $this->collContentProfiles = null;
        if ($this->collContentWishes instanceof PropelCollection) {
            $this->collContentWishes->clearIterator();
        }
        $this->collContentWishes = null;
        if ($this->collContentNewss instanceof PropelCollection) {
            $this->collContentNewss->clearIterator();
        }
        $this->collContentNewss = null;
        if ($this->collContentGenerics instanceof PropelCollection) {
            $this->collContentGenerics->clearIterator();
        }
        $this->collContentGenerics = null;
        if ($this->collContentOffers instanceof PropelCollection) {
            $this->collContentOffers->clearIterator();
        }
        $this->collContentOffers = null;
        if ($this->collContentStays instanceof PropelCollection) {
            $this->collContentStays->clearIterator();
        }
        $this->collContentStays = null;
        if ($this->collSeMediaObjects instanceof PropelCollection) {
            $this->collSeMediaObjects->clearIterator();
        }
        $this->collSeMediaObjects = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(SeMediaFilePeer::DEFAULT_STRING_FORMAT);
    }

    /**
     * return true is the object is in saving state
     *
     * @return boolean
     */
    public function isAlreadyInSave()
    {
        return $this->alreadyInSave;
    }

    // i18n behavior

    /**
     * Sets the locale for translations
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     *
     * @return    SeMediaFile The current object (for fluent API support)
     */
    public function setLocale($locale = 'fr_FR')
    {
        $this->currentLocale = $locale;

        return $this;
    }

    /**
     * Gets the locale for translations
     *
     * @return    string $locale Locale to use for the translation, e.g. 'fr_FR'
     */
    public function getLocale()
    {
        return $this->currentLocale;
    }

    /**
     * Returns the current translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     PropelPDO $con an optional connection object
     *
     * @return SeMediaFileI18n */
    public function getTranslation($locale = 'fr_FR', PropelPDO $con = null)
    {
        if (!isset($this->currentTranslations[$locale])) {
            if (null !== $this->collSeMediaFileI18ns) {
                foreach ($this->collSeMediaFileI18ns as $translation) {
                    if ($translation->getLocale() == $locale) {
                        $this->currentTranslations[$locale] = $translation;

                        return $translation;
                    }
                }
            }
            if ($this->isNew()) {
                $translation = new SeMediaFileI18n();
                $translation->setLocale($locale);
            } else {
                $translation = SeMediaFileI18nQuery::create()
                    ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                    ->findOneOrCreate($con);
                $this->currentTranslations[$locale] = $translation;
            }
            $this->addSeMediaFileI18n($translation);
        }

        return $this->currentTranslations[$locale];
    }

    /**
     * Remove the translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     PropelPDO $con an optional connection object
     *
     * @return    SeMediaFile The current object (for fluent API support)
     */
    public function removeTranslation($locale = 'fr_FR', PropelPDO $con = null)
    {
        if (!$this->isNew()) {
            SeMediaFileI18nQuery::create()
                ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                ->delete($con);
        }
        if (isset($this->currentTranslations[$locale])) {
            unset($this->currentTranslations[$locale]);
        }
        foreach ($this->collSeMediaFileI18ns as $key => $translation) {
            if ($translation->getLocale() == $locale) {
                unset($this->collSeMediaFileI18ns[$key]);
                break;
            }
        }

        return $this;
    }

    /**
     * Returns the current translation
     *
     * @param     PropelPDO $con an optional connection object
     *
     * @return SeMediaFileI18n */
    public function getCurrentTranslation(PropelPDO $con = null)
    {
        return $this->getTranslation($this->getLocale(), $con);
    }


        /**
         * Get the [title] column value.
         *
         * @return string
         */
        public function getTitle()
        {
        return $this->getCurrentTranslation()->getTitle();
    }


        /**
         * Set the value of [title] column.
         *
         * @param string $v new value
         * @return SeMediaFileI18n The current object (for fluent API support)
         */
        public function setTitle($v)
        {    $this->getCurrentTranslation()->setTitle($v);

        return $this;
    }


        /**
         * Get the [description] column value.
         *
         * @return string
         */
        public function getDescription()
        {
        return $this->getCurrentTranslation()->getDescription();
    }


        /**
         * Set the value of [description] column.
         *
         * @param string $v new value
         * @return SeMediaFileI18n The current object (for fluent API support)
         */
        public function setDescription($v)
        {    $this->getCurrentTranslation()->setDescription($v);

        return $this;
    }


        /**
         * Get the [copyright] column value.
         *
         * @return string
         */
        public function getCopyright()
        {
        return $this->getCurrentTranslation()->getCopyright();
    }


        /**
         * Set the value of [copyright] column.
         *
         * @param string $v new value
         * @return SeMediaFileI18n The current object (for fluent API support)
         */
        public function setCopyright($v)
        {    $this->getCurrentTranslation()->setCopyright($v);

        return $this;
    }


        /**
         * Get the [online] column value.
         *
         * @return boolean
         */
        public function getOnline()
        {
        return $this->getCurrentTranslation()->getOnline();
    }


        /**
         * Set the value of [online] column.
         *
         * @param boolean $v new value
         * @return SeMediaFileI18n The current object (for fluent API support)
         */
        public function setOnline($v)
        {    $this->getCurrentTranslation()->setOnline($v);

        return $this;
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     SeMediaFile The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[] = SeMediaFilePeer::UPDATED_AT;

        return $this;
    }

    // event behavior
    public function preCommit(\PropelPDO $con = null){}
    public function preCommitSave(\PropelPDO $con = null){}
    public function preCommitDelete(\PropelPDO $con = null){}
    public function preCommitUpdate(\PropelPDO $con = null){}
    public function preCommitInsert(\PropelPDO $con = null){}
    public function preRollback(\PropelPDO $con = null){}
    public function preRollbackSave(\PropelPDO $con = null){}
    public function preRollbackDelete(\PropelPDO $con = null){}
    public function preRollbackUpdate(\PropelPDO $con = null){}
    public function preRollbackInsert(\PropelPDO $con = null){}

}
