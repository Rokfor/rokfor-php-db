<?php

namespace Base;

use \Data as ChildData;
use \DataQuery as ChildDataQuery;
use \Exception;
use \PDO;
use Map\DataTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the '_data' table.
 *
 *
 *
 * @method     ChildDataQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildDataQuery orderByForcontribution($order = Criteria::ASC) Order by the _forcontribution column
 * @method     ChildDataQuery orderByFortemplatefield($order = Criteria::ASC) Order by the _fortemplatefield column
 * @method     ChildDataQuery orderByContent($order = Criteria::ASC) Order by the _content column
 * @method     ChildDataQuery orderByIsjson($order = Criteria::ASC) Order by the _isjson column
 * @method     ChildDataQuery orderByUserSys($order = Criteria::ASC) Order by the __user__ column
 * @method     ChildDataQuery orderByConfigSys($order = Criteria::ASC) Order by the __config__ column
 * @method     ChildDataQuery orderBySplit($order = Criteria::ASC) Order by the __split__ column
 * @method     ChildDataQuery orderByParentnode($order = Criteria::ASC) Order by the __parentnode__ column
 * @method     ChildDataQuery orderBySort($order = Criteria::ASC) Order by the __sort__ column
 *
 * @method     ChildDataQuery groupById() Group by the id column
 * @method     ChildDataQuery groupByForcontribution() Group by the _forcontribution column
 * @method     ChildDataQuery groupByFortemplatefield() Group by the _fortemplatefield column
 * @method     ChildDataQuery groupByContent() Group by the _content column
 * @method     ChildDataQuery groupByIsjson() Group by the _isjson column
 * @method     ChildDataQuery groupByUserSys() Group by the __user__ column
 * @method     ChildDataQuery groupByConfigSys() Group by the __config__ column
 * @method     ChildDataQuery groupBySplit() Group by the __split__ column
 * @method     ChildDataQuery groupByParentnode() Group by the __parentnode__ column
 * @method     ChildDataQuery groupBySort() Group by the __sort__ column
 *
 * @method     ChildDataQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDataQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDataQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDataQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildDataQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildDataQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildDataQuery leftJoinContributions($relationAlias = null) Adds a LEFT JOIN clause to the query using the Contributions relation
 * @method     ChildDataQuery rightJoinContributions($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Contributions relation
 * @method     ChildDataQuery innerJoinContributions($relationAlias = null) Adds a INNER JOIN clause to the query using the Contributions relation
 *
 * @method     ChildDataQuery joinWithContributions($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Contributions relation
 *
 * @method     ChildDataQuery leftJoinWithContributions() Adds a LEFT JOIN clause and with to the query using the Contributions relation
 * @method     ChildDataQuery rightJoinWithContributions() Adds a RIGHT JOIN clause and with to the query using the Contributions relation
 * @method     ChildDataQuery innerJoinWithContributions() Adds a INNER JOIN clause and with to the query using the Contributions relation
 *
 * @method     ChildDataQuery leftJoinTemplates($relationAlias = null) Adds a LEFT JOIN clause to the query using the Templates relation
 * @method     ChildDataQuery rightJoinTemplates($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Templates relation
 * @method     ChildDataQuery innerJoinTemplates($relationAlias = null) Adds a INNER JOIN clause to the query using the Templates relation
 *
 * @method     ChildDataQuery joinWithTemplates($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Templates relation
 *
 * @method     ChildDataQuery leftJoinWithTemplates() Adds a LEFT JOIN clause and with to the query using the Templates relation
 * @method     ChildDataQuery rightJoinWithTemplates() Adds a RIGHT JOIN clause and with to the query using the Templates relation
 * @method     ChildDataQuery innerJoinWithTemplates() Adds a INNER JOIN clause and with to the query using the Templates relation
 *
 * @method     \ContributionsQuery|\TemplatesQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildData findOne(ConnectionInterface $con = null) Return the first ChildData matching the query
 * @method     ChildData findOneOrCreate(ConnectionInterface $con = null) Return the first ChildData matching the query, or a new ChildData object populated from the query conditions when no match is found
 *
 * @method     ChildData findOneById(int $id) Return the first ChildData filtered by the id column
 * @method     ChildData findOneByForcontribution(int $_forcontribution) Return the first ChildData filtered by the _forcontribution column
 * @method     ChildData findOneByFortemplatefield(int $_fortemplatefield) Return the first ChildData filtered by the _fortemplatefield column
 * @method     ChildData findOneByContent(string $_content) Return the first ChildData filtered by the _content column
 * @method     ChildData findOneByIsjson(boolean $_isjson) Return the first ChildData filtered by the _isjson column
 * @method     ChildData findOneByUserSys(string $__user__) Return the first ChildData filtered by the __user__ column
 * @method     ChildData findOneByConfigSys(string $__config__) Return the first ChildData filtered by the __config__ column
 * @method     ChildData findOneBySplit(string $__split__) Return the first ChildData filtered by the __split__ column
 * @method     ChildData findOneByParentnode(int $__parentnode__) Return the first ChildData filtered by the __parentnode__ column
 * @method     ChildData findOneBySort(int $__sort__) Return the first ChildData filtered by the __sort__ column *

 * @method     ChildData requirePk($key, ConnectionInterface $con = null) Return the ChildData by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildData requireOne(ConnectionInterface $con = null) Return the first ChildData matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildData requireOneById(int $id) Return the first ChildData filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildData requireOneByForcontribution(int $_forcontribution) Return the first ChildData filtered by the _forcontribution column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildData requireOneByFortemplatefield(int $_fortemplatefield) Return the first ChildData filtered by the _fortemplatefield column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildData requireOneByContent(string $_content) Return the first ChildData filtered by the _content column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildData requireOneByIsjson(boolean $_isjson) Return the first ChildData filtered by the _isjson column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildData requireOneByUserSys(string $__user__) Return the first ChildData filtered by the __user__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildData requireOneByConfigSys(string $__config__) Return the first ChildData filtered by the __config__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildData requireOneBySplit(string $__split__) Return the first ChildData filtered by the __split__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildData requireOneByParentnode(int $__parentnode__) Return the first ChildData filtered by the __parentnode__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildData requireOneBySort(int $__sort__) Return the first ChildData filtered by the __sort__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildData[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildData objects based on current ModelCriteria
 * @method     ChildData[]|ObjectCollection findById(int $id) Return ChildData objects filtered by the id column
 * @method     ChildData[]|ObjectCollection findByForcontribution(int $_forcontribution) Return ChildData objects filtered by the _forcontribution column
 * @method     ChildData[]|ObjectCollection findByFortemplatefield(int $_fortemplatefield) Return ChildData objects filtered by the _fortemplatefield column
 * @method     ChildData[]|ObjectCollection findByContent(string $_content) Return ChildData objects filtered by the _content column
 * @method     ChildData[]|ObjectCollection findByIsjson(boolean $_isjson) Return ChildData objects filtered by the _isjson column
 * @method     ChildData[]|ObjectCollection findByUserSys(string $__user__) Return ChildData objects filtered by the __user__ column
 * @method     ChildData[]|ObjectCollection findByConfigSys(string $__config__) Return ChildData objects filtered by the __config__ column
 * @method     ChildData[]|ObjectCollection findBySplit(string $__split__) Return ChildData objects filtered by the __split__ column
 * @method     ChildData[]|ObjectCollection findByParentnode(int $__parentnode__) Return ChildData objects filtered by the __parentnode__ column
 * @method     ChildData[]|ObjectCollection findBySort(int $__sort__) Return ChildData objects filtered by the __sort__ column
 * @method     ChildData[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class DataQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\DataQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'rokfor', $modelName = '\\Data', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDataQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDataQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildDataQuery) {
            return $criteria;
        }
        $query = new ChildDataQuery();
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
     * @return ChildData|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = DataTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DataTableMap::DATABASE_NAME);
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
     * @return ChildData A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, _forcontribution, _fortemplatefield, _content, _isjson, __user__, __config__, __split__, __parentnode__, __sort__ FROM _data WHERE id = :p0';
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
            /** @var ChildData $obj */
            $obj = new ChildData();
            $obj->hydrate($row);
            DataTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildData|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildDataQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(DataTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildDataQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(DataTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildDataQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(DataTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(DataTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DataTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the _forcontribution column
     *
     * Example usage:
     * <code>
     * $query->filterByForcontribution(1234); // WHERE _forcontribution = 1234
     * $query->filterByForcontribution(array(12, 34)); // WHERE _forcontribution IN (12, 34)
     * $query->filterByForcontribution(array('min' => 12)); // WHERE _forcontribution > 12
     * </code>
     *
     * @see       filterByContributions()
     *
     * @param     mixed $forcontribution The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDataQuery The current query, for fluid interface
     */
    public function filterByForcontribution($forcontribution = null, $comparison = null)
    {
        if (is_array($forcontribution)) {
            $useMinMax = false;
            if (isset($forcontribution['min'])) {
                $this->addUsingAlias(DataTableMap::COL__FORCONTRIBUTION, $forcontribution['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($forcontribution['max'])) {
                $this->addUsingAlias(DataTableMap::COL__FORCONTRIBUTION, $forcontribution['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DataTableMap::COL__FORCONTRIBUTION, $forcontribution, $comparison);
    }

    /**
     * Filter the query on the _fortemplatefield column
     *
     * Example usage:
     * <code>
     * $query->filterByFortemplatefield(1234); // WHERE _fortemplatefield = 1234
     * $query->filterByFortemplatefield(array(12, 34)); // WHERE _fortemplatefield IN (12, 34)
     * $query->filterByFortemplatefield(array('min' => 12)); // WHERE _fortemplatefield > 12
     * </code>
     *
     * @see       filterByTemplates()
     *
     * @param     mixed $fortemplatefield The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDataQuery The current query, for fluid interface
     */
    public function filterByFortemplatefield($fortemplatefield = null, $comparison = null)
    {
        if (is_array($fortemplatefield)) {
            $useMinMax = false;
            if (isset($fortemplatefield['min'])) {
                $this->addUsingAlias(DataTableMap::COL__FORTEMPLATEFIELD, $fortemplatefield['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fortemplatefield['max'])) {
                $this->addUsingAlias(DataTableMap::COL__FORTEMPLATEFIELD, $fortemplatefield['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DataTableMap::COL__FORTEMPLATEFIELD, $fortemplatefield, $comparison);
    }

    /**
     * Filter the query on the _content column
     *
     * Example usage:
     * <code>
     * $query->filterByContent('fooValue');   // WHERE _content = 'fooValue'
     * $query->filterByContent('%fooValue%'); // WHERE _content LIKE '%fooValue%'
     * </code>
     *
     * @param     string $content The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDataQuery The current query, for fluid interface
     */
    public function filterByContent($content = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($content)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $content)) {
                $content = str_replace('*', '%', $content);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(DataTableMap::COL__CONTENT, $content, $comparison);
    }

    /**
     * Filter the query on the _isjson column
     *
     * Example usage:
     * <code>
     * $query->filterByIsjson(true); // WHERE _isjson = true
     * $query->filterByIsjson('yes'); // WHERE _isjson = true
     * </code>
     *
     * @param     boolean|string $isjson The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDataQuery The current query, for fluid interface
     */
    public function filterByIsjson($isjson = null, $comparison = null)
    {
        if (is_string($isjson)) {
            $isjson = in_array(strtolower($isjson), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(DataTableMap::COL__ISJSON, $isjson, $comparison);
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
     * @return $this|ChildDataQuery The current query, for fluid interface
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

        return $this->addUsingAlias(DataTableMap::COL___USER__, $userSys, $comparison);
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
     * @return $this|ChildDataQuery The current query, for fluid interface
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

        return $this->addUsingAlias(DataTableMap::COL___CONFIG__, $configSys, $comparison);
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
     * @return $this|ChildDataQuery The current query, for fluid interface
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

        return $this->addUsingAlias(DataTableMap::COL___SPLIT__, $split, $comparison);
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
     * @return $this|ChildDataQuery The current query, for fluid interface
     */
    public function filterByParentnode($parentnode = null, $comparison = null)
    {
        if (is_array($parentnode)) {
            $useMinMax = false;
            if (isset($parentnode['min'])) {
                $this->addUsingAlias(DataTableMap::COL___PARENTNODE__, $parentnode['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parentnode['max'])) {
                $this->addUsingAlias(DataTableMap::COL___PARENTNODE__, $parentnode['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DataTableMap::COL___PARENTNODE__, $parentnode, $comparison);
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
     * @return $this|ChildDataQuery The current query, for fluid interface
     */
    public function filterBySort($sort = null, $comparison = null)
    {
        if (is_array($sort)) {
            $useMinMax = false;
            if (isset($sort['min'])) {
                $this->addUsingAlias(DataTableMap::COL___SORT__, $sort['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sort['max'])) {
                $this->addUsingAlias(DataTableMap::COL___SORT__, $sort['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DataTableMap::COL___SORT__, $sort, $comparison);
    }

    /**
     * Filter the query by a related \Contributions object
     *
     * @param \Contributions|ObjectCollection $contributions The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDataQuery The current query, for fluid interface
     */
    public function filterByContributions($contributions, $comparison = null)
    {
        if ($contributions instanceof \Contributions) {
            return $this
                ->addUsingAlias(DataTableMap::COL__FORCONTRIBUTION, $contributions->getId(), $comparison);
        } elseif ($contributions instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DataTableMap::COL__FORCONTRIBUTION, $contributions->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildDataQuery The current query, for fluid interface
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
     * Filter the query by a related \Templates object
     *
     * @param \Templates|ObjectCollection $templates The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDataQuery The current query, for fluid interface
     */
    public function filterByTemplates($templates, $comparison = null)
    {
        if ($templates instanceof \Templates) {
            return $this
                ->addUsingAlias(DataTableMap::COL__FORTEMPLATEFIELD, $templates->getId(), $comparison);
        } elseif ($templates instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DataTableMap::COL__FORTEMPLATEFIELD, $templates->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByTemplates() only accepts arguments of type \Templates or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Templates relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDataQuery The current query, for fluid interface
     */
    public function joinTemplates($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Templates');

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
            $this->addJoinObject($join, 'Templates');
        }

        return $this;
    }

    /**
     * Use the Templates relation Templates object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \TemplatesQuery A secondary query class using the current class as primary query
     */
    public function useTemplatesQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinTemplates($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Templates', '\TemplatesQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildData $data Object to remove from the list of results
     *
     * @return $this|ChildDataQuery The current query, for fluid interface
     */
    public function prune($data = null)
    {
        if ($data) {
            $this->addUsingAlias(DataTableMap::COL_ID, $data->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the _data table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DataTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DataTableMap::clearInstancePool();
            DataTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(DataTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DataTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            DataTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            DataTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // DataQuery
