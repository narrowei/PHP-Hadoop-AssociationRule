#!/bin/bash
dir_name="output"
output="/part-00000"
echo Please enter your file
read FILE
echo $FILE>tmp.txt
echo Please enter your support like 0.6
read SUP
echo $SUP>>tmp.txt
echo Please enter your confidence like 0.5
read COF
echo $COF>>tmp.txt
for loop in 1 2 3
do
    if [ -d "$dir_name$loop" ]
     then
      rm -rf "$dir_name$loop"
     echo `date`" DELETE DIRgr: "$dir_name$loop
    fi
    hadoop jar /usr/local/Cellar/hadoop/2.7.2/libexec/share/hadoop/tools/lib/hadoop-streaming-2.7.2.jar  -input word.txt -output $dir_name$loop -mapper "php mapper${loop}.php" -reducer 'php reducer.php'
    if [ ! -s ${dir_name}${loop}${output} ]
     then
      break
    fi
done
