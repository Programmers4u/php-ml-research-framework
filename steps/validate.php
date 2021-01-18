<?php
namespace P4u\ML\Research\Validate;

include_once __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/../lib/mlplot/Plot.php';

use P4u\ML\Graphics\Plot\Plot;
use Rubix\ML\Classifiers\KDNeighbors;
use Rubix\ML\CrossValidation\LeavePOut;
use Rubix\ML\CrossValidation\Metrics\Accuracy;
use Rubix\ML\CrossValidation\Metrics\FBeta;
use Rubix\ML\CrossValidation\Metrics\MeanAbsoluteError;
use Rubix\ML\CrossValidation\Metrics\RSquared;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\PersistentModel;
use Rubix\ML\Persisters\Filesystem;
use Rubix\ML\CrossValidation\Reports\AggregateReport;
use Rubix\ML\CrossValidation\Reports\ConfusionMatrix;
use Rubix\ML\CrossValidation\Reports\MulticlassBreakdown;
use Rubix\ML\Graph\Trees\BallTree;
use Rubix\ML\Kernels\Distance\Minkowski;
use Rubix\ML\Kernels\Distance\SafeEuclidean;
use Rubix\ML\NeuralNet\ActivationFunctions\ReLU;
use Rubix\ML\NeuralNet\CostFunctions\LeastSquares;
use Rubix\ML\NeuralNet\Layers\Activation;
use Rubix\ML\NeuralNet\Layers\Dense;
use Rubix\ML\NeuralNet\Optimizers\RMSProp;
use Rubix\ML\Pipeline;
use Rubix\ML\Regressors\KNNRegressor;
use Rubix\ML\Regressors\MLPRegressor;

ini_set('memory_limit', '-1');

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
    ],
    new MLPRegressor([
        new Dense(100),
        new Activation(new ReLU()),
        new Dense(100),
        new Activation(new ReLU()),
        new Dense(50),
        new Activation(new ReLU()),
        new Dense(50),
        new Activation(new ReLU()),
    ], 64, new RMSProp(0.001), 1e-3, 10, 1e-5, 3, 0.1, new LeastSquares(), new RSquared())),
new Filesystem('models/gen.model', false));

$estimatorTested = new KNNRegressor(2, false, new SafeEuclidean());
// $estimatorTested = new KDNeighbors(5, true, new BallTree(30, new Minkowski()));
// $estimatorTested = new RadiusNeighborsRegressor(0.5, true, new BallTree(30, new Diagonal())),
// $estimatorTested = new KDNeighbors(5, true, new BallTree(40, new Minkowski())),
// $estimatorTested = new KNearestNeighbors(3, true, new Manhattan()),
// $estimatorTested = new ExtraTreeRegressor(30, 3, 20, 0.05),
// $estimatorTested = new DBSCAN(4.0, 5, new BallTree(20, new Diagonal()));
// $estimatorTested = new IsolationForest(100, 0.2, 0.05);
// $estimatorTested = new GaussianMLE(0.03);
// $estimatorTested = new Loda(250, 8, 0.01);
// $estimatorTested = new KDNeighbors(5, true, new BallTree(20, new Minkowski()));

// $validator = new KFold($dataset->numRows()/2);
$validator = new LeavePOut($datasetGenerator->numRows()-1);
// $validator = new MonteCarlo(30, 0.1);
// $validator = new HoldOut(0.3);
// $metric = new FBeta();
$metric = new MeanAbsoluteError();
// $metric = new Accuracy();
$score = $validator->test($estimatorTested, $datasetGenerator, $metric);
echo 'validator score: ' ;
var_dump($score);

$predictions = $estimatorTested->predict($test);
echo 'Predictions: ' . PHP_EOL;
print_r($predictions);
echo $test;

Plot::$width = 600;
Plot::$height = 400;
Plot::Line([$predictions],'./doc/validate.png');

// $report = new ConfusionMatrix();
// $results = $report->generate($predictions, $test->labels());
// print_r($results);

