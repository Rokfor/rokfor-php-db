<?

use Gregwar\Image\Image;

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
   * current user after login
   * required for all store actions
   *
   * @var string
   */
  private $currentUser;
  
  /**
   * Propel Manager
   *
   * @var string
   */
  private $manager;
  
  
  /**
   * Rights for a user
   *
   * @var array
   */
  private $rights;
    

  /**
   * paths for several upload actions
   *
   * @var array
   */
  private $paths;
    
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
    $this->currentUser = false;
    $this->paths = [
      'sys'       => __DIR__. '/../public/udb/',
      'systhumbs' => __DIR__. '/../public/udb/thumbs/',
      'web'       => '/udb/',
      'webthumbs' => '/udb/thumbs/',
      'thmbsuffix'=> '-thmb.jpg',
      'scaled'    => '-preview[*].jpg',
      'quality'   =>  75,
      'process'   => ['image/jpg', 'image/png', 'image/gif', 'image/tiff'],
      'store'     => ['application/zip', 'video/quicktime', 'video/mp4', 'video/webm', 'audio/mp3'],
      'icon'      => 'thumb.jpg'
    ];
  }
  
  private function RightsQuery() {
    return \RightsQuery::create();
  }  

  private function BooksQuery() {
    return \BooksQuery::create();
  }

  private function ContributionsQuery() {
    return \ContributionsQuery::create();
  }

  private function IssuesQuery() {
    return \IssuesQuery::create();
  }
  
  private function FormatsQuery() {
    return \FormatsQuery::create();
  }

  private function TemplatenamesQuery() {
    return \TemplatenamesQuery::create();
  }

  private function TemplatesQuery() {
    return \TemplatesQuery::create();
  }

  private function DataQuery() {
    return \DataQuery::create();
  }
  
  private function UsersQuery() {
    return \UsersQuery::create();
  }
  
  private function Contributions() {
    return new \Contributions();
  }
  
  function PDO() {
    return $this->serviceContainer->getConnection()->getWrappedConnection();
  }

  /**
   * update paths for file actions
   *
   * @param string $pSys 
   * @param string $pSysthumbs 
   * @param string $pWeb 
   * @param string $pWebthumbs 
   * @param string $thmbsuffix 
   * @return void
   * @author Urs Hofer
   */
  function updatePaths($pSys = false, $pSysthumbs = false, $pWeb = false, $pWebthumbs = false, $thmbsuffix = false, $scaled = false, $quality = false, $process = false, $store = false, $icon = false) {
    $this->paths = [
      'sys'       => $pSys        ? $pSys       : $this->paths['sys'],
      'systhumbs' => $pSysthumbs  ? $pSysthumbs : $this->paths['systhumbs'],
      'web'       => $pWeb        ? $pWeb       : $this->paths['web'],
      'webthumbs' => $pWebthumbs  ? $pWebthumbs : $this->paths['webthumbs'],
      'thmbsuffix'=> $thmbsuffix  ? $thmbsuffix : $this->paths['thmbsuffix'],
      'scaled'    => $scaled      ? $scaled     : $this->paths['scaled'],
      'quality'   => $quality     ? $quality    : $this->paths['quality'],
      'process'   => $process     ? $process    : $this->paths['process'],
      'store'     => $store       ? $store      : $this->paths['store'],
      'icon'      => $icon        ? $icon       : $this->paths['icon']
    ];    
  }
  
  /**
   * set user rights: Populates $this->rights and $this->currentUser
   *
   * @param Childobject\User $user 
   * @return void
   * @author Urs Hofer
   */
  function setUser($userid) {
    $user = $this->UsersQuery()->findPk($userid);
    if ($user) {
      $this->currentUser = $user;
      switch ($user->getUsergroup()) {
        case 'admin':
        case 'root':
          $this->rights = [
            "role"  =>  $user->getUsergroup(),
            "books"     => true,
            "issues"    => true,
            "templates" => true
          ];
          break;
        case 'user':
          // Rights Classes for current user
          $rights = $this->RightsQuery()
                                ->useRRightsForuserQuery()
                                  ->filterByUserid($identity['id'])
                                ->endUse()
                                ->find(); 
          foreach ($rights as $right) {
            $this->rights = [
                "role"  =>  $user->getUsergroup(),
                "books"     => $right->getBookss(),
                "issues"    => $right->getIssuess(),
                "templates" => $right->getTemplatenamess()
            ];
          } 
          break;
        default:
          $this->rights = null;
          break;
      }
    }
    else {
      $this->currentUser = false;
      $this->rights = null;      
    }
  }
  
  /**
   * returns a whole book/issue/chapter structure according to the
   * rights of the current user.
   *
   * @param string $url_prefix 
   * @return array
   * @author Urs Hofer
   */
  function getStructure($url_prefix) {
    $retval = [];
    foreach ($this->BooksQuery() as $book) {
      $i = [];
      if ($this->rights["books"] === true || (is_array($this->rights["books"]) && in_array($book, $this->rights["books"]))) {
        foreach ($book->getIssuess() as $issue) {
          $c = [];
          if ($this->rights["issues"] === true || (is_array($this->rights["issues"]) && in_array($issues, $this->rights["issues"]))) {
            foreach ($book->getFormatss() as $chapter) {
              $c[] = [
                "name"    => $chapter->getName(),
                "url"     => $url_prefix.$book->getId().'/'.$issue->getId().'/'.$chapter->getId()
              ];
            }
            $i[]  = [
              "name"      => $issue->getName(),
              "status"    => $issue->getStatus(),
              "chapters"  => $c
            ];
          }
        }
        $retval[] = [
          "name"  => $book->getName(),
          "issues"  => $i
        ];
      }
    }
    return $retval;
  }
  
  /**
   * return template id and name for a chapter
   * according to the current user
   *
   * @param string $format 
   * @return void
   * @author Urs Hofer
   */
  function getTemplates($format) {
    $retval = [];
    foreach ($this->TemplatenamesQuery()->filterByFormats($format) as $template) {
      if ($this->rights["templates"]=== true || is_array($this->rights["templates"]) && in_array($template, $this->rights["templates"])) {
        $retval[] = [
          "id"    => $template->getId(),
          "name"  => $template->getName()
        ];
      }
    }
    return $retval;
  }

  
  /**
   * reorder a bunch of contributions defined by their ids
   *
   * @param array $id 
   * @return bool
   * @author Urs Hofer
   */
  function ReorderContributions($ids) {
    if (!is_array($ids))
      return false;
    $_s = 0;
    foreach ($ids as $value) {
      $this->ContributionsQuery()
        ->findPk($value)
        ->setSort($_s++) 
        ->save(); 
    }    
    return true;
  }
  
  /**
   * delete a bunch of contributions defined by their ids or id
   *
   * @param mixed $id 
   * @return void
   * @author Urs Hofer
   */
  function DeleteContributions($ids) {
    $this->ContributionsQuery()
      ->filterById($ids)
      ->delete();
  }  
  
  /**
   * delete a bunch of contributions defined by their ids or id
   *
   * @param mixed $ids 
   * @param string $state 
   * @return void
   * @author Urs Hofer
   */
  function ChangeStateContributions($ids, $state) {
    if (!in_array($state, ['Open', 'Close', 'Deleted']))
      return false;
    $this->ContributionsQuery()
      ->filterById($ids)
      ->update(array('Status' => $state));
  }  
  
  /**
   * NewContribution
   * 
   * Adds a Contribution and Data Fields according to the given Template
   *
   * @param ChildIssues $issue 
   * @param ChildFormats $format 
   * @param int $templateid 
   * @param string $name 
   * @param string $status 
   * @return $this|\Contributions Contribution
   * @author Urs Hofer
   */
  function NewContribution($issue, $format, $templateid, $name = "Empty Contribution", $status = "Open") {
    if (!$this->currentUser)
      return false;
    $template = $this->TemplatenamesQuery()->findPk($templateid);
    if (!$template)
      return false;
    $c = new \Contributions();
    $c->setIssues($issue)
      ->setFormats($format)
      ->setTemplatenames($template)
      ->setStatus($status)
      ->setNewdate(time())
      ->setModdate(time())        
      ->setName($name)
      ->setUserSysRef($this->currentUser)
      ->save();
    $_sort = 0;
    foreach ($this->TemplatesQuery()->filterByTemplatenames($template)->orderBySort('asc') as $templatefield) {
      $d = new \Data();
      $d->setContributions($c)
        ->setTemplates($templatefield)
        ->setUserSysRef($this->currentUser)
        ->setSort($_sort)
        ->save();
      $_sort++;
    }
    return $c;
  }
  
  /**
   * undocumented function
   *
   * @param array $ids 
   * @param string $suffix 
   * @return void
   * @author Urs Hofer
   */
  function CloneContributions($ids, $suffix) {
    if (!is_array($ids))
      return false;    
    foreach ($ids as $id) {
      $c = $this->ContributionsQuery()->findPk($id);
      $new = $c->copy(true);
      $new
        ->setName($c->getName() . "[".$suffix."]")
        ->save();
    }
  }
    
    
  
  /**
   * DataStore
   * 
   * Stores the Data of a specific Field
   *
   * @param integer $id Data Field Primary Key
   * @param mixed $data Either jsonized string, plain string or $FILES array
   * @param string $action either NULL, add, delete or modify
   * @param string $idx 
   * @return void
   * @author Urs Hofer
   */
  function DataStore($id, &$data) {
    $field = \DataQuery::create()->findPk($id);
    if ($field) {
//      $field->setContent($value)->save();
    }
    else
      return false;
  }

  /**
   * FileStore
   *
   * Adds a upload to a Binary Field
   *
   * @author Urs Hofer
   * @param $id     Field id
   * @param $files  _FILES
   * @param $urls   Array populated with the processed urls
   * @return bool   True on success, false on error
   * @throws \Propel\Runtime\Exception\PropelException*
   */
  function FileStore(&$field, &$file, &$original_url, &$thumb_url) {
    if ($field) {
      $settings = json_decode($field->getTemplates()->getConfigSys(), true);
      $oldVal   = json_decode($field->getContent(), true);


      // Escape File Name
      $escapedFileName = preg_replace('/[^A-Za-z0-9ÄÖÜäöüÀÉÈèéà_\-\.]/', '_', $file->getClientFilename());
      $localFile = $this->paths['sys'].$escapedFileName;
      while (file_exists($localFile)) {
        $escapedFileName = time()."_".$escapedFileName;
        $localFile = $this->paths['sys'].$escapedFileName;
      }
      
      // Process
      if (in_array($file->getClientMediaType(), $this->paths['process'])) {
        $file->moveTo($localFile);
        // Thumbnail
        $thumb_url = $this->paths['systhumbs'].$escapedFileName.$this->paths['thmbsuffix'];
        \Image::open($localFile)
             ->resize(200, 100)
             ->save($thumb_url, 'jpg', $this->paths['quality']);

        $_copy = 0;        
        foreach ($settings['imagewidth'] as $key => $width) {
          $height = $settings['imageheight'][$key];
          // Resize and Copy to width and height
          $_ext = str_replace('[*]', $_copy++, $this->paths['scaled']);
          $_processfile = $localFile.$_ext;
            

        }
        $original_url = $escapedFileName;
      }
      // Move
      else if (in_array($file->getClientMediaType(), $this->paths['store'])) {
        $file->moveTo($localFile);
        $original_url = $escapedFileName;
        $thumb_url    = $this->paths['webthumbs'].$this->paths['icon'];
      }
      // Unknown Type
      else {
        $original_url = false;
        $thumb_url = false;
        return false;
      }
      // Attach to Data, Store
      
      array_push($oldVal, [$original_url,'caption']);
      $field->setContent(json_encode($oldVal))->save();

//      print_r($file->getClientFilename());
//      print_r($file->getSize());
//      print_r($file->getError());
//      print_r($file->getClientMediaType());
//      $field->setContent($value)->save();


      return true;
    }
    else
      return false;
  }


  /**
   * BinaryModify
   *
   * Adds a upload to a Binary Field
   * @param $id
   * @param array $tabledata
   * @param string $caption
   * @return bool
   */
  function FileModify($field, $tabledata) {
    if ($field) {
//      $field->setContent($value)->save();
      return true;
    }
    else
      return false;
  }
  
  /**
   * returns data object by id
   *
   * @param int $id 
   * @return Childobject\Data()
   * @author Urs Hofer
   */
  function getField($id) {
    return $this->DataQuery()->findPk($id);
  }

  /**
   * returns book object by id
   *
   * @param int $id 
   * @return Childobject\Book()
   * @author Urs Hofer
   */  
  function getBook($id) {
    return $this->BooksQuery()->findPk($id);
  }

  /**
   * returns Format object by id
   *
   * @param int $id 
   * @return Childobject\Format()
   * @author Urs Hofer
   */
  function getFormat($id) {
    return $this->FormatsQuery()->findPk($id);
  }

  /**
   * returns Issue object by id
   *
   * @param int $id 
   * @return Childobject\Issue()
   * @author Urs Hofer
   */
  function getIssue($id) {
    return $this->IssuesQuery()->findPk($id);
  }
  
  /**
   * returns Contributions Collection by issue and chapter
   *
   * @param int $id 
   * @return Childcollection\ContributionsQuery()
   * @author Urs Hofer
   */  
  function getContributions($issue, $chapter) {
    return $this->ContributionsQuery()
                ->filterByForissue($issue)
                ->filterByForchapter($chapter)
                ->orderBySort('asc');
  }

  /**
   * returns Contribution object by id
   *
   * @param int $id 
   * @return Childobject\Contribution()
   * @author Urs Hofer
   */  
  function getContribution($id) {
    return $this->ContributionsQuery()->findPk($id);
  }  

} // END class 

?>