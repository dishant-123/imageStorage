<!-- for session connect and dataBase Connection -->
<?php

    session_start();
    include_once 'dbConnection.php';
?>

<!-- For bootstrap -->

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<?php
    $error = "";
    if($_POST && $_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(!$_POST['email']){
            $error.= 'Please Enter Email!<br>';
        }
        if(!$_POST['password']){
            $error.= 'Please Enter Password!<br>';
        }


        if($error!=""){
            $error .= '<div class = "alert alert-danger" role="alert">'. $error . '</div>';
            
        }
        else
        {
            $query = "SELECT * FROM user WHERE email = '$_POST[email]'";
            $result = mysqli_query($link, $query);

            if(mysqli_num_rows($result) == 0){
                $error .= '<div class = "alert alert-danger" role="alert"><p><strong>Email Not Found!</strong></p></div>';

            }
            else
            {
                $password = md5($_POST[password]);
                $query = "SELECT * FROM user WHERE email = '$_POST[email]' and password = '$password' ";
                $result = mysqli_query($link, $query);

                if(mysqli_num_rows($result) == 0){
                    $error .= '<div class = "alert alert-danger" role="alert"><p><strong>Email And Password Not Match!</strong></p></div>';

                }
                else
                {
                    $_SESSION['email'] = $_POST['email'];
                    header('Location: index.php');                    
                }
            }
        }
    }
?>
<html>
    <body>
        <div class = "container col-8">
            <h2>Welcome Please Enter Email And Password!</h2>
            <form method = "POST" >
                <p><?php echo $error; ?></p>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Enter Email:</label>
                    <input type="text" id = "email" name = "email" class="form-control" id="exampleFormControlInput1" placeholder="abc@gmail.com">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1"> Enter Password : </label>
                    <input type="password" id = "password" name = "password" class="form-control" id="exampleFormControlInput1" placeholder="Enter Passoword" autocomplete = "off">
                </div>
                <input type = "submit" value = "Sign In" class = "btn btn-primary mb-2">
                <a href= "signUp.php"> <button type = "button" class = "btn btn-primary mb-2">Sign Up</button></a>
            </form>
        </div>
    </body>
</html>