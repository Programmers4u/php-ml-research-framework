<?php

namespace P4u\ML\Research\Steps;

/**
 *** BADANIE 1 ***
 * 
 * Co mówi nam statystyka dotycząca ludności?
 * 
 * Z badań psychologicznych wiemy ze mozna stworzyc ogólny profil psychologiczny na podstawie
 * rodzaju oraz wieku.
 *
 * Załozenie:
 * 
 * W miejscach gdzie występuje duzo takich samych lub podobnych obiektów - przewazają czynniki społeczne 
 * determinujące do spełnienia roli społecznej adekwatnej do kultury i satusu społecznego.
 * 
 * Przedział wiekowy:
 * 24 - 35 czynniki: realizacja społeczna
 * 35 - 45 czynniki: realizacja osobista
 * 45 - 55 czynniki: 
 * 
 * Co moze nam to dać?
 * 
 * Mozemy dowiedzieć się w których miejscach na mapie znajdują się dane skupiska i następnie
 * emitować odpowiedno skierowany przekaz.
 * 
 * Mozemy identyfikować w prosty i ogólny sposób płeć jeśli znamy obszar z którego pochodzi odwiedzający
 * np.: adres IP, miejscowość, ulica
 * 
 * Moemy zestawić te dane z danymi środowiskowymi, np.: skład powierzta lub/i medycznym 
 * częstotliwośc zapadania na choroby.
 * 
 * Analiza wieku grup pomoze dowiedziec się gdzie jest duze prawdopodobienstwo 
 * nowych nieruchomość ze względu na umieralność.
 * 
 * Zestawienie usług w danym  obszarze w odniesieniu do zagęszczenia i rodzaju 
 * 
 * Moemy dowiedzieć się jaki biznes otworzyć
 * 
 * Odnalezienie skupisk grup społecznych ze względu na wiek w przestrzeni geograficznej
 * 
 *** Realizacja ***
 * 
 * Utworzenie przekazu reklamowego do kazdej grupy społecznej [wiek] z uwzgędnieniem profili społecznych
 * Min 3 wersje przekazu
 * 
 * Analiza skuteczności -> Wybór najlepszych cech przekazu reklamowego -> Zastosowanie -> Analiza skuteczności
 * 
 * Określenie potrzeb grup wiekowej z podziałem na cechy:
 * - płeć
 * - stan cywilny
 * - zainteresowania osobiste (hobby,polityczne)
 * - potrzeby osobiste (wynikające z roli społecznej i statusu [stan cywilny,zawód])
 * - zawód (określenie status w podziale pracy)
 * 
 * Rozkład grup wiekowych i rodzaju na rejony: ulice / dzielnice / miasta / państwa
 * 
 * Określenie oczekiwań społecznych:
 * Oczekiwania względem roli społecznej z uwzględnieniem kultury
 * Oczekiwania względem statusu społecznego z uwzględnieniem kultury
 * 
 */

/**
 *** Steps ***
 * - Pobranie bazy danych z Urzędu Statystycznego i przygotowanie danych
 * - validacja i wybór estymatora
 * - trening
 * - validacja
 * - predykcja
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
        * Generowanie zestawu danych 1000 próbek
        */

        $answer = $this->ask("Do you want start generator?: y/n", "y");
        if($answer) $this->datasetGenertion = $this->setGenerator();
  
        /**
        * Estimator training
        */

        $answer = $this->ask("Do you want start training?: y/n ","y");
        if($answer) $this->setTrain();

        /**
        * Prognozowanie
        */
        $answer = $this->ask("Do you want predict?: y/n ","y");
        if($answer) $this->setPredict();

        /**
        * Wyszukiwanie anomali [cech]
        */

        /**
        * Uczenie ze wzmocnieniem [RL]
        */

        /**
        * Zapisz zestaw danych
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