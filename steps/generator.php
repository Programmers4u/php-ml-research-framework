<?php

namespace P4u\ML\Research\Generator;

include_once __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/../lib/mlplot/Plot.php';

use Rubix\ML\Datasets\Generators\Hyperplane;
use Rubix\ML\Kernels\Distance\Euclidean;
use Rubix\ML\Transformers\NumericStringConverter;
use Rubix\ML\Transformers\OneHotEncoder;
use Rubix\ML\Transformers\RandomHotDeckImputer;
use Rubix\ML\Transformers\ZScaleStandardizer;

/**
* Generator
*/
    
ini_set('memory_limit', '-1');

$generator = new Hyperplane([1,1,0]);
$datasetGenerator = $generator->generate(1000);
// print_r($datasetGenerator->labels());
echo $datasetGenerator->take(3);
    
[$train, $test] = $datasetGenerator->split(0.99);

// $estimator = new KMeans(3, 128, 300, 10.0, 10, new Euclidean(), new PlusPlus());
// $estimator->train($train);
    
// $predictions = $estimator->predict($test);
// print_r($predictions);
// $proba = $estimator->proba($test);
// print_r($proba);
// $report = new ContingencyTable();
// $results = $report->generate($predictions, $test->labels());
// print_r($results);
    
// $data = array_map(function($item,$key) {
//     return ['predict',$key,$item];
// }, $proba, array_keys($proba));
// print_r($data[0]);

// PlotPlot::$width = 600;
// PlotPlot::$height = 400;
// PlotPlot::stackedArea($proba,'./doc/report.png');

