<?php


$filename = 'todo_record.json';
function loadTodoRecord($filename)
{


  $json = file_get_contents($filename);
  $todoRecord = json_decode($json, true);

  return $todoRecord;
}

function saveTodoRecord($filename, $todoRecord)
{
  $json = json_encode($todoRecord);
  file_put_contents($filename, $json);
}


$todoRecord = loadTodoRecord($filename);
if (isset($_POST['save'])) {
  if (!empty($_POST['task']) && !empty($_POST['due_date']) && !empty($_POST['status']) && !empty($_POST['priority'])) {
    $task = $_POST['task'];
    $due_date = $_POST['due_date'];
    $status = $_POST['status'];
    $priority = $_POST['priority'];

    $newData = ['task' => $task, 'due_date' => $due_date, 'status' => $status, 'priority' => $priority];
    $todoRecord[] = $newData;

    saveTodoRecord($filename, $todoRecord);
  }
}


if (isset($_POST['edit_index']) && isset($_POST['update_task']) && isset($_POST['update_due_date']) && isset($_POST['update_status']) && isset($_POST['update_priority'])) {
  $edit_index = $_POST['edit_index'];
  $update_task = $_POST['update_task'];
  $update_due_date = $_POST['update_due_date'];
  $update_status = $_POST['update_status'];
  $update_priority = $_POST['update_priority'];


  if (isset($todoRecord[$editIndex])) {
    $todoRecord[$editIndex]['task'] = $update_task;
    $todoRecord[$editIndex]['due_date'] = $update_due_date;
    $todoRecord[$editIndex]['status'] = $update_status;
    $todoRecord[$editIndex]['priority'] = $update_priority;

    saveTodoRecord($filename, $todoRecord);
  }
}
if (isset($_POST['remove'])) {
  $indexToRemove = $_POST['remove'];
  unset($todoRecord[$indexToRemove]);
  $todoRecord = array_values($todoRecord);
  saveTodoRecord($filename, $todoRecord);
}




function recordNumber()
{
  static $a = 1;
  return $a++;
}

?>






<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Todo App</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
    Add Todo Record
  </button>

  <form action="" method="POST">

    <h1 class="text-center my-4 py-4" style="font-family: Verdana, Geneva, Tahoma, sans-serif;">Welcome To My TODO App</h1>


    <div class="w-50 m-auto">
      <div class="mb-3">
        <label for="task" class="form-label">Task:</label>
        <input type="text" class="form-control" id="task" name="task" placeholder="Enter Task to Add in ToDo">
      </div>
      <div class="mb-3">
        <label for="due-date" class="form-label">Due Date:</label>
        <input type="date" class="form-control" id="due-date" name="due_date">
      </div>
      <br>

      <div class="mb-3">


      </div>
      <!-- Modal -->
      <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Input Your Data</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

              <label for="">select menu:</label>
              <select class="form-select" aria-label="Default select example" name="status">
                <option value="In Progress">In Progress</option>
                <option value="Blocked">Blocked</option>
                <option value="MR">MR</option>
                <option value="Ready for QA">Ready for QA</option>
                <option value="Done">Done</option>
              </select>
              <br>

              <label for="">radio button:</label>
              <div class="form-check">
                <input class="form-check-input" type="radio" value="low" name="priority" id="flexRadioDefault1">
                <label class="form-check-label" for="flexRadioDefault1">
                  LOW
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" value="medium" name="priority" id="flexRadioDefault2">
                <label class="form-check-label" for="flexRadioDefault2">
                  MEDIUM
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" value="high" name="priority" id="flexRadioDefault2" checked>
                <label class="form-check-label" for="flexRadioDefault2">
                  HIGH
                </label>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" name="save">Save</button>
            </div>
          </div>
  </form>

  </div>
  </div>

  <hr>
  <br> <br>

  <table class="table table-dark table-hover">
    <thead>
      <tr>
        <th scope="col">S/N</th>
        <th scope="col">Task</th>
        <th scope="col">Due Date</th>
        <th scope="col">Action</th>
        <th scope="col">Status</th>
        <th scope="col">Priority</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <?php if (!empty($todoRecord)) : ?>
      <tbody>
        <?php foreach ($todoRecord as $index => $record) : ?>
          <tr>
            <th scope="row"><?php echo recordNumber() ?></th>
            <td><?php echo $record['task']; ?></td>
            <td><?php echo $record['due_date']; ?></td>
            <td>
              <form action="" method="POST" style="display:inline;">

                <input type="hidden" name="remove" value="<?php echo $index; ?>">
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
              </form>
            </td>
            <td><?php echo $record['status']; ?></td>
            <td><?php echo $record['priority']; ?></td>

            <form action="" method="POST">

              <input type="hidden" name="edit_index" value="<?php echo $index; ?>">
              <td> <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?php echo $index; ?>">
                  Update
                </button>
              </td>


              <!-- Modal -->
              <div class="modal fade" id="staticBackdrop<?php echo $index; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel<?php echo $index; ?>" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                      <label for="">select menu:</label>
                      <select class="form-select" aria-label="Default select example" name="update_status">
                        <option value="In Progress" <?php echo $record['status'] == 'In Progress' ? 'selected' : ""; ?>>In Progress</option>
                        <option value="Blocked" <?php echo $record['status'] == 'Blocked' ? 'selected' : ""; ?>>Blocked</option>
                        <option value="MR" <?php echo $record['status'] == 'MR' ? 'selected' : ""; ?>>MR</option>
                        <option value="Ready for QA" <?php echo $record['status'] == 'Ready for QA' ? 'selected' : ""; ?>>Ready for QA</option>
                        <option value="Done" <?php echo $record['status'] == 'Done' ? 'selected' : ""; ?>>Done</option>
                      </select>
                      <br>

                      <label for="">radio button:</label>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="low" name="update_priority" id="priority_low" <?php echo $record['priority'] == 'low' ? 'checked' : ""; ?>>
                        <label class="form-check-label" for="priority_low">
                          LOW
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="medium" name="update_priority" id="priority_medium" <?php echo $record['priority'] == 'medium' ? 'checked' : ""; ?>>
                        <label class="form-check-label" for="priority_medium">
                          MEDIUM
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="high" name="update_priority" id="priority_high" <?php echo $record['priority'] == 'high' ? 'checked' : ""; ?>>
                        <label class="form-check-label" for="priority_high">
                          HIGH
                        </label>
                      </div>

                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary" name="edit">Update Record</button>
                    </div>
                  </div>
                </div>
              </div>


            </form>


          </tr>
        <?php endforeach; ?>
      </tbody>
    <?php else : ?>
      <p>No list found</p>
    <?php endif; ?>
  </table>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>