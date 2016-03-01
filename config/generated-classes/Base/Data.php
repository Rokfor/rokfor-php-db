<?php

namespace Base;

use \Contributions as ChildContributions;
use \ContributionsQuery as ChildContributionsQuery;
use \ContributionsVersionQuery as ChildContributionsVersionQuery;
use \Data as ChildData;
use \DataQuery as ChildDataQuery;
use \DataVersion as ChildDataVersion;
use \DataVersionQuery as ChildDataVersionQuery;
use \Templates as ChildTemplates;
use \TemplatesQuery as ChildTemplatesQuery;
use \Users as ChildUsers;
use \UsersQuery as ChildUsersQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\DataTableMap;
use Map\DataVersionTableMap;
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
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the '_data' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Data implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\DataTableMap';


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
     * @var        int
     */
    protected $id;

    /**
     * The value for the _forcontribution field.
     * @var        int
     */
    protected $_forcontribution;

    /**
     * The value for the _fortemplatefield field.
     * @var        int
     */
    protected $_fortemplatefield;

    /**
     * The value for the _content field.
     * @var        string
     */
    protected $_content;

    /**
     * The value for the _isjson field.
     * @var        boolean
     */
    protected $_isjson;

    /**
     * The value for the __user__ field.
     * @var        int
     */
    protected $__user__;

    /**
     * The value for the __config__ field.
     * @var        string
     */
    protected $__config__;

    /**
     * The value for the __split__ field.
     * @var        string
     */
    protected $__split__;

    /**
     * The value for the __parentnode__ field.
     * @var        int
     */
    protected $__parentnode__;

    /**
     * The value for the __sort__ field.
     * @var        int
     */
    protected $__sort__;

    /**
     * The value for the version field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $version;

    /**
     * The value for the version_created_at field.
     * @var        \DateTime
     */
    protected $version_created_at;

    /**
     * The value for the version_created_by field.
     * @var        string
     */
    protected $version_created_by;

    /**
     * The value for the version_comment field.
     * @var        string
     */
    protected $version_comment;

    /**
     * @var        ChildUsers
     */
    protected $auserSysRef;

    /**
     * @var        ChildContributions
     */
    protected $aContributions;

    /**
     * @var        ChildTemplates
     */
    protected $aTemplates;

    /**
     * @var        ObjectCollection|ChildDataVersion[] Collection to store aggregation of ChildDataVersion objects.
     */
    protected $collDataVersions;
    protected $collDataVersionsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    // versionable behavior


    /**
     * @var bool
     */
    protected $enforceVersion = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildDataVersion[]
     */
    protected $dataVersionsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->version = 0;
    }

    /**
     * Initializes internal state of Base\Data object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
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
     * Compares this with another <code>Data</code> instance.  If
     * <code>obj</code> is an instance of <code>Data</code>, delegates to
     * <code>equals(Data)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Data The current object, for fluid interface
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

        return array_keys(get_object_vars($this));
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
     * Get the [_forcontribution] column value.
     *
     * @return int
     */
    public function getForcontribution()
    {
        return $this->_forcontribution;
    }

    /**
     * Get the [_fortemplatefield] column value.
     *
     * @return int
     */
    public function getFortemplatefield()
    {
        return $this->_fortemplatefield;
    }

    /**
     * Get the [_content] column value.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->_content;
    }

    /**
     * Get the [_isjson] column value.
     *
     * @return boolean
     */
    public function getIsjson()
    {
        return $this->_isjson;
    }

    /**
     * Get the [_isjson] column value.
     *
     * @return boolean
     */
    public function isIsjson()
    {
        return $this->getIsjson();
    }

    /**
     * Get the [__user__] column value.
     *
     * @return int
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
     * Get the [version] column value.
     *
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Get the [optionally formatted] temporal [version_created_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getVersionCreatedAt($format = NULL)
    {
        if ($format === null) {
            return $this->version_created_at;
        } else {
            return $this->version_created_at instanceof \DateTime ? $this->version_created_at->format($format) : null;
        }
    }

    /**
     * Get the [version_created_by] column value.
     *
     * @return string
     */
    public function getVersionCreatedBy()
    {
        return $this->version_created_by;
    }

    /**
     * Get the [version_comment] column value.
     *
     * @return string
     */
    public function getVersionComment()
    {
        return $this->version_comment;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Data The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[DataTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [_forcontribution] column.
     *
     * @param int $v new value
     * @return $this|\Data The current object (for fluent API support)
     */
    public function setForcontribution($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->_forcontribution !== $v) {
            $this->_forcontribution = $v;
            $this->modifiedColumns[DataTableMap::COL__FORCONTRIBUTION] = true;
        }

        if ($this->aContributions !== null && $this->aContributions->getId() !== $v) {
            $this->aContributions = null;
        }

        return $this;
    } // setForcontribution()

    /**
     * Set the value of [_fortemplatefield] column.
     *
     * @param int $v new value
     * @return $this|\Data The current object (for fluent API support)
     */
    public function setFortemplatefield($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->_fortemplatefield !== $v) {
            $this->_fortemplatefield = $v;
            $this->modifiedColumns[DataTableMap::COL__FORTEMPLATEFIELD] = true;
        }

        if ($this->aTemplates !== null && $this->aTemplates->getId() !== $v) {
            $this->aTemplates = null;
        }

        return $this;
    } // setFortemplatefield()

    /**
     * Set the value of [_content] column.
     *
     * @param string $v new value
     * @return $this|\Data The current object (for fluent API support)
     */
    public function setContent($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->_content !== $v) {
            $this->_content = $v;
            $this->modifiedColumns[DataTableMap::COL__CONTENT] = true;
        }

        return $this;
    } // setContent()

    /**
     * Sets the value of the [_isjson] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Data The current object (for fluent API support)
     */
    public function setIsjson($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->_isjson !== $v) {
            $this->_isjson = $v;
            $this->modifiedColumns[DataTableMap::COL__ISJSON] = true;
        }

        return $this;
    } // setIsjson()

    /**
     * Set the value of [__user__] column.
     *
     * @param int $v new value
     * @return $this|\Data The current object (for fluent API support)
     */
    public function setUserSys($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->__user__ !== $v) {
            $this->__user__ = $v;
            $this->modifiedColumns[DataTableMap::COL___USER__] = true;
        }

        if ($this->auserSysRef !== null && $this->auserSysRef->getId() !== $v) {
            $this->auserSysRef = null;
        }

        return $this;
    } // setUserSys()

    /**
     * Set the value of [__config__] column.
     *
     * @param string $v new value
     * @return $this|\Data The current object (for fluent API support)
     */
    public function setConfigSys($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->__config__ !== $v) {
            $this->__config__ = $v;
            $this->modifiedColumns[DataTableMap::COL___CONFIG__] = true;
        }

        return $this;
    } // setConfigSys()

    /**
     * Set the value of [__split__] column.
     *
     * @param string $v new value
     * @return $this|\Data The current object (for fluent API support)
     */
    public function setSplit($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->__split__ !== $v) {
            $this->__split__ = $v;
            $this->modifiedColumns[DataTableMap::COL___SPLIT__] = true;
        }

        return $this;
    } // setSplit()

    /**
     * Set the value of [__parentnode__] column.
     *
     * @param int $v new value
     * @return $this|\Data The current object (for fluent API support)
     */
    public function setParentnode($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->__parentnode__ !== $v) {
            $this->__parentnode__ = $v;
            $this->modifiedColumns[DataTableMap::COL___PARENTNODE__] = true;
        }

        return $this;
    } // setParentnode()

    /**
     * Set the value of [__sort__] column.
     *
     * @param int $v new value
     * @return $this|\Data The current object (for fluent API support)
     */
    public function setSort($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->__sort__ !== $v) {
            $this->__sort__ = $v;
            $this->modifiedColumns[DataTableMap::COL___SORT__] = true;
        }

        return $this;
    } // setSort()

    /**
     * Set the value of [version] column.
     *
     * @param int $v new value
     * @return $this|\Data The current object (for fluent API support)
     */
    public function setVersion($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->version !== $v) {
            $this->version = $v;
            $this->modifiedColumns[DataTableMap::COL_VERSION] = true;
        }

        return $this;
    } // setVersion()

    /**
     * Sets the value of [version_created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\Data The current object (for fluent API support)
     */
    public function setVersionCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->version_created_at !== null || $dt !== null) {
            if ($this->version_created_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->version_created_at->format("Y-m-d H:i:s")) {
                $this->version_created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[DataTableMap::COL_VERSION_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setVersionCreatedAt()

    /**
     * Set the value of [version_created_by] column.
     *
     * @param string $v new value
     * @return $this|\Data The current object (for fluent API support)
     */
    public function setVersionCreatedBy($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->version_created_by !== $v) {
            $this->version_created_by = $v;
            $this->modifiedColumns[DataTableMap::COL_VERSION_CREATED_BY] = true;
        }

        return $this;
    } // setVersionCreatedBy()

    /**
     * Set the value of [version_comment] column.
     *
     * @param string $v new value
     * @return $this|\Data The current object (for fluent API support)
     */
    public function setVersionComment($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->version_comment !== $v) {
            $this->version_comment = $v;
            $this->modifiedColumns[DataTableMap::COL_VERSION_COMMENT] = true;
        }

        return $this;
    } // setVersionComment()

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
            if ($this->version !== 0) {
                return false;
            }

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : DataTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : DataTableMap::translateFieldName('Forcontribution', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_forcontribution = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : DataTableMap::translateFieldName('Fortemplatefield', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_fortemplatefield = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : DataTableMap::translateFieldName('Content', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_content = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : DataTableMap::translateFieldName('Isjson', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_isjson = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : DataTableMap::translateFieldName('UserSys', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__user__ = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : DataTableMap::translateFieldName('ConfigSys', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__config__ = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : DataTableMap::translateFieldName('Split', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__split__ = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : DataTableMap::translateFieldName('Parentnode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__parentnode__ = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : DataTableMap::translateFieldName('Sort', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__sort__ = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : DataTableMap::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : DataTableMap::translateFieldName('VersionCreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->version_created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : DataTableMap::translateFieldName('VersionCreatedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version_created_by = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : DataTableMap::translateFieldName('VersionComment', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version_comment = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 14; // 14 = DataTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Data'), 0, $e);
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
        if ($this->aContributions !== null && $this->_forcontribution !== $this->aContributions->getId()) {
            $this->aContributions = null;
        }
        if ($this->aTemplates !== null && $this->_fortemplatefield !== $this->aTemplates->getId()) {
            $this->aTemplates = null;
        }
        if ($this->auserSysRef !== null && $this->__user__ !== $this->auserSysRef->getId()) {
            $this->auserSysRef = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(DataTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildDataQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->auserSysRef = null;
            $this->aContributions = null;
            $this->aTemplates = null;
            $this->collDataVersions = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Data::setDeleted()
     * @see Data::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(DataTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildDataQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(DataTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            // versionable behavior
            if ($this->isVersioningNecessary()) {
                $this->setVersion($this->isNew() ? 1 : $this->getLastVersionNumber($con) + 1);
                if (!$this->isColumnModified(DataTableMap::COL_VERSION_CREATED_AT)) {
                    $this->setVersionCreatedAt(time());
                }
                $createVersion = true; // for postSave hook
            }
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
                // versionable behavior
                if (isset($createVersion)) {
                    $this->addVersion($con);
                }
                DataTableMap::addInstanceToPool($this);
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

            if ($this->auserSysRef !== null) {
                if ($this->auserSysRef->isModified() || $this->auserSysRef->isNew()) {
                    $affectedRows += $this->auserSysRef->save($con);
                }
                $this->setuserSysRef($this->auserSysRef);
            }

            if ($this->aContributions !== null) {
                if ($this->aContributions->isModified() || $this->aContributions->isNew()) {
                    $affectedRows += $this->aContributions->save($con);
                }
                $this->setContributions($this->aContributions);
            }

            if ($this->aTemplates !== null) {
                if ($this->aTemplates->isModified() || $this->aTemplates->isNew()) {
                    $affectedRows += $this->aTemplates->save($con);
                }
                $this->setTemplates($this->aTemplates);
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

            if ($this->dataVersionsScheduledForDeletion !== null) {
                if (!$this->dataVersionsScheduledForDeletion->isEmpty()) {
                    \DataVersionQuery::create()
                        ->filterByPrimaryKeys($this->dataVersionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->dataVersionsScheduledForDeletion = null;
                }
            }

            if ($this->collDataVersions !== null) {
                foreach ($this->collDataVersions as $referrerFK) {
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

        $this->modifiedColumns[DataTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . DataTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(DataTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(DataTableMap::COL__FORCONTRIBUTION)) {
            $modifiedColumns[':p' . $index++]  = '_forcontribution';
        }
        if ($this->isColumnModified(DataTableMap::COL__FORTEMPLATEFIELD)) {
            $modifiedColumns[':p' . $index++]  = '_fortemplatefield';
        }
        if ($this->isColumnModified(DataTableMap::COL__CONTENT)) {
            $modifiedColumns[':p' . $index++]  = '_content';
        }
        if ($this->isColumnModified(DataTableMap::COL__ISJSON)) {
            $modifiedColumns[':p' . $index++]  = '_isjson';
        }
        if ($this->isColumnModified(DataTableMap::COL___USER__)) {
            $modifiedColumns[':p' . $index++]  = '__user__';
        }
        if ($this->isColumnModified(DataTableMap::COL___CONFIG__)) {
            $modifiedColumns[':p' . $index++]  = '__config__';
        }
        if ($this->isColumnModified(DataTableMap::COL___SPLIT__)) {
            $modifiedColumns[':p' . $index++]  = '__split__';
        }
        if ($this->isColumnModified(DataTableMap::COL___PARENTNODE__)) {
            $modifiedColumns[':p' . $index++]  = '__parentnode__';
        }
        if ($this->isColumnModified(DataTableMap::COL___SORT__)) {
            $modifiedColumns[':p' . $index++]  = '__sort__';
        }
        if ($this->isColumnModified(DataTableMap::COL_VERSION)) {
            $modifiedColumns[':p' . $index++]  = 'version';
        }
        if ($this->isColumnModified(DataTableMap::COL_VERSION_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'version_created_at';
        }
        if ($this->isColumnModified(DataTableMap::COL_VERSION_CREATED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'version_created_by';
        }
        if ($this->isColumnModified(DataTableMap::COL_VERSION_COMMENT)) {
            $modifiedColumns[':p' . $index++]  = 'version_comment';
        }

        $sql = sprintf(
            'INSERT INTO _data (%s) VALUES (%s)',
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
                    case '_forcontribution':
                        $stmt->bindValue($identifier, $this->_forcontribution, PDO::PARAM_INT);
                        break;
                    case '_fortemplatefield':
                        $stmt->bindValue($identifier, $this->_fortemplatefield, PDO::PARAM_INT);
                        break;
                    case '_content':
                        $stmt->bindValue($identifier, $this->_content, PDO::PARAM_STR);
                        break;
                    case '_isjson':
                        $stmt->bindValue($identifier, (int) $this->_isjson, PDO::PARAM_INT);
                        break;
                    case '__user__':
                        $stmt->bindValue($identifier, $this->__user__, PDO::PARAM_INT);
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
                    case 'version':
                        $stmt->bindValue($identifier, $this->version, PDO::PARAM_INT);
                        break;
                    case 'version_created_at':
                        $stmt->bindValue($identifier, $this->version_created_at ? $this->version_created_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'version_created_by':
                        $stmt->bindValue($identifier, $this->version_created_by, PDO::PARAM_STR);
                        break;
                    case 'version_comment':
                        $stmt->bindValue($identifier, $this->version_comment, PDO::PARAM_STR);
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
        $pos = DataTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getForcontribution();
                break;
            case 2:
                return $this->getFortemplatefield();
                break;
            case 3:
                return $this->getContent();
                break;
            case 4:
                return $this->getIsjson();
                break;
            case 5:
                return $this->getUserSys();
                break;
            case 6:
                return $this->getConfigSys();
                break;
            case 7:
                return $this->getSplit();
                break;
            case 8:
                return $this->getParentnode();
                break;
            case 9:
                return $this->getSort();
                break;
            case 10:
                return $this->getVersion();
                break;
            case 11:
                return $this->getVersionCreatedAt();
                break;
            case 12:
                return $this->getVersionCreatedBy();
                break;
            case 13:
                return $this->getVersionComment();
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

        if (isset($alreadyDumpedObjects['Data'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Data'][$this->hashCode()] = true;
        $keys = DataTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getForcontribution(),
            $keys[2] => $this->getFortemplatefield(),
            $keys[3] => $this->getContent(),
            $keys[4] => $this->getIsjson(),
            $keys[5] => $this->getUserSys(),
            $keys[6] => $this->getConfigSys(),
            $keys[7] => $this->getSplit(),
            $keys[8] => $this->getParentnode(),
            $keys[9] => $this->getSort(),
            $keys[10] => $this->getVersion(),
            $keys[11] => $this->getVersionCreatedAt(),
            $keys[12] => $this->getVersionCreatedBy(),
            $keys[13] => $this->getVersionComment(),
        );

        $utc = new \DateTimeZone('utc');
        if ($result[$keys[11]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[11]];
            $result[$keys[11]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->auserSysRef) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'users';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'users';
                        break;
                    default:
                        $key = 'Users';
                }

                $result[$key] = $this->auserSysRef->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aContributions) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'contributions';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = '_contributions';
                        break;
                    default:
                        $key = 'Contributions';
                }

                $result[$key] = $this->aContributions->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aTemplates) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'templates';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = '_templates';
                        break;
                    default:
                        $key = 'Templates';
                }

                $result[$key] = $this->aTemplates->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collDataVersions) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'dataVersions';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = '_data_versions';
                        break;
                    default:
                        $key = 'DataVersions';
                }

                $result[$key] = $this->collDataVersions->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Data
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = DataTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Data
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setForcontribution($value);
                break;
            case 2:
                $this->setFortemplatefield($value);
                break;
            case 3:
                $this->setContent($value);
                break;
            case 4:
                $this->setIsjson($value);
                break;
            case 5:
                $this->setUserSys($value);
                break;
            case 6:
                $this->setConfigSys($value);
                break;
            case 7:
                $this->setSplit($value);
                break;
            case 8:
                $this->setParentnode($value);
                break;
            case 9:
                $this->setSort($value);
                break;
            case 10:
                $this->setVersion($value);
                break;
            case 11:
                $this->setVersionCreatedAt($value);
                break;
            case 12:
                $this->setVersionCreatedBy($value);
                break;
            case 13:
                $this->setVersionComment($value);
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
        $keys = DataTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setForcontribution($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setFortemplatefield($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setContent($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setIsjson($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setUserSys($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setConfigSys($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setSplit($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setParentnode($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setSort($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setVersion($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setVersionCreatedAt($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setVersionCreatedBy($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setVersionComment($arr[$keys[13]]);
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
     * @return $this|\Data The current object, for fluid interface
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
        $criteria = new Criteria(DataTableMap::DATABASE_NAME);

        if ($this->isColumnModified(DataTableMap::COL_ID)) {
            $criteria->add(DataTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(DataTableMap::COL__FORCONTRIBUTION)) {
            $criteria->add(DataTableMap::COL__FORCONTRIBUTION, $this->_forcontribution);
        }
        if ($this->isColumnModified(DataTableMap::COL__FORTEMPLATEFIELD)) {
            $criteria->add(DataTableMap::COL__FORTEMPLATEFIELD, $this->_fortemplatefield);
        }
        if ($this->isColumnModified(DataTableMap::COL__CONTENT)) {
            $criteria->add(DataTableMap::COL__CONTENT, $this->_content);
        }
        if ($this->isColumnModified(DataTableMap::COL__ISJSON)) {
            $criteria->add(DataTableMap::COL__ISJSON, $this->_isjson);
        }
        if ($this->isColumnModified(DataTableMap::COL___USER__)) {
            $criteria->add(DataTableMap::COL___USER__, $this->__user__);
        }
        if ($this->isColumnModified(DataTableMap::COL___CONFIG__)) {
            $criteria->add(DataTableMap::COL___CONFIG__, $this->__config__);
        }
        if ($this->isColumnModified(DataTableMap::COL___SPLIT__)) {
            $criteria->add(DataTableMap::COL___SPLIT__, $this->__split__);
        }
        if ($this->isColumnModified(DataTableMap::COL___PARENTNODE__)) {
            $criteria->add(DataTableMap::COL___PARENTNODE__, $this->__parentnode__);
        }
        if ($this->isColumnModified(DataTableMap::COL___SORT__)) {
            $criteria->add(DataTableMap::COL___SORT__, $this->__sort__);
        }
        if ($this->isColumnModified(DataTableMap::COL_VERSION)) {
            $criteria->add(DataTableMap::COL_VERSION, $this->version);
        }
        if ($this->isColumnModified(DataTableMap::COL_VERSION_CREATED_AT)) {
            $criteria->add(DataTableMap::COL_VERSION_CREATED_AT, $this->version_created_at);
        }
        if ($this->isColumnModified(DataTableMap::COL_VERSION_CREATED_BY)) {
            $criteria->add(DataTableMap::COL_VERSION_CREATED_BY, $this->version_created_by);
        }
        if ($this->isColumnModified(DataTableMap::COL_VERSION_COMMENT)) {
            $criteria->add(DataTableMap::COL_VERSION_COMMENT, $this->version_comment);
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
        $criteria = ChildDataQuery::create();
        $criteria->add(DataTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Data (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setForcontribution($this->getForcontribution());
        $copyObj->setFortemplatefield($this->getFortemplatefield());
        $copyObj->setContent($this->getContent());
        $copyObj->setIsjson($this->getIsjson());
        $copyObj->setUserSys($this->getUserSys());
        $copyObj->setConfigSys($this->getConfigSys());
        $copyObj->setSplit($this->getSplit());
        $copyObj->setParentnode($this->getParentnode());
        $copyObj->setSort($this->getSort());
        $copyObj->setVersion($this->getVersion());
        $copyObj->setVersionCreatedAt($this->getVersionCreatedAt());
        $copyObj->setVersionCreatedBy($this->getVersionCreatedBy());
        $copyObj->setVersionComment($this->getVersionComment());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getDataVersions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDataVersion($relObj->copy($deepCopy));
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
     * @return \Data Clone of current object.
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
     * Declares an association between this object and a ChildUsers object.
     *
     * @param  ChildUsers $v
     * @return $this|\Data The current object (for fluent API support)
     * @throws PropelException
     */
    public function setuserSysRef(ChildUsers $v = null)
    {
        if ($v === null) {
            $this->setUserSys(NULL);
        } else {
            $this->setUserSys($v->getId());
        }

        $this->auserSysRef = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildUsers object, it will not be re-added.
        if ($v !== null) {
            $v->addData($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildUsers object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildUsers The associated ChildUsers object.
     * @throws PropelException
     */
    public function getuserSysRef(ConnectionInterface $con = null)
    {
        if ($this->auserSysRef === null && ($this->__user__ !== null)) {
            $this->auserSysRef = ChildUsersQuery::create()->findPk($this->__user__, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->auserSysRef->addDatas($this);
             */
        }

        return $this->auserSysRef;
    }

    /**
     * Declares an association between this object and a ChildContributions object.
     *
     * @param  ChildContributions $v
     * @return $this|\Data The current object (for fluent API support)
     * @throws PropelException
     */
    public function setContributions(ChildContributions $v = null)
    {
        if ($v === null) {
            $this->setForcontribution(NULL);
        } else {
            $this->setForcontribution($v->getId());
        }

        $this->aContributions = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildContributions object, it will not be re-added.
        if ($v !== null) {
            $v->addData($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildContributions object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildContributions The associated ChildContributions object.
     * @throws PropelException
     */
    public function getContributions(ConnectionInterface $con = null)
    {
        if ($this->aContributions === null && ($this->_forcontribution !== null)) {
            $this->aContributions = ChildContributionsQuery::create()->findPk($this->_forcontribution, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aContributions->addDatas($this);
             */
        }

        return $this->aContributions;
    }

    /**
     * Declares an association between this object and a ChildTemplates object.
     *
     * @param  ChildTemplates $v
     * @return $this|\Data The current object (for fluent API support)
     * @throws PropelException
     */
    public function setTemplates(ChildTemplates $v = null)
    {
        if ($v === null) {
            $this->setFortemplatefield(NULL);
        } else {
            $this->setFortemplatefield($v->getId());
        }

        $this->aTemplates = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildTemplates object, it will not be re-added.
        if ($v !== null) {
            $v->addData($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildTemplates object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildTemplates The associated ChildTemplates object.
     * @throws PropelException
     */
    public function getTemplates(ConnectionInterface $con = null)
    {
        if ($this->aTemplates === null && ($this->_fortemplatefield !== null)) {
            $this->aTemplates = ChildTemplatesQuery::create()->findPk($this->_fortemplatefield, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aTemplates->addDatas($this);
             */
        }

        return $this->aTemplates;
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
        if ('DataVersion' == $relationName) {
            return $this->initDataVersions();
        }
    }

    /**
     * Clears out the collDataVersions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addDataVersions()
     */
    public function clearDataVersions()
    {
        $this->collDataVersions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collDataVersions collection loaded partially.
     */
    public function resetPartialDataVersions($v = true)
    {
        $this->collDataVersionsPartial = $v;
    }

    /**
     * Initializes the collDataVersions collection.
     *
     * By default this just sets the collDataVersions collection to an empty array (like clearcollDataVersions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initDataVersions($overrideExisting = true)
    {
        if (null !== $this->collDataVersions && !$overrideExisting) {
            return;
        }
        $this->collDataVersions = new ObjectCollection();
        $this->collDataVersions->setModel('\DataVersion');
    }

    /**
     * Gets an array of ChildDataVersion objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildData is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildDataVersion[] List of ChildDataVersion objects
     * @throws PropelException
     */
    public function getDataVersions(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collDataVersionsPartial && !$this->isNew();
        if (null === $this->collDataVersions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collDataVersions) {
                // return empty collection
                $this->initDataVersions();
            } else {
                $collDataVersions = ChildDataVersionQuery::create(null, $criteria)
                    ->filterByData($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collDataVersionsPartial && count($collDataVersions)) {
                        $this->initDataVersions(false);

                        foreach ($collDataVersions as $obj) {
                            if (false == $this->collDataVersions->contains($obj)) {
                                $this->collDataVersions->append($obj);
                            }
                        }

                        $this->collDataVersionsPartial = true;
                    }

                    return $collDataVersions;
                }

                if ($partial && $this->collDataVersions) {
                    foreach ($this->collDataVersions as $obj) {
                        if ($obj->isNew()) {
                            $collDataVersions[] = $obj;
                        }
                    }
                }

                $this->collDataVersions = $collDataVersions;
                $this->collDataVersionsPartial = false;
            }
        }

        return $this->collDataVersions;
    }

    /**
     * Sets a collection of ChildDataVersion objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $dataVersions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildData The current object (for fluent API support)
     */
    public function setDataVersions(Collection $dataVersions, ConnectionInterface $con = null)
    {
        /** @var ChildDataVersion[] $dataVersionsToDelete */
        $dataVersionsToDelete = $this->getDataVersions(new Criteria(), $con)->diff($dataVersions);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->dataVersionsScheduledForDeletion = clone $dataVersionsToDelete;

        foreach ($dataVersionsToDelete as $dataVersionRemoved) {
            $dataVersionRemoved->setData(null);
        }

        $this->collDataVersions = null;
        foreach ($dataVersions as $dataVersion) {
            $this->addDataVersion($dataVersion);
        }

        $this->collDataVersions = $dataVersions;
        $this->collDataVersionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related DataVersion objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related DataVersion objects.
     * @throws PropelException
     */
    public function countDataVersions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collDataVersionsPartial && !$this->isNew();
        if (null === $this->collDataVersions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collDataVersions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getDataVersions());
            }

            $query = ChildDataVersionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByData($this)
                ->count($con);
        }

        return count($this->collDataVersions);
    }

    /**
     * Method called to associate a ChildDataVersion object to this object
     * through the ChildDataVersion foreign key attribute.
     *
     * @param  ChildDataVersion $l ChildDataVersion
     * @return $this|\Data The current object (for fluent API support)
     */
    public function addDataVersion(ChildDataVersion $l)
    {
        if ($this->collDataVersions === null) {
            $this->initDataVersions();
            $this->collDataVersionsPartial = true;
        }

        if (!$this->collDataVersions->contains($l)) {
            $this->doAddDataVersion($l);
        }

        return $this;
    }

    /**
     * @param ChildDataVersion $dataVersion The ChildDataVersion object to add.
     */
    protected function doAddDataVersion(ChildDataVersion $dataVersion)
    {
        $this->collDataVersions[]= $dataVersion;
        $dataVersion->setData($this);
    }

    /**
     * @param  ChildDataVersion $dataVersion The ChildDataVersion object to remove.
     * @return $this|ChildData The current object (for fluent API support)
     */
    public function removeDataVersion(ChildDataVersion $dataVersion)
    {
        if ($this->getDataVersions()->contains($dataVersion)) {
            $pos = $this->collDataVersions->search($dataVersion);
            $this->collDataVersions->remove($pos);
            if (null === $this->dataVersionsScheduledForDeletion) {
                $this->dataVersionsScheduledForDeletion = clone $this->collDataVersions;
                $this->dataVersionsScheduledForDeletion->clear();
            }
            $this->dataVersionsScheduledForDeletion[]= clone $dataVersion;
            $dataVersion->setData(null);
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
        if (null !== $this->auserSysRef) {
            $this->auserSysRef->removeData($this);
        }
        if (null !== $this->aContributions) {
            $this->aContributions->removeData($this);
        }
        if (null !== $this->aTemplates) {
            $this->aTemplates->removeData($this);
        }
        $this->id = null;
        $this->_forcontribution = null;
        $this->_fortemplatefield = null;
        $this->_content = null;
        $this->_isjson = null;
        $this->__user__ = null;
        $this->__config__ = null;
        $this->__split__ = null;
        $this->__parentnode__ = null;
        $this->__sort__ = null;
        $this->version = null;
        $this->version_created_at = null;
        $this->version_created_by = null;
        $this->version_comment = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
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
            if ($this->collDataVersions) {
                foreach ($this->collDataVersions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collDataVersions = null;
        $this->auserSysRef = null;
        $this->aContributions = null;
        $this->aTemplates = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(DataTableMap::DEFAULT_STRING_FORMAT);
    }

    // versionable behavior

    /**
     * Enforce a new Version of this object upon next save.
     *
     * @return $this|\Data
     */
    public function enforceVersioning()
    {
        $this->enforceVersion = true;

        return $this;
    }

    /**
     * Checks whether the current state must be recorded as a version
     *
     * @return  boolean
     */
    public function isVersioningNecessary($con = null)
    {
        if ($this->alreadyInSave) {
            return false;
        }

        if ($this->enforceVersion) {
            return true;
        }

        if (ChildDataQuery::isVersioningEnabled() && ($this->isNew() || $this->isModified()) || $this->isDeleted()) {
            return true;
        }
        if (null !== ($object = $this->getContributions($con)) && $object->isVersioningNecessary($con)) {
            return true;
        }


        return false;
    }

    /**
     * Creates a version of the current object and saves it.
     *
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  ChildDataVersion A version object
     */
    public function addVersion($con = null)
    {
        $this->enforceVersion = false;

        $version = new ChildDataVersion();
        $version->setId($this->getId());
        $version->setForcontribution($this->getForcontribution());
        $version->setFortemplatefield($this->getFortemplatefield());
        $version->setContent($this->getContent());
        $version->setIsjson($this->getIsjson());
        $version->setUserSys($this->getUserSys());
        $version->setConfigSys($this->getConfigSys());
        $version->setSplit($this->getSplit());
        $version->setParentnode($this->getParentnode());
        $version->setSort($this->getSort());
        $version->setVersion($this->getVersion());
        $version->setVersionCreatedAt($this->getVersionCreatedAt());
        $version->setVersionCreatedBy($this->getVersionCreatedBy());
        $version->setVersionComment($this->getVersionComment());
        $version->setData($this);
        if (($related = $this->getContributions(null, $con)) && $related->getVersion()) {
            $version->setForcontributionVersion($related->getVersion());
        }
        $version->save($con);

        return $version;
    }

    /**
     * Sets the properties of the current object to the value they had at a specific version
     *
     * @param   integer $versionNumber The version number to read
     * @param   ConnectionInterface $con The connection to use
     *
     * @return  $this|ChildData The current object (for fluent API support)
     */
    public function toVersion($versionNumber, $con = null)
    {
        $version = $this->getOneVersion($versionNumber, $con);
        if (!$version) {
            throw new PropelException(sprintf('No ChildData object found with version %d', $version));
        }
        $this->populateFromVersion($version, $con);

        return $this;
    }

    /**
     * Sets the properties of the current object to the value they had at a specific version
     *
     * @param ChildDataVersion $version The version object to use
     * @param ConnectionInterface   $con the connection to use
     * @param array                 $loadedObjects objects that been loaded in a chain of populateFromVersion calls on referrer or fk objects.
     *
     * @return $this|ChildData The current object (for fluent API support)
     */
    public function populateFromVersion($version, $con = null, &$loadedObjects = array())
    {
        $loadedObjects['ChildData'][$version->getId()][$version->getVersion()] = $this;
        $this->setId($version->getId());
        $this->setForcontribution($version->getForcontribution());
        $this->setFortemplatefield($version->getFortemplatefield());
        $this->setContent($version->getContent());
        $this->setIsjson($version->getIsjson());
        $this->setUserSys($version->getUserSys());
        $this->setConfigSys($version->getConfigSys());
        $this->setSplit($version->getSplit());
        $this->setParentnode($version->getParentnode());
        $this->setSort($version->getSort());
        $this->setVersion($version->getVersion());
        $this->setVersionCreatedAt($version->getVersionCreatedAt());
        $this->setVersionCreatedBy($version->getVersionCreatedBy());
        $this->setVersionComment($version->getVersionComment());
        if ($fkValue = $version->getForcontribution()) {
            if (isset($loadedObjects['ChildContributions']) && isset($loadedObjects['ChildContributions'][$fkValue]) && isset($loadedObjects['ChildContributions'][$fkValue][$version->getForcontributionVersion()])) {
                $related = $loadedObjects['ChildContributions'][$fkValue][$version->getForcontributionVersion()];
            } else {
                $related = new ChildContributions();
                $relatedVersion = ChildContributionsVersionQuery::create()
                    ->filterById($fkValue)
                    ->filterByVersion($version->getForcontributionVersion())
                    ->findOne($con);
                $related->populateFromVersion($relatedVersion, $con, $loadedObjects);
                $related->setNew(false);
            }
            $this->setContributions($related);
        }

        return $this;
    }

    /**
     * Gets the latest persisted version number for the current object
     *
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  integer
     */
    public function getLastVersionNumber($con = null)
    {
        $v = ChildDataVersionQuery::create()
            ->filterByData($this)
            ->orderByVersion('desc')
            ->findOne($con);
        if (!$v) {
            return 0;
        }

        return $v->getVersion();
    }

    /**
     * Checks whether the current object is the latest one
     *
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  Boolean
     */
    public function isLastVersion($con = null)
    {
        return $this->getLastVersionNumber($con) == $this->getVersion();
    }

    /**
     * Retrieves a version object for this entity and a version number
     *
     * @param   integer $versionNumber The version number to read
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  ChildDataVersion A version object
     */
    public function getOneVersion($versionNumber, $con = null)
    {
        return ChildDataVersionQuery::create()
            ->filterByData($this)
            ->filterByVersion($versionNumber)
            ->findOne($con);
    }

    /**
     * Gets all the versions of this object, in incremental order
     *
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  ObjectCollection|ChildDataVersion[] A list of ChildDataVersion objects
     */
    public function getAllVersions($con = null)
    {
        $criteria = new Criteria();
        $criteria->addAscendingOrderByColumn(DataVersionTableMap::COL_VERSION);

        return $this->getDataVersions($criteria, $con);
    }

    /**
     * Compares the current object with another of its version.
     * <code>
     * print_r($book->compareVersion(1));
     * => array(
     *   '1' => array('Title' => 'Book title at version 1'),
     *   '2' => array('Title' => 'Book title at version 2')
     * );
     * </code>
     *
     * @param   integer             $versionNumber
     * @param   string              $keys Main key used for the result diff (versions|columns)
     * @param   ConnectionInterface $con the connection to use
     * @param   array               $ignoredColumns  The columns to exclude from the diff.
     *
     * @return  array A list of differences
     */
    public function compareVersion($versionNumber, $keys = 'columns', $con = null, $ignoredColumns = array())
    {
        $fromVersion = $this->toArray();
        $toVersion = $this->getOneVersion($versionNumber, $con)->toArray();

        return $this->computeDiff($fromVersion, $toVersion, $keys, $ignoredColumns);
    }

    /**
     * Compares two versions of the current object.
     * <code>
     * print_r($book->compareVersions(1, 2));
     * => array(
     *   '1' => array('Title' => 'Book title at version 1'),
     *   '2' => array('Title' => 'Book title at version 2')
     * );
     * </code>
     *
     * @param   integer             $fromVersionNumber
     * @param   integer             $toVersionNumber
     * @param   string              $keys Main key used for the result diff (versions|columns)
     * @param   ConnectionInterface $con the connection to use
     * @param   array               $ignoredColumns  The columns to exclude from the diff.
     *
     * @return  array A list of differences
     */
    public function compareVersions($fromVersionNumber, $toVersionNumber, $keys = 'columns', $con = null, $ignoredColumns = array())
    {
        $fromVersion = $this->getOneVersion($fromVersionNumber, $con)->toArray();
        $toVersion = $this->getOneVersion($toVersionNumber, $con)->toArray();

        return $this->computeDiff($fromVersion, $toVersion, $keys, $ignoredColumns);
    }

    /**
     * Computes the diff between two versions.
     * <code>
     * print_r($book->computeDiff(1, 2));
     * => array(
     *   '1' => array('Title' => 'Book title at version 1'),
     *   '2' => array('Title' => 'Book title at version 2')
     * );
     * </code>
     *
     * @param   array     $fromVersion     An array representing the original version.
     * @param   array     $toVersion       An array representing the destination version.
     * @param   string    $keys            Main key used for the result diff (versions|columns).
     * @param   array     $ignoredColumns  The columns to exclude from the diff.
     *
     * @return  array A list of differences
     */
    protected function computeDiff($fromVersion, $toVersion, $keys = 'columns', $ignoredColumns = array())
    {
        $fromVersionNumber = $fromVersion['Version'];
        $toVersionNumber = $toVersion['Version'];
        $ignoredColumns = array_merge(array(
            'Version',
            'VersionCreatedAt',
            'VersionCreatedBy',
            'VersionComment',
        ), $ignoredColumns);
        $diff = array();
        foreach ($fromVersion as $key => $value) {
            if (in_array($key, $ignoredColumns)) {
                continue;
            }
            if ($toVersion[$key] != $value) {
                switch ($keys) {
                    case 'versions':
                        $diff[$fromVersionNumber][$key] = $value;
                        $diff[$toVersionNumber][$key] = $toVersion[$key];
                        break;
                    default:
                        $diff[$key] = array(
                            $fromVersionNumber => $value,
                            $toVersionNumber => $toVersion[$key],
                        );
                        break;
                }
            }
        }

        return $diff;
    }
    /**
     * retrieve the last $number versions.
     *
     * @param Integer $number the number of record to return.
     * @return PropelCollection|\DataVersion[] List of \DataVersion objects
     */
    public function getLastVersions($number = 10, $criteria = null, $con = null)
    {
        $criteria = ChildDataVersionQuery::create(null, $criteria);
        $criteria->addDescendingOrderByColumn(DataVersionTableMap::COL_VERSION);
        $criteria->limit($number);

        return $this->getDataVersions($criteria, $con);
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
