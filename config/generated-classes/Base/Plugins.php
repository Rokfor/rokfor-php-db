<?php

namespace Base;

use \Issues as ChildIssues;
use \IssuesQuery as ChildIssuesQuery;
use \Plugins as ChildPlugins;
use \PluginsQuery as ChildPluginsQuery;
use \RIssuesAllplugin as ChildRIssuesAllplugin;
use \RIssuesAllpluginQuery as ChildRIssuesAllpluginQuery;
use \RIssuesNarrationplugin as ChildRIssuesNarrationplugin;
use \RIssuesNarrationpluginQuery as ChildRIssuesNarrationpluginQuery;
use \RIssuesRtfplugin as ChildRIssuesRtfplugin;
use \RIssuesRtfpluginQuery as ChildRIssuesRtfpluginQuery;
use \RIssuesSingleplugin as ChildRIssuesSingleplugin;
use \RIssuesSinglepluginQuery as ChildRIssuesSinglepluginQuery;
use \RIssuesXmlplugin as ChildRIssuesXmlplugin;
use \RIssuesXmlpluginQuery as ChildRIssuesXmlpluginQuery;
use \Exception;
use \PDO;
use Map\PluginsTableMap;
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
 * Base class that represents a row from the '_plugins' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Plugins implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\PluginsTableMap';


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
     * The value for the _name field.
     *
     * @var        string
     */
    protected $_name;

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
     * The value for the __split__ field.
     *
     * @var        string
     */
    protected $__split__;

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
     * The value for the _page field.
     *
     * @var        string
     */
    protected $_page;

    /**
     * The value for the _config field.
     *
     * @var        string
     */
    protected $_config;

    /**
     * The value for the _callback field.
     *
     * @var        string
     */
    protected $_callback;

    /**
     * @var        ObjectCollection|ChildRIssuesAllplugin[] Collection to store aggregation of ChildRIssuesAllplugin objects.
     */
    protected $collRIssuesAllplugins;
    protected $collRIssuesAllpluginsPartial;

    /**
     * @var        ObjectCollection|ChildRIssuesNarrationplugin[] Collection to store aggregation of ChildRIssuesNarrationplugin objects.
     */
    protected $collRIssuesNarrationplugins;
    protected $collRIssuesNarrationpluginsPartial;

    /**
     * @var        ObjectCollection|ChildRIssuesRtfplugin[] Collection to store aggregation of ChildRIssuesRtfplugin objects.
     */
    protected $collRIssuesRtfplugins;
    protected $collRIssuesRtfpluginsPartial;

    /**
     * @var        ObjectCollection|ChildRIssuesSingleplugin[] Collection to store aggregation of ChildRIssuesSingleplugin objects.
     */
    protected $collRIssuesSingleplugins;
    protected $collRIssuesSinglepluginsPartial;

    /**
     * @var        ObjectCollection|ChildRIssuesXmlplugin[] Collection to store aggregation of ChildRIssuesXmlplugin objects.
     */
    protected $collRIssuesXmlplugins;
    protected $collRIssuesXmlpluginsPartial;

    /**
     * @var        ObjectCollection|ChildIssues[] Cross Collection to store aggregation of ChildIssues objects.
     */
    protected $collIssuess;

    /**
     * @var bool
     */
    protected $collIssuessPartial;

    /**
     * @var        ObjectCollection|ChildIssues[] Cross Collection to store aggregation of ChildIssues objects.
     */
    protected $collIssuess;

    /**
     * @var bool
     */
    protected $collIssuessPartial;

    /**
     * @var        ObjectCollection|ChildIssues[] Cross Collection to store aggregation of ChildIssues objects.
     */
    protected $collIssuess;

    /**
     * @var bool
     */
    protected $collIssuessPartial;

    /**
     * @var        ObjectCollection|ChildIssues[] Cross Collection to store aggregation of ChildIssues objects.
     */
    protected $collIssuess;

    /**
     * @var bool
     */
    protected $collIssuessPartial;

    /**
     * @var        ObjectCollection|ChildIssues[] Cross Collection to store aggregation of ChildIssues objects.
     */
    protected $collIssuess;

    /**
     * @var bool
     */
    protected $collIssuessPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildIssues[]
     */
    protected $issuessScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildIssues[]
     */
    protected $issuessScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildIssues[]
     */
    protected $issuessScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildIssues[]
     */
    protected $issuessScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildIssues[]
     */
    protected $issuessScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRIssuesAllplugin[]
     */
    protected $rIssuesAllpluginsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRIssuesNarrationplugin[]
     */
    protected $rIssuesNarrationpluginsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRIssuesRtfplugin[]
     */
    protected $rIssuesRtfpluginsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRIssuesSingleplugin[]
     */
    protected $rIssuesSinglepluginsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRIssuesXmlplugin[]
     */
    protected $rIssuesXmlpluginsScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Plugins object.
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
     * Compares this with another <code>Plugins</code> instance.  If
     * <code>obj</code> is an instance of <code>Plugins</code>, delegates to
     * <code>equals(Plugins)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Plugins The current object, for fluid interface
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
     * Get the [_name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Get the [__user__] column value.
     *
     * @return string
     */
    public function getUser()
    {
        return $this->__user__;
    }

    /**
     * Get the [__config__] column value.
     *
     * @return string
     */
    public function getConfig()
    {
        return $this->__config__;
    }

    /**
     * Get the [__split__] column value.
     *
     * @return string
     */
    public function getSplit()
    {
        return $this->__split__;
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
     * Get the [_page] column value.
     *
     * @return string
     */
    public function getPage()
    {
        return $this->_page;
    }

    /**
     * Get the [_config] column value.
     *
     * @return string
     */
    public function getConfig()
    {
        return $this->_config;
    }

    /**
     * Get the [_callback] column value.
     *
     * @return string
     */
    public function getCallback()
    {
        return $this->_callback;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Plugins The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[PluginsTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [_name] column.
     *
     * @param string $v new value
     * @return $this|\Plugins The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->_name !== $v) {
            $this->_name = $v;
            $this->modifiedColumns[PluginsTableMap::COL__NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [__user__] column.
     *
     * @param string $v new value
     * @return $this|\Plugins The current object (for fluent API support)
     */
    public function setUser($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->__user__ !== $v) {
            $this->__user__ = $v;
            $this->modifiedColumns[PluginsTableMap::COL___USER__] = true;
        }

        return $this;
    } // setUser()

    /**
     * Set the value of [__config__] column.
     *
     * @param string $v new value
     * @return $this|\Plugins The current object (for fluent API support)
     */
    public function setConfig($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->__config__ !== $v) {
            $this->__config__ = $v;
            $this->modifiedColumns[PluginsTableMap::COL___CONFIG__] = true;
        }

        return $this;
    } // setConfig()

    /**
     * Set the value of [__split__] column.
     *
     * @param string $v new value
     * @return $this|\Plugins The current object (for fluent API support)
     */
    public function setSplit($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->__split__ !== $v) {
            $this->__split__ = $v;
            $this->modifiedColumns[PluginsTableMap::COL___SPLIT__] = true;
        }

        return $this;
    } // setSplit()

    /**
     * Set the value of [__parentnode__] column.
     *
     * @param int $v new value
     * @return $this|\Plugins The current object (for fluent API support)
     */
    public function setParentnode($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->__parentnode__ !== $v) {
            $this->__parentnode__ = $v;
            $this->modifiedColumns[PluginsTableMap::COL___PARENTNODE__] = true;
        }

        return $this;
    } // setParentnode()

    /**
     * Set the value of [__sort__] column.
     *
     * @param int $v new value
     * @return $this|\Plugins The current object (for fluent API support)
     */
    public function setSort($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->__sort__ !== $v) {
            $this->__sort__ = $v;
            $this->modifiedColumns[PluginsTableMap::COL___SORT__] = true;
        }

        return $this;
    } // setSort()

    /**
     * Set the value of [_page] column.
     *
     * @param string $v new value
     * @return $this|\Plugins The current object (for fluent API support)
     */
    public function setPage($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->_page !== $v) {
            $this->_page = $v;
            $this->modifiedColumns[PluginsTableMap::COL__PAGE] = true;
        }

        return $this;
    } // setPage()

    /**
     * Set the value of [_config] column.
     *
     * @param string $v new value
     * @return $this|\Plugins The current object (for fluent API support)
     */
    public function setConfig($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->_config !== $v) {
            $this->_config = $v;
            $this->modifiedColumns[PluginsTableMap::COL__CONFIG] = true;
        }

        return $this;
    } // setConfig()

    /**
     * Set the value of [_callback] column.
     *
     * @param string $v new value
     * @return $this|\Plugins The current object (for fluent API support)
     */
    public function setCallback($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->_callback !== $v) {
            $this->_callback = $v;
            $this->modifiedColumns[PluginsTableMap::COL__CALLBACK] = true;
        }

        return $this;
    } // setCallback()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PluginsTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PluginsTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PluginsTableMap::translateFieldName('User', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__user__ = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : PluginsTableMap::translateFieldName('Config', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__config__ = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : PluginsTableMap::translateFieldName('Split', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__split__ = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : PluginsTableMap::translateFieldName('Parentnode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__parentnode__ = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : PluginsTableMap::translateFieldName('Sort', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__sort__ = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : PluginsTableMap::translateFieldName('Page', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_page = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : PluginsTableMap::translateFieldName('Config', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_config = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : PluginsTableMap::translateFieldName('Callback', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_callback = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 10; // 10 = PluginsTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Plugins'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(PluginsTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPluginsQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collRIssuesAllplugins = null;

            $this->collRIssuesNarrationplugins = null;

            $this->collRIssuesRtfplugins = null;

            $this->collRIssuesSingleplugins = null;

            $this->collRIssuesXmlplugins = null;

            $this->collIssuess = null;
            $this->collIssuess = null;
            $this->collIssuess = null;
            $this->collIssuess = null;
            $this->collIssuess = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Plugins::setDeleted()
     * @see Plugins::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PluginsTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPluginsQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(PluginsTableMap::DATABASE_NAME);
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
                PluginsTableMap::addInstanceToPool($this);
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

            if ($this->issuessScheduledForDeletion !== null) {
                if (!$this->issuessScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->issuessScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[0] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \RIssuesAllpluginQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->issuessScheduledForDeletion = null;
                }

            }

            if ($this->collIssuess) {
                foreach ($this->collIssuess as $issues) {
                    if (!$issues->isDeleted() && ($issues->isNew() || $issues->isModified())) {
                        $issues->save($con);
                    }
                }
            }


            if ($this->issuessScheduledForDeletion !== null) {
                if (!$this->issuessScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->issuessScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[0] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \RIssuesNarrationpluginQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->issuessScheduledForDeletion = null;
                }

            }

            if ($this->collIssuess) {
                foreach ($this->collIssuess as $issues) {
                    if (!$issues->isDeleted() && ($issues->isNew() || $issues->isModified())) {
                        $issues->save($con);
                    }
                }
            }


            if ($this->issuessScheduledForDeletion !== null) {
                if (!$this->issuessScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->issuessScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[0] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \RIssuesRtfpluginQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->issuessScheduledForDeletion = null;
                }

            }

            if ($this->collIssuess) {
                foreach ($this->collIssuess as $issues) {
                    if (!$issues->isDeleted() && ($issues->isNew() || $issues->isModified())) {
                        $issues->save($con);
                    }
                }
            }


            if ($this->issuessScheduledForDeletion !== null) {
                if (!$this->issuessScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->issuessScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[0] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \RIssuesSinglepluginQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->issuessScheduledForDeletion = null;
                }

            }

            if ($this->collIssuess) {
                foreach ($this->collIssuess as $issues) {
                    if (!$issues->isDeleted() && ($issues->isNew() || $issues->isModified())) {
                        $issues->save($con);
                    }
                }
            }


            if ($this->issuessScheduledForDeletion !== null) {
                if (!$this->issuessScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->issuessScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[0] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \RIssuesXmlpluginQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->issuessScheduledForDeletion = null;
                }

            }

            if ($this->collIssuess) {
                foreach ($this->collIssuess as $issues) {
                    if (!$issues->isDeleted() && ($issues->isNew() || $issues->isModified())) {
                        $issues->save($con);
                    }
                }
            }


            if ($this->rIssuesAllpluginsScheduledForDeletion !== null) {
                if (!$this->rIssuesAllpluginsScheduledForDeletion->isEmpty()) {
                    \RIssuesAllpluginQuery::create()
                        ->filterByPrimaryKeys($this->rIssuesAllpluginsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->rIssuesAllpluginsScheduledForDeletion = null;
                }
            }

            if ($this->collRIssuesAllplugins !== null) {
                foreach ($this->collRIssuesAllplugins as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->rIssuesNarrationpluginsScheduledForDeletion !== null) {
                if (!$this->rIssuesNarrationpluginsScheduledForDeletion->isEmpty()) {
                    \RIssuesNarrationpluginQuery::create()
                        ->filterByPrimaryKeys($this->rIssuesNarrationpluginsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->rIssuesNarrationpluginsScheduledForDeletion = null;
                }
            }

            if ($this->collRIssuesNarrationplugins !== null) {
                foreach ($this->collRIssuesNarrationplugins as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->rIssuesRtfpluginsScheduledForDeletion !== null) {
                if (!$this->rIssuesRtfpluginsScheduledForDeletion->isEmpty()) {
                    \RIssuesRtfpluginQuery::create()
                        ->filterByPrimaryKeys($this->rIssuesRtfpluginsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->rIssuesRtfpluginsScheduledForDeletion = null;
                }
            }

            if ($this->collRIssuesRtfplugins !== null) {
                foreach ($this->collRIssuesRtfplugins as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->rIssuesSinglepluginsScheduledForDeletion !== null) {
                if (!$this->rIssuesSinglepluginsScheduledForDeletion->isEmpty()) {
                    \RIssuesSinglepluginQuery::create()
                        ->filterByPrimaryKeys($this->rIssuesSinglepluginsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->rIssuesSinglepluginsScheduledForDeletion = null;
                }
            }

            if ($this->collRIssuesSingleplugins !== null) {
                foreach ($this->collRIssuesSingleplugins as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->rIssuesXmlpluginsScheduledForDeletion !== null) {
                if (!$this->rIssuesXmlpluginsScheduledForDeletion->isEmpty()) {
                    \RIssuesXmlpluginQuery::create()
                        ->filterByPrimaryKeys($this->rIssuesXmlpluginsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->rIssuesXmlpluginsScheduledForDeletion = null;
                }
            }

            if ($this->collRIssuesXmlplugins !== null) {
                foreach ($this->collRIssuesXmlplugins as $referrerFK) {
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

        $this->modifiedColumns[PluginsTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PluginsTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PluginsTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(PluginsTableMap::COL__NAME)) {
            $modifiedColumns[':p' . $index++]  = '_name';
        }
        if ($this->isColumnModified(PluginsTableMap::COL___USER__)) {
            $modifiedColumns[':p' . $index++]  = '__user__';
        }
        if ($this->isColumnModified(PluginsTableMap::COL___CONFIG__)) {
            $modifiedColumns[':p' . $index++]  = '__config__';
        }
        if ($this->isColumnModified(PluginsTableMap::COL___SPLIT__)) {
            $modifiedColumns[':p' . $index++]  = '__split__';
        }
        if ($this->isColumnModified(PluginsTableMap::COL___PARENTNODE__)) {
            $modifiedColumns[':p' . $index++]  = '__parentnode__';
        }
        if ($this->isColumnModified(PluginsTableMap::COL___SORT__)) {
            $modifiedColumns[':p' . $index++]  = '__sort__';
        }
        if ($this->isColumnModified(PluginsTableMap::COL__PAGE)) {
            $modifiedColumns[':p' . $index++]  = '_page';
        }
        if ($this->isColumnModified(PluginsTableMap::COL__CONFIG)) {
            $modifiedColumns[':p' . $index++]  = '_config';
        }
        if ($this->isColumnModified(PluginsTableMap::COL__CALLBACK)) {
            $modifiedColumns[':p' . $index++]  = '_callback';
        }

        $sql = sprintf(
            'INSERT INTO _plugins (%s) VALUES (%s)',
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
                    case '_name':
                        $stmt->bindValue($identifier, $this->_name, PDO::PARAM_STR);
                        break;
                    case '__user__':
                        $stmt->bindValue($identifier, $this->__user__, PDO::PARAM_STR);
                        break;
                    case '__config__':
                        $stmt->bindValue($identifier, $this->__config__, PDO::PARAM_STR);
                        break;
                    case '__split__':
                        $stmt->bindValue($identifier, $this->__split__, PDO::PARAM_STR);
                        break;
                    case '__parentnode__':
                        $stmt->bindValue($identifier, $this->__parentnode__, PDO::PARAM_INT);
                        break;
                    case '__sort__':
                        $stmt->bindValue($identifier, $this->__sort__, PDO::PARAM_INT);
                        break;
                    case '_page':
                        $stmt->bindValue($identifier, $this->_page, PDO::PARAM_STR);
                        break;
                    case '_config':
                        $stmt->bindValue($identifier, $this->_config, PDO::PARAM_STR);
                        break;
                    case '_callback':
                        $stmt->bindValue($identifier, $this->_callback, PDO::PARAM_STR);
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
        $pos = PluginsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getName();
                break;
            case 2:
                return $this->getUser();
                break;
            case 3:
                return $this->getConfig();
                break;
            case 4:
                return $this->getSplit();
                break;
            case 5:
                return $this->getParentnode();
                break;
            case 6:
                return $this->getSort();
                break;
            case 7:
                return $this->getPage();
                break;
            case 8:
                return $this->getConfig();
                break;
            case 9:
                return $this->getCallback();
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

        if (isset($alreadyDumpedObjects['Plugins'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Plugins'][$this->hashCode()] = true;
        $keys = PluginsTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getUser(),
            $keys[3] => $this->getConfig(),
            $keys[4] => $this->getSplit(),
            $keys[5] => $this->getParentnode(),
            $keys[6] => $this->getSort(),
            $keys[7] => $this->getPage(),
            $keys[8] => $this->getConfig(),
            $keys[9] => $this->getCallback(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collRIssuesAllplugins) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'rIssuesAllplugins';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'R_issues_allplugins';
                        break;
                    default:
                        $key = 'RIssuesAllplugins';
                }

                $result[$key] = $this->collRIssuesAllplugins->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRIssuesNarrationplugins) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'rIssuesNarrationplugins';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'R_issues_narrationplugins';
                        break;
                    default:
                        $key = 'RIssuesNarrationplugins';
                }

                $result[$key] = $this->collRIssuesNarrationplugins->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRIssuesRtfplugins) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'rIssuesRtfplugins';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'R_issues_rtfplugins';
                        break;
                    default:
                        $key = 'RIssuesRtfplugins';
                }

                $result[$key] = $this->collRIssuesRtfplugins->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRIssuesSingleplugins) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'rIssuesSingleplugins';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'R_issues_singleplugins';
                        break;
                    default:
                        $key = 'RIssuesSingleplugins';
                }

                $result[$key] = $this->collRIssuesSingleplugins->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRIssuesXmlplugins) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'rIssuesXmlplugins';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'R_issues_xmlplugins';
                        break;
                    default:
                        $key = 'RIssuesXmlplugins';
                }

                $result[$key] = $this->collRIssuesXmlplugins->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Plugins
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PluginsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Plugins
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setUser($value);
                break;
            case 3:
                $this->setConfig($value);
                break;
            case 4:
                $this->setSplit($value);
                break;
            case 5:
                $this->setParentnode($value);
                break;
            case 6:
                $this->setSort($value);
                break;
            case 7:
                $this->setPage($value);
                break;
            case 8:
                $this->setConfig($value);
                break;
            case 9:
                $this->setCallback($value);
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
        $keys = PluginsTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setUser($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setConfig($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setSplit($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setParentnode($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setSort($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setPage($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setConfig($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setCallback($arr[$keys[9]]);
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
     * @return $this|\Plugins The current object, for fluid interface
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
        $criteria = new Criteria(PluginsTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PluginsTableMap::COL_ID)) {
            $criteria->add(PluginsTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(PluginsTableMap::COL__NAME)) {
            $criteria->add(PluginsTableMap::COL__NAME, $this->_name);
        }
        if ($this->isColumnModified(PluginsTableMap::COL___USER__)) {
            $criteria->add(PluginsTableMap::COL___USER__, $this->__user__);
        }
        if ($this->isColumnModified(PluginsTableMap::COL___CONFIG__)) {
            $criteria->add(PluginsTableMap::COL___CONFIG__, $this->__config__);
        }
        if ($this->isColumnModified(PluginsTableMap::COL___SPLIT__)) {
            $criteria->add(PluginsTableMap::COL___SPLIT__, $this->__split__);
        }
        if ($this->isColumnModified(PluginsTableMap::COL___PARENTNODE__)) {
            $criteria->add(PluginsTableMap::COL___PARENTNODE__, $this->__parentnode__);
        }
        if ($this->isColumnModified(PluginsTableMap::COL___SORT__)) {
            $criteria->add(PluginsTableMap::COL___SORT__, $this->__sort__);
        }
        if ($this->isColumnModified(PluginsTableMap::COL__PAGE)) {
            $criteria->add(PluginsTableMap::COL__PAGE, $this->_page);
        }
        if ($this->isColumnModified(PluginsTableMap::COL__CONFIG)) {
            $criteria->add(PluginsTableMap::COL__CONFIG, $this->_config);
        }
        if ($this->isColumnModified(PluginsTableMap::COL__CALLBACK)) {
            $criteria->add(PluginsTableMap::COL__CALLBACK, $this->_callback);
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
        $criteria = ChildPluginsQuery::create();
        $criteria->add(PluginsTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Plugins (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setUser($this->getUser());
        $copyObj->setConfig($this->getConfig());
        $copyObj->setSplit($this->getSplit());
        $copyObj->setParentnode($this->getParentnode());
        $copyObj->setSort($this->getSort());
        $copyObj->setPage($this->getPage());
        $copyObj->setConfig($this->getConfig());
        $copyObj->setCallback($this->getCallback());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getRIssuesAllplugins() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRIssuesAllplugin($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRIssuesNarrationplugins() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRIssuesNarrationplugin($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRIssuesRtfplugins() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRIssuesRtfplugin($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRIssuesSingleplugins() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRIssuesSingleplugin($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRIssuesXmlplugins() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRIssuesXmlplugin($relObj->copy($deepCopy));
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
     * @return \Plugins Clone of current object.
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
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('RIssuesAllplugin' == $relationName) {
            return $this->initRIssuesAllplugins();
        }
        if ('RIssuesNarrationplugin' == $relationName) {
            return $this->initRIssuesNarrationplugins();
        }
        if ('RIssuesRtfplugin' == $relationName) {
            return $this->initRIssuesRtfplugins();
        }
        if ('RIssuesSingleplugin' == $relationName) {
            return $this->initRIssuesSingleplugins();
        }
        if ('RIssuesXmlplugin' == $relationName) {
            return $this->initRIssuesXmlplugins();
        }
    }

    /**
     * Clears out the collRIssuesAllplugins collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRIssuesAllplugins()
     */
    public function clearRIssuesAllplugins()
    {
        $this->collRIssuesAllplugins = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRIssuesAllplugins collection loaded partially.
     */
    public function resetPartialRIssuesAllplugins($v = true)
    {
        $this->collRIssuesAllpluginsPartial = $v;
    }

    /**
     * Initializes the collRIssuesAllplugins collection.
     *
     * By default this just sets the collRIssuesAllplugins collection to an empty array (like clearcollRIssuesAllplugins());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRIssuesAllplugins($overrideExisting = true)
    {
        if (null !== $this->collRIssuesAllplugins && !$overrideExisting) {
            return;
        }
        $this->collRIssuesAllplugins = new ObjectCollection();
        $this->collRIssuesAllplugins->setModel('\RIssuesAllplugin');
    }

    /**
     * Gets an array of ChildRIssuesAllplugin objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPlugins is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRIssuesAllplugin[] List of ChildRIssuesAllplugin objects
     * @throws PropelException
     */
    public function getRIssuesAllplugins(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRIssuesAllpluginsPartial && !$this->isNew();
        if (null === $this->collRIssuesAllplugins || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRIssuesAllplugins) {
                // return empty collection
                $this->initRIssuesAllplugins();
            } else {
                $collRIssuesAllplugins = ChildRIssuesAllpluginQuery::create(null, $criteria)
                    ->filterByPlugins($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRIssuesAllpluginsPartial && count($collRIssuesAllplugins)) {
                        $this->initRIssuesAllplugins(false);

                        foreach ($collRIssuesAllplugins as $obj) {
                            if (false == $this->collRIssuesAllplugins->contains($obj)) {
                                $this->collRIssuesAllplugins->append($obj);
                            }
                        }

                        $this->collRIssuesAllpluginsPartial = true;
                    }

                    return $collRIssuesAllplugins;
                }

                if ($partial && $this->collRIssuesAllplugins) {
                    foreach ($this->collRIssuesAllplugins as $obj) {
                        if ($obj->isNew()) {
                            $collRIssuesAllplugins[] = $obj;
                        }
                    }
                }

                $this->collRIssuesAllplugins = $collRIssuesAllplugins;
                $this->collRIssuesAllpluginsPartial = false;
            }
        }

        return $this->collRIssuesAllplugins;
    }

    /**
     * Sets a collection of ChildRIssuesAllplugin objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $rIssuesAllplugins A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPlugins The current object (for fluent API support)
     */
    public function setRIssuesAllplugins(Collection $rIssuesAllplugins, ConnectionInterface $con = null)
    {
        /** @var ChildRIssuesAllplugin[] $rIssuesAllpluginsToDelete */
        $rIssuesAllpluginsToDelete = $this->getRIssuesAllplugins(new Criteria(), $con)->diff($rIssuesAllplugins);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->rIssuesAllpluginsScheduledForDeletion = clone $rIssuesAllpluginsToDelete;

        foreach ($rIssuesAllpluginsToDelete as $rIssuesAllpluginRemoved) {
            $rIssuesAllpluginRemoved->setPlugins(null);
        }

        $this->collRIssuesAllplugins = null;
        foreach ($rIssuesAllplugins as $rIssuesAllplugin) {
            $this->addRIssuesAllplugin($rIssuesAllplugin);
        }

        $this->collRIssuesAllplugins = $rIssuesAllplugins;
        $this->collRIssuesAllpluginsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RIssuesAllplugin objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RIssuesAllplugin objects.
     * @throws PropelException
     */
    public function countRIssuesAllplugins(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRIssuesAllpluginsPartial && !$this->isNew();
        if (null === $this->collRIssuesAllplugins || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRIssuesAllplugins) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRIssuesAllplugins());
            }

            $query = ChildRIssuesAllpluginQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPlugins($this)
                ->count($con);
        }

        return count($this->collRIssuesAllplugins);
    }

    /**
     * Method called to associate a ChildRIssuesAllplugin object to this object
     * through the ChildRIssuesAllplugin foreign key attribute.
     *
     * @param  ChildRIssuesAllplugin $l ChildRIssuesAllplugin
     * @return $this|\Plugins The current object (for fluent API support)
     */
    public function addRIssuesAllplugin(ChildRIssuesAllplugin $l)
    {
        if ($this->collRIssuesAllplugins === null) {
            $this->initRIssuesAllplugins();
            $this->collRIssuesAllpluginsPartial = true;
        }

        if (!$this->collRIssuesAllplugins->contains($l)) {
            $this->doAddRIssuesAllplugin($l);

            if ($this->rIssuesAllpluginsScheduledForDeletion and $this->rIssuesAllpluginsScheduledForDeletion->contains($l)) {
                $this->rIssuesAllpluginsScheduledForDeletion->remove($this->rIssuesAllpluginsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildRIssuesAllplugin $rIssuesAllplugin The ChildRIssuesAllplugin object to add.
     */
    protected function doAddRIssuesAllplugin(ChildRIssuesAllplugin $rIssuesAllplugin)
    {
        $this->collRIssuesAllplugins[]= $rIssuesAllplugin;
        $rIssuesAllplugin->setPlugins($this);
    }

    /**
     * @param  ChildRIssuesAllplugin $rIssuesAllplugin The ChildRIssuesAllplugin object to remove.
     * @return $this|ChildPlugins The current object (for fluent API support)
     */
    public function removeRIssuesAllplugin(ChildRIssuesAllplugin $rIssuesAllplugin)
    {
        if ($this->getRIssuesAllplugins()->contains($rIssuesAllplugin)) {
            $pos = $this->collRIssuesAllplugins->search($rIssuesAllplugin);
            $this->collRIssuesAllplugins->remove($pos);
            if (null === $this->rIssuesAllpluginsScheduledForDeletion) {
                $this->rIssuesAllpluginsScheduledForDeletion = clone $this->collRIssuesAllplugins;
                $this->rIssuesAllpluginsScheduledForDeletion->clear();
            }
            $this->rIssuesAllpluginsScheduledForDeletion[]= clone $rIssuesAllplugin;
            $rIssuesAllplugin->setPlugins(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Plugins is new, it will return
     * an empty collection; or if this Plugins has previously
     * been saved, it will retrieve related RIssuesAllplugins from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Plugins.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRIssuesAllplugin[] List of ChildRIssuesAllplugin objects
     */
    public function getRIssuesAllpluginsJoinIssues(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRIssuesAllpluginQuery::create(null, $criteria);
        $query->joinWith('Issues', $joinBehavior);

        return $this->getRIssuesAllplugins($query, $con);
    }

    /**
     * Clears out the collRIssuesNarrationplugins collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRIssuesNarrationplugins()
     */
    public function clearRIssuesNarrationplugins()
    {
        $this->collRIssuesNarrationplugins = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRIssuesNarrationplugins collection loaded partially.
     */
    public function resetPartialRIssuesNarrationplugins($v = true)
    {
        $this->collRIssuesNarrationpluginsPartial = $v;
    }

    /**
     * Initializes the collRIssuesNarrationplugins collection.
     *
     * By default this just sets the collRIssuesNarrationplugins collection to an empty array (like clearcollRIssuesNarrationplugins());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRIssuesNarrationplugins($overrideExisting = true)
    {
        if (null !== $this->collRIssuesNarrationplugins && !$overrideExisting) {
            return;
        }
        $this->collRIssuesNarrationplugins = new ObjectCollection();
        $this->collRIssuesNarrationplugins->setModel('\RIssuesNarrationplugin');
    }

    /**
     * Gets an array of ChildRIssuesNarrationplugin objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPlugins is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRIssuesNarrationplugin[] List of ChildRIssuesNarrationplugin objects
     * @throws PropelException
     */
    public function getRIssuesNarrationplugins(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRIssuesNarrationpluginsPartial && !$this->isNew();
        if (null === $this->collRIssuesNarrationplugins || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRIssuesNarrationplugins) {
                // return empty collection
                $this->initRIssuesNarrationplugins();
            } else {
                $collRIssuesNarrationplugins = ChildRIssuesNarrationpluginQuery::create(null, $criteria)
                    ->filterByPlugins($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRIssuesNarrationpluginsPartial && count($collRIssuesNarrationplugins)) {
                        $this->initRIssuesNarrationplugins(false);

                        foreach ($collRIssuesNarrationplugins as $obj) {
                            if (false == $this->collRIssuesNarrationplugins->contains($obj)) {
                                $this->collRIssuesNarrationplugins->append($obj);
                            }
                        }

                        $this->collRIssuesNarrationpluginsPartial = true;
                    }

                    return $collRIssuesNarrationplugins;
                }

                if ($partial && $this->collRIssuesNarrationplugins) {
                    foreach ($this->collRIssuesNarrationplugins as $obj) {
                        if ($obj->isNew()) {
                            $collRIssuesNarrationplugins[] = $obj;
                        }
                    }
                }

                $this->collRIssuesNarrationplugins = $collRIssuesNarrationplugins;
                $this->collRIssuesNarrationpluginsPartial = false;
            }
        }

        return $this->collRIssuesNarrationplugins;
    }

    /**
     * Sets a collection of ChildRIssuesNarrationplugin objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $rIssuesNarrationplugins A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPlugins The current object (for fluent API support)
     */
    public function setRIssuesNarrationplugins(Collection $rIssuesNarrationplugins, ConnectionInterface $con = null)
    {
        /** @var ChildRIssuesNarrationplugin[] $rIssuesNarrationpluginsToDelete */
        $rIssuesNarrationpluginsToDelete = $this->getRIssuesNarrationplugins(new Criteria(), $con)->diff($rIssuesNarrationplugins);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->rIssuesNarrationpluginsScheduledForDeletion = clone $rIssuesNarrationpluginsToDelete;

        foreach ($rIssuesNarrationpluginsToDelete as $rIssuesNarrationpluginRemoved) {
            $rIssuesNarrationpluginRemoved->setPlugins(null);
        }

        $this->collRIssuesNarrationplugins = null;
        foreach ($rIssuesNarrationplugins as $rIssuesNarrationplugin) {
            $this->addRIssuesNarrationplugin($rIssuesNarrationplugin);
        }

        $this->collRIssuesNarrationplugins = $rIssuesNarrationplugins;
        $this->collRIssuesNarrationpluginsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RIssuesNarrationplugin objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RIssuesNarrationplugin objects.
     * @throws PropelException
     */
    public function countRIssuesNarrationplugins(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRIssuesNarrationpluginsPartial && !$this->isNew();
        if (null === $this->collRIssuesNarrationplugins || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRIssuesNarrationplugins) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRIssuesNarrationplugins());
            }

            $query = ChildRIssuesNarrationpluginQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPlugins($this)
                ->count($con);
        }

        return count($this->collRIssuesNarrationplugins);
    }

    /**
     * Method called to associate a ChildRIssuesNarrationplugin object to this object
     * through the ChildRIssuesNarrationplugin foreign key attribute.
     *
     * @param  ChildRIssuesNarrationplugin $l ChildRIssuesNarrationplugin
     * @return $this|\Plugins The current object (for fluent API support)
     */
    public function addRIssuesNarrationplugin(ChildRIssuesNarrationplugin $l)
    {
        if ($this->collRIssuesNarrationplugins === null) {
            $this->initRIssuesNarrationplugins();
            $this->collRIssuesNarrationpluginsPartial = true;
        }

        if (!$this->collRIssuesNarrationplugins->contains($l)) {
            $this->doAddRIssuesNarrationplugin($l);

            if ($this->rIssuesNarrationpluginsScheduledForDeletion and $this->rIssuesNarrationpluginsScheduledForDeletion->contains($l)) {
                $this->rIssuesNarrationpluginsScheduledForDeletion->remove($this->rIssuesNarrationpluginsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildRIssuesNarrationplugin $rIssuesNarrationplugin The ChildRIssuesNarrationplugin object to add.
     */
    protected function doAddRIssuesNarrationplugin(ChildRIssuesNarrationplugin $rIssuesNarrationplugin)
    {
        $this->collRIssuesNarrationplugins[]= $rIssuesNarrationplugin;
        $rIssuesNarrationplugin->setPlugins($this);
    }

    /**
     * @param  ChildRIssuesNarrationplugin $rIssuesNarrationplugin The ChildRIssuesNarrationplugin object to remove.
     * @return $this|ChildPlugins The current object (for fluent API support)
     */
    public function removeRIssuesNarrationplugin(ChildRIssuesNarrationplugin $rIssuesNarrationplugin)
    {
        if ($this->getRIssuesNarrationplugins()->contains($rIssuesNarrationplugin)) {
            $pos = $this->collRIssuesNarrationplugins->search($rIssuesNarrationplugin);
            $this->collRIssuesNarrationplugins->remove($pos);
            if (null === $this->rIssuesNarrationpluginsScheduledForDeletion) {
                $this->rIssuesNarrationpluginsScheduledForDeletion = clone $this->collRIssuesNarrationplugins;
                $this->rIssuesNarrationpluginsScheduledForDeletion->clear();
            }
            $this->rIssuesNarrationpluginsScheduledForDeletion[]= clone $rIssuesNarrationplugin;
            $rIssuesNarrationplugin->setPlugins(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Plugins is new, it will return
     * an empty collection; or if this Plugins has previously
     * been saved, it will retrieve related RIssuesNarrationplugins from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Plugins.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRIssuesNarrationplugin[] List of ChildRIssuesNarrationplugin objects
     */
    public function getRIssuesNarrationpluginsJoinIssues(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRIssuesNarrationpluginQuery::create(null, $criteria);
        $query->joinWith('Issues', $joinBehavior);

        return $this->getRIssuesNarrationplugins($query, $con);
    }

    /**
     * Clears out the collRIssuesRtfplugins collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRIssuesRtfplugins()
     */
    public function clearRIssuesRtfplugins()
    {
        $this->collRIssuesRtfplugins = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRIssuesRtfplugins collection loaded partially.
     */
    public function resetPartialRIssuesRtfplugins($v = true)
    {
        $this->collRIssuesRtfpluginsPartial = $v;
    }

    /**
     * Initializes the collRIssuesRtfplugins collection.
     *
     * By default this just sets the collRIssuesRtfplugins collection to an empty array (like clearcollRIssuesRtfplugins());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRIssuesRtfplugins($overrideExisting = true)
    {
        if (null !== $this->collRIssuesRtfplugins && !$overrideExisting) {
            return;
        }
        $this->collRIssuesRtfplugins = new ObjectCollection();
        $this->collRIssuesRtfplugins->setModel('\RIssuesRtfplugin');
    }

    /**
     * Gets an array of ChildRIssuesRtfplugin objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPlugins is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRIssuesRtfplugin[] List of ChildRIssuesRtfplugin objects
     * @throws PropelException
     */
    public function getRIssuesRtfplugins(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRIssuesRtfpluginsPartial && !$this->isNew();
        if (null === $this->collRIssuesRtfplugins || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRIssuesRtfplugins) {
                // return empty collection
                $this->initRIssuesRtfplugins();
            } else {
                $collRIssuesRtfplugins = ChildRIssuesRtfpluginQuery::create(null, $criteria)
                    ->filterByPlugins($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRIssuesRtfpluginsPartial && count($collRIssuesRtfplugins)) {
                        $this->initRIssuesRtfplugins(false);

                        foreach ($collRIssuesRtfplugins as $obj) {
                            if (false == $this->collRIssuesRtfplugins->contains($obj)) {
                                $this->collRIssuesRtfplugins->append($obj);
                            }
                        }

                        $this->collRIssuesRtfpluginsPartial = true;
                    }

                    return $collRIssuesRtfplugins;
                }

                if ($partial && $this->collRIssuesRtfplugins) {
                    foreach ($this->collRIssuesRtfplugins as $obj) {
                        if ($obj->isNew()) {
                            $collRIssuesRtfplugins[] = $obj;
                        }
                    }
                }

                $this->collRIssuesRtfplugins = $collRIssuesRtfplugins;
                $this->collRIssuesRtfpluginsPartial = false;
            }
        }

        return $this->collRIssuesRtfplugins;
    }

    /**
     * Sets a collection of ChildRIssuesRtfplugin objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $rIssuesRtfplugins A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPlugins The current object (for fluent API support)
     */
    public function setRIssuesRtfplugins(Collection $rIssuesRtfplugins, ConnectionInterface $con = null)
    {
        /** @var ChildRIssuesRtfplugin[] $rIssuesRtfpluginsToDelete */
        $rIssuesRtfpluginsToDelete = $this->getRIssuesRtfplugins(new Criteria(), $con)->diff($rIssuesRtfplugins);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->rIssuesRtfpluginsScheduledForDeletion = clone $rIssuesRtfpluginsToDelete;

        foreach ($rIssuesRtfpluginsToDelete as $rIssuesRtfpluginRemoved) {
            $rIssuesRtfpluginRemoved->setPlugins(null);
        }

        $this->collRIssuesRtfplugins = null;
        foreach ($rIssuesRtfplugins as $rIssuesRtfplugin) {
            $this->addRIssuesRtfplugin($rIssuesRtfplugin);
        }

        $this->collRIssuesRtfplugins = $rIssuesRtfplugins;
        $this->collRIssuesRtfpluginsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RIssuesRtfplugin objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RIssuesRtfplugin objects.
     * @throws PropelException
     */
    public function countRIssuesRtfplugins(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRIssuesRtfpluginsPartial && !$this->isNew();
        if (null === $this->collRIssuesRtfplugins || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRIssuesRtfplugins) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRIssuesRtfplugins());
            }

            $query = ChildRIssuesRtfpluginQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPlugins($this)
                ->count($con);
        }

        return count($this->collRIssuesRtfplugins);
    }

    /**
     * Method called to associate a ChildRIssuesRtfplugin object to this object
     * through the ChildRIssuesRtfplugin foreign key attribute.
     *
     * @param  ChildRIssuesRtfplugin $l ChildRIssuesRtfplugin
     * @return $this|\Plugins The current object (for fluent API support)
     */
    public function addRIssuesRtfplugin(ChildRIssuesRtfplugin $l)
    {
        if ($this->collRIssuesRtfplugins === null) {
            $this->initRIssuesRtfplugins();
            $this->collRIssuesRtfpluginsPartial = true;
        }

        if (!$this->collRIssuesRtfplugins->contains($l)) {
            $this->doAddRIssuesRtfplugin($l);

            if ($this->rIssuesRtfpluginsScheduledForDeletion and $this->rIssuesRtfpluginsScheduledForDeletion->contains($l)) {
                $this->rIssuesRtfpluginsScheduledForDeletion->remove($this->rIssuesRtfpluginsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildRIssuesRtfplugin $rIssuesRtfplugin The ChildRIssuesRtfplugin object to add.
     */
    protected function doAddRIssuesRtfplugin(ChildRIssuesRtfplugin $rIssuesRtfplugin)
    {
        $this->collRIssuesRtfplugins[]= $rIssuesRtfplugin;
        $rIssuesRtfplugin->setPlugins($this);
    }

    /**
     * @param  ChildRIssuesRtfplugin $rIssuesRtfplugin The ChildRIssuesRtfplugin object to remove.
     * @return $this|ChildPlugins The current object (for fluent API support)
     */
    public function removeRIssuesRtfplugin(ChildRIssuesRtfplugin $rIssuesRtfplugin)
    {
        if ($this->getRIssuesRtfplugins()->contains($rIssuesRtfplugin)) {
            $pos = $this->collRIssuesRtfplugins->search($rIssuesRtfplugin);
            $this->collRIssuesRtfplugins->remove($pos);
            if (null === $this->rIssuesRtfpluginsScheduledForDeletion) {
                $this->rIssuesRtfpluginsScheduledForDeletion = clone $this->collRIssuesRtfplugins;
                $this->rIssuesRtfpluginsScheduledForDeletion->clear();
            }
            $this->rIssuesRtfpluginsScheduledForDeletion[]= clone $rIssuesRtfplugin;
            $rIssuesRtfplugin->setPlugins(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Plugins is new, it will return
     * an empty collection; or if this Plugins has previously
     * been saved, it will retrieve related RIssuesRtfplugins from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Plugins.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRIssuesRtfplugin[] List of ChildRIssuesRtfplugin objects
     */
    public function getRIssuesRtfpluginsJoinIssues(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRIssuesRtfpluginQuery::create(null, $criteria);
        $query->joinWith('Issues', $joinBehavior);

        return $this->getRIssuesRtfplugins($query, $con);
    }

    /**
     * Clears out the collRIssuesSingleplugins collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRIssuesSingleplugins()
     */
    public function clearRIssuesSingleplugins()
    {
        $this->collRIssuesSingleplugins = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRIssuesSingleplugins collection loaded partially.
     */
    public function resetPartialRIssuesSingleplugins($v = true)
    {
        $this->collRIssuesSinglepluginsPartial = $v;
    }

    /**
     * Initializes the collRIssuesSingleplugins collection.
     *
     * By default this just sets the collRIssuesSingleplugins collection to an empty array (like clearcollRIssuesSingleplugins());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRIssuesSingleplugins($overrideExisting = true)
    {
        if (null !== $this->collRIssuesSingleplugins && !$overrideExisting) {
            return;
        }
        $this->collRIssuesSingleplugins = new ObjectCollection();
        $this->collRIssuesSingleplugins->setModel('\RIssuesSingleplugin');
    }

    /**
     * Gets an array of ChildRIssuesSingleplugin objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPlugins is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRIssuesSingleplugin[] List of ChildRIssuesSingleplugin objects
     * @throws PropelException
     */
    public function getRIssuesSingleplugins(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRIssuesSinglepluginsPartial && !$this->isNew();
        if (null === $this->collRIssuesSingleplugins || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRIssuesSingleplugins) {
                // return empty collection
                $this->initRIssuesSingleplugins();
            } else {
                $collRIssuesSingleplugins = ChildRIssuesSinglepluginQuery::create(null, $criteria)
                    ->filterByPlugins($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRIssuesSinglepluginsPartial && count($collRIssuesSingleplugins)) {
                        $this->initRIssuesSingleplugins(false);

                        foreach ($collRIssuesSingleplugins as $obj) {
                            if (false == $this->collRIssuesSingleplugins->contains($obj)) {
                                $this->collRIssuesSingleplugins->append($obj);
                            }
                        }

                        $this->collRIssuesSinglepluginsPartial = true;
                    }

                    return $collRIssuesSingleplugins;
                }

                if ($partial && $this->collRIssuesSingleplugins) {
                    foreach ($this->collRIssuesSingleplugins as $obj) {
                        if ($obj->isNew()) {
                            $collRIssuesSingleplugins[] = $obj;
                        }
                    }
                }

                $this->collRIssuesSingleplugins = $collRIssuesSingleplugins;
                $this->collRIssuesSinglepluginsPartial = false;
            }
        }

        return $this->collRIssuesSingleplugins;
    }

    /**
     * Sets a collection of ChildRIssuesSingleplugin objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $rIssuesSingleplugins A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPlugins The current object (for fluent API support)
     */
    public function setRIssuesSingleplugins(Collection $rIssuesSingleplugins, ConnectionInterface $con = null)
    {
        /** @var ChildRIssuesSingleplugin[] $rIssuesSinglepluginsToDelete */
        $rIssuesSinglepluginsToDelete = $this->getRIssuesSingleplugins(new Criteria(), $con)->diff($rIssuesSingleplugins);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->rIssuesSinglepluginsScheduledForDeletion = clone $rIssuesSinglepluginsToDelete;

        foreach ($rIssuesSinglepluginsToDelete as $rIssuesSinglepluginRemoved) {
            $rIssuesSinglepluginRemoved->setPlugins(null);
        }

        $this->collRIssuesSingleplugins = null;
        foreach ($rIssuesSingleplugins as $rIssuesSingleplugin) {
            $this->addRIssuesSingleplugin($rIssuesSingleplugin);
        }

        $this->collRIssuesSingleplugins = $rIssuesSingleplugins;
        $this->collRIssuesSinglepluginsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RIssuesSingleplugin objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RIssuesSingleplugin objects.
     * @throws PropelException
     */
    public function countRIssuesSingleplugins(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRIssuesSinglepluginsPartial && !$this->isNew();
        if (null === $this->collRIssuesSingleplugins || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRIssuesSingleplugins) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRIssuesSingleplugins());
            }

            $query = ChildRIssuesSinglepluginQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPlugins($this)
                ->count($con);
        }

        return count($this->collRIssuesSingleplugins);
    }

    /**
     * Method called to associate a ChildRIssuesSingleplugin object to this object
     * through the ChildRIssuesSingleplugin foreign key attribute.
     *
     * @param  ChildRIssuesSingleplugin $l ChildRIssuesSingleplugin
     * @return $this|\Plugins The current object (for fluent API support)
     */
    public function addRIssuesSingleplugin(ChildRIssuesSingleplugin $l)
    {
        if ($this->collRIssuesSingleplugins === null) {
            $this->initRIssuesSingleplugins();
            $this->collRIssuesSinglepluginsPartial = true;
        }

        if (!$this->collRIssuesSingleplugins->contains($l)) {
            $this->doAddRIssuesSingleplugin($l);

            if ($this->rIssuesSinglepluginsScheduledForDeletion and $this->rIssuesSinglepluginsScheduledForDeletion->contains($l)) {
                $this->rIssuesSinglepluginsScheduledForDeletion->remove($this->rIssuesSinglepluginsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildRIssuesSingleplugin $rIssuesSingleplugin The ChildRIssuesSingleplugin object to add.
     */
    protected function doAddRIssuesSingleplugin(ChildRIssuesSingleplugin $rIssuesSingleplugin)
    {
        $this->collRIssuesSingleplugins[]= $rIssuesSingleplugin;
        $rIssuesSingleplugin->setPlugins($this);
    }

    /**
     * @param  ChildRIssuesSingleplugin $rIssuesSingleplugin The ChildRIssuesSingleplugin object to remove.
     * @return $this|ChildPlugins The current object (for fluent API support)
     */
    public function removeRIssuesSingleplugin(ChildRIssuesSingleplugin $rIssuesSingleplugin)
    {
        if ($this->getRIssuesSingleplugins()->contains($rIssuesSingleplugin)) {
            $pos = $this->collRIssuesSingleplugins->search($rIssuesSingleplugin);
            $this->collRIssuesSingleplugins->remove($pos);
            if (null === $this->rIssuesSinglepluginsScheduledForDeletion) {
                $this->rIssuesSinglepluginsScheduledForDeletion = clone $this->collRIssuesSingleplugins;
                $this->rIssuesSinglepluginsScheduledForDeletion->clear();
            }
            $this->rIssuesSinglepluginsScheduledForDeletion[]= clone $rIssuesSingleplugin;
            $rIssuesSingleplugin->setPlugins(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Plugins is new, it will return
     * an empty collection; or if this Plugins has previously
     * been saved, it will retrieve related RIssuesSingleplugins from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Plugins.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRIssuesSingleplugin[] List of ChildRIssuesSingleplugin objects
     */
    public function getRIssuesSinglepluginsJoinIssues(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRIssuesSinglepluginQuery::create(null, $criteria);
        $query->joinWith('Issues', $joinBehavior);

        return $this->getRIssuesSingleplugins($query, $con);
    }

    /**
     * Clears out the collRIssuesXmlplugins collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRIssuesXmlplugins()
     */
    public function clearRIssuesXmlplugins()
    {
        $this->collRIssuesXmlplugins = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRIssuesXmlplugins collection loaded partially.
     */
    public function resetPartialRIssuesXmlplugins($v = true)
    {
        $this->collRIssuesXmlpluginsPartial = $v;
    }

    /**
     * Initializes the collRIssuesXmlplugins collection.
     *
     * By default this just sets the collRIssuesXmlplugins collection to an empty array (like clearcollRIssuesXmlplugins());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRIssuesXmlplugins($overrideExisting = true)
    {
        if (null !== $this->collRIssuesXmlplugins && !$overrideExisting) {
            return;
        }
        $this->collRIssuesXmlplugins = new ObjectCollection();
        $this->collRIssuesXmlplugins->setModel('\RIssuesXmlplugin');
    }

    /**
     * Gets an array of ChildRIssuesXmlplugin objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPlugins is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRIssuesXmlplugin[] List of ChildRIssuesXmlplugin objects
     * @throws PropelException
     */
    public function getRIssuesXmlplugins(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRIssuesXmlpluginsPartial && !$this->isNew();
        if (null === $this->collRIssuesXmlplugins || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRIssuesXmlplugins) {
                // return empty collection
                $this->initRIssuesXmlplugins();
            } else {
                $collRIssuesXmlplugins = ChildRIssuesXmlpluginQuery::create(null, $criteria)
                    ->filterByPlugins($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRIssuesXmlpluginsPartial && count($collRIssuesXmlplugins)) {
                        $this->initRIssuesXmlplugins(false);

                        foreach ($collRIssuesXmlplugins as $obj) {
                            if (false == $this->collRIssuesXmlplugins->contains($obj)) {
                                $this->collRIssuesXmlplugins->append($obj);
                            }
                        }

                        $this->collRIssuesXmlpluginsPartial = true;
                    }

                    return $collRIssuesXmlplugins;
                }

                if ($partial && $this->collRIssuesXmlplugins) {
                    foreach ($this->collRIssuesXmlplugins as $obj) {
                        if ($obj->isNew()) {
                            $collRIssuesXmlplugins[] = $obj;
                        }
                    }
                }

                $this->collRIssuesXmlplugins = $collRIssuesXmlplugins;
                $this->collRIssuesXmlpluginsPartial = false;
            }
        }

        return $this->collRIssuesXmlplugins;
    }

    /**
     * Sets a collection of ChildRIssuesXmlplugin objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $rIssuesXmlplugins A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPlugins The current object (for fluent API support)
     */
    public function setRIssuesXmlplugins(Collection $rIssuesXmlplugins, ConnectionInterface $con = null)
    {
        /** @var ChildRIssuesXmlplugin[] $rIssuesXmlpluginsToDelete */
        $rIssuesXmlpluginsToDelete = $this->getRIssuesXmlplugins(new Criteria(), $con)->diff($rIssuesXmlplugins);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->rIssuesXmlpluginsScheduledForDeletion = clone $rIssuesXmlpluginsToDelete;

        foreach ($rIssuesXmlpluginsToDelete as $rIssuesXmlpluginRemoved) {
            $rIssuesXmlpluginRemoved->setPlugins(null);
        }

        $this->collRIssuesXmlplugins = null;
        foreach ($rIssuesXmlplugins as $rIssuesXmlplugin) {
            $this->addRIssuesXmlplugin($rIssuesXmlplugin);
        }

        $this->collRIssuesXmlplugins = $rIssuesXmlplugins;
        $this->collRIssuesXmlpluginsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RIssuesXmlplugin objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RIssuesXmlplugin objects.
     * @throws PropelException
     */
    public function countRIssuesXmlplugins(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRIssuesXmlpluginsPartial && !$this->isNew();
        if (null === $this->collRIssuesXmlplugins || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRIssuesXmlplugins) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRIssuesXmlplugins());
            }

            $query = ChildRIssuesXmlpluginQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPlugins($this)
                ->count($con);
        }

        return count($this->collRIssuesXmlplugins);
    }

    /**
     * Method called to associate a ChildRIssuesXmlplugin object to this object
     * through the ChildRIssuesXmlplugin foreign key attribute.
     *
     * @param  ChildRIssuesXmlplugin $l ChildRIssuesXmlplugin
     * @return $this|\Plugins The current object (for fluent API support)
     */
    public function addRIssuesXmlplugin(ChildRIssuesXmlplugin $l)
    {
        if ($this->collRIssuesXmlplugins === null) {
            $this->initRIssuesXmlplugins();
            $this->collRIssuesXmlpluginsPartial = true;
        }

        if (!$this->collRIssuesXmlplugins->contains($l)) {
            $this->doAddRIssuesXmlplugin($l);

            if ($this->rIssuesXmlpluginsScheduledForDeletion and $this->rIssuesXmlpluginsScheduledForDeletion->contains($l)) {
                $this->rIssuesXmlpluginsScheduledForDeletion->remove($this->rIssuesXmlpluginsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildRIssuesXmlplugin $rIssuesXmlplugin The ChildRIssuesXmlplugin object to add.
     */
    protected function doAddRIssuesXmlplugin(ChildRIssuesXmlplugin $rIssuesXmlplugin)
    {
        $this->collRIssuesXmlplugins[]= $rIssuesXmlplugin;
        $rIssuesXmlplugin->setPlugins($this);
    }

    /**
     * @param  ChildRIssuesXmlplugin $rIssuesXmlplugin The ChildRIssuesXmlplugin object to remove.
     * @return $this|ChildPlugins The current object (for fluent API support)
     */
    public function removeRIssuesXmlplugin(ChildRIssuesXmlplugin $rIssuesXmlplugin)
    {
        if ($this->getRIssuesXmlplugins()->contains($rIssuesXmlplugin)) {
            $pos = $this->collRIssuesXmlplugins->search($rIssuesXmlplugin);
            $this->collRIssuesXmlplugins->remove($pos);
            if (null === $this->rIssuesXmlpluginsScheduledForDeletion) {
                $this->rIssuesXmlpluginsScheduledForDeletion = clone $this->collRIssuesXmlplugins;
                $this->rIssuesXmlpluginsScheduledForDeletion->clear();
            }
            $this->rIssuesXmlpluginsScheduledForDeletion[]= clone $rIssuesXmlplugin;
            $rIssuesXmlplugin->setPlugins(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Plugins is new, it will return
     * an empty collection; or if this Plugins has previously
     * been saved, it will retrieve related RIssuesXmlplugins from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Plugins.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRIssuesXmlplugin[] List of ChildRIssuesXmlplugin objects
     */
    public function getRIssuesXmlpluginsJoinIssues(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRIssuesXmlpluginQuery::create(null, $criteria);
        $query->joinWith('Issues', $joinBehavior);

        return $this->getRIssuesXmlplugins($query, $con);
    }

    /**
     * Clears out the collIssuess collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addIssuess()
     */
    public function clearIssuess()
    {
        $this->collIssuess = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collIssuess crossRef collection.
     *
     * By default this just sets the collIssuess collection to an empty collection (like clearIssuess());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initIssuess()
    {
        $this->collIssuess = new ObjectCollection();
        $this->collIssuessPartial = true;

        $this->collIssuess->setModel('\Issues');
    }

    /**
     * Checks if the collIssuess collection is loaded.
     *
     * @return bool
     */
    public function isIssuessLoaded()
    {
        return null !== $this->collIssuess;
    }

    /**
     * Gets a collection of ChildIssues objects related by a many-to-many relationship
     * to the current object by way of the R_issues_allplugin cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPlugins is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildIssues[] List of ChildIssues objects
     */
    public function getIssuess(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collIssuessPartial && !$this->isNew();
        if (null === $this->collIssuess || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collIssuess) {
                    $this->initIssuess();
                }
            } else {

                $query = ChildIssuesQuery::create(null, $criteria)
                    ->filterByPlugins($this);
                $collIssuess = $query->find($con);
                if (null !== $criteria) {
                    return $collIssuess;
                }

                if ($partial && $this->collIssuess) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collIssuess as $obj) {
                        if (!$collIssuess->contains($obj)) {
                            $collIssuess[] = $obj;
                        }
                    }
                }

                $this->collIssuess = $collIssuess;
                $this->collIssuessPartial = false;
            }
        }

        return $this->collIssuess;
    }

    /**
     * Sets a collection of Issues objects related by a many-to-many relationship
     * to the current object by way of the R_issues_allplugin cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $issuess A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildPlugins The current object (for fluent API support)
     */
    public function setIssuess(Collection $issuess, ConnectionInterface $con = null)
    {
        $this->clearIssuess();
        $currentIssuess = $this->getIssuess();

        $issuessScheduledForDeletion = $currentIssuess->diff($issuess);

        foreach ($issuessScheduledForDeletion as $toDelete) {
            $this->removeIssues($toDelete);
        }

        foreach ($issuess as $issues) {
            if (!$currentIssuess->contains($issues)) {
                $this->doAddIssues($issues);
            }
        }

        $this->collIssuessPartial = false;
        $this->collIssuess = $issuess;

        return $this;
    }

    /**
     * Gets the number of Issues objects related by a many-to-many relationship
     * to the current object by way of the R_issues_allplugin cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Issues objects
     */
    public function countIssuess(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collIssuessPartial && !$this->isNew();
        if (null === $this->collIssuess || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collIssuess) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getIssuess());
                }

                $query = ChildIssuesQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByPlugins($this)
                    ->count($con);
            }
        } else {
            return count($this->collIssuess);
        }
    }

    /**
     * Associate a ChildIssues to this object
     * through the R_issues_allplugin cross reference table.
     *
     * @param ChildIssues $issues
     * @return ChildPlugins The current object (for fluent API support)
     */
    public function addIssues(ChildIssues $issues)
    {
        if ($this->collIssuess === null) {
            $this->initIssuess();
        }

        if (!$this->getIssuess()->contains($issues)) {
            // only add it if the **same** object is not already associated
            $this->collIssuess->push($issues);
            $this->doAddIssues($issues);
        }

        return $this;
    }

    /**
     *
     * @param ChildIssues $issues
     */
    protected function doAddIssues(ChildIssues $issues)
    {
        $rIssuesAllplugin = new ChildRIssuesAllplugin();

        $rIssuesAllplugin->setIssues($issues);

        $rIssuesAllplugin->setPlugins($this);

        $this->addRIssuesAllplugin($rIssuesAllplugin);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$issues->isPluginssLoaded()) {
            $issues->initPluginss();
            $issues->getPluginss()->push($this);
        } elseif (!$issues->getPluginss()->contains($this)) {
            $issues->getPluginss()->push($this);
        }

    }

    /**
     * Remove issues of this object
     * through the R_issues_allplugin cross reference table.
     *
     * @param ChildIssues $issues
     * @return ChildPlugins The current object (for fluent API support)
     */
    public function removeIssues(ChildIssues $issues)
    {
        if ($this->getIssuess()->contains($issues)) { $rIssuesAllplugin = new ChildRIssuesAllplugin();

            $rIssuesAllplugin->setIssues($issues);
            if ($issues->isPluginssLoaded()) {
                //remove the back reference if available
                $issues->getPluginss()->removeObject($this);
            }

            $rIssuesAllplugin->setPlugins($this);
            $this->removeRIssuesAllplugin(clone $rIssuesAllplugin);
            $rIssuesAllplugin->clear();

            $this->collIssuess->remove($this->collIssuess->search($issues));

            if (null === $this->issuessScheduledForDeletion) {
                $this->issuessScheduledForDeletion = clone $this->collIssuess;
                $this->issuessScheduledForDeletion->clear();
            }

            $this->issuessScheduledForDeletion->push($issues);
        }


        return $this;
    }

    /**
     * Clears out the collIssuess collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addIssuess()
     */
    public function clearIssuess()
    {
        $this->collIssuess = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collIssuess crossRef collection.
     *
     * By default this just sets the collIssuess collection to an empty collection (like clearIssuess());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initIssuess()
    {
        $this->collIssuess = new ObjectCollection();
        $this->collIssuessPartial = true;

        $this->collIssuess->setModel('\Issues');
    }

    /**
     * Checks if the collIssuess collection is loaded.
     *
     * @return bool
     */
    public function isIssuessLoaded()
    {
        return null !== $this->collIssuess;
    }

    /**
     * Gets a collection of ChildIssues objects related by a many-to-many relationship
     * to the current object by way of the R_issues_narrationplugin cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPlugins is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildIssues[] List of ChildIssues objects
     */
    public function getIssuess(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collIssuessPartial && !$this->isNew();
        if (null === $this->collIssuess || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collIssuess) {
                    $this->initIssuess();
                }
            } else {

                $query = ChildIssuesQuery::create(null, $criteria)
                    ->filterByPlugins($this);
                $collIssuess = $query->find($con);
                if (null !== $criteria) {
                    return $collIssuess;
                }

                if ($partial && $this->collIssuess) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collIssuess as $obj) {
                        if (!$collIssuess->contains($obj)) {
                            $collIssuess[] = $obj;
                        }
                    }
                }

                $this->collIssuess = $collIssuess;
                $this->collIssuessPartial = false;
            }
        }

        return $this->collIssuess;
    }

    /**
     * Sets a collection of Issues objects related by a many-to-many relationship
     * to the current object by way of the R_issues_narrationplugin cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $issuess A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildPlugins The current object (for fluent API support)
     */
    public function setIssuess(Collection $issuess, ConnectionInterface $con = null)
    {
        $this->clearIssuess();
        $currentIssuess = $this->getIssuess();

        $issuessScheduledForDeletion = $currentIssuess->diff($issuess);

        foreach ($issuessScheduledForDeletion as $toDelete) {
            $this->removeIssues($toDelete);
        }

        foreach ($issuess as $issues) {
            if (!$currentIssuess->contains($issues)) {
                $this->doAddIssues($issues);
            }
        }

        $this->collIssuessPartial = false;
        $this->collIssuess = $issuess;

        return $this;
    }

    /**
     * Gets the number of Issues objects related by a many-to-many relationship
     * to the current object by way of the R_issues_narrationplugin cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Issues objects
     */
    public function countIssuess(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collIssuessPartial && !$this->isNew();
        if (null === $this->collIssuess || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collIssuess) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getIssuess());
                }

                $query = ChildIssuesQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByPlugins($this)
                    ->count($con);
            }
        } else {
            return count($this->collIssuess);
        }
    }

    /**
     * Associate a ChildIssues to this object
     * through the R_issues_narrationplugin cross reference table.
     *
     * @param ChildIssues $issues
     * @return ChildPlugins The current object (for fluent API support)
     */
    public function addIssues(ChildIssues $issues)
    {
        if ($this->collIssuess === null) {
            $this->initIssuess();
        }

        if (!$this->getIssuess()->contains($issues)) {
            // only add it if the **same** object is not already associated
            $this->collIssuess->push($issues);
            $this->doAddIssues($issues);
        }

        return $this;
    }

    /**
     *
     * @param ChildIssues $issues
     */
    protected function doAddIssues(ChildIssues $issues)
    {
        $rIssuesNarrationplugin = new ChildRIssuesNarrationplugin();

        $rIssuesNarrationplugin->setIssues($issues);

        $rIssuesNarrationplugin->setPlugins($this);

        $this->addRIssuesNarrationplugin($rIssuesNarrationplugin);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$issues->isPluginssLoaded()) {
            $issues->initPluginss();
            $issues->getPluginss()->push($this);
        } elseif (!$issues->getPluginss()->contains($this)) {
            $issues->getPluginss()->push($this);
        }

    }

    /**
     * Remove issues of this object
     * through the R_issues_narrationplugin cross reference table.
     *
     * @param ChildIssues $issues
     * @return ChildPlugins The current object (for fluent API support)
     */
    public function removeIssues(ChildIssues $issues)
    {
        if ($this->getIssuess()->contains($issues)) { $rIssuesNarrationplugin = new ChildRIssuesNarrationplugin();

            $rIssuesNarrationplugin->setIssues($issues);
            if ($issues->isPluginssLoaded()) {
                //remove the back reference if available
                $issues->getPluginss()->removeObject($this);
            }

            $rIssuesNarrationplugin->setPlugins($this);
            $this->removeRIssuesNarrationplugin(clone $rIssuesNarrationplugin);
            $rIssuesNarrationplugin->clear();

            $this->collIssuess->remove($this->collIssuess->search($issues));

            if (null === $this->issuessScheduledForDeletion) {
                $this->issuessScheduledForDeletion = clone $this->collIssuess;
                $this->issuessScheduledForDeletion->clear();
            }

            $this->issuessScheduledForDeletion->push($issues);
        }


        return $this;
    }

    /**
     * Clears out the collIssuess collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addIssuess()
     */
    public function clearIssuess()
    {
        $this->collIssuess = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collIssuess crossRef collection.
     *
     * By default this just sets the collIssuess collection to an empty collection (like clearIssuess());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initIssuess()
    {
        $this->collIssuess = new ObjectCollection();
        $this->collIssuessPartial = true;

        $this->collIssuess->setModel('\Issues');
    }

    /**
     * Checks if the collIssuess collection is loaded.
     *
     * @return bool
     */
    public function isIssuessLoaded()
    {
        return null !== $this->collIssuess;
    }

    /**
     * Gets a collection of ChildIssues objects related by a many-to-many relationship
     * to the current object by way of the R_issues_rtfplugin cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPlugins is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildIssues[] List of ChildIssues objects
     */
    public function getIssuess(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collIssuessPartial && !$this->isNew();
        if (null === $this->collIssuess || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collIssuess) {
                    $this->initIssuess();
                }
            } else {

                $query = ChildIssuesQuery::create(null, $criteria)
                    ->filterByPlugins($this);
                $collIssuess = $query->find($con);
                if (null !== $criteria) {
                    return $collIssuess;
                }

                if ($partial && $this->collIssuess) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collIssuess as $obj) {
                        if (!$collIssuess->contains($obj)) {
                            $collIssuess[] = $obj;
                        }
                    }
                }

                $this->collIssuess = $collIssuess;
                $this->collIssuessPartial = false;
            }
        }

        return $this->collIssuess;
    }

    /**
     * Sets a collection of Issues objects related by a many-to-many relationship
     * to the current object by way of the R_issues_rtfplugin cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $issuess A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildPlugins The current object (for fluent API support)
     */
    public function setIssuess(Collection $issuess, ConnectionInterface $con = null)
    {
        $this->clearIssuess();
        $currentIssuess = $this->getIssuess();

        $issuessScheduledForDeletion = $currentIssuess->diff($issuess);

        foreach ($issuessScheduledForDeletion as $toDelete) {
            $this->removeIssues($toDelete);
        }

        foreach ($issuess as $issues) {
            if (!$currentIssuess->contains($issues)) {
                $this->doAddIssues($issues);
            }
        }

        $this->collIssuessPartial = false;
        $this->collIssuess = $issuess;

        return $this;
    }

    /**
     * Gets the number of Issues objects related by a many-to-many relationship
     * to the current object by way of the R_issues_rtfplugin cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Issues objects
     */
    public function countIssuess(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collIssuessPartial && !$this->isNew();
        if (null === $this->collIssuess || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collIssuess) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getIssuess());
                }

                $query = ChildIssuesQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByPlugins($this)
                    ->count($con);
            }
        } else {
            return count($this->collIssuess);
        }
    }

    /**
     * Associate a ChildIssues to this object
     * through the R_issues_rtfplugin cross reference table.
     *
     * @param ChildIssues $issues
     * @return ChildPlugins The current object (for fluent API support)
     */
    public function addIssues(ChildIssues $issues)
    {
        if ($this->collIssuess === null) {
            $this->initIssuess();
        }

        if (!$this->getIssuess()->contains($issues)) {
            // only add it if the **same** object is not already associated
            $this->collIssuess->push($issues);
            $this->doAddIssues($issues);
        }

        return $this;
    }

    /**
     *
     * @param ChildIssues $issues
     */
    protected function doAddIssues(ChildIssues $issues)
    {
        $rIssuesRtfplugin = new ChildRIssuesRtfplugin();

        $rIssuesRtfplugin->setIssues($issues);

        $rIssuesRtfplugin->setPlugins($this);

        $this->addRIssuesRtfplugin($rIssuesRtfplugin);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$issues->isPluginssLoaded()) {
            $issues->initPluginss();
            $issues->getPluginss()->push($this);
        } elseif (!$issues->getPluginss()->contains($this)) {
            $issues->getPluginss()->push($this);
        }

    }

    /**
     * Remove issues of this object
     * through the R_issues_rtfplugin cross reference table.
     *
     * @param ChildIssues $issues
     * @return ChildPlugins The current object (for fluent API support)
     */
    public function removeIssues(ChildIssues $issues)
    {
        if ($this->getIssuess()->contains($issues)) { $rIssuesRtfplugin = new ChildRIssuesRtfplugin();

            $rIssuesRtfplugin->setIssues($issues);
            if ($issues->isPluginssLoaded()) {
                //remove the back reference if available
                $issues->getPluginss()->removeObject($this);
            }

            $rIssuesRtfplugin->setPlugins($this);
            $this->removeRIssuesRtfplugin(clone $rIssuesRtfplugin);
            $rIssuesRtfplugin->clear();

            $this->collIssuess->remove($this->collIssuess->search($issues));

            if (null === $this->issuessScheduledForDeletion) {
                $this->issuessScheduledForDeletion = clone $this->collIssuess;
                $this->issuessScheduledForDeletion->clear();
            }

            $this->issuessScheduledForDeletion->push($issues);
        }


        return $this;
    }

    /**
     * Clears out the collIssuess collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addIssuess()
     */
    public function clearIssuess()
    {
        $this->collIssuess = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collIssuess crossRef collection.
     *
     * By default this just sets the collIssuess collection to an empty collection (like clearIssuess());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initIssuess()
    {
        $this->collIssuess = new ObjectCollection();
        $this->collIssuessPartial = true;

        $this->collIssuess->setModel('\Issues');
    }

    /**
     * Checks if the collIssuess collection is loaded.
     *
     * @return bool
     */
    public function isIssuessLoaded()
    {
        return null !== $this->collIssuess;
    }

    /**
     * Gets a collection of ChildIssues objects related by a many-to-many relationship
     * to the current object by way of the R_issues_singleplugin cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPlugins is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildIssues[] List of ChildIssues objects
     */
    public function getIssuess(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collIssuessPartial && !$this->isNew();
        if (null === $this->collIssuess || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collIssuess) {
                    $this->initIssuess();
                }
            } else {

                $query = ChildIssuesQuery::create(null, $criteria)
                    ->filterByPlugins($this);
                $collIssuess = $query->find($con);
                if (null !== $criteria) {
                    return $collIssuess;
                }

                if ($partial && $this->collIssuess) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collIssuess as $obj) {
                        if (!$collIssuess->contains($obj)) {
                            $collIssuess[] = $obj;
                        }
                    }
                }

                $this->collIssuess = $collIssuess;
                $this->collIssuessPartial = false;
            }
        }

        return $this->collIssuess;
    }

    /**
     * Sets a collection of Issues objects related by a many-to-many relationship
     * to the current object by way of the R_issues_singleplugin cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $issuess A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildPlugins The current object (for fluent API support)
     */
    public function setIssuess(Collection $issuess, ConnectionInterface $con = null)
    {
        $this->clearIssuess();
        $currentIssuess = $this->getIssuess();

        $issuessScheduledForDeletion = $currentIssuess->diff($issuess);

        foreach ($issuessScheduledForDeletion as $toDelete) {
            $this->removeIssues($toDelete);
        }

        foreach ($issuess as $issues) {
            if (!$currentIssuess->contains($issues)) {
                $this->doAddIssues($issues);
            }
        }

        $this->collIssuessPartial = false;
        $this->collIssuess = $issuess;

        return $this;
    }

    /**
     * Gets the number of Issues objects related by a many-to-many relationship
     * to the current object by way of the R_issues_singleplugin cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Issues objects
     */
    public function countIssuess(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collIssuessPartial && !$this->isNew();
        if (null === $this->collIssuess || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collIssuess) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getIssuess());
                }

                $query = ChildIssuesQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByPlugins($this)
                    ->count($con);
            }
        } else {
            return count($this->collIssuess);
        }
    }

    /**
     * Associate a ChildIssues to this object
     * through the R_issues_singleplugin cross reference table.
     *
     * @param ChildIssues $issues
     * @return ChildPlugins The current object (for fluent API support)
     */
    public function addIssues(ChildIssues $issues)
    {
        if ($this->collIssuess === null) {
            $this->initIssuess();
        }

        if (!$this->getIssuess()->contains($issues)) {
            // only add it if the **same** object is not already associated
            $this->collIssuess->push($issues);
            $this->doAddIssues($issues);
        }

        return $this;
    }

    /**
     *
     * @param ChildIssues $issues
     */
    protected function doAddIssues(ChildIssues $issues)
    {
        $rIssuesSingleplugin = new ChildRIssuesSingleplugin();

        $rIssuesSingleplugin->setIssues($issues);

        $rIssuesSingleplugin->setPlugins($this);

        $this->addRIssuesSingleplugin($rIssuesSingleplugin);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$issues->isPluginssLoaded()) {
            $issues->initPluginss();
            $issues->getPluginss()->push($this);
        } elseif (!$issues->getPluginss()->contains($this)) {
            $issues->getPluginss()->push($this);
        }

    }

    /**
     * Remove issues of this object
     * through the R_issues_singleplugin cross reference table.
     *
     * @param ChildIssues $issues
     * @return ChildPlugins The current object (for fluent API support)
     */
    public function removeIssues(ChildIssues $issues)
    {
        if ($this->getIssuess()->contains($issues)) { $rIssuesSingleplugin = new ChildRIssuesSingleplugin();

            $rIssuesSingleplugin->setIssues($issues);
            if ($issues->isPluginssLoaded()) {
                //remove the back reference if available
                $issues->getPluginss()->removeObject($this);
            }

            $rIssuesSingleplugin->setPlugins($this);
            $this->removeRIssuesSingleplugin(clone $rIssuesSingleplugin);
            $rIssuesSingleplugin->clear();

            $this->collIssuess->remove($this->collIssuess->search($issues));

            if (null === $this->issuessScheduledForDeletion) {
                $this->issuessScheduledForDeletion = clone $this->collIssuess;
                $this->issuessScheduledForDeletion->clear();
            }

            $this->issuessScheduledForDeletion->push($issues);
        }


        return $this;
    }

    /**
     * Clears out the collIssuess collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addIssuess()
     */
    public function clearIssuess()
    {
        $this->collIssuess = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collIssuess crossRef collection.
     *
     * By default this just sets the collIssuess collection to an empty collection (like clearIssuess());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initIssuess()
    {
        $this->collIssuess = new ObjectCollection();
        $this->collIssuessPartial = true;

        $this->collIssuess->setModel('\Issues');
    }

    /**
     * Checks if the collIssuess collection is loaded.
     *
     * @return bool
     */
    public function isIssuessLoaded()
    {
        return null !== $this->collIssuess;
    }

    /**
     * Gets a collection of ChildIssues objects related by a many-to-many relationship
     * to the current object by way of the R_issues_xmlplugin cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPlugins is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildIssues[] List of ChildIssues objects
     */
    public function getIssuess(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collIssuessPartial && !$this->isNew();
        if (null === $this->collIssuess || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collIssuess) {
                    $this->initIssuess();
                }
            } else {

                $query = ChildIssuesQuery::create(null, $criteria)
                    ->filterByPlugins($this);
                $collIssuess = $query->find($con);
                if (null !== $criteria) {
                    return $collIssuess;
                }

                if ($partial && $this->collIssuess) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collIssuess as $obj) {
                        if (!$collIssuess->contains($obj)) {
                            $collIssuess[] = $obj;
                        }
                    }
                }

                $this->collIssuess = $collIssuess;
                $this->collIssuessPartial = false;
            }
        }

        return $this->collIssuess;
    }

    /**
     * Sets a collection of Issues objects related by a many-to-many relationship
     * to the current object by way of the R_issues_xmlplugin cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $issuess A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildPlugins The current object (for fluent API support)
     */
    public function setIssuess(Collection $issuess, ConnectionInterface $con = null)
    {
        $this->clearIssuess();
        $currentIssuess = $this->getIssuess();

        $issuessScheduledForDeletion = $currentIssuess->diff($issuess);

        foreach ($issuessScheduledForDeletion as $toDelete) {
            $this->removeIssues($toDelete);
        }

        foreach ($issuess as $issues) {
            if (!$currentIssuess->contains($issues)) {
                $this->doAddIssues($issues);
            }
        }

        $this->collIssuessPartial = false;
        $this->collIssuess = $issuess;

        return $this;
    }

    /**
     * Gets the number of Issues objects related by a many-to-many relationship
     * to the current object by way of the R_issues_xmlplugin cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Issues objects
     */
    public function countIssuess(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collIssuessPartial && !$this->isNew();
        if (null === $this->collIssuess || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collIssuess) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getIssuess());
                }

                $query = ChildIssuesQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByPlugins($this)
                    ->count($con);
            }
        } else {
            return count($this->collIssuess);
        }
    }

    /**
     * Associate a ChildIssues to this object
     * through the R_issues_xmlplugin cross reference table.
     *
     * @param ChildIssues $issues
     * @return ChildPlugins The current object (for fluent API support)
     */
    public function addIssues(ChildIssues $issues)
    {
        if ($this->collIssuess === null) {
            $this->initIssuess();
        }

        if (!$this->getIssuess()->contains($issues)) {
            // only add it if the **same** object is not already associated
            $this->collIssuess->push($issues);
            $this->doAddIssues($issues);
        }

        return $this;
    }

    /**
     *
     * @param ChildIssues $issues
     */
    protected function doAddIssues(ChildIssues $issues)
    {
        $rIssuesXmlplugin = new ChildRIssuesXmlplugin();

        $rIssuesXmlplugin->setIssues($issues);

        $rIssuesXmlplugin->setPlugins($this);

        $this->addRIssuesXmlplugin($rIssuesXmlplugin);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$issues->isPluginssLoaded()) {
            $issues->initPluginss();
            $issues->getPluginss()->push($this);
        } elseif (!$issues->getPluginss()->contains($this)) {
            $issues->getPluginss()->push($this);
        }

    }

    /**
     * Remove issues of this object
     * through the R_issues_xmlplugin cross reference table.
     *
     * @param ChildIssues $issues
     * @return ChildPlugins The current object (for fluent API support)
     */
    public function removeIssues(ChildIssues $issues)
    {
        if ($this->getIssuess()->contains($issues)) { $rIssuesXmlplugin = new ChildRIssuesXmlplugin();

            $rIssuesXmlplugin->setIssues($issues);
            if ($issues->isPluginssLoaded()) {
                //remove the back reference if available
                $issues->getPluginss()->removeObject($this);
            }

            $rIssuesXmlplugin->setPlugins($this);
            $this->removeRIssuesXmlplugin(clone $rIssuesXmlplugin);
            $rIssuesXmlplugin->clear();

            $this->collIssuess->remove($this->collIssuess->search($issues));

            if (null === $this->issuessScheduledForDeletion) {
                $this->issuessScheduledForDeletion = clone $this->collIssuess;
                $this->issuessScheduledForDeletion->clear();
            }

            $this->issuessScheduledForDeletion->push($issues);
        }


        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->_name = null;
        $this->__user__ = null;
        $this->__config__ = null;
        $this->__split__ = null;
        $this->__parentnode__ = null;
        $this->__sort__ = null;
        $this->_page = null;
        $this->_config = null;
        $this->_callback = null;
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
            if ($this->collRIssuesAllplugins) {
                foreach ($this->collRIssuesAllplugins as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRIssuesNarrationplugins) {
                foreach ($this->collRIssuesNarrationplugins as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRIssuesRtfplugins) {
                foreach ($this->collRIssuesRtfplugins as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRIssuesSingleplugins) {
                foreach ($this->collRIssuesSingleplugins as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRIssuesXmlplugins) {
                foreach ($this->collRIssuesXmlplugins as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collIssuess) {
                foreach ($this->collIssuess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collIssuess) {
                foreach ($this->collIssuess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collIssuess) {
                foreach ($this->collIssuess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collIssuess) {
                foreach ($this->collIssuess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collIssuess) {
                foreach ($this->collIssuess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collRIssuesAllplugins = null;
        $this->collRIssuesNarrationplugins = null;
        $this->collRIssuesRtfplugins = null;
        $this->collRIssuesSingleplugins = null;
        $this->collRIssuesXmlplugins = null;
        $this->collIssuess = null;
        $this->collIssuess = null;
        $this->collIssuess = null;
        $this->collIssuess = null;
        $this->collIssuess = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PluginsTableMap::DEFAULT_STRING_FORMAT);
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
