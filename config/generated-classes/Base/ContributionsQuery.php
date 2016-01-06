<?php

namespace Base;

use \Contributions as ChildContributions;
use \ContributionsQuery as ChildContributionsQuery;
use \Exception;
use \PDO;
use Map\ContributionsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the '_contributions' table.
 *
 *
 *
 * @method     ChildContributionsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildContributionsQuery orderByFortemplate($order = Criteria::ASC) Order by the _fortemplate column
 * @method     ChildContributionsQuery orderByForissue($order = Criteria::ASC) Order by the _forissue column
 * @method     ChildContributionsQuery orderByName($order = Criteria::ASC) Order by the _name column
 * @method     ChildContributionsQuery orderByStatus($order = Criteria::ASC) Order by the _status column
 * @method     ChildContributionsQuery orderByNewdate($order = Criteria::ASC) Order by the _newdate column
 * @method     ChildContributionsQuery orderByModdate($order = Criteria::ASC) Order by the _moddate column
 * @method     ChildContributionsQuery orderByUser($order = Criteria::ASC) Order by the __user__ column
 * @method     ChildContributionsQuery orderByConfig($order = Criteria::ASC) Order by the __config__ column
 * @method     ChildContributionsQuery orderBySplit($order = Criteria::ASC) Order by the __split__ column
 * @method     ChildContributionsQuery orderByParentnode($order = Criteria::ASC) Order by the __parentnode__ column
 * @method     ChildContributionsQuery orderBySort($order = Criteria::ASC) Order by the __sort__ column
 *
 * @method     ChildContributionsQuery groupById() Group by the id column
 * @method     ChildContributionsQuery groupByFortemplate() Group by the _fortemplate column
 * @method     ChildContributionsQuery groupByForissue() Group by the _forissue column
 * @method     ChildContributionsQuery groupByName() Group by the _name column
 * @method     ChildContributionsQuery groupByStatus() Group by the _status column
 * @method     ChildContributionsQuery groupByNewdate() Group by the _newdate column
 * @method     ChildContributionsQuery groupByModdate() Group by the _moddate column
 * @method     ChildContributionsQuery groupByUser() Group by the __user__ column
 * @method     ChildContributionsQuery groupByConfig() Group by the __config__ column
 * @method     ChildContributionsQuery groupBySplit() Group by the __split__ column
 * @method     ChildContributionsQuery groupByParentnode() Group by the __parentnode__ column
 * @method     ChildContributionsQuery groupBySort() Group by the __sort__ column
 *
 * @method     ChildContributionsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildContributionsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildContributionsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildContributionsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildContributionsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildContributionsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildContributionsQuery leftJoinFormats($relationAlias = null) Adds a LEFT JOIN clause to the query using the Formats relation
 * @method     ChildContributionsQuery rightJoinFormats($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Formats relation
 * @method     ChildContributionsQuery innerJoinFormats($relationAlias = null) Adds a INNER JOIN clause to the query using the Formats relation
 *
 * @method     ChildContributionsQuery joinWithFormats($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Formats relation
 *
 * @method     ChildContributionsQuery leftJoinWithFormats() Adds a LEFT JOIN clause and with to the query using the Formats relation
 * @method     ChildContributionsQuery rightJoinWithFormats() Adds a RIGHT JOIN clause and with to the query using the Formats relation
 * @method     ChildContributionsQuery innerJoinWithFormats() Adds a INNER JOIN clause and with to the query using the Formats relation
 *
 * @method     ChildContributionsQuery leftJoinIssues($relationAlias = null) Adds a LEFT JOIN clause to the query using the Issues relation
 * @method     ChildContributionsQuery rightJoinIssues($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Issues relation
 * @method     ChildContributionsQuery innerJoinIssues($relationAlias = null) Adds a INNER JOIN clause to the query using the Issues relation
 *
 * @method     ChildContributionsQuery joinWithIssues($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Issues relation
 *
 * @method     ChildContributionsQuery leftJoinWithIssues() Adds a LEFT JOIN clause and with to the query using the Issues relation
 * @method     ChildContributionsQuery rightJoinWithIssues() Adds a RIGHT JOIN clause and with to the query using the Issues relation
 * @method     ChildContributionsQuery innerJoinWithIssues() Adds a INNER JOIN clause and with to the query using the Issues relation
 *
 * @method     ChildContributionsQuery leftJoinTemplatenames($relationAlias = null) Adds a LEFT JOIN clause to the query using the Templatenames relation
 * @method     ChildContributionsQuery rightJoinTemplatenames($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Templatenames relation
 * @method     ChildContributionsQuery innerJoinTemplatenames($relationAlias = null) Adds a INNER JOIN clause to the query using the Templatenames relation
 *
 * @method     ChildContributionsQuery joinWithTemplatenames($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Templatenames relation
 *
 * @method     ChildContributionsQuery leftJoinWithTemplatenames() Adds a LEFT JOIN clause and with to the query using the Templatenames relation
 * @method     ChildContributionsQuery rightJoinWithTemplatenames() Adds a RIGHT JOIN clause and with to the query using the Templatenames relation
 * @method     ChildContributionsQuery innerJoinWithTemplatenames() Adds a INNER JOIN clause and with to the query using the Templatenames relation
 *
 * @method     ChildContributionsQuery leftJoinData($relationAlias = null) Adds a LEFT JOIN clause to the query using the Data relation
 * @method     ChildContributionsQuery rightJoinData($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Data relation
 * @method     ChildContributionsQuery innerJoinData($relationAlias = null) Adds a INNER JOIN clause to the query using the Data relation
 *
 * @method     ChildContributionsQuery joinWithData($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Data relation
 *
 * @method     ChildContributionsQuery leftJoinWithData() Adds a LEFT JOIN clause and with to the query using the Data relation
 * @method     ChildContributionsQuery rightJoinWithData() Adds a RIGHT JOIN clause and with to the query using the Data relation
 * @method     ChildContributionsQuery innerJoinWithData() Adds a INNER JOIN clause and with to the query using the Data relation
 *
 * @method     \FormatsQuery|\IssuesQuery|\TemplatenamesQuery|\DataQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildContributions findOne(ConnectionInterface $con = null) Return the first ChildContributions matching the query
 * @method     ChildContributions findOneOrCreate(ConnectionInterface $con = null) Return the first ChildContributions matching the query, or a new ChildContributions object populated from the query conditions when no match is found
 *
 * @method     ChildContributions findOneById(int $id) Return the first ChildContributions filtered by the id column
 * @method     ChildContributions findOneByFortemplate(int $_fortemplate) Return the first ChildContributions filtered by the _fortemplate column
 * @method     ChildContributions findOneByForissue(int $_forissue) Return the first ChildContributions filtered by the _forissue column
 * @method     ChildContributions findOneByName(string $_name) Return the first ChildContributions filtered by the _name column
 * @method     ChildContributions findOneByStatus(string $_status) Return the first ChildContributions filtered by the _status column
 * @method     ChildContributions findOneByNewdate(int $_newdate) Return the first ChildContributions filtered by the _newdate column
 * @method     ChildContributions findOneByModdate(int $_moddate) Return the first ChildContributions filtered by the _moddate column
 * @method     ChildContributions findOneByUser(string $__user__) Return the first ChildContributions filtered by the __user__ column
 * @method     ChildContributions findOneByConfig(string $__config__) Return the first ChildContributions filtered by the __config__ column
 * @method     ChildContributions findOneBySplit(int $__split__) Return the first ChildContributions filtered by the __split__ column
 * @method     ChildContributions findOneByParentnode(int $__parentnode__) Return the first ChildContributions filtered by the __parentnode__ column
 * @method     ChildContributions findOneBySort(int $__sort__) Return the first ChildContributions filtered by the __sort__ column *

 * @method     ChildContributions requirePk($key, ConnectionInterface $con = null) Return the ChildContributions by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributions requireOne(ConnectionInterface $con = null) Return the first ChildContributions matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildContributions requireOneById(int $id) Return the first ChildContributions filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributions requireOneByFortemplate(int $_fortemplate) Return the first ChildContributions filtered by the _fortemplate column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributions requireOneByForissue(int $_forissue) Return the first ChildContributions filtered by the _forissue column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributions requireOneByName(string $_name) Return the first ChildContributions filtered by the _name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributions requireOneByStatus(string $_status) Return the first ChildContributions filtered by the _status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributions requireOneByNewdate(int $_newdate) Return the first ChildContributions filtered by the _newdate column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributions requireOneByModdate(int $_moddate) Return the first ChildContributions filtered by the _moddate column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributions requireOneByUser(string $__user__) Return the first ChildContributions filtered by the __user__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributions requireOneByConfig(string $__config__) Return the first ChildContributions filtered by the __config__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributions requireOneBySplit(int $__split__) Return the first ChildContributions filtered by the __split__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributions requireOneByParentnode(int $__parentnode__) Return the first ChildContributions filtered by the __parentnode__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributions requireOneBySort(int $__sort__) Return the first ChildContributions filtered by the __sort__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildContributions[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildContributions objects based on current ModelCriteria
 * @method     ChildContributions[]|ObjectCollection findById(int $id) Return ChildContributions objects filtered by the id column
 * @method     ChildContributions[]|ObjectCollection findByFortemplate(int $_fortemplate) Return ChildContributions objects filtered by the _fortemplate column
 * @method     ChildContributions[]|ObjectCollection findByForissue(int $_forissue) Return ChildContributions objects filtered by the _forissue column
 * @method     ChildContributions[]|ObjectCollection findByName(string $_name) Return ChildContributions objects filtered by the _name column
 * @method     ChildContributions[]|ObjectCollection findByStatus(string $_status) Return ChildContributions objects filtered by the _status column
 * @method     ChildContributions[]|ObjectCollection findByNewdate(int $_newdate) Return ChildContributions objects filtered by the _newdate column
 * @method     ChildContributions[]|ObjectCollection findByModdate(int $_moddate) Return ChildContributions objects filtered by the _moddate column
 * @method     ChildContributions[]|ObjectCollection findByUser(string $__user__) Return ChildContributions objects filtered by the __user__ column
 * @method     ChildContributions[]|ObjectCollection findByConfig(string $__config__) Return ChildContributions objects filtered by the __config__ column
 * @method     ChildContributions[]|ObjectCollection findBySplit(int $__split__) Return ChildContributions objects filtered by the __split__ column
 * @method     ChildContributions[]|ObjectCollection findByParentnode(int $__parentnode__) Return ChildContributions objects filtered by the __parentnode__ column
 * @method     ChildContributions[]|ObjectCollection findBySort(int $__sort__) Return ChildContributions objects filtered by the __sort__ column
 * @method     ChildContributions[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ContributionsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ContributionsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'rokfor', $modelName = '\\Contributions', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildContributionsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildContributionsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildContributionsQuery) {
            return $criteria;
        }
        $query = new ChildContributionsQuery();
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
     * @return ChildContributions|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ContributionsTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ContributionsTableMap::DATABASE_NAME);
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
     * @return ChildContributions A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, _fortemplate, _forissue, _name, _status, _newdate, _moddate, __user__, __config__, __split__, __parentnode__, __sort__ FROM _contributions WHERE id = :p0';
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
            /** @var ChildContributions $obj */
            $obj = new ChildContributions();
            $obj->hydrate($row);
            ContributionsTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildContributions|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildContributionsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ContributionsTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildContributionsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ContributionsTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildContributionsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ContributionsTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ContributionsTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContributionsTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the _fortemplate column
     *
     * Example usage:
     * <code>
     * $query->filterByFortemplate(1234); // WHERE _fortemplate = 1234
     * $query->filterByFortemplate(array(12, 34)); // WHERE _fortemplate IN (12, 34)
     * $query->filterByFortemplate(array('min' => 12)); // WHERE _fortemplate > 12
     * </code>
     *
     * @see       filterByTemplatenames()
     *
     * @param     mixed $fortemplate The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildContributionsQuery The current query, for fluid interface
     */
    public function filterByFortemplate($fortemplate = null, $comparison = null)
    {
        if (is_array($fortemplate)) {
            $useMinMax = false;
            if (isset($fortemplate['min'])) {
                $this->addUsingAlias(ContributionsTableMap::COL__FORTEMPLATE, $fortemplate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fortemplate['max'])) {
                $this->addUsingAlias(ContributionsTableMap::COL__FORTEMPLATE, $fortemplate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContributionsTableMap::COL__FORTEMPLATE, $fortemplate, $comparison);
    }

    /**
     * Filter the query on the _forissue column
     *
     * Example usage:
     * <code>
     * $query->filterByForissue(1234); // WHERE _forissue = 1234
     * $query->filterByForissue(array(12, 34)); // WHERE _forissue IN (12, 34)
     * $query->filterByForissue(array('min' => 12)); // WHERE _forissue > 12
     * </code>
     *
     * @see       filterByIssues()
     *
     * @param     mixed $forissue The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildContributionsQuery The current query, for fluid interface
     */
    public function filterByForissue($forissue = null, $comparison = null)
    {
        if (is_array($forissue)) {
            $useMinMax = false;
            if (isset($forissue['min'])) {
                $this->addUsingAlias(ContributionsTableMap::COL__FORISSUE, $forissue['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($forissue['max'])) {
                $this->addUsingAlias(ContributionsTableMap::COL__FORISSUE, $forissue['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContributionsTableMap::COL__FORISSUE, $forissue, $comparison);
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
     * @return $this|ChildContributionsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ContributionsTableMap::COL__NAME, $name, $comparison);
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
     * @return $this|ChildContributionsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ContributionsTableMap::COL__STATUS, $status, $comparison);
    }

    /**
     * Filter the query on the _newdate column
     *
     * Example usage:
     * <code>
     * $query->filterByNewdate(1234); // WHERE _newdate = 1234
     * $query->filterByNewdate(array(12, 34)); // WHERE _newdate IN (12, 34)
     * $query->filterByNewdate(array('min' => 12)); // WHERE _newdate > 12
     * </code>
     *
     * @param     mixed $newdate The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildContributionsQuery The current query, for fluid interface
     */
    public function filterByNewdate($newdate = null, $comparison = null)
    {
        if (is_array($newdate)) {
            $useMinMax = false;
            if (isset($newdate['min'])) {
                $this->addUsingAlias(ContributionsTableMap::COL__NEWDATE, $newdate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($newdate['max'])) {
                $this->addUsingAlias(ContributionsTableMap::COL__NEWDATE, $newdate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContributionsTableMap::COL__NEWDATE, $newdate, $comparison);
    }

    /**
     * Filter the query on the _moddate column
     *
     * Example usage:
     * <code>
     * $query->filterByModdate(1234); // WHERE _moddate = 1234
     * $query->filterByModdate(array(12, 34)); // WHERE _moddate IN (12, 34)
     * $query->filterByModdate(array('min' => 12)); // WHERE _moddate > 12
     * </code>
     *
     * @param     mixed $moddate The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildContributionsQuery The current query, for fluid interface
     */
    public function filterByModdate($moddate = null, $comparison = null)
    {
        if (is_array($moddate)) {
            $useMinMax = false;
            if (isset($moddate['min'])) {
                $this->addUsingAlias(ContributionsTableMap::COL__MODDATE, $moddate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($moddate['max'])) {
                $this->addUsingAlias(ContributionsTableMap::COL__MODDATE, $moddate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContributionsTableMap::COL__MODDATE, $moddate, $comparison);
    }

    /**
     * Filter the query on the __user__ column
     *
     * Example usage:
     * <code>
     * $query->filterByUser('fooValue');   // WHERE __user__ = 'fooValue'
     * $query->filterByUser('%fooValue%'); // WHERE __user__ LIKE '%fooValue%'
     * </code>
     *
     * @param     string $user The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildContributionsQuery The current query, for fluid interface
     */
    public function filterByUser($user = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($user)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $user)) {
                $user = str_replace('*', '%', $user);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ContributionsTableMap::COL___USER__, $user, $comparison);
    }

    /**
     * Filter the query on the __config__ column
     *
     * Example usage:
     * <code>
     * $query->filterByConfig('fooValue');   // WHERE __config__ = 'fooValue'
     * $query->filterByConfig('%fooValue%'); // WHERE __config__ LIKE '%fooValue%'
     * </code>
     *
     * @param     string $config The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildContributionsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ContributionsTableMap::COL___CONFIG__, $config, $comparison);
    }

    /**
     * Filter the query on the __split__ column
     *
     * Example usage:
     * <code>
     * $query->filterBySplit(1234); // WHERE __split__ = 1234
     * $query->filterBySplit(array(12, 34)); // WHERE __split__ IN (12, 34)
     * $query->filterBySplit(array('min' => 12)); // WHERE __split__ > 12
     * </code>
     *
     * @see       filterByFormats()
     *
     * @param     mixed $split The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildContributionsQuery The current query, for fluid interface
     */
    public function filterBySplit($split = null, $comparison = null)
    {
        if (is_array($split)) {
            $useMinMax = false;
            if (isset($split['min'])) {
                $this->addUsingAlias(ContributionsTableMap::COL___SPLIT__, $split['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($split['max'])) {
                $this->addUsingAlias(ContributionsTableMap::COL___SPLIT__, $split['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContributionsTableMap::COL___SPLIT__, $split, $comparison);
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
     * @return $this|ChildContributionsQuery The current query, for fluid interface
     */
    public function filterByParentnode($parentnode = null, $comparison = null)
    {
        if (is_array($parentnode)) {
            $useMinMax = false;
            if (isset($parentnode['min'])) {
                $this->addUsingAlias(ContributionsTableMap::COL___PARENTNODE__, $parentnode['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parentnode['max'])) {
                $this->addUsingAlias(ContributionsTableMap::COL___PARENTNODE__, $parentnode['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContributionsTableMap::COL___PARENTNODE__, $parentnode, $comparison);
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
     * @return $this|ChildContributionsQuery The current query, for fluid interface
     */
    public function filterBySort($sort = null, $comparison = null)
    {
        if (is_array($sort)) {
            $useMinMax = false;
            if (isset($sort['min'])) {
                $this->addUsingAlias(ContributionsTableMap::COL___SORT__, $sort['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sort['max'])) {
                $this->addUsingAlias(ContributionsTableMap::COL___SORT__, $sort['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContributionsTableMap::COL___SORT__, $sort, $comparison);
    }

    /**
     * Filter the query by a related \Formats object
     *
     * @param \Formats|ObjectCollection $formats The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildContributionsQuery The current query, for fluid interface
     */
    public function filterByFormats($formats, $comparison = null)
    {
        if ($formats instanceof \Formats) {
            return $this
                ->addUsingAlias(ContributionsTableMap::COL___SPLIT__, $formats->getId(), $comparison);
        } elseif ($formats instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ContributionsTableMap::COL___SPLIT__, $formats->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByFormats() only accepts arguments of type \Formats or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Formats relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildContributionsQuery The current query, for fluid interface
     */
    public function joinFormats($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Formats');

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
            $this->addJoinObject($join, 'Formats');
        }

        return $this;
    }

    /**
     * Use the Formats relation Formats object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \FormatsQuery A secondary query class using the current class as primary query
     */
    public function useFormatsQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinFormats($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Formats', '\FormatsQuery');
    }

    /**
     * Filter the query by a related \Issues object
     *
     * @param \Issues|ObjectCollection $issues The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildContributionsQuery The current query, for fluid interface
     */
    public function filterByIssues($issues, $comparison = null)
    {
        if ($issues instanceof \Issues) {
            return $this
                ->addUsingAlias(ContributionsTableMap::COL__FORISSUE, $issues->getId(), $comparison);
        } elseif ($issues instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ContributionsTableMap::COL__FORISSUE, $issues->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByIssues() only accepts arguments of type \Issues or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Issues relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildContributionsQuery The current query, for fluid interface
     */
    public function joinIssues($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Issues');

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
            $this->addJoinObject($join, 'Issues');
        }

        return $this;
    }

    /**
     * Use the Issues relation Issues object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \IssuesQuery A secondary query class using the current class as primary query
     */
    public function useIssuesQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinIssues($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Issues', '\IssuesQuery');
    }

    /**
     * Filter the query by a related \Templatenames object
     *
     * @param \Templatenames|ObjectCollection $templatenames The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildContributionsQuery The current query, for fluid interface
     */
    public function filterByTemplatenames($templatenames, $comparison = null)
    {
        if ($templatenames instanceof \Templatenames) {
            return $this
                ->addUsingAlias(ContributionsTableMap::COL__FORTEMPLATE, $templatenames->getId(), $comparison);
        } elseif ($templatenames instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ContributionsTableMap::COL__FORTEMPLATE, $templatenames->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByTemplatenames() only accepts arguments of type \Templatenames or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Templatenames relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildContributionsQuery The current query, for fluid interface
     */
    public function joinTemplatenames($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Templatenames');

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
            $this->addJoinObject($join, 'Templatenames');
        }

        return $this;
    }

    /**
     * Use the Templatenames relation Templatenames object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \TemplatenamesQuery A secondary query class using the current class as primary query
     */
    public function useTemplatenamesQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinTemplatenames($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Templatenames', '\TemplatenamesQuery');
    }

    /**
     * Filter the query by a related \Data object
     *
     * @param \Data|ObjectCollection $data the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildContributionsQuery The current query, for fluid interface
     */
    public function filterByData($data, $comparison = null)
    {
        if ($data instanceof \Data) {
            return $this
                ->addUsingAlias(ContributionsTableMap::COL_ID, $data->getForcontribution(), $comparison);
        } elseif ($data instanceof ObjectCollection) {
            return $this
                ->useDataQuery()
                ->filterByPrimaryKeys($data->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByData() only accepts arguments of type \Data or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Data relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildContributionsQuery The current query, for fluid interface
     */
    public function joinData($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Data');

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
            $this->addJoinObject($join, 'Data');
        }

        return $this;
    }

    /**
     * Use the Data relation Data object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DataQuery A secondary query class using the current class as primary query
     */
    public function useDataQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinData($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Data', '\DataQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildContributions $contributions Object to remove from the list of results
     *
     * @return $this|ChildContributionsQuery The current query, for fluid interface
     */
    public function prune($contributions = null)
    {
        if ($contributions) {
            $this->addUsingAlias(ContributionsTableMap::COL_ID, $contributions->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the _contributions table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ContributionsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ContributionsTableMap::clearInstancePool();
            ContributionsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ContributionsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ContributionsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ContributionsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ContributionsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ContributionsQuery
