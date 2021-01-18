<?php

namespace P4u\ML\Research\Train;

include_once __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/../lib/mlplot/Plot.php';

use P4u\ML\Graphics\Plot\Plot;
use Rubix\ML\CrossValidation\Reports\MulticlassBreakdown;
use Rubix\ML\Other\Loggers\Screen;
use Rubix\ML\PersistentModel;
use Rubix\ML\Persisters\Filesystem;

ini_set('memory_limit', '-1');

define('MODEL_NAME','research_1');

$estimator = PersistentModel::load(new Filesystem('models/' . MODEL_NAME . '.model'));

// $estimator = 
// new PersistentModel(
//     $estimatorTested,
//     new Filesystem('models/' . MODEL_NAME . '.model', false)
// );
    
$estimator->setLogger(new Screen(MODEL_NAME));

$estimator->train($train);

// $report = new ConfusionMatrix();
// $report = new MulticlassBreakdown();
// $results = $report->generate($predictions, $test->take(3)->labels());
// $results->toArray();
// print_r($results);

// $scores = $estimator->scores();
// $losses = $estimator->steps();

// Plot::$title = 'Training';
// $data = [
//     ['score',$scores],
//     ['losses',$losses]
// ];
// Plot::Line($data,'./doc/training.png');

while (empty($text)) $text = readline("Do you want save model?: y/n \n");
if($text === 'y') $estimator->save();
$text = '';