<?


namespace Rokfor;


/**
* Description
*/
class DB
{
  
  /**
   * undocumented class variable
   *
   * @var string
   */
  private $db;
  
  
  function __construct($host, $user, $pass, $dbname)
  {
    try {
      $this->db = new \PDO('mysql:host='.$host.';dbname='.$dbname.';unix_socket=/tmp/mysql.sock;', $user, $pass);
      $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    } 
    catch(PDOException $e) {
      echo 'ERROR: ' . $e->getMessage();
      return false;
    }
    return true;
  }
  
  function getData($id) {
    /* Execute a prepared statement by passing an array of values */
    $sql = 'SELECT _data.id,_templates.id as t_id, _templates._fieldname, _templates._fieldtype, 
    _data._datatext as d_text,
    _data._databinary as d_binary,
    _data._datainteger as d_integer,
    _data.__parentnode__ FROM _data
    LEFT JOIN _templates ON _templates.id = _data._fortemplatefield
    WHERE _data._forcontribution = ? ORDER BY _data.__sort__';        
    $sth = $this->db->prepare($sql);
    $sth->execute(array($id));
    return $sth->fetchAll();
  }
  
}

?>