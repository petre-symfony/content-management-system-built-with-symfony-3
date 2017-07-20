<?php
namespace AppBundle\DataFixtures\ORM\Dev;

use Hautelook\AliceBundle\Doctrine\DataFixtures\AbstractLoader;

class DataLoader extends AbstractLoader{
  public function getFixtures(){
    return [
      __DIR__.'/../Fixtures/fixtures.yml'
    ];
  }
}
