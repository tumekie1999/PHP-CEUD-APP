<html>
  <head>
    <title>PHP Test</title>
  </head>
  <body>
<form action="index.php" method="POST">
  <input type="hidden" name="action" value="add">
  <input type="text" name="todo"/>
  <button type="submit">Add</button>
</form>

<?php

// create
if($_REQUEST["action"]=="add"){
  file_put_contents("todos.txt", $_REQUEST["todo"]."\n", FILE_APPEND);
}

// delete
if($_REQUEST["action"]=="delete"){
  $delete_index = $_REQUEST["index"];
  $old_array = file("todos.txt");
  $new_array = [];
  for($i = 0; $i < count($old_array); $i++){
    if($i != $delete_index){
      array_push($new_array, $old_array[$i]);
    }
  }
  file_put_contents("todos.txt", $new_array);
}

// edit
$edit_index = -1;
if($_REQUEST["action"]=="edit"){
  $edit_index = $_GET["index"];
}

// update
if($_REQUEST["action"]=="update"){
  $save_index = $_REQUEST["index"];
  $updated_todo = $_REQUEST["todo"];
  $old_array = file("todos.txt");
  $new_array = [];
  for($i = 0; $i < count($old_array); $i++){
    if($i != $save_index){
      array_push($new_array, $old_array[$i]);
    }else{
      array_push($new_array, $updated_todo."\n");
    }
  }
  file_put_contents("todos.txt", $new_array);
}

?>

<ul>
<?php
$array = file("todos.txt");
for($i = 0; $i < count($array); $i++) {
  if($i==$edit_index){
?>
  <li>
  <form action="index.php" method="GET">
    <input type="hidden" name="action" value="update">
    <input type="hidden" name="index" value=<?=$edit_index?>>
    <input type="text" name="todo" value="<?=$array[$i]?>"/>
    <button type="submit">Save</button>
  </form>
  </li> 
<?php
  }else{
?>
  <li>
  <?=$array[$i]?>
  <a href="index.php?action=delete&index=<?=$i?>">❌</a>
  <a href="index.php?action=edit&index=<?=$i?>">✏️</a>
  </li>
<?php
  }
}
?>
</ul>
  </body>
</html>
