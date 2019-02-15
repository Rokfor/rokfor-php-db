<?php

use Base\Contributions as BaseContributions;

class Contributions extends BaseContributions
{
  
  private function debuglog($msg) {
    file_put_contents('test.log', "$msg\n", FILE_APPEND);
  }
  
  
  private function my_validate($value, &$stack){
    foreach ($value->Data as $k=>$v) {
      if ($v->Reference && $v->ReferenceType == 'Contributional') {
        
        // Related Contributions
        foreach ($v->Content as $_v) {
          if (in_array($_v, $stack) === false) {
            $stack[] = $_v;
          }
        }
        
        // Recursion
        foreach ((array)$v->Reference as $_k=>$_v) {
          $this->my_validate($_v, $stack);
        }
      }
    }
    foreach ($value->Contribution->ReferencedFrom as $k=>$v) {
      if (in_array($v->Contribution->Id, $stack) === false) {
        $stack[] = $v->Contribution->Id;
      }
      $this->my_validate($v, $stack);
    }
  }
  
  private function recursiveDelete($contribution) {
    $s = [];
    $s[] = $contribution->getId();

    

    foreach ($contribution->getContributionscaches() as $_cache) {
      $_data = json_decode($_cache->getCache());
      $this->my_validate($_data, $s);
    }

    foreach (\ContributionscacheQuery::create()
      ->filterByCache('%Contribution":{"Id":'.$contribution->getId().'%') 
      ->_or()
      ->filterByCache('%"'.$contribution->getId().'":%') 
        as $_cache) {
      //$this->debuglog("ADDING: ".print_r($_cache->getId(), true));
      $s[] = $_cache->getForcontribution();
      $_data = json_decode($_cache->getCache());
      $this->my_validate($_data, $s);
    }
    return $s;
  }
  

  function updateCacheLegacy() {
    // This might be a little bit strict but
    // ensures, that caches of related contributions
    // are deleted as well

    // Clearing Contributions with Data referring to this contribution

    foreach ($this->getRDatas() as $r) {
      try {
        $r->getContributions()
          ->getContributionscaches()
          ->delete();
      } catch (Exception $e) {}
    }

    // Cycle thru fields

    foreach ($this->getDatas() as $f) {

      // Field to Contribution
      //  Gets an array of ChildRDataContribution objects which
      //  contain a foreign key that references this object.

      foreach ($f->getRDataContributions() as $c) {
        try {
          $c->getRContribution()
            ->getContributionscaches()
            ->delete();
        } catch (Exception $e) {}

      }

      // Field to Field
      //  Gets a collection of ChildData objects
      //  related by a many-to-many relationship

      foreach ($f->getRDataRefs() as $c) {
        try {
          $c->getContributions()
            ->getContributionscaches()
            ->delete();
        } catch (Exception $e) {}
      }

      // Many to Many Relations...

      foreach ($f->getRContributions() as $c) {
        try {
          $c->getContributionscaches()
            ->delete();
        } catch (Exception $e) {}
      }
    }
    $this->getContributionscaches()->delete();
    return $this;
  }



  function updateCache() {
    $w = $this->recursiveDelete($this);
    sort($w);
    
    //$this->debuglog("WALKED: ".print_r($w, true));
    //$this->debuglog("COUNT: ".print_r(count($w), true));
    
    if (count($w) > 0) {
      try {
        $_caches = \ContributionscacheQuery::create()
        ->filterByForcontribution($w)
        ->delete();
      } catch (\Throwable $th) { }
    }
    
    $this->updateCacheLegacy();

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
