<?php

namespace P4u\ML\Research\Steps\Dataset;

include_once __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/../lib/autoload.php';

use P4u\ML\Research\Research;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Datasets\Unlabeled;
use Rubix\ML\Extractors\ColumnPicker;
use Rubix\ML\Extractors\CSV;
use Rubix\ML\Other\Loggers\Screen;
use Rubix\ML\Transformers\NumericStringConverter;
use Rubix\ML\Transformers\OneHotEncoder;
use Rubix\ML\Transformers\RandomHotDeckImputer;
use Rubix\ML\Transformers\WordCountVectorizer;
use Rubix\ML\Transformers\ZScaleStandardizer;

ini_set('memory_limit', '-1');

class Dataset extends Research {

    public function run() : void {

        $this->logger = new Screen();

        $this->info('Preprocessing');
        $this->info('Loading data into memory');
        
        $male = 'train/sample2/male.csv';
        $female = 'train/sample2/female.csv';
        
        $extractorMale = new ColumnPicker(new CSV($male, true),['Kod','2019','Nazwa']);
        $extractorMale = iterator_to_array($extractorMale);
        $this->info('Generate male labels');
        $extractorMale = array_map(function($item){
            $item['gender'] = 'male';
            return $item;
        }, $extractorMale);
        
        $datasetMale = Labeled::fromIterator($extractorMale);
        $this->info('Male dataset');
        echo $datasetMale;
        
        $extractorFemale = new ColumnPicker(new CSV($female, true),['Kod', 'ogółem;kobiety;2019;[osoba]', 'Nazwa']);
        $extractorFemale = iterator_to_array($extractorFemale);
        $this->info('Generate female labels');
        $extractorFemale = array_map(function($item){
            $item['gender'] = 'female';
            return $item;
        },$extractorFemale);
        
        $datasetFemale = Labeled::fromIterator($extractorFemale);
        $this->info('female dataset');
        echo $datasetFemale;
        
        $this->info('Merge to dataset');
        
        $dataset = $datasetMale->merge($datasetFemale);
        
        $this->info('Dataset samples: ' . $dataset->numRows());
        
        $dataset->sortByColumn(1);
        // $dataset->sortByLabel();
        // $dataset->deduplicate();
        echo $dataset;
        
        $this->info('Dataset samples randomize and take 100');
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
        
        $this->info('Dataset transform');
        $dataset
            ->apply(new WordCountVectorizer())
            ->apply(new RandomHotDeckImputer())
            ->apply(new NumericStringConverter())
            ->apply(new OneHotEncoder())
            ->apply(new ZScaleStandardizer())
            ;
        $this->info('Dataset split 0.8');
        [$train, $test] = $dataset->split(0.8);
        
        $this->info('Train samples: ' . count($train));
        echo $train;
        
        $this->info('Label type: ' . $dataset->labelType());
        
        // $dataset->transformLabels('floatval');
        // echo $dataset->describe();

        $this->output = [
            'train' => $train, 
            'test' => $test
        ];
    } 
    
}