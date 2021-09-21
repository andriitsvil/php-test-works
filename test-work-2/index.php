<?php
echo '<pre>';
// TREO


//Задача №1
//Дано текст. Написати функцію calcword, яка на вхід приймає текст на
// виході повертає масив частоти повторення двобуквений сполучень
// (тільки тих, які зустрічаються в тексті).
$string = "df dd ff df ffff dz";
function calcword($str){
    if(gettype($str)!== 'string'){
        return null;
    }else{
        $str_array = str_replace(' ', '', $str);
        $str_array = str_split($str_array, 2);
        $result = array();
        for($i = 0; $i <= count($str_array); $i++){
            foreach($str_array as $value){
                if($str_array[$i] === $value){
                    $result[$i] += 1;
                }
            }
        }
    return $result;
    }
}
//print_r(calcword($string));


//Задача №2
//Розробити функцію, яка знайде дві найближчі між собою точки.
//Тобто на вхід функції передається масив з точками (точка це координати x;y),
// функція має повернути масив в якому буде 2 точки відстань між якими найменша.
//
//Формула пошуку відстані
//
//d=sqrt((x2−x1)^2+(y2−y1)^2)

$points = array([0, 1], [1,3], [2,12], [4, 4], [3, 12]);
function findClosest(array $array){
    $X = array();
    $Y = array();
    $distances = array();
    foreach($array as $key => $value){
        $X[] = (int)$value[0];
        $Y[] = (int)$value[1];
    }
    if(count($X) === count($Y)){
        for($i = 0; $i < count($X); $i++){
            for($j = 0; $j < count($X); $j++){
                $distances[$i][$j] = sqrt((pow(($X[$i] - $X[$j]),2) + pow(($Y[$i] - $Y[$j]),2)));
            }
        }
        foreach($distances as $key => $arr){
            for($n = 0; $n < count($arr); $n++){
                if($arr[$n] == 0){
                    unset($distances[$key][$n]);
                }
            }
        }
        $min_distances = $distances;
        foreach ($min_distances as $item => $value){
            for($s = 0; $s < count($value); $s++ ){
                $min_distances[$item] = min($value);
            }
        }
        $result = array();
        $limit = min($min_distances);
        foreach ($min_distances as $key => $value){
            if($value === $limit){
                $result[] = [$X[$key],$Y[$key]];
            }
        }
        return $result;
    }

};
//print_r(findClosest($points));


//Задача 3
// Реалізувати об'єкт який буде реалізовувати наступний тип даних черга
//
//В об'єкті CellectionEnqueue повинні бути реалізовані наступні публічні методи:
//
//enqueue – додає елемент в кінець (хвіст) черги
// dequeue – отримати та видалити елемент з початку черги (голови).
// size - отримує кількість елементів в черзі
// Тип даних які може містити черга може бути тільки  int


class CellectionEnqueue {
    private $con = array(); ///array
    public function enqueue($data){
        if(gettype($data)!== 'integer'){
            $data = null;
        }else{
            $data = (int)$data;
            array_unshift($this->con,$data);
        }
    }
    public function dequeue(){
        array_pop($this->con);
    }
    public function size(){
        return count($this->con);
    }
}
$test = new CellectionEnqueue();
$test->enqueue(222);
$test->enqueue(444);
print_r($test);