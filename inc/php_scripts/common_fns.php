<?php

function b_menu($arr){
  $ret = "";
  foreach($arr as $name => $val){
    if(is_array($val)){
      // if menu
      $ret .= '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$name.'<span class="caret"></span></a><ul class="dropdown-menu">';
      foreach($val as $name => $href) $ret .= "<li><a href=\"$href\">$name</a></li>";
      $ret .= '</ul></li>';
    }
    else{
      $ret .= '<li><a href="'.$val.'">'.$name.'</a></li>';
    }
  }
  return $ret;
}

function pprint($obj, $desc = ""){
    echo "<pre>Debug dump: $desc ";
    print_r($obj);
    echo '</pre>';
}

function ifsetor(&$check, $alternate = NULL){
  return (isset($check)) ? $check : $alternate;
}
