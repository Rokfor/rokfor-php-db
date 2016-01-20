<?php

use Base\Data as BaseData;

/**
 * Skeleton subclass for representing a row from the '_data' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Data extends BaseData
{

  /**
   * creates history values for reference fields
   *
   * @return void
   * @author Urs Hofer
   */
  function getHistory()
  {
    return ([
      ["id"=>-1,"value"=>"Value -1"],
      ["id"=>0,"value"=>"Value 0"],
      ["id"=>1,"value"=>"Value 1"],
      ["id"=>2,"value"=>"Value 2"],
      ["id"=>'Forum',"value"=>"Forum"],
      ["id"=>4,"value"=>"Value 4"],
      ["id"=>5,"value"=>"Value 5"]
    ]);
  }
  
  /**
   * returns data alsways as array, even the underlying content is no array.
   *
   * @return void
   * @author Urs Hofer
   */
  function getDataAlwaysAsArray()
  {
    $data = json_decode($this->getContent());
    return (!is_array($data)?[$data]:$data);
  }

}
