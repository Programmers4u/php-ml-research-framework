<?php
namespace P4u\ML\Dist\Predict\Server;

include __DIR__ . '/../vendor/autoload.php';

use Rubix\ML\PersistentModel;
use Rubix\ML\Persisters\Filesystem;

ini_set('memory_limit', '-1');

$estimator = PersistentModel::load(new Filesystem('models/default.model'));

$prediction = $estimator->predictSample([$argv[1]]);

echo $prediction . PHP_EOL;
