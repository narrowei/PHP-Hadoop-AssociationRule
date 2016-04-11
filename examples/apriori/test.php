<?php
/**
 * Created by PhpStorm.
 * User: wei
 * Date: 3/26/16
 * Time: 11:25 AM
 */
$words = exec("grep \"BH CM\" output2/part-00000 ");
echo $words;
preg_match("/0.*|1/", $words, $matches);
print_r($matches);
//$word_list = array();
//$tmp=file_get_contents("output1/part-00000");
//foreach(preg_split('/\n/', $tmp) as $line) {
//    $words = preg_split('/\s/', $line);
//    if($line)
//    array_push($word_list,preg_split('/,/',$words[0]));
//}
//print_r($word_list);
//exit();
//for($i=0;$i<count($word_list);$i++){
//    for($j=$i+1;$j<count($word_list);$j++){
//        $first = preg_split('/\s/', $word_list[$i])[0];
//        $second = preg_split('/\s/', $word_list[$j])[0];
//        if ($first == $second) {
//            echo $word_list[$i] . " " . preg_split('/\s/', $word_list[$j])[1];
//            echo "\n";
//           // $this->emit($word_list[$i] . " " . preg_split('/\s/', $word_list[$j])[1],1);
//        }
//    }
//}

//<?php
//require_once __DIR__ . '/../../src/Mapper.php';
//
//class Mapper extends \Makotokw\HadoopStreaming\Mapper
//{
//    public function map($s)
//    {
////        $tmp = array();
////        foreach (preg_split('/\s+/', $s) as $word) {
////            if ($word !== '') {
////                $this->emit($word, 1);
////            }
////        }
////        $word_list = array();
////        $tmp=file_get_contents("output/part-00000");
////        foreach(preg_split('/\n/', $tmp) as $line) {
////            $words = preg_split('/\s/', $line);
////            if($line)
////                array_push($word_list, $words[0]);
////        }
////        $trans = preg_split('/\s+/', $s);
////        for($i=0;$i<count($trans);$i++){
////            for($j=$i+1;$j<count($trans);$j++){
////                if(in_array($trans[$i],$word_list)&&in_array($trans[$j],$word_list)) {
////                    $this->emit($trans[$i] . "," . $trans[$j], 1);
////                }
////            }
////        }
//        $trans = preg_split('/\s+/', $s);
//        for($i=0;$i<count($trans)-1;$i++){
//            for($j=$i+2;$j<count($trans);$j++){
//                $this->emit($trans[$i] . " " . $trans[$i + 1] . " " . $trans[$j], 1);
//            }
//
//        }
//    }
//}
//$mapper = new Mapper();
