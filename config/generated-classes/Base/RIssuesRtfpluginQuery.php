<?php

namespace Base;

use \RIssuesRtfplugin as ChildRIssuesRtfplugin;
use \RIssuesRtfpluginQuery as ChildRIssuesRtfpluginQuery;
use \Exception;
use \PDO;
use Map\RIssuesRtfpluginTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'R_issues_rtfplugin' table.
 *
 *
 *
 * @method     ChildRIssuesRtfpluginQuery orderByIssueid($order = Criteria::ASC) Order by the _issueid column
 * @method     ChildRIssuesRtfpluginQuery orderByPluginid($order = Criteria::ASC) Order by the _pluginid column
 *
 * @method     ChildRIssuesRtfpluginQuery groupByIssueid() Group by the _issueid column
 * @method     ChildRIssuesRtfpluginQuery groupByPluginid() Group by the _pluginid column
 *
 * @method     ChildRIssuesRtfpluginQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRIssuesRtfpluginQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRIssuesRtfpluginQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRIssuesRtfpluginQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildRIssuesRtfpluginQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildRIssuesRtfpluginQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildRIssuesRtfpluginQuery leftJoinRtfIssue($relationAlias = null) Adds a LEFT JOIN clause to the query using the RtfIssue relation
 * @method     ChildRIssuesRtfpluginQuery rightJoinRtfIssue($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RtfIssue relation
 * @method     ChildRIssuesRtfpluginQuery innerJoinRtfIssue($relationAlias = null) Adds a INNER JOIN clause to the query using the RtfIssue relation
 *
 * @method     ChildRIssuesRtfpluginQuery joinWithRtfIssue($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RtfIssue relation
 *
 * @method     ChildRIssuesRtfpluginQuery leftJoinWithRtfIssue() Adds a LEFT JOIN clause and with to the query using the RtfIssue relation
 * @method     ChildRIssuesRtfpluginQuery rightJoinWithRtfIssue() Adds a RIGHT JOIN clause and with to the query using the RtfIssue relation
 * @method     ChildRIssuesRtfpluginQuery innerJoinWithRtfIssue() Adds a INNER JOIN clause and with to the query using the RtfIssue relation
 *
 * @method     ChildRIssuesRtfpluginQuery leftJoinRtfPlugin($relationAlias = null) Adds a LEFT JOIN clause to the query using the RtfPlugin relation
 * @method     ChildRIssuesRtfpluginQuery rightJoinRtfPlugin($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RtfPlugin relation
 * @method     ChildRIssuesRtfpluginQuery innerJoinRtfPlugin($relationAlias = null) Adds a INNER JOIN clause to the query using the RtfPlugin relation
 *
 * @method     ChildRIssuesRtfpluginQuery joinWithRtfPlugin($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RtfPlugin relation
 *
 * @method     ChildRIssuesRtfpluginQuery leftJoinWithRtfPlugin() Adds a LEFT JOIN clause and with to the query using the RtfPlugin relation
 * @method     ChildRIssuesRtfpluginQuery rightJoinWithRtfPlugin() Adds a RIGHT JOIN clause and with to the query using the RtfPlugin relation
 * @method     ChildRIssuesRtfpluginQuery innerJoinWithRtfPlugin() Adds a INNER JOIN clause and with to the query using the RtfPlugin relation
 *
 * @method     \IssuesQuery|\PluginsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRIssuesRtfplugin findOne(ConnectionInterface $con = null) Return the first ChildRIssuesRtfplugin matching the query
 * @method     ChildRIssuesRtfplugin findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRIssuesRtfplugin matching the query, or a new ChildRIssuesRtfplugin object populated from the query conditions when no match is found
 *
 * @method     ChildRIssuesRtfplugin findOneByIssueid(int $_issueid) Return the first ChildRIssuesRtfplugin filtered by the _issueid column
 * @method     ChildRIssuesRtfplugin findOneByPluginid(int $_pluginid) Return the first ChildRIssuesRtfplugin filtered by the _pluginid column *

 * @method     ChildRIssuesRtfplugin requirePk($key, ConnectionInterface $con = null) Return the ChildRIssuesRtfplugin by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRIssuesRtfplugin requireOne(ConnectionInterface $con = null) Return the first ChildRIssuesRtfplugin matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRIssuesRtfplugin requireOneByIssueid(int $_issueid) Return the first ChildRIssuesRtfplugin filtered by the _issueid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRIssuesRtfplugin requireOneByPluginid(int $_pluginid) Return the first ChildRIssuesRtfplugin filtered by the _pluginid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRIssuesRtfplugin[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRIssuesRtfplugin objects based on current ModelCriteria
 * @method     ChildRIssuesRtfplugin[]|ObjectCollection findByIssueid(int $_issueid) Return ChildRIssuesRtfplugin objects filtered by the _issueid column
 * @method     ChildRIssuesRtfplugin[]|ObjectCollection findByPluginid(int $_pluginid) Return ChildRIssuesRtfplugin objects filtered by the _pluginid column
 * @method     ChildRIssuesRtfplugin[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RIssuesRtfpluginQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\RIssuesRtfpluginQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'rokfor', $modelName = '\\RIssuesRtfplugin', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRIssuesRtfpluginQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRIssuesRtfpluginQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRIssuesRtfpluginQuery) {
            return $criteria;
        }
        $query = new ChildRIssuesRtfpluginQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$_issueid, $_pluginid] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildRIssuesRtfplugin|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = RIssuesRtfpluginTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])])))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RIssuesRtfpluginTableMap::DATABASE_NAME);
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
     * @return ChildRIssuesRtfplugin A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT _issueid, _pluginid FROM R_issues_rtfplugin WHERE _issueid = :p0 AND _pluginid = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildRIssuesRtfplugin $obj */
            $obj = new ChildRIssuesRtfplugin();
            $obj->hydrate($row);
            RIssuesRtfpluginTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildRIssuesRtfplugin|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return $this|ChildRIssuesRtfpluginQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(RIssuesRtfpluginTableMap::COL__ISSUEID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(RIssuesRtfpluginTableMap::COL__PLUGINID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRIssuesRtfpluginQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(RIssuesRtfpluginTableMap::COL__ISSUEID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(RIssuesRtfpluginTableMap::COL__PLUGINID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the _issueid column
     *
     * Example usage:
     * <code>
     * $query->filterByIssueid(1234); // WHERE _issueid = 1234
     * $query->filterByIssueid(array(12, 34)); // WHERE _issueid IN (12, 34)
     * $query->filterByIssueid(array('min' => 12)); // WHERE _issueid > 12
     * </code>
     *
     * @see       filterByRtfIssue()
     *
     * @param     mixed $issueid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRIssuesRtfpluginQuery The current query, for fluid interface
     */
    public function filterByIssueid($issueid = null, $comparison = null)
    {
        if (is_array($issueid)) {
            $useMinMax = false;
            if (isset($issueid['min'])) {
                $this->addUsingAlias(RIssuesRtfpluginTableMap::COL__ISSUEID, $issueid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($issueid['max'])) {
                $this->addUsingAlias(RIssuesRtfpluginTableMap::COL__ISSUEID, $issueid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RIssuesRtfpluginTableMap::COL__ISSUEID, $issueid, $comparison);
    }

    /**
     * Filter the query on the _pluginid column
     *
     * Example usage:
     * <code>
     * $query->filterByPluginid(1234); // WHERE _pluginid = 1234
     * $query->filterByPluginid(array(12, 34)); // WHERE _pluginid IN (12, 34)
     * $query->filterByPluginid(array('min' => 12)); // WHERE _pluginid > 12
     * </code>
     *
     * @see       filterByRtfPlugin()
     *
     * @param     mixed $pluginid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRIssuesRtfpluginQuery The current query, for fluid interface
     */
    public function filterByPluginid($pluginid = null, $comparison = null)
    {
        if (is_array($pluginid)) {
            $useMinMax = false;
            if (isset($pluginid['min'])) {
                $this->addUsingAlias(RIssuesRtfpluginTableMap::COL__PLUGINID, $pluginid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pluginid['max'])) {
                $this->addUsingAlias(RIssuesRtfpluginTableMap::COL__PLUGINID, $pluginid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RIssuesRtfpluginTableMap::COL__PLUGINID, $pluginid, $comparison);
    }

    /**
     * Filter the query by a related \Issues object
     *
     * @param \Issues|ObjectCollection $issues The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRIssuesRtfpluginQuery The current query, for fluid interface
     */
    public function filterByRtfIssue($issues, $comparison = null)
    {
        if ($issues instanceof \Issues) {
            return $this
                ->addUsingAlias(RIssuesRtfpluginTableMap::COL__ISSUEID, $issues->getId(), $comparison);
        } elseif ($issues instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RIssuesRtfpluginTableMap::COL__ISSUEID, $issues->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByRtfIssue() only accepts arguments of type \Issues or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RtfIssue relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRIssuesRtfpluginQuery The current query, for fluid interface
     */
    public function joinRtfIssue($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RtfIssue');

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
            $this->addJoinObject($join, 'RtfIssue');
        }

        return $this;
    }

    /**
     * Use the RtfIssue relation Issues object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \IssuesQuery A secondary query class using the current class as primary query
     */
    public function useRtfIssueQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRtfIssue($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RtfIssue', '\IssuesQuery');
    }

    /**
     * Filter the query by a related \Plugins object
     *
     * @param \Plugins|ObjectCollection $plugins The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRIssuesRtfpluginQuery The current query, for fluid interface
     */
    public function filterByRtfPlugin($plugins, $comparison = null)
    {
        if ($plugins instanceof \Plugins) {
            return $this
                ->addUsingAlias(RIssuesRtfpluginTableMap::COL__PLUGINID, $plugins->getId(), $comparison);
        } elseif ($plugins instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RIssuesRtfpluginTableMap::COL__PLUGINID, $plugins->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByRtfPlugin() only accepts arguments of type \Plugins or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RtfPlugin relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRIssuesRtfpluginQuery The current query, for fluid interface
     */
    public function joinRtfPlugin($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RtfPlugin');

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
            $this->addJoinObject($join, 'RtfPlugin');
        }

        return $this;
    }

    /**
     * Use the RtfPlugin relation Plugins object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PluginsQuery A secondary query class using the current class as primary query
     */
    public function useRtfPluginQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRtfPlugin($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RtfPlugin', '\PluginsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildRIssuesRtfplugin $rIssuesRtfplugin Object to remove from the list of results
     *
     * @return $this|ChildRIssuesRtfpluginQuery The current query, for fluid interface
     */
    public function prune($rIssuesRtfplugin = null)
    {
        if ($rIssuesRtfplugin) {
            $this->addCond('pruneCond0', $this->getAliasedColName(RIssuesRtfpluginTableMap::COL__ISSUEID), $rIssuesRtfplugin->getIssueid(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(RIssuesRtfpluginTableMap::COL__PLUGINID), $rIssuesRtfplugin->getPluginid(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the R_issues_rtfplugin table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RIssuesRtfpluginTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RIssuesRtfpluginTableMap::clearInstancePool();
            RIssuesRtfpluginTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(RIssuesRtfpluginTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RIssuesRtfpluginTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            RIssuesRtfpluginTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            RIssuesRtfpluginTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RIssuesRtfpluginQuery
