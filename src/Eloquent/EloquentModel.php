<?php
namespace DalBench\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string    username
 * @property string    display
 * @property string    id
 */
class EloquentModel extends Model
{
  protected $table = 'mock_ql_daos';
  public $timestamps = false;
}
