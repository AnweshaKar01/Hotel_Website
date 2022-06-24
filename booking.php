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

$name=$_POST["name"];
$email=$_POST["email"];
$phno=$_POST["phno"];
$address=$_POST["address"];
$age=$_POST["age"];
$rooms=$_POST["rooms"];
$adults=$_POST["adults"];
$children=$_POST["children"];

if ( $name==NULL ||  $email==NULL ||  $phno==NULL ||  $age==NULL  ||  $rooms==NULL ||  $address==NULL ||$adults==NULL || $children==NULL  )
{
$fill="Please fill up ";
if($name==NULL)
{
$fill="$fill"."NAME,";
}
if($email==NULL)
{
$fill="$fill"."Email,";
}
if($age==NULL)
{
$fill="$fill"."Age,";
}
if($phno==NULL)
{
$fill="$fill"."Phone Number,";
}
if($rooms==NULL)
{
$fill="$fill"."Rooms,";
}
if($adults==NULL)
{
$fill="$fill"."Adults,";
}
if($address==NULL)
{
$fill="$fill"."Address Of Origin,";
}
if($children==NULL)
{
$fill="$fill"."Children,";
}
$len=strlen($fill);
$fill[($len-1)]=".";
$response["success"]=false;
$response["message"]=$fill;
echo json_encode($response);
exit();

}

$sql="INSERT INTO book_user (name,age,email,phno,address,rooms,adults,children) VALUES ('$name','$age','$email','$phno','$address','$rooms','$adults','$children') ";
$result=mysqli_query($conn,$sql);

if(!$result){
$response["success"]=false;
$response["message"]="Error:".mysqli_error($conn);
echo json_encode($response);
exit();
}

$sql1="SELECT user_id,name FROM users where name='$name'";
$result1=mysqli_query($conn, $sql1);
if(!$result){
$response["success"]=false;
$response["message"]="Error:".mysqli_error($conn);
echo json_encode($response);
exit();
}
$row = mysqli_fetch_array($result1);
//$_SESSION["id"]=$row["user_id"];
//$_SESSION["name"]=$row["name"];
$response["success"]=true;
$response["message"]="Booking Successful";
if(isset($_COOKIE["cookie_set"]))
    {
        $response["cookie_set"]=true;
    }
echo json_encode($response);
mysqli_close($conn);
 //header('Location:ResortHome.html');

?>