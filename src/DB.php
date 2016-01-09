<?


namespace Rokfor;


/**
 * Rokfor DB
 * 
 *
 * @package Rokfor.DB
 * @author Urs Hofer
 */

class DB
{
  
  /**
   * Propel ServiceContainer
   *
   * @var string
   */
  private $serviceContainer;
  
  /**
   * Propel Manager
   *
   * @var string
   */
  private $manager;
    
  function __construct($host, $user, $pass, $dbname)
  {
    $this->serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
    $this->serviceContainer->checkVersion('2.0.0-dev');
    $this->serviceContainer->setAdapterClass('rokfor', 'mysql');
    $this->manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
    $this->manager->setConfiguration(array (
      'classname' => 'Propel\\Runtime\\Connection\\DebugPDO',
      'dsn' => 'mysql:host='.$host.';dbname='.$dbname.';unix_socket=/tmp/mysql.sock;',
      'user' => $user,
      'password' => $pass,
      'attributes' =>
      array (
        'ATTR_EMULATE_PREPARES' => false,
      ),
    ));
    $this->manager->setName('rokfor');
    $this->serviceContainer->setConnectionManager('rokfor', $this->manager);
    $this->serviceContainer->setDefaultDatasource('rokfor');
  }
  
  function ContributionsQuery() {
    return \ContributionsQuery::create();
  }

  function IssuesQuery() {
    return \IssuesQuery::create();
  }

  function DataQuery() {
    return \DataQuery::create();
  }

  
} // END class 

?>