<?php

namespace Base;

use \RPluginFormat as ChildRPluginFormat;
use \RPluginFormatQuery as ChildRPluginFormatQuery;
use \Exception;
use \PDO;
use Map\RPluginFormatTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'R_plugin_format' table.
 *
 *
 *
 * @method     ChildRPluginFormatQuery orderByPluginid($order = Criteria::ASC) Order by the _pluginid column
 * @method     ChildRPluginFormatQuery orderByFormatid($order = Criteria::ASC) Order by the _formatid column
 *
 * @method     ChildRPluginFormatQuery groupByPluginid() Group by the _pluginid column
 * @method     ChildRPluginFormatQuery groupByFormatid() Group by the _formatid column
 *
 * @method     ChildRPluginFormatQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRPluginFormatQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRPluginFormatQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRPluginFormatQuery leftJoinRPlugin($relationAlias = null) Adds a LEFT JOIN clause to the query using the RPlugin relation
 * @method     ChildRPluginFormatQuery rightJoinRPlugin($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RPlugin relation
 * @method     ChildRPluginFormatQuery innerJoinRPlugin($relationAlias = null) Adds a INNER JOIN clause to the query using the RPlugin relation
 *
 * @method     ChildRPluginFormatQuery leftJoinRFormat($relationAlias = null) Adds a LEFT JOIN clause to the query using the RFormat relation
 * @method     ChildRPluginFormatQuery rightJoinRFormat($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RFormat relation
 * @method     ChildRPluginFormatQuery innerJoinRFormat($relationAlias = null) Adds a INNER JOIN clause to the query using the RFormat relation
 *
 * @method     \PluginsQuery|\FormatsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRPluginFormat findOne(ConnectionInterface $con = null) Return the first ChildRPluginFormat matching the query
 * @method     ChildRPluginFormat findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRPluginFormat matching the query, or a new ChildRPluginFormat object populated from the query conditions when no match is found
 *
 * @method     ChildRPluginFormat findOneByPluginid(int $_pluginid) Return the first ChildRPluginFormat filtered by the _pluginid column
 * @method     ChildRPluginFormat findOneByFormatid(int $_formatid) Return the first ChildRPluginFormat filtered by the _formatid column *

 * @method     ChildRPluginFormat requirePk($key, ConnectionInterface $con = null) Return the ChildRPluginFormat by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRPluginFormat requireOne(ConnectionInterface $con = null) Return the first ChildRPluginFormat matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRPluginFormat requireOneByPluginid(int $_pluginid) Return the first ChildRPluginFormat filtered by the _pluginid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRPluginFormat requireOneByFormatid(int $_formatid) Return the first ChildRPluginFormat filtered by the _formatid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRPluginFormat[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRPluginFormat objects based on current ModelCriteria
 * @method     ChildRPluginFormat[]|ObjectCollection findByPluginid(int $_pluginid) Return ChildRPluginFormat objects filtered by the _pluginid column
 * @method     ChildRPluginFormat[]|ObjectCollection findByFormatid(int $_formatid) Return ChildRPluginFormat objects filtered by the _formatid column
 * @method     ChildRPluginFormat[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RPluginFormatQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\RPluginFormatQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'rokfor', $modelName = '\\RPluginFormat', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRPluginFormatQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRPluginFormatQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRPluginFormatQuery) {
            return $criteria;
        }
        $query = new ChildRPluginFormatQuery();
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
     * @param array[$_pluginid, $_formatid] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildRPluginFormat|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = RPluginFormatTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RPluginFormatTableMap::DATABASE_NAME);
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
     * @return ChildRPluginFormat A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT _pluginid, _formatid FROM R_plugin_format WHERE _pluginid = :p0 AND _formatid = :p1';
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
            /** @var ChildRPluginFormat $obj */
            $obj = new ChildRPluginFormat();
            $obj->hydrate($row);
            RPluginFormatTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildRPluginFormat|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildRPluginFormatQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(RPluginFormatTableMap::COL__PLUGINID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(RPluginFormatTableMap::COL__FORMATID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRPluginFormatQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(RPluginFormatTableMap::COL__PLUGINID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(RPluginFormatTableMap::COL__FORMATID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @see       filterByRPlugin()
     *
     * @param     mixed $pluginid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRPluginFormatQuery The current query, for fluid interface
     */
    public function filterByPluginid($pluginid = null, $comparison = null)
    {
        if (is_array($pluginid)) {
            $useMinMax = false;
            if (isset($pluginid['min'])) {
                $this->addUsingAlias(RPluginFormatTableMap::COL__PLUGINID, $pluginid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pluginid['max'])) {
                $this->addUsingAlias(RPluginFormatTableMap::COL__PLUGINID, $pluginid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RPluginFormatTableMap::COL__PLUGINID, $pluginid, $comparison);
    }

    /**
     * Filter the query on the _formatid column
     *
     * Example usage:
     * <code>
     * $query->filterByFormatid(1234); // WHERE _formatid = 1234
     * $query->filterByFormatid(array(12, 34)); // WHERE _formatid IN (12, 34)
     * $query->filterByFormatid(array('min' => 12)); // WHERE _formatid > 12
     * </code>
     *
     * @see       filterByRFormat()
     *
     * @param     mixed $formatid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRPluginFormatQuery The current query, for fluid interface
     */
    public function filterByFormatid($formatid = null, $comparison = null)
    {
        if (is_array($formatid)) {
            $useMinMax = false;
            if (isset($formatid['min'])) {
                $this->addUsingAlias(RPluginFormatTableMap::COL__FORMATID, $formatid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($formatid['max'])) {
                $this->addUsingAlias(RPluginFormatTableMap::COL__FORMATID, $formatid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RPluginFormatTableMap::COL__FORMATID, $formatid, $comparison);
    }

    /**
     * Filter the query by a related \Plugins object
     *
     * @param \Plugins|ObjectCollection $plugins The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRPluginFormatQuery The current query, for fluid interface
     */
    public function filterByRPlugin($plugins, $comparison = null)
    {
        if ($plugins instanceof \Plugins) {
            return $this
                ->addUsingAlias(RPluginFormatTableMap::COL__PLUGINID, $plugins->getId(), $comparison);
        } elseif ($plugins instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RPluginFormatTableMap::COL__PLUGINID, $plugins->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByRPlugin() only accepts arguments of type \Plugins or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RPlugin relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRPluginFormatQuery The current query, for fluid interface
     */
    public function joinRPlugin($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RPlugin');

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
            $this->addJoinObject($join, 'RPlugin');
        }

        return $this;
    }

    /**
     * Use the RPlugin relation Plugins object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PluginsQuery A secondary query class using the current class as primary query
     */
    public function useRPluginQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRPlugin($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RPlugin', '\PluginsQuery');
    }

    /**
     * Filter the query by a related \Formats object
     *
     * @param \Formats|ObjectCollection $formats The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRPluginFormatQuery The current query, for fluid interface
     */
    public function filterByRFormat($formats, $comparison = null)
    {
        if ($formats instanceof \Formats) {
            return $this
                ->addUsingAlias(RPluginFormatTableMap::COL__FORMATID, $formats->getId(), $comparison);
        } elseif ($formats instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RPluginFormatTableMap::COL__FORMATID, $formats->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByRFormat() only accepts arguments of type \Formats or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RFormat relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRPluginFormatQuery The current query, for fluid interface
     */
    public function joinRFormat($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RFormat');

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
            $this->addJoinObject($join, 'RFormat');
        }

        return $this;
    }

    /**
     * Use the RFormat relation Formats object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \FormatsQuery A secondary query class using the current class as primary query
     */
    public function useRFormatQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRFormat($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RFormat', '\FormatsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildRPluginFormat $rPluginFormat Object to remove from the list of results
     *
     * @return $this|ChildRPluginFormatQuery The current query, for fluid interface
     */
    public function prune($rPluginFormat = null)
    {
        if ($rPluginFormat) {
            $this->addCond('pruneCond0', $this->getAliasedColName(RPluginFormatTableMap::COL__PLUGINID), $rPluginFormat->getPluginid(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(RPluginFormatTableMap::COL__FORMATID), $rPluginFormat->getFormatid(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the R_plugin_format table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RPluginFormatTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RPluginFormatTableMap::clearInstancePool();
            RPluginFormatTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(RPluginFormatTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RPluginFormatTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            RPluginFormatTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            RPluginFormatTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RPluginFormatQuery
