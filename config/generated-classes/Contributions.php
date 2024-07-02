<?php

use Base\Contributions as BaseContributions;
use Propel\Runtime\ActiveQuery\Criterion\LikeCriterion;

class Contributions extends BaseContributions
{
  
  private function debuglog($msg) {
    file_put_contents('test.log', "$msg\n", FILE_APPEND);
  }
  
  
  function updateCache() {
    $oneYearAgo = new DateTime();
    $oneYearAgo->modify('-1 year');
    try {
      \ContributionscacheQuery::create()
        ->filterByContribution('%|'.$this->getId().'|%',  \Propel\Runtime\ActiveQuery\Criteria::LIKE) 
        ->_or()
        ->filterByTouched(array('max' => $oneYearAgo->format('Y-m-d H:i:s')))
        ->delete();
    } catch (\Throwable $th) {
     }
    return $this;
  }
  
                
  function checkCache($signature) {
    $criteria = new \Propel\Runtime\ActiveQuery\Criteria();
    $criteria->add('_signature', $signature, \Propel\Runtime\ActiveQuery\Criteria::EQUAL);
    $c = $this->getContributionscaches($criteria);
    if ($c->count() > 0) {
      $c->getFirst()->setTouched(new \DateTime())->save();
      return json_decode($c->getFirst()->getCache());
    }
    return false;
  }
  
}
