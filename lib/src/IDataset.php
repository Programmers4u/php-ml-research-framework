<?php

namespace P4u\ML\Research\IDataset;

interface IDataset {
    public function setData() : void;
    public function testData() : array;
    public function trainData() : array;
}
