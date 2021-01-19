<?php
namespace P4u\ML\Research\Steps\Predict;

include __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/../lib/autoload.php';

use P4u\ML\Graphics\Plot\Plot;
use P4u\ML\Research\Research;
use Rubix\ML\CrossValidation\Reports\MulticlassBreakdown;
use Rubix\ML\PersistentModel;
use Rubix\ML\Persisters\Filesystem;

ini_set('memory_limit', '-1');

class Predict extends Research {

    public function run(): void
    {
        $train = $this->input['train'];
        $test = $this->input['test'];
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
        
        $estimator = PersistentModel::load(new Filesystem('models/' . $this->modelName . '.model'));
        
        $predictions = $estimator->predict($train);
        
        // print_r($predictions);
        
        $report = new MulticlassBreakdown();
        $results = $report->generate($predictions, $train->labels());
        $results->toArray();
        // print_r( $results );
        
        Plot::$title = 'Predict';
        $data = [
            ['predictions overall accuracy',$results['overall']['accuracy']],
            ['predictions female accuracy',$results['classes']['female']['accuracy']],
            ['predictions male accuracy',$results['classes']['male']['accuracy']]
        ];
        Plot::Bar($data,'./doc/predict.png');
        
        echo PHP_EOL;        
    }
}
