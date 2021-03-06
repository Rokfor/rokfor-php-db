<?php

namespace Map;

use \Data;
use \DataQuery;
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
 * This class defines the structure of the '_data' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class DataTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.DataTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'rokfor';

    /**
     * The table name for this class
     */
    const TABLE_NAME = '_data';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Data';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Data';

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
    const COL_ID = '_data.id';

    /**
     * the column name for the _forcontribution field
     */
    const COL__FORCONTRIBUTION = '_data._forcontribution';

    /**
     * the column name for the _fortemplatefield field
     */
    const COL__FORTEMPLATEFIELD = '_data._fortemplatefield';

    /**
     * the column name for the _content field
     */
    const COL__CONTENT = '_data._content';

    /**
     * the column name for the _isjson field
     */
    const COL__ISJSON = '_data._isjson';

    /**
     * the column name for the __user__ field
     */
    const COL___USER__ = '_data.__user__';

    /**
     * the column name for the __config__ field
     */
    const COL___CONFIG__ = '_data.__config__';

    /**
     * the column name for the __split__ field
     */
    const COL___SPLIT__ = '_data.__split__';

    /**
     * the column name for the __parentnode__ field
     */
    const COL___PARENTNODE__ = '_data.__parentnode__';

    /**
     * the column name for the __sort__ field
     */
    const COL___SORT__ = '_data.__sort__';

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
        self::TYPE_PHPNAME       => array('Id', 'Forcontribution', 'Fortemplatefield', 'Content', 'Isjson', 'UserSys', 'ConfigSys', 'Split', 'Parentnode', 'Sort', ),
        self::TYPE_CAMELNAME     => array('id', 'forcontribution', 'fortemplatefield', 'content', 'isjson', 'userSys', 'configSys', 'split', 'parentnode', 'sort', ),
        self::TYPE_COLNAME       => array(DataTableMap::COL_ID, DataTableMap::COL__FORCONTRIBUTION, DataTableMap::COL__FORTEMPLATEFIELD, DataTableMap::COL__CONTENT, DataTableMap::COL__ISJSON, DataTableMap::COL___USER__, DataTableMap::COL___CONFIG__, DataTableMap::COL___SPLIT__, DataTableMap::COL___PARENTNODE__, DataTableMap::COL___SORT__, ),
        self::TYPE_FIELDNAME     => array('id', '_forcontribution', '_fortemplatefield', '_content', '_isjson', '__user__', '__config__', '__split__', '__parentnode__', '__sort__', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Forcontribution' => 1, 'Fortemplatefield' => 2, 'Content' => 3, 'Isjson' => 4, 'UserSys' => 5, 'ConfigSys' => 6, 'Split' => 7, 'Parentnode' => 8, 'Sort' => 9, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'forcontribution' => 1, 'fortemplatefield' => 2, 'content' => 3, 'isjson' => 4, 'userSys' => 5, 'configSys' => 6, 'split' => 7, 'parentnode' => 8, 'sort' => 9, ),
        self::TYPE_COLNAME       => array(DataTableMap::COL_ID => 0, DataTableMap::COL__FORCONTRIBUTION => 1, DataTableMap::COL__FORTEMPLATEFIELD => 2, DataTableMap::COL__CONTENT => 3, DataTableMap::COL__ISJSON => 4, DataTableMap::COL___USER__ => 5, DataTableMap::COL___CONFIG__ => 6, DataTableMap::COL___SPLIT__ => 7, DataTableMap::COL___PARENTNODE__ => 8, DataTableMap::COL___SORT__ => 9, ),
        self::TYPE_FIELDNAME     => array('id' => 0, '_forcontribution' => 1, '_fortemplatefield' => 2, '_content' => 3, '_isjson' => 4, '__user__' => 5, '__config__' => 6, '__split__' => 7, '__parentnode__' => 8, '__sort__' => 9, ),
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
        $this->setName('_data');
        $this->setPhpName('Data');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Data');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, 4, null);
        $this->addForeignKey('_forcontribution', 'Forcontribution', 'INTEGER', '_contributions', 'id', false, 4, null);
        $this->addForeignKey('_fortemplatefield', 'Fortemplatefield', 'INTEGER', '_templates', 'id', false, 32, null);
        $this->addColumn('_content', 'Content', 'LONGVARCHAR', false, null, null);
        $this->addColumn('_isjson', 'Isjson', 'BOOLEAN', false, 1, null);
        $this->addForeignKey('__user__', 'UserSys', 'INTEGER', 'users', 'id', false, 4, null);
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
        $this->addRelation('userSysRef', '\\Users', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':__user__',
    1 => ':id',
  ),
), 'SET NULL', 'SET NULL', null, false);
        $this->addRelation('Contributions', '\\Contributions', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':_forcontribution',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('Templates', '\\Templates', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':_fortemplatefield',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', null, false);
    } // buildRelations()

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
        return $withPrefix ? DataTableMap::CLASS_DEFAULT : DataTableMap::OM_CLASS;
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
     * @return array           (Data object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = DataTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = DataTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + DataTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = DataTableMap::OM_CLASS;
            /** @var Data $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            DataTableMap::addInstanceToPool($obj, $key);
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
            $key = DataTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = DataTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Data $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                DataTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(DataTableMap::COL_ID);
            $criteria->addSelectColumn(DataTableMap::COL__FORCONTRIBUTION);
            $criteria->addSelectColumn(DataTableMap::COL__FORTEMPLATEFIELD);
            $criteria->addSelectColumn(DataTableMap::COL__CONTENT);
            $criteria->addSelectColumn(DataTableMap::COL__ISJSON);
            $criteria->addSelectColumn(DataTableMap::COL___USER__);
            $criteria->addSelectColumn(DataTableMap::COL___CONFIG__);
            $criteria->addSelectColumn(DataTableMap::COL___SPLIT__);
            $criteria->addSelectColumn(DataTableMap::COL___PARENTNODE__);
            $criteria->addSelectColumn(DataTableMap::COL___SORT__);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '._forcontribution');
            $criteria->addSelectColumn($alias . '._fortemplatefield');
            $criteria->addSelectColumn($alias . '._content');
            $criteria->addSelectColumn($alias . '._isjson');
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
        return Propel::getServiceContainer()->getDatabaseMap(DataTableMap::DATABASE_NAME)->getTable(DataTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(DataTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(DataTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new DataTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Data or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Data object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(DataTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Data) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(DataTableMap::DATABASE_NAME);
            $criteria->add(DataTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = DataQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            DataTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                DataTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the _data table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return DataQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Data or Criteria object.
     *
     * @param mixed               $criteria Criteria or Data object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DataTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Data object
        }

        if ($criteria->containsKey(DataTableMap::COL_ID) && $criteria->keyContainsValue(DataTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.DataTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = DataQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // DataTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
DataTableMap::buildTableMap();
