<!-- For bootstrap -->

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<!DOCTYPE html>
<html>
    <body>
        <?php
            $error = "";
            if(isset($_POST['submit']))
            {
                $fileExt = explode('.',$_FILES['fileToUpload']['name']);
                $fileActualExt = strtolower(end($fileExt));

                $allowed = array('jpg', 'png', 'jpeg');

                if(in_array($fileActualExt,$allowed))
                {
                      if($_FILES['fileToUpload']['error'] == 0)
                      {
                            if($_FILES['fileToUpload']['size'] < 10000000) //10 mb
                            {
                                $fileDestination = 'uploads/'.$_FILES['fileToUpload']['name'];
                                move_uploaded_file($_FILES['fileToUpload']['tmp_name'],$fileDestination);
                                $error.='<div class = "alert alert-success" role = "alert"><p><strong>File Upload SuccessFully!</strong></p> </div>';

                            }
                            else{
                                $error.='<div class = "alert alert-danger" role = "alert"><p><strong>File is Too Big To Upload!</strong></p> </div>';
                            }

                      }
                      else{
                        $error.='<div class = "alert alert-danger" role = "alert"><p><strong>There was Error Uploading This Type Of File!</strong></p> </div>';
                      }
                }
                else{
                    $error.='<div class = "alert alert-danger" role = "alert"><p><strong>You cannot upload file of this type!</strong></p> </div>';
                }
                
            
            }
        ?>
        <div class= "container" style = "margin-top:70px;text-align:center;">
            <p><?php echo $error;?></p>
            <form method="POST" enctype="multipart/form-data">
                <h2>Select image to upload:</h2>
                <input type="file" name="fileToUpload" id="fileToUpload" required>
                <input type="submit" value="Upload Image" name="submit" class = "btn btn-success">
            </form>
            
        </div>
    </body>
</html>