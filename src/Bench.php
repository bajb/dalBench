<?php
namespace DalBench;

abstract class Bench
{
  public static $runs = 4;
  public static $perRun = 2000;

  public function execute()
  {
    echo "\n";
    $format = "%6s%18s%18s%25s%25s%15s%15s\n";
    echo sprintf(
      $format,
      "Run ID",
      "Avg Time",
      "Total Time",
      "Raw Avg Time",
      "Raw Total Time",
      "Avg Memory",
      "Global Memory"
    );
    echo "\n";
    $total            = [];
    $total['avgtest'] = $total['runtime'] =
    $total['avgmem'] = $total['runmem'] =
    $total['runs'] = 0;

    for($runi = 0; $runi < self::$runs; $runi++)
    {
      $tests        = $mem = [];
      $runStartTime = microtime(true);
      for($testi = 0; $testi < self::$perRun; $testi++)
      {
        $testStartTime = microtime(true);
        $memRunStart   = memory_get_usage();
        $this->runTest();
        $mem[]   = memory_get_usage() - $memRunStart;
        $tests[] = microtime(true) - $testStartTime;
        if($runi == 0)
        {
          break;
        }
      }

      $run['runmem'] = memory_get_usage();
      $run['avgmem'] = array_sum($mem) / count($mem);

      $run['runtime'] = microtime(true) - $runStartTime;
      $run['avgtest'] = array_sum($tests) / count($tests);

      echo sprintf(
        $format,
        ($runi == 0 ? 'single' : $runi),
        (number_format(($run['avgtest'] * 1000), 3) . ' ms'),
        (number_format(($run['runtime'] * 1000), 3) . ' ms'),
        $run['avgtest'],
        $run['runtime'],
        number_format($run['avgmem']),
        number_format($run['runmem'])
      );

      $total['avgtest'] += $run['avgtest'];
      $total['runtime'] += $run['runtime'];

      $total['avgmem'] += $run['avgmem'];
      $total['runmem'] += $run['runmem'];

      $total['runs']++;
    }

    echo "\n";
    echo sprintf(
      $format,
      "Total",
      (number_format(($total['avgtest'] / $total['runs'] * 1000), 3) . ' ms'),
      (number_format(($total['runtime'] * 1000), 3) . ' ms'),
      ($total['avgtest'] / $total['runs']),
      ($total['runtime']),
      number_format($total['avgmem'] / $total['runs']),
      number_format(memory_get_usage())
    );

    echo "\n";
    echo "Total Tests Run: " . number_format(
        ((self::$runs - 1) * self::$perRun) + 1,
        0
      );
    echo "\n";

    $this->shutdown();
  }

  abstract public function runTest();

  public function shutdown()
  {
  }
}
