#!/usr/bin/php
<?php
require_once __DIR__ . '/../../src/Mapper.php';

class Mapper extends \Makotokw\HadoopStreaming\Mapper
{
    public function map($s)
    {
        $word_list = array();
        $tmp=file_get_contents("output1/part-00000");
        foreach(preg_split('/\n/', $tmp) as $line) {
            $words = preg_split('/\s/', $line);
            if($line)
                array_push($word_list, $words[0]);
        }
        $trans = preg_split('/\s+/', $s);
        for($i=0;$i<count($trans);$i++){
            for($j=$i+1;$j<count($trans);$j++){
                if(in_array($trans[$i],$word_list)&&in_array($trans[$j],$word_list)) {
                    $this->emit($trans[$i] . " " . $trans[$j], 1);
                }
            }
        }
    }
}
$mapper = new Mapper();
