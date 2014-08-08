<?php
namespace DalBench\Dal;

use Packaged\Dal\Ql\QlDao;

class MySQLiDao extends QlDao
{
  public $id;
  public $username;
  public $display;

  protected function _configure()
  {
    $this->_setDataStoreName('mysqlids');
  }

  public function getTableName()
  {
    return 'mock_ql_daos';
  }
}
