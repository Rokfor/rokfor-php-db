<?php

namespace Base;

use \Plugins as ChildPlugins;
use \PluginsQuery as ChildPluginsQuery;
use \Exception;
use \PDO;
use Map\PluginsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the '_plugins' table.
 *
 *
 *
 * @method     ChildPluginsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPluginsQuery orderByName($order = Criteria::ASC) Order by the _name column
 * @method     ChildPluginsQuery orderByUserSys($order = Criteria::ASC) Order by the __user__ column
 * @method     ChildPluginsQuery orderByConfigSys($order = Criteria::ASC) Order by the __config__ column
 * @method     ChildPluginsQuery orderBySplit($order = Criteria::ASC) Order by the __split__ column
 * @method     ChildPluginsQuery orderByParentnode($order = Criteria::ASC) Order by the __parentnode__ column
 * @method     ChildPluginsQuery orderBySort($order = Criteria::ASC) Order by the __sort__ column
 * @method     ChildPluginsQuery orderByPage($order = Criteria::ASC) Order by the _page column
 * @method     ChildPluginsQuery orderByConfig($order = Criteria::ASC) Order by the _config column
 * @method     ChildPluginsQuery orderByCallback($order = Criteria::ASC) Order by the _callback column
 *
 * @method     ChildPluginsQuery groupById() Group by the id column
 * @method     ChildPluginsQuery groupByName() Group by the _name column
 * @method     ChildPluginsQuery groupByUserSys() Group by the __user__ column
 * @method     ChildPluginsQuery groupByConfigSys() Group by the __config__ column
 * @method     ChildPluginsQuery groupBySplit() Group by the __split__ column
 * @method     ChildPluginsQuery groupByParentnode() Group by the __parentnode__ column
 * @method     ChildPluginsQuery groupBySort() Group by the __sort__ column
 * @method     ChildPluginsQuery groupByPage() Group by the _page column
 * @method     ChildPluginsQuery groupByConfig() Group by the _config column
 * @method     ChildPluginsQuery groupByCallback() Group by the _callback column
 *
 * @method     ChildPluginsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPluginsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPluginsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPluginsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPluginsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPluginsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPluginsQuery leftJoinRIssuesAllplugin($relationAlias = null) Adds a LEFT JOIN clause to the query using the RIssuesAllplugin relation
 * @method     ChildPluginsQuery rightJoinRIssuesAllplugin($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RIssuesAllplugin relation
 * @method     ChildPluginsQuery innerJoinRIssuesAllplugin($relationAlias = null) Adds a INNER JOIN clause to the query using the RIssuesAllplugin relation
 *
 * @method     ChildPluginsQuery joinWithRIssuesAllplugin($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RIssuesAllplugin relation
 *
 * @method     ChildPluginsQuery leftJoinWithRIssuesAllplugin() Adds a LEFT JOIN clause and with to the query using the RIssuesAllplugin relation
 * @method     ChildPluginsQuery rightJoinWithRIssuesAllplugin() Adds a RIGHT JOIN clause and with to the query using the RIssuesAllplugin relation
 * @method     ChildPluginsQuery innerJoinWithRIssuesAllplugin() Adds a INNER JOIN clause and with to the query using the RIssuesAllplugin relation
 *
 * @method     ChildPluginsQuery leftJoinRIssuesNarrationplugin($relationAlias = null) Adds a LEFT JOIN clause to the query using the RIssuesNarrationplugin relation
 * @method     ChildPluginsQuery rightJoinRIssuesNarrationplugin($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RIssuesNarrationplugin relation
 * @method     ChildPluginsQuery innerJoinRIssuesNarrationplugin($relationAlias = null) Adds a INNER JOIN clause to the query using the RIssuesNarrationplugin relation
 *
 * @method     ChildPluginsQuery joinWithRIssuesNarrationplugin($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RIssuesNarrationplugin relation
 *
 * @method     ChildPluginsQuery leftJoinWithRIssuesNarrationplugin() Adds a LEFT JOIN clause and with to the query using the RIssuesNarrationplugin relation
 * @method     ChildPluginsQuery rightJoinWithRIssuesNarrationplugin() Adds a RIGHT JOIN clause and with to the query using the RIssuesNarrationplugin relation
 * @method     ChildPluginsQuery innerJoinWithRIssuesNarrationplugin() Adds a INNER JOIN clause and with to the query using the RIssuesNarrationplugin relation
 *
 * @method     ChildPluginsQuery leftJoinRIssuesRtfplugin($relationAlias = null) Adds a LEFT JOIN clause to the query using the RIssuesRtfplugin relation
 * @method     ChildPluginsQuery rightJoinRIssuesRtfplugin($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RIssuesRtfplugin relation
 * @method     ChildPluginsQuery innerJoinRIssuesRtfplugin($relationAlias = null) Adds a INNER JOIN clause to the query using the RIssuesRtfplugin relation
 *
 * @method     ChildPluginsQuery joinWithRIssuesRtfplugin($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RIssuesRtfplugin relation
 *
 * @method     ChildPluginsQuery leftJoinWithRIssuesRtfplugin() Adds a LEFT JOIN clause and with to the query using the RIssuesRtfplugin relation
 * @method     ChildPluginsQuery rightJoinWithRIssuesRtfplugin() Adds a RIGHT JOIN clause and with to the query using the RIssuesRtfplugin relation
 * @method     ChildPluginsQuery innerJoinWithRIssuesRtfplugin() Adds a INNER JOIN clause and with to the query using the RIssuesRtfplugin relation
 *
 * @method     ChildPluginsQuery leftJoinRIssuesSingleplugin($relationAlias = null) Adds a LEFT JOIN clause to the query using the RIssuesSingleplugin relation
 * @method     ChildPluginsQuery rightJoinRIssuesSingleplugin($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RIssuesSingleplugin relation
 * @method     ChildPluginsQuery innerJoinRIssuesSingleplugin($relationAlias = null) Adds a INNER JOIN clause to the query using the RIssuesSingleplugin relation
 *
 * @method     ChildPluginsQuery joinWithRIssuesSingleplugin($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RIssuesSingleplugin relation
 *
 * @method     ChildPluginsQuery leftJoinWithRIssuesSingleplugin() Adds a LEFT JOIN clause and with to the query using the RIssuesSingleplugin relation
 * @method     ChildPluginsQuery rightJoinWithRIssuesSingleplugin() Adds a RIGHT JOIN clause and with to the query using the RIssuesSingleplugin relation
 * @method     ChildPluginsQuery innerJoinWithRIssuesSingleplugin() Adds a INNER JOIN clause and with to the query using the RIssuesSingleplugin relation
 *
 * @method     ChildPluginsQuery leftJoinRIssuesXmlplugin($relationAlias = null) Adds a LEFT JOIN clause to the query using the RIssuesXmlplugin relation
 * @method     ChildPluginsQuery rightJoinRIssuesXmlplugin($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RIssuesXmlplugin relation
 * @method     ChildPluginsQuery innerJoinRIssuesXmlplugin($relationAlias = null) Adds a INNER JOIN clause to the query using the RIssuesXmlplugin relation
 *
 * @method     ChildPluginsQuery joinWithRIssuesXmlplugin($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RIssuesXmlplugin relation
 *
 * @method     ChildPluginsQuery leftJoinWithRIssuesXmlplugin() Adds a LEFT JOIN clause and with to the query using the RIssuesXmlplugin relation
 * @method     ChildPluginsQuery rightJoinWithRIssuesXmlplugin() Adds a RIGHT JOIN clause and with to the query using the RIssuesXmlplugin relation
 * @method     ChildPluginsQuery innerJoinWithRIssuesXmlplugin() Adds a INNER JOIN clause and with to the query using the RIssuesXmlplugin relation
 *
 * @method     \RIssuesAllpluginQuery|\RIssuesNarrationpluginQuery|\RIssuesRtfpluginQuery|\RIssuesSinglepluginQuery|\RIssuesXmlpluginQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPlugins findOne(ConnectionInterface $con = null) Return the first ChildPlugins matching the query
 * @method     ChildPlugins findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPlugins matching the query, or a new ChildPlugins object populated from the query conditions when no match is found
 *
 * @method     ChildPlugins findOneById(int $id) Return the first ChildPlugins filtered by the id column
 * @method     ChildPlugins findOneByName(string $_name) Return the first ChildPlugins filtered by the _name column
 * @method     ChildPlugins findOneByUserSys(string $__user__) Return the first ChildPlugins filtered by the __user__ column
 * @method     ChildPlugins findOneByConfigSys(string $__config__) Return the first ChildPlugins filtered by the __config__ column
 * @method     ChildPlugins findOneBySplit(string $__split__) Return the first ChildPlugins filtered by the __split__ column
 * @method     ChildPlugins findOneByParentnode(int $__parentnode__) Return the first ChildPlugins filtered by the __parentnode__ column
 * @method     ChildPlugins findOneBySort(int $__sort__) Return the first ChildPlugins filtered by the __sort__ column
 * @method     ChildPlugins findOneByPage(string $_page) Return the first ChildPlugins filtered by the _page column
 * @method     ChildPlugins findOneByConfig(string $_config) Return the first ChildPlugins filtered by the _config column
 * @method     ChildPlugins findOneByCallback(string $_callback) Return the first ChildPlugins filtered by the _callback column *

 * @method     ChildPlugins requirePk($key, ConnectionInterface $con = null) Return the ChildPlugins by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlugins requireOne(ConnectionInterface $con = null) Return the first ChildPlugins matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPlugins requireOneById(int $id) Return the first ChildPlugins filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlugins requireOneByName(string $_name) Return the first ChildPlugins filtered by the _name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlugins requireOneByUserSys(string $__user__) Return the first ChildPlugins filtered by the __user__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlugins requireOneByConfigSys(string $__config__) Return the first ChildPlugins filtered by the __config__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlugins requireOneBySplit(string $__split__) Return the first ChildPlugins filtered by the __split__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlugins requireOneByParentnode(int $__parentnode__) Return the first ChildPlugins filtered by the __parentnode__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlugins requireOneBySort(int $__sort__) Return the first ChildPlugins filtered by the __sort__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlugins requireOneByPage(string $_page) Return the first ChildPlugins filtered by the _page column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlugins requireOneByConfig(string $_config) Return the first ChildPlugins filtered by the _config column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlugins requireOneByCallback(string $_callback) Return the first ChildPlugins filtered by the _callback column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPlugins[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPlugins objects based on current ModelCriteria
 * @method     ChildPlugins[]|ObjectCollection findById(int $id) Return ChildPlugins objects filtered by the id column
 * @method     ChildPlugins[]|ObjectCollection findByName(string $_name) Return ChildPlugins objects filtered by the _name column
 * @method     ChildPlugins[]|ObjectCollection findByUserSys(string $__user__) Return ChildPlugins objects filtered by the __user__ column
 * @method     ChildPlugins[]|ObjectCollection findByConfigSys(string $__config__) Return ChildPlugins objects filtered by the __config__ column
 * @method     ChildPlugins[]|ObjectCollection findBySplit(string $__split__) Return ChildPlugins objects filtered by the __split__ column
 * @method     ChildPlugins[]|ObjectCollection findByParentnode(int $__parentnode__) Return ChildPlugins objects filtered by the __parentnode__ column
 * @method     ChildPlugins[]|ObjectCollection findBySort(int $__sort__) Return ChildPlugins objects filtered by the __sort__ column
 * @method     ChildPlugins[]|ObjectCollection findByPage(string $_page) Return ChildPlugins objects filtered by the _page column
 * @method     ChildPlugins[]|ObjectCollection findByConfig(string $_config) Return ChildPlugins objects filtered by the _config column
 * @method     ChildPlugins[]|ObjectCollection findByCallback(string $_callback) Return ChildPlugins objects filtered by the _callback column
 * @method     ChildPlugins[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PluginsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\PluginsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'rokfor', $modelName = '\\Plugins', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPluginsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPluginsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPluginsQuery) {
            return $criteria;
        }
        $query = new ChildPluginsQuery();
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
     * @return ChildPlugins|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PluginsTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PluginsTableMap::DATABASE_NAME);
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
     * @return ChildPlugins A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, _name, __user__, __config__, __split__, __parentnode__, __sort__, _page, _config, _callback FROM _plugins WHERE id = :p0';
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
            /** @var ChildPlugins $obj */
            $obj = new ChildPlugins();
            $obj->hydrate($row);
            PluginsTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildPlugins|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPluginsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PluginsTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPluginsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PluginsTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPluginsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PluginsTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PluginsTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PluginsTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildPluginsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PluginsTableMap::COL__NAME, $name, $comparison);
    }

    /**
     * Filter the query on the __user__ column
     *
     * Example usage:
     * <code>
     * $query->filterByUserSys('fooValue');   // WHERE __user__ = 'fooValue'
     * $query->filterByUserSys('%fooValue%'); // WHERE __user__ LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userSys The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPluginsQuery The current query, for fluid interface
     */
    public function filterByUserSys($userSys = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userSys)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $userSys)) {
                $userSys = str_replace('*', '%', $userSys);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginsTableMap::COL___USER__, $userSys, $comparison);
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
     * @return $this|ChildPluginsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PluginsTableMap::COL___CONFIG__, $configSys, $comparison);
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
     * @return $this|ChildPluginsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PluginsTableMap::COL___SPLIT__, $split, $comparison);
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
     * @return $this|ChildPluginsQuery The current query, for fluid interface
     */
    public function filterByParentnode($parentnode = null, $comparison = null)
    {
        if (is_array($parentnode)) {
            $useMinMax = false;
            if (isset($parentnode['min'])) {
                $this->addUsingAlias(PluginsTableMap::COL___PARENTNODE__, $parentnode['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parentnode['max'])) {
                $this->addUsingAlias(PluginsTableMap::COL___PARENTNODE__, $parentnode['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PluginsTableMap::COL___PARENTNODE__, $parentnode, $comparison);
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
     * @return $this|ChildPluginsQuery The current query, for fluid interface
     */
    public function filterBySort($sort = null, $comparison = null)
    {
        if (is_array($sort)) {
            $useMinMax = false;
            if (isset($sort['min'])) {
                $this->addUsingAlias(PluginsTableMap::COL___SORT__, $sort['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sort['max'])) {
                $this->addUsingAlias(PluginsTableMap::COL___SORT__, $sort['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PluginsTableMap::COL___SORT__, $sort, $comparison);
    }

    /**
     * Filter the query on the _page column
     *
     * Example usage:
     * <code>
     * $query->filterByPage('fooValue');   // WHERE _page = 'fooValue'
     * $query->filterByPage('%fooValue%'); // WHERE _page LIKE '%fooValue%'
     * </code>
     *
     * @param     string $page The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPluginsQuery The current query, for fluid interface
     */
    public function filterByPage($page = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($page)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $page)) {
                $page = str_replace('*', '%', $page);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginsTableMap::COL__PAGE, $page, $comparison);
    }

    /**
     * Filter the query on the _config column
     *
     * Example usage:
     * <code>
     * $query->filterByConfig('fooValue');   // WHERE _config = 'fooValue'
     * $query->filterByConfig('%fooValue%'); // WHERE _config LIKE '%fooValue%'
     * </code>
     *
     * @param     string $config The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPluginsQuery The current query, for fluid interface
     */
    public function filterByConfig($config = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($config)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $config)) {
                $config = str_replace('*', '%', $config);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginsTableMap::COL__CONFIG, $config, $comparison);
    }

    /**
     * Filter the query on the _callback column
     *
     * Example usage:
     * <code>
     * $query->filterByCallback('fooValue');   // WHERE _callback = 'fooValue'
     * $query->filterByCallback('%fooValue%'); // WHERE _callback LIKE '%fooValue%'
     * </code>
     *
     * @param     string $callback The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPluginsQuery The current query, for fluid interface
     */
    public function filterByCallback($callback = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($callback)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $callback)) {
                $callback = str_replace('*', '%', $callback);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginsTableMap::COL__CALLBACK, $callback, $comparison);
    }

    /**
     * Filter the query by a related \RIssuesAllplugin object
     *
     * @param \RIssuesAllplugin|ObjectCollection $rIssuesAllplugin the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginsQuery The current query, for fluid interface
     */
    public function filterByRIssuesAllplugin($rIssuesAllplugin, $comparison = null)
    {
        if ($rIssuesAllplugin instanceof \RIssuesAllplugin) {
            return $this
                ->addUsingAlias(PluginsTableMap::COL_ID, $rIssuesAllplugin->getPluginid(), $comparison);
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
     * @return $this|ChildPluginsQuery The current query, for fluid interface
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
     * @return ChildPluginsQuery The current query, for fluid interface
     */
    public function filterByRIssuesNarrationplugin($rIssuesNarrationplugin, $comparison = null)
    {
        if ($rIssuesNarrationplugin instanceof \RIssuesNarrationplugin) {
            return $this
                ->addUsingAlias(PluginsTableMap::COL_ID, $rIssuesNarrationplugin->getPluginid(), $comparison);
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
     * @return $this|ChildPluginsQuery The current query, for fluid interface
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
     * @return ChildPluginsQuery The current query, for fluid interface
     */
    public function filterByRIssuesRtfplugin($rIssuesRtfplugin, $comparison = null)
    {
        if ($rIssuesRtfplugin instanceof \RIssuesRtfplugin) {
            return $this
                ->addUsingAlias(PluginsTableMap::COL_ID, $rIssuesRtfplugin->getPluginid(), $comparison);
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
     * @return $this|ChildPluginsQuery The current query, for fluid interface
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
     * @return ChildPluginsQuery The current query, for fluid interface
     */
    public function filterByRIssuesSingleplugin($rIssuesSingleplugin, $comparison = null)
    {
        if ($rIssuesSingleplugin instanceof \RIssuesSingleplugin) {
            return $this
                ->addUsingAlias(PluginsTableMap::COL_ID, $rIssuesSingleplugin->getPluginid(), $comparison);
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
     * @return $this|ChildPluginsQuery The current query, for fluid interface
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
     * @return ChildPluginsQuery The current query, for fluid interface
     */
    public function filterByRIssuesXmlplugin($rIssuesXmlplugin, $comparison = null)
    {
        if ($rIssuesXmlplugin instanceof \RIssuesXmlplugin) {
            return $this
                ->addUsingAlias(PluginsTableMap::COL_ID, $rIssuesXmlplugin->getPluginid(), $comparison);
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
     * @return $this|ChildPluginsQuery The current query, for fluid interface
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
     * Filter the query by a related Issues object
     * using the R_issues_allplugin table as cross reference
     *
     * @param Issues $issues the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginsQuery The current query, for fluid interface
     */
    public function filterByAllIssue($issues, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRIssuesAllpluginQuery()
            ->filterByAllIssue($issues, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Issues object
     * using the R_issues_narrationplugin table as cross reference
     *
     * @param Issues $issues the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginsQuery The current query, for fluid interface
     */
    public function filterByNarrationIssue($issues, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRIssuesNarrationpluginQuery()
            ->filterByNarrationIssue($issues, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Issues object
     * using the R_issues_rtfplugin table as cross reference
     *
     * @param Issues $issues the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginsQuery The current query, for fluid interface
     */
    public function filterByRtfIssue($issues, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRIssuesRtfpluginQuery()
            ->filterByRtfIssue($issues, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Issues object
     * using the R_issues_singleplugin table as cross reference
     *
     * @param Issues $issues the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginsQuery The current query, for fluid interface
     */
    public function filterBySingleIssue($issues, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRIssuesSinglepluginQuery()
            ->filterBySingleIssue($issues, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Issues object
     * using the R_issues_xmlplugin table as cross reference
     *
     * @param Issues $issues the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginsQuery The current query, for fluid interface
     */
    public function filterByXmlIssue($issues, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRIssuesXmlpluginQuery()
            ->filterByXmlIssue($issues, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPlugins $plugins Object to remove from the list of results
     *
     * @return $this|ChildPluginsQuery The current query, for fluid interface
     */
    public function prune($plugins = null)
    {
        if ($plugins) {
            $this->addUsingAlias(PluginsTableMap::COL_ID, $plugins->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the _plugins table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PluginsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PluginsTableMap::clearInstancePool();
            PluginsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PluginsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PluginsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PluginsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PluginsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PluginsQuery
