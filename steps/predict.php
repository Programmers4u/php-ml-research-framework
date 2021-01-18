<?php
namespace P4u\ML\Research\Predict;

include __DIR__ . '/../vendor/autoload.php';

use Rubix\ML\CrossValidation\Reports\MulticlassBreakdown;
use Rubix\ML\PersistentModel;
use Rubix\ML\Persisters\Filesystem;

ini_set('memory_limit', '-1');

echo $test;

// $check = new DummyRegressor(new Percentile(56.5));
// $check->train($train);
// $ch = $check->predict($res);
// var_dump($ch);
// $scores = $estimator->score($dataset);
// var_dump($scores);


// $scores = $estimator->scores();
// $losses = $estimator->steps();
// $writer = Writer::createFromPath('doc/progress.csv', 'w+');
// $writer->insertOne(['score', 'loss']);
// $writer->insertAll(array_transpose([$scores, $losses]));
// echo 'Progress saved to doc/progress.csv' . PHP_EOL;

// $m = $estimator->means();
// $v =  $estimator->variances();
// var_dump($m,$v);

// while (empty($text)) $text = readline("Enter some text to analyze: \n");
// $dataset = new UnLabeled([explode(' ', $text)]);

$estimator = PersistentModel::load(new Filesystem('models/default.model'));

$predictions = $estimator->predict($train);

print_r($predictions);

$report = new MulticlassBreakdown();
$results = $report->generate($predictions, $dataset->labels());
print_r( $results );

echo PHP_EOL;