<?php
namespace DalBench\Dal;

use Packaged\Dal\Ql\QlDao;

class PdoDao extends QlDao
{
  public $id;
  public $username;
  public $display;

  protected function _configure()
  {
    $this->_setDataStoreName('pdods');
  }

  public function getTableName()
  {
    return 'mock_ql_daos';
  }
}
