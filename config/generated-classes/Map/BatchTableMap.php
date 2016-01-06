<?php

namespace Map;

use \Batch;
use \BatchQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the '_batch' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class BatchTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.BatchTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'rokfor';

    /**
     * The table name for this class
     */
    const TABLE_NAME = '_batch';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Batch';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Batch';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 10;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 10;

    /**
     * the column name for the id field
     */
    const COL_ID = '_batch.id';

    /**
     * the column name for the _name field
     */
    const COL__NAME = '_batch._name';

    /**
     * the column name for the _description field
     */
    const COL__DESCRIPTION = '_batch._description';

    /**
     * the column name for the _precode field
     */
    const COL__PRECODE = '_batch._precode';

    /**
     * the column name for the _postcode field
     */
    const COL__POSTCODE = '_batch._postcode';

    /**
     * the column name for the __user__ field
     */
    const COL___USER__ = '_batch.__user__';

    /**
     * the column name for the __config__ field
     */
    const COL___CONFIG__ = '_batch.__config__';

    /**
     * the column name for the __split__ field
     */
    const COL___SPLIT__ = '_batch.__split__';

    /**
     * the column name for the __parentnode__ field
     */
    const COL___PARENTNODE__ = '_batch.__parentnode__';

    /**
     * the column name for the __sort__ field
     */
    const COL___SORT__ = '_batch.__sort__';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'Name', 'Description', 'Precode', 'Postcode', 'UserSys', 'ConfigSys', 'Split', 'Parentnode', 'Sort', ),
        self::TYPE_CAMELNAME     => array('id', 'name', 'description', 'precode', 'postcode', 'userSys', 'configSys', 'split', 'parentnode', 'sort', ),
        self::TYPE_COLNAME       => array(BatchTableMap::COL_ID, BatchTableMap::COL__NAME, BatchTableMap::COL__DESCRIPTION, BatchTableMap::COL__PRECODE, BatchTableMap::COL__POSTCODE, BatchTableMap::COL___USER__, BatchTableMap::COL___CONFIG__, BatchTableMap::COL___SPLIT__, BatchTableMap::COL___PARENTNODE__, BatchTableMap::COL___SORT__, ),
        self::TYPE_FIELDNAME     => array('id', '_name', '_description', '_precode', '_postcode', '__user__', '__config__', '__split__', '__parentnode__', '__sort__', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Name' => 1, 'Description' => 2, 'Precode' => 3, 'Postcode' => 4, 'UserSys' => 5, 'ConfigSys' => 6, 'Split' => 7, 'Parentnode' => 8, 'Sort' => 9, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'name' => 1, 'description' => 2, 'precode' => 3, 'postcode' => 4, 'userSys' => 5, 'configSys' => 6, 'split' => 7, 'parentnode' => 8, 'sort' => 9, ),
        self::TYPE_COLNAME       => array(BatchTableMap::COL_ID => 0, BatchTableMap::COL__NAME => 1, BatchTableMap::COL__DESCRIPTION => 2, BatchTableMap::COL__PRECODE => 3, BatchTableMap::COL__POSTCODE => 4, BatchTableMap::COL___USER__ => 5, BatchTableMap::COL___CONFIG__ => 6, BatchTableMap::COL___SPLIT__ => 7, BatchTableMap::COL___PARENTNODE__ => 8, BatchTableMap::COL___SORT__ => 9, ),
        self::TYPE_FIELDNAME     => array('id' => 0, '_name' => 1, '_description' => 2, '_precode' => 3, '_postcode' => 4, '__user__' => 5, '__config__' => 6, '__split__' => 7, '__parentnode__' => 8, '__sort__' => 9, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('_batch');
        $this->setPhpName('Batch');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Batch');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, 4, null);
        $this->addColumn('_name', 'Name', 'LONGVARCHAR', false, null, null);
        $this->addColumn('_description', 'Description', 'LONGVARCHAR', false, null, null);
        $this->addColumn('_precode', 'Precode', 'LONGVARCHAR', false, null, null);
        $this->addColumn('_postcode', 'Postcode', 'LONGVARCHAR', false, null, null);
        $this->addColumn('__user__', 'UserSys', 'LONGVARCHAR', false, null, null);
        $this->addColumn('__config__', 'ConfigSys', 'LONGVARCHAR', false, null, null);
        $this->addColumn('__split__', 'Split', 'LONGVARCHAR', false, null, null);
        $this->addColumn('__parentnode__', 'Parentnode', 'INTEGER', false, 32, null);
        $this->addColumn('__sort__', 'Sort', 'INTEGER', false, 32, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('RBatchForbook', '\\RBatchForbook', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':_batchid',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'RBatchForbooks', false);
        $this->addRelation('Books', '\\Books', RelationMap::MANY_TO_MANY, array(), 'CASCADE', 'CASCADE', 'Bookss');
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to _batch     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        RBatchForbookTableMap::clearInstancePool();
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? BatchTableMap::CLASS_DEFAULT : BatchTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Batch object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = BatchTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = BatchTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + BatchTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = BatchTableMap::OM_CLASS;
            /** @var Batch $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            BatchTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = BatchTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = BatchTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Batch $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                BatchTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(BatchTableMap::COL_ID);
            $criteria->addSelectColumn(BatchTableMap::COL__NAME);
            $criteria->addSelectColumn(BatchTableMap::COL__DESCRIPTION);
            $criteria->addSelectColumn(BatchTableMap::COL__PRECODE);
            $criteria->addSelectColumn(BatchTableMap::COL__POSTCODE);
            $criteria->addSelectColumn(BatchTableMap::COL___USER__);
            $criteria->addSelectColumn(BatchTableMap::COL___CONFIG__);
            $criteria->addSelectColumn(BatchTableMap::COL___SPLIT__);
            $criteria->addSelectColumn(BatchTableMap::COL___PARENTNODE__);
            $criteria->addSelectColumn(BatchTableMap::COL___SORT__);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '._name');
            $criteria->addSelectColumn($alias . '._description');
            $criteria->addSelectColumn($alias . '._precode');
            $criteria->addSelectColumn($alias . '._postcode');
            $criteria->addSelectColumn($alias . '.__user__');
            $criteria->addSelectColumn($alias . '.__config__');
            $criteria->addSelectColumn($alias . '.__split__');
            $criteria->addSelectColumn($alias . '.__parentnode__');
            $criteria->addSelectColumn($alias . '.__sort__');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(BatchTableMap::DATABASE_NAME)->getTable(BatchTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(BatchTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(BatchTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new BatchTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Batch or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Batch object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BatchTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Batch) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(BatchTableMap::DATABASE_NAME);
            $criteria->add(BatchTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = BatchQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            BatchTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                BatchTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the _batch table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return BatchQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Batch or Criteria object.
     *
     * @param mixed               $criteria Criteria or Batch object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BatchTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Batch object
        }

        if ($criteria->containsKey(BatchTableMap::COL_ID) && $criteria->keyContainsValue(BatchTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.BatchTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = BatchQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // BatchTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BatchTableMap::buildTableMap();
