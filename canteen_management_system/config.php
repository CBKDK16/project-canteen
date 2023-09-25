<?php

$conn = mysqli_connect('localhost','root','','canteen_db') or die('connection failed');


function requireValidation($data,$index)
   {
      if(isset($data[$index]) && !empty($data[$index]) && trim($data[$index]))
         return true;
      else
         return false;
   } 
   function displayError($array,$index)
   {
      $msg = '';
      if(isset($array[$index]))
      {
         $msg = '<b class="error">' . $array[$index] . '</b>';
      }
      return $msg;
   }

?>