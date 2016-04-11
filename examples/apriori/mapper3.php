#!/usr/bin/php
<?php
require_once __DIR__ . '/../../src/Mapper.php';

class Mapper extends \Makotokw\HadoopStreaming\Mapper
{
    public function map($s)
    {
        $trans = preg_split('/\s+/', $s);
        for($i=0;$i<count($trans)-1;$i++){
            for($j=$i+2;$j<count($trans);$j++){
                $this->emit($trans[$i] . " " . $trans[$i + 1] . " " . $trans[$j], 1);
            }
        }
    }
}
$mapper = new Mapper();
