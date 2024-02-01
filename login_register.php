<?php
require('connection.php');
session_start();
if(isset($_POST['login'])){
    $query="SELECT * FROM 'registered_users' WHERE 'email'=$_POST[email]'";
    $result=mysqli_query($con,$query);
    if($result){
        if(mysqli_num_rows($result)==1){
            $result_fetch=mysqli_fetch_assoc($result);
            if(password_verify($_POST['password'],$result_fetch['password'])){
                $_session['logged_in']=true;
                $_session['email']=$result_fetch['email'];
                header("location:index.php");

            }
            else{
                echo"
                <script>
                alert('incorrect password');
                window.location.href='index.php';
                </script>
                ";
            }
        }
        else{
            echo"
                <script>
                alert('$result_fetch[email] - email already taken');
                window.location.href='index.php';
                </script>
                ";

        }
    }
}
if(isset($_POST['register'])){
    $user_exist_query="SELECT * FROM 'registered_users' WHERE 'email'='$_POST[email]'";
    $result=mysqli_query($con,$user_exist_query);
    if($result){
        if(mysqli_num_rows($result)>0){
            $result_fetch=mysqli_fetch_assoc($result);
            if($result_fetch['email']==$_POST['email']){
                echo"
                <script>
                alert('$result_fetch[email] - email already taken');
                window.location.href='index.php';
                </script>
                ";
            }
            else{
                $query="INSERT INTO 'registered_users'('name', 'email', 'password', 'address', 'phonenumber') VALUES ($_POST[name], $_POST[email], $_POST[password], $_POST[address], $_POST[phonenumber]";
                if(mysqli_query($con,$query)){
                    echo"
                    <script>
                    alert('Registration Sucessfully');
                    window.location.href='index.php';
                    </script>
                    ";

                }
                else{
                    echo"
                    <script>
                    alert('cannot run query');
                    window.location.href='index.php';
                    </script>
                    ";
                }
            }
        }
        else{
            echo"
            <script>
            alert('cannot run query');
            window.location.href='index.php';
            </script>
            ";

    }
}
}




?>