<?php
session_start();
$hostname="localhost";
$sql_username="root";
$db_name="hotel";
$response=array();
$conn=mysqli_connect($hostname,$sql_username,"",$db_name);
if(!$conn){
$response["sucess"]=false;
$response["message"]="Connection Failed: ".mysqli_connect_error();
echo json_encode($response);
exit();
}

$email=$_POST["email"];
$password=$_POST["password"];

if($email==NULL && $password==NULL)
    {
        $response["success"]=false;
        $response["message"]="Please fill-up the Email and password field properly";
        echo json_encode($response);
        exit;
    }
   
    if($email==NULL)
    {
        $response["success"]=false;
        $response["message"]="Please fill-up the Email field";
        echo json_encode($response);
        exit;
    }
    if($password==NULL)
    {
        $response["success"]=false;
        $response["message"]="Please fill-up the password field";
        echo json_encode($response);
        exit;
    }

    $sql="SELECT * FROM users WHERE email='$email'";

    $result=mysqli_query($conn,$sql);
    if(!$result){
        $response["success"]=false;
        $response["message"]="Error: " . mysqli_error($conn);
        echo json_encode($response);
        exit;
    }

    $row=mysqli_fetch_array($result);
    if($row!=NULL && $row["password"]==$password)
    {
    $_SESSION['id']=$row['user_id'];
        $_SESSION['name']=$row['name'];
        $response["success"]=true;
        if(isset($_COOKIE["cookie_set"]))
        {
            $response["cookie_set"]=true;
        }
        echo json_encode($response);
    }
    elseif ($row!=NULL && $row["password"]!=$password) {
    $response["success"]=false;
        $response["message"]="Incorrect password";
        echo json_encode($response);
    }
    else{
    $response["success"]=false;
        $response["message"]="No Such Email is Registered";
        echo json_encode($response);

    }

    mysqli_close($conn);
     header('Location:booking.html');
?>