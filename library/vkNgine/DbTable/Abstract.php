<?php
/**
 * vkNgine3 Admin System
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the new BSD license.
 *
 * @category    core
 * @package     vkNgine3
 * @copyright   Copyright (c) 2011 Volkan Yavuz (http://www.vknyvz.com)
 */
abstract class vkNgine_DbTable_Abstract extends Zend_Db_Table_Abstract
{	
	/**
	 * Name of the DB table.
	 * 
	 * @var string
	 */
    protected $_name	= null;
    
    /**
     * Name of primary column in the DB table.
     * 
     * @var string
     */
	protected $_primary	= null;	
	
	/**
	 * Array of columns editable by the admin iterface.
	 * If empty, all columns but the primary are editable.
	 * 
	 * @var array
	 */
	protected $_columns	= array();
	
	/**
	 * Whether a "dateInserted" column exists and should be managed.
	 * (string for alternate column name.)
	 * 
	 * @var bool
	 */
	protected $_saveInsertDate	= false;
	const INSERT_DATE_COLUMN_DEFAULT = 'dateInserted';
	
	/**
	 * Whether a "dateUpdated" column exists and should be managed.
	 * (string for alternate column name.)
	 * 
	 * @var mixed
	 */
	protected $_saveUpdateDate	= false;
	const UPDATE_DATE_COLUMN_DEFAULT = 'dateUpdated';
	
	/**
	 * Caching object
	 * 
	 * @var object either the Zend_Cache File Backend or Memcached Backend
	 */
	protected $_cache;
	
	public function __construct($config = null)
	{
		$this->_cache = Zend_Registry::get('cache');
		parent::__construct($config);
	}
	
	
	/**
	 * Returns name of table.
	 * 
	 * @return string
	 */
	public function getTableName()
	{
		return $this->getName();
	}
	
    /**
     * Returns name of primary column.
     * 
     * @return string
     */
    public function getPrimary()
    {
    	if (is_array($this->_primary)){
    		return (string) current($this->_primary);
    	}
    	else{
    		return (string) $this->_primary;
    	}
    }
    
    /**
     * Returns name of DB table.
     * 
     * @return string
     */
    protected function getName()
    {
    	return (string) $this->_name;
    }
	
	/**
     * Filters given array for editable columns only
     * 
     * @param	array $data	Input array.
     * @return	array
     */
    public function getDataForDb($data)
    {
    	// columns array set
    	if (!empty($this->_columns)){
    		$_columnsToCheck = $this->_columns;
    		
    		// add saveInsertDate, saveUpdateDate
    		if ($this->_saveInsertDate){
    			$_columnsToCheck[] = 'dateInserted';
    		}
    		if ($this->_saveUpdateDate){
    			$_columnsToCheck[] = 'dateUpdated';
    		}
    	}
    	// all columns
    	else{
    		$_info = $this->info();
    		$_columnsToCheck = $_info['cols'];
    	}
    	
    	$primary = $this->getPrimary();
    	
    	$new = array();
    	foreach($_columnsToCheck as $key){
    		// primary is untouchable unless columns array was specifically defined
    		if ($key !== $primary || !empty($this->_columns)){
    			if (array_key_exists($key, $data)){
    				$new[$key] = $data[$key];
    			}
    		}
    	}
    	return $new;
    }
    
    /**
     * Fetches one record by the primary ID.
     * 
     * @param	int	$id	Id to look for
     * @return Zend_Db_Table_Row_Abstract|null
     */
    public function getById($id)
    {
    	return $this->fetchRow($this->getPrimaryWhere($id));
    }
    
    /**
     * Returns WHERE statement by given primary ID.
     * 
     * @param	int	$id		Primary key value to look for.
     * @return	array		WHERE statement array for DB queries.
     */
	public function getPrimaryWhere($id)
	{
		$where = array();
		$where[] = $this->getPrimary() . ' = ' . $this->_db->quote((int)$id, 'INT');
		
		return $where;
	}
	
	/**
	 * Sets array of columns to check before manipulation.
	 * 
	 * @param array $columns Array of allowed column names to manipulate
	 * @return self
	 */
	public function setColumns($columns)
	{
		$this->_columns = $columns;
		
		return $this;
	}
	
	/**
	 * Sets flags for dateInserted, dateUpdated columns management.
	 * 
	 * @param mixed $insertDate	Whether to manage dateInserted column (string for alternate col name)
	 * @param mixed $updateDate	Whether to manage dateUpdated column (string for alternate col name)
	 * @return self
	 */
	public function setDateFlags($insertDate = null, $updateDate = null)
	{
		if (null !== $insertDate){
			$this->_saveInsertDate = $insertDate;
		}
		if (null !== $updateDate){
			$this->_saveUpdateDate = $updateDate;
		}
		
		return $this;
	}
	
	/**
	 * Return name of dateInserted column to use.
	 * 
	 * @return string
	 */
	public function getInsertDateCol()
	{
		if (is_string($this->_saveInsertDate)){
			return $this->_saveInsertDate;
		}
		elseif (true === $this->_saveInsertDate){
			return self::INSERT_DATE_COLUMN_DEFAULT;
		}
		return null;
	}
	
	/**
	 * Return name of dateUpdated column to use
	 * 
	 * @return string
	 */
	public function getUpdateDateCol()
	{
		if (is_string($this->_saveUpdateDate)){
			return $this->_saveUpdateDate;
		}
		elseif (true === $this->_saveUpdateDate){
			return self::UPDATE_DATE_COLUMN_DEFAULT;
		}
		return null;
	}
    

	/**
	 * update function
	 * 
	 * @param array $data
	 * @param unknown_type $where
	 * 
	 */
    public function update($data, $where)
    {
    	if ($this->_saveUpdateDate){
    		$data[$this->getUpdateDateCol()] = new Zend_Db_Expr('NOW()');
    	}
    	
    	return parent::update($this->getDataForDb($data), $where);
    }
    
    /**
     * Adds record to table.
     * 
     * @param	array	$data	Array of data to insert (will be filtered in getDataForDb()).
     * @return	int		The primary key of the row inserted.
     */
    public function insert($data)
    {
    	if ($this->_saveInsertDate)	{
    		$data[$this->getInsertDateCol()] = new Zend_Db_Expr('NOW()');
    	}
    	
    	if ($this->_saveUpdateDate){
    		$data[$this->getUpdateDateCol()] = new Zend_Db_Expr('NOW()');
    	}
    	    	
    	$id = parent::insert($data);
    	
    	return $this->getAdapter()->lastInsertId();
    }
    
    /**
     * Delete records from DB table
     * 
     * @param	int|string	$where	Id of record to delete, or WHERE statement.
     * @return	int			Number of rows deleted.
     */
    public function delete($where)
    {
    	if(is_numeric($where)){
    		$where = $this->getPrimaryWhere($where);
    	}
    	    	
    	return parent::delete($where);
    }
    
    /**
     * Safely quotes a value for an SQL statement 
     * Proxy for quote() in Zend_Db_Adapter
     * 
     * @see Zend_Db_Adapter_Abstract::quote()
     */
    public function quote($value, $type = null)
    {
    	return $this->_db->quote($value, $type);
    }
    
    /**
     * Quotes a value and places into a piece of text at a placeholder
     * Proxy for quoteInto() in Zend_Db_Adapter
     * 
     * @see Zend_Db_Adapter_Abstract::quoteInto()
     */
    public function quoteInto($text, $value, $type = null, $count = null)
    {
    	return $this->_db->quoteInto($text, $value, $type, $count);
    }
    
    /**
     * Returns a Y/N string value, given a boolean value.
     * Good for inserting boolean value into our enum('Y','N') fields.
     * 
     * @param	boolean	$value
     * @return	string
     */
    static function getYNBool($value)
    {
    	return (bool) $value ? 'Y' : 'N';
    }
    
    /**
     * Returns a MySQL-formatted datetime string.
     * 
     * @param $time	Timestamp to format (null for now)
     * @return string
     */
    static function datetime($time = null)
    {
    	return date('Y-m-d H:i:s', $time);
    }
    
	/**
	 * Handles a form image file upload.
	 * 
	 * @param string	$field File field name in form
	 * @return string	Path of temporary file.
	 */
	public function handleImageUpload($field)
	{
		$upload = new Zend_File_Transfer_Adapter_Http();
		
		if ($upload->isValid($field)){
			if ($upload->receive($field)){
				return $upload->getFileName($field);
			}
		}
		
		return null;
	}
		
	/**
	 * 
	 * 
	 * @param unknown_type $data
	 * @param unknown_type $searchFor
	 * @param unknown_type $searchIn
	 * @param unknown_type $order
	 * @param unknown_type $where
	 * @return NULL|Zend_Db_Table_Rowset_Abstract
	 */
	public function fetchByDataReference($data, $searchFor = null, $searchIn = null, $order = null, $where = null)
	{
		if (null === $searchFor){
			if (is_object($data) && method_exists($data, 'getPrimary')){
				$searchFor = $data->getPrimary();
			}
		}

		if (null === $searchIn){
			$searchIn = $this->getPrimary();
		}
		
		if (null === $searchFor || null === $searchIn){
			return null;
		}
		
		// i want an array
		if (is_object($data) && method_exists($data, 'toArray')){
			$data = $data->toArray();
		}
		
		$values = array();
		if (is_array($data)){
			// collect user ids
			foreach ($data as $item){
				if (isset($item[$searchFor])){
					$values[] = (int)$item[$searchFor];
				}
			}
		}
				
		if (empty($values)){
			return null;
		}
		
		$values = array_unique($values);
		
		$select = $this->select();
		$select->where($searchIn . ' IN (?)', $values);	
		
		if($where){
			if (is_array($where)){
				foreach ($where as $w){
					$select->where($w);
				}
			}
			else{
				$select->where($where);
			}
		}
		
		if ($order){
			$select->order($order);
		}
		
		$result = $this->fetchAll($select);
		
		return $result;
	}	
}
