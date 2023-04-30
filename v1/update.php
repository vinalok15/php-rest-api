<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

// include database.php
include_once("../config/database.php");
// include student.php
include_once("../classes/student.php");

// create object for database
$db = new Database();

$connection = $db->connect();

// create object for student
$student = new Student($connection);

if ($_SERVER['REQUEST_METHOD'] === "POST") {

  $data = json_decode(file_get_contents("php://input"));

  if (!empty($data->name) && !empty($data->email) && !empty($data->mobile) && !empty($data->course) && !empty($data->id)) {
    $student->name = $data->name;
    $student->email = $data->email;
    $student->mobile = $data->mobile;
    $student->course = $data->course;
    $student->id = $data->id;

    if ($student->update_student()) {

      //  http_response_code(200); // OK
      echo json_encode(array(
        "status" => 1,
        "message" => "Student data successfully updated"
      ));
    } else {

      // http_response_code(500); // server error
      echo json_encode(array(
        "status" => 0,
        "message" => "Failed to update data"
      ));
    }
  } else {
    // http_response_code(404); // data not found
    echo json_encode(array(
      "status" => 0,
      "message" => "All data needed"
    ));
  }
} else {

  //  http_response_code(503); // service unavialable
  echo json_encode(array(
    "status" => 0,
    "message" => "Access denied"
  ));
}
