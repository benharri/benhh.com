<?php
require_once 'login_check.php';
require_once 'inc/header.php';
$query = "select username, failcount, ip from users";
$query_data = $db->query($query);
?>
<h1>System Administrator Dashboard</h1>

Manage users
<hr>
<table class="tablecss">
<tr>
  <th class="label">Username</th>
  <th class="label">Photo Count</th>
  <th class="label">Failcount</th>
  <th class="label">Reset Failcount</th>
  <th class="label">IP Address</th>
  <th class="label">Delete user</th>
</tr>
<?php
while($result = $query_data->fetch_object()){
  if($result->username != 'admin'){

  ?>

  <tr class="whiterow">
    <td><?=$result->username?></td>
    <td><?php $query2 = "select count(*) as count from photos where username = '$result->username'";
              $query_data2 = $db->query($query2);
              $result2 = $query_data2->fetch_object();
              echo $result2->count; ?></td>
    <td><?=$result->failcount?></td>
    <td><a href="action.php?do=reset_failcount&username=<?=$result->username?>">reset failcount</a></td>
    <td><?=$result->ip?></td>
    <td><a href="action.php?do=delete_user&username=<?=$result->username?>">delete this user</a></td>
  </tr>

<?php
  }
}
?>
</table>
<br>
List all files
<hr>

<table class="tablecss">
  <tr>
    <td class='label'>Preview</td>
    <th class="label">Filename</th>
    <th class="label">Description</th>
    <th class="label">Username</th>
    <th class="label">View Count</th>
  </tr>
  <?php
  $query = "select filename, description, username, viewcount, id from photos order by viewcount desc";
  $query_data = $db->query($query);
  while($result = $query_data->fetch_object()){?>
    <tr class="whiterow">
      <td><a href='img.php?id=<?=$result->id?>'><img src='img.php?id=<?=$result->id?>&thumbnail=YES'></a></td>
      <td><a href='img.php?id=<?=$result->id?>'><?=$result->filename?></a></td>
      <td><?=$result->description?></td>
      <td><?=$result->username?></td>
      <td><?=$result->viewcount?></td>
    </tr>
  <?php
  }?>
</table>
