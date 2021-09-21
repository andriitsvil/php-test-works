<?php
  /*
   * Задача - поменять значения
   * двух переменных между собой не используя третьей
   * переменной
   * */
  $a = 5;
  $b = 8;

  echo '<pre>';
  echo "var a = {$a}";
  echo '<br>';
  echo "var b = {$b}";

  echo '<hr>';

  $a = array($a,$b);
  $b = (int)$a[0];
  $a = (int)$a[1];

  echo "var a = {$a}";
  echo '<br>';
  echo "var b = {$b}";
  echo '</pre>';