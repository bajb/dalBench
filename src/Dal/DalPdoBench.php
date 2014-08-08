<?php
namespace DalBench\Dal;

use DalBench\Bench;

class DalPdoBench extends Bench
{
  public function runTest()
  {
    $dao           = new PdoDao();
    $dao->id       = 1;
    $dao->username = 'random';
    $dao->display  = time();
    $dao->save();
    $dao->display = 'random ' . microtime();
    $dao->save();
    $dao     = null;
    $dao     = new PdoDao();
    $dao->id = 1;
    $dao->load();
    $dao->delete();
  }
}
