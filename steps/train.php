<?php

namespace P4u\ML\Research\Train;

include_once __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/../mlplot/Plot.php';

use P4u\ML\Graphics\Plot\Plot;
use Rubix\ML\PersistentModel;
use Rubix\ML\Persisters\Filesystem;

ini_set('memory_limit', '-1');

$estimator = 
new PersistentModel(
    $estimatorTested,
    new Filesystem('models/default.model', false)
);
    
echo 'Training ...' . PHP_EOL;
// $estimator->setLogger(new Screen('gen'));
$estimator->train($train);

$scores = $estimator->scores();
$losses = $estimator->steps();

Plot::$width = 800;
Plot::$height = 600;
Plot::Line([$scores,$losses],'./doc/progress.png');

while (empty($text)) $text = readline("Do you want save model?: y/n \n");
if($text === 'y') $estimator->save();
$text = '';