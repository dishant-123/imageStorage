<?php
    session_start();
    include_once 'dbConnection.php';
    include 'fileUploadMySql.php';
?>
<html>
    <head>
         <!-- For bootstrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    
    </head>
    <body>
        <?php
            $error = "";
            $content = "";
            $images = "";
            // logout the User
            if(array_key_exists('logoutButton', $_POST))
            {
                
                Logout();
            }
            if(array_key_exists('deleteAccount', $_POST) && $_SESSION)
            {
                $query = 'DELETE FROM userimages WHERE email = "'.$_SESSION['email']. '"';
                mysqli_query($link,$query);   

                $query = 'DELETE FROM user WHERE email  = "'.$_SESSION['email'].'"';      
                mysqli_query($link,$query); 
                // echo mysqli_error($link);  
                Logout();

            }
            if(array_key_exists('comment',$_POST))
            {
                if($_POST['imageComment']!="")
                {
                    $text = $_POST['imageComment'];
                    $id = intval($_POST['id']);
        
                    $query = 'UPDATE usersimages SET comment="'.$text.'" WHERE id='.$id.'  ';
                    mysqli_query($link, $query);
                    echo mysqli_error($link);
                }
            }
            function Logout()
            { 
                unset($_SESSION['email']);
                // header('Location: SignUp.php');
                
            }
            function DisplayImages($link,$images)
            {
                $query = "SELECT * FROM usersimages WHERE email = '$_SESSION[email]' ";
                
                $rows = mysqli_query($link, $query);
                while($row  = mysqli_fetch_array($rows))
                {
                    $images.= '<div style="float:left; "><img style = "margin-left:8px;" height="300px" width="300px" src= "data:image;base64,'.$row[3].'"><br>';
                    $images.='<p><strong>Comment :  </strong><font>'.$row[4].'</font></p>';
                    $images.='<a href="deleteImage.php?id='.$row[0].'" ><button type="button" class= "btn btn-danger mb-2 btn-sm">Delete</button></a>';
                    $images.= '<form method="POST"><input type="text" name="imageComment"><input type="hidden" name="id" value='.$row[0].'><input type="submit" name="comment" class="btn btn-primary mb-2 btn-sm" value="Comment"/></form></div>';
                    
                }
                return $images;
            }
            if($_SESSION && $_SESSION['email']){
                $query = "SELECT username FROM user WHERE email ='$_SESSION[email]' ";
                $result = mysqli_query($link, $query);
                $row = mysqli_fetch_array($result);
                $content = '<form method="POST" enctype="multipart/form-data">
                <h2>Select image to upload:</h2>
                <input type="file" name="fileToUpload" id="fileToUpload" required>
                <input type="submit" value="Upload Image" name="submit" class = "btn btn-primary mb-2">
                </form>';
                $images = DisplayImages($link,$images);
                $error = '<div class = "alert alert-success" role="alert"><div><h2>Welcome '. $row['username'] . '!</h2> <form method="POST"><input type = "submit" name = "logoutButton" class = "btn btn-danger mb-2" value="LogOut"><input type="submit" style="float:right" name="deleteAccount" class="btn btn-danger mb-2" value="DeleteAccount"></form></div></div>';
            }
            else{
                $error = '<div class = "alert alert-danger" role="alert"> <p><strong>Please SignIn or SingUp!</p></strong><div><a href= "signIn.php"> <button type = "button" class = "btn btn-primary mb-2">Sign In</button></a> <a href= "signUp.php"> <button type = "button" class = "btn btn-primary mb-2">Sign Up</button></a></div></div>';
            }
        ?>
        <div class = "container">
            <p><?php echo $error; ?> </p>
            <p><?php echo $fileError;?></p>
            <p><?php echo $content;?></p>
            <p><?php echo $images;?></p>
            
        </div>
    </body>
</html>