<?
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
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
    
  function __construct($host, $user, $pass, $dbname, $log)
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
    
    $defaultLogger = new \Monolog\Logger('defaultLogger');
    $defaultLogger->pushHandler(new \Monolog\Handler\StreamHandler($log, \Monolog\Logger::ERROR));
    $this->serviceContainer->setLogger('defaultLogger', $defaultLogger);
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
  
  private function LogQuery() {
    return \LogQuery::create();
  }
  
  function PDO() {
    return $this->serviceContainer->getConnection()->getWrappedConnection();
  }

  /**
   * deletes an array of files, inclusive possible thumbs and previews
   *
   * @param string $delete 
   * @return void
   * @author Urs Hofer
   */
  private function DeleteFiles($delete) {
    foreach ($delete as $file) {
      // Thumb
      @unlink($this->paths['systhumbs'].$file.$this->paths['thmbsuffix']);
      // Original
      @unlink($this->paths['sys'].$file);      
      // Scaled Versions
      foreach (glob($this->paths['sys'].$file."*") as $filename) {
        @unlink($filename);      
      }
    }
  }
  
  /**
   * copies a file inclusive thumbs and scaled versions, returns the new filename
   *
   * @param string $delete 
   * @return void
   * @author Urs Hofer
   */
  private function CopyFiles($filename) {
    $parts = pathinfo($filename);
    $copy_suffix = uniqid("_");
    $newname = $parts['filename'].$copy_suffix.'.'.$parts['extension'];
    // Thumb
    @copy($this->paths['systhumbs'].$filename.$this->paths['thmbsuffix'], $this->paths['systhumbs'].$newname.$this->paths['thmbsuffix']);
    // Original
    @copy($this->paths['sys'].$filename, $this->paths['sys'].$newname);      
    // Scaled Versions
    foreach (glob($this->paths['sys'].$filename."*") as $scaled) {
      $new_scaled = str_replace($filename, $newname, $scaled);
      @copy($scaled, $new_scaled);
    }
    return $newname;
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
   * return user object
   *
   * @return void
   * @author Urs Hofer
   */
  function getUser() {
    if (!$this->currentUser) return false;
    $level = false;
    switch ($this->currentUser->getUsergroup()) {
      case 'user':
        $level = 1;
        break;
      case 'admin':
        $level = 2;
        break;    
      case 'root':
        $level = 3;
        break;              
      default:
        $level = 0;
        break;
    }
    return [
      "id"        => $this->currentUser->getId(),
      "username"  => $this->currentUser->getUsername(), 
      "level"     => $level,
      "role"      => $this->currentUser->getUsergroup(), 
      "email"     => $this->currentUser->getFilerights(), 
      "api"       => $this->currentUser->getPluginrights(), 
      "group"     => $this->currentUser->getRightss()->toArray()
    ];
    
  }
  
  
  /**
   * returns all users - only if logged in as root
   *
   * @return void
   * @author Urs Hofer
   */
  function getUsers() {
    if ($this->currentUser->getUsergroup() == "root")
      return $this->usersQuery();
    else 
      return false;
  }
  
  /**
   * creates a new user
   *
   * @return void
   * @author Urs Hofer
   */
  function newUser() {
    return new \Users();
  }  
  
  /**
   * checks the password of the current user
   *
   * @param string $pw 
   * @return void
   * @author Urs Hofer
   */
  function checkPassword($pw) {
    return md5($pw) == $this->currentUser->getPassword();
  }
  
  /**
   * password quality 
   *
   * @param string $pwd 
   * @param string $errors 
   * @return void
   * @author Urs Hofer
   */
  private function checkPasswordStrength($pwd, &$errors) {
    $errors_init = $errors;
    if (strlen($pwd) < 8) {
        $errors[] = "password_too_short";
    }

    if (!preg_match("#[0-9]+#", $pwd)) {
        $errors[] = "password_atleast_number";
    }

    if (!preg_match("#[a-zA-Z]+#", $pwd)) {
        $errors[] = "password_atleast_letter";
    }     
    return ($errors == $errors_init);
  }
  
  /**
   * sets a new passwor the password of the current user
   *
   * @param string $pw 
   * @return void
   * @author Urs Hofer
   */
  function updatePassword($pw, $new1, $new2, &$error) {
    if ($new1 <> $new2) {
      $error[] = 'profile_error_pwnotmatch';
      return false;
    }
    if (!$this->checkPasswordStrength($new1, $error)) {
      return false;
    }
    if ($new1 == $pw) {
      $error[] = 'profile_error_pwsameasold';
      return false;
    }
    if (!$this->checkPassword($pw)) {
      $error[] = 'profile_error_oldpwwrong';
      return false;
    }
    $this->currentUser->setPassword(md5($new1))->save();
    return true;
  }  
  
  /**
   * sets a new passwor the password of the current user
   *
   * @param string $pw 
   * @return void
   * @author Urs Hofer
   */
  function updateProfile($name, $mail, $api,  &$error) {
    if (strlen($name) < 3) {
      $error[] = 'profile_error_nameempty';
      return false;
    }
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
      $error[] = 'profile_error_mail';
      return false;
    }    
    if ($this->UsersQuery()->filterByUsername($name)->count() > 0 && $name <> $this->currentUser->getUsername()) {
      $error[] = 'profile_error_usernameexists';
      return false;
    }
    $this
      ->currentUser
      ->setUsername($name)
      ->setFilerights($mail)
      ->setPluginrights($api)
      ->save();
    return true;
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
            "templates" => true,
            "formats"   => true
          ];
          break;
        case 'user':
          // Rights Classes for current user
          $rights = $this->RightsQuery()
                                ->useRRightsForuserQuery()
                                  ->filterByUserid($userid)
                                ->endUse()
                                ->find(); 
          foreach ($rights as $right) {
            $this->rights = [
                "role"  =>  $user->getUsergroup(),
                "books"     => $right->getBookss(),
                "issues"    => $right->getIssuess(),
                "templates" => $right->getTemplatenamess(),
                "formats"   => $right->getFormatss()
            ];
          } 
          break;
        default:
          $this->rights = null;
          break;
      }
      return true;
    }
    else {
      $this->currentUser = false;
      $this->rights = null;      
      return false;
    }
  }
  
  /**
   * returns a templatenames Query order by sort
   *
   * @return \Childobject\Template
   * @author Urs Hofer
   */
  function getTemplatenames() {
    return $this->TemplatenamesQuery()
                ->orderBySort('asc');
  }

  /**
   * returns a templatenames Object by PK
   *
   * @param int $id
   * @return \Childobject\Template
   * @author Urs Hofer
   */
  function getTemplatename($id) {
    return $this->TemplatenamesQuery()
                ->findPk($id);
  }
  
  /**
   * returns a formats Query
   *
   * @return \Childobject\Template
   * @author Urs Hofer
   */  
  function getFormats() {
    return $this->FormatsQuery();
  }
  
  /**
   * returns rights query
   *
   * @return void
   * @author Urs Hofer
   */
  function getRights() {
    return $this->RightsQuery();
  }  
  
  /**
   * returns book object by id
   *
   * @param int $id 
   * @return Childobject\Book()
   * @author Urs Hofer
   */  
  function getRight($id) {
    return $this->RightsQuery()->findPk($id);
  }

  /**
   * adds a right
   *
   * @return void
   * @author Urs Hofer
   */
  function newRight() {
    return new \Rights();
  }  
  
  /**
   * returns a whole book/issue/chapter structure according to the
   * rights of the current user.
   * valid_paths is an array containing the md5 checksum as a key and
   * the corresponding chapter/issue/book name as value.
   * it can be used to check log file entries and to keep them up to date
   * even if the naming changed afterwards.
   *
   * @param string $url_prefix 
   * @return array
   * @author Urs Hofer
   */
  function getStructure($url_prefix, $bookid = false, &$valid_paths = []) {
    $criteria = new \Propel\Runtime\ActiveQuery\Criteria();
    $criteria->addAscendingOrderByColumn(__sort__);  
    $retval = [];
    
    $books = $this->BooksQuery()
                  ->_if($bookid)
                    ->filterById($bookid)
                  ->_endif()
                  ->orderBySort('asc');
        
    foreach ($books as $book) {
      $i = [];
      if ($this->rights["books"] === true || (is_object($this->rights["books"]) && in_array($book->getId(), $this->rights["books"]->getPrimaryKeys()))) {
        foreach ($book->getIssuess($criteria) as $issue) {
          $c = [];
          if ($this->rights["issues"] === true || (is_object($this->rights["issues"]) && in_array($issue->getId(), $this->rights["issues"]->getPrimaryKeys()))) {
            foreach ($book->getFormatss($criteria) as $chapter) {
              if ($this->rights["formats"] === true || (is_object($this->rights["formats"]) && in_array($chapter->getId(), $this->rights["formats"]->getPrimaryKeys()))) {
                $c[] = [
                  "chapter" => $chapter,
                  "name"    => $chapter->getName(),
                  "url"     => $url_prefix.$book->getId().'/'.$issue->getId().'/'.$chapter->getId()
                ];
                $valid_paths[md5($url_prefix.$book->getId().'/'.$issue->getId().'/'.$chapter->getId())] = [
                  "chapter" => $chapter->getName(),
                  "book"    => $book->getName(),
                  "issue"   => $issue->getName(),
                  "url"     => $url_prefix.$book->getId().'/'.$issue->getId().'/'.$chapter->getId()
                ];
              }
            }
            $i[]  = [
              "issue"     => $issue,
              "name"      => $issue->getName(),
              "status"    => $issue->getStatus(),
              "chapters"  => $c
            ];
          }
        }
        $retval[] = [
          "book"  => $book,
          "name"  => $book->getName(),
          "issues"  => $i,
          "chapters"  => $c
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
      if ($this->rights["templates"]=== true || (is_object($this->rights["templates"]) && in_array($template->getId(), $this->rights["templates"]->getPrimaryKeys()))) {
        $retval[] = [
          "id"    => $template->getId(),
          "name"  => $template->getName()
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
  function getTemplatefields() {
    return $this->TemplatesQuery();
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
   * check if there are binaries linked to the files and delete them
   * from the server as well (call FileModify with empty data)
   *
   * @param mixed $id 
   * @return void
   * @author Urs Hofer
   */
  function DeleteContributions($ids) {
    foreach ($ids as $id) {
      $c = $this->ContributionsQuery()->findPk($id);
      $this->deleteData($c);
    }
    $this->ContributionsQuery()
      ->filterById($ids)
      ->delete();
  }  
  
  /**
   * change the state a bunch of contributions defined by their ids or id
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
    $last = $this->getContributions($issue->getId(), $format->getId(), 'desc')->findOne();
    if ($last)
      $_newsort = $last->getSort()+1;
    else
      $_newsort = 0;
    if (!$template)
      return false;
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
      ->setSort($_newsort)
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
      $this->duplicateData($new);
    }
  }
    
  /**
   * Import Data from one contribution into another of the same type
   *
   * @param int $sourceid
   * @param int $destinationid
   * @return void
   * @author Urs Hofer
   */
  function ImportContribution($sourceid, $destinationid) {
    $_c = $this->getContribution($destinationid);    
    $_source = $this->getContribution($sourceid);
    if ($_source && $_c->getFortemplate() == $_source->getFortemplate()) {
      $_olddata = [];
      foreach ($_source->getDatas() as $_data) {
        $_olddata[$_data->getFortemplatefield()] = $_data->getContent();
      }
      foreach ($_c->getDatas() as $_data) {
        $_data
          ->setContent($_olddata[$_data->getFortemplatefield()])
          ->save();
      }
      return $_source->getName();
    }
    else {
      return false;
    }
  }
  
  /**
   * Changes a Template of a contribution and delete/adds fields
   *
   * @param int $sourceid
   * @param int $destinationid
   * @return void
   * @author Urs Hofer
   */
  function ChangeTemplateContribution($contributionid, $templateid) {

    $criteria = new \Propel\Runtime\ActiveQuery\Criteria();
    $criteria->addAscendingOrderByColumn(__sort__);
    $_template = $this->TemplatenamesQuery()->findPk($templateid);
    $_c = $this->getContribution($contributionid);   
    $_oldfields = $_c->getDatas($criteria); 
    $_newfields = $_template->getTemplatess($criteria);

    if ($_template) {
      // Delete Fields which are not used anymore
      $_delcount = 0;
      $_addcount = 0;
      $_modcount = 0;
      if (count($_oldfields) > count($_newfields)) {
        for ($delfield=count($_newfields); $delfield < count($_oldfields); $delfield++) { 
          $this->deleteField($_oldfields[$delfield]);
          $_delcount++;
        }
      }
      // Fields of new Template
      $_sort = 0;      
      foreach ($_newfields as $templatefield) {
        // Use old
        if ($_oldfields[$_sort]) {
          if ($_oldfields[$_sort]->getTemplates()->getFieldtype() == 'Bild' && 
          $_oldfields[$_sort]->getTemplates()->getFieldtype() != $templatefield->getFieldtype()) {
            $this->FileModify($_oldfields[$_sort]->getId(), []);
          }
          $d = $_oldfields[$_sort];
          $_modcount++;
        }
        // Insert if not existing
        else {
          $d = new \Data();
          $_addcount++;
        }
        $d->setContributions($_c)
          ->setTemplates($templatefield)
          ->setUserSysRef($this->currentUser)
          ->setSort($_sort)
          ->save();
        $_sort++;        
      }
      // Update contributions reference
      $_c->setTemplatenames($_template)->save();
      return $_template->getName()." [+] $_addcount [-] $_delcount / [m] $_modcount";
    }
    else {
      return false;
    }
  }
  
  /**
   * FileStore
   *
   * Adds a upload to a Binary Field
   *
   * @author Urs Hofer
   * @param $fieldid     Field id
   * @param $files  PSR-7 Files Request
   * @param $urls   Array populated with the processed urls
   * @return bool   True on success, false on error
   * @throws \Propel\Runtime\Exception\PropelException*
   */
  function FileStore($fieldid, &$file, &$original_url, &$thumb_url, &$caption, $default_caption = 'Caption') {
    $field = $this->getField($fieldid);
    if ($field) {
      $settings = json_decode($field->getTemplates()->getConfigSys(), true);
      $oldVal   = json_decode($field->getContent(), true);
      if (!$oldVal) {
        $oldVal = [];
      }
      $caption = $default_caption;
      if ($settings["growing"]==false) {
        $caption = $oldVal[0][0] ? $oldVal[0][0] : $default_caption;
        $oldVal = [];
        $this->FileModify($fieldid, $oldVal);
      }

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
        $image = new \Eventviva\ImageResize($localFile);
        $image->quality_jpg = $this->paths['quality'];
        $image->resizeToBestFit(150,100);            
        $image->save($this->paths['systhumbs'].$escapedFileName.$this->paths['thmbsuffix'], IMAGETYPE_JPEG);
        $thumb_url = $this->paths['webthumbs'].$escapedFileName.$this->paths['thmbsuffix'];
        $_copy = 0;        
        foreach ($settings['imagesize'] as $size_per_image) {
          $width = $size_per_image['width'];
          $height = $size_per_image['height'];
          // Resize and Copy to width and height
          $_ext = str_replace('[*]', $_copy++, $this->paths['scaled']);
          $_processfile = $localFile.$_ext;

          if ($height==0)
            $image->resizeToWidth($width);
          elseif ($width==0)
            $image->resizeToHeight($height);
          else
            $image->resizeToBestFit($width,$height);            
          $image->save($_processfile, IMAGETYPE_JPEG);        
            

        }
        $original_url = $escapedFileName;
      }
      // Move & Create a fake thumbnail
      else if (in_array($file->getClientMediaType(), $this->paths['store'])) {
        $file->moveTo($localFile);
        $original_url = $escapedFileName;
        copy($this->paths['systhumbs'].$this->paths['icon'], $this->paths['systhumbs'].$escapedFileName.$this->paths['thmbsuffix']);
        $thumb_url = $this->paths['webthumbs'].$escapedFileName.$this->paths['thmbsuffix'];
      }
      // Unknown Type
      else {
        $original_url = false;
        $thumb_url = false;
        return false;
      }
      // Attach to Data, Store
      
      array_push($oldVal, [$caption, $original_url]);
      $field->setContent(json_encode($oldVal))->save();



      return true;
    }
    else
      return false;
  }


  /**
   * BinaryModify
   *
   * Adds a upload to a Binary Field
   * @param int $fieldid
   * @param json $tabledata
   * @param string $caption
   * @return bool
   */
  function FileModify($fieldid, $tabledata) {
    $field = $this->getField($fieldid);
    if (!is_array($tabledata))
      $tabledata = [];
    if ($field) {
      $olddata  = json_decode($field->getContent(), true);
      $images = [];
      // Get Files to Delete
      foreach ($tabledata as $i) $images[] = $i[1];
      $delete = [];
      if (is_array($olddata)) {
        foreach ($olddata as $oldimage) {
          if (!in_array($oldimage[1], $images))
            $delete[] = $oldimage[1];
        };
        $this->DeleteFiles($delete);
      }      
//      print_r($delete);
//      print_r($newdata);      
//      print_r($olddata);      
      $field->setContent(json_encode($tabledata))->save();
      return true;
    }
    else
      return false;
  }
  
  /**
   * setField
   * 
   * Stores the Data of a specific Field
   * If the field has a json attribut set to true and the data is of type object
   * or array, the data will be transformed into a json string before save.
   *
   * @param integer $fieldid Data Field Primary Key
   * @param mixed $data Either jsonized string, plain string or $FILES array
   * @param string $action either NULL, add, delete or modify
   * @param string $idx 
   * @return void
   * @author Urs Hofer
   */
  function setField($fieldid, &$data) {
    $field = $this->getField($fieldid);
    if ($field) {
      $tname = $field->getTemplates()->getTemplatenames();
      $access = ($this->rights["templates"]=== true || is_array($this->rights["templates"]) && in_array($tname, $this->rights["templates"]));
      if ($access) {
        if ($field->getIsjson() == true && (is_array($data) || is_object($data))) {
          $data = json_encode($data);
        }
        $field->setContent($data)->save();
        return true;
      }
    }
    else
      return false;
  }
  
  /**
   * deletes a field, and if it is of binary type, the associated files as well
   *
   * @param \Childobject\Field $field 
   * @return void
   * @author Urs Hofer
   */
  function deleteField($field) {
    if ($field->getTemplates()->getFieldtype() == "Bild") {
      $this->FileModify($field->getId(), []);
    }
    $field->delete();
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
   * returns all books
   *
   * @param int $id 
   * @return Childobject\Book()
   * @author Urs Hofer
   */  
  function getBooks() {
    return $this->BooksQuery();
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
   * returns all Issues
   *
   * @param int $id 
   * @return Childobject\Issue()
   * @author Urs Hofer
   */
  function getIssues() {
    return $this->IssuesQuery();
  }  
  
  /**
   * returns Contributions Collection by issue and chapter
   *
   * @param int $issueid
   * @param int $chapterid 
   * @return Childcollection\ContributionsQuery()
   * @author Urs Hofer
   */  
  function getContributions($issueid, $chapterid, $sort = 'asc') {
    return $this->ContributionsQuery()
                ->filterByForissue($issueid)
                ->filterByForchapter($chapterid)
                ->orderBySort($sort);
  }
  
  /**
   * returns all contributions matching string in the name
   *
   * @param string $string 
   * @return ChildCollection\ContributionsQuery()
   * @author Urs Hofer
   */
  function searchContributions($string) {
    return $this->ContributionsQuery()
                ->distinct()
                ->filterByName('%'.$string.'%')
                ->_or()
                  ->useDataQuery()
                  ->filterByContent('%'.$string.'%')
                  ->endUse()
                ->orderByName();
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
  
  /**
   * returns all contributions with a certain template
   *
   * @param Childobject\Template() $template 
   * @return collection contributions
   * @author Urs Hofer
   */
  function getContributionsByTemplate($template) {
    return $this->ContributionsQuery()->filterByTemplatenames($template);
  }
  
  /**
   * return all templatenames of a certain chapter
   *
   * @param Childobject\Chapter() $chapter 
   * @return collection templatenames
   * @author Urs Hofer
   */
  function getTemplatenamesByFormats($chapter) {
    return $this->TemplatenamesQuery()->filterByFormats($chapter)->orderByName();
  }
  
  /**
   * adds a message into the log for the current user
   *
   * @param string $message 
   * @return collection LogQuery
   * @author Urs Hofer
   */
  function addLog($type, $message, $ip) {
    $log = new \Log();
    $log->setUser($this->currentUser->getId())
        ->setIp($ip)
        ->setAgent($type)
        ->setDate(time())
        ->setConfigSys($message)
        ->save();
  }
  
  /**
   * returns a log entries by type and latest date, optionally filtered by a callback
   * which is applied on the __config__ field.
   *
   * @param string $type 
   * @return collection LogQuery
   * @author Urs Hofer
   */
  function getRecentLog($type = 'get_contributions', $callback = false, $limit = 4) {
    if (!$this->currentUser) return false;
    // SELECT __config__, MAX(_date) as date FROM _log GROUP BY __config__ ORDER BY date DESC
    $log = $this->LogQuery()
         ->filterByAgent($type)
         ->filterByUser($this->currentUser->getId())
         ->select('__config__')
         ->withColumn('MAX(_log._date)', 'date')
         ->groupBy('_log.__config__')
         ->orderBy('date', 'desc');
    return $this->applyCallbackAndLimitToLog($log, $callback, $limit);
  }
  
  /**
   * returns a log entries by type and max count of usage, optionally filtered by a callback
   * which is applied on the __config__ field.
   *
   * @param string $type 
   * @return collection LogQuery
   * @author Urs Hofer
   */  
  function getFavouriteLog($type = 'get_contributions', $callback = false, $limit = 10) {
    if (!$this->currentUser) return false;

    //SELECT __config__, count(__config__) AS count FROM _log WHERE _agent ="get_contributions" GROUP BY __config__ ORDER BY count DESC
    $log = $this->LogQuery()
           ->filterByAgent($type)
             ->filterByUser($this->currentUser->getId())
           ->select('__config__')
           ->withColumn('COUNT(_log.__config__)', 'count')
           ->groupBy('_log.__config__')
           ->orderBy('count', 'desc');
    return $this->applyCallbackAndLimitToLog($log, $callback, $limit);
  }

  /**
   * callback wrapper function applied to the logfile
   *
   * @param string $type 
   * @return collection LogQuery
   * @author Urs Hofer
   */
  private function applyCallbackAndLimitToLog($log, $callback, $limit) {
    $retval = [];
    foreach ($log as $data) {
      if ($callback) {
        $data['__config__'] = $callback($data['__config__']);
        if ($data['__config__']) {
         $retval[] = $data;
        }
      }
      else $retval[] = $data;
      if (count($retval)==$limit) break;
    }
    return $retval;
  }
  
  
  /**
   * adds a book
   *
   * @param string $name 
   * @return void
   * @author Urs Hofer
   */
  function addBook($name) {
    $last =  $this->BooksQuery()
                  ->orderBySort('desc')
                  ->findOne();
    if ($last)
      $_newsort = $last->getSort()+1;
    else
      $_newsort = 0;
    
    $c = new \Books();
    $c->setName($name)
      ->setUserSysRef($this->currentUser)      
      ->setSort($_newsort)
      ->save();
  }

  /**
   * adds an issue
   *
   * @param string $name 
   * @param int $forbook 
   * @param string $status 
   * @return void
   * @author Urs Hofer
   */
  function addIssue($name, $forbook, $status = 'open') {
    $last =  $this->IssuesQuery()
                  ->orderBySort('desc')
                  ->findOne();
    if ($last)
      $_newsort = $last->getSort()+1;
    else
      $_newsort = 0;
    
    $c = new \Issues();
    $c->setName($name)
      ->setForbook($forbook)
      ->setStatus($status)
      ->setUserSysRef($this->currentUser)        
      ->setSort($_newsort)
      ->save();
  }

  /**
   * sets the issue state to open
   *
   * @param int $id 
   * @return void
   * @author Urs Hofer
   */
  function openIssue($id) {
    $this->getIssue($id)
         ->setStatus("open")
         ->save();
  }

  /**
   * sets the issue state to close
   *
   * @param int $id 
   * @return void
   * @author Urs Hofer
   */
  function closeIssue($id) {
    $this->getIssue($id)
         ->setStatus("closed")
         ->save();
  }
  
  /**
   * adds a chapter
   *
   * @param string $name 
   * @param int $forbook 
   * @return void
   * @author Urs Hofer
   */
  function addChapter($name, $forbook) {
    $last =  $this->FormatsQuery()
                  ->orderBySort('desc')
                  ->findOne();
    if ($last)
      $_newsort = $last->getSort()+1;
    else
      $_newsort = 0;
    
    $c = new \Formats();
    $c->setName($name)
      ->setForbook($forbook)
      ->setUserSysRef($this->currentUser)        
      ->setSort($_newsort)
      ->save();    
  }

  /**
   * stores the sort order of an array of books
   *
   * @param array $sortarray
   * @return void
   * @author Urs Hofer
   */
  function sortBook($sortarray) {
    if (!is_array($sortarray))
      return false;
    foreach ($sortarray as $sort=>$id) {
      $this->BooksQuery()
        ->findPk($id)
        ->setSort($sort) 
        ->save(); 
    }
  }

  /**
   * stores the sort order of an array of issues
   *
   * @param array $sortarray
   * @return void
   * @author Urs Hofer
   */
  function sortIssue($sortarray) {
    if (!is_array($sortarray))
      return false;
    foreach ($sortarray as $sort=>$id) {
      $this->IssuesQuery()
        ->findPk($id)
        ->setSort($sort) 
        ->save(); 
    }
  }

  /**
   * stores the sort order of an array of chapters
   *
   * @param array $sortarray
   * @return void
   * @author Urs Hofer
   */
  function sortChapter($sortarray) {
    if (!is_array($sortarray))
      return false;
    foreach ($sortarray as $sort=>$id) {
      $this->FormatsQuery()
        ->findPk($id)
        ->setSort($sort) 
        ->save(); 
    }    
  }

  /**
   * renames a book
   *
   * @param int $id 
   * @param string $name
   * @return void
   * @author Urs Hofer
   */  
  function renameBook($id, $name) {
    $this->getBook($id)
         ->setName($name)
         ->save();
  }

  /**
   * change rights of a book
   *
   * @param int $id 
   * @param string $name
   * @return void
   * @author Urs Hofer
   */  
  function rightsBook($id, $rights) {
    $b = $this->getBook($id);
    foreach($b->getRightss() as $f) {$b->removeRights($f);}

    // Cycle thru form values and store them
    foreach ($rights as $value) {
      $b->addRights($this->getRight($value["value"]));
    }
    $b->save();
  }

  /**
   * renames an issue
   *
   * @param int $id 
   * @param string $name
   * @return void
   * @author Urs Hofer
   */
  function renameIssue($id, $name) {
    $this->getIssue($id)
         ->setName($name)
         ->save();    
  }
  
  /**
   * change rights of a issue
   *
   * @param int $id 
   * @param string $name
   * @return void
   * @author Urs Hofer
   */  
  function rightsIssue($id, $rights) {
    $b = $this->getIssue($id);
    foreach($b->getRightss() as $f) {$b->removeRights($f);}

    // Cycle thru form values and store them
    foreach ($rights as $value) {
      $b->addRights($this->getRight($value["value"]));
    }
    $b->save();
  }  

  /**
   * renames a chapter
   *
   * @param int $id 
   * @param string $name
   * @return void
   * @author Urs Hofer
   */
  function renameChapter($id, $name) {
    $this->getFormat($id)
         ->setName($name)
         ->save();        
  }
  
  /**
   * change rights of a issue
   *
   * @param int $id 
   * @param string $name
   * @return void
   * @author Urs Hofer
   */  
  function rightsChapter($id, $rights) {
    $b = $this->getFormat($id);
    foreach($b->getRightss() as $f) {$b->removeRights($f);}

    // Cycle thru form values and store them
    foreach ($rights as $value) {
      $b->addRights($this->getRight($value["value"]));
    }
    $b->save();
  }    

  /**
   * deletes a book with all content and binaries
   *
   * @param int $id 
   * @return void
   * @author Urs Hofer
   */
  function deleteBook($id) {
    foreach ($this->IssuesQuery()->filterByForbook($id) as $issue) {
      foreach ($this->ContributionsQuery()->filterByIssues($issue) as $contribution) {
          $this->deleteData($contribution);
      }
    }
    $this->getBook($id)
         ->delete();
  }

  /**
   * deletes a issue with all content and binaries
   *
   * @param int $id 
   * @return void
   * @author Urs Hofer
   */
  function deleteIssue($id) {
    foreach ($this->ContributionsQuery()->filterByForissue($id) as $contribution) {
      $this->deleteData($contribution);
    }    
    $this->getIssue($id)
         ->delete();    
  }

  /**
   * deletes a chapter with all content and binaries
   *
   * @param int $id 
   * @return void
   * @author Urs Hofer
   */
  function deleteChapter($id) {
    foreach ($this->ContributionsQuery()->filterByForchapter($id) as $contribution) {
      $this->deleteData($contribution);
    }
    $this->getFormat($id)
         ->delete();        
  }
  
  /**
   * duplicates a book with all content
   *
   * @param int $id 
   * @param string $suffix 
   * @return void
   * @author Urs Hofer
   */  
  function duplicateBook($id, $suffix = "Copy") {
    $new = $this->getBook($id)
                ->copy(true);
    $new
      ->setName($new->getName() . "[".$suffix."]")
      ->save();  
    /* Not necessary. Deep copy of books copy only direct affiliated data 
    foreach ($this->IssuesQuery()->filterByForbook($new->getId()) as $issue) {
      foreach ($this->ContributionsQuery()->filterByIssues($issue) as $contribution) {
        $this->duplicateData($contribution);
      }
    }*/
    
  }

  /**
   * duplicates a issue with all content if deep is true
   *
   * @param int $id 
   * @param string $suffix 
   * @param bool $deep
   * @return void
   * @author Urs Hofer
   */
  function duplicateIssue($id, $suffix = "Copy", $deep = true) {
    $new = $this->getIssue($id)
                ->copy($deep);
    $new
      ->setName($new->getName() . "[".$suffix."]")
      ->save();  

    foreach ($this->ContributionsQuery()->filterByForissue($new->getId()) as $contribution) {
      $this->duplicateData($contribution);
    }
  }

  /**
   * duplicates a chapter with all content
   *
   * @param int $id 
   * @param string $suffix 
   * @return void
   * @author Urs Hofer
   */
  function duplicateChapter($id, $suffix = "Copy", $deep = true) {
    $new = $this->getFormat($id)
                ->copy($deep);
    $new
      ->setName($new->getName() . "[".$suffix."]")
      ->save(); 
    
    foreach ($this->ContributionsQuery()->filterByForchapter($new->getId()) as $contribution) {
      $this->duplicateData($contribution);
    }
  }
  
  /**
   * adds a template (without any fields)
   *
   * @param string $name 
   * @return void
   * @author Urs Hofer
   */
  function addTemplates($name) {
    $last =  $this->TemplatenamesQuery()
                  ->orderBySort('desc')
                  ->findOne();
    if ($last)
      $_newsort = $last->getSort()+1;
    else
      $_newsort = 0;
    
    $c = new \Templatenames();
    $c->setName($name)
      ->setSort($_newsort)
      ->save();
  }
  
  /**
   * renames a template
   *
   * @param string $name 
   * @return void
   * @author Urs Hofer
   */  
  function renameTemplates($id, $name) {
    $this->TemplatenamesQuery()
         ->findPk($id)
         ->setName($name)
         ->save();
  }
  
  /**
   * deletes a template and all contributions attached to it
   *
   * @param string $name 
   * @return void
   * @author Urs Hofer
   */  
  function deleteTemplates($id) {
    foreach ($this->ContributionsQuery()->filterByFortemplate($id) as $contribution) {
        $this->deleteData($contribution);
    }
    $this->TemplatenamesQuery()
         ->findPk($id)
         ->delete();
  }
  
  /**
   * duplicates a template
   *
   * @param string $name 
   * @return void
   * @author Urs Hofer
   */  
  function duplicateTemplates($id, $suffix = "Copy") {
    $new = $this->TemplatenamesQuery()
                ->findPk($id)
                ->copy(true);
    $new
      ->setName($new->getName() . "[".$suffix."]")
      ->save();     
  }  
  
  /**
   * renames a template
   *
   * @param string $name 
   * @return void
   * @author Urs Hofer
   */  
  function updateTemplates($id, $data) {
    $t = $this->TemplatenamesQuery()->findPk($id);
    // Clear all relations first
    foreach($t->getFormatss() as $f) {$t->removeFormats($f);}
    foreach($t->getBookss() as $f) {$t->removeBooks($f);}
    foreach($t->getRightss() as $f) {$t->removeRights($f);}

    // Cycle thru form values and store them
    foreach ($data as $value) {
      if ($value["name"] == "Formats") {
        $t->addFormats($this->getFormat($value["value"]));
      }
      elseif ($value["name"] == "Books") {
        $t->addBooks($this->getBook($value["value"]));
      }      
      elseif ($value["name"] == "Rights") {
        $t->addRights($this->getRight($value["value"]));
      }            
      elseif ($value["name"] == "Public") {
        $t->setPublic($value["value"] == "on" ? "true" : "false");
      }
      else {
        $t->{"set".$value["name"]}($value["value"]);
      }
    }
    $t->save();
  }
  

  /**
   * adds a field into a template
   *
   * @param int $fortemplate 
   * @param string $name 
   * @return void
   * @author Urs Hofer
   */
  function addTemplatefield($fortemplate, $name, $type = "Text") {
    $last =  $this->TemplatesQuery()
                  ->orderBySort('desc')
                  ->findOne();
    if ($last)
      $_newsort = $last->getSort()+1;
    else
      $_newsort = 0;
    
    $t = new \Templates();
    $t->setFieldname($name)
      ->setFieldtype($type)
      ->setFortemplate($fortemplate)
      ->setSort($_newsort)
      ->save();
    
    // Add the field to the contributions
    foreach ($this->ContributionsQuery()->filterByFortemplate($fortemplate) as $c) {
      $d = new \Data();
      $d->setContributions($c)
        ->setTemplates($t)
        ->setUserSysRef($this->currentUser)
        ->setSort($_newsort)
        ->save();
    }
    
  }
  
  /**
   * deletes a field. if it's a binary field, deletes binaries first.
   * data related in contributions are deleted via mysql delete constraint
   *
   * @param string $name 
   * @return void
   * @author Urs Hofer
   */  
  function deleteTemplatefield($id) {
    $f = $this->TemplatesQuery()->findPk($id);
    if ($f->getFieldtype() == "Bild") {
      foreach ($this->DataQuery()->filterByFortemplatefield($f->getId()) as $d) {
        $this->FileModify($d->getId(), []);
      }
    }
    $f->delete();
  }
  
  /**
   * duplicates a field and all data in contributions recursively
   *
   * @param string $name 
   * @return void
   * @author Urs Hofer
   */  
  function duplicateTemplatefield($id, $suffix = "Copy") {
    $new = $this->TemplatesQuery()
                ->findPk($id)
                ->copy(true);
    $new
      ->setFieldname($new->getFieldname() . "[".$suffix."]")
      ->save();
  }   
  
  
  
  /**
   * renames a field in a template
   *
   * @param int $id 
   * @param string $name
   * @return void
   * @author Urs Hofer
   */  
  function renameTemplatefield($id, $name) {
    $this->TemplatesQuery()
         ->findPk($id)
         ->setFieldname($name)
         ->save();
  }
  
  /**
   * sorts the fields of a template
   *
   * @param int $id 
   * @param string $name
   * @return void
   * @author Urs Hofer
   */  
  function sortTemplatefield($fortemplate, $sortarray) {
    if (!is_array($sortarray))
      return false;
    foreach ($sortarray as $sort=>$id) {
      $this->TemplatesQuery()
        ->findPk($id)
        ->setSort($sort) 
        ->save();
      $this->DataQuery()
        ->filterByFortemplatefield($id) 
        ->update(array('Sort' => $sort));
    }    
  }
  
  /**
   * updates the field settings
   *
   * @param int $id
   * @param array $data
   * @return void
   * @author Urs Hofer
   */  
  function updateTemplatefield($id, $data) {
    $t = $this->TemplatesQuery()->findPk($id);
    /*
(
    [0] => Array
        (
            [name] => Fieldtype
            [value] => 
        )

    [1] => Array
        (
            [name] => ConfigSys
            [value] => {"lengthinfluence":[{"fieldname":2,"factor":"0"},{"fieldname":4,"factor":"0"},{"fieldname":1,"factor":"0"},{"fieldname":19,"factor":"0"},{"fieldname":5,"factor":"0"}],"history":false,"maxlines":false,"textlength":"10000","fullhistory":false,"rtfeditor":false,"codeeditor":true,"editorcolumns":[{"lines":"10","label":"Source"},{"lines":"10","label":"View"},{"lines":"10","label":"Translation"}],"arrayeditor":true}
        )

    [2] => Array
        (
            [name] => Helpdescription
            [value] => <table>
        )

    [3] => Array
        (
            [name] => Helpimage
            [value] => 
        )

)
    */

    // Cycle thru form values and store them
    foreach ($data as $value) {
      $t->{"set".$value["name"]}($value["value"]);
    }
    $t->save();
  }
  
  
  /**
   * duplicates the data of upload fields of a contribution
   *
   * @param array $ids 
   * @param string $suffix 
   * @return void
   * @author Urs Hofer
   */
  function duplicateData($contribution) {
    foreach ($contribution->getDatas() as $field) {
      if ($field->getTemplates()->getFieldtype() == "Bild") {
        $olddata  = json_decode($field->getContent(), true);
        if (is_array($olddata)) {
          foreach ($olddata as &$oldimage) {
              $oldimage[1] = $this->CopyFiles($oldimage[1]);
          }
          $field->setContent(json_encode($olddata))->save();
        }
      }
    }
  }
  
  /**
   * deletes the data of upload fields of a contribution
   *
   * @param array $ids 
   * @param string $suffix 
   * @return void
   * @author Urs Hofer
   */
  function deleteData($contribution) {  
    foreach ($contribution->getDatas() as $field) {
      if ($field->getTemplates()->getFieldtype() == "Bild") {
        $this->FileModify($field->getId(), []);
      }
    }
  }  

} // END class 

?>