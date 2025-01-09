<?php
include 'db.php';
$id = $_GET['id'];
if($id){
    $stmt = $conn->prepare("UPDATE Tasks set is_completed = 1 WHERE id=?");
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $stmt->close();
}
header("location: index.php");
exit;
?>