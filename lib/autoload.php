<?php

/*Directories that contain classes*/

$classesDir = array (
    __DIR__ . '/src/',
    __DIR__ . '/mplot/',
    __DIR__ . '/../steps/',
);

foreach ($classesDir as $directory) {
    foreach (glob("{$directory}/*.php") as $filename) {
        include_once $filename;
    }
}