<?php
include_once 'vendor/autoload.php';

//Boot DAL
$resolver = new \Packaged\Dal\DalResolver(
  new \Packaged\Config\Provider\Ini\IniConfigProvider('conf/connections.ini'),
  new \Packaged\Config\Provider\Ini\IniConfigProvider('conf/datastores.ini')
);
$resolver->boot();

//Boot Eloquent
$capsule = new Illuminate\Database\Capsule\Manager;
$capsule->addConnection(
  [
    'driver'    => 'mysql',
    'host'      => '127.0.0.1',
    'database'  => 'packaged_dal',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
  ]
);
$capsule->setEventDispatcher(
  new \Illuminate\Events\Dispatcher(new \Illuminate\Container\Container())
);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$libs = [
  new \DalBench\Dal\DalPdoBench(),
  new \DalBench\Dal\DalCqlBench(),
  new \DalBench\Eloquent\EloquentBench(),
];
shuffle($libs);

\DalBench\Bench::$runs   = 4;
\DalBench\Bench::$perRun = 1000;

/**
 * @var $libs \DalBench\Bench[]
 */
foreach($libs as $lib)
{
  echo "Testing " . get_class($lib) . "\n";
  $lib->execute();
  echo "\n";
}
echo "\n";
