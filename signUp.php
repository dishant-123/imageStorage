<!-- for session connect and dataBase Connection -->
<?php
    session_start();
    include_once 'dbConnection.php';
?>
<html>  
    <head>
   

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"/>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <!-- front End validation -->
    <script type = "text/javascript">
        $("form").submit(function(e){
            e.preventDefault();
            var error = "";

            if($("#name").val() == "") {
                error += "Please Enter Name1!</br>";
            }
            if($("#email").val() == ""){
                error += "Please Enter Email!</br>";
            }
            if($("#text").val() == ""){
                error += "Please Enter Text!";
            }
            if($("#password").val() == ""){
                error += "Please Enter Password!";
            }

            if(error != "")
            {
                $(".error").html('<div class = "alert alert-danger" role="alert"> <p><strong>There are errors in Form</p></strong>'+ error + '</div>');

            }
            else
            {
                $("form").unbind("submit").submit(); //so that it can't render to php not this stript again
            }
        })
    </script>
    </head>

    <body>
    <!-- for connection with mysql database -->
    <?php
        $user = 'root';
        $pass = '';
        $db = 'dbs';
        $link = new mysqli('localhost',$user, $pass, $db) or die('unable to conect dataBase');
    ?>
    <!-- server side validation -->
        <?php 
            $error = ""; //works as globally.
            if($_POST && $_SERVER["REQUEST_METHOD"] == "POST")
            {
                if(!$_POST['name']){
                    $error.= 'Please Enter Name!<br>';
                }
                if(!$_POST['email']){
                    $error.= 'Please Enter Email!<br>';
                }
                if(!$_POST['password']){
                    $error.= 'Please Enter Password!<br>';
                }
                if(!$_POST['text']){
                    $error.= 'Please Enter Text!<br>';
                }
                if($_POST['email'] && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false){
                    $error.= 'Email is Invalid!';
                }
                
                if($error!="")
                {
                    $error = '<div class = "alert alert-danger" role="alert"> <p><strong>There are errors in Form</p></strong>'. $error . '</div>';
                }
                else
                {
                    $password = md5($_POST['password']);
                    $query = "INSERT into user VALUES('$_POST[name]','$_POST[email]','$password','$_POST[country]','$_POST[text]')";
                    
                    if(!mysqli_query($link, $query))
                    {
                        $error.= '<div class = "alert alert-danger" role = "alert"><p><strong>Email Already exists! </strong></p> </div>';
                        
                    }
                    else
                    {
                        $_SESSION['email'] = $_POST['email'];
                         header('Location: index.php');

                        $error = '<div class = "alert alert-success" role = "alert"><p><strong>Form Submit Successfully !</strong></p> </div>';
                    }
                }
            }

        ?>

        <div class = "Container col-6">
        <h2>Hello Geeky! Please Fill The Form Correct!</h2>
        <p class = "error"><?php echo $error; ?></p>
        <form method = "POST" >
            <div class="form-group">
                <label for="exampleFormControlInput1">Name</label>
                <input type="text" id = "name" name = "name" class="form-control" id="exampleFormControlInput1" placeholder="Dishant">
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Email address</label>
                <input type="email" id = "email" name = "email"class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Password</label>
                <input type="password" id = "password" name = "password" class="form-control" id="exampleFormControlInput1" placeholder="Enter Strong Password"  autocomplete = "off">
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect1">Example Country</label>
                <select class="form-control" id="exampleFormControlSelect1" name = "country">
                    <option>India</option>
                    <option>NewYork</option>
                    <option>America</option>
                    <option>Australia</option>
                    <option>Canada</option>
                </select>
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Comment</label>
                <textarea name = "text" id = "text" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary mb-2">Sign Up</button>
            <a href= "signIn.php"> <button type = "button" class = "btn btn-primary mb-2">Sign In</button></a>
            </form>

            
        </div>
    </body>
</html>
