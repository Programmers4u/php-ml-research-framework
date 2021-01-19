<?php

namespace P4u\ML\Research\Steps\Generator;

use P4u\ML\Research\Research;
use Rubix\ML\Datasets\Generators\Hyperplane;
    
ini_set('memory_limit', '-1');

class Generator extends Research {
    
    public function run(): void
    {
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
         
        $this->output = [
            'train' => $train,
            'test' => $test
        ];             
    }
}