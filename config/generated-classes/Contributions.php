<?php

use Base\Contributions as BaseContributions;

class Contributions extends BaseContributions
{

  function updateCache() {
    // This might be a little bit strict but
    // ensures, that caches of related contributions 
    // are deleted as well
    foreach ($this->getRDatas() as $r) {
      $r->getContributions()
        ->getContributionscaches()
        ->delete();
    }
    foreach ($this->getDatas() as $f) {
      foreach ($f->getRDataRefs() as $c) {
        $c->getContributions()
          ->getContributionscaches()
          ->delete();
      }
      foreach ($f->getRContributions() as $c) {
        $c->getContributionscaches()
          ->delete();
      }
    }
    $this->getContributionscaches()->delete();
    return $this;
  }
  
  function checkCache($signature) {
    $criteria = new \Propel\Runtime\ActiveQuery\Criteria();
    $criteria->add('_signature', $signature, \Propel\Runtime\ActiveQuery\Criteria::EQUAL);
    $c = $this->getContributionscaches($criteria);
    if ($c->count() > 0) {
      return json_decode($c->getFirst()->getCache());
    }
    return false;
  }

}
