<?php
namespace P4u\ML\Research\Steps\Validate;

include_once __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/../lib/autoload.php';

use P4u\ML\Graphics\Plot\Plot;
use P4u\ML\Research\Research;
use Rubix\ML\Classifiers\KDNeighbors;
use Rubix\ML\CrossValidation\LeavePOut;
use Rubix\ML\CrossValidation\Metrics\Accuracy;
use Rubix\ML\CrossValidation\Metrics\FBeta;
use Rubix\ML\PersistentModel;
use Rubix\ML\Persisters\Filesystem;
use Rubix\ML\CrossValidation\Reports\MulticlassBreakdown;
use Rubix\ML\Graph\Trees\BallTree;
use Rubix\ML\Kernels\Distance\Minkowski;
use Rubix\ML\Other\Loggers\Screen;
use Rubix\ML\Pipeline;

ini_set('memory_limit', '-1');
class Validate extends Research {

    public function run() : void {
        $logger = new Screen();
        $test = $this->input['test'];
        $train = $this->input['train'];

        // $estimatorTested = new MLPRegressor([
        //     new Dense(100),
        //     new Activation(new ReLU()),
        //     new Dense(100),
        //     new Activation(new ReLU()),
        //     new Dense(50),
        //     new Activation(new ReLU()),
        //     new Dense(50),
        //     new Activation(new ReLU()),
        // ], 64, new RMSProp(0.001), 1e-3, 10, 1e-5, 3, 0.1, new LeastSquares(), new RSquared());
        // $estimatorTested = new KNNRegressor(2, false, new SafeEuclidean());
        // $estimatorTested = new KDNeighbors(5, true, new BallTree(30, new Minkowski()));
        // $estimatorTested = new RadiusNeighborsRegressor(0.5, true, new BallTree(30, new Diagonal())),
        // $estimatorTested = new KDNeighbors(5, true, new BallTree(40, new Minkowski())),
        // $estimatorTested = new KNearestNeighbors(3, true, new Manhattan()),
        // $estimatorTested = new ExtraTreeRegressor(30, 3, 20, 0.05),
        // $estimatorTested = new DBSCAN(4.0, 5, new BallTree(20, new Diagonal()));
        // $estimatorTested = new IsolationForest(100, 0.2, 0.05);
        // $estimatorTested = new GaussianMLE(0.03);
        // $estimatorTested = new Loda(250, 8, 0.01);
        $estimatorTested = new KDNeighbors(5, true, new BallTree(20, new Minkowski()));

        // $validator = new KFold($dataset->numRows()/2);
        $validator = new LeavePOut($test->numRows()-1);
        // $validator = new MonteCarlo(30, 0.1);
        // $validator = new HoldOut(0.3);
        $metric = new FBeta();
        // $metric = new MeanAbsoluteError();
        $FBeta = $validator->test($estimatorTested, $test, $metric);
        $metric = new Accuracy();
        $score = $validator->test($estimatorTested, $test, $metric);
        $logger->info('validator FBeta: ' . $FBeta);
        $logger->info('validator score: ' . $score);

        Plot::$title = 'Validate';
        Plot::$width = 800;
        Plot::$height = 600;
        $data = [
            ['FBeta',1,$FBeta],
            ['score',1,$score]
        ];
        Plot::Line($data,'./doc/validate.png');

        $predictions = $estimatorTested->predict($train->take(3));
        echo 'Predictions: ' . PHP_EOL;
        print_r($predictions);
        echo $test->take(3);

        // $report = new ConfusionMatrix();
        $report = new MulticlassBreakdown();
        $results = $report->generate($predictions, $test->take(3)->labels());
        $results->toArray();
        // print_r($results);

        Plot::$title = 'Validate predict';
        $data = [
            ['predictions score',$results['overall']['accuracy']],
            ['validate score',$score]
        ];
        Plot::Bar($data,'./doc/validate-predict.png');

        $estimator = 
        new PersistentModel(
            new Pipeline([
                // new MissingDataImputer(),
                // new HTMLStripper(),
                // new TextNormalizer(),
                // new MultibyteTextNormalizer(),
                // new NumericStringConverter(),
                // new KNNImputer(10, false, '?', new BallTree(30, new SafeEuclidean())),
                // new WordCountVectorizer(10000, 3, 10000, new NGram(1, 2)),
                // new OneHotEncoder(),
                // new L2Normalizer(),
                // new TfIdfTransformer(),
                // new ZScaleStandardizer(),
            ], $estimatorTested),
        new Filesystem('models/'. $this->modelName .'.model', false));

        $this->output = $estimator;
    }
}