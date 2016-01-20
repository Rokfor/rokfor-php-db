<?php

namespace Base;

use \Issues as ChildIssues;
use \IssuesQuery as ChildIssuesQuery;
use \Exception;
use \PDO;
use Map\IssuesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the '_issues' table.
 *
 *
 *
 * @method     ChildIssuesQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildIssuesQuery orderByName($order = Criteria::ASC) Order by the _name column
 * @method     ChildIssuesQuery orderByOpendate($order = Criteria::ASC) Order by the _opendate column
 * @method     ChildIssuesQuery orderByClosedate($order = Criteria::ASC) Order by the _closedate column
 * @method     ChildIssuesQuery orderByStatus($order = Criteria::ASC) Order by the _status column
 * @method     ChildIssuesQuery orderByInfotext($order = Criteria::ASC) Order by the _infotext column
 * @method     ChildIssuesQuery orderByForbook($order = Criteria::ASC) Order by the _forbook column
 * @method     ChildIssuesQuery orderByUserSys($order = Criteria::ASC) Order by the __user__ column
 * @method     ChildIssuesQuery orderByConfigSys($order = Criteria::ASC) Order by the __config__ column
 * @method     ChildIssuesQuery orderBySplit($order = Criteria::ASC) Order by the __split__ column
 * @method     ChildIssuesQuery orderByParentnode($order = Criteria::ASC) Order by the __parentnode__ column
 * @method     ChildIssuesQuery orderBySort($order = Criteria::ASC) Order by the __sort__ column
 *
 * @method     ChildIssuesQuery groupById() Group by the id column
 * @method     ChildIssuesQuery groupByName() Group by the _name column
 * @method     ChildIssuesQuery groupByOpendate() Group by the _opendate column
 * @method     ChildIssuesQuery groupByClosedate() Group by the _closedate column
 * @method     ChildIssuesQuery groupByStatus() Group by the _status column
 * @method     ChildIssuesQuery groupByInfotext() Group by the _infotext column
 * @method     ChildIssuesQuery groupByForbook() Group by the _forbook column
 * @method     ChildIssuesQuery groupByUserSys() Group by the __user__ column
 * @method     ChildIssuesQuery groupByConfigSys() Group by the __config__ column
 * @method     ChildIssuesQuery groupBySplit() Group by the __split__ column
 * @method     ChildIssuesQuery groupByParentnode() Group by the __parentnode__ column
 * @method     ChildIssuesQuery groupBySort() Group by the __sort__ column
 *
 * @method     ChildIssuesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildIssuesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildIssuesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildIssuesQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildIssuesQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildIssuesQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildIssuesQuery leftJoinuserSysRef($relationAlias = null) Adds a LEFT JOIN clause to the query using the userSysRef relation
 * @method     ChildIssuesQuery rightJoinuserSysRef($relationAlias = null) Adds a RIGHT JOIN clause to the query using the userSysRef relation
 * @method     ChildIssuesQuery innerJoinuserSysRef($relationAlias = null) Adds a INNER JOIN clause to the query using the userSysRef relation
 *
 * @method     ChildIssuesQuery joinWithuserSysRef($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the userSysRef relation
 *
 * @method     ChildIssuesQuery leftJoinWithuserSysRef() Adds a LEFT JOIN clause and with to the query using the userSysRef relation
 * @method     ChildIssuesQuery rightJoinWithuserSysRef() Adds a RIGHT JOIN clause and with to the query using the userSysRef relation
 * @method     ChildIssuesQuery innerJoinWithuserSysRef() Adds a INNER JOIN clause and with to the query using the userSysRef relation
 *
 * @method     ChildIssuesQuery leftJoinBooks($relationAlias = null) Adds a LEFT JOIN clause to the query using the Books relation
 * @method     ChildIssuesQuery rightJoinBooks($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Books relation
 * @method     ChildIssuesQuery innerJoinBooks($relationAlias = null) Adds a INNER JOIN clause to the query using the Books relation
 *
 * @method     ChildIssuesQuery joinWithBooks($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Books relation
 *
 * @method     ChildIssuesQuery leftJoinWithBooks() Adds a LEFT JOIN clause and with to the query using the Books relation
 * @method     ChildIssuesQuery rightJoinWithBooks() Adds a RIGHT JOIN clause and with to the query using the Books relation
 * @method     ChildIssuesQuery innerJoinWithBooks() Adds a INNER JOIN clause and with to the query using the Books relation
 *
 * @method     ChildIssuesQuery leftJoinRIssuesAllplugin($relationAlias = null) Adds a LEFT JOIN clause to the query using the RIssuesAllplugin relation
 * @method     ChildIssuesQuery rightJoinRIssuesAllplugin($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RIssuesAllplugin relation
 * @method     ChildIssuesQuery innerJoinRIssuesAllplugin($relationAlias = null) Adds a INNER JOIN clause to the query using the RIssuesAllplugin relation
 *
 * @method     ChildIssuesQuery joinWithRIssuesAllplugin($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RIssuesAllplugin relation
 *
 * @method     ChildIssuesQuery leftJoinWithRIssuesAllplugin() Adds a LEFT JOIN clause and with to the query using the RIssuesAllplugin relation
 * @method     ChildIssuesQuery rightJoinWithRIssuesAllplugin() Adds a RIGHT JOIN clause and with to the query using the RIssuesAllplugin relation
 * @method     ChildIssuesQuery innerJoinWithRIssuesAllplugin() Adds a INNER JOIN clause and with to the query using the RIssuesAllplugin relation
 *
 * @method     ChildIssuesQuery leftJoinRIssuesNarrationplugin($relationAlias = null) Adds a LEFT JOIN clause to the query using the RIssuesNarrationplugin relation
 * @method     ChildIssuesQuery rightJoinRIssuesNarrationplugin($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RIssuesNarrationplugin relation
 * @method     ChildIssuesQuery innerJoinRIssuesNarrationplugin($relationAlias = null) Adds a INNER JOIN clause to the query using the RIssuesNarrationplugin relation
 *
 * @method     ChildIssuesQuery joinWithRIssuesNarrationplugin($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RIssuesNarrationplugin relation
 *
 * @method     ChildIssuesQuery leftJoinWithRIssuesNarrationplugin() Adds a LEFT JOIN clause and with to the query using the RIssuesNarrationplugin relation
 * @method     ChildIssuesQuery rightJoinWithRIssuesNarrationplugin() Adds a RIGHT JOIN clause and with to the query using the RIssuesNarrationplugin relation
 * @method     ChildIssuesQuery innerJoinWithRIssuesNarrationplugin() Adds a INNER JOIN clause and with to the query using the RIssuesNarrationplugin relation
 *
 * @method     ChildIssuesQuery leftJoinRIssuesRtfplugin($relationAlias = null) Adds a LEFT JOIN clause to the query using the RIssuesRtfplugin relation
 * @method     ChildIssuesQuery rightJoinRIssuesRtfplugin($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RIssuesRtfplugin relation
 * @method     ChildIssuesQuery innerJoinRIssuesRtfplugin($relationAlias = null) Adds a INNER JOIN clause to the query using the RIssuesRtfplugin relation
 *
 * @method     ChildIssuesQuery joinWithRIssuesRtfplugin($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RIssuesRtfplugin relation
 *
 * @method     ChildIssuesQuery leftJoinWithRIssuesRtfplugin() Adds a LEFT JOIN clause and with to the query using the RIssuesRtfplugin relation
 * @method     ChildIssuesQuery rightJoinWithRIssuesRtfplugin() Adds a RIGHT JOIN clause and with to the query using the RIssuesRtfplugin relation
 * @method     ChildIssuesQuery innerJoinWithRIssuesRtfplugin() Adds a INNER JOIN clause and with to the query using the RIssuesRtfplugin relation
 *
 * @method     ChildIssuesQuery leftJoinRIssuesSingleplugin($relationAlias = null) Adds a LEFT JOIN clause to the query using the RIssuesSingleplugin relation
 * @method     ChildIssuesQuery rightJoinRIssuesSingleplugin($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RIssuesSingleplugin relation
 * @method     ChildIssuesQuery innerJoinRIssuesSingleplugin($relationAlias = null) Adds a INNER JOIN clause to the query using the RIssuesSingleplugin relation
 *
 * @method     ChildIssuesQuery joinWithRIssuesSingleplugin($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RIssuesSingleplugin relation
 *
 * @method     ChildIssuesQuery leftJoinWithRIssuesSingleplugin() Adds a LEFT JOIN clause and with to the query using the RIssuesSingleplugin relation
 * @method     ChildIssuesQuery rightJoinWithRIssuesSingleplugin() Adds a RIGHT JOIN clause and with to the query using the RIssuesSingleplugin relation
 * @method     ChildIssuesQuery innerJoinWithRIssuesSingleplugin() Adds a INNER JOIN clause and with to the query using the RIssuesSingleplugin relation
 *
 * @method     ChildIssuesQuery leftJoinRIssuesXmlplugin($relationAlias = null) Adds a LEFT JOIN clause to the query using the RIssuesXmlplugin relation
 * @method     ChildIssuesQuery rightJoinRIssuesXmlplugin($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RIssuesXmlplugin relation
 * @method     ChildIssuesQuery innerJoinRIssuesXmlplugin($relationAlias = null) Adds a INNER JOIN clause to the query using the RIssuesXmlplugin relation
 *
 * @method     ChildIssuesQuery joinWithRIssuesXmlplugin($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RIssuesXmlplugin relation
 *
 * @method     ChildIssuesQuery leftJoinWithRIssuesXmlplugin() Adds a LEFT JOIN clause and with to the query using the RIssuesXmlplugin relation
 * @method     ChildIssuesQuery rightJoinWithRIssuesXmlplugin() Adds a RIGHT JOIN clause and with to the query using the RIssuesXmlplugin relation
 * @method     ChildIssuesQuery innerJoinWithRIssuesXmlplugin() Adds a INNER JOIN clause and with to the query using the RIssuesXmlplugin relation
 *
 * @method     ChildIssuesQuery leftJoinRRightsForissue($relationAlias = null) Adds a LEFT JOIN clause to the query using the RRightsForissue relation
 * @method     ChildIssuesQuery rightJoinRRightsForissue($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RRightsForissue relation
 * @method     ChildIssuesQuery innerJoinRRightsForissue($relationAlias = null) Adds a INNER JOIN clause to the query using the RRightsForissue relation
 *
 * @method     ChildIssuesQuery joinWithRRightsForissue($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RRightsForissue relation
 *
 * @method     ChildIssuesQuery leftJoinWithRRightsForissue() Adds a LEFT JOIN clause and with to the query using the RRightsForissue relation
 * @method     ChildIssuesQuery rightJoinWithRRightsForissue() Adds a RIGHT JOIN clause and with to the query using the RRightsForissue relation
 * @method     ChildIssuesQuery innerJoinWithRRightsForissue() Adds a INNER JOIN clause and with to the query using the RRightsForissue relation
 *
 * @method     ChildIssuesQuery leftJoinContributions($relationAlias = null) Adds a LEFT JOIN clause to the query using the Contributions relation
 * @method     ChildIssuesQuery rightJoinContributions($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Contributions relation
 * @method     ChildIssuesQuery innerJoinContributions($relationAlias = null) Adds a INNER JOIN clause to the query using the Contributions relation
 *
 * @method     ChildIssuesQuery joinWithContributions($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Contributions relation
 *
 * @method     ChildIssuesQuery leftJoinWithContributions() Adds a LEFT JOIN clause and with to the query using the Contributions relation
 * @method     ChildIssuesQuery rightJoinWithContributions() Adds a RIGHT JOIN clause and with to the query using the Contributions relation
 * @method     ChildIssuesQuery innerJoinWithContributions() Adds a INNER JOIN clause and with to the query using the Contributions relation
 *
 * @method     \UsersQuery|\BooksQuery|\RIssuesAllpluginQuery|\RIssuesNarrationpluginQuery|\RIssuesRtfpluginQuery|\RIssuesSinglepluginQuery|\RIssuesXmlpluginQuery|\RRightsForissueQuery|\ContributionsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildIssues findOne(ConnectionInterface $con = null) Return the first ChildIssues matching the query
 * @method     ChildIssues findOneOrCreate(ConnectionInterface $con = null) Return the first ChildIssues matching the query, or a new ChildIssues object populated from the query conditions when no match is found
 *
 * @method     ChildIssues findOneById(int $id) Return the first ChildIssues filtered by the id column
 * @method     ChildIssues findOneByName(string $_name) Return the first ChildIssues filtered by the _name column
 * @method     ChildIssues findOneByOpendate(int $_opendate) Return the first ChildIssues filtered by the _opendate column
 * @method     ChildIssues findOneByClosedate(int $_closedate) Return the first ChildIssues filtered by the _closedate column
 * @method     ChildIssues findOneByStatus(string $_status) Return the first ChildIssues filtered by the _status column
 * @method     ChildIssues findOneByInfotext(string $_infotext) Return the first ChildIssues filtered by the _infotext column
 * @method     ChildIssues findOneByForbook(int $_forbook) Return the first ChildIssues filtered by the _forbook column
 * @method     ChildIssues findOneByUserSys(int $__user__) Return the first ChildIssues filtered by the __user__ column
 * @method     ChildIssues findOneByConfigSys(string $__config__) Return the first ChildIssues filtered by the __config__ column
 * @method     ChildIssues findOneBySplit(string $__split__) Return the first ChildIssues filtered by the __split__ column
 * @method     ChildIssues findOneByParentnode(int $__parentnode__) Return the first ChildIssues filtered by the __parentnode__ column
 * @method     ChildIssues findOneBySort(int $__sort__) Return the first ChildIssues filtered by the __sort__ column *

 * @method     ChildIssues requirePk($key, ConnectionInterface $con = null) Return the ChildIssues by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIssues requireOne(ConnectionInterface $con = null) Return the first ChildIssues matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildIssues requireOneById(int $id) Return the first ChildIssues filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIssues requireOneByName(string $_name) Return the first ChildIssues filtered by the _name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIssues requireOneByOpendate(int $_opendate) Return the first ChildIssues filtered by the _opendate column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIssues requireOneByClosedate(int $_closedate) Return the first ChildIssues filtered by the _closedate column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIssues requireOneByStatus(string $_status) Return the first ChildIssues filtered by the _status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIssues requireOneByInfotext(string $_infotext) Return the first ChildIssues filtered by the _infotext column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIssues requireOneByForbook(int $_forbook) Return the first ChildIssues filtered by the _forbook column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIssues requireOneByUserSys(int $__user__) Return the first ChildIssues filtered by the __user__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIssues requireOneByConfigSys(string $__config__) Return the first ChildIssues filtered by the __config__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIssues requireOneBySplit(string $__split__) Return the first ChildIssues filtered by the __split__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIssues requireOneByParentnode(int $__parentnode__) Return the first ChildIssues filtered by the __parentnode__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIssues requireOneBySort(int $__sort__) Return the first ChildIssues filtered by the __sort__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildIssues[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildIssues objects based on current ModelCriteria
 * @method     ChildIssues[]|ObjectCollection findById(int $id) Return ChildIssues objects filtered by the id column
 * @method     ChildIssues[]|ObjectCollection findByName(string $_name) Return ChildIssues objects filtered by the _name column
 * @method     ChildIssues[]|ObjectCollection findByOpendate(int $_opendate) Return ChildIssues objects filtered by the _opendate column
 * @method     ChildIssues[]|ObjectCollection findByClosedate(int $_closedate) Return ChildIssues objects filtered by the _closedate column
 * @method     ChildIssues[]|ObjectCollection findByStatus(string $_status) Return ChildIssues objects filtered by the _status column
 * @method     ChildIssues[]|ObjectCollection findByInfotext(string $_infotext) Return ChildIssues objects filtered by the _infotext column
 * @method     ChildIssues[]|ObjectCollection findByForbook(int $_forbook) Return ChildIssues objects filtered by the _forbook column
 * @method     ChildIssues[]|ObjectCollection findByUserSys(int $__user__) Return ChildIssues objects filtered by the __user__ column
 * @method     ChildIssues[]|ObjectCollection findByConfigSys(string $__config__) Return ChildIssues objects filtered by the __config__ column
 * @method     ChildIssues[]|ObjectCollection findBySplit(string $__split__) Return ChildIssues objects filtered by the __split__ column
 * @method     ChildIssues[]|ObjectCollection findByParentnode(int $__parentnode__) Return ChildIssues objects filtered by the __parentnode__ column
 * @method     ChildIssues[]|ObjectCollection findBySort(int $__sort__) Return ChildIssues objects filtered by the __sort__ column
 * @method     ChildIssues[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class IssuesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\IssuesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'rokfor', $modelName = '\\Issues', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildIssuesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildIssuesQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildIssuesQuery) {
            return $criteria;
        }
        $query = new ChildIssuesQuery();
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
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildIssues|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = IssuesTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(IssuesTableMap::DATABASE_NAME);
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
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildIssues A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, _name, _opendate, _closedate, _status, _infotext, _forbook, __user__, __config__, __split__, __parentnode__, __sort__ FROM _issues WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildIssues $obj */
            $obj = new ChildIssues();
            $obj->hydrate($row);
            IssuesTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildIssues|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildIssuesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(IssuesTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildIssuesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(IssuesTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIssuesQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(IssuesTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(IssuesTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IssuesTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the _name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE _name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE _name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIssuesQuery The current query, for fluid interface
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

        return $this->addUsingAlias(IssuesTableMap::COL__NAME, $name, $comparison);
    }

    /**
     * Filter the query on the _opendate column
     *
     * Example usage:
     * <code>
     * $query->filterByOpendate(1234); // WHERE _opendate = 1234
     * $query->filterByOpendate(array(12, 34)); // WHERE _opendate IN (12, 34)
     * $query->filterByOpendate(array('min' => 12)); // WHERE _opendate > 12
     * </code>
     *
     * @param     mixed $opendate The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIssuesQuery The current query, for fluid interface
     */
    public function filterByOpendate($opendate = null, $comparison = null)
    {
        if (is_array($opendate)) {
            $useMinMax = false;
            if (isset($opendate['min'])) {
                $this->addUsingAlias(IssuesTableMap::COL__OPENDATE, $opendate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($opendate['max'])) {
                $this->addUsingAlias(IssuesTableMap::COL__OPENDATE, $opendate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IssuesTableMap::COL__OPENDATE, $opendate, $comparison);
    }

    /**
     * Filter the query on the _closedate column
     *
     * Example usage:
     * <code>
     * $query->filterByClosedate(1234); // WHERE _closedate = 1234
     * $query->filterByClosedate(array(12, 34)); // WHERE _closedate IN (12, 34)
     * $query->filterByClosedate(array('min' => 12)); // WHERE _closedate > 12
     * </code>
     *
     * @param     mixed $closedate The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIssuesQuery The current query, for fluid interface
     */
    public function filterByClosedate($closedate = null, $comparison = null)
    {
        if (is_array($closedate)) {
            $useMinMax = false;
            if (isset($closedate['min'])) {
                $this->addUsingAlias(IssuesTableMap::COL__CLOSEDATE, $closedate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($closedate['max'])) {
                $this->addUsingAlias(IssuesTableMap::COL__CLOSEDATE, $closedate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IssuesTableMap::COL__CLOSEDATE, $closedate, $comparison);
    }

    /**
     * Filter the query on the _status column
     *
     * Example usage:
     * <code>
     * $query->filterByStatus('fooValue');   // WHERE _status = 'fooValue'
     * $query->filterByStatus('%fooValue%'); // WHERE _status LIKE '%fooValue%'
     * </code>
     *
     * @param     string $status The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIssuesQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($status)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $status)) {
                $status = str_replace('*', '%', $status);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(IssuesTableMap::COL__STATUS, $status, $comparison);
    }

    /**
     * Filter the query on the _infotext column
     *
     * Example usage:
     * <code>
     * $query->filterByInfotext('fooValue');   // WHERE _infotext = 'fooValue'
     * $query->filterByInfotext('%fooValue%'); // WHERE _infotext LIKE '%fooValue%'
     * </code>
     *
     * @param     string $infotext The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIssuesQuery The current query, for fluid interface
     */
    public function filterByInfotext($infotext = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($infotext)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $infotext)) {
                $infotext = str_replace('*', '%', $infotext);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(IssuesTableMap::COL__INFOTEXT, $infotext, $comparison);
    }

    /**
     * Filter the query on the _forbook column
     *
     * Example usage:
     * <code>
     * $query->filterByForbook(1234); // WHERE _forbook = 1234
     * $query->filterByForbook(array(12, 34)); // WHERE _forbook IN (12, 34)
     * $query->filterByForbook(array('min' => 12)); // WHERE _forbook > 12
     * </code>
     *
     * @see       filterByBooks()
     *
     * @param     mixed $forbook The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIssuesQuery The current query, for fluid interface
     */
    public function filterByForbook($forbook = null, $comparison = null)
    {
        if (is_array($forbook)) {
            $useMinMax = false;
            if (isset($forbook['min'])) {
                $this->addUsingAlias(IssuesTableMap::COL__FORBOOK, $forbook['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($forbook['max'])) {
                $this->addUsingAlias(IssuesTableMap::COL__FORBOOK, $forbook['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IssuesTableMap::COL__FORBOOK, $forbook, $comparison);
    }

    /**
     * Filter the query on the __user__ column
     *
     * Example usage:
     * <code>
     * $query->filterByUserSys(1234); // WHERE __user__ = 1234
     * $query->filterByUserSys(array(12, 34)); // WHERE __user__ IN (12, 34)
     * $query->filterByUserSys(array('min' => 12)); // WHERE __user__ > 12
     * </code>
     *
     * @see       filterByuserSysRef()
     *
     * @param     mixed $userSys The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIssuesQuery The current query, for fluid interface
     */
    public function filterByUserSys($userSys = null, $comparison = null)
    {
        if (is_array($userSys)) {
            $useMinMax = false;
            if (isset($userSys['min'])) {
                $this->addUsingAlias(IssuesTableMap::COL___USER__, $userSys['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userSys['max'])) {
                $this->addUsingAlias(IssuesTableMap::COL___USER__, $userSys['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IssuesTableMap::COL___USER__, $userSys, $comparison);
    }

    /**
     * Filter the query on the __config__ column
     *
     * Example usage:
     * <code>
     * $query->filterByConfigSys('fooValue');   // WHERE __config__ = 'fooValue'
     * $query->filterByConfigSys('%fooValue%'); // WHERE __config__ LIKE '%fooValue%'
     * </code>
     *
     * @param     string $configSys The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIssuesQuery The current query, for fluid interface
     */
    public function filterByConfigSys($configSys = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($configSys)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $configSys)) {
                $configSys = str_replace('*', '%', $configSys);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(IssuesTableMap::COL___CONFIG__, $configSys, $comparison);
    }

    /**
     * Filter the query on the __split__ column
     *
     * Example usage:
     * <code>
     * $query->filterBySplit('fooValue');   // WHERE __split__ = 'fooValue'
     * $query->filterBySplit('%fooValue%'); // WHERE __split__ LIKE '%fooValue%'
     * </code>
     *
     * @param     string $split The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIssuesQuery The current query, for fluid interface
     */
    public function filterBySplit($split = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($split)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $split)) {
                $split = str_replace('*', '%', $split);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(IssuesTableMap::COL___SPLIT__, $split, $comparison);
    }

    /**
     * Filter the query on the __parentnode__ column
     *
     * Example usage:
     * <code>
     * $query->filterByParentnode(1234); // WHERE __parentnode__ = 1234
     * $query->filterByParentnode(array(12, 34)); // WHERE __parentnode__ IN (12, 34)
     * $query->filterByParentnode(array('min' => 12)); // WHERE __parentnode__ > 12
     * </code>
     *
     * @param     mixed $parentnode The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIssuesQuery The current query, for fluid interface
     */
    public function filterByParentnode($parentnode = null, $comparison = null)
    {
        if (is_array($parentnode)) {
            $useMinMax = false;
            if (isset($parentnode['min'])) {
                $this->addUsingAlias(IssuesTableMap::COL___PARENTNODE__, $parentnode['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parentnode['max'])) {
                $this->addUsingAlias(IssuesTableMap::COL___PARENTNODE__, $parentnode['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IssuesTableMap::COL___PARENTNODE__, $parentnode, $comparison);
    }

    /**
     * Filter the query on the __sort__ column
     *
     * Example usage:
     * <code>
     * $query->filterBySort(1234); // WHERE __sort__ = 1234
     * $query->filterBySort(array(12, 34)); // WHERE __sort__ IN (12, 34)
     * $query->filterBySort(array('min' => 12)); // WHERE __sort__ > 12
     * </code>
     *
     * @param     mixed $sort The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIssuesQuery The current query, for fluid interface
     */
    public function filterBySort($sort = null, $comparison = null)
    {
        if (is_array($sort)) {
            $useMinMax = false;
            if (isset($sort['min'])) {
                $this->addUsingAlias(IssuesTableMap::COL___SORT__, $sort['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sort['max'])) {
                $this->addUsingAlias(IssuesTableMap::COL___SORT__, $sort['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IssuesTableMap::COL___SORT__, $sort, $comparison);
    }

    /**
     * Filter the query by a related \Users object
     *
     * @param \Users|ObjectCollection $users The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildIssuesQuery The current query, for fluid interface
     */
    public function filterByuserSysRef($users, $comparison = null)
    {
        if ($users instanceof \Users) {
            return $this
                ->addUsingAlias(IssuesTableMap::COL___USER__, $users->getId(), $comparison);
        } elseif ($users instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(IssuesTableMap::COL___USER__, $users->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByuserSysRef() only accepts arguments of type \Users or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the userSysRef relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildIssuesQuery The current query, for fluid interface
     */
    public function joinuserSysRef($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('userSysRef');

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
            $this->addJoinObject($join, 'userSysRef');
        }

        return $this;
    }

    /**
     * Use the userSysRef relation Users object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UsersQuery A secondary query class using the current class as primary query
     */
    public function useuserSysRefQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinuserSysRef($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'userSysRef', '\UsersQuery');
    }

    /**
     * Filter the query by a related \Books object
     *
     * @param \Books|ObjectCollection $books The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildIssuesQuery The current query, for fluid interface
     */
    public function filterByBooks($books, $comparison = null)
    {
        if ($books instanceof \Books) {
            return $this
                ->addUsingAlias(IssuesTableMap::COL__FORBOOK, $books->getId(), $comparison);
        } elseif ($books instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(IssuesTableMap::COL__FORBOOK, $books->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByBooks() only accepts arguments of type \Books or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Books relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildIssuesQuery The current query, for fluid interface
     */
    public function joinBooks($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Books');

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
            $this->addJoinObject($join, 'Books');
        }

        return $this;
    }

    /**
     * Use the Books relation Books object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \BooksQuery A secondary query class using the current class as primary query
     */
    public function useBooksQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinBooks($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Books', '\BooksQuery');
    }

    /**
     * Filter the query by a related \RIssuesAllplugin object
     *
     * @param \RIssuesAllplugin|ObjectCollection $rIssuesAllplugin the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildIssuesQuery The current query, for fluid interface
     */
    public function filterByRIssuesAllplugin($rIssuesAllplugin, $comparison = null)
    {
        if ($rIssuesAllplugin instanceof \RIssuesAllplugin) {
            return $this
                ->addUsingAlias(IssuesTableMap::COL_ID, $rIssuesAllplugin->getIssueid(), $comparison);
        } elseif ($rIssuesAllplugin instanceof ObjectCollection) {
            return $this
                ->useRIssuesAllpluginQuery()
                ->filterByPrimaryKeys($rIssuesAllplugin->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRIssuesAllplugin() only accepts arguments of type \RIssuesAllplugin or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RIssuesAllplugin relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildIssuesQuery The current query, for fluid interface
     */
    public function joinRIssuesAllplugin($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RIssuesAllplugin');

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
            $this->addJoinObject($join, 'RIssuesAllplugin');
        }

        return $this;
    }

    /**
     * Use the RIssuesAllplugin relation RIssuesAllplugin object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RIssuesAllpluginQuery A secondary query class using the current class as primary query
     */
    public function useRIssuesAllpluginQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRIssuesAllplugin($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RIssuesAllplugin', '\RIssuesAllpluginQuery');
    }

    /**
     * Filter the query by a related \RIssuesNarrationplugin object
     *
     * @param \RIssuesNarrationplugin|ObjectCollection $rIssuesNarrationplugin the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildIssuesQuery The current query, for fluid interface
     */
    public function filterByRIssuesNarrationplugin($rIssuesNarrationplugin, $comparison = null)
    {
        if ($rIssuesNarrationplugin instanceof \RIssuesNarrationplugin) {
            return $this
                ->addUsingAlias(IssuesTableMap::COL_ID, $rIssuesNarrationplugin->getIssueid(), $comparison);
        } elseif ($rIssuesNarrationplugin instanceof ObjectCollection) {
            return $this
                ->useRIssuesNarrationpluginQuery()
                ->filterByPrimaryKeys($rIssuesNarrationplugin->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRIssuesNarrationplugin() only accepts arguments of type \RIssuesNarrationplugin or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RIssuesNarrationplugin relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildIssuesQuery The current query, for fluid interface
     */
    public function joinRIssuesNarrationplugin($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RIssuesNarrationplugin');

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
            $this->addJoinObject($join, 'RIssuesNarrationplugin');
        }

        return $this;
    }

    /**
     * Use the RIssuesNarrationplugin relation RIssuesNarrationplugin object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RIssuesNarrationpluginQuery A secondary query class using the current class as primary query
     */
    public function useRIssuesNarrationpluginQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRIssuesNarrationplugin($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RIssuesNarrationplugin', '\RIssuesNarrationpluginQuery');
    }

    /**
     * Filter the query by a related \RIssuesRtfplugin object
     *
     * @param \RIssuesRtfplugin|ObjectCollection $rIssuesRtfplugin the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildIssuesQuery The current query, for fluid interface
     */
    public function filterByRIssuesRtfplugin($rIssuesRtfplugin, $comparison = null)
    {
        if ($rIssuesRtfplugin instanceof \RIssuesRtfplugin) {
            return $this
                ->addUsingAlias(IssuesTableMap::COL_ID, $rIssuesRtfplugin->getIssueid(), $comparison);
        } elseif ($rIssuesRtfplugin instanceof ObjectCollection) {
            return $this
                ->useRIssuesRtfpluginQuery()
                ->filterByPrimaryKeys($rIssuesRtfplugin->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRIssuesRtfplugin() only accepts arguments of type \RIssuesRtfplugin or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RIssuesRtfplugin relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildIssuesQuery The current query, for fluid interface
     */
    public function joinRIssuesRtfplugin($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RIssuesRtfplugin');

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
            $this->addJoinObject($join, 'RIssuesRtfplugin');
        }

        return $this;
    }

    /**
     * Use the RIssuesRtfplugin relation RIssuesRtfplugin object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RIssuesRtfpluginQuery A secondary query class using the current class as primary query
     */
    public function useRIssuesRtfpluginQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRIssuesRtfplugin($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RIssuesRtfplugin', '\RIssuesRtfpluginQuery');
    }

    /**
     * Filter the query by a related \RIssuesSingleplugin object
     *
     * @param \RIssuesSingleplugin|ObjectCollection $rIssuesSingleplugin the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildIssuesQuery The current query, for fluid interface
     */
    public function filterByRIssuesSingleplugin($rIssuesSingleplugin, $comparison = null)
    {
        if ($rIssuesSingleplugin instanceof \RIssuesSingleplugin) {
            return $this
                ->addUsingAlias(IssuesTableMap::COL_ID, $rIssuesSingleplugin->getIssueid(), $comparison);
        } elseif ($rIssuesSingleplugin instanceof ObjectCollection) {
            return $this
                ->useRIssuesSinglepluginQuery()
                ->filterByPrimaryKeys($rIssuesSingleplugin->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRIssuesSingleplugin() only accepts arguments of type \RIssuesSingleplugin or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RIssuesSingleplugin relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildIssuesQuery The current query, for fluid interface
     */
    public function joinRIssuesSingleplugin($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RIssuesSingleplugin');

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
            $this->addJoinObject($join, 'RIssuesSingleplugin');
        }

        return $this;
    }

    /**
     * Use the RIssuesSingleplugin relation RIssuesSingleplugin object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RIssuesSinglepluginQuery A secondary query class using the current class as primary query
     */
    public function useRIssuesSinglepluginQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRIssuesSingleplugin($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RIssuesSingleplugin', '\RIssuesSinglepluginQuery');
    }

    /**
     * Filter the query by a related \RIssuesXmlplugin object
     *
     * @param \RIssuesXmlplugin|ObjectCollection $rIssuesXmlplugin the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildIssuesQuery The current query, for fluid interface
     */
    public function filterByRIssuesXmlplugin($rIssuesXmlplugin, $comparison = null)
    {
        if ($rIssuesXmlplugin instanceof \RIssuesXmlplugin) {
            return $this
                ->addUsingAlias(IssuesTableMap::COL_ID, $rIssuesXmlplugin->getIssueid(), $comparison);
        } elseif ($rIssuesXmlplugin instanceof ObjectCollection) {
            return $this
                ->useRIssuesXmlpluginQuery()
                ->filterByPrimaryKeys($rIssuesXmlplugin->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRIssuesXmlplugin() only accepts arguments of type \RIssuesXmlplugin or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RIssuesXmlplugin relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildIssuesQuery The current query, for fluid interface
     */
    public function joinRIssuesXmlplugin($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RIssuesXmlplugin');

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
            $this->addJoinObject($join, 'RIssuesXmlplugin');
        }

        return $this;
    }

    /**
     * Use the RIssuesXmlplugin relation RIssuesXmlplugin object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RIssuesXmlpluginQuery A secondary query class using the current class as primary query
     */
    public function useRIssuesXmlpluginQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRIssuesXmlplugin($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RIssuesXmlplugin', '\RIssuesXmlpluginQuery');
    }

    /**
     * Filter the query by a related \RRightsForissue object
     *
     * @param \RRightsForissue|ObjectCollection $rRightsForissue the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildIssuesQuery The current query, for fluid interface
     */
    public function filterByRRightsForissue($rRightsForissue, $comparison = null)
    {
        if ($rRightsForissue instanceof \RRightsForissue) {
            return $this
                ->addUsingAlias(IssuesTableMap::COL_ID, $rRightsForissue->getIssueid(), $comparison);
        } elseif ($rRightsForissue instanceof ObjectCollection) {
            return $this
                ->useRRightsForissueQuery()
                ->filterByPrimaryKeys($rRightsForissue->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRRightsForissue() only accepts arguments of type \RRightsForissue or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RRightsForissue relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildIssuesQuery The current query, for fluid interface
     */
    public function joinRRightsForissue($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RRightsForissue');

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
            $this->addJoinObject($join, 'RRightsForissue');
        }

        return $this;
    }

    /**
     * Use the RRightsForissue relation RRightsForissue object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RRightsForissueQuery A secondary query class using the current class as primary query
     */
    public function useRRightsForissueQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRRightsForissue($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RRightsForissue', '\RRightsForissueQuery');
    }

    /**
     * Filter the query by a related \Contributions object
     *
     * @param \Contributions|ObjectCollection $contributions the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildIssuesQuery The current query, for fluid interface
     */
    public function filterByContributions($contributions, $comparison = null)
    {
        if ($contributions instanceof \Contributions) {
            return $this
                ->addUsingAlias(IssuesTableMap::COL_ID, $contributions->getForissue(), $comparison);
        } elseif ($contributions instanceof ObjectCollection) {
            return $this
                ->useContributionsQuery()
                ->filterByPrimaryKeys($contributions->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByContributions() only accepts arguments of type \Contributions or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Contributions relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildIssuesQuery The current query, for fluid interface
     */
    public function joinContributions($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Contributions');

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
            $this->addJoinObject($join, 'Contributions');
        }

        return $this;
    }

    /**
     * Use the Contributions relation Contributions object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ContributionsQuery A secondary query class using the current class as primary query
     */
    public function useContributionsQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinContributions($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Contributions', '\ContributionsQuery');
    }

    /**
     * Filter the query by a related Plugins object
     * using the R_issues_allplugin table as cross reference
     *
     * @param Plugins $plugins the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildIssuesQuery The current query, for fluid interface
     */
    public function filterByAllPlugin($plugins, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRIssuesAllpluginQuery()
            ->filterByAllPlugin($plugins, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Plugins object
     * using the R_issues_narrationplugin table as cross reference
     *
     * @param Plugins $plugins the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildIssuesQuery The current query, for fluid interface
     */
    public function filterByNarrationPlugin($plugins, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRIssuesNarrationpluginQuery()
            ->filterByNarrationPlugin($plugins, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Plugins object
     * using the R_issues_rtfplugin table as cross reference
     *
     * @param Plugins $plugins the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildIssuesQuery The current query, for fluid interface
     */
    public function filterByRtfPlugin($plugins, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRIssuesRtfpluginQuery()
            ->filterByRtfPlugin($plugins, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Plugins object
     * using the R_issues_singleplugin table as cross reference
     *
     * @param Plugins $plugins the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildIssuesQuery The current query, for fluid interface
     */
    public function filterBySinglePlugin($plugins, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRIssuesSinglepluginQuery()
            ->filterBySinglePlugin($plugins, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Plugins object
     * using the R_issues_xmlplugin table as cross reference
     *
     * @param Plugins $plugins the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildIssuesQuery The current query, for fluid interface
     */
    public function filterByXmlPlugin($plugins, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRIssuesXmlpluginQuery()
            ->filterByXmlPlugin($plugins, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Rights object
     * using the R_rights_forissue table as cross reference
     *
     * @param Rights $rights the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildIssuesQuery The current query, for fluid interface
     */
    public function filterByRights($rights, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRRightsForissueQuery()
            ->filterByRights($rights, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildIssues $issues Object to remove from the list of results
     *
     * @return $this|ChildIssuesQuery The current query, for fluid interface
     */
    public function prune($issues = null)
    {
        if ($issues) {
            $this->addUsingAlias(IssuesTableMap::COL_ID, $issues->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the _issues table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(IssuesTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            IssuesTableMap::clearInstancePool();
            IssuesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(IssuesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(IssuesTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            IssuesTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            IssuesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // IssuesQuery
