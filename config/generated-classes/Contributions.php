<?php

use Base\Contributions as BaseContributions;

class Contributions extends BaseContributions
{

  function updateCache() {
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
