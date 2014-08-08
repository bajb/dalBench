<?php
namespace DalBench\Eloquent;

use DalBench\Bench;

class EloquentBench extends Bench
{
  public function runTest()
  {
    $model           = new EloquentModel();
    $model->id       = 1;
    $model->username = 'random';
    $model->display  = time();
    $model->save();
    $model->display = 'random ' . microtime();
    $model->save();
    $model = null;
    $model = EloquentModel::find(1);
    /**
     * @var $model EloquentModel
     */
    $model->delete();
  }
}
