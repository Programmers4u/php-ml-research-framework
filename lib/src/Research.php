<?php

namespace P4u\ML\Research;

use P4u\ML\Research\IResearch\IResearch;

class Research implements IResearch {

    protected $input;
    protected $output;
    protected $modelName;
    protected $logger;

    public function __construct(array $input = [], $modelName = "default") {
        $this->input = $input;
        $this->modelName = $modelName;
        $this->run();
    }

    public function info($message) : void {
        if(!$this->logger) return;
        $this->logger->info($message);
    }

    public function setLogger($logger) : void {
        $this->logger = $logger;
    }

    public function ask($ask, $positive) : bool {
        while (empty($text)) $text = readline($ask . " \n");
        return $positive ? true : false; 
    }
    
    public function run() : void {
        $this->output = [];
    }
    
    public function result() {
        return $this->output;
    }
}