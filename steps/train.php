<?php

namespace P4u\ML\Research\Steps\Train;

use P4u\ML\Research\Research;
use Rubix\ML\Other\Loggers\Screen;
use Rubix\ML\PersistentModel;
use Rubix\ML\Persisters\Filesystem;

ini_set('memory_limit', '-1');
class Train extends Research {

    public function run() : void {
        $train = $this->input;

        $estimator = PersistentModel::load(new Filesystem('models/' . $this->modelName . '.model'));

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

        while (empty($text)) $text = readline("Do you want disable validate?: y/n \n");
        if($text === 'y') {
            file_put_contents('./temp/disable.step', json_encode(['validate']));
        }
        $text = '';    
    }
}    