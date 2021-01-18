<?php

namespace P4u\ML\Research\Steps;

/**
 *  Profil psychologiczny grup społecznych w przedziałach wiekowych
 * Odnalezienie skupisk grup społecznych ze względu na wiek w przestrzeni geograficznej
 * Utworzenie przekazu reklamowego do konkretnej grupy społecznej z uwzgędnieniem profili społecznych
 * Min 3 wersje przekazu
 * Analiza skuteczności
 * Wybór najlepszych cech przekazu reklamowego
 * 
 * Określenie potrzeb grup wiekowej z podziałem na cechy:
 * - płeć
 * - stan cywilny
 * - zainteresowania osobiste (hobby,polityczne)
 * - potrzeby osobiste (wynikające z roli społecznej i statusu [stan cywilny,zawód])
 * - zawód (określenie status w podziale pracy)
 * 
 * Rozkład grup wiekowych na rejony miasta/kraju
 * Oczekiwania względem roli społecznej z uwzględnieniem kultury
 * Oczekiwania względem statusu społecznego z uwzględnieniem kultury
 * Klastrowanie 
 */

/**
 * 
 * Rozkład w regionach kobiet / męzczyzna
 * dobór startegi przekazu
 * Załozenie:
 * W miejscach gdzie wystepuje wiwecej kobiet 25-35 przewazaja czynnik
 * spoleczne determinujące do spełnienia roli społecznek
 * 35-45 real;izacja osobosta maciezycstwo stabilizacja
 * takie czynnik sprawiaj ze przekaz poinien byc inny
 * Jesli zidentyfikujemy uzystkownika jako kobiete z danego regionu
 * to mozemy wyswietlic jej reklame lub tresc zgodnie z najwiekszym prwadopodobientwem zakupu
 * 
 * - płeć obywateli
 * 
 * Steps:
 * - Pobranie bazy danych z Urzędu Statystycznego i przygotowanie danych []
 * - validacja estymatora
 * - trening
 * - predykcja
 * -
 * 
 */

include_once __DIR__ . '/vendor/autoload.php';
include_once __DIR__ . '/lib/mlplot/Plot.php';

use Rubix\ML\Other\Loggers\Screen;

$logger = new Screen();

/**
* Dataset
*/

while (empty($text)) $text = readline("Do you have source raw data from csv or other place?: y/n \n");
if($text === 'y') {
    $logger->info('welcome, start research');

    include './steps/dataset.php';
};
$text = '';

/**
* Generowanie zestawu danych 1000 próbek
*/
  
// while (empty($text)) $text = readline("Do you want start generator?: y/n \n");
// if($text === 'y') {
//     include_once './steps/generator.php';
// };
// $text = '';

/**
* Odkrywanie najlepszegow walidatora
*/

// while (empty($text)) $text = readline("Do you want start testing estimator?: y/n \n");
// if($text === 'y') {
//     include_once './steps/validate.php';
// };
// $text = '';

/**
* Ćwiczenie estymatora
*/

// while (empty($text)) $text = readline("Do you want start training?: y/n \n");
// if($text === 'y') {
//     include_once './steps/train.php';
// };
// $text = '';

/**
* Prognozowanie
*/

// while (empty($text)) $text = readline("Do you want predict?: y/n \n");
// if($text === 'y') {
//     include_once './steps/predict.php';
// };
// $text = '';

/**
* Wyszukiwanie anomali [cech]
*/

/**
* Uczenie ze wzmocnieniem [RL]
*/

/**
* Zapisz zestaw danych
*/
