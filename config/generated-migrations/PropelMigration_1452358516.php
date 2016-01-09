<?php

// bootstrap the Propel runtime (and other dependencies)
require_once __DIR__ . '/../../vendor/autoload.php';
set_include_path(__DIR__ . '/../generated-classes' . PATH_SEPARATOR . get_include_path());
include __DIR__ .'/../generated-conf/config.php';

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1452358516.
 * Generated on 2016-01-09 16:55:16 by urshofer
 */
class PropelMigration_1452358516
{
    public $comment = '';
    
    function 	_ConvertInfluenceArray($_inf) {
  		// Transform Influence Array
  		$_inf_array = [];
  		foreach (explode('<::::::>', $_inf) as $_value) {
  			array_push($_inf_array, explode("%%%%%", $_value));
  		}
  		return ($_inf_array);				
	  }

    public function preUp($manager)
    {
        // add the pre-migration code here
    }

    public function postUp($manager)
    {
        // add the post-migration code here
        $pdo = $manager->getAdapterConnection('rokfor');
        
        $datasets = TemplatesQuery::create()->find();
        $count = 0;
        foreach ($datasets as $field) {
          $newconfig = Array (
            maxlines    => $field->getMaxlines(),
            textlength  => $field->getTextlength(),
            imagewidth  => explode(';',$field->getImagewidth()),
            imageheight => explode(';',$field->getImageheight()),
            columns     => $field->getCols(),
            history     => strtolower($field->getHistory()) == "ja",
            growing     => strtolower($field->getGrowing()) == "ja"
          );
          
          $newconfig['lengthinfluence'] = $this->_ConvertInfluenceArray($field->getLengthinfluence());
          
          $string = $field->getColnames();
          switch ($field->getFieldname()) {
            case 'Text':
              $newconfig['fullhistory']  = stristr($string, 'fullhistory=true');
              $newconfig['rtfeditor']    = !stristr($string, 'rtfeditor=false');
              $newconfig['codeeditor']   = stristr($string, 'codeeditor=true');
              $string = str_ireplace('fullhistory=true', '',$string);
              $string = str_ireplace('rtfeditor=false', '', $string);
              $string = str_ireplace('codeeditor=true', '', $string);
          		$_columns = explode(";", $string);
              $newconfig['editorcolumns'] = [];
          		if (count($_columns)>1) {
          			$newconfig['arrayeditor'] = true;
          			foreach ($_columns as $_colId=>$_colName) {
                  preg_match("/<(.*)>(.*)/", $_colName, $_LengthName);
                  if ($_LengthName[1] == 0)
                    $_LengthName[1] = 1;
                  array_push($newconfig['editorcolumns'], [$_LengthName[1], $_LengthName[2]]);
                }
              }
              break;
            case 'Tabelle':
              $newconfig['colnames'] = explode(';',$string);
              break;            
            default:


            if (!stristr($string,"=")) {
              $newconfig['colnames'] = explode(';',$string);
            }
            else {
              $init = parse_ini_string ($string,true);
              print_r($init);
              if (is_array($init)) {
            		foreach ($init as $type=>$row) {
                  $newconfig['default']             = explode(';',trim($row['legends']));
                  $newconfig['history_command']     = $row['history'];
                  $newconfig['dateformat']          = $row['dateformat'];
                  $newconfig['fromtemplate']        = $row['fromtemplate'];
                  $newconfig['fromfield']           = $row['fromfield'];
                  $newconfig['frombook']            = $row['frombook'];                  
                  $newconfig['fixedvalues']         = explode(';',trim($row['values']));	
                  $newconfig['restrict_to_open']    = $row['restrict_to_open'] ? true : false;
                  $newconfig['restrict_to_issue']   = $row['restrict_to_issue'];
                  $newconfig['restrict_to_chapter'] = $row['restrict_to_chapter'];
                  $newconfig['restrict_to_book']    = $row['restrict_to_book'] ? true : false;
                  $newconfig['threeDee']            = $row['3d'] ? true : false;
                }
              }
            }
            break;
          }
          
          $field->setConfigSys(json_encode($newconfig))->save($pdo);
        }
    }

    public function preDown($manager)
    {
        // add the pre-migration code here
    }

    public function postDown($manager)
    {
        // add the post-migration code here
    }

    /**
     * Get the SQL statements for the Up migration
     *
     * @return array list of the SQL strings to execute for the Up migration
     *               the keys being the datasources
     */
    public function getUpSQL()
    {
        return array (
  'rokfor' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;


# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

    /**
     * Get the SQL statements for the Down migration
     *
     * @return array list of the SQL strings to execute for the Down migration
     *               the keys being the datasources
     */
    public function getDownSQL()
    {
        return array (
  'rokfor' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;


# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}