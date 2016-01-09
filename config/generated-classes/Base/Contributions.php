<?php

namespace Base;

use \Contributions as ChildContributions;
use \ContributionsQuery as ChildContributionsQuery;
use \Data as ChildData;
use \DataQuery as ChildDataQuery;
use \Formats as ChildFormats;
use \FormatsQuery as ChildFormatsQuery;
use \Issues as ChildIssues;
use \IssuesQuery as ChildIssuesQuery;
use \Templatenames as ChildTemplatenames;
use \TemplatenamesQuery as ChildTemplatenamesQuery;
use \Exception;
use \PDO;
use Map\ContributionsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the '_contributions' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Contributions implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\ContributionsTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     *
     * @var        int
     */
    protected $id;

    /**
     * The value for the _fortemplate field.
     *
     * @var        int
     */
    protected $_fortemplate;

    /**
     * The value for the _forissue field.
     *
     * @var        int
     */
    protected $_forissue;

    /**
     * The value for the _name field.
     *
     * @var        string
     */
    protected $_name;

    /**
     * The value for the _status field.
     *
     * @var        string
     */
    protected $_status;

    /**
     * The value for the _newdate field.
     *
     * @var        int
     */
    protected $_newdate;

    /**
     * The value for the _moddate field.
     *
     * @var        int
     */
    protected $_moddate;

    /**
     * The value for the __user__ field.
     *
     * @var        string
     */
    protected $__user__;

    /**
     * The value for the __config__ field.
     *
     * @var        string
     */
    protected $__config__;

    /**
     * The value for the _forchapter field.
     *
     * @var        int
     */
    protected $_forchapter;

    /**
     * The value for the __parentnode__ field.
     *
     * @var        int
     */
    protected $__parentnode__;

    /**
     * The value for the __sort__ field.
     *
     * @var        int
     */
    protected $__sort__;

    /**
     * @var        ChildFormats
     */
    protected $aFormats;

    /**
     * @var        ChildIssues
     */
    protected $aIssues;

    /**
     * @var        ChildTemplatenames
     */
    protected $aTemplatenames;

    /**
     * @var        ObjectCollection|ChildData[] Collection to store aggregation of ChildData objects.
     */
    protected $collDatas;
    protected $collDatasPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildData[]
     */
    protected $datasScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Contributions object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Contributions</code> instance.  If
     * <code>obj</code> is an instance of <code>Contributions</code>, delegates to
     * <code>equals(Contributions)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Contributions The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [_fortemplate] column value.
     *
     * @return int
     */
    public function getFortemplate()
    {
        return $this->_fortemplate;
    }

    /**
     * Get the [_forissue] column value.
     *
     * @return int
     */
    public function getForissue()
    {
        return $this->_forissue;
    }

    /**
     * Get the [_name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Get the [_status] column value.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->_status;
    }

    /**
     * Get the [_newdate] column value.
     *
     * @return int
     */
    public function getNewdate()
    {
        return $this->_newdate;
    }

    /**
     * Get the [_moddate] column value.
     *
     * @return int
     */
    public function getModdate()
    {
        return $this->_moddate;
    }

    /**
     * Get the [__user__] column value.
     *
     * @return string
     */
    public function getUserSys()
    {
        return $this->__user__;
    }

    /**
     * Get the [__config__] column value.
     *
     * @return string
     */
    public function getConfigSys()
    {
        return $this->__config__;
    }

    /**
     * Get the [_forchapter] column value.
     *
     * @return int
     */
    public function getForchapter()
    {
        return $this->_forchapter;
    }

    /**
     * Get the [__parentnode__] column value.
     *
     * @return int
     */
    public function getParentnode()
    {
        return $this->__parentnode__;
    }

    /**
     * Get the [__sort__] column value.
     *
     * @return int
     */
    public function getSort()
    {
        return $this->__sort__;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Contributions The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[ContributionsTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [_fortemplate] column.
     *
     * @param int $v new value
     * @return $this|\Contributions The current object (for fluent API support)
     */
    public function setFortemplate($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->_fortemplate !== $v) {
            $this->_fortemplate = $v;
            $this->modifiedColumns[ContributionsTableMap::COL__FORTEMPLATE] = true;
        }

        if ($this->aTemplatenames !== null && $this->aTemplatenames->getId() !== $v) {
            $this->aTemplatenames = null;
        }

        return $this;
    } // setFortemplate()

    /**
     * Set the value of [_forissue] column.
     *
     * @param int $v new value
     * @return $this|\Contributions The current object (for fluent API support)
     */
    public function setForissue($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->_forissue !== $v) {
            $this->_forissue = $v;
            $this->modifiedColumns[ContributionsTableMap::COL__FORISSUE] = true;
        }

        if ($this->aIssues !== null && $this->aIssues->getId() !== $v) {
            $this->aIssues = null;
        }

        return $this;
    } // setForissue()

    /**
     * Set the value of [_name] column.
     *
     * @param string $v new value
     * @return $this|\Contributions The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->_name !== $v) {
            $this->_name = $v;
            $this->modifiedColumns[ContributionsTableMap::COL__NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [_status] column.
     *
     * @param string $v new value
     * @return $this|\Contributions The current object (for fluent API support)
     */
    public function setStatus($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->_status !== $v) {
            $this->_status = $v;
            $this->modifiedColumns[ContributionsTableMap::COL__STATUS] = true;
        }

        return $this;
    } // setStatus()

    /**
     * Set the value of [_newdate] column.
     *
     * @param int $v new value
     * @return $this|\Contributions The current object (for fluent API support)
     */
    public function setNewdate($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->_newdate !== $v) {
            $this->_newdate = $v;
            $this->modifiedColumns[ContributionsTableMap::COL__NEWDATE] = true;
        }

        return $this;
    } // setNewdate()

    /**
     * Set the value of [_moddate] column.
     *
     * @param int $v new value
     * @return $this|\Contributions The current object (for fluent API support)
     */
    public function setModdate($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->_moddate !== $v) {
            $this->_moddate = $v;
            $this->modifiedColumns[ContributionsTableMap::COL__MODDATE] = true;
        }

        return $this;
    } // setModdate()

    /**
     * Set the value of [__user__] column.
     *
     * @param string $v new value
     * @return $this|\Contributions The current object (for fluent API support)
     */
    public function setUserSys($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->__user__ !== $v) {
            $this->__user__ = $v;
            $this->modifiedColumns[ContributionsTableMap::COL___USER__] = true;
        }

        return $this;
    } // setUserSys()

    /**
     * Set the value of [__config__] column.
     *
     * @param string $v new value
     * @return $this|\Contributions The current object (for fluent API support)
     */
    public function setConfigSys($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->__config__ !== $v) {
            $this->__config__ = $v;
            $this->modifiedColumns[ContributionsTableMap::COL___CONFIG__] = true;
        }

        return $this;
    } // setConfigSys()

    /**
     * Set the value of [_forchapter] column.
     *
     * @param int $v new value
     * @return $this|\Contributions The current object (for fluent API support)
     */
    public function setForchapter($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->_forchapter !== $v) {
            $this->_forchapter = $v;
            $this->modifiedColumns[ContributionsTableMap::COL__FORCHAPTER] = true;
        }

        if ($this->aFormats !== null && $this->aFormats->getId() !== $v) {
            $this->aFormats = null;
        }

        return $this;
    } // setForchapter()

    /**
     * Set the value of [__parentnode__] column.
     *
     * @param int $v new value
     * @return $this|\Contributions The current object (for fluent API support)
     */
    public function setParentnode($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->__parentnode__ !== $v) {
            $this->__parentnode__ = $v;
            $this->modifiedColumns[ContributionsTableMap::COL___PARENTNODE__] = true;
        }

        return $this;
    } // setParentnode()

    /**
     * Set the value of [__sort__] column.
     *
     * @param int $v new value
     * @return $this|\Contributions The current object (for fluent API support)
     */
    public function setSort($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->__sort__ !== $v) {
            $this->__sort__ = $v;
            $this->modifiedColumns[ContributionsTableMap::COL___SORT__] = true;
        }

        return $this;
    } // setSort()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ContributionsTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ContributionsTableMap::translateFieldName('Fortemplate', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_fortemplate = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ContributionsTableMap::translateFieldName('Forissue', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_forissue = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ContributionsTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ContributionsTableMap::translateFieldName('Status', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_status = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : ContributionsTableMap::translateFieldName('Newdate', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_newdate = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : ContributionsTableMap::translateFieldName('Moddate', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_moddate = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : ContributionsTableMap::translateFieldName('UserSys', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__user__ = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : ContributionsTableMap::translateFieldName('ConfigSys', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__config__ = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : ContributionsTableMap::translateFieldName('Forchapter', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_forchapter = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : ContributionsTableMap::translateFieldName('Parentnode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__parentnode__ = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : ContributionsTableMap::translateFieldName('Sort', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__sort__ = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 12; // 12 = ContributionsTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Contributions'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aTemplatenames !== null && $this->_fortemplate !== $this->aTemplatenames->getId()) {
            $this->aTemplatenames = null;
        }
        if ($this->aIssues !== null && $this->_forissue !== $this->aIssues->getId()) {
            $this->aIssues = null;
        }
        if ($this->aFormats !== null && $this->_forchapter !== $this->aFormats->getId()) {
            $this->aFormats = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ContributionsTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildContributionsQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aFormats = null;
            $this->aIssues = null;
            $this->aTemplatenames = null;
            $this->collDatas = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Contributions::setDeleted()
     * @see Contributions::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ContributionsTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildContributionsQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ContributionsTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                ContributionsTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aFormats !== null) {
                if ($this->aFormats->isModified() || $this->aFormats->isNew()) {
                    $affectedRows += $this->aFormats->save($con);
                }
                $this->setFormats($this->aFormats);
            }

            if ($this->aIssues !== null) {
                if ($this->aIssues->isModified() || $this->aIssues->isNew()) {
                    $affectedRows += $this->aIssues->save($con);
                }
                $this->setIssues($this->aIssues);
            }

            if ($this->aTemplatenames !== null) {
                if ($this->aTemplatenames->isModified() || $this->aTemplatenames->isNew()) {
                    $affectedRows += $this->aTemplatenames->save($con);
                }
                $this->setTemplatenames($this->aTemplatenames);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->datasScheduledForDeletion !== null) {
                if (!$this->datasScheduledForDeletion->isEmpty()) {
                    \DataQuery::create()
                        ->filterByPrimaryKeys($this->datasScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->datasScheduledForDeletion = null;
                }
            }

            if ($this->collDatas !== null) {
                foreach ($this->collDatas as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[ContributionsTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ContributionsTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ContributionsTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(ContributionsTableMap::COL__FORTEMPLATE)) {
            $modifiedColumns[':p' . $index++]  = '_fortemplate';
        }
        if ($this->isColumnModified(ContributionsTableMap::COL__FORISSUE)) {
            $modifiedColumns[':p' . $index++]  = '_forissue';
        }
        if ($this->isColumnModified(ContributionsTableMap::COL__NAME)) {
            $modifiedColumns[':p' . $index++]  = '_name';
        }
        if ($this->isColumnModified(ContributionsTableMap::COL__STATUS)) {
            $modifiedColumns[':p' . $index++]  = '_status';
        }
        if ($this->isColumnModified(ContributionsTableMap::COL__NEWDATE)) {
            $modifiedColumns[':p' . $index++]  = '_newdate';
        }
        if ($this->isColumnModified(ContributionsTableMap::COL__MODDATE)) {
            $modifiedColumns[':p' . $index++]  = '_moddate';
        }
        if ($this->isColumnModified(ContributionsTableMap::COL___USER__)) {
            $modifiedColumns[':p' . $index++]  = '__user__';
        }
        if ($this->isColumnModified(ContributionsTableMap::COL___CONFIG__)) {
            $modifiedColumns[':p' . $index++]  = '__config__';
        }
        if ($this->isColumnModified(ContributionsTableMap::COL__FORCHAPTER)) {
            $modifiedColumns[':p' . $index++]  = '_forchapter';
        }
        if ($this->isColumnModified(ContributionsTableMap::COL___PARENTNODE__)) {
            $modifiedColumns[':p' . $index++]  = '__parentnode__';
        }
        if ($this->isColumnModified(ContributionsTableMap::COL___SORT__)) {
            $modifiedColumns[':p' . $index++]  = '__sort__';
        }

        $sql = sprintf(
            'INSERT INTO _contributions (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case '_fortemplate':
                        $stmt->bindValue($identifier, $this->_fortemplate, PDO::PARAM_INT);
                        break;
                    case '_forissue':
                        $stmt->bindValue($identifier, $this->_forissue, PDO::PARAM_INT);
                        break;
                    case '_name':
                        $stmt->bindValue($identifier, $this->_name, PDO::PARAM_STR);
                        break;
                    case '_status':
                        $stmt->bindValue($identifier, $this->_status, PDO::PARAM_STR);
                        break;
                    case '_newdate':
                        $stmt->bindValue($identifier, $this->_newdate, PDO::PARAM_INT);
                        break;
                    case '_moddate':
                        $stmt->bindValue($identifier, $this->_moddate, PDO::PARAM_INT);
                        break;
                    case '__user__':
                        $stmt->bindValue($identifier, $this->__user__, PDO::PARAM_STR);
                        break;
                    case '__config__':
                        $stmt->bindValue($identifier, $this->__config__, PDO::PARAM_STR);
                        break;
                    case '_forchapter':
                        $stmt->bindValue($identifier, $this->_forchapter, PDO::PARAM_INT);
                        break;
                    case '__parentnode__':
                        $stmt->bindValue($identifier, $this->__parentnode__, PDO::PARAM_INT);
                        break;
                    case '__sort__':
                        $stmt->bindValue($identifier, $this->__sort__, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ContributionsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getFortemplate();
                break;
            case 2:
                return $this->getForissue();
                break;
            case 3:
                return $this->getName();
                break;
            case 4:
                return $this->getStatus();
                break;
            case 5:
                return $this->getNewdate();
                break;
            case 6:
                return $this->getModdate();
                break;
            case 7:
                return $this->getUserSys();
                break;
            case 8:
                return $this->getConfigSys();
                break;
            case 9:
                return $this->getForchapter();
                break;
            case 10:
                return $this->getParentnode();
                break;
            case 11:
                return $this->getSort();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Contributions'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Contributions'][$this->hashCode()] = true;
        $keys = ContributionsTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getFortemplate(),
            $keys[2] => $this->getForissue(),
            $keys[3] => $this->getName(),
            $keys[4] => $this->getStatus(),
            $keys[5] => $this->getNewdate(),
            $keys[6] => $this->getModdate(),
            $keys[7] => $this->getUserSys(),
            $keys[8] => $this->getConfigSys(),
            $keys[9] => $this->getForchapter(),
            $keys[10] => $this->getParentnode(),
            $keys[11] => $this->getSort(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aFormats) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'formats';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = '_formats';
                        break;
                    default:
                        $key = 'Formats';
                }

                $result[$key] = $this->aFormats->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aIssues) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'issues';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = '_issues';
                        break;
                    default:
                        $key = 'Issues';
                }

                $result[$key] = $this->aIssues->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aTemplatenames) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'templatenames';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = '_templatenames';
                        break;
                    default:
                        $key = 'Templatenames';
                }

                $result[$key] = $this->aTemplatenames->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collDatas) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'datas';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = '_datas';
                        break;
                    default:
                        $key = 'Datas';
                }

                $result[$key] = $this->collDatas->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Contributions
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ContributionsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Contributions
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setFortemplate($value);
                break;
            case 2:
                $this->setForissue($value);
                break;
            case 3:
                $this->setName($value);
                break;
            case 4:
                $this->setStatus($value);
                break;
            case 5:
                $this->setNewdate($value);
                break;
            case 6:
                $this->setModdate($value);
                break;
            case 7:
                $this->setUserSys($value);
                break;
            case 8:
                $this->setConfigSys($value);
                break;
            case 9:
                $this->setForchapter($value);
                break;
            case 10:
                $this->setParentnode($value);
                break;
            case 11:
                $this->setSort($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = ContributionsTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setFortemplate($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setForissue($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setName($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setStatus($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setNewdate($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setModdate($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setUserSys($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setConfigSys($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setForchapter($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setParentnode($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setSort($arr[$keys[11]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Contributions The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ContributionsTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ContributionsTableMap::COL_ID)) {
            $criteria->add(ContributionsTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(ContributionsTableMap::COL__FORTEMPLATE)) {
            $criteria->add(ContributionsTableMap::COL__FORTEMPLATE, $this->_fortemplate);
        }
        if ($this->isColumnModified(ContributionsTableMap::COL__FORISSUE)) {
            $criteria->add(ContributionsTableMap::COL__FORISSUE, $this->_forissue);
        }
        if ($this->isColumnModified(ContributionsTableMap::COL__NAME)) {
            $criteria->add(ContributionsTableMap::COL__NAME, $this->_name);
        }
        if ($this->isColumnModified(ContributionsTableMap::COL__STATUS)) {
            $criteria->add(ContributionsTableMap::COL__STATUS, $this->_status);
        }
        if ($this->isColumnModified(ContributionsTableMap::COL__NEWDATE)) {
            $criteria->add(ContributionsTableMap::COL__NEWDATE, $this->_newdate);
        }
        if ($this->isColumnModified(ContributionsTableMap::COL__MODDATE)) {
            $criteria->add(ContributionsTableMap::COL__MODDATE, $this->_moddate);
        }
        if ($this->isColumnModified(ContributionsTableMap::COL___USER__)) {
            $criteria->add(ContributionsTableMap::COL___USER__, $this->__user__);
        }
        if ($this->isColumnModified(ContributionsTableMap::COL___CONFIG__)) {
            $criteria->add(ContributionsTableMap::COL___CONFIG__, $this->__config__);
        }
        if ($this->isColumnModified(ContributionsTableMap::COL__FORCHAPTER)) {
            $criteria->add(ContributionsTableMap::COL__FORCHAPTER, $this->_forchapter);
        }
        if ($this->isColumnModified(ContributionsTableMap::COL___PARENTNODE__)) {
            $criteria->add(ContributionsTableMap::COL___PARENTNODE__, $this->__parentnode__);
        }
        if ($this->isColumnModified(ContributionsTableMap::COL___SORT__)) {
            $criteria->add(ContributionsTableMap::COL___SORT__, $this->__sort__);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildContributionsQuery::create();
        $criteria->add(ContributionsTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Contributions (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setFortemplate($this->getFortemplate());
        $copyObj->setForissue($this->getForissue());
        $copyObj->setName($this->getName());
        $copyObj->setStatus($this->getStatus());
        $copyObj->setNewdate($this->getNewdate());
        $copyObj->setModdate($this->getModdate());
        $copyObj->setUserSys($this->getUserSys());
        $copyObj->setConfigSys($this->getConfigSys());
        $copyObj->setForchapter($this->getForchapter());
        $copyObj->setParentnode($this->getParentnode());
        $copyObj->setSort($this->getSort());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getDatas() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addData($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Contributions Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildFormats object.
     *
     * @param  ChildFormats $v
     * @return $this|\Contributions The current object (for fluent API support)
     * @throws PropelException
     */
    public function setFormats(ChildFormats $v = null)
    {
        if ($v === null) {
            $this->setForchapter(NULL);
        } else {
            $this->setForchapter($v->getId());
        }

        $this->aFormats = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildFormats object, it will not be re-added.
        if ($v !== null) {
            $v->addContributions($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildFormats object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildFormats The associated ChildFormats object.
     * @throws PropelException
     */
    public function getFormats(ConnectionInterface $con = null)
    {
        if ($this->aFormats === null && ($this->_forchapter !== null)) {
            $this->aFormats = ChildFormatsQuery::create()->findPk($this->_forchapter, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aFormats->addContributionss($this);
             */
        }

        return $this->aFormats;
    }

    /**
     * Declares an association between this object and a ChildIssues object.
     *
     * @param  ChildIssues $v
     * @return $this|\Contributions The current object (for fluent API support)
     * @throws PropelException
     */
    public function setIssues(ChildIssues $v = null)
    {
        if ($v === null) {
            $this->setForissue(NULL);
        } else {
            $this->setForissue($v->getId());
        }

        $this->aIssues = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildIssues object, it will not be re-added.
        if ($v !== null) {
            $v->addContributions($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildIssues object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildIssues The associated ChildIssues object.
     * @throws PropelException
     */
    public function getIssues(ConnectionInterface $con = null)
    {
        if ($this->aIssues === null && ($this->_forissue !== null)) {
            $this->aIssues = ChildIssuesQuery::create()->findPk($this->_forissue, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aIssues->addContributionss($this);
             */
        }

        return $this->aIssues;
    }

    /**
     * Declares an association between this object and a ChildTemplatenames object.
     *
     * @param  ChildTemplatenames $v
     * @return $this|\Contributions The current object (for fluent API support)
     * @throws PropelException
     */
    public function setTemplatenames(ChildTemplatenames $v = null)
    {
        if ($v === null) {
            $this->setFortemplate(NULL);
        } else {
            $this->setFortemplate($v->getId());
        }

        $this->aTemplatenames = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildTemplatenames object, it will not be re-added.
        if ($v !== null) {
            $v->addContributions($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildTemplatenames object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildTemplatenames The associated ChildTemplatenames object.
     * @throws PropelException
     */
    public function getTemplatenames(ConnectionInterface $con = null)
    {
        if ($this->aTemplatenames === null && ($this->_fortemplate !== null)) {
            $this->aTemplatenames = ChildTemplatenamesQuery::create()->findPk($this->_fortemplate, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aTemplatenames->addContributionss($this);
             */
        }

        return $this->aTemplatenames;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Data' == $relationName) {
            return $this->initDatas();
        }
    }

    /**
     * Clears out the collDatas collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addDatas()
     */
    public function clearDatas()
    {
        $this->collDatas = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collDatas collection loaded partially.
     */
    public function resetPartialDatas($v = true)
    {
        $this->collDatasPartial = $v;
    }

    /**
     * Initializes the collDatas collection.
     *
     * By default this just sets the collDatas collection to an empty array (like clearcollDatas());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initDatas($overrideExisting = true)
    {
        if (null !== $this->collDatas && !$overrideExisting) {
            return;
        }
        $this->collDatas = new ObjectCollection();
        $this->collDatas->setModel('\Data');
    }

    /**
     * Gets an array of ChildData objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildContributions is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildData[] List of ChildData objects
     * @throws PropelException
     */
    public function getDatas(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collDatasPartial && !$this->isNew();
        if (null === $this->collDatas || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collDatas) {
                // return empty collection
                $this->initDatas();
            } else {
                $collDatas = ChildDataQuery::create(null, $criteria)
                    ->filterByContributions($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collDatasPartial && count($collDatas)) {
                        $this->initDatas(false);

                        foreach ($collDatas as $obj) {
                            if (false == $this->collDatas->contains($obj)) {
                                $this->collDatas->append($obj);
                            }
                        }

                        $this->collDatasPartial = true;
                    }

                    return $collDatas;
                }

                if ($partial && $this->collDatas) {
                    foreach ($this->collDatas as $obj) {
                        if ($obj->isNew()) {
                            $collDatas[] = $obj;
                        }
                    }
                }

                $this->collDatas = $collDatas;
                $this->collDatasPartial = false;
            }
        }

        return $this->collDatas;
    }

    /**
     * Sets a collection of ChildData objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $datas A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildContributions The current object (for fluent API support)
     */
    public function setDatas(Collection $datas, ConnectionInterface $con = null)
    {
        /** @var ChildData[] $datasToDelete */
        $datasToDelete = $this->getDatas(new Criteria(), $con)->diff($datas);


        $this->datasScheduledForDeletion = $datasToDelete;

        foreach ($datasToDelete as $dataRemoved) {
            $dataRemoved->setContributions(null);
        }

        $this->collDatas = null;
        foreach ($datas as $data) {
            $this->addData($data);
        }

        $this->collDatas = $datas;
        $this->collDatasPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Data objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Data objects.
     * @throws PropelException
     */
    public function countDatas(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collDatasPartial && !$this->isNew();
        if (null === $this->collDatas || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collDatas) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getDatas());
            }

            $query = ChildDataQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByContributions($this)
                ->count($con);
        }

        return count($this->collDatas);
    }

    /**
     * Method called to associate a ChildData object to this object
     * through the ChildData foreign key attribute.
     *
     * @param  ChildData $l ChildData
     * @return $this|\Contributions The current object (for fluent API support)
     */
    public function addData(ChildData $l)
    {
        if ($this->collDatas === null) {
            $this->initDatas();
            $this->collDatasPartial = true;
        }

        if (!$this->collDatas->contains($l)) {
            $this->doAddData($l);

            if ($this->datasScheduledForDeletion and $this->datasScheduledForDeletion->contains($l)) {
                $this->datasScheduledForDeletion->remove($this->datasScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildData $data The ChildData object to add.
     */
    protected function doAddData(ChildData $data)
    {
        $this->collDatas[]= $data;
        $data->setContributions($this);
    }

    /**
     * @param  ChildData $data The ChildData object to remove.
     * @return $this|ChildContributions The current object (for fluent API support)
     */
    public function removeData(ChildData $data)
    {
        if ($this->getDatas()->contains($data)) {
            $pos = $this->collDatas->search($data);
            $this->collDatas->remove($pos);
            if (null === $this->datasScheduledForDeletion) {
                $this->datasScheduledForDeletion = clone $this->collDatas;
                $this->datasScheduledForDeletion->clear();
            }
            $this->datasScheduledForDeletion[]= $data;
            $data->setContributions(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Contributions is new, it will return
     * an empty collection; or if this Contributions has previously
     * been saved, it will retrieve related Datas from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Contributions.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildData[] List of ChildData objects
     */
    public function getDatasJoinTemplates(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildDataQuery::create(null, $criteria);
        $query->joinWith('Templates', $joinBehavior);

        return $this->getDatas($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aFormats) {
            $this->aFormats->removeContributions($this);
        }
        if (null !== $this->aIssues) {
            $this->aIssues->removeContributions($this);
        }
        if (null !== $this->aTemplatenames) {
            $this->aTemplatenames->removeContributions($this);
        }
        $this->id = null;
        $this->_fortemplate = null;
        $this->_forissue = null;
        $this->_name = null;
        $this->_status = null;
        $this->_newdate = null;
        $this->_moddate = null;
        $this->__user__ = null;
        $this->__config__ = null;
        $this->_forchapter = null;
        $this->__parentnode__ = null;
        $this->__sort__ = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collDatas) {
                foreach ($this->collDatas as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collDatas = null;
        $this->aFormats = null;
        $this->aIssues = null;
        $this->aTemplatenames = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ContributionsTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
