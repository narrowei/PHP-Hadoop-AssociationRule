#!/usr/bin/php
<?php
require_once __DIR__ . '/../../src/Reducer.php';
require_once __DIR__ . '/../../src/Reducer/Iterator.php';

class Reducer extends \Makotokw\HadoopStreaming\Reducer
{
    protected function reduce($key, $emits)
    {
        //print_r($key);
        //print_r($emits);
        $file=exec('sed -n \'1p\' tmp.txt');
        $per = count($emits)/exec('sed -n \'$=\' '.$file) ;
        if($per>=exec('sed -n \'2p\' tmp.txt')) {
            $this->emit($key, $per);
            $words = preg_split('/\s/', $key);
            $times = count($words);
            if($times>1){
                $conf = exec('sed -n \'3p\' tmp.txt');
                if($times==2){
                   $left = exec("grep \"".$words[0]."\" output".($times-1)."/part-00000 ");
                   preg_match("/0.*|1/", $left, $matches);
                   $left = $matches[0];
                   $right = exec("grep \"".$words[1]."\" output".($times-1)."/part-00000 ");
                   preg_match("/0.*|1/", $right, $matches);
                   $right = $matches[0];
                   $leftC = $per / $left;
                   if($leftC>=$conf)
                   $this->emit($words[0]."=>".$words[1], $leftC);
                   $rightC = $per / $right;
                   if($rightC>=$conf)
                   $this->emit($words[1]."=>".$words[0], $rightC);
                 }
                if($times>2){
                    for($i=$times-3;$i<$times;$i+=($times-2)){
                        $left = array();
                        if($times-2>1){
                            for($j=$i;$j>=$i-($times-3);$j--){
                                array_push($left, $words[$j]);
                            }
                        }else{
                            array_push($left, $words[$i]);
                        }
                        $right = array_diff($words, $left);
                        $rightW = "";
                        $leftW = "";
                        $lnum = 0;
                        $rnum = 0;
                        if(count($left)>1){
                            foreach($left as $k=>$v){
                                if($k!=count($left)){
                                    $leftW .= $v." ";
                                }else{
                                    $leftW .= $v;
                                }
                                ++$lnum;
                            }
                        }else{
                            $leftW = $left[0];
                            ++$lnum;
                        }
                        $leftS = $this->getSupp($leftW, $lnum);
                        if(count($right)>1){
                            foreach($right as $k=>$v){
                                if($k!=count($right)) {
                                    $rightW .= $v . " ";
                                }else{
                                    $rightW .= $v;

                                }
                                ++$rnum;
                            }
                        }else{
                            $rightW = $right[0];
                            ++$rnum;
                        }
                        $rightS = $this->getSupp($rightW, $rnum);
                        $leftC = $this->getConf($leftS, $per);
                        $rightC = $this->getConf($rightS, $per);
                        if($leftC>=$conf){
                            $this->emit($leftW."=>".$rightW, $leftC);
                        }
                        if($rightC>=$conf){
                            $this->emit($rightW."=>".$leftW, $leftC);
                        }

                    }
                }
            }
        }
        //$this->emit($key, $per);
    }
    public function getSupp($word,$num){
        $tmp = exec("grep \"".trim($word)."\" output".($num)."/part-00000 ");
        preg_match("/0.*|1/", $tmp, $matches);
        if(empty($tmp))
        file_put_contents("results.txt", $word . "\n",FILE_APPEND);
        return $matches[0];
    }
    public function getConf($support,$per){
        return ($per / $support);
    }
}
$reducer = new Reducer();
