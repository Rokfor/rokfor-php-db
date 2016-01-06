<?php

namespace Base;

use \Books as ChildBooks;
use \BooksQuery as ChildBooksQuery;
use \Contributions as ChildContributions;
use \ContributionsQuery as ChildContributionsQuery;
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
use \RRightsForissue as ChildRRightsForissue;
use \RRightsForissueQuery as ChildRRightsForissueQuery;
use \Rights as ChildRights;
use \RightsQuery as ChildRightsQuery;
use \Exception;
use \PDO;
use Map\IssuesTableMap;
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
 * Base class that represents a row from the '_issues' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Issues implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\IssuesTableMap';


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
     * The value for the _opendate field.
     *
     * @var        int
     */
    protected $_opendate;

    /**
     * The value for the _closedate field.
     *
     * @var        int
     */
    protected $_closedate;

    /**
     * The value for the _status field.
     *
     * @var        string
     */
    protected $_status;

    /**
     * The value for the _infotext field.
     *
     * @var        string
     */
    protected $_infotext;

    /**
     * The value for the _forbook field.
     *
     * @var        int
     */
    protected $_forbook;

    /**
     * The value for the _singleplugin field.
     *
     * @var        string
     */
    protected $_singleplugin;

    /**
     * The value for the _allplugin field.
     *
     * @var        string
     */
    protected $_allplugin;

    /**
     * The value for the _rtfplugin field.
     *
     * @var        string
     */
    protected $_rtfplugin;

    /**
     * The value for the _xmlplugin field.
     *
     * @var        string
     */
    protected $_xmlplugin;

    /**
     * The value for the _narrationplugin field.
     *
     * @var        string
     */
    protected $_narrationplugin;

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
     * @var        ChildBooks
     */
    protected $aBooks;

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
     * @var        ObjectCollection|ChildRRightsForissue[] Collection to store aggregation of ChildRRightsForissue objects.
     */
    protected $collRRightsForissues;
    protected $collRRightsForissuesPartial;

    /**
     * @var        ObjectCollection|ChildContributions[] Collection to store aggregation of ChildContributions objects.
     */
    protected $collContributionss;
    protected $collContributionssPartial;

    /**
     * @var        ObjectCollection|ChildPlugins[] Cross Collection to store aggregation of ChildPlugins objects.
     */
    protected $collPluginss;

    /**
     * @var bool
     */
    protected $collPluginssPartial;

    /**
     * @var        ObjectCollection|ChildPlugins[] Cross Collection to store aggregation of ChildPlugins objects.
     */
    protected $collPluginss;

    /**
     * @var bool
     */
    protected $collPluginssPartial;

    /**
     * @var        ObjectCollection|ChildPlugins[] Cross Collection to store aggregation of ChildPlugins objects.
     */
    protected $collPluginss;

    /**
     * @var bool
     */
    protected $collPluginssPartial;

    /**
     * @var        ObjectCollection|ChildPlugins[] Cross Collection to store aggregation of ChildPlugins objects.
     */
    protected $collPluginss;

    /**
     * @var bool
     */
    protected $collPluginssPartial;

    /**
     * @var        ObjectCollection|ChildPlugins[] Cross Collection to store aggregation of ChildPlugins objects.
     */
    protected $collPluginss;

    /**
     * @var bool
     */
    protected $collPluginssPartial;

    /**
     * @var        ObjectCollection|ChildRights[] Cross Collection to store aggregation of ChildRights objects.
     */
    protected $collRightss;

    /**
     * @var bool
     */
    protected $collRightssPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPlugins[]
     */
    protected $pluginssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPlugins[]
     */
    protected $pluginssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPlugins[]
     */
    protected $pluginssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPlugins[]
     */
    protected $pluginssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPlugins[]
     */
    protected $pluginssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRights[]
     */
    protected $rightssScheduledForDeletion = null;

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
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRRightsForissue[]
     */
    protected $rRightsForissuesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildContributions[]
     */
    protected $contributionssScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Issues object.
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
     * Compares this with another <code>Issues</code> instance.  If
     * <code>obj</code> is an instance of <code>Issues</code>, delegates to
     * <code>equals(Issues)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Issues The current object, for fluid interface
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
     * Get the [_opendate] column value.
     *
     * @return int
     */
    public function getOpendate()
    {
        return $this->_opendate;
    }

    /**
     * Get the [_closedate] column value.
     *
     * @return int
     */
    public function getClosedate()
    {
        return $this->_closedate;
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
     * Get the [_infotext] column value.
     *
     * @return string
     */
    public function getInfotext()
    {
        return $this->_infotext;
    }

    /**
     * Get the [_forbook] column value.
     *
     * @return int
     */
    public function getForbook()
    {
        return $this->_forbook;
    }

    /**
     * Get the [_singleplugin] column value.
     *
     * @return string
     */
    public function getSingleplugin()
    {
        return $this->_singleplugin;
    }

    /**
     * Get the [_allplugin] column value.
     *
     * @return string
     */
    public function getAllplugin()
    {
        return $this->_allplugin;
    }

    /**
     * Get the [_rtfplugin] column value.
     *
     * @return string
     */
    public function getRtfplugin()
    {
        return $this->_rtfplugin;
    }

    /**
     * Get the [_xmlplugin] column value.
     *
     * @return string
     */
    public function getXmlplugin()
    {
        return $this->_xmlplugin;
    }

    /**
     * Get the [_narrationplugin] column value.
     *
     * @return string
     */
    public function getNarrationplugin()
    {
        return $this->_narrationplugin;
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
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Issues The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[IssuesTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [_name] column.
     *
     * @param string $v new value
     * @return $this|\Issues The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->_name !== $v) {
            $this->_name = $v;
            $this->modifiedColumns[IssuesTableMap::COL__NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [_opendate] column.
     *
     * @param int $v new value
     * @return $this|\Issues The current object (for fluent API support)
     */
    public function setOpendate($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->_opendate !== $v) {
            $this->_opendate = $v;
            $this->modifiedColumns[IssuesTableMap::COL__OPENDATE] = true;
        }

        return $this;
    } // setOpendate()

    /**
     * Set the value of [_closedate] column.
     *
     * @param int $v new value
     * @return $this|\Issues The current object (for fluent API support)
     */
    public function setClosedate($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->_closedate !== $v) {
            $this->_closedate = $v;
            $this->modifiedColumns[IssuesTableMap::COL__CLOSEDATE] = true;
        }

        return $this;
    } // setClosedate()

    /**
     * Set the value of [_status] column.
     *
     * @param string $v new value
     * @return $this|\Issues The current object (for fluent API support)
     */
    public function setStatus($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->_status !== $v) {
            $this->_status = $v;
            $this->modifiedColumns[IssuesTableMap::COL__STATUS] = true;
        }

        return $this;
    } // setStatus()

    /**
     * Set the value of [_infotext] column.
     *
     * @param string $v new value
     * @return $this|\Issues The current object (for fluent API support)
     */
    public function setInfotext($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->_infotext !== $v) {
            $this->_infotext = $v;
            $this->modifiedColumns[IssuesTableMap::COL__INFOTEXT] = true;
        }

        return $this;
    } // setInfotext()

    /**
     * Set the value of [_forbook] column.
     *
     * @param int $v new value
     * @return $this|\Issues The current object (for fluent API support)
     */
    public function setForbook($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->_forbook !== $v) {
            $this->_forbook = $v;
            $this->modifiedColumns[IssuesTableMap::COL__FORBOOK] = true;
        }

        if ($this->aBooks !== null && $this->aBooks->getId() !== $v) {
            $this->aBooks = null;
        }

        return $this;
    } // setForbook()

    /**
     * Set the value of [_singleplugin] column.
     *
     * @param string $v new value
     * @return $this|\Issues The current object (for fluent API support)
     */
    public function setSingleplugin($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->_singleplugin !== $v) {
            $this->_singleplugin = $v;
            $this->modifiedColumns[IssuesTableMap::COL__SINGLEPLUGIN] = true;
        }

        return $this;
    } // setSingleplugin()

    /**
     * Set the value of [_allplugin] column.
     *
     * @param string $v new value
     * @return $this|\Issues The current object (for fluent API support)
     */
    public function setAllplugin($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->_allplugin !== $v) {
            $this->_allplugin = $v;
            $this->modifiedColumns[IssuesTableMap::COL__ALLPLUGIN] = true;
        }

        return $this;
    } // setAllplugin()

    /**
     * Set the value of [_rtfplugin] column.
     *
     * @param string $v new value
     * @return $this|\Issues The current object (for fluent API support)
     */
    public function setRtfplugin($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->_rtfplugin !== $v) {
            $this->_rtfplugin = $v;
            $this->modifiedColumns[IssuesTableMap::COL__RTFPLUGIN] = true;
        }

        return $this;
    } // setRtfplugin()

    /**
     * Set the value of [_xmlplugin] column.
     *
     * @param string $v new value
     * @return $this|\Issues The current object (for fluent API support)
     */
    public function setXmlplugin($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->_xmlplugin !== $v) {
            $this->_xmlplugin = $v;
            $this->modifiedColumns[IssuesTableMap::COL__XMLPLUGIN] = true;
        }

        return $this;
    } // setXmlplugin()

    /**
     * Set the value of [_narrationplugin] column.
     *
     * @param string $v new value
     * @return $this|\Issues The current object (for fluent API support)
     */
    public function setNarrationplugin($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->_narrationplugin !== $v) {
            $this->_narrationplugin = $v;
            $this->modifiedColumns[IssuesTableMap::COL__NARRATIONPLUGIN] = true;
        }

        return $this;
    } // setNarrationplugin()

    /**
     * Set the value of [__user__] column.
     *
     * @param string $v new value
     * @return $this|\Issues The current object (for fluent API support)
     */
    public function setUser($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->__user__ !== $v) {
            $this->__user__ = $v;
            $this->modifiedColumns[IssuesTableMap::COL___USER__] = true;
        }

        return $this;
    } // setUser()

    /**
     * Set the value of [__config__] column.
     *
     * @param string $v new value
     * @return $this|\Issues The current object (for fluent API support)
     */
    public function setConfig($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->__config__ !== $v) {
            $this->__config__ = $v;
            $this->modifiedColumns[IssuesTableMap::COL___CONFIG__] = true;
        }

        return $this;
    } // setConfig()

    /**
     * Set the value of [__split__] column.
     *
     * @param string $v new value
     * @return $this|\Issues The current object (for fluent API support)
     */
    public function setSplit($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->__split__ !== $v) {
            $this->__split__ = $v;
            $this->modifiedColumns[IssuesTableMap::COL___SPLIT__] = true;
        }

        return $this;
    } // setSplit()

    /**
     * Set the value of [__parentnode__] column.
     *
     * @param int $v new value
     * @return $this|\Issues The current object (for fluent API support)
     */
    public function setParentnode($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->__parentnode__ !== $v) {
            $this->__parentnode__ = $v;
            $this->modifiedColumns[IssuesTableMap::COL___PARENTNODE__] = true;
        }

        return $this;
    } // setParentnode()

    /**
     * Set the value of [__sort__] column.
     *
     * @param int $v new value
     * @return $this|\Issues The current object (for fluent API support)
     */
    public function setSort($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->__sort__ !== $v) {
            $this->__sort__ = $v;
            $this->modifiedColumns[IssuesTableMap::COL___SORT__] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : IssuesTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : IssuesTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : IssuesTableMap::translateFieldName('Opendate', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_opendate = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : IssuesTableMap::translateFieldName('Closedate', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_closedate = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : IssuesTableMap::translateFieldName('Status', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_status = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : IssuesTableMap::translateFieldName('Infotext', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_infotext = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : IssuesTableMap::translateFieldName('Forbook', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_forbook = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : IssuesTableMap::translateFieldName('Singleplugin', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_singleplugin = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : IssuesTableMap::translateFieldName('Allplugin', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_allplugin = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : IssuesTableMap::translateFieldName('Rtfplugin', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_rtfplugin = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : IssuesTableMap::translateFieldName('Xmlplugin', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_xmlplugin = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : IssuesTableMap::translateFieldName('Narrationplugin', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_narrationplugin = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : IssuesTableMap::translateFieldName('User', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__user__ = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : IssuesTableMap::translateFieldName('Config', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__config__ = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : IssuesTableMap::translateFieldName('Split', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__split__ = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : IssuesTableMap::translateFieldName('Parentnode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__parentnode__ = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : IssuesTableMap::translateFieldName('Sort', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__sort__ = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 17; // 17 = IssuesTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Issues'), 0, $e);
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
        if ($this->aBooks !== null && $this->_forbook !== $this->aBooks->getId()) {
            $this->aBooks = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(IssuesTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildIssuesQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aBooks = null;
            $this->collRIssuesAllplugins = null;

            $this->collRIssuesNarrationplugins = null;

            $this->collRIssuesRtfplugins = null;

            $this->collRIssuesSingleplugins = null;

            $this->collRIssuesXmlplugins = null;

            $this->collRRightsForissues = null;

            $this->collContributionss = null;

            $this->collPluginss = null;
            $this->collPluginss = null;
            $this->collPluginss = null;
            $this->collPluginss = null;
            $this->collPluginss = null;
            $this->collRightss = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Issues::setDeleted()
     * @see Issues::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(IssuesTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildIssuesQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(IssuesTableMap::DATABASE_NAME);
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
                IssuesTableMap::addInstanceToPool($this);
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

            if ($this->aBooks !== null) {
                if ($this->aBooks->isModified() || $this->aBooks->isNew()) {
                    $affectedRows += $this->aBooks->save($con);
                }
                $this->setBooks($this->aBooks);
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

            if ($this->pluginssScheduledForDeletion !== null) {
                if (!$this->pluginssScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->pluginssScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getId();
                        $entryPk[1] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \RIssuesAllpluginQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->pluginssScheduledForDeletion = null;
                }

            }

            if ($this->collPluginss) {
                foreach ($this->collPluginss as $plugins) {
                    if (!$plugins->isDeleted() && ($plugins->isNew() || $plugins->isModified())) {
                        $plugins->save($con);
                    }
                }
            }


            if ($this->pluginssScheduledForDeletion !== null) {
                if (!$this->pluginssScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->pluginssScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getId();
                        $entryPk[1] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \RIssuesNarrationpluginQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->pluginssScheduledForDeletion = null;
                }

            }

            if ($this->collPluginss) {
                foreach ($this->collPluginss as $plugins) {
                    if (!$plugins->isDeleted() && ($plugins->isNew() || $plugins->isModified())) {
                        $plugins->save($con);
                    }
                }
            }


            if ($this->pluginssScheduledForDeletion !== null) {
                if (!$this->pluginssScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->pluginssScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getId();
                        $entryPk[1] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \RIssuesRtfpluginQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->pluginssScheduledForDeletion = null;
                }

            }

            if ($this->collPluginss) {
                foreach ($this->collPluginss as $plugins) {
                    if (!$plugins->isDeleted() && ($plugins->isNew() || $plugins->isModified())) {
                        $plugins->save($con);
                    }
                }
            }


            if ($this->pluginssScheduledForDeletion !== null) {
                if (!$this->pluginssScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->pluginssScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getId();
                        $entryPk[1] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \RIssuesSinglepluginQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->pluginssScheduledForDeletion = null;
                }

            }

            if ($this->collPluginss) {
                foreach ($this->collPluginss as $plugins) {
                    if (!$plugins->isDeleted() && ($plugins->isNew() || $plugins->isModified())) {
                        $plugins->save($con);
                    }
                }
            }


            if ($this->pluginssScheduledForDeletion !== null) {
                if (!$this->pluginssScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->pluginssScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getId();
                        $entryPk[1] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \RIssuesXmlpluginQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->pluginssScheduledForDeletion = null;
                }

            }

            if ($this->collPluginss) {
                foreach ($this->collPluginss as $plugins) {
                    if (!$plugins->isDeleted() && ($plugins->isNew() || $plugins->isModified())) {
                        $plugins->save($con);
                    }
                }
            }


            if ($this->rightssScheduledForDeletion !== null) {
                if (!$this->rightssScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->rightssScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[0] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \RRightsForissueQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->rightssScheduledForDeletion = null;
                }

            }

            if ($this->collRightss) {
                foreach ($this->collRightss as $rights) {
                    if (!$rights->isDeleted() && ($rights->isNew() || $rights->isModified())) {
                        $rights->save($con);
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

            if ($this->rRightsForissuesScheduledForDeletion !== null) {
                if (!$this->rRightsForissuesScheduledForDeletion->isEmpty()) {
                    \RRightsForissueQuery::create()
                        ->filterByPrimaryKeys($this->rRightsForissuesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->rRightsForissuesScheduledForDeletion = null;
                }
            }

            if ($this->collRRightsForissues !== null) {
                foreach ($this->collRRightsForissues as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->contributionssScheduledForDeletion !== null) {
                if (!$this->contributionssScheduledForDeletion->isEmpty()) {
                    \ContributionsQuery::create()
                        ->filterByPrimaryKeys($this->contributionssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->contributionssScheduledForDeletion = null;
                }
            }

            if ($this->collContributionss !== null) {
                foreach ($this->collContributionss as $referrerFK) {
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

        $this->modifiedColumns[IssuesTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . IssuesTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(IssuesTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(IssuesTableMap::COL__NAME)) {
            $modifiedColumns[':p' . $index++]  = '_name';
        }
        if ($this->isColumnModified(IssuesTableMap::COL__OPENDATE)) {
            $modifiedColumns[':p' . $index++]  = '_opendate';
        }
        if ($this->isColumnModified(IssuesTableMap::COL__CLOSEDATE)) {
            $modifiedColumns[':p' . $index++]  = '_closedate';
        }
        if ($this->isColumnModified(IssuesTableMap::COL__STATUS)) {
            $modifiedColumns[':p' . $index++]  = '_status';
        }
        if ($this->isColumnModified(IssuesTableMap::COL__INFOTEXT)) {
            $modifiedColumns[':p' . $index++]  = '_infotext';
        }
        if ($this->isColumnModified(IssuesTableMap::COL__FORBOOK)) {
            $modifiedColumns[':p' . $index++]  = '_forbook';
        }
        if ($this->isColumnModified(IssuesTableMap::COL__SINGLEPLUGIN)) {
            $modifiedColumns[':p' . $index++]  = '_singleplugin';
        }
        if ($this->isColumnModified(IssuesTableMap::COL__ALLPLUGIN)) {
            $modifiedColumns[':p' . $index++]  = '_allplugin';
        }
        if ($this->isColumnModified(IssuesTableMap::COL__RTFPLUGIN)) {
            $modifiedColumns[':p' . $index++]  = '_rtfplugin';
        }
        if ($this->isColumnModified(IssuesTableMap::COL__XMLPLUGIN)) {
            $modifiedColumns[':p' . $index++]  = '_xmlplugin';
        }
        if ($this->isColumnModified(IssuesTableMap::COL__NARRATIONPLUGIN)) {
            $modifiedColumns[':p' . $index++]  = '_narrationplugin';
        }
        if ($this->isColumnModified(IssuesTableMap::COL___USER__)) {
            $modifiedColumns[':p' . $index++]  = '__user__';
        }
        if ($this->isColumnModified(IssuesTableMap::COL___CONFIG__)) {
            $modifiedColumns[':p' . $index++]  = '__config__';
        }
        if ($this->isColumnModified(IssuesTableMap::COL___SPLIT__)) {
            $modifiedColumns[':p' . $index++]  = '__split__';
        }
        if ($this->isColumnModified(IssuesTableMap::COL___PARENTNODE__)) {
            $modifiedColumns[':p' . $index++]  = '__parentnode__';
        }
        if ($this->isColumnModified(IssuesTableMap::COL___SORT__)) {
            $modifiedColumns[':p' . $index++]  = '__sort__';
        }

        $sql = sprintf(
            'INSERT INTO _issues (%s) VALUES (%s)',
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
                    case '_opendate':
                        $stmt->bindValue($identifier, $this->_opendate, PDO::PARAM_INT);
                        break;
                    case '_closedate':
                        $stmt->bindValue($identifier, $this->_closedate, PDO::PARAM_INT);
                        break;
                    case '_status':
                        $stmt->bindValue($identifier, $this->_status, PDO::PARAM_STR);
                        break;
                    case '_infotext':
                        $stmt->bindValue($identifier, $this->_infotext, PDO::PARAM_STR);
                        break;
                    case '_forbook':
                        $stmt->bindValue($identifier, $this->_forbook, PDO::PARAM_INT);
                        break;
                    case '_singleplugin':
                        $stmt->bindValue($identifier, $this->_singleplugin, PDO::PARAM_STR);
                        break;
                    case '_allplugin':
                        $stmt->bindValue($identifier, $this->_allplugin, PDO::PARAM_STR);
                        break;
                    case '_rtfplugin':
                        $stmt->bindValue($identifier, $this->_rtfplugin, PDO::PARAM_STR);
                        break;
                    case '_xmlplugin':
                        $stmt->bindValue($identifier, $this->_xmlplugin, PDO::PARAM_STR);
                        break;
                    case '_narrationplugin':
                        $stmt->bindValue($identifier, $this->_narrationplugin, PDO::PARAM_STR);
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
        $pos = IssuesTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getOpendate();
                break;
            case 3:
                return $this->getClosedate();
                break;
            case 4:
                return $this->getStatus();
                break;
            case 5:
                return $this->getInfotext();
                break;
            case 6:
                return $this->getForbook();
                break;
            case 7:
                return $this->getSingleplugin();
                break;
            case 8:
                return $this->getAllplugin();
                break;
            case 9:
                return $this->getRtfplugin();
                break;
            case 10:
                return $this->getXmlplugin();
                break;
            case 11:
                return $this->getNarrationplugin();
                break;
            case 12:
                return $this->getUser();
                break;
            case 13:
                return $this->getConfig();
                break;
            case 14:
                return $this->getSplit();
                break;
            case 15:
                return $this->getParentnode();
                break;
            case 16:
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

        if (isset($alreadyDumpedObjects['Issues'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Issues'][$this->hashCode()] = true;
        $keys = IssuesTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getOpendate(),
            $keys[3] => $this->getClosedate(),
            $keys[4] => $this->getStatus(),
            $keys[5] => $this->getInfotext(),
            $keys[6] => $this->getForbook(),
            $keys[7] => $this->getSingleplugin(),
            $keys[8] => $this->getAllplugin(),
            $keys[9] => $this->getRtfplugin(),
            $keys[10] => $this->getXmlplugin(),
            $keys[11] => $this->getNarrationplugin(),
            $keys[12] => $this->getUser(),
            $keys[13] => $this->getConfig(),
            $keys[14] => $this->getSplit(),
            $keys[15] => $this->getParentnode(),
            $keys[16] => $this->getSort(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aBooks) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'books';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = '_books';
                        break;
                    default:
                        $key = 'Books';
                }

                $result[$key] = $this->aBooks->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
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
            if (null !== $this->collRRightsForissues) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'rRightsForissues';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'R_rights_forissues';
                        break;
                    default:
                        $key = 'RRightsForissues';
                }

                $result[$key] = $this->collRRightsForissues->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collContributionss) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'contributionss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = '_contributionss';
                        break;
                    default:
                        $key = 'Contributionss';
                }

                $result[$key] = $this->collContributionss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Issues
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = IssuesTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Issues
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
                $this->setOpendate($value);
                break;
            case 3:
                $this->setClosedate($value);
                break;
            case 4:
                $this->setStatus($value);
                break;
            case 5:
                $this->setInfotext($value);
                break;
            case 6:
                $this->setForbook($value);
                break;
            case 7:
                $this->setSingleplugin($value);
                break;
            case 8:
                $this->setAllplugin($value);
                break;
            case 9:
                $this->setRtfplugin($value);
                break;
            case 10:
                $this->setXmlplugin($value);
                break;
            case 11:
                $this->setNarrationplugin($value);
                break;
            case 12:
                $this->setUser($value);
                break;
            case 13:
                $this->setConfig($value);
                break;
            case 14:
                $this->setSplit($value);
                break;
            case 15:
                $this->setParentnode($value);
                break;
            case 16:
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
        $keys = IssuesTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setOpendate($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setClosedate($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setStatus($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setInfotext($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setForbook($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setSingleplugin($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setAllplugin($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setRtfplugin($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setXmlplugin($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setNarrationplugin($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setUser($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setConfig($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setSplit($arr[$keys[14]]);
        }
        if (array_key_exists($keys[15], $arr)) {
            $this->setParentnode($arr[$keys[15]]);
        }
        if (array_key_exists($keys[16], $arr)) {
            $this->setSort($arr[$keys[16]]);
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
     * @return $this|\Issues The current object, for fluid interface
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
        $criteria = new Criteria(IssuesTableMap::DATABASE_NAME);

        if ($this->isColumnModified(IssuesTableMap::COL_ID)) {
            $criteria->add(IssuesTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(IssuesTableMap::COL__NAME)) {
            $criteria->add(IssuesTableMap::COL__NAME, $this->_name);
        }
        if ($this->isColumnModified(IssuesTableMap::COL__OPENDATE)) {
            $criteria->add(IssuesTableMap::COL__OPENDATE, $this->_opendate);
        }
        if ($this->isColumnModified(IssuesTableMap::COL__CLOSEDATE)) {
            $criteria->add(IssuesTableMap::COL__CLOSEDATE, $this->_closedate);
        }
        if ($this->isColumnModified(IssuesTableMap::COL__STATUS)) {
            $criteria->add(IssuesTableMap::COL__STATUS, $this->_status);
        }
        if ($this->isColumnModified(IssuesTableMap::COL__INFOTEXT)) {
            $criteria->add(IssuesTableMap::COL__INFOTEXT, $this->_infotext);
        }
        if ($this->isColumnModified(IssuesTableMap::COL__FORBOOK)) {
            $criteria->add(IssuesTableMap::COL__FORBOOK, $this->_forbook);
        }
        if ($this->isColumnModified(IssuesTableMap::COL__SINGLEPLUGIN)) {
            $criteria->add(IssuesTableMap::COL__SINGLEPLUGIN, $this->_singleplugin);
        }
        if ($this->isColumnModified(IssuesTableMap::COL__ALLPLUGIN)) {
            $criteria->add(IssuesTableMap::COL__ALLPLUGIN, $this->_allplugin);
        }
        if ($this->isColumnModified(IssuesTableMap::COL__RTFPLUGIN)) {
            $criteria->add(IssuesTableMap::COL__RTFPLUGIN, $this->_rtfplugin);
        }
        if ($this->isColumnModified(IssuesTableMap::COL__XMLPLUGIN)) {
            $criteria->add(IssuesTableMap::COL__XMLPLUGIN, $this->_xmlplugin);
        }
        if ($this->isColumnModified(IssuesTableMap::COL__NARRATIONPLUGIN)) {
            $criteria->add(IssuesTableMap::COL__NARRATIONPLUGIN, $this->_narrationplugin);
        }
        if ($this->isColumnModified(IssuesTableMap::COL___USER__)) {
            $criteria->add(IssuesTableMap::COL___USER__, $this->__user__);
        }
        if ($this->isColumnModified(IssuesTableMap::COL___CONFIG__)) {
            $criteria->add(IssuesTableMap::COL___CONFIG__, $this->__config__);
        }
        if ($this->isColumnModified(IssuesTableMap::COL___SPLIT__)) {
            $criteria->add(IssuesTableMap::COL___SPLIT__, $this->__split__);
        }
        if ($this->isColumnModified(IssuesTableMap::COL___PARENTNODE__)) {
            $criteria->add(IssuesTableMap::COL___PARENTNODE__, $this->__parentnode__);
        }
        if ($this->isColumnModified(IssuesTableMap::COL___SORT__)) {
            $criteria->add(IssuesTableMap::COL___SORT__, $this->__sort__);
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
        $criteria = ChildIssuesQuery::create();
        $criteria->add(IssuesTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Issues (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setOpendate($this->getOpendate());
        $copyObj->setClosedate($this->getClosedate());
        $copyObj->setStatus($this->getStatus());
        $copyObj->setInfotext($this->getInfotext());
        $copyObj->setForbook($this->getForbook());
        $copyObj->setSingleplugin($this->getSingleplugin());
        $copyObj->setAllplugin($this->getAllplugin());
        $copyObj->setRtfplugin($this->getRtfplugin());
        $copyObj->setXmlplugin($this->getXmlplugin());
        $copyObj->setNarrationplugin($this->getNarrationplugin());
        $copyObj->setUser($this->getUser());
        $copyObj->setConfig($this->getConfig());
        $copyObj->setSplit($this->getSplit());
        $copyObj->setParentnode($this->getParentnode());
        $copyObj->setSort($this->getSort());

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

            foreach ($this->getRRightsForissues() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRRightsForissue($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getContributionss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addContributions($relObj->copy($deepCopy));
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
     * @return \Issues Clone of current object.
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
     * Declares an association between this object and a ChildBooks object.
     *
     * @param  ChildBooks $v
     * @return $this|\Issues The current object (for fluent API support)
     * @throws PropelException
     */
    public function setBooks(ChildBooks $v = null)
    {
        if ($v === null) {
            $this->setForbook(NULL);
        } else {
            $this->setForbook($v->getId());
        }

        $this->aBooks = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildBooks object, it will not be re-added.
        if ($v !== null) {
            $v->addIssues($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildBooks object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildBooks The associated ChildBooks object.
     * @throws PropelException
     */
    public function getBooks(ConnectionInterface $con = null)
    {
        if ($this->aBooks === null && ($this->_forbook !== null)) {
            $this->aBooks = ChildBooksQuery::create()->findPk($this->_forbook, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aBooks->addIssuess($this);
             */
        }

        return $this->aBooks;
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
        if ('RRightsForissue' == $relationName) {
            return $this->initRRightsForissues();
        }
        if ('Contributions' == $relationName) {
            return $this->initContributionss();
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
     * If this ChildIssues is new, it will return
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
                    ->filterByIssues($this)
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
     * @return $this|ChildIssues The current object (for fluent API support)
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
            $rIssuesAllpluginRemoved->setIssues(null);
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
                ->filterByIssues($this)
                ->count($con);
        }

        return count($this->collRIssuesAllplugins);
    }

    /**
     * Method called to associate a ChildRIssuesAllplugin object to this object
     * through the ChildRIssuesAllplugin foreign key attribute.
     *
     * @param  ChildRIssuesAllplugin $l ChildRIssuesAllplugin
     * @return $this|\Issues The current object (for fluent API support)
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
        $rIssuesAllplugin->setIssues($this);
    }

    /**
     * @param  ChildRIssuesAllplugin $rIssuesAllplugin The ChildRIssuesAllplugin object to remove.
     * @return $this|ChildIssues The current object (for fluent API support)
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
            $rIssuesAllplugin->setIssues(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Issues is new, it will return
     * an empty collection; or if this Issues has previously
     * been saved, it will retrieve related RIssuesAllplugins from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Issues.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRIssuesAllplugin[] List of ChildRIssuesAllplugin objects
     */
    public function getRIssuesAllpluginsJoinPlugins(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRIssuesAllpluginQuery::create(null, $criteria);
        $query->joinWith('Plugins', $joinBehavior);

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
     * If this ChildIssues is new, it will return
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
                    ->filterByIssues($this)
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
     * @return $this|ChildIssues The current object (for fluent API support)
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
            $rIssuesNarrationpluginRemoved->setIssues(null);
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
                ->filterByIssues($this)
                ->count($con);
        }

        return count($this->collRIssuesNarrationplugins);
    }

    /**
     * Method called to associate a ChildRIssuesNarrationplugin object to this object
     * through the ChildRIssuesNarrationplugin foreign key attribute.
     *
     * @param  ChildRIssuesNarrationplugin $l ChildRIssuesNarrationplugin
     * @return $this|\Issues The current object (for fluent API support)
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
        $rIssuesNarrationplugin->setIssues($this);
    }

    /**
     * @param  ChildRIssuesNarrationplugin $rIssuesNarrationplugin The ChildRIssuesNarrationplugin object to remove.
     * @return $this|ChildIssues The current object (for fluent API support)
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
            $rIssuesNarrationplugin->setIssues(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Issues is new, it will return
     * an empty collection; or if this Issues has previously
     * been saved, it will retrieve related RIssuesNarrationplugins from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Issues.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRIssuesNarrationplugin[] List of ChildRIssuesNarrationplugin objects
     */
    public function getRIssuesNarrationpluginsJoinPlugins(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRIssuesNarrationpluginQuery::create(null, $criteria);
        $query->joinWith('Plugins', $joinBehavior);

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
     * If this ChildIssues is new, it will return
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
                    ->filterByIssues($this)
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
     * @return $this|ChildIssues The current object (for fluent API support)
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
            $rIssuesRtfpluginRemoved->setIssues(null);
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
                ->filterByIssues($this)
                ->count($con);
        }

        return count($this->collRIssuesRtfplugins);
    }

    /**
     * Method called to associate a ChildRIssuesRtfplugin object to this object
     * through the ChildRIssuesRtfplugin foreign key attribute.
     *
     * @param  ChildRIssuesRtfplugin $l ChildRIssuesRtfplugin
     * @return $this|\Issues The current object (for fluent API support)
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
        $rIssuesRtfplugin->setIssues($this);
    }

    /**
     * @param  ChildRIssuesRtfplugin $rIssuesRtfplugin The ChildRIssuesRtfplugin object to remove.
     * @return $this|ChildIssues The current object (for fluent API support)
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
            $rIssuesRtfplugin->setIssues(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Issues is new, it will return
     * an empty collection; or if this Issues has previously
     * been saved, it will retrieve related RIssuesRtfplugins from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Issues.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRIssuesRtfplugin[] List of ChildRIssuesRtfplugin objects
     */
    public function getRIssuesRtfpluginsJoinPlugins(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRIssuesRtfpluginQuery::create(null, $criteria);
        $query->joinWith('Plugins', $joinBehavior);

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
     * If this ChildIssues is new, it will return
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
                    ->filterByIssues($this)
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
     * @return $this|ChildIssues The current object (for fluent API support)
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
            $rIssuesSinglepluginRemoved->setIssues(null);
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
                ->filterByIssues($this)
                ->count($con);
        }

        return count($this->collRIssuesSingleplugins);
    }

    /**
     * Method called to associate a ChildRIssuesSingleplugin object to this object
     * through the ChildRIssuesSingleplugin foreign key attribute.
     *
     * @param  ChildRIssuesSingleplugin $l ChildRIssuesSingleplugin
     * @return $this|\Issues The current object (for fluent API support)
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
        $rIssuesSingleplugin->setIssues($this);
    }

    /**
     * @param  ChildRIssuesSingleplugin $rIssuesSingleplugin The ChildRIssuesSingleplugin object to remove.
     * @return $this|ChildIssues The current object (for fluent API support)
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
            $rIssuesSingleplugin->setIssues(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Issues is new, it will return
     * an empty collection; or if this Issues has previously
     * been saved, it will retrieve related RIssuesSingleplugins from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Issues.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRIssuesSingleplugin[] List of ChildRIssuesSingleplugin objects
     */
    public function getRIssuesSinglepluginsJoinPlugins(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRIssuesSinglepluginQuery::create(null, $criteria);
        $query->joinWith('Plugins', $joinBehavior);

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
     * If this ChildIssues is new, it will return
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
                    ->filterByIssues($this)
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
     * @return $this|ChildIssues The current object (for fluent API support)
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
            $rIssuesXmlpluginRemoved->setIssues(null);
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
                ->filterByIssues($this)
                ->count($con);
        }

        return count($this->collRIssuesXmlplugins);
    }

    /**
     * Method called to associate a ChildRIssuesXmlplugin object to this object
     * through the ChildRIssuesXmlplugin foreign key attribute.
     *
     * @param  ChildRIssuesXmlplugin $l ChildRIssuesXmlplugin
     * @return $this|\Issues The current object (for fluent API support)
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
        $rIssuesXmlplugin->setIssues($this);
    }

    /**
     * @param  ChildRIssuesXmlplugin $rIssuesXmlplugin The ChildRIssuesXmlplugin object to remove.
     * @return $this|ChildIssues The current object (for fluent API support)
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
            $rIssuesXmlplugin->setIssues(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Issues is new, it will return
     * an empty collection; or if this Issues has previously
     * been saved, it will retrieve related RIssuesXmlplugins from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Issues.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRIssuesXmlplugin[] List of ChildRIssuesXmlplugin objects
     */
    public function getRIssuesXmlpluginsJoinPlugins(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRIssuesXmlpluginQuery::create(null, $criteria);
        $query->joinWith('Plugins', $joinBehavior);

        return $this->getRIssuesXmlplugins($query, $con);
    }

    /**
     * Clears out the collRRightsForissues collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRRightsForissues()
     */
    public function clearRRightsForissues()
    {
        $this->collRRightsForissues = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRRightsForissues collection loaded partially.
     */
    public function resetPartialRRightsForissues($v = true)
    {
        $this->collRRightsForissuesPartial = $v;
    }

    /**
     * Initializes the collRRightsForissues collection.
     *
     * By default this just sets the collRRightsForissues collection to an empty array (like clearcollRRightsForissues());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRRightsForissues($overrideExisting = true)
    {
        if (null !== $this->collRRightsForissues && !$overrideExisting) {
            return;
        }
        $this->collRRightsForissues = new ObjectCollection();
        $this->collRRightsForissues->setModel('\RRightsForissue');
    }

    /**
     * Gets an array of ChildRRightsForissue objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildIssues is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRRightsForissue[] List of ChildRRightsForissue objects
     * @throws PropelException
     */
    public function getRRightsForissues(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRRightsForissuesPartial && !$this->isNew();
        if (null === $this->collRRightsForissues || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRRightsForissues) {
                // return empty collection
                $this->initRRightsForissues();
            } else {
                $collRRightsForissues = ChildRRightsForissueQuery::create(null, $criteria)
                    ->filterByIssues($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRRightsForissuesPartial && count($collRRightsForissues)) {
                        $this->initRRightsForissues(false);

                        foreach ($collRRightsForissues as $obj) {
                            if (false == $this->collRRightsForissues->contains($obj)) {
                                $this->collRRightsForissues->append($obj);
                            }
                        }

                        $this->collRRightsForissuesPartial = true;
                    }

                    return $collRRightsForissues;
                }

                if ($partial && $this->collRRightsForissues) {
                    foreach ($this->collRRightsForissues as $obj) {
                        if ($obj->isNew()) {
                            $collRRightsForissues[] = $obj;
                        }
                    }
                }

                $this->collRRightsForissues = $collRRightsForissues;
                $this->collRRightsForissuesPartial = false;
            }
        }

        return $this->collRRightsForissues;
    }

    /**
     * Sets a collection of ChildRRightsForissue objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $rRightsForissues A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildIssues The current object (for fluent API support)
     */
    public function setRRightsForissues(Collection $rRightsForissues, ConnectionInterface $con = null)
    {
        /** @var ChildRRightsForissue[] $rRightsForissuesToDelete */
        $rRightsForissuesToDelete = $this->getRRightsForissues(new Criteria(), $con)->diff($rRightsForissues);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->rRightsForissuesScheduledForDeletion = clone $rRightsForissuesToDelete;

        foreach ($rRightsForissuesToDelete as $rRightsForissueRemoved) {
            $rRightsForissueRemoved->setIssues(null);
        }

        $this->collRRightsForissues = null;
        foreach ($rRightsForissues as $rRightsForissue) {
            $this->addRRightsForissue($rRightsForissue);
        }

        $this->collRRightsForissues = $rRightsForissues;
        $this->collRRightsForissuesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RRightsForissue objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RRightsForissue objects.
     * @throws PropelException
     */
    public function countRRightsForissues(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRRightsForissuesPartial && !$this->isNew();
        if (null === $this->collRRightsForissues || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRRightsForissues) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRRightsForissues());
            }

            $query = ChildRRightsForissueQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByIssues($this)
                ->count($con);
        }

        return count($this->collRRightsForissues);
    }

    /**
     * Method called to associate a ChildRRightsForissue object to this object
     * through the ChildRRightsForissue foreign key attribute.
     *
     * @param  ChildRRightsForissue $l ChildRRightsForissue
     * @return $this|\Issues The current object (for fluent API support)
     */
    public function addRRightsForissue(ChildRRightsForissue $l)
    {
        if ($this->collRRightsForissues === null) {
            $this->initRRightsForissues();
            $this->collRRightsForissuesPartial = true;
        }

        if (!$this->collRRightsForissues->contains($l)) {
            $this->doAddRRightsForissue($l);

            if ($this->rRightsForissuesScheduledForDeletion and $this->rRightsForissuesScheduledForDeletion->contains($l)) {
                $this->rRightsForissuesScheduledForDeletion->remove($this->rRightsForissuesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildRRightsForissue $rRightsForissue The ChildRRightsForissue object to add.
     */
    protected function doAddRRightsForissue(ChildRRightsForissue $rRightsForissue)
    {
        $this->collRRightsForissues[]= $rRightsForissue;
        $rRightsForissue->setIssues($this);
    }

    /**
     * @param  ChildRRightsForissue $rRightsForissue The ChildRRightsForissue object to remove.
     * @return $this|ChildIssues The current object (for fluent API support)
     */
    public function removeRRightsForissue(ChildRRightsForissue $rRightsForissue)
    {
        if ($this->getRRightsForissues()->contains($rRightsForissue)) {
            $pos = $this->collRRightsForissues->search($rRightsForissue);
            $this->collRRightsForissues->remove($pos);
            if (null === $this->rRightsForissuesScheduledForDeletion) {
                $this->rRightsForissuesScheduledForDeletion = clone $this->collRRightsForissues;
                $this->rRightsForissuesScheduledForDeletion->clear();
            }
            $this->rRightsForissuesScheduledForDeletion[]= clone $rRightsForissue;
            $rRightsForissue->setIssues(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Issues is new, it will return
     * an empty collection; or if this Issues has previously
     * been saved, it will retrieve related RRightsForissues from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Issues.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRRightsForissue[] List of ChildRRightsForissue objects
     */
    public function getRRightsForissuesJoinRights(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRRightsForissueQuery::create(null, $criteria);
        $query->joinWith('Rights', $joinBehavior);

        return $this->getRRightsForissues($query, $con);
    }

    /**
     * Clears out the collContributionss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addContributionss()
     */
    public function clearContributionss()
    {
        $this->collContributionss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collContributionss collection loaded partially.
     */
    public function resetPartialContributionss($v = true)
    {
        $this->collContributionssPartial = $v;
    }

    /**
     * Initializes the collContributionss collection.
     *
     * By default this just sets the collContributionss collection to an empty array (like clearcollContributionss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initContributionss($overrideExisting = true)
    {
        if (null !== $this->collContributionss && !$overrideExisting) {
            return;
        }
        $this->collContributionss = new ObjectCollection();
        $this->collContributionss->setModel('\Contributions');
    }

    /**
     * Gets an array of ChildContributions objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildIssues is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildContributions[] List of ChildContributions objects
     * @throws PropelException
     */
    public function getContributionss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collContributionssPartial && !$this->isNew();
        if (null === $this->collContributionss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collContributionss) {
                // return empty collection
                $this->initContributionss();
            } else {
                $collContributionss = ChildContributionsQuery::create(null, $criteria)
                    ->filterByIssues($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collContributionssPartial && count($collContributionss)) {
                        $this->initContributionss(false);

                        foreach ($collContributionss as $obj) {
                            if (false == $this->collContributionss->contains($obj)) {
                                $this->collContributionss->append($obj);
                            }
                        }

                        $this->collContributionssPartial = true;
                    }

                    return $collContributionss;
                }

                if ($partial && $this->collContributionss) {
                    foreach ($this->collContributionss as $obj) {
                        if ($obj->isNew()) {
                            $collContributionss[] = $obj;
                        }
                    }
                }

                $this->collContributionss = $collContributionss;
                $this->collContributionssPartial = false;
            }
        }

        return $this->collContributionss;
    }

    /**
     * Sets a collection of ChildContributions objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $contributionss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildIssues The current object (for fluent API support)
     */
    public function setContributionss(Collection $contributionss, ConnectionInterface $con = null)
    {
        /** @var ChildContributions[] $contributionssToDelete */
        $contributionssToDelete = $this->getContributionss(new Criteria(), $con)->diff($contributionss);


        $this->contributionssScheduledForDeletion = $contributionssToDelete;

        foreach ($contributionssToDelete as $contributionsRemoved) {
            $contributionsRemoved->setIssues(null);
        }

        $this->collContributionss = null;
        foreach ($contributionss as $contributions) {
            $this->addContributions($contributions);
        }

        $this->collContributionss = $contributionss;
        $this->collContributionssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Contributions objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Contributions objects.
     * @throws PropelException
     */
    public function countContributionss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collContributionssPartial && !$this->isNew();
        if (null === $this->collContributionss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collContributionss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getContributionss());
            }

            $query = ChildContributionsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByIssues($this)
                ->count($con);
        }

        return count($this->collContributionss);
    }

    /**
     * Method called to associate a ChildContributions object to this object
     * through the ChildContributions foreign key attribute.
     *
     * @param  ChildContributions $l ChildContributions
     * @return $this|\Issues The current object (for fluent API support)
     */
    public function addContributions(ChildContributions $l)
    {
        if ($this->collContributionss === null) {
            $this->initContributionss();
            $this->collContributionssPartial = true;
        }

        if (!$this->collContributionss->contains($l)) {
            $this->doAddContributions($l);

            if ($this->contributionssScheduledForDeletion and $this->contributionssScheduledForDeletion->contains($l)) {
                $this->contributionssScheduledForDeletion->remove($this->contributionssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildContributions $contributions The ChildContributions object to add.
     */
    protected function doAddContributions(ChildContributions $contributions)
    {
        $this->collContributionss[]= $contributions;
        $contributions->setIssues($this);
    }

    /**
     * @param  ChildContributions $contributions The ChildContributions object to remove.
     * @return $this|ChildIssues The current object (for fluent API support)
     */
    public function removeContributions(ChildContributions $contributions)
    {
        if ($this->getContributionss()->contains($contributions)) {
            $pos = $this->collContributionss->search($contributions);
            $this->collContributionss->remove($pos);
            if (null === $this->contributionssScheduledForDeletion) {
                $this->contributionssScheduledForDeletion = clone $this->collContributionss;
                $this->contributionssScheduledForDeletion->clear();
            }
            $this->contributionssScheduledForDeletion[]= $contributions;
            $contributions->setIssues(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Issues is new, it will return
     * an empty collection; or if this Issues has previously
     * been saved, it will retrieve related Contributionss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Issues.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildContributions[] List of ChildContributions objects
     */
    public function getContributionssJoinFormats(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildContributionsQuery::create(null, $criteria);
        $query->joinWith('Formats', $joinBehavior);

        return $this->getContributionss($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Issues is new, it will return
     * an empty collection; or if this Issues has previously
     * been saved, it will retrieve related Contributionss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Issues.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildContributions[] List of ChildContributions objects
     */
    public function getContributionssJoinTemplatenames(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildContributionsQuery::create(null, $criteria);
        $query->joinWith('Templatenames', $joinBehavior);

        return $this->getContributionss($query, $con);
    }

    /**
     * Clears out the collPluginss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPluginss()
     */
    public function clearPluginss()
    {
        $this->collPluginss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collPluginss crossRef collection.
     *
     * By default this just sets the collPluginss collection to an empty collection (like clearPluginss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initPluginss()
    {
        $this->collPluginss = new ObjectCollection();
        $this->collPluginssPartial = true;

        $this->collPluginss->setModel('\Plugins');
    }

    /**
     * Checks if the collPluginss collection is loaded.
     *
     * @return bool
     */
    public function isPluginssLoaded()
    {
        return null !== $this->collPluginss;
    }

    /**
     * Gets a collection of ChildPlugins objects related by a many-to-many relationship
     * to the current object by way of the R_issues_allplugin cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildIssues is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildPlugins[] List of ChildPlugins objects
     */
    public function getPluginss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPluginssPartial && !$this->isNew();
        if (null === $this->collPluginss || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collPluginss) {
                    $this->initPluginss();
                }
            } else {

                $query = ChildPluginsQuery::create(null, $criteria)
                    ->filterByIssues($this);
                $collPluginss = $query->find($con);
                if (null !== $criteria) {
                    return $collPluginss;
                }

                if ($partial && $this->collPluginss) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collPluginss as $obj) {
                        if (!$collPluginss->contains($obj)) {
                            $collPluginss[] = $obj;
                        }
                    }
                }

                $this->collPluginss = $collPluginss;
                $this->collPluginssPartial = false;
            }
        }

        return $this->collPluginss;
    }

    /**
     * Sets a collection of Plugins objects related by a many-to-many relationship
     * to the current object by way of the R_issues_allplugin cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $pluginss A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildIssues The current object (for fluent API support)
     */
    public function setPluginss(Collection $pluginss, ConnectionInterface $con = null)
    {
        $this->clearPluginss();
        $currentPluginss = $this->getPluginss();

        $pluginssScheduledForDeletion = $currentPluginss->diff($pluginss);

        foreach ($pluginssScheduledForDeletion as $toDelete) {
            $this->removePlugins($toDelete);
        }

        foreach ($pluginss as $plugins) {
            if (!$currentPluginss->contains($plugins)) {
                $this->doAddPlugins($plugins);
            }
        }

        $this->collPluginssPartial = false;
        $this->collPluginss = $pluginss;

        return $this;
    }

    /**
     * Gets the number of Plugins objects related by a many-to-many relationship
     * to the current object by way of the R_issues_allplugin cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Plugins objects
     */
    public function countPluginss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPluginssPartial && !$this->isNew();
        if (null === $this->collPluginss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPluginss) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getPluginss());
                }

                $query = ChildPluginsQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByIssues($this)
                    ->count($con);
            }
        } else {
            return count($this->collPluginss);
        }
    }

    /**
     * Associate a ChildPlugins to this object
     * through the R_issues_allplugin cross reference table.
     *
     * @param ChildPlugins $plugins
     * @return ChildIssues The current object (for fluent API support)
     */
    public function addPlugins(ChildPlugins $plugins)
    {
        if ($this->collPluginss === null) {
            $this->initPluginss();
        }

        if (!$this->getPluginss()->contains($plugins)) {
            // only add it if the **same** object is not already associated
            $this->collPluginss->push($plugins);
            $this->doAddPlugins($plugins);
        }

        return $this;
    }

    /**
     *
     * @param ChildPlugins $plugins
     */
    protected function doAddPlugins(ChildPlugins $plugins)
    {
        $rIssuesAllplugin = new ChildRIssuesAllplugin();

        $rIssuesAllplugin->setPlugins($plugins);

        $rIssuesAllplugin->setIssues($this);

        $this->addRIssuesAllplugin($rIssuesAllplugin);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$plugins->isIssuessLoaded()) {
            $plugins->initIssuess();
            $plugins->getIssuess()->push($this);
        } elseif (!$plugins->getIssuess()->contains($this)) {
            $plugins->getIssuess()->push($this);
        }

    }

    /**
     * Remove plugins of this object
     * through the R_issues_allplugin cross reference table.
     *
     * @param ChildPlugins $plugins
     * @return ChildIssues The current object (for fluent API support)
     */
    public function removePlugins(ChildPlugins $plugins)
    {
        if ($this->getPluginss()->contains($plugins)) { $rIssuesAllplugin = new ChildRIssuesAllplugin();

            $rIssuesAllplugin->setPlugins($plugins);
            if ($plugins->isIssuessLoaded()) {
                //remove the back reference if available
                $plugins->getIssuess()->removeObject($this);
            }

            $rIssuesAllplugin->setIssues($this);
            $this->removeRIssuesAllplugin(clone $rIssuesAllplugin);
            $rIssuesAllplugin->clear();

            $this->collPluginss->remove($this->collPluginss->search($plugins));

            if (null === $this->pluginssScheduledForDeletion) {
                $this->pluginssScheduledForDeletion = clone $this->collPluginss;
                $this->pluginssScheduledForDeletion->clear();
            }

            $this->pluginssScheduledForDeletion->push($plugins);
        }


        return $this;
    }

    /**
     * Clears out the collPluginss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPluginss()
     */
    public function clearPluginss()
    {
        $this->collPluginss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collPluginss crossRef collection.
     *
     * By default this just sets the collPluginss collection to an empty collection (like clearPluginss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initPluginss()
    {
        $this->collPluginss = new ObjectCollection();
        $this->collPluginssPartial = true;

        $this->collPluginss->setModel('\Plugins');
    }

    /**
     * Checks if the collPluginss collection is loaded.
     *
     * @return bool
     */
    public function isPluginssLoaded()
    {
        return null !== $this->collPluginss;
    }

    /**
     * Gets a collection of ChildPlugins objects related by a many-to-many relationship
     * to the current object by way of the R_issues_narrationplugin cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildIssues is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildPlugins[] List of ChildPlugins objects
     */
    public function getPluginss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPluginssPartial && !$this->isNew();
        if (null === $this->collPluginss || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collPluginss) {
                    $this->initPluginss();
                }
            } else {

                $query = ChildPluginsQuery::create(null, $criteria)
                    ->filterByIssues($this);
                $collPluginss = $query->find($con);
                if (null !== $criteria) {
                    return $collPluginss;
                }

                if ($partial && $this->collPluginss) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collPluginss as $obj) {
                        if (!$collPluginss->contains($obj)) {
                            $collPluginss[] = $obj;
                        }
                    }
                }

                $this->collPluginss = $collPluginss;
                $this->collPluginssPartial = false;
            }
        }

        return $this->collPluginss;
    }

    /**
     * Sets a collection of Plugins objects related by a many-to-many relationship
     * to the current object by way of the R_issues_narrationplugin cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $pluginss A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildIssues The current object (for fluent API support)
     */
    public function setPluginss(Collection $pluginss, ConnectionInterface $con = null)
    {
        $this->clearPluginss();
        $currentPluginss = $this->getPluginss();

        $pluginssScheduledForDeletion = $currentPluginss->diff($pluginss);

        foreach ($pluginssScheduledForDeletion as $toDelete) {
            $this->removePlugins($toDelete);
        }

        foreach ($pluginss as $plugins) {
            if (!$currentPluginss->contains($plugins)) {
                $this->doAddPlugins($plugins);
            }
        }

        $this->collPluginssPartial = false;
        $this->collPluginss = $pluginss;

        return $this;
    }

    /**
     * Gets the number of Plugins objects related by a many-to-many relationship
     * to the current object by way of the R_issues_narrationplugin cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Plugins objects
     */
    public function countPluginss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPluginssPartial && !$this->isNew();
        if (null === $this->collPluginss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPluginss) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getPluginss());
                }

                $query = ChildPluginsQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByIssues($this)
                    ->count($con);
            }
        } else {
            return count($this->collPluginss);
        }
    }

    /**
     * Associate a ChildPlugins to this object
     * through the R_issues_narrationplugin cross reference table.
     *
     * @param ChildPlugins $plugins
     * @return ChildIssues The current object (for fluent API support)
     */
    public function addPlugins(ChildPlugins $plugins)
    {
        if ($this->collPluginss === null) {
            $this->initPluginss();
        }

        if (!$this->getPluginss()->contains($plugins)) {
            // only add it if the **same** object is not already associated
            $this->collPluginss->push($plugins);
            $this->doAddPlugins($plugins);
        }

        return $this;
    }

    /**
     *
     * @param ChildPlugins $plugins
     */
    protected function doAddPlugins(ChildPlugins $plugins)
    {
        $rIssuesNarrationplugin = new ChildRIssuesNarrationplugin();

        $rIssuesNarrationplugin->setPlugins($plugins);

        $rIssuesNarrationplugin->setIssues($this);

        $this->addRIssuesNarrationplugin($rIssuesNarrationplugin);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$plugins->isIssuessLoaded()) {
            $plugins->initIssuess();
            $plugins->getIssuess()->push($this);
        } elseif (!$plugins->getIssuess()->contains($this)) {
            $plugins->getIssuess()->push($this);
        }

    }

    /**
     * Remove plugins of this object
     * through the R_issues_narrationplugin cross reference table.
     *
     * @param ChildPlugins $plugins
     * @return ChildIssues The current object (for fluent API support)
     */
    public function removePlugins(ChildPlugins $plugins)
    {
        if ($this->getPluginss()->contains($plugins)) { $rIssuesNarrationplugin = new ChildRIssuesNarrationplugin();

            $rIssuesNarrationplugin->setPlugins($plugins);
            if ($plugins->isIssuessLoaded()) {
                //remove the back reference if available
                $plugins->getIssuess()->removeObject($this);
            }

            $rIssuesNarrationplugin->setIssues($this);
            $this->removeRIssuesNarrationplugin(clone $rIssuesNarrationplugin);
            $rIssuesNarrationplugin->clear();

            $this->collPluginss->remove($this->collPluginss->search($plugins));

            if (null === $this->pluginssScheduledForDeletion) {
                $this->pluginssScheduledForDeletion = clone $this->collPluginss;
                $this->pluginssScheduledForDeletion->clear();
            }

            $this->pluginssScheduledForDeletion->push($plugins);
        }


        return $this;
    }

    /**
     * Clears out the collPluginss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPluginss()
     */
    public function clearPluginss()
    {
        $this->collPluginss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collPluginss crossRef collection.
     *
     * By default this just sets the collPluginss collection to an empty collection (like clearPluginss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initPluginss()
    {
        $this->collPluginss = new ObjectCollection();
        $this->collPluginssPartial = true;

        $this->collPluginss->setModel('\Plugins');
    }

    /**
     * Checks if the collPluginss collection is loaded.
     *
     * @return bool
     */
    public function isPluginssLoaded()
    {
        return null !== $this->collPluginss;
    }

    /**
     * Gets a collection of ChildPlugins objects related by a many-to-many relationship
     * to the current object by way of the R_issues_rtfplugin cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildIssues is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildPlugins[] List of ChildPlugins objects
     */
    public function getPluginss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPluginssPartial && !$this->isNew();
        if (null === $this->collPluginss || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collPluginss) {
                    $this->initPluginss();
                }
            } else {

                $query = ChildPluginsQuery::create(null, $criteria)
                    ->filterByIssues($this);
                $collPluginss = $query->find($con);
                if (null !== $criteria) {
                    return $collPluginss;
                }

                if ($partial && $this->collPluginss) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collPluginss as $obj) {
                        if (!$collPluginss->contains($obj)) {
                            $collPluginss[] = $obj;
                        }
                    }
                }

                $this->collPluginss = $collPluginss;
                $this->collPluginssPartial = false;
            }
        }

        return $this->collPluginss;
    }

    /**
     * Sets a collection of Plugins objects related by a many-to-many relationship
     * to the current object by way of the R_issues_rtfplugin cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $pluginss A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildIssues The current object (for fluent API support)
     */
    public function setPluginss(Collection $pluginss, ConnectionInterface $con = null)
    {
        $this->clearPluginss();
        $currentPluginss = $this->getPluginss();

        $pluginssScheduledForDeletion = $currentPluginss->diff($pluginss);

        foreach ($pluginssScheduledForDeletion as $toDelete) {
            $this->removePlugins($toDelete);
        }

        foreach ($pluginss as $plugins) {
            if (!$currentPluginss->contains($plugins)) {
                $this->doAddPlugins($plugins);
            }
        }

        $this->collPluginssPartial = false;
        $this->collPluginss = $pluginss;

        return $this;
    }

    /**
     * Gets the number of Plugins objects related by a many-to-many relationship
     * to the current object by way of the R_issues_rtfplugin cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Plugins objects
     */
    public function countPluginss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPluginssPartial && !$this->isNew();
        if (null === $this->collPluginss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPluginss) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getPluginss());
                }

                $query = ChildPluginsQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByIssues($this)
                    ->count($con);
            }
        } else {
            return count($this->collPluginss);
        }
    }

    /**
     * Associate a ChildPlugins to this object
     * through the R_issues_rtfplugin cross reference table.
     *
     * @param ChildPlugins $plugins
     * @return ChildIssues The current object (for fluent API support)
     */
    public function addPlugins(ChildPlugins $plugins)
    {
        if ($this->collPluginss === null) {
            $this->initPluginss();
        }

        if (!$this->getPluginss()->contains($plugins)) {
            // only add it if the **same** object is not already associated
            $this->collPluginss->push($plugins);
            $this->doAddPlugins($plugins);
        }

        return $this;
    }

    /**
     *
     * @param ChildPlugins $plugins
     */
    protected function doAddPlugins(ChildPlugins $plugins)
    {
        $rIssuesRtfplugin = new ChildRIssuesRtfplugin();

        $rIssuesRtfplugin->setPlugins($plugins);

        $rIssuesRtfplugin->setIssues($this);

        $this->addRIssuesRtfplugin($rIssuesRtfplugin);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$plugins->isIssuessLoaded()) {
            $plugins->initIssuess();
            $plugins->getIssuess()->push($this);
        } elseif (!$plugins->getIssuess()->contains($this)) {
            $plugins->getIssuess()->push($this);
        }

    }

    /**
     * Remove plugins of this object
     * through the R_issues_rtfplugin cross reference table.
     *
     * @param ChildPlugins $plugins
     * @return ChildIssues The current object (for fluent API support)
     */
    public function removePlugins(ChildPlugins $plugins)
    {
        if ($this->getPluginss()->contains($plugins)) { $rIssuesRtfplugin = new ChildRIssuesRtfplugin();

            $rIssuesRtfplugin->setPlugins($plugins);
            if ($plugins->isIssuessLoaded()) {
                //remove the back reference if available
                $plugins->getIssuess()->removeObject($this);
            }

            $rIssuesRtfplugin->setIssues($this);
            $this->removeRIssuesRtfplugin(clone $rIssuesRtfplugin);
            $rIssuesRtfplugin->clear();

            $this->collPluginss->remove($this->collPluginss->search($plugins));

            if (null === $this->pluginssScheduledForDeletion) {
                $this->pluginssScheduledForDeletion = clone $this->collPluginss;
                $this->pluginssScheduledForDeletion->clear();
            }

            $this->pluginssScheduledForDeletion->push($plugins);
        }


        return $this;
    }

    /**
     * Clears out the collPluginss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPluginss()
     */
    public function clearPluginss()
    {
        $this->collPluginss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collPluginss crossRef collection.
     *
     * By default this just sets the collPluginss collection to an empty collection (like clearPluginss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initPluginss()
    {
        $this->collPluginss = new ObjectCollection();
        $this->collPluginssPartial = true;

        $this->collPluginss->setModel('\Plugins');
    }

    /**
     * Checks if the collPluginss collection is loaded.
     *
     * @return bool
     */
    public function isPluginssLoaded()
    {
        return null !== $this->collPluginss;
    }

    /**
     * Gets a collection of ChildPlugins objects related by a many-to-many relationship
     * to the current object by way of the R_issues_singleplugin cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildIssues is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildPlugins[] List of ChildPlugins objects
     */
    public function getPluginss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPluginssPartial && !$this->isNew();
        if (null === $this->collPluginss || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collPluginss) {
                    $this->initPluginss();
                }
            } else {

                $query = ChildPluginsQuery::create(null, $criteria)
                    ->filterByIssues($this);
                $collPluginss = $query->find($con);
                if (null !== $criteria) {
                    return $collPluginss;
                }

                if ($partial && $this->collPluginss) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collPluginss as $obj) {
                        if (!$collPluginss->contains($obj)) {
                            $collPluginss[] = $obj;
                        }
                    }
                }

                $this->collPluginss = $collPluginss;
                $this->collPluginssPartial = false;
            }
        }

        return $this->collPluginss;
    }

    /**
     * Sets a collection of Plugins objects related by a many-to-many relationship
     * to the current object by way of the R_issues_singleplugin cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $pluginss A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildIssues The current object (for fluent API support)
     */
    public function setPluginss(Collection $pluginss, ConnectionInterface $con = null)
    {
        $this->clearPluginss();
        $currentPluginss = $this->getPluginss();

        $pluginssScheduledForDeletion = $currentPluginss->diff($pluginss);

        foreach ($pluginssScheduledForDeletion as $toDelete) {
            $this->removePlugins($toDelete);
        }

        foreach ($pluginss as $plugins) {
            if (!$currentPluginss->contains($plugins)) {
                $this->doAddPlugins($plugins);
            }
        }

        $this->collPluginssPartial = false;
        $this->collPluginss = $pluginss;

        return $this;
    }

    /**
     * Gets the number of Plugins objects related by a many-to-many relationship
     * to the current object by way of the R_issues_singleplugin cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Plugins objects
     */
    public function countPluginss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPluginssPartial && !$this->isNew();
        if (null === $this->collPluginss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPluginss) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getPluginss());
                }

                $query = ChildPluginsQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByIssues($this)
                    ->count($con);
            }
        } else {
            return count($this->collPluginss);
        }
    }

    /**
     * Associate a ChildPlugins to this object
     * through the R_issues_singleplugin cross reference table.
     *
     * @param ChildPlugins $plugins
     * @return ChildIssues The current object (for fluent API support)
     */
    public function addPlugins(ChildPlugins $plugins)
    {
        if ($this->collPluginss === null) {
            $this->initPluginss();
        }

        if (!$this->getPluginss()->contains($plugins)) {
            // only add it if the **same** object is not already associated
            $this->collPluginss->push($plugins);
            $this->doAddPlugins($plugins);
        }

        return $this;
    }

    /**
     *
     * @param ChildPlugins $plugins
     */
    protected function doAddPlugins(ChildPlugins $plugins)
    {
        $rIssuesSingleplugin = new ChildRIssuesSingleplugin();

        $rIssuesSingleplugin->setPlugins($plugins);

        $rIssuesSingleplugin->setIssues($this);

        $this->addRIssuesSingleplugin($rIssuesSingleplugin);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$plugins->isIssuessLoaded()) {
            $plugins->initIssuess();
            $plugins->getIssuess()->push($this);
        } elseif (!$plugins->getIssuess()->contains($this)) {
            $plugins->getIssuess()->push($this);
        }

    }

    /**
     * Remove plugins of this object
     * through the R_issues_singleplugin cross reference table.
     *
     * @param ChildPlugins $plugins
     * @return ChildIssues The current object (for fluent API support)
     */
    public function removePlugins(ChildPlugins $plugins)
    {
        if ($this->getPluginss()->contains($plugins)) { $rIssuesSingleplugin = new ChildRIssuesSingleplugin();

            $rIssuesSingleplugin->setPlugins($plugins);
            if ($plugins->isIssuessLoaded()) {
                //remove the back reference if available
                $plugins->getIssuess()->removeObject($this);
            }

            $rIssuesSingleplugin->setIssues($this);
            $this->removeRIssuesSingleplugin(clone $rIssuesSingleplugin);
            $rIssuesSingleplugin->clear();

            $this->collPluginss->remove($this->collPluginss->search($plugins));

            if (null === $this->pluginssScheduledForDeletion) {
                $this->pluginssScheduledForDeletion = clone $this->collPluginss;
                $this->pluginssScheduledForDeletion->clear();
            }

            $this->pluginssScheduledForDeletion->push($plugins);
        }


        return $this;
    }

    /**
     * Clears out the collPluginss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPluginss()
     */
    public function clearPluginss()
    {
        $this->collPluginss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collPluginss crossRef collection.
     *
     * By default this just sets the collPluginss collection to an empty collection (like clearPluginss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initPluginss()
    {
        $this->collPluginss = new ObjectCollection();
        $this->collPluginssPartial = true;

        $this->collPluginss->setModel('\Plugins');
    }

    /**
     * Checks if the collPluginss collection is loaded.
     *
     * @return bool
     */
    public function isPluginssLoaded()
    {
        return null !== $this->collPluginss;
    }

    /**
     * Gets a collection of ChildPlugins objects related by a many-to-many relationship
     * to the current object by way of the R_issues_xmlplugin cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildIssues is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildPlugins[] List of ChildPlugins objects
     */
    public function getPluginss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPluginssPartial && !$this->isNew();
        if (null === $this->collPluginss || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collPluginss) {
                    $this->initPluginss();
                }
            } else {

                $query = ChildPluginsQuery::create(null, $criteria)
                    ->filterByIssues($this);
                $collPluginss = $query->find($con);
                if (null !== $criteria) {
                    return $collPluginss;
                }

                if ($partial && $this->collPluginss) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collPluginss as $obj) {
                        if (!$collPluginss->contains($obj)) {
                            $collPluginss[] = $obj;
                        }
                    }
                }

                $this->collPluginss = $collPluginss;
                $this->collPluginssPartial = false;
            }
        }

        return $this->collPluginss;
    }

    /**
     * Sets a collection of Plugins objects related by a many-to-many relationship
     * to the current object by way of the R_issues_xmlplugin cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $pluginss A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildIssues The current object (for fluent API support)
     */
    public function setPluginss(Collection $pluginss, ConnectionInterface $con = null)
    {
        $this->clearPluginss();
        $currentPluginss = $this->getPluginss();

        $pluginssScheduledForDeletion = $currentPluginss->diff($pluginss);

        foreach ($pluginssScheduledForDeletion as $toDelete) {
            $this->removePlugins($toDelete);
        }

        foreach ($pluginss as $plugins) {
            if (!$currentPluginss->contains($plugins)) {
                $this->doAddPlugins($plugins);
            }
        }

        $this->collPluginssPartial = false;
        $this->collPluginss = $pluginss;

        return $this;
    }

    /**
     * Gets the number of Plugins objects related by a many-to-many relationship
     * to the current object by way of the R_issues_xmlplugin cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Plugins objects
     */
    public function countPluginss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPluginssPartial && !$this->isNew();
        if (null === $this->collPluginss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPluginss) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getPluginss());
                }

                $query = ChildPluginsQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByIssues($this)
                    ->count($con);
            }
        } else {
            return count($this->collPluginss);
        }
    }

    /**
     * Associate a ChildPlugins to this object
     * through the R_issues_xmlplugin cross reference table.
     *
     * @param ChildPlugins $plugins
     * @return ChildIssues The current object (for fluent API support)
     */
    public function addPlugins(ChildPlugins $plugins)
    {
        if ($this->collPluginss === null) {
            $this->initPluginss();
        }

        if (!$this->getPluginss()->contains($plugins)) {
            // only add it if the **same** object is not already associated
            $this->collPluginss->push($plugins);
            $this->doAddPlugins($plugins);
        }

        return $this;
    }

    /**
     *
     * @param ChildPlugins $plugins
     */
    protected function doAddPlugins(ChildPlugins $plugins)
    {
        $rIssuesXmlplugin = new ChildRIssuesXmlplugin();

        $rIssuesXmlplugin->setPlugins($plugins);

        $rIssuesXmlplugin->setIssues($this);

        $this->addRIssuesXmlplugin($rIssuesXmlplugin);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$plugins->isIssuessLoaded()) {
            $plugins->initIssuess();
            $plugins->getIssuess()->push($this);
        } elseif (!$plugins->getIssuess()->contains($this)) {
            $plugins->getIssuess()->push($this);
        }

    }

    /**
     * Remove plugins of this object
     * through the R_issues_xmlplugin cross reference table.
     *
     * @param ChildPlugins $plugins
     * @return ChildIssues The current object (for fluent API support)
     */
    public function removePlugins(ChildPlugins $plugins)
    {
        if ($this->getPluginss()->contains($plugins)) { $rIssuesXmlplugin = new ChildRIssuesXmlplugin();

            $rIssuesXmlplugin->setPlugins($plugins);
            if ($plugins->isIssuessLoaded()) {
                //remove the back reference if available
                $plugins->getIssuess()->removeObject($this);
            }

            $rIssuesXmlplugin->setIssues($this);
            $this->removeRIssuesXmlplugin(clone $rIssuesXmlplugin);
            $rIssuesXmlplugin->clear();

            $this->collPluginss->remove($this->collPluginss->search($plugins));

            if (null === $this->pluginssScheduledForDeletion) {
                $this->pluginssScheduledForDeletion = clone $this->collPluginss;
                $this->pluginssScheduledForDeletion->clear();
            }

            $this->pluginssScheduledForDeletion->push($plugins);
        }


        return $this;
    }

    /**
     * Clears out the collRightss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRightss()
     */
    public function clearRightss()
    {
        $this->collRightss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collRightss crossRef collection.
     *
     * By default this just sets the collRightss collection to an empty collection (like clearRightss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initRightss()
    {
        $this->collRightss = new ObjectCollection();
        $this->collRightssPartial = true;

        $this->collRightss->setModel('\Rights');
    }

    /**
     * Checks if the collRightss collection is loaded.
     *
     * @return bool
     */
    public function isRightssLoaded()
    {
        return null !== $this->collRightss;
    }

    /**
     * Gets a collection of ChildRights objects related by a many-to-many relationship
     * to the current object by way of the R_rights_forissue cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildIssues is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildRights[] List of ChildRights objects
     */
    public function getRightss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRightssPartial && !$this->isNew();
        if (null === $this->collRightss || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collRightss) {
                    $this->initRightss();
                }
            } else {

                $query = ChildRightsQuery::create(null, $criteria)
                    ->filterByIssues($this);
                $collRightss = $query->find($con);
                if (null !== $criteria) {
                    return $collRightss;
                }

                if ($partial && $this->collRightss) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collRightss as $obj) {
                        if (!$collRightss->contains($obj)) {
                            $collRightss[] = $obj;
                        }
                    }
                }

                $this->collRightss = $collRightss;
                $this->collRightssPartial = false;
            }
        }

        return $this->collRightss;
    }

    /**
     * Sets a collection of Rights objects related by a many-to-many relationship
     * to the current object by way of the R_rights_forissue cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $rightss A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildIssues The current object (for fluent API support)
     */
    public function setRightss(Collection $rightss, ConnectionInterface $con = null)
    {
        $this->clearRightss();
        $currentRightss = $this->getRightss();

        $rightssScheduledForDeletion = $currentRightss->diff($rightss);

        foreach ($rightssScheduledForDeletion as $toDelete) {
            $this->removeRights($toDelete);
        }

        foreach ($rightss as $rights) {
            if (!$currentRightss->contains($rights)) {
                $this->doAddRights($rights);
            }
        }

        $this->collRightssPartial = false;
        $this->collRightss = $rightss;

        return $this;
    }

    /**
     * Gets the number of Rights objects related by a many-to-many relationship
     * to the current object by way of the R_rights_forissue cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Rights objects
     */
    public function countRightss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRightssPartial && !$this->isNew();
        if (null === $this->collRightss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRightss) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getRightss());
                }

                $query = ChildRightsQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByIssues($this)
                    ->count($con);
            }
        } else {
            return count($this->collRightss);
        }
    }

    /**
     * Associate a ChildRights to this object
     * through the R_rights_forissue cross reference table.
     *
     * @param ChildRights $rights
     * @return ChildIssues The current object (for fluent API support)
     */
    public function addRights(ChildRights $rights)
    {
        if ($this->collRightss === null) {
            $this->initRightss();
        }

        if (!$this->getRightss()->contains($rights)) {
            // only add it if the **same** object is not already associated
            $this->collRightss->push($rights);
            $this->doAddRights($rights);
        }

        return $this;
    }

    /**
     *
     * @param ChildRights $rights
     */
    protected function doAddRights(ChildRights $rights)
    {
        $rRightsForissue = new ChildRRightsForissue();

        $rRightsForissue->setRights($rights);

        $rRightsForissue->setIssues($this);

        $this->addRRightsForissue($rRightsForissue);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$rights->isIssuessLoaded()) {
            $rights->initIssuess();
            $rights->getIssuess()->push($this);
        } elseif (!$rights->getIssuess()->contains($this)) {
            $rights->getIssuess()->push($this);
        }

    }

    /**
     * Remove rights of this object
     * through the R_rights_forissue cross reference table.
     *
     * @param ChildRights $rights
     * @return ChildIssues The current object (for fluent API support)
     */
    public function removeRights(ChildRights $rights)
    {
        if ($this->getRightss()->contains($rights)) { $rRightsForissue = new ChildRRightsForissue();

            $rRightsForissue->setRights($rights);
            if ($rights->isIssuessLoaded()) {
                //remove the back reference if available
                $rights->getIssuess()->removeObject($this);
            }

            $rRightsForissue->setIssues($this);
            $this->removeRRightsForissue(clone $rRightsForissue);
            $rRightsForissue->clear();

            $this->collRightss->remove($this->collRightss->search($rights));

            if (null === $this->rightssScheduledForDeletion) {
                $this->rightssScheduledForDeletion = clone $this->collRightss;
                $this->rightssScheduledForDeletion->clear();
            }

            $this->rightssScheduledForDeletion->push($rights);
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
        if (null !== $this->aBooks) {
            $this->aBooks->removeIssues($this);
        }
        $this->id = null;
        $this->_name = null;
        $this->_opendate = null;
        $this->_closedate = null;
        $this->_status = null;
        $this->_infotext = null;
        $this->_forbook = null;
        $this->_singleplugin = null;
        $this->_allplugin = null;
        $this->_rtfplugin = null;
        $this->_xmlplugin = null;
        $this->_narrationplugin = null;
        $this->__user__ = null;
        $this->__config__ = null;
        $this->__split__ = null;
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
            if ($this->collRRightsForissues) {
                foreach ($this->collRRightsForissues as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collContributionss) {
                foreach ($this->collContributionss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPluginss) {
                foreach ($this->collPluginss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPluginss) {
                foreach ($this->collPluginss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPluginss) {
                foreach ($this->collPluginss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPluginss) {
                foreach ($this->collPluginss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPluginss) {
                foreach ($this->collPluginss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRightss) {
                foreach ($this->collRightss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collRIssuesAllplugins = null;
        $this->collRIssuesNarrationplugins = null;
        $this->collRIssuesRtfplugins = null;
        $this->collRIssuesSingleplugins = null;
        $this->collRIssuesXmlplugins = null;
        $this->collRRightsForissues = null;
        $this->collContributionss = null;
        $this->collPluginss = null;
        $this->collPluginss = null;
        $this->collPluginss = null;
        $this->collPluginss = null;
        $this->collPluginss = null;
        $this->collRightss = null;
        $this->aBooks = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(IssuesTableMap::DEFAULT_STRING_FORMAT);
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
