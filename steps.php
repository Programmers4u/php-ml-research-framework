<?php

namespace P4u\ML\Research\Steps;

/**
 * * * BADANIE 1 * * *
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
 * * * Realizacja * * *
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
 * * * Steps * * *
 * - Pobranie bazy danych z Urzędu Statystycznego i przygotowanie danych []
 * - validacja estymatora
 * - trening
 * - validacja
 * - predykcja
 * - dist
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
