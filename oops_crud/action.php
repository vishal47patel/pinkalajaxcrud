<?php
include "database1.php";

$database = new Database();

if (isset($_POST['action']) && $_POST['action'] == "insert") {
    // echo"<pre>";
    // print_r($_POST);exit;
    // if(empty($_POST['name'])){
    //     $nameErr = "name is requierd";

    // }else {
        $name = $_POST['name'];
    // }
    
    $email = $_POST['email'];
    $password = $_POST['password'];
    $mobile = $_POST['mobile'];
    $city = $_POST['city'];
    $gender = $_POST['gender'];
    $merital_status = $_POST['marital_status'];
    $date = $_POST['date'];

    $hobby = $_POST['hobby'];
    $hobbys = implode(",", $hobby);
   
    $result = $database->create($name, $email, $password, $mobile, $city, $gender, $merital_status, $date, $hobbys);
    if ($result) {
        echo "successfully added";
    } else {
        echo "fail";
    }
}


if (isset($_REQUEST['action']) && $_REQUEST['action'] == "view") {

    $res = $database->index();
    if ($res) {
        echo json_encode($res);
    }
}

if(isset($_REQUEST['action'])&& $_REQUEST['action']== "edit"){
    // echo "<pre>";
    // print_r($_REQUEST);exit;
    $id=$_REQUEST["id"];
    
    $result = $database->edit($id);

    if($result){
        echo json_encode($result);
    }

}
 if (isset($_REQUEST['action']) && $_REQUEST['action'] == "update" ){
   

     $res = $database->update($_REQUEST);
     if ($res){
        echo "successfully added";
    } else {
        echo "fail";
    }
    
}
if(isset($_REQUEST['action']) && $_REQUEST['action'] == "delete"){
    $id=$_REQUEST['id'];
    $result = $database->delete($id);
}

