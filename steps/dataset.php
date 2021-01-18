<?php

namespace P4u\ML\Research\Dataset;

include_once __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/../lib/mlplot/Plot.php';

use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Datasets\Unlabeled;
use Rubix\ML\Extractors\ColumnPicker;
use Rubix\ML\Extractors\CSV;
use Rubix\ML\Other\Loggers\Screen;
use Rubix\ML\Transformers\NumericStringConverter;
use Rubix\ML\Transformers\OneHotEncoder;
use Rubix\ML\Transformers\RandomHotDeckImputer;
use Rubix\ML\Transformers\ZScaleStandardizer;

/**
  * Dataset
  */
    
ini_set('memory_limit', '-1');

$logger = new Screen();

$logger->info('Preprocessing');
$logger->info('Loading data into memory');

$male = 'train/sample2/male.csv';
$female = 'train/sample2/female.csv';

$extractorMale = new ColumnPicker(new CSV($male, true),['Kod','2019','Nazwa']);
$extractorMale = iterator_to_array($extractorMale);
$logger->info('Generate male labels');
$extractorMale = array_map(function($item){
    $item['gender'] = 'male';
    return $item;
}, $extractorMale);

$datasetMale = Labeled::fromIterator($extractorMale);
$logger->info('Male dataset');
echo $datasetMale;

$extractorFemale = new ColumnPicker(new CSV($female, true),['Kod', 'ogółem;kobiety;2019;[osoba]', 'Nazwa']);
$extractorFemale = iterator_to_array($extractorFemale);
$logger->info('Generate female labels');
$extractorFemale = array_map(function($item){
    $item['gender'] = 'female';
    return $item;
},$extractorFemale);

$datasetFemale = Labeled::fromIterator($extractorFemale);
$logger->info('female dataset');
echo $datasetFemale;

$logger->info('Merge to dataset');

$dataset = $datasetMale->merge($datasetFemale);

$logger->info('Dataset samples: ' . $dataset->numRows());

$dataset->sortByColumn(1);
echo $dataset;

// $dataset->deduplicate();
// $dataset->sortByLabel();
$logger->info('Dataset samples randomize and take 100');
$dataset = $dataset->randomize()->take(100);
$dataset->transformColumn(0, function ($value) {
    return empty($value) ? NAN : $value;
});
$dataset->transformColumn(1, function ($value) {
    return empty($value) ? NAN : $value;
});

echo $dataset;
// $dataset->filterByColumn(2, function($item){
//     return preg_match('/Nowe Warpno.*/isU',$item);    
// });

// echo $dataset;

exit;

$logger->info('Dataset transform');
$dataset
    ->apply(new RandomHotDeckImputer())
    ->apply(new NumericStringConverter())
    ->apply(new OneHotEncoder())
    ->apply(new ZScaleStandardizer())
    ;
$logger->info('Dataset split 0.8');
[$train, $test] = $dataset->split(0.8);

$logger->info('Train samples: ' . count($train));
echo $train;

$logger->info('Label type: ' . $dataset->labelType());

// $dataset->transformLabels('floatval');
// echo $dataset->describe();