<?php
include 'db.php';
if($_SERVER ['REQUEST_METHOD']==='POST'){
    $task_name = $_POST['task_name'];
    if(!empty($task_name)){
        $stmt = $conn->prepare("INSERT INTO Tasks(task_name)VALUES (?)");
        $stmt->bind_param('s',$task_name);
        $stmt->execute();
        $stmt->close();
    }
        header("location: " .$_SERVER['PHP_SELF']);
}
 $open_tasks = $conn->query("SELECT * FROM tasks WHERE is_completed=0");
 $closed_tasks = $conn->query("SELECT * FROM tasks where is_completed=1");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do list</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">ToDo-list for ZWEKT</h1>
        <form class="mb-4" action="index.php" method="POST">
            <div class="input-group">
                <input type="text" name="task_name" class="form-control" placeholder="New Task..." required>
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
        </form>

        <div class="row">
            <div class="col-md-6">
                <h2 class="text-center">Open Tasks</h2>
                <ul class="list-group">
                    <?php if($open_tasks->num_rows > 0 ): ?>    
                    <?php while($row = $open_tasks->fetch_assoc()): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?php echo $row['task_name']; ?>
                        <div>
                            <a href="delete_tasks.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
                            <a href="complete_task.php?id=<?php echo $row['id']; ?>" class="btn btn-success">Complete</a>
                        </div>
                    <?php endwhile; ?>
                    <?php else : ?>
                    <li class="list-group_item">No Open Tasks Found.</li>    
                    <?php endif ?>
                    </li>
                </ul>
            </div>
            <div class="col-md-6">
                <h2 class="text-center">closed Tasks</h2>
                <?php if($closed_tasks ->num_rows >0 ):   ?>
                    <?php while($row = $closed_tasks->fetch_assoc()): ?>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php echo $row['task_name']; ?>
                        <div>
                            <a href="delete_tasks.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
                        </div>
                    </li>
                    <?php endwhile; ?>
                    <?php else : ?>
                    <li class="list-group_item">No Closed Tasks Found.</li>    
                    <?php endif ?>
                </ul>
            </div>
        </div>


    </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>