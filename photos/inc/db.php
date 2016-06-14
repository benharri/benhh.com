<?php
@session_start();
$db = new mysqli('localhost', '','', 'benharri');

if($db->connect_error){
  die("Connect error (" . $db->connect_errno . ") " . $db->connect_error);
}