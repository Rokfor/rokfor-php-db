<?php
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
  
  
  /**
   * proxy redirect prefix for private binary uploads
   *
   * @var string
   */
  private $proxy_prefix;
  
  
  /**
   * s3 storage client
   *
   * @var string
   */
  private static $s3;
    
  function __construct($host, $user, $pass, $dbname, $log, $level, $patharray = [], $socket = false, $port = false, $versioning = false)
  {
    $socket = $socket 
              ? "unix_socket=".$socket.";" 
              : "";
    $port = $port 
            ? "port=".$port.";" 
            : "";

    $this->serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
    $this->serviceContainer->checkVersion('2.0.0-dev');
    $this->serviceContainer->setAdapterClass('rokfor', 'mysql');
    $this->manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
    $this->manager->setConfiguration(array (
      'classname' => 'Propel\\Runtime\\Connection\\DebugPDO',
      'dsn' => 'mysql:host='.$host.';'.$port.'dbname='.$dbname.';'.$socket,
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
      'sys'       => $patharray['sys']        ? $patharray['sys']         : __DIR__. '/../public',
      'privatesys'=> $patharray['privatesys'] ? $patharray['privatesys']  : __DIR__. '/../public',
      'web'       => $patharray['web']        ? $patharray['web']         : '/udb/',
      'webthumbs' => $patharray['webthumbs']  ? $patharray['webthumbs']   : '/udb/thumbs/',
      'thmbsuffix'=> $patharray['thmbsuffix'] ? $patharray['thmbsuffix']  : '-thmb.jpg',
      'scaled'    => $patharray['scaled']     ? $patharray['scaled']      : '-preview[*].jpg',
      'quality'   => $patharray['quality']    ? $patharray['quality']     :  75,
      'process'   => $patharray['process']    ? $patharray['process']     : ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/tiff'],
      'store'     => $patharray['store']      ? $patharray['store']       : ['application/zip', 'video/quicktime', 'video/mp4', 'video/webm', 'audio/mp3'],
      'icon'      => $patharray['icon']       ? $patharray['icon']        : 'thumb.jpg'
    ];
    $this->defaultLogger = new \Monolog\Logger('defaultLogger');
    $this->defaultLogger->pushHandler(new \Monolog\Handler\StreamHandler($log, $level));
    $this->serviceContainer->setLogger('defaultLogger', $this->defaultLogger);
    if (!$versioning) {
      \ContributionsQuery::disableVersioning();
      \DataQuery::disableVersioning();
    }
    
    if ($patharray['s3'] === true) {
      static::$s3 = new \stdClass();
      static::$s3->client = \Aws\S3\S3Client::factory(array(
          'credentials' => array(
              'key'     => $patharray['s3_aws_key'],
              'secret'  => $patharray['s3_aws_secret'],
          ),
          'region'      => $patharray['s3_aws_region'],
          'version'     => "2006-03-01"
      ));
      static::$s3->bucket = $patharray['s3_aws_bucket'];
      static::$s3->folder = md5($dbname);
      static::$s3->client->registerStreamWrapper();
    }
    else {
      static::$s3 = false;
    }
    
    $this->proxy_prefix = '/rf/proxy?';
  }
  
  private function s3_upload($source, $dest, $private) {
    if (substr($dest, 0, 1) != '/') {
      $dest = '/'. $dest;
    }
    $result = static::$s3->client->putObject(array(
        'ACL'        => $private ? 'private' : 'public-read',
        'Bucket'     => static::$s3->bucket,
        'Key'        => static::$s3->folder . $dest,
        'SourceFile' => $source,
    ));
    $this->defaultLogger->info("uploaded $deleteFile with status " . ($private ? 'private' : 'public-read'));
    
    return $result['ObjectURL'];
  }
  
  private function _add_proxy_single_file($url) {
    return $this->proxy_prefix.base64_encode($url);
  }
  
  private function _remove_proxy_single_file($url) {
    if (stristr($url, $this->proxy_prefix )) {
      if (static::$s3 !== false) {
        return base64_decode(substr($url, strlen($this->proxy_prefix)));
      }
      else {
        $encoded = base64_decode(substr($url, strlen($this->proxy_prefix)));
        if (substr($encoded, 0, strlen($this->paths['web'])) === $this->paths['web']) {
          return substr($encoded, strlen($this->paths['web']));
        }
        if (substr($encoded, 0, strlen($this->paths['webthumbs'])) === $this->paths['webthumbs']) {
          return substr($encoded, strlen($this->paths['webthumbs']));
        } 
        return $encoded;       
      }

    }
    else {
      return $url;
    }
  }

  function sign_request(&$fields, $proxy_prefix = false) {
    if ($proxy_prefix) {
      $this->proxy_prefix = $proxy_prefix;
    }
    if (static::$s3 !== false) {
      foreach ($fields as $key => &$v) {
        $v[1]              = $this->_add_proxy_single_file($v[1]);
        if (is_object($v[2])) {
          $v[2]->thumbnail = $this->_add_proxy_single_file($v[2]->thumbnail);
          if (is_array($v[2]->scaled)) {
            foreach ($v[2]->scaled as &$s) {
              $s = $this->_add_proxy_single_file($s);
            }
          }
        }
        else {
          $v[2]['thumbnail'] = $this->_add_proxy_single_file($v[2]['thumbnail']);
          if (is_array($v[2]['scaled'])) {
            foreach ($v[2]['scaled'] as &$s) {
              $s = $this->_add_proxy_single_file($s);
            }
          }
        }
      }
    }
    else {
      foreach ($fields as $key => &$v) {
        $v[1]              = $this->_add_proxy_single_file($this->paths['web'].$v[1]);
        if (is_object($v[2])) {
          $v[2]->thumbnail = $this->_add_proxy_single_file($this->paths['webthumbs'].$v[2]->thumbnail);
          if (is_array($v[2]->scaled)) {
            foreach ($v[2]->scaled as &$s) {
              $s = $this->_add_proxy_single_file($this->paths['web'].$s);
            }
          }
        }
        else {
          $v[2]['thumbnail'] = $this->_add_proxy_single_file($this->paths['webthumbs'].$v[2]['thumbnail']);
          if (is_array($v[2]['scaled'])) {
            foreach ($v[2]['scaled'] as &$s) {
              $s = $this->_add_proxy_single_file($this->paths['web'].$s);
            }
          }
        }
      }
    }    
  }

  
/*  function unsign_request(&$fields, $proxy_prefix = false) {
    if ($proxy_prefix) {
      $this->proxy_prefix = $proxy_prefix;
    }
    $this->_sign_request($fields, true);
  }*/  
  
  
  function proxy($s3url, &$response) {
    /* S3 File Proxying */
    if (static::$s3 !== false) {    
      $key = static::$s3->folder . '/' . pathinfo($s3url, PATHINFO_BASENAME);
      $this->defaultLogger->info("s3 proxying $key");
      if ($this->s3_file_exists($key)) {
        $result =  static::$s3->client->getObject(array(
            'Bucket' => static::$s3->bucket,
            'Key'    => $key
        ));
        $body = $result->get('Body');
        $body->rewind();
        $r = $response
                ->withHeader('Content-Type', $result['ContentType'])
                ->withHeader('Content-Length', $result['ContentLength'])
                ->withHeader('Content-Disposition', 'attachment; filename="'.pathinfo($s3url, PATHINFO_BASENAME).'"');
                  
        $r->getBody()->write($body->read($result['ContentLength']));    
      }
      else {
        $r = $response->withHeader('Content-type', 'application/json');
        $r->getBody()->write(json_encode(['error' => "404", 'message' => "File not found"]));
      }
    }
    /* Local File Proxying: Always from private folder */
    else {
      $localfile = $this->paths['privatesys'].$s3url;
      if (file_exists($localfile)) {
        $this->defaultLogger->info("local proxying $localfile");
        $r = $response
                ->withHeader('Content-Type', mime_content_type($localfile))
                ->withHeader('Content-Length', filesize($localfile))
                ->withHeader('Content-Disposition', 'attachment; filename="'.basename($localfile).'"');
        $r->getBody()->write(file_get_contents($localfile));            
      }
      else {
        $r = $response->withHeader('Content-type', 'application/json');
        $r->getBody()->write(json_encode(['error' => "404", 'message' => "File not found"]));
      }
    }
    /* Return Response */
    return $r;
  }

  private function s3_move($source, $dest, $private) {
    $ObjectURL = $this->s3_upload($source, $dest, $private);
    @unlink($source);
    return $ObjectURL;
  }
  
  private function s3_unlink($filename) {
    $deleteFile = static::$s3->folder . '/' . pathinfo($filename, PATHINFO_BASENAME);
    $result = static::$s3->client->deleteObject(array(
        'Bucket' => static::$s3->bucket,
        'Key'    => $deleteFile,
    ));
    $this->defaultLogger->info("s3 unlink $deleteFile");  
    return $result['DeleteMarker'];
  } 

  private function s3_file_exists($filename) {
//    $this->defaultLogger->info($deleteFile);
    $checkFile = static::$s3->folder . '/' . pathinfo($filename, PATHINFO_BASENAME);
    $keyExists = file_exists("s3://".static::$s3->bucket."/".$checkFile);
    if ($keyExists) {
      $this->defaultLogger->info("s3 file exists $checkFile");  
    }
    return $keyExists;
  }
  
  private function s3_copy($source, $dest, $private) {
    $sourceFile = static::$s3->folder . '/' . pathinfo($source, PATHINFO_BASENAME);
    $destFile = static::$s3->folder . '/' . pathinfo($dest, PATHINFO_BASENAME);    
  //  $this->defaultLogger->info("s3 copy: " . $sourceFile . " TO: ". $destFile);
    $result = static::$s3->client->copyObject(array(
      'ACL'        =>  $private ? 'private' : 'public-read',
      'Bucket'      => static::$s3->bucket,
      'Key'         => $destFile,
      'CopySource'  => static::$s3->bucket. "/" . $sourceFile,
    ));
  //  $this->defaultLogger->info("s3 copy done.");
    $destUrl = static::$s3->client->getObjectUrl(static::$s3->bucket, $destFile);
    return $destUrl;
  }
    
  
  private function copy($source, $dest) {
    return @copy($source, $dest);
  }

  private function unlink($path, $filename) {
    if (static::$s3 !== false) {
      return $this->s3_unlink($filename);
    }
    else {
      return @unlink($path . $filename);
    }
  }

  private function file_exists($filename) {
    if (static::$s3 !== false) {
      return $this->s3_file_exists($filename);      
    }
    else {
      return file_exists($filename);
    }
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
   * returns true if the field has to be stored as json encoded string
   *
   * @param string $field 
   * @return void
   * @author Urs Hofer
   */
  private function _determineJsonForField($field) {
    $settings = json_decode($field->getTemplates()->getConfigSys(), true);
    switch ($field->getTemplates()->getFieldtype()) {
      case 'Zahl':
        return false;
        break;
      case 'Text':
        if (!$settings['arrayeditor'])
          return false;
        break;      
    }
    return true;
  }

  /**
   * deletes an array of files, inclusive possible thumbs and previews
   *
   * @param string $delete 
   * @return void
   * @author Urs Hofer
   */
  private function DeleteFiles($delete, $thumbs, $scaled, $private = false) {
    $path = $private === true 
              ? $this->paths['privatesys'] 
              : $this->paths['sys'];
    
    foreach ($delete as $file) {
      // Original
      $this->unlink($path.$this->paths['web'], $file);      
    }
    foreach ($thumbs as $file) {
      // Thumb
      $this->unlink($path.$this->paths['webthumbs'], $file);
    }
    foreach ($scaled as $file) {
      // Scaled Versions
      $this->unlink($path.$this->paths['web'], $file);      
    }
  }
  
  /**
   * copies a file inclusive thumbs and scaled versions, returns the new filename
   *
   * @param string $delete 
   * @return void
   * @author Urs Hofer
   */
  private function CopyFiles($file, $versions, $private) {
    $newversions = ['thumbnail' => "", 'scaled' => []];
    $copy_suffix = uniqid("_");
    $path = $private === true 
              ? $this->paths['privatesys'] 
              : $this->paths['sys'];

    // Original
    $parts = pathinfo($file);    
    $newname = $parts['filename'].$copy_suffix.'.'.$parts['extension'];
    if (static::$s3 !== false) {
      $newname = $this->s3_copy($path.$this->paths['web'].$file, $path.$this->paths['web'].$newname, $private);      
    }
    else {
      $this->copy($path.$this->paths['web'].$file, $path.$this->paths['web'].$newname);      
    }


    // Thumb
    if ($versions['thumbnail']) {
      $parts = pathinfo($versions['thumbnail']);    
      $newversions['thumbnail'] = $parts['filename'].$copy_suffix.'.'.$parts['extension'];
      if (static::$s3 !== false) {
        $newversions['thumbnail'] = $this->s3_copy($path.$this->paths['webthumbs'].$versions['thumbnail'], $path.$this->paths['webthumbs'].$newversions['thumbnail'], $private);
      }
      else {
        $this->copy($path.$this->paths['webthumbs'].$versions['thumbnail'], $path.$this->paths['webthumbs'].$newversions['thumbnail']);
      }
    }

    // Scaled Versions

    foreach ($versions['scaled'] as $scaled) {
      $parts = pathinfo($scaled);
      $new_scaled = $parts['filename'].$copy_suffix.'.'.$parts['extension'];
      if (static::$s3 !== false) {
        $new_scaled = $this->s3_copy($path.$this->paths['web'].$scaled, $path.$this->paths['web'].$new_scaled, $private);
      }
      else {
        $this->copy($path.$this->paths['web'].$scaled, $path.$this->paths['web'].$new_scaled);
      }
      $newversions['scaled'][] = $new_scaled;
    }
    return array($newname, $newversions);
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
      "email"     => $this->currentUser->getEmail(), 
      "api"       => $this->currentUser->getRoapikey(), 
      "rwapi"     => $this->currentUser->getRwapikey(), 
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
    return $this->usersQuery();
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
   * returns the user query by Email
   *
   * @param string $email 
   * @return void
   * @author Urs Hofer
   */
  function getUserByEmail($email) {
    $q = $this->UsersQuery()->filterByEmail($email);
    if ($q->count() > 0) {
      return $q; 
    }
    else {
      return false;
    }
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
  function updateProfile($name, $mail, $api, &$error, $rwapi = false) {
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
      ->setEmail($mail)
      ->setRoapikey($api)
      ->setRwapikey($rwapi)
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
   * returns a formats Query
   *
   * @return \Childobject\Template
   * @author Urs Hofer
   */  
  function getData() {
    return $this->DataQuery();
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
   * valid_paths are used to check if latest log entries are still pointing
   * to existing chapters and issues.
   * 
   *
   * @param string $url_prefix 
   * @return array
   * @author Urs Hofer
   */
  function getStructure($url_prefix = "", $bookid = false, &$valid_paths = []) {
    $criteria = new \Propel\Runtime\ActiveQuery\Criteria();
    $criteria->addAscendingOrderByColumn(__sort__);  
    $retval = [];
    
    $books = $this->BooksQuery()
                  ->_if($bookid)
                    ->filterById($bookid)
                  ->_endif()
                  ->orderBySort('asc');
        
    foreach ($books as $book) {
      if ($this->rights["books"] === true || (is_object($this->rights["books"]) && in_array($book->getId(), $this->rights["books"]->getPrimaryKeys()))) {
        $c = [];
        $i = [];
        foreach ($book->getIssuess($criteria) as $issue) {
          if ($this->rights["issues"] === true || (is_object($this->rights["issues"]) && in_array($issue->getId(), $this->rights["issues"]->getPrimaryKeys()))) {
            $c = [];
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
      else {
        if ($bookid) {
          return false;
        }
      }
    }
    return $retval;
  }
  
  /**
   * returns available issues for a user
   * 
   *
   * @param int $issueid
   * @return array
   * @author Urs Hofer
   */
  function getStructureByIssues($issueid = false) {
    $retval = [];
    
    $issues = $this->IssuesQuery()
                  ->_if($issueid)
                    ->filterById($issueid)
                  ->_endif()
                  ->orderBySort('asc');
    foreach ($issues as $issue) {
      if ($this->rights["issues"] === true || (is_object($this->rights["issues"]) && in_array($issue->getId(), $this->rights["issues"]->getPrimaryKeys()))) {
        $retval[] = $issue;
      }
      else {
        if ($issueid) {
          return false;
        }
      }
    }
    return $retval;
  }
  
  /**
   * returns available chapters for a user
   * 
   *
   * @param int $issueid
   * @return array
   * @author Urs Hofer
   */
  function getStructureByChapters($chapterid = false) {
    $retval = [];
    $formats = $this->FormatsQuery()
                  ->_if($chapterid)
                    ->filterById($chapterid)
                  ->_endif()
                  ->orderBySort('asc');
    foreach ($formats as $format) {
      if ($this->rights["formats"] === true || (is_object($this->rights["formats"]) && in_array($format->getId(), $this->rights["formats"]->getPrimaryKeys()))) {
        $retval[] = $format;
      }
      else {
        if ($chapterid) {
          return false;
        }
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
   * return template field by id
   *
   * @param string $format 
   * @return void
   * @author Urs Hofer
   */
  function getTemplatefield($value) {
    return $this->TemplatesQuery()->findPk($value);
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
      // Update Contribution References
      $this->_clearReferencedObjects($c);
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
    if (!in_array($state, ['Open', 'Draft', 'Close', 'Deleted']))
      return false;
    $this->ContributionsQuery()
      ->filterById($ids)
      ->update(array('Status' => $state));
  }  
  
  /**
   * prepares the json statement for the config field of a new contribution
   *
   * @return void
   * @author Urs Hofer
   */
  function ContributionDefaultConfig() {
    return json_encode(['lockdate'=>time()]);
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
      ->setConfigSys($this->ContributionDefaultConfig())
      ->save();
    $_sort = 0;
    foreach ($this->TemplatesQuery()->filterByTemplatenames($template)->orderBySort('asc') as $templatefield) {
      $d = new \Data();
      $d->setContributions($c)
        ->setTemplates($templatefield)
        ->setUserSysRef($this->currentUser)
        ->setSort($_sort)
        ->setIsjson($d)
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
    if (\ContributionsQuery::isVersioningEnabled()) {
      \ContributionsQuery::disableVersioning();
      \DataQuery::disableVersioning();
      $restoreVersioning = true;
    }     
    else {
      $restoreVersioning = false;
    }
    foreach ($ids as $id) {
      $c = $this->ContributionsQuery()->findPk($id);
      $new = $c->copy(true);
      $new->setName($c->getName() . "[".$suffix."]");

      /* Clear References in New Contribution */
      if ($_nodes = json_decode($new->getConfigSys(), true)) {
        if ($_nodes["referenced"]) {
          $_nodes["referenced"] = [];
          $new->setConfigSys(json_encode($_nodes));
        }
      }      
      
      /* Save */
      $new->save();
      $this->duplicateData($new);
    }
    if ($restoreVersioning) {
      \ContributionsQuery::disableVersioning();
      \DataQuery::disableVersioning();
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
  
  private function _getMimeType($file) {
    $type = $file->getClientMediaType();
    // Nasty Firefox Bug handeled here...
    if ($type === "application/force-download") {
      if (strtolower(pathinfo( $file->getClientFilename(), PATHINFO_EXTENSION)) === "pdf") {
        $type = "application/pdf";
      }
    }
    return $type;
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
  function FileStore($fieldid, &$file, &$original_url, &$relative_url, &$thumb_url, &$caption, &$newindex, $default_caption = 'Caption') {
    $field = $this->getField($fieldid);
    $versions = ['thumbnail' => "", 'scaled' => []];
    if ($field) {

      // Private Storage
      $private = $field->getTemplates()->getTemplatenames()->getPublic() ? false : true;
      $path = $private === true 
                ? $this->paths['privatesys'] 
                : $this->paths['sys'];

$this->defaultLogger->info("PRIVATE: " . $private);

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
      $escapedFileName = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $file->getClientFilename());
      while ($this->file_exists($path.$this->paths['web'].$escapedFileName)) {
        $escapedFileName = time()."_".$escapedFileName;
        $this->defaultLogger->info("APPENDING: " . $escapedFileName);
      }
      
      // Process
      if (in_array($this->_getMimeType($file), $this->paths['process']) && ($settings['imagesize'][0]['width'] || $settings['imagesize'][0]['height'])) {

        $file->moveTo($path.$this->paths['web'].$escapedFileName);

        // Class
        $driver = (in_array('Imagick', get_declared_classes()) ? 'imagick' : 'gd');
        $manager = new \Intervention\Image\ImageManager(array('driver' => $driver));
        $supported_types = $driver == 'imagick' 
                            ? ['image/jpeg' => 'jpg',
                               'image/jpg'  => 'jpg',
                               'image/png'  => 'png',
                               'image/gif'  => 'gif']
                            : ['image/jpeg' => 'jpg',
                               'image/jpg'  => 'jpg',
                               'image/gif'  => 'gif'];

        // Thumbnail
        $image = $manager->make($path.$this->paths['web'].$escapedFileName);
        $image->fit(100,100);
        $image->save($path.$this->paths['webthumbs'].$escapedFileName.$this->paths['thmbsuffix'], $this->paths['quality']);

        // S3 Storage
        if (static::$s3 !== false) {
          $thumb_url = $this->s3_move($path.$this->paths['webthumbs'].$escapedFileName.$this->paths['thmbsuffix'], $escapedFileName.$this->paths['thmbsuffix'], $private);
          $versions['thumbnail'] = $thumb_url;
        }
        else {
          $thumb_url = $this->paths['webthumbs'].$escapedFileName.$this->paths['thmbsuffix'];          
          $versions['thumbnail'] = $escapedFileName.$this->paths['thmbsuffix'];
        }

        $_copy = 0;        
        foreach ($settings['imagesize'] as $size_per_image) {
          $image = $manager->make($path.$this->paths['web'].$escapedFileName);
          $width = $size_per_image['width'];
          $height = $size_per_image['height'];
          // Resize and Copy to width and height
          $_ext = str_replace('[*]', $_copy++, $this->paths['scaled']);

          // Keep File Type if possible: otherwise make a jpeg.
          // If no [ext] is avaible, nothing happens.

          $_suffix = $supported_types[$this->_getMimeType($file)] ? $supported_types[$this->_getMimeType($file)] : 'jpg';
          $_ext = str_replace('[ext]', $_suffix, $_ext);

          $_processfile = $escapedFileName.$_ext;

          $height = $height == 0 ? null : $height;
          $width  = $width  == 0 ? null : $width;

          $image->resize($width,$height, function ($constraint) {
            $constraint->aspectRatio();
          });
          $image->save($path.$this->paths['web'].$_processfile, $this->paths['quality']);
          
          // S3 Storage
          if (static::$s3 !== false) {
            array_push($versions['scaled'], $this->s3_move($path.$this->paths['web'].$_processfile, $escapedFileName.$_ext, $private));
          }
          else {
            array_push($versions['scaled'], $escapedFileName.$_ext);
          }
        }
        
        if (static::$s3 !== false) {
          $original_url = $this->s3_move($path.$this->paths['web'].$escapedFileName, $escapedFileName, $private);
        }
      }
      // Move & Create a fake thumbnail
      // Also for process mime types which just failed because of missing size parameters
      else if (in_array($this->_getMimeType($file), $this->paths['store']) || in_array($this->_getMimeType($file), $this->paths['process'])) {
        $file->moveTo($path.$this->paths['web'].$escapedFileName);
        
        // S3 Storage
        if (static::$s3 !== false) {
          $original_url = $this->s3_move($path.$this->paths['web'].$escapedFileName, $escapedFileName, $private);
          $thumb_url = $this->s3_upload($path.$this->paths['webthumbs'].$this->paths['icon'], $escapedFileName.$this->paths['thmbsuffix'], $private);
          $versions['thumbnail'] = $thumb_url;
        }
        else {
          $this->copy($path.$this->paths['webthumbs'].$this->paths['icon'], $path.$this->paths['webthumbs'].$escapedFileName.$this->paths['thmbsuffix']);
          $thumb_url = $this->paths['webthumbs'].$escapedFileName.$this->paths['thmbsuffix'];
          $versions['thumbnail'] = $escapedFileName.$this->paths['thmbsuffix'];
        }
      }
      // Unknown Type: Do not accept and return false
      else {
        $original_url = false;
        $thumb_url = false;
        $relative_url = false;
        return false;
      }
      
      // Update References
      if (static::$s3 === false) {
        // Attach to Data
        $newindex = array_push($oldVal, [$caption, $escapedFileName, $versions]);
        $original_url = $escapedFileName;
        $relative_url = $this->paths['web'].$escapedFileName;
      }
      else {
        // Attach to Data
        $newindex = array_push($oldVal, [$caption, $original_url, $versions]);
        $relative_url = $original_url;
      }
      // Store
      $field->setContent(json_encode($oldVal))
        ->setIsjson(true)
        ->save();
      // Proxify if private
      if ($private === true) {
        $original_url = $this->_add_proxy_single_file($original_url);
        $thumb_url    = $this->_add_proxy_single_file($thumb_url);
        $relative_url = $this->_add_proxy_single_file($relative_url);
      }
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

      // Deproxify Private Binaries
      if (!$field->getTemplates()->getTemplatenames()->getPublic()) {
        $private = true;
      }
      else {
        $private = false;
      }

      $olddata  = json_decode($field->getContent(), true);
      $oldimages = [];
      if (is_array($olddata)) {
        foreach ($olddata as $i) {
          $oldimages[$i[1]] = $i;
        }
      }

      // Copy scaled versions from old data
      if ($private === true) {
        foreach ($tabledata as $key => $i) {
          $tabledata[$key][1] = $this->_remove_proxy_single_file($i[1]);
          $this->defaultLogger->info($tabledata[$key][1]);
        }
      }
      foreach ($tabledata as $key => $i) {
        if ($oldimages[$i[1]][1] === $i[1]) {
          $tabledata[$key][2] = $oldimages[$i[1]][2];
          unset($oldimages[$i[1]]);
        }
      }

      // $this->defaultLogger->info("TO DELETE: " . join(",",array_keys($oldimages)));

      // Oldimages has now all the rest which does not exist in the new data
      $delete = [];
      $thumbs = [];
      $scaled = [];
      foreach ($oldimages as $i) {
        $delete[] = $i[1];
        if ($i[2]['thumbnail']) {
          $thumbs[] = $i[2]['thumbnail'];
        }
        if (is_array($i[2]['scaled'])) {
          $scaled  = array_merge($scaled, $i[2]['scaled']);
        }        
      }
      $this->DeleteFiles($delete, $thumbs, $scaled, $private);

      //$this->defaultLogger->info("ORIG: " . join(",", $delete));
      //$this->defaultLogger->info("THMB: " . join(",", $thumbs));
      //$this->defaultLogger->info("SCLD: " . join(",", $scaled));
      //$this->defaultLogger->info("STORE: " . print_r($tabledata, true));
      
      //      print_r($delete);
      //      print_r($newdata);
      //      print_r($olddata);
      $field->setContent(json_encode($tabledata))
        ->setIsjson(true)
        ->save();
      return true;
    }
    else
      return false;
  }
  
  /**
   * sets the value of a referenced field to -1 if the source object is deleted
   *
   * @param string $source 
   * @return void
   * @author Urs Hofer
   */
  private function _clearReferencedObjects($source) {
    $_id = $source->getId();
    if ($_id) {
      if ($_nodes = json_decode($source->getConfigSys())) {
        foreach ($_nodes->referenced as $fieldId => $refContrib) {
          $_f = $this->getField($fieldId);
          if ($_f) {
            $_oldval = $_f->getDataAlwaysAsArray();
            // Delete this reference from valoues
            if(($key = array_search($_id, $_oldval)) !== false) {
                unset($_oldval[$key]);
            }
            // Set to Disabled if no values are left
            if (sizeof($_oldval) == 0) {
              $_oldval[] = -1;
            }
            $_f->setContent(json_encode($_oldval))->save();
          }        
        }
      }
    }
  }
  

  /**
   * updates the contribution backreferences stored in the _config_ field of a contribution
   *
   * @param string $field 
   * @param string $data 
   * @return void
   * @author Urs Hofer
   */
  private function _updateReferencedObjects($fieldid, $data = []) {
    $field = $this->getField($fieldid);    
    if ($field->getTemplates()->getFieldtype() == "TypologySelect" || $field->getTemplates()->getFieldtype() == "TypologyKeyword") {
      $settings = json_decode($field->getTemplates()->getConfigSys());
      $_oldvals = json_decode($field->getContent());
      $_oldref = false;
      $_newref = false;
      // Contributional: Store contribution-id of the field in the target contribution
      if ($settings->history_command == "contributional") {
        $_oldref = $this->ContributionsQuery()->filterById($_oldvals);
        $_newref = $this->ContributionsQuery()->filterById(json_decode($data));
      }
      
      // Books: Store contribution-id of the field in the target contribution
      else if ($settings->history_command == "books") {
        $_oldref = $this->BooksQuery()->filterById($_oldvals); 
        $_newref = $this->BooksQuery()->filterById(json_decode($data)); 
      }
      else if ($settings->history_command == "issues") {
        $_oldref = $this->IssuesQuery()->filterById($_oldvals); 
        $_newref = $this->IssuesQuery()->filterById(json_decode($data));
      }
      else if ($settings->history_command == "chapters") {
        $_oldref = $this->FormatsQuery()->filterById($_oldvals); 
        $_newref = $this->FormatsQuery()->filterById(json_decode($data));
      }
      
      if ($_oldref && $_newref) {
        // Delete old References: Possible to de-click values
        foreach ($_oldref as $_ref) {
          if ($_nodes = json_decode($_ref->getConfigSys(), true)) {
            if ($_nodes["referenced"][$fieldid]) {
              unset($_nodes["referenced"][$fieldid]);
              $_ref->setConfigSys(json_encode($_nodes))->save();
            }
          }
        }
        // Store new References
        foreach ($_newref as $_ref) {
          $_nodes = json_decode($_ref->getConfigSys(), true);
          if (!$_nodes || !is_array($_nodes)) {
            $_nodes = [];
          }
          if (!is_array($_nodes["referenced"])) $_nodes["referenced"] = [];
          $_nodes["referenced"][$fieldid] = $field->getForcontribution();
          $_ref->setConfigSys(json_encode($_nodes))->save();
        }
      }
    }
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
      $access = ($this->rights["templates"]=== true || is_object($this->rights["templates"]) && in_array($tname->getId(), $this->rights["templates"]->getPrimaryKeys()));
      if ($access) {
        // Update Contributional References for Relative Fields
        $this->_updateReferencedObjects($fieldid, $data);
        // Json is always true unless it is a number or a plain text field
        $field->setIsjson($this->_determineJsonForField($field));

        if ((is_array($data) || is_object($data))) {
          $data = json_encode($data);
        }
        $field->setContent($data)->save();
        return true;
      }
      else return "access failed";
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
  function getContributions($issueid, $chapterid, $sortmode = 'asc', $status = false, $limit = false, $offset = false, $count = false, $templateid = false) {
    
    
    $chaptersort = false;   // Sort by chapter
    $issuesort   = false;   // Sort by issue
    $customsort = false; // If Sorted by Field: Contains Field ID
    
    if (!$sortmode) $sortmode = "asc";
    if ($sortmode == "asc" || $sortmode == "desc") {
      $direction = $sortmode;
      $sort = 'orderBySort';
    }
    else {
      list($sortarray,$direction) = explode(":", $sortmode);
      if ($direction == "") {
        $direction = "asc";
      }
      foreach ((array)explode("|", $sortarray) as $_sort) {
        switch ($_sort) {
          case 'date':
            $sort = 'orderByNewdate';
            break;
          case 'name':
            $sort = 'orderByName';
            break;
          case 'id':
            $sort = 'orderById';
            break;
          case 'chapter':
            $chaptersort = true;
            break;          
          case 'issue':
            $issuesort = true;
            break;          
          default:
            if ($_sort != false && $_sort != "sort") {
              $customsort = $_sort;
            }
            break;
        }
        if (!$sort) {
          $sort = 'orderBySort';
        }
      }
    }
    
    if (
      ($this->rights["issues"] === true || (is_object($this->rights["issues"]) && (
        is_array($issueid) 
          ? count(array_intersect($issueid, $this->rights["issues"]->getPrimaryKeys())) > 0
          : in_array($issueid, $this->rights["issues"]->getPrimaryKeys())
        ))) &&
      ($this->rights["formats"] === true || (is_object($this->rights["formats"]) && (
        is_array($chapterid) 
          ? count(array_intersect($chapterid, $this->rights["formats"]->getPrimaryKeys())) > 0
          : in_array($chapterid, $this->rights["formats"]->getPrimaryKeys())
          
        )))
    ) {
      if ($count === true) return $this->ContributionsQuery()
                ->filterByForissue($issueid)
                ->filterByForchapter($chapterid)
                ->_if($templateid)
                  ->filterByFortemplate($templateid)
                ->_endif()                  
                ->_if($status)
                  ->filterByStatus($status)
                ->_endif()
                ->count();
      
      else return $this->ContributionsQuery()
                ->filterByForissue($issueid)
                ->filterByForchapter($chapterid)
                ->_if($templateid)
                  ->filterByFortemplate($templateid)
                ->_endif()
                ->_if($status)
                  ->filterByStatus($status)
                ->_endif()
                
                ->_if($customsort)
                    ->withColumn('SortColumn._content', 'sortcolumn')
                    ->useDataQuery('SortColumn')
                      ->filterByFortemplatefield($customsort)
                    ->endUse()
                    ->orderBy('sortcolumn', $direction)
                ->_endif()

                ->_if($chaptersort)
                  ->useFormatsQuery('ChapterSortColumn')
                    ->withColumn('ChapterSortColumn.__sort__', 'chaptersort')
                  ->endUse()
                  ->orderBy('chaptersort', $direction)
                ->_endif()

                ->_if($issuesort)
                  ->useIssuesQuery('IssueSortColumn')
                    ->withColumn('IssueSortColumn.__sort__', 'issuesort')
                  ->endUse()
                  ->orderBy('issuesort', $direction)
                ->_endif()

                ->_if(!$customsort)
                  ->$sort($direction)
                ->_endif()

                ->_if($offset)
                  ->offset((int)$offset)
                ->_endif()
                ->_if($limit)
                  ->limit((int)$limit)
                ->_endif();
      }
      else return false;
  }
  
  /**
   * returns all contributions matching string in the name
   *
   * @param string $string 
   * @return ChildCollection\ContributionsQuery()
   * @author Urs Hofer
   */
  function searchContributions($string, $issueid = false, $chapterid = false, $status = false, $limit = false, $offset = false, $filterfield = false, $filtermode = "like", $sortmode = 'asc', $count = false, $templateid = false) {
    // Checks: if issue id is set, only check for the rights for this issue
    if ($issueid) {
      if (!($this->rights["issues"] === true || (is_object($this->rights["issues"]) && in_array($issueid, $this->rights["issues"]->getPrimaryKeys())))) 
        return false;
    }
    // Checks: if issue is not sent and user is regular, set issue to available primary keys
    elseif ($this->rights["issues"] !== true) {
      $issueid = $this->rights["issues"]->getPrimaryKeys();
    }

    // Checks: if chapter id is set, only check for the rights for this issue    
    if ($chapterid) {
      if (!($this->rights["formats"] === true || (is_object($this->rights["formats"]) && in_array($chapterid, $this->rights["formats"]->getPrimaryKeys()))))
        return false;
    }  
    // Checks: if chapter is not sent and user is regular, set chapters to available primary keys
    elseif ($this->rights["formats"] !== true) {
      $chapterid = $this->rights["formats"]->getPrimaryKeys();
    }
    
    // Sort Mode
    $customsort = false; // If Sorted by Field: Contains Field ID
    $sort = false;      
    $direction = "asc";
    $chaptersort = false;   // Sort by chapter
    $issuesort   = false;   // Sort by issue


    if ($sortmode == "asc" || $sortmode == "desc") {
      $direction = $sortmode;
      $sort = 'orderBySort';
    }
    else {
      list($sortarray,$direction) = explode(":", $sortmode);
      if ($direction == "") {
        $direction = "asc";
      }
      foreach ((array)explode("|", $sortarray) as $_sort) {
        switch ($_sort) {
          case 'date':
            $sort = 'orderByNewdate';
            break;
          case 'name':
            $sort = 'orderByName';
            break;
          case 'id':
            $sort = 'orderById';
            break;
          case 'chapter':
            $chaptersort = true;
            break;          
          case 'issue':
            $issuesort = true;
            break;          
          default:
            if ($_sort != false && $_sort != "sort") {
              $customsort = $_sort;
            }
            break;
        }
        if (!$sort) {
          $sort = 'orderBySort';
        }
      }
      
    }
  
    // Filter Fields: If passed, only the selected fields are searched for a valoue
    $filterfieldids = [];

    $filterby = "";
    $filterbycol = false;

    if ($filterfield) {
      foreach (explode('|', $filterfield) as $f) {
        if ($f === "sort") {
          $filterby = 'filterBySort';
          $filterbycol = '_contributions.__sort__';
        }
        else if ($f === "id") {
          $filterby = 'filterById';
          $filterbycol = '_contributions.id';
        }
        else if ($f === "date") {
          $filterby = 'filterByNewdate';
          $filterbycol = '_contributions._newdate';
        }        
        else {
          $filterfieldids[] = (int)$f;
        }
      }
    }
    if ($filtermode != "lte" && $filtermode != "gte" && $filtermode != "lt" && $filtermode != "gt" && $filtermode != "eq") {
      $filtermode = "like";
    }
    if ($count === true) return $this->ContributionsQuery()
                ->_if($issueid)
                  ->filterByForissue($issueid)
                ->_endif()
                ->_if($chapterid)
                  ->filterByForchapter($chapterid)
                ->_endif()
                ->_if($status)
                  ->filterByStatus($status)
                ->_endif()
                ->_if($templateid)
                  ->filterByFortemplate($templateid)
                ->_endif()
                ->distinct()

                ->_if($filterby != "")
                  ->_if($filtermode == "like")
                    ->$filterby('%'.$string.'%')
                  ->_endif()
                  ->_if($filtermode == "lt")
                    ->addUsingAlias($filterbycol, (int)$string, \Propel\Runtime\ActiveQuery\Criteria::LESS_THAN)
                  ->_endif()
                  ->_if($filtermode == "gt")
                    ->addUsingAlias($filterbycol, (int)$string, \Propel\Runtime\ActiveQuery\Criteria::GREATER_THAN)
                  ->_endif()
                  ->_if($filtermode == "lte")
                    ->$filterby(array('max' => (int)$string))
                  ->_endif()
                  ->_if($filtermode == "gte")
                    ->$filterby(array('min' => (int)$string))
                  ->_endif()
                  ->_if($filtermode == "eq")
                    ->$filterby((int)$string)
                  ->_endif()

                ->_else()
                  ->_if(!$filterfield)
                    ->filterByName('%'.$string.'%')
                    ->_or()
                  ->_endif()
                  ->useDataQuery()
                      ->_if($filterfield)
                        ->filterByFortemplatefield($filterfieldids)
                        ->_and()
                      ->_endif()
                      ->_if($filtermode == "like")
                        ->filterByContent('%'.$string.'%')
                      ->_endif()
                      ->_if($filtermode == "lt")
                        ->add('_content', 'CAST(_content AS UNSIGNED) < ' . (int)$string, \Propel\Runtime\ActiveQuery\Criteria::CUSTOM)
                      ->_endif()
                      ->_if($filtermode == "gt")
                        ->add('_content', 'CAST(_content AS UNSIGNED) > ' . (int)$string, \Propel\Runtime\ActiveQuery\Criteria::CUSTOM)
                      ->_endif()
                      ->_if($filtermode == "lte")
                        ->add('_content', 'CAST(_content AS UNSIGNED) <= ' . (int)$string, \Propel\Runtime\ActiveQuery\Criteria::CUSTOM)
                      ->_endif()                                  
                      ->_if($filtermode == "gte")
                        ->add('_content', 'CAST(_content AS UNSIGNED) >= ' . (int)$string, \Propel\Runtime\ActiveQuery\Criteria::CUSTOM)
                      ->_endif()
                      ->_if($filtermode == "eq")
                        ->filterByContent($string)
                      ->_endif()
                  ->endUse()
                ->_endif()
                ->count();
    
    else return $this->ContributionsQuery()
                ->_if($issueid)
                  ->filterByForissue($issueid)
                ->_endif()
                ->_if($chapterid)
                  ->filterByForchapter($chapterid)
                ->_endif()
                ->_if($status)
                  ->filterByStatus($status)
                ->_endif()
                ->_if($templateid)
                  ->filterByFortemplate($templateid)
                ->_endif()                
                        
                ->distinct()
                        
                ->_if($filterby <> "")
                  ->_if($filtermode == "like")
                    ->$filterby('%'.$string.'%')
                  ->_endif()
                  ->_if($filtermode == "lt")
                    ->addUsingAlias($filterbycol, (int)$string, \Propel\Runtime\ActiveQuery\Criteria::LESS_THAN)
                  ->_endif()
                  ->_if($filtermode == "gt")
                    ->addUsingAlias($filterbycol, (int)$string, \Propel\Runtime\ActiveQuery\Criteria::GREATER_THAN)
                  ->_endif()
                  ->_if($filtermode == "lte")
                    ->$filterby(array('max' => (int)$string))
                  ->_endif()
                  ->_if($filtermode == "gte")
                    ->$filterby(array('min' => (int)$string))
                  ->_endif()
                  ->_if($filtermode == "eq")
                    ->$filterby((int)$string)
                  ->_endif()

                ->_else()                        
                  ->_if(!$filterfield)
                    ->filterByName('%'.$string.'%')
                    ->_or()
                  ->_endif()
                  ->useDataQuery('FilterColumn')
                      ->_if($filterfield)
                        ->filterByFortemplatefield($filterfieldids)
                        ->_and()
                      ->_endif()
                      ->_if($filtermode == "like")
                        ->filterByContent('%'.$string.'%')
                      ->_endif()
                      ->_if($filtermode == "lt")
                        ->add('FilterColumn._content', 'CAST(FilterColumn._content AS UNSIGNED) < ' . (int)$string, \Propel\Runtime\ActiveQuery\Criteria::CUSTOM)
                      ->_endif()
                      ->_if($filtermode == "gt")
                        ->add('FilterColumn._content', 'CAST(FilterColumn._content AS UNSIGNED) > ' . (int)$string, \Propel\Runtime\ActiveQuery\Criteria::CUSTOM)
                      ->_endif()
                      ->_if($filtermode == "lte")
                        ->add('FilterColumn._content', 'CAST(FilterColumn._content AS UNSIGNED) <= ' . (int)$string, \Propel\Runtime\ActiveQuery\Criteria::CUSTOM)
                      ->_endif()                                  
                      ->_if($filtermode == "gte")
                        ->add('FilterColumn._content', 'CAST(FilterColumn._content AS UNSIGNED) >= ' . (int)$string, \Propel\Runtime\ActiveQuery\Criteria::CUSTOM)
                      ->_endif()

                      ->_if($filtermode == "eq")
                        ->filterByContent($string)
                      ->_endif()
                  ->endUse()
                ->_endif()

                ->_if($customsort)
                    ->withColumn('SortColumn._content', 'sortcolumn')
                    ->useDataQuery('SortColumn')
                      ->filterByFortemplatefield($customsort)
                    ->endUse()
                    ->orderBy('sortcolumn', $direction)
                ->_endif()

                ->_if($chaptersort)
                  ->useFormatsQuery('ChapterSortColumn')
                    ->withColumn('ChapterSortColumn.__sort__', 'chaptersort')
                  ->endUse()
                  ->orderBy('chaptersort', $direction)
                ->_endif()

                ->_if($issuesort)
                  ->useIssuesQuery('IssueSortColumn')
                    ->withColumn('IssueSortColumn.__sort__', 'issuesort')
                  ->endUse()
                  ->orderBy('issuesort', $direction)
                ->_endif()

                ->_if(!$customsort)
                  ->$sort($direction)
                ->_endif()

                ->_if($offset)
                  ->offset((int)$offset)
                ->_endif()
                ->_if($limit)
                  ->limit((int)$limit)
                ->_endif();

  }

  /**
   * returns Contribution object by id
   *
   * @param int $id 
   * @return Childobject\Contribution()
   * @author Urs Hofer
   */  
  function getContribution($id) {
    if ($_c = $this->ContributionsQuery()->findPk($id)) {
      if (
        ($this->rights["issues"] === true || (is_object($this->rights["issues"]) && in_array($_c->getForissue(), $this->rights["issues"]->getPrimaryKeys()))) &&
        ($this->rights["formats"] === true || (is_object($this->rights["formats"]) && in_array($_c->getForchapter(), $this->rights["formats"]->getPrimaryKeys())))
      ) {
        return $_c; 
      }
      else {
        return false;
      }
    }
    else {
      return null;
    } 
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
   * change settingsBook of a book
   *
   * @param int $id 
   * @param string $name
   * @return void
   * @author Urs Hofer
   */  
  function settingsBook($id, $rights) {
    $b = $this->getBook($id);
    if ($b) {
      $b->setConfigSys($rights);
      $b->save();
    }
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
   * change config of a issue
   *
   * @param int $id 
   * @param string $name
   * @return void
   * @author Urs Hofer
   */  
  function settingsIssue($id, $rights) {
    $b = $this->getIssue($id);
    if ($b) {
      $b->setConfigSys($rights);
      $b->save();
    }
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
   * change rights of a chapter
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
   * change rights of a chapter
   *
   * @param int $id 
   * @param string $name
   * @return void
   * @author Urs Hofer
   */  
  function settingsChapter($id, $rights) {
    $b = $this->getFormat($id);
    if ($b) {
      $b->setConfigSys($rights);
      $b->save();
    }
  }    

  /**
   * deletes a book with all content and binaries
   *
   * @param int $id 
   * @return void
   * @author Urs Hofer
   */
  function deleteBook($id) {
    $_book =  $this->getBook($id);
    if ($_book) {
      // Update Contribution References
      $this->_clearReferencedObjects($_book);
      // Delete Binaries & References
      foreach ($this->IssuesQuery()->filterByForbook($id) as $issue) {
        $this->_clearReferencedObjects($issue);
        foreach ($this->ContributionsQuery()->filterByIssues($issue) as $contribution) {
            $this->deleteData($contribution);
            $this->_clearReferencedObjects($contribution);
        }
      }
      // Delete Chapter References
      foreach ($this->FormatsQuery()->filterByForbook($id) as $chapter) {
        $this->_clearReferencedObjects($chapter);
      }
      $_book->delete();
    }
  }

  /**
   * deletes a issue with all content and binaries
   *
   * @param int $id 
   * @return void
   * @author Urs Hofer
   */
  function deleteIssue($id) {
    $_issue = $this->getIssue($id);
    if ($_issue) {
      // Delete Contribution References
      $this->_clearReferencedObjects($_issue);
      // Delete Binaries & References
      foreach ($this->ContributionsQuery()->filterByForissue($id) as $contribution) {
        $this->deleteData($contribution);
        $this->_clearReferencedObjects($contribution);
      }    
      $_issue->delete();    
    }
  }

  /**
   * deletes a chapter with all content and binaries
   *
   * @param int $id 
   * @return void
   * @author Urs Hofer
   */
  function deleteChapter($id) {
    $_chapter = $this->getFormat($id);
    if ($_chapter) {
      // Update Contribution References
      $this->_clearReferencedObjects($_chapter);
      // Delete Binaries & References
      foreach ($this->ContributionsQuery()->filterByForchapter($id) as $contribution) {
        $this->deleteData($contribution);
        $this->_clearReferencedObjects($contribution);
      }
      // Set Parentnode of dependent chapters to -1
      foreach ($this->getFormats()->filterByForbook($_chapter->getForbook()) as $f) {
        $_config = json_decode($f->getConfigSys());
        if ($_config->parentnode == $id) {
          $_config->parentnode = -1;
          $f->setConfigSys(json_encode($_config))->save();
        }
      }
      // Delete Chapter
      $_chapter->delete();
    }
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
    if (\ContributionsQuery::isVersioningEnabled()) {
      \ContributionsQuery::disableVersioning();
      \DataQuery::disableVersioning();
      $restoreVersioning = true;
    }     
    else {
      $restoreVersioning = false;
    }
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
    if ($restoreVersioning) {
      \ContributionsQuery::enableVersioning();
      \DataQuery::enableVersioning();
    }    
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
    if (\ContributionsQuery::isVersioningEnabled()) {
      \ContributionsQuery::disableVersioning();
      \DataQuery::disableVersioning();
      $restoreVersioning = true;
    }     
    else {
      $restoreVersioning = false;
    }
    
    $new = $this->getIssue($id)
                ->copy($deep);
    $new
      ->setName($new->getName() . "[".$suffix."]")
      ->save();  

    foreach ($this->ContributionsQuery()->filterByForissue($new->getId()) as $contribution) {
      $this->duplicateData($contribution);
    }
    if ($restoreVersioning) {
      \ContributionsQuery::enableVersioning();
      \DataQuery::enableVersioning();
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
    if (\ContributionsQuery::isVersioningEnabled()) {
      \ContributionsQuery::disableVersioning();
      \DataQuery::disableVersioning();
      $restoreVersioning = true;
    }     
    else {
      $restoreVersioning = false;
    }
    
    $new = $this->getFormat($id)
                ->copy($deep);
    $new
      ->setName($new->getName() . "[".$suffix."]")
      ->save(); 
    
    foreach ($this->ContributionsQuery()->filterByForchapter($new->getId()) as $contribution) {
      $this->duplicateData($contribution);
    }
    if ($restoreVersioning) {
      \ContributionsQuery::enableVersioning();
      \DataQuery::enableVersioning();
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
    if (\ContributionsQuery::isVersioningEnabled()) {
      \ContributionsQuery::disableVersioning();
      \DataQuery::disableVersioning();
      $restoreVersioning = true;
    }     
    else {
      $restoreVersioning = false;
    }    

    $new = $this->TemplatenamesQuery()
                ->findPk($id)
                ->copy(true);
    $new
      ->setName($new->getName() . "[".$suffix."]")
      ->save();

    if ($restoreVersioning) {
      \ContributionsQuery::enableVersioning();
      \DataQuery::enableVersioning();
    }    
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

    // Reset Checkboxes first, since they are not passed
    // if switched of, only on values
    $t->setPublic(false);

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
        $t->setPublic(true);
        $this->defaultLogger->info("set public: true");
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
    if (\ContributionsQuery::isVersioningEnabled()) {
      \ContributionsQuery::disableVersioning();
      \DataQuery::disableVersioning();
      $restoreVersioning = true;
    }     
    else {
      $restoreVersioning = false;
    } 
    
    $new = $this->TemplatesQuery()
                ->findPk($id)
                ->copy(true);
    $new
      ->setFieldname($new->getFieldname() . "[".$suffix."]")
      ->save();

    if ($restoreVersioning) {
      \ContributionsQuery::enableVersioning();
      \DataQuery::enableVersioning();
    }
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
    $private = !$contribution->getTemplatenames()->getPublic();
    foreach ($contribution->getDatas() as $field) {
      if ($field->getTemplates()->getFieldtype() == "Bild") {
        $olddata  = json_decode($field->getContent(), true);
        if (is_array($olddata)) {
          foreach ($olddata as $key=>$oldimage) {
              list($olddata[$key][1], $olddata[$key][2]) = $this->CopyFiles($oldimage[1], $oldimage[2], $private);
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
      // Delete Images
      if ($field->getTemplates()->getFieldtype() == "Bild") {
        $this->FileModify($field->getId(), []);
      }
    }
  }  

} // END class 

?>
