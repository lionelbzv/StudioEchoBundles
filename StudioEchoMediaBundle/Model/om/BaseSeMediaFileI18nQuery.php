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
use StudioEchoBundles\StudioEchoMediaBundle\Model\SeMediaFile;
use StudioEchoBundles\StudioEchoMediaBundle\Model\SeMediaFileI18n;
use StudioEchoBundles\StudioEchoMediaBundle\Model\SeMediaFileI18nPeer;
use StudioEchoBundles\StudioEchoMediaBundle\Model\SeMediaFileI18nQuery;

/**
 * @method SeMediaFileI18nQuery orderById($order = Criteria::ASC) Order by the id column
 * @method SeMediaFileI18nQuery orderByLocale($order = Criteria::ASC) Order by the locale column
 * @method SeMediaFileI18nQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method SeMediaFileI18nQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method SeMediaFileI18nQuery orderByCopyright($order = Criteria::ASC) Order by the copyright column
 * @method SeMediaFileI18nQuery orderByOnline($order = Criteria::ASC) Order by the online column
 *
 * @method SeMediaFileI18nQuery groupById() Group by the id column
 * @method SeMediaFileI18nQuery groupByLocale() Group by the locale column
 * @method SeMediaFileI18nQuery groupByTitle() Group by the title column
 * @method SeMediaFileI18nQuery groupByDescription() Group by the description column
 * @method SeMediaFileI18nQuery groupByCopyright() Group by the copyright column
 * @method SeMediaFileI18nQuery groupByOnline() Group by the online column
 *
 * @method SeMediaFileI18nQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method SeMediaFileI18nQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method SeMediaFileI18nQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method SeMediaFileI18nQuery leftJoinSeMediaFile($relationAlias = null) Adds a LEFT JOIN clause to the query using the SeMediaFile relation
 * @method SeMediaFileI18nQuery rightJoinSeMediaFile($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SeMediaFile relation
 * @method SeMediaFileI18nQuery innerJoinSeMediaFile($relationAlias = null) Adds a INNER JOIN clause to the query using the SeMediaFile relation
 *
 * @method SeMediaFileI18n findOne(PropelPDO $con = null) Return the first SeMediaFileI18n matching the query
 * @method SeMediaFileI18n findOneOrCreate(PropelPDO $con = null) Return the first SeMediaFileI18n matching the query, or a new SeMediaFileI18n object populated from the query conditions when no match is found
 *
 * @method SeMediaFileI18n findOneById(int $id) Return the first SeMediaFileI18n filtered by the id column
 * @method SeMediaFileI18n findOneByLocale(string $locale) Return the first SeMediaFileI18n filtered by the locale column
 * @method SeMediaFileI18n findOneByTitle(string $title) Return the first SeMediaFileI18n filtered by the title column
 * @method SeMediaFileI18n findOneByDescription(string $description) Return the first SeMediaFileI18n filtered by the description column
 * @method SeMediaFileI18n findOneByCopyright(string $copyright) Return the first SeMediaFileI18n filtered by the copyright column
 * @method SeMediaFileI18n findOneByOnline(boolean $online) Return the first SeMediaFileI18n filtered by the online column
 *
 * @method array findById(int $id) Return SeMediaFileI18n objects filtered by the id column
 * @method array findByLocale(string $locale) Return SeMediaFileI18n objects filtered by the locale column
 * @method array findByTitle(string $title) Return SeMediaFileI18n objects filtered by the title column
 * @method array findByDescription(string $description) Return SeMediaFileI18n objects filtered by the description column
 * @method array findByCopyright(string $copyright) Return SeMediaFileI18n objects filtered by the copyright column
 * @method array findByOnline(boolean $online) Return SeMediaFileI18n objects filtered by the online column
 */
abstract class BaseSeMediaFileI18nQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseSeMediaFileI18nQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = null, $modelName = null, $modelAlias = null)
    {
        if (null === $dbName) {
            $dbName = 'default';
        }
        if (null === $modelName) {
            $modelName = 'StudioEchoBundles\\StudioEchoMediaBundle\\Model\\SeMediaFileI18n';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
        EventDispatcherProxy::trigger(array('construct','query.construct'), new QueryEvent($this));
    }

    /**
     * Returns a new SeMediaFileI18nQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   SeMediaFileI18nQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return SeMediaFileI18nQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof SeMediaFileI18nQuery) {
            return $criteria;
        }
        $query = new static(null, null, $modelAlias);

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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array $key Primary key to use for the query
                         A Primary key composition: [$id, $locale]
     * @param     PropelPDO $con an optional connection object
     *
     * @return   SeMediaFileI18n|SeMediaFileI18n[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SeMediaFileI18nPeer::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(SeMediaFileI18nPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 SeMediaFileI18n A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `locale`, `title`, `description`, `copyright`, `online` FROM `se_media_file_i18n` WHERE `id` = :p0 AND `locale` = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $cls = SeMediaFileI18nPeer::getOMClass();
            $obj = new $cls;
            $obj->hydrate($row);
            SeMediaFileI18nPeer::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return SeMediaFileI18n|SeMediaFileI18n[]|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|SeMediaFileI18n[]|mixed the list of results, formatted by the current formatter
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
     * @return SeMediaFileI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(SeMediaFileI18nPeer::ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(SeMediaFileI18nPeer::LOCALE, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return SeMediaFileI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(SeMediaFileI18nPeer::ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(SeMediaFileI18nPeer::LOCALE, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @see       filterBySeMediaFile()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SeMediaFileI18nQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SeMediaFileI18nPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SeMediaFileI18nPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SeMediaFileI18nPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the locale column
     *
     * Example usage:
     * <code>
     * $query->filterByLocale('fooValue');   // WHERE locale = 'fooValue'
     * $query->filterByLocale('%fooValue%'); // WHERE locale LIKE '%fooValue%'
     * </code>
     *
     * @param     string $locale The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SeMediaFileI18nQuery The current query, for fluid interface
     */
    public function filterByLocale($locale = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($locale)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $locale)) {
                $locale = str_replace('*', '%', $locale);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SeMediaFileI18nPeer::LOCALE, $locale, $comparison);
    }

    /**
     * Filter the query on the title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue');   // WHERE title = 'fooValue'
     * $query->filterByTitle('%fooValue%'); // WHERE title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $title The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SeMediaFileI18nQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $title)) {
                $title = str_replace('*', '%', $title);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SeMediaFileI18nPeer::TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%'); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SeMediaFileI18nQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $description)) {
                $description = str_replace('*', '%', $description);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SeMediaFileI18nPeer::DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the copyright column
     *
     * Example usage:
     * <code>
     * $query->filterByCopyright('fooValue');   // WHERE copyright = 'fooValue'
     * $query->filterByCopyright('%fooValue%'); // WHERE copyright LIKE '%fooValue%'
     * </code>
     *
     * @param     string $copyright The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SeMediaFileI18nQuery The current query, for fluid interface
     */
    public function filterByCopyright($copyright = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($copyright)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $copyright)) {
                $copyright = str_replace('*', '%', $copyright);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SeMediaFileI18nPeer::COPYRIGHT, $copyright, $comparison);
    }

    /**
     * Filter the query on the online column
     *
     * Example usage:
     * <code>
     * $query->filterByOnline(true); // WHERE online = true
     * $query->filterByOnline('yes'); // WHERE online = true
     * </code>
     *
     * @param     boolean|string $online The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SeMediaFileI18nQuery The current query, for fluid interface
     */
    public function filterByOnline($online = null, $comparison = null)
    {
        if (is_string($online)) {
            $online = in_array(strtolower($online), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(SeMediaFileI18nPeer::ONLINE, $online, $comparison);
    }

    /**
     * Filter the query by a related SeMediaFile object
     *
     * @param   SeMediaFile|PropelObjectCollection $seMediaFile The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 SeMediaFileI18nQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterBySeMediaFile($seMediaFile, $comparison = null)
    {
        if ($seMediaFile instanceof SeMediaFile) {
            return $this
                ->addUsingAlias(SeMediaFileI18nPeer::ID, $seMediaFile->getId(), $comparison);
        } elseif ($seMediaFile instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SeMediaFileI18nPeer::ID, $seMediaFile->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterBySeMediaFile() only accepts arguments of type SeMediaFile or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SeMediaFile relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return SeMediaFileI18nQuery The current query, for fluid interface
     */
    public function joinSeMediaFile($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SeMediaFile');

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
            $this->addJoinObject($join, 'SeMediaFile');
        }

        return $this;
    }

    /**
     * Use the SeMediaFile relation SeMediaFile object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \StudioEchoBundles\StudioEchoMediaBundle\Model\SeMediaFileQuery A secondary query class using the current class as primary query
     */
    public function useSeMediaFileQuery($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        return $this
            ->joinSeMediaFile($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SeMediaFile', '\StudioEchoBundles\StudioEchoMediaBundle\Model\SeMediaFileQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   SeMediaFileI18n $seMediaFileI18n Object to remove from the list of results
     *
     * @return SeMediaFileI18nQuery The current query, for fluid interface
     */
    public function prune($seMediaFileI18n = null)
    {
        if ($seMediaFileI18n) {
            $this->addCond('pruneCond0', $this->getAliasedColName(SeMediaFileI18nPeer::ID), $seMediaFileI18n->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(SeMediaFileI18nPeer::LOCALE), $seMediaFileI18n->getLocale(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
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
        EventDispatcherProxy::trigger('query.select.pre', new QueryEvent($this, $con));

        return $this->preSelect($con);
    }

    /**
     * Code to execute before every DELETE statement
     *
     * @param     PropelPDO $con The connection object used by the query
     */
    protected function basePreDelete(PropelPDO $con)
    {
        EventDispatcherProxy::trigger(array('delete.pre','query.delete.pre'), new QueryEvent($this, $con));
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
        EventDispatcherProxy::trigger(array('delete.post','query.delete.post'), new QueryEvent($this, $con));

        return $this->postDelete($affectedRows, $con);
    }

    /**
     * Code to execute before every UPDATE statement
     *
     * @param     array $values The associative array of columns and values for the update
     * @param     PropelPDO $con The connection object used by the query
     * @param     boolean $forceIndividualSaves If false (default), the resulting call is a BasePeer::doUpdate(), otherwise it is a series of save() calls on all the found objects
     */
    protected function basePreUpdate(&$values, PropelPDO $con, $forceIndividualSaves = false)
    {
        // event behavior
        EventDispatcherProxy::trigger(array('update.pre', 'query.update.pre'), new QueryEvent($this, $con));

        return $this->preUpdate($values, $con, $forceIndividualSaves);
    }

    /**
     * Code to execute after every UPDATE statement
     *
     * @param     int $affectedRows the number of updated rows
     * @param     PropelPDO $con The connection object used by the query
     */
    protected function basePostUpdate($affectedRows, PropelPDO $con)
    {
        // event behavior
        EventDispatcherProxy::trigger(array('update.post', 'query.update.post'), new QueryEvent($this, $con));

        return $this->postUpdate($affectedRows, $con);
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
