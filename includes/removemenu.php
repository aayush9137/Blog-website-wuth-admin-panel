<?php
require('db.php');
if(isset($_GET['id'])){
    $id=$_GET['id'];
    $query="DELETE FROM menu WHERE id=$id";
    mysqli_query($db,$query);

    // Corrected the column name from 'parenu_menu_id' to 'parent_menu_id'
    $query="DELETE FROM smenu WHERE parent_menu_id=$id";
    mysqli_query($db,$query);

    header('location:../admin/index.php?managemenu');
}
?>