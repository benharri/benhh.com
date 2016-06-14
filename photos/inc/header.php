<?php
@session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title><?= $v_page_title?></title>

  <!-- JavaScripts -->
  <?php if(isset($jq)) foreach($jq as $j):?>
    <script src="<?=$j?>" type="text/javascript"></script>
  <?php endforeach;?>

  <!-- Stylesheets -->
    <link rel="stylesheet" href="inc/login.css" type="text/css">
  <?php if(isset($css)) foreach(array($css) as $c):?>
    <link rel="stylesheet" href="<?=$c?>" type="text/css">
  <?php endforeach;?>

</head>
<body>

<?php
  if(isset($_SESSION['msg']['error'])){?>
    <div class="alert_error">
      <?=$_SESSION['msg']['error']?>
    </div>
  <?php }
  if(isset($_SESSION['msg']['success'])){?>
    <div class="alert_success">
      <?=$_SESSION['msg']['success']?>
    </div>
  <?php }
  if(isset($_SESSION['msg']['logged-in'])){?>
    <div class="alert_logged-in">
      <?=$_SESSION['msg']['logged-in']?>
    </div>
  <?php }
  if(isset($_SESSION['msg'])){
    unset($_SESSION['msg']);
  }