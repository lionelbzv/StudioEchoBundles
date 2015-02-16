<?php

namespace StudioEchoBundles\StudioEchoMediaBundle\Model\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \ModelJoin;
use \PDO;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Glorpen\Propel\PropelBundle\Dispatcher\EventDispatcherProxy;
use Glorpen\Propel\PropelBundle\Events\QueryEvent;
use MontcalmAventure\Model\Activity;
use MontcalmAventure\Model\ActivityDocLib;
use MontcalmAventure\Model\ActivityInsert;
use MontcalmAventure\Model\ActivityInsertDocLib;
use MontcalmAventure\Model\ActivitySub;
use MontcalmAventure\Model\ActivitySubDocLib;
use MontcalmAventure\Model\ContentGeneric;
use MontcalmAventure\Model\ContentGenericDocLib;
use MontcalmAventure\Model\ContentNews;
use MontcalmAventure\Model\ContentNewsDocLib;
use MontcalmAventure\Model\ContentOffer;
use MontcalmAventure\Model\ContentOfferDocLib;
use MontcalmAventure\Model\ContentProfile;
use MontcalmAventure\Model\ContentProfileDocLib;
use MontcalmAventure\Model\ContentStay;
use MontcalmAventure\Model\ContentStayDocLib;
use MontcalmAventure\Model\ContentWish;
use MontcalmAventure\Model\ContentWishDocLib;
use StudioEchoBundles\StudioEchoMediaBundle\Model\SeMediaFile;
use StudioEchoBundles\StudioEchoMediaBundle\Model\SeMediaFileI18n;
use StudioEchoBundles\StudioEchoMediaBundle\Model\SeMediaFilePeer;
use StudioEchoBundles\StudioEchoMediaBundle\Model\SeMediaFileQuery;
use StudioEchoBundles\StudioEchoMediaBundle\Model\SeMediaObject;
use StudioEchoBundles\StudioEchoMediaBundle\Model\SeObjectHasFile;

/**
 * @method SeMediaFileQuery orderById($order = Criteria::ASC) Order by the id column
 * @method SeMediaFileQuery orderByCategoryId($order = Criteria::ASC) Order by the category_id column
 * @method SeMediaFileQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method SeMediaFileQuery orderByExtension($order = Criteria::ASC) Order by the extension column
 * @method SeMediaFileQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method SeMediaFileQuery orderByMimeType($order = Criteria::ASC) Order by the mime_type column
 * @method SeMediaFileQuery orderBySize($order = Criteria::ASC) Order by the size column
 * @method SeMediaFileQuery orderByHeight($order = Criteria::ASC) Order by the height column
 * @method SeMediaFileQuery orderByWidth($order = Criteria::ASC) Order by the width column
 * @method SeMediaFileQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method SeMediaFileQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method SeMediaFileQuery groupById() Group by the id column
 * @method SeMediaFileQuery groupByCategoryId() Group by the category_id column
 * @method SeMediaFileQuery groupByName() Group by the name column
 * @method SeMediaFileQuery groupByExtension() Group by the extension column
 * @method SeMediaFileQuery groupByType() Group by the type column
 * @method SeMediaFileQuery groupByMimeType() Group by the mime_type column
 * @method SeMediaFileQuery groupBySize() Group by the size column
 * @method SeMediaFileQuery groupByHeight() Group by the height column
 * @method SeMediaFileQuery groupByWidth() Group by the width column
 * @method SeMediaFileQuery groupByCreatedAt() Group by the created_at column
 * @method SeMediaFileQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method SeMediaFileQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method SeMediaFileQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method SeMediaFileQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method SeMediaFileQuery leftJoinActivityDocLib($relationAlias = null) Adds a LEFT JOIN clause to the query using the ActivityDocLib relation
 * @method SeMediaFileQuery rightJoinActivityDocLib($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ActivityDocLib relation
 * @method SeMediaFileQuery innerJoinActivityDocLib($relationAlias = null) Adds a INNER JOIN clause to the query using the ActivityDocLib relation
 *
 * @method SeMediaFileQuery leftJoinActivitySubDocLib($relationAlias = null) Adds a LEFT JOIN clause to the query using the ActivitySubDocLib relation
 * @method SeMediaFileQuery rightJoinActivitySubDocLib($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ActivitySubDocLib relation
 * @method SeMediaFileQuery innerJoinActivitySubDocLib($relationAlias = null) Adds a INNER JOIN clause to the query using the ActivitySubDocLib relation
 *
 * @method SeMediaFileQuery leftJoinActivityInsertDocLib($relationAlias = null) Adds a LEFT JOIN clause to the query using the ActivityInsertDocLib relation
 * @method SeMediaFileQuery rightJoinActivityInsertDocLib($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ActivityInsertDocLib relation
 * @method SeMediaFileQuery innerJoinActivityInsertDocLib($relationAlias = null) Adds a INNER JOIN clause to the query using the ActivityInsertDocLib relation
 *
 * @method SeMediaFileQuery leftJoinContentProfileDocLib($relationAlias = null) Adds a LEFT JOIN clause to the query using the ContentProfileDocLib relation
 * @method SeMediaFileQuery rightJoinContentProfileDocLib($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ContentProfileDocLib relation
 * @method SeMediaFileQuery innerJoinContentProfileDocLib($relationAlias = null) Adds a INNER JOIN clause to the query using the ContentProfileDocLib relation
 *
 * @method SeMediaFileQuery leftJoinContentWishDocLib($relationAlias = null) Adds a LEFT JOIN clause to the query using the ContentWishDocLib relation
 * @method SeMediaFileQuery rightJoinContentWishDocLib($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ContentWishDocLib relation
 * @method SeMediaFileQuery innerJoinContentWishDocLib($relationAlias = null) Adds a INNER JOIN clause to the query using the ContentWishDocLib relation
 *
 * @method SeMediaFileQuery leftJoinContentNewsDocLib($relationAlias = null) Adds a LEFT JOIN clause to the query using the ContentNewsDocLib relation
 * @method SeMediaFileQuery rightJoinContentNewsDocLib($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ContentNewsDocLib relation
 * @method SeMediaFileQuery innerJoinContentNewsDocLib($relationAlias = null) Adds a INNER JOIN clause to the query using the ContentNewsDocLib relation
 *
 * @method SeMediaFileQuery leftJoinContentGenericDocLib($relationAlias = null) Adds a LEFT JOIN clause to the query using the ContentGenericDocLib relation
 * @method SeMediaFileQuery rightJoinContentGenericDocLib($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ContentGenericDocLib relation
 * @method SeMediaFileQuery innerJoinContentGenericDocLib($relationAlias = null) Adds a INNER JOIN clause to the query using the ContentGenericDocLib relation
 *
 * @method SeMediaFileQuery leftJoinContentOfferDocLib($relationAlias = null) Adds a LEFT JOIN clause to the query using the ContentOfferDocLib relation
 * @method SeMediaFileQuery rightJoinContentOfferDocLib($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ContentOfferDocLib relation
 * @method SeMediaFileQuery innerJoinContentOfferDocLib($relationAlias = null) Adds a INNER JOIN clause to the query using the ContentOfferDocLib relation
 *
 * @method SeMediaFileQuery leftJoinContentStayDocLib($relationAlias = null) Adds a LEFT JOIN clause to the query using the ContentStayDocLib relation
 * @method SeMediaFileQuery rightJoinContentStayDocLib($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ContentStayDocLib relation
 * @method SeMediaFileQuery innerJoinContentStayDocLib($relationAlias = null) Adds a INNER JOIN clause to the query using the ContentStayDocLib relation
 *
 * @method SeMediaFileQuery leftJoinSeObjectHasFile($relationAlias = null) Adds a LEFT JOIN clause to the query using the SeObjectHasFile relation
 * @method SeMediaFileQuery rightJoinSeObjectHasFile($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SeObjectHasFile relation
 * @method SeMediaFileQuery innerJoinSeObjectHasFile($relationAlias = null) Adds a INNER JOIN clause to the query using the SeObjectHasFile relation
 *
 * @method SeMediaFileQuery leftJoinSeMediaFileI18n($relationAlias = null) Adds a LEFT JOIN clause to the query using the SeMediaFileI18n relation
 * @method SeMediaFileQuery rightJoinSeMediaFileI18n($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SeMediaFileI18n relation
 * @method SeMediaFileQuery innerJoinSeMediaFileI18n($relationAlias = null) Adds a INNER JOIN clause to the query using the SeMediaFileI18n relation
 *
 * @method SeMediaFile findOne(PropelPDO $con = null) Return the first SeMediaFile matching the query
 * @method SeMediaFile findOneOrCreate(PropelPDO $con = null) Return the first SeMediaFile matching the query, or a new SeMediaFile object populated from the query conditions when no match is found
 *
 * @method SeMediaFile findOneByCategoryId(int $category_id) Return the first SeMediaFile filtered by the category_id column
 * @method SeMediaFile findOneByName(string $name) Return the first SeMediaFile filtered by the name column
 * @method SeMediaFile findOneByExtension(string $extension) Return the first SeMediaFile filtered by the extension column
 * @method SeMediaFile findOneByType(string $type) Return the first SeMediaFile filtered by the type column
 * @method SeMediaFile findOneByMimeType(string $mime_type) Return the first SeMediaFile filtered by the mime_type column
 * @method SeMediaFile findOneBySize(int $size) Return the first SeMediaFile filtered by the size column
 * @method SeMediaFile findOneByHeight(int $height) Return the first SeMediaFile filtered by the height column
 * @method SeMediaFile findOneByWidth(int $width) Return the first SeMediaFile filtered by the width column
 * @method SeMediaFile findOneByCreatedAt(string $created_at) Return the first SeMediaFile filtered by the created_at column
 * @method SeMediaFile findOneByUpdatedAt(string $updated_at) Return the first SeMediaFile filtered by the updated_at column
 *
 * @method array findById(int $id) Return SeMediaFile objects filtered by the id column
 * @method array findByCategoryId(int $category_id) Return SeMediaFile objects filtered by the category_id column
 * @method array findByName(string $name) Return SeMediaFile objects filtered by the name column
 * @method array findByExtension(string $extension) Return SeMediaFile objects filtered by the extension column
 * @method array findByType(string $type) Return SeMediaFile objects filtered by the type column
 * @method array findByMimeType(string $mime_type) Return SeMediaFile objects filtered by the mime_type column
 * @method array findBySize(int $size) Return SeMediaFile objects filtered by the size column
 * @method array findByHeight(int $height) Return SeMediaFile objects filtered by the height column
 * @method array findByWidth(int $width) Return SeMediaFile objects filtered by the width column
 * @method array findByCreatedAt(string $created_at) Return SeMediaFile objects filtered by the created_at column
 * @method array findByUpdatedAt(string $updated_at) Return SeMediaFile objects filtered by the updated_at column
 */
abstract class BaseSeMediaFileQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseSeMediaFileQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = 'StudioEchoBundles\\StudioEchoMediaBundle\\Model\\SeMediaFile', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
        EventDispatcherProxy::trigger(array('construct','query.construct'), new QueryEvent($this));
    }

    /**
     * Returns a new SeMediaFileQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   SeMediaFileQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return SeMediaFileQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof SeMediaFileQuery) {
            return $criteria;
        }
        $query = new static();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return   SeMediaFile|SeMediaFile[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SeMediaFilePeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(SeMediaFilePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Alias of findPk to use instance pooling
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 SeMediaFile A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneById($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 SeMediaFile A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `category_id`, `name`, `extension`, `type`, `mime_type`, `size`, `height`, `width`, `created_at`, `updated_at` FROM `se_media_file` WHERE `id` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $cls = SeMediaFilePeer::getOMClass();
            $obj = new $cls;
            $obj->hydrate($row);
            SeMediaFilePeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return SeMediaFile|SeMediaFile[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|SeMediaFile[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return SeMediaFileQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SeMediaFilePeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return SeMediaFileQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SeMediaFilePeer::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id >= 12
     * $query->filterById(array('max' => 12)); // WHERE id <= 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SeMediaFileQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SeMediaFilePeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SeMediaFilePeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SeMediaFilePeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the category_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCategoryId(1234); // WHERE category_id = 1234
     * $query->filterByCategoryId(array(12, 34)); // WHERE category_id IN (12, 34)
     * $query->filterByCategoryId(array('min' => 12)); // WHERE category_id >= 12
     * $query->filterByCategoryId(array('max' => 12)); // WHERE category_id <= 12
     * </code>
     *
     * @param     mixed $categoryId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SeMediaFileQuery The current query, for fluid interface
     */
    public function filterByCategoryId($categoryId = null, $comparison = null)
    {
        if (is_array($categoryId)) {
            $useMinMax = false;
            if (isset($categoryId['min'])) {
                $this->addUsingAlias(SeMediaFilePeer::CATEGORY_ID, $categoryId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($categoryId['max'])) {
                $this->addUsingAlias(SeMediaFilePeer::CATEGORY_ID, $categoryId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SeMediaFilePeer::CATEGORY_ID, $categoryId, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SeMediaFileQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SeMediaFilePeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the extension column
     *
     * Example usage:
     * <code>
     * $query->filterByExtension('fooValue');   // WHERE extension = 'fooValue'
     * $query->filterByExtension('%fooValue%'); // WHERE extension LIKE '%fooValue%'
     * </code>
     *
     * @param     string $extension The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SeMediaFileQuery The current query, for fluid interface
     */
    public function filterByExtension($extension = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($extension)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $extension)) {
                $extension = str_replace('*', '%', $extension);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SeMediaFilePeer::EXTENSION, $extension, $comparison);
    }

    /**
     * Filter the query on the type column
     *
     * Example usage:
     * <code>
     * $query->filterByType('fooValue');   // WHERE type = 'fooValue'
     * $query->filterByType('%fooValue%'); // WHERE type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $type The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SeMediaFileQuery The current query, for fluid interface
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($type)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $type)) {
                $type = str_replace('*', '%', $type);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SeMediaFilePeer::TYPE, $type, $comparison);
    }

    /**
     * Filter the query on the mime_type column
     *
     * Example usage:
     * <code>
     * $query->filterByMimeType('fooValue');   // WHERE mime_type = 'fooValue'
     * $query->filterByMimeType('%fooValue%'); // WHERE mime_type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $mimeType The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SeMediaFileQuery The current query, for fluid interface
     */
    public function filterByMimeType($mimeType = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($mimeType)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $mimeType)) {
                $mimeType = str_replace('*', '%', $mimeType);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SeMediaFilePeer::MIME_TYPE, $mimeType, $comparison);
    }

    /**
     * Filter the query on the size column
     *
     * Example usage:
     * <code>
     * $query->filterBySize(1234); // WHERE size = 1234
     * $query->filterBySize(array(12, 34)); // WHERE size IN (12, 34)
     * $query->filterBySize(array('min' => 12)); // WHERE size >= 12
     * $query->filterBySize(array('max' => 12)); // WHERE size <= 12
     * </code>
     *
     * @param     mixed $size The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SeMediaFileQuery The current query, for fluid interface
     */
    public function filterBySize($size = null, $comparison = null)
    {
        if (is_array($size)) {
            $useMinMax = false;
            if (isset($size['min'])) {
                $this->addUsingAlias(SeMediaFilePeer::SIZE, $size['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($size['max'])) {
                $this->addUsingAlias(SeMediaFilePeer::SIZE, $size['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SeMediaFilePeer::SIZE, $size, $comparison);
    }

    /**
     * Filter the query on the height column
     *
     * Example usage:
     * <code>
     * $query->filterByHeight(1234); // WHERE height = 1234
     * $query->filterByHeight(array(12, 34)); // WHERE height IN (12, 34)
     * $query->filterByHeight(array('min' => 12)); // WHERE height >= 12
     * $query->filterByHeight(array('max' => 12)); // WHERE height <= 12
     * </code>
     *
     * @param     mixed $height The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SeMediaFileQuery The current query, for fluid interface
     */
    public function filterByHeight($height = null, $comparison = null)
    {
        if (is_array($height)) {
            $useMinMax = false;
            if (isset($height['min'])) {
                $this->addUsingAlias(SeMediaFilePeer::HEIGHT, $height['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($height['max'])) {
                $this->addUsingAlias(SeMediaFilePeer::HEIGHT, $height['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SeMediaFilePeer::HEIGHT, $height, $comparison);
    }

    /**
     * Filter the query on the width column
     *
     * Example usage:
     * <code>
     * $query->filterByWidth(1234); // WHERE width = 1234
     * $query->filterByWidth(array(12, 34)); // WHERE width IN (12, 34)
     * $query->filterByWidth(array('min' => 12)); // WHERE width >= 12
     * $query->filterByWidth(array('max' => 12)); // WHERE width <= 12
     * </code>
     *
     * @param     mixed $width The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SeMediaFileQuery The current query, for fluid interface
     */
    public function filterByWidth($width = null, $comparison = null)
    {
        if (is_array($width)) {
            $useMinMax = false;
            if (isset($width['min'])) {
                $this->addUsingAlias(SeMediaFilePeer::WIDTH, $width['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($width['max'])) {
                $this->addUsingAlias(SeMediaFilePeer::WIDTH, $width['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SeMediaFilePeer::WIDTH, $width, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SeMediaFileQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(SeMediaFilePeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(SeMediaFilePeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SeMediaFilePeer::CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SeMediaFileQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(SeMediaFilePeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(SeMediaFilePeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SeMediaFilePeer::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related ActivityDocLib object
     *
     * @param   ActivityDocLib|PropelObjectCollection $activityDocLib  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 SeMediaFileQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByActivityDocLib($activityDocLib, $comparison = null)
    {
        if ($activityDocLib instanceof ActivityDocLib) {
            return $this
                ->addUsingAlias(SeMediaFilePeer::ID, $activityDocLib->getSeMediaFileId(), $comparison);
        } elseif ($activityDocLib instanceof PropelObjectCollection) {
            return $this
                ->useActivityDocLibQuery()
                ->filterByPrimaryKeys($activityDocLib->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByActivityDocLib() only accepts arguments of type ActivityDocLib or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ActivityDocLib relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return SeMediaFileQuery The current query, for fluid interface
     */
    public function joinActivityDocLib($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ActivityDocLib');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'ActivityDocLib');
        }

        return $this;
    }

    /**
     * Use the ActivityDocLib relation ActivityDocLib object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \MontcalmAventure\Model\ActivityDocLibQuery A secondary query class using the current class as primary query
     */
    public function useActivityDocLibQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinActivityDocLib($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ActivityDocLib', '\MontcalmAventure\Model\ActivityDocLibQuery');
    }

    /**
     * Filter the query by a related ActivitySubDocLib object
     *
     * @param   ActivitySubDocLib|PropelObjectCollection $activitySubDocLib  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 SeMediaFileQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByActivitySubDocLib($activitySubDocLib, $comparison = null)
    {
        if ($activitySubDocLib instanceof ActivitySubDocLib) {
            return $this
                ->addUsingAlias(SeMediaFilePeer::ID, $activitySubDocLib->getSeMediaFileId(), $comparison);
        } elseif ($activitySubDocLib instanceof PropelObjectCollection) {
            return $this
                ->useActivitySubDocLibQuery()
                ->filterByPrimaryKeys($activitySubDocLib->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByActivitySubDocLib() only accepts arguments of type ActivitySubDocLib or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ActivitySubDocLib relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return SeMediaFileQuery The current query, for fluid interface
     */
    public function joinActivitySubDocLib($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ActivitySubDocLib');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'ActivitySubDocLib');
        }

        return $this;
    }

    /**
     * Use the ActivitySubDocLib relation ActivitySubDocLib object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \MontcalmAventure\Model\ActivitySubDocLibQuery A secondary query class using the current class as primary query
     */
    public function useActivitySubDocLibQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinActivitySubDocLib($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ActivitySubDocLib', '\MontcalmAventure\Model\ActivitySubDocLibQuery');
    }

    /**
     * Filter the query by a related ActivityInsertDocLib object
     *
     * @param   ActivityInsertDocLib|PropelObjectCollection $activityInsertDocLib  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 SeMediaFileQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByActivityInsertDocLib($activityInsertDocLib, $comparison = null)
    {
        if ($activityInsertDocLib instanceof ActivityInsertDocLib) {
            return $this
                ->addUsingAlias(SeMediaFilePeer::ID, $activityInsertDocLib->getSeMediaFileId(), $comparison);
        } elseif ($activityInsertDocLib instanceof PropelObjectCollection) {
            return $this
                ->useActivityInsertDocLibQuery()
                ->filterByPrimaryKeys($activityInsertDocLib->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByActivityInsertDocLib() only accepts arguments of type ActivityInsertDocLib or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ActivityInsertDocLib relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return SeMediaFileQuery The current query, for fluid interface
     */
    public function joinActivityInsertDocLib($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ActivityInsertDocLib');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'ActivityInsertDocLib');
        }

        return $this;
    }

    /**
     * Use the ActivityInsertDocLib relation ActivityInsertDocLib object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \MontcalmAventure\Model\ActivityInsertDocLibQuery A secondary query class using the current class as primary query
     */
    public function useActivityInsertDocLibQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinActivityInsertDocLib($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ActivityInsertDocLib', '\MontcalmAventure\Model\ActivityInsertDocLibQuery');
    }

    /**
     * Filter the query by a related ContentProfileDocLib object
     *
     * @param   ContentProfileDocLib|PropelObjectCollection $contentProfileDocLib  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 SeMediaFileQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByContentProfileDocLib($contentProfileDocLib, $comparison = null)
    {
        if ($contentProfileDocLib instanceof ContentProfileDocLib) {
            return $this
                ->addUsingAlias(SeMediaFilePeer::ID, $contentProfileDocLib->getSeMediaFileId(), $comparison);
        } elseif ($contentProfileDocLib instanceof PropelObjectCollection) {
            return $this
                ->useContentProfileDocLibQuery()
                ->filterByPrimaryKeys($contentProfileDocLib->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByContentProfileDocLib() only accepts arguments of type ContentProfileDocLib or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ContentProfileDocLib relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return SeMediaFileQuery The current query, for fluid interface
     */
    public function joinContentProfileDocLib($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ContentProfileDocLib');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'ContentProfileDocLib');
        }

        return $this;
    }

    /**
     * Use the ContentProfileDocLib relation ContentProfileDocLib object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \MontcalmAventure\Model\ContentProfileDocLibQuery A secondary query class using the current class as primary query
     */
    public function useContentProfileDocLibQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinContentProfileDocLib($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ContentProfileDocLib', '\MontcalmAventure\Model\ContentProfileDocLibQuery');
    }

    /**
     * Filter the query by a related ContentWishDocLib object
     *
     * @param   ContentWishDocLib|PropelObjectCollection $contentWishDocLib  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 SeMediaFileQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByContentWishDocLib($contentWishDocLib, $comparison = null)
    {
        if ($contentWishDocLib instanceof ContentWishDocLib) {
            return $this
                ->addUsingAlias(SeMediaFilePeer::ID, $contentWishDocLib->getSeMediaFileId(), $comparison);
        } elseif ($contentWishDocLib instanceof PropelObjectCollection) {
            return $this
                ->useContentWishDocLibQuery()
                ->filterByPrimaryKeys($contentWishDocLib->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByContentWishDocLib() only accepts arguments of type ContentWishDocLib or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ContentWishDocLib relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return SeMediaFileQuery The current query, for fluid interface
     */
    public function joinContentWishDocLib($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ContentWishDocLib');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'ContentWishDocLib');
        }

        return $this;
    }

    /**
     * Use the ContentWishDocLib relation ContentWishDocLib object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \MontcalmAventure\Model\ContentWishDocLibQuery A secondary query class using the current class as primary query
     */
    public function useContentWishDocLibQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinContentWishDocLib($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ContentWishDocLib', '\MontcalmAventure\Model\ContentWishDocLibQuery');
    }

    /**
     * Filter the query by a related ContentNewsDocLib object
     *
     * @param   ContentNewsDocLib|PropelObjectCollection $contentNewsDocLib  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 SeMediaFileQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByContentNewsDocLib($contentNewsDocLib, $comparison = null)
    {
        if ($contentNewsDocLib instanceof ContentNewsDocLib) {
            return $this
                ->addUsingAlias(SeMediaFilePeer::ID, $contentNewsDocLib->getSeMediaFileId(), $comparison);
        } elseif ($contentNewsDocLib instanceof PropelObjectCollection) {
            return $this
                ->useContentNewsDocLibQuery()
                ->filterByPrimaryKeys($contentNewsDocLib->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByContentNewsDocLib() only accepts arguments of type ContentNewsDocLib or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ContentNewsDocLib relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return SeMediaFileQuery The current query, for fluid interface
     */
    public function joinContentNewsDocLib($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ContentNewsDocLib');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'ContentNewsDocLib');
        }

        return $this;
    }

    /**
     * Use the ContentNewsDocLib relation ContentNewsDocLib object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \MontcalmAventure\Model\ContentNewsDocLibQuery A secondary query class using the current class as primary query
     */
    public function useContentNewsDocLibQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinContentNewsDocLib($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ContentNewsDocLib', '\MontcalmAventure\Model\ContentNewsDocLibQuery');
    }

    /**
     * Filter the query by a related ContentGenericDocLib object
     *
     * @param   ContentGenericDocLib|PropelObjectCollection $contentGenericDocLib  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 SeMediaFileQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByContentGenericDocLib($contentGenericDocLib, $comparison = null)
    {
        if ($contentGenericDocLib instanceof ContentGenericDocLib) {
            return $this
                ->addUsingAlias(SeMediaFilePeer::ID, $contentGenericDocLib->getSeMediaFileId(), $comparison);
        } elseif ($contentGenericDocLib instanceof PropelObjectCollection) {
            return $this
                ->useContentGenericDocLibQuery()
                ->filterByPrimaryKeys($contentGenericDocLib->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByContentGenericDocLib() only accepts arguments of type ContentGenericDocLib or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ContentGenericDocLib relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return SeMediaFileQuery The current query, for fluid interface
     */
    public function joinContentGenericDocLib($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ContentGenericDocLib');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'ContentGenericDocLib');
        }

        return $this;
    }

    /**
     * Use the ContentGenericDocLib relation ContentGenericDocLib object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \MontcalmAventure\Model\ContentGenericDocLibQuery A secondary query class using the current class as primary query
     */
    public function useContentGenericDocLibQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinContentGenericDocLib($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ContentGenericDocLib', '\MontcalmAventure\Model\ContentGenericDocLibQuery');
    }

    /**
     * Filter the query by a related ContentOfferDocLib object
     *
     * @param   ContentOfferDocLib|PropelObjectCollection $contentOfferDocLib  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 SeMediaFileQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByContentOfferDocLib($contentOfferDocLib, $comparison = null)
    {
        if ($contentOfferDocLib instanceof ContentOfferDocLib) {
            return $this
                ->addUsingAlias(SeMediaFilePeer::ID, $contentOfferDocLib->getSeMediaFileId(), $comparison);
        } elseif ($contentOfferDocLib instanceof PropelObjectCollection) {
            return $this
                ->useContentOfferDocLibQuery()
                ->filterByPrimaryKeys($contentOfferDocLib->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByContentOfferDocLib() only accepts arguments of type ContentOfferDocLib or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ContentOfferDocLib relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return SeMediaFileQuery The current query, for fluid interface
     */
    public function joinContentOfferDocLib($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ContentOfferDocLib');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'ContentOfferDocLib');
        }

        return $this;
    }

    /**
     * Use the ContentOfferDocLib relation ContentOfferDocLib object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \MontcalmAventure\Model\ContentOfferDocLibQuery A secondary query class using the current class as primary query
     */
    public function useContentOfferDocLibQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinContentOfferDocLib($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ContentOfferDocLib', '\MontcalmAventure\Model\ContentOfferDocLibQuery');
    }

    /**
     * Filter the query by a related ContentStayDocLib object
     *
     * @param   ContentStayDocLib|PropelObjectCollection $contentStayDocLib  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 SeMediaFileQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByContentStayDocLib($contentStayDocLib, $comparison = null)
    {
        if ($contentStayDocLib instanceof ContentStayDocLib) {
            return $this
                ->addUsingAlias(SeMediaFilePeer::ID, $contentStayDocLib->getSeMediaFileId(), $comparison);
        } elseif ($contentStayDocLib instanceof PropelObjectCollection) {
            return $this
                ->useContentStayDocLibQuery()
                ->filterByPrimaryKeys($contentStayDocLib->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByContentStayDocLib() only accepts arguments of type ContentStayDocLib or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ContentStayDocLib relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return SeMediaFileQuery The current query, for fluid interface
     */
    public function joinContentStayDocLib($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ContentStayDocLib');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'ContentStayDocLib');
        }

        return $this;
    }

    /**
     * Use the ContentStayDocLib relation ContentStayDocLib object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \MontcalmAventure\Model\ContentStayDocLibQuery A secondary query class using the current class as primary query
     */
    public function useContentStayDocLibQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinContentStayDocLib($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ContentStayDocLib', '\MontcalmAventure\Model\ContentStayDocLibQuery');
    }

    /**
     * Filter the query by a related SeObjectHasFile object
     *
     * @param   SeObjectHasFile|PropelObjectCollection $seObjectHasFile  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 SeMediaFileQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterBySeObjectHasFile($seObjectHasFile, $comparison = null)
    {
        if ($seObjectHasFile instanceof SeObjectHasFile) {
            return $this
                ->addUsingAlias(SeMediaFilePeer::ID, $seObjectHasFile->getSeMediaFileId(), $comparison);
        } elseif ($seObjectHasFile instanceof PropelObjectCollection) {
            return $this
                ->useSeObjectHasFileQuery()
                ->filterByPrimaryKeys($seObjectHasFile->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySeObjectHasFile() only accepts arguments of type SeObjectHasFile or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SeObjectHasFile relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return SeMediaFileQuery The current query, for fluid interface
     */
    public function joinSeObjectHasFile($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SeObjectHasFile');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'SeObjectHasFile');
        }

        return $this;
    }

    /**
     * Use the SeObjectHasFile relation SeObjectHasFile object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \StudioEchoBundles\StudioEchoMediaBundle\Model\SeObjectHasFileQuery A secondary query class using the current class as primary query
     */
    public function useSeObjectHasFileQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSeObjectHasFile($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SeObjectHasFile', '\StudioEchoBundles\StudioEchoMediaBundle\Model\SeObjectHasFileQuery');
    }

    /**
     * Filter the query by a related SeMediaFileI18n object
     *
     * @param   SeMediaFileI18n|PropelObjectCollection $seMediaFileI18n  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 SeMediaFileQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterBySeMediaFileI18n($seMediaFileI18n, $comparison = null)
    {
        if ($seMediaFileI18n instanceof SeMediaFileI18n) {
            return $this
                ->addUsingAlias(SeMediaFilePeer::ID, $seMediaFileI18n->getId(), $comparison);
        } elseif ($seMediaFileI18n instanceof PropelObjectCollection) {
            return $this
                ->useSeMediaFileI18nQuery()
                ->filterByPrimaryKeys($seMediaFileI18n->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySeMediaFileI18n() only accepts arguments of type SeMediaFileI18n or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SeMediaFileI18n relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return SeMediaFileQuery The current query, for fluid interface
     */
    public function joinSeMediaFileI18n($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SeMediaFileI18n');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'SeMediaFileI18n');
        }

        return $this;
    }

    /**
     * Use the SeMediaFileI18n relation SeMediaFileI18n object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \StudioEchoBundles\StudioEchoMediaBundle\Model\SeMediaFileI18nQuery A secondary query class using the current class as primary query
     */
    public function useSeMediaFileI18nQuery($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        return $this
            ->joinSeMediaFileI18n($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SeMediaFileI18n', '\StudioEchoBundles\StudioEchoMediaBundle\Model\SeMediaFileI18nQuery');
    }

    /**
     * Filter the query by a related Activity object
     * using the activity_doc_lib table as cross reference
     *
     * @param   Activity $activity the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   SeMediaFileQuery The current query, for fluid interface
     */
    public function filterByActivity($activity, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useActivityDocLibQuery()
            ->filterByActivity($activity, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related ActivitySub object
     * using the activity_sub_doc_lib table as cross reference
     *
     * @param   ActivitySub $activitySub the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   SeMediaFileQuery The current query, for fluid interface
     */
    public function filterByActivitySub($activitySub, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useActivitySubDocLibQuery()
            ->filterByActivitySub($activitySub, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related ActivityInsert object
     * using the activity_insert_doc_lib table as cross reference
     *
     * @param   ActivityInsert $activityInsert the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   SeMediaFileQuery The current query, for fluid interface
     */
    public function filterByActivityInsert($activityInsert, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useActivityInsertDocLibQuery()
            ->filterByActivityInsert($activityInsert, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related ContentProfile object
     * using the content_profile_doc_lib table as cross reference
     *
     * @param   ContentProfile $contentProfile the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   SeMediaFileQuery The current query, for fluid interface
     */
    public function filterByContentProfile($contentProfile, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useContentProfileDocLibQuery()
            ->filterByContentProfile($contentProfile, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related ContentWish object
     * using the content_wish_doc_lib table as cross reference
     *
     * @param   ContentWish $contentWish the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   SeMediaFileQuery The current query, for fluid interface
     */
    public function filterByContentWish($contentWish, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useContentWishDocLibQuery()
            ->filterByContentWish($contentWish, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related ContentNews object
     * using the content_news_doc_lib table as cross reference
     *
     * @param   ContentNews $contentNews the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   SeMediaFileQuery The current query, for fluid interface
     */
    public function filterByContentNews($contentNews, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useContentNewsDocLibQuery()
            ->filterByContentNews($contentNews, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related ContentGeneric object
     * using the content_generic_doc_lib table as cross reference
     *
     * @param   ContentGeneric $contentGeneric the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   SeMediaFileQuery The current query, for fluid interface
     */
    public function filterByContentGeneric($contentGeneric, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useContentGenericDocLibQuery()
            ->filterByContentGeneric($contentGeneric, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related ContentOffer object
     * using the content_offer_doc_lib table as cross reference
     *
     * @param   ContentOffer $contentOffer the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   SeMediaFileQuery The current query, for fluid interface
     */
    public function filterByContentOffer($contentOffer, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useContentOfferDocLibQuery()
            ->filterByContentOffer($contentOffer, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related ContentStay object
     * using the content_stay_doc_lib table as cross reference
     *
     * @param   ContentStay $contentStay the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   SeMediaFileQuery The current query, for fluid interface
     */
    public function filterByContentStay($contentStay, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useContentStayDocLibQuery()
            ->filterByContentStay($contentStay, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related SeMediaObject object
     * using the se_object_has_file table as cross reference
     *
     * @param   SeMediaObject $seMediaObject the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   SeMediaFileQuery The current query, for fluid interface
     */
    public function filterBySeMediaObject($seMediaObject, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useSeObjectHasFileQuery()
            ->filterBySeMediaObject($seMediaObject, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   SeMediaFile $seMediaFile Object to remove from the list of results
     *
     * @return SeMediaFileQuery The current query, for fluid interface
     */
    public function prune($seMediaFile = null)
    {
        if ($seMediaFile) {
            $this->addUsingAlias(SeMediaFilePeer::ID, $seMediaFile->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Code to execute before every SELECT statement
     *
     * @param     PropelPDO $con The connection object used by the query
     */
    protected function basePreSelect(PropelPDO $con)
    {
        // event behavior
        EventDispatcherProxy::trigger('query.select.pre', new QueryEvent($this));

        return $this->preSelect($con);
    }

    /**
     * Code to execute before every DELETE statement
     *
     * @param     PropelPDO $con The connection object used by the query
     */
    protected function basePreDelete(PropelPDO $con)
    {
        EventDispatcherProxy::trigger(array('delete.pre','query.delete.pre'), new QueryEvent($this));
        // event behavior
        // placeholder, issue #5

        return $this->preDelete($con);
    }

    /**
     * Code to execute after every DELETE statement
     *
     * @param     int $affectedRows the number of deleted rows
     * @param     PropelPDO $con The connection object used by the query
     */
    protected function basePostDelete($affectedRows, PropelPDO $con)
    {
        // event behavior
        EventDispatcherProxy::trigger(array('delete.post','query.delete.post'), new QueryEvent($this));

        return $this->postDelete($affectedRows, $con);
    }

    /**
     * Code to execute before every UPDATE statement
     *
     * @param     array $values The associatiove array of columns and values for the update
     * @param     PropelPDO $con The connection object used by the query
     * @param     boolean $forceIndividualSaves If false (default), the resulting call is a BasePeer::doUpdate(), ortherwise it is a series of save() calls on all the found objects
     */
    protected function basePreUpdate(&$values, PropelPDO $con, $forceIndividualSaves = false)
    {
        // event behavior
        EventDispatcherProxy::trigger(array('update.pre', 'query.update.pre'), new QueryEvent($this));

        return $this->preUpdate($values, $con, $forceIndividualSaves);
    }

    /**
     * Code to execute after every UPDATE statement
     *
     * @param     int $affectedRows the number of udated rows
     * @param     PropelPDO $con The connection object used by the query
     */
    protected function basePostUpdate($affectedRows, PropelPDO $con)
    {
        // event behavior
        EventDispatcherProxy::trigger(array('update.post', 'query.update.post'), new QueryEvent($this));

        return $this->postUpdate($affectedRows, $con);
    }

    // i18n behavior

    /**
     * Adds a JOIN clause to the query using the i18n relation
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    SeMediaFileQuery The current query, for fluid interface
     */
    public function joinI18n($locale = 'fr_FR', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $relationName = $relationAlias ? $relationAlias : 'SeMediaFileI18n';

        return $this
            ->joinSeMediaFileI18n($relationAlias, $joinType)
            ->addJoinCondition($relationName, $relationName . '.Locale = ?', $locale);
    }

    /**
     * Adds a JOIN clause to the query and hydrates the related I18n object.
     * Shortcut for $c->joinI18n($locale)->with()
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    SeMediaFileQuery The current query, for fluid interface
     */
    public function joinWithI18n($locale = 'fr_FR', $joinType = Criteria::LEFT_JOIN)
    {
        $this
            ->joinI18n($locale, null, $joinType)
            ->with('SeMediaFileI18n');
        $this->with['SeMediaFileI18n']->setIsWithOneToMany(false);

        return $this;
    }

    /**
     * Use the I18n relation query object
     *
     * @see       useQuery()
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    SeMediaFileI18nQuery A secondary query class using the current class as primary query
     */
    public function useI18nQuery($locale = 'fr_FR', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinI18n($locale, $relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SeMediaFileI18n', 'StudioEchoBundles\StudioEchoMediaBundle\Model\SeMediaFileI18nQuery');
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     SeMediaFileQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(SeMediaFilePeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     SeMediaFileQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(SeMediaFilePeer::UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     SeMediaFileQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(SeMediaFilePeer::UPDATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     SeMediaFileQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(SeMediaFilePeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date desc
     *
     * @return     SeMediaFileQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(SeMediaFilePeer::CREATED_AT);
    }

    /**
     * Order by create date asc
     *
     * @return     SeMediaFileQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(SeMediaFilePeer::CREATED_AT);
    }
    // extend behavior
    public function setFormatter($formatter)
    {
        if (is_string($formatter) && $formatter === \ModelCriteria::FORMAT_ON_DEMAND) {
            $formatter = '\Glorpen\Propel\PropelBundle\Formatter\PropelOnDemandFormatter';
        }

        return parent::setFormatter($formatter);
    }
}
