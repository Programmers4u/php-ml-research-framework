<?php

namespace P4u\ML\Research\Steps;

/*** STUDY 1 ***
  *
  * What do population statistics tell us?
  *
  * We know from psychological research that a general psychological profile can be created based on
  * type and age.
  *
  * Assumption:
  *
  * In places where there are many of the same or similar objects, social factors prevail
  * determining the fulfillment of a social role appropriate to the culture and social status.
  *
  * Age range:
  * 24 - 35 factors: social implementation
  * 35 - 45 factors: personal implementation
  * 45 - 55 factors:
  *
  * What can this give us?
  *
  * We can find out where on the map certain clusters are located and then
  * emit an appropriately targeted message.
  *
  * We can identify gender in a simple and general way if we know the area the visitor comes from
  * e.g.: IP address, city, street
  *
  * We can compare this data with environmental data, e.g. air composition and/or medical data
  * frequency of disease.
  *
  * Analyzing the age of groups will help you find out where there is a high probability
  * new property due to mortality.
  *
  * Summary of services in a given area in relation to density and type
  *
  * We can find out what business to open
  *
  * Finding clusters of social groups based on age in geographical space
  *
  *** Realization ***
  *
  * Creating an advertising message for each social group [age], taking into account social profiles
  *Min 3 versions of the message
  *
  * Effectiveness analysis -> Selection of the best features of the advertising message -> Application -> Effectiveness analysis
  *
  * Determining the needs of the age group divided into characteristics:
  * - sex
  * - marital status
  * - personal interests (hobby, political)
  * - personal needs (resulting from social role and status [marital status, profession])
  * - profession (determination of status in the division of labor)
  *
  * Distribution of age groups and types by areas: streets / districts / cities / countries
  *
  * Determining social expectations:
  * Expectations regarding social role, taking into account culture
  * Expectations regarding social status, taking into account culture
  *
  *
  ***Steps***
  * - Downloading the database from the Statistical Office and preparing the data
  * - validation and selection of estimator
  * - training
  * - validation
  * - prediction
  * - dist
  */

include_once __DIR__ . '/vendor/autoload.php';
include_once __DIR__ . '/lib/autoload.php';

use P4u\ML\Research\Steps\Dataset\Dataset;
use P4u\ML\Research\Steps\Generator\Generator;
use P4u\ML\Research\Steps\Validate\Validate;

use P4u\ML\Research\Research;
use P4u\ML\Research\IDataset\IDataset;
use P4u\ML\Research\IGenerator\IGenerator;
use P4u\ML\Research\IPredict\IPredict;
use P4u\ML\Research\ITrain\ITrain;
use P4u\ML\Research\IValidate\IValidate;
use P4u\ML\Research\Steps\Predict\Predict;
use P4u\ML\Research\Steps\Train\Train;
use Rubix\ML\Other\Loggers\Screen;

if(!is_dir(__DIR__ . '/temp')) mkdir(__DIR__ . '/temp');
// if(!is_file(__DIR__ . '/temp/disable.step'))  touch(__DIR__ . '/temp/disable.step');
// $disabledStep = json_decode(file_get_contents('./temp/disable.step'));

class Steps extends Research implements 
    IDataset, 
    IValidate, 
    ITrain, 
    IGenerator,
    IPredict {
    
    protected $dataset;
    protected $datasetGenertion;
    protected $estimator;

    public function run() : void {

        $this->setLogger(new Screen());        
        
        /**
        * Dataset
        */

        $answer = $this->ask("Do you have source raw data from csv or other place?: y/n", "y");
        if(!$answer) exit;

        $this->info('welcome, start research');
        $this->setData();

        /**
        * Validator
        */

        $answer = $this->ask("Do you want start validate estimator?: y/n", "y");
        if($answer) {
            $this->setValidate();
            $answer = $this->ask("Do you want save model or exit?: y/n", "y");
            if($answer) $this->estimator->save();
        }

        /**
        * Generating a dataset of 1000 samples
        */

        $answer = $this->ask("Do you want start generator?: y/n", "y");
        if($answer) $this->datasetGenertion = $this->setGenerator();
  
        /**
        * Estimator training
        */

        $answer = $this->ask("Do you want start training?: y/n ","y");
        if($answer) $this->setTrain();

        /**
        * Forecasting
        */
        $answer = $this->ask("Do you want predict?: y/n ","y");
        if($answer) $this->setPredict();

        /**
        * Search for anomalies [features]
        */

        /**
        * Reinforcement learning [RL]
        */

        /**
        * Save the data set
        */
    }

    public function setPredict(): void
    {
        new Predict($this->testData());
    }

    public function setGenerator(): void
    {
        $this->datasetGenertion = new Generator();
    }

    public function setTrain(): void
    {
        new Train($this->trainData());
    }

    public function setValidate() : void
    {
        $this->estimator = new Validate($this->dataset);    
    }

    public function setData() : void
    {
        $data = new Dataset();
        $this->dataset = $data->result();
    }

    public function testData() : array
    {
        return $this->dataset['test'];
    }

    public function trainData() : array
    {
        return $this->dataset['train'];        
    }
}

$research = new Steps();
exit;
