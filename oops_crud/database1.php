<?php
// echo"hii";
// exit;
class Database
{
     function __construct()
     {
          $this->connect_db();
     }
     public function connect_db()
     {
          // 
          $this->connection = mysqli_connect('localhost', 'root', '', 'database');

          if (mysqli_connect_error()) {
               echo "conection failed:" . mysqli_connect_error() . mysqli_connect_errno();
          }
     }

     public function create($name,$email,$password,$mobile,$city, $gender,$merital_status,$date, $hobbys)
     {
          $sql = "INSERT INTO `users`(name,mobile,city,gender,marital_status,date,hobby)VALUES('$name','$mobile','$city','$gender','$merital_status','$date','$hobbys')"; 
       
          $result = mysqli_query($this->connection, $sql);
// echo"<pre>";
// print_r($sql);exit;   

          if ($result) {
               $user_id= $this->connection->insert_id;
                $q= "INSERT INTO `login`(email,password,user_id)values('$email','$password','$user_id')";
          
                $res = mysqli_query($this->connection,$q);
               //  echo mysqli_error($this->connection);
                if($res){
                    return true;

                }else {
                    return false;
                }
                echo "success";
               // return true;
          } else {
               echo "fail";
               // return false;
          }
     }
     public function index()
     {
          $sql = "SELECT *,users.id as id FROM `users` LEFT JOIN `login`ON users.id=login.user_id";
         
          $result = mysqli_query($this->connection, $sql);
          if($result){
               $data ='';
               foreach($result as $row){
                    $data.='
                    <tr>
                    <td>'.$row['id'].'</td>
                    <td>'.$row['name'].'</td>
                    <td>'.$row['email'].'</td>
                    <td>'.$row['password'].'</td>
                    <td>'.$row['mobile'].'</td>
                    <td>'.$row['city'].'</td>
                    <td>'.$row['gender'].'</td>
                    <td>'.$row['marital_status'].'</td>
                    <td>'.$row['date'].'</td>
                    <td>'.$row['hobby'].'</td>
                    <td>
                    <a data-bs-target="#updateusermodal" class="edit" data-bs-toggle="modal"><i class="material-icons update" data-bs-toggle="tooltip" data-id="'.$row['id'].'" title="edit">edit</i></a>
                    <a href="#deleteusermodal" class="delete" data-bs-toggle="modal" data-id= "'.$row['id'].'"><i class="material-icons" data-bs-toggle="tooltip"
                    title="delete">delete</i></a>

                    </td>
                    </tr>
                    ';

               }
          } 
          return $data;
     }
     
     public function edit($id){
          $sql ="SELECT *,users.id as id FROM `users` LEFT JOIN `login` ON users.id=login.user_id WHERE users.id=".$id;
          // echo "<pre>";
          // print_r($sql);exit;
          $result =mysqli_query($this->connection,$sql);
 $data = [];
          while($row=$result->fetch_assoc()){
               
               $data['id']=$row['id'];
               $data['name']=$row['name'];
               $data['email']=$row['email'];
               $data['password']=$row['password'];
               $data['mobile']=$row['mobile'];
               $data['city']=$row['city'];
               $data['gender']=$row['gender'];
               $data['marital_status']=$row['marital_status'];
               $data['date']=$row['date'];
               $hobby=explode(",",$row['hobby']);
                $data['hobby']=$hobby;
               
          }
             

          

          return $data;
          if($result){
               return $result;

          }
          return false;
     }

     
     public function update($data)
     {
          $hobbys=implode(",",$data['hobby']);
           $sql = "UPDATE `users` SET name='".$data['name']."',  mobile='".$data['mobile']."', city='".$data['city']."', gender='".$data['gender']."', marital_status='".$data['marital_status']."', date='".$data['date']."', hobby='".$hobbys."' WHERE id='".$data['id']."'";
          $result = mysqli_query($this->connection, $sql);
     //     echo"<pre>";
     //     print_r($data);exit;
          if ($result) {
               // $user_id = $this->connection->updated_id;
               // $q = "UPDATE `login` SET email='".$data['email']."', password='".$data['password']."',user_id='$user_id'";
               // $res = mysqli_query($this->connection,$q);
               // if($res){
               //      return true ;
               // }else{
               //      return false; 
               // }
              return true;
          } else {
           return false;
               // echo  "Query Failed! SQL: $sql - Error: " . mysqli_error($this->connection);
          }
     }
     public function delete($id)
     {
          $sql = "DELETE FROM  `users` WHERE id=$id";
          $result = mysqli_query($this->connection, $sql);
          if ($result) {
               return true;
          } else {
               return false;
          }
     }
    
     public function sanitize($var)
     {
          $return = mysqli_real_escape_string($this->connection, $var);
          return $return;
     }
}

