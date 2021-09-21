<?php

//задача - написать свой аналог функции array_unique();

echo '<pre>';
$a = array(1,2,3,2,1,3,4,5,6,6,6,3,2,1);

function uniq(array $arr){
    $result = array();
    for($i = 1; $i <= count($arr); $i++){
        for($j = 1; $j <= count($arr); $j++){
            if($j === $i){
                $result[] = $j;
            }else{
                unset($arr[$j]);
            }
        }
    }
    return $result;
}
print_r(uniq($a));


