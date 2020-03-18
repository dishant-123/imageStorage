

<?php
    $fileError = "";
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
                    $image = addslashes($_FILES['fileToUpload']['tmp_name']);
                    $name = addslashes($_FILES['fileToUpload']['name']);
                    $image = file_get_contents($image); //convert a file into string
                    $image = base64_encode($image);
                    $query = "INSERT INTO usersimages(email,name,image) VALUES('$_SESSION[email]','$name','$image')";
                    if(!mysqli_query($link, $query))
                    {
                        echo mysqli_error($link);
                        $fileError.='<div class = "alert alert-danger" role = "alert"><p><strong>Some Error Occur!</strong></p> </div>';
                    }
                    else{
                        $fileError.='<div class = "alert alert-success" role = "alert"><p><strong>Image Uploaded SuccesFully!</strong></p> </div>';
                    }
                }
                else{
                        $fileError.='<div class = "alert alert-danger" role = "alert"><p><strong>File is Too Big To Upload!</strong></p> </div>';
                }

            }
            else{
                $fileError.='<div class = "alert alert-danger" role = "alert"><p><strong>There was Error Uploading This Type Of File!</strong></p> </div>';
            }
                     
        }
        else{
            $fileError.='<div class = "alert alert-danger" role = "alert"><p><strong>You cannot upload file of this type!</strong></p> </div>';
        }

                
            
    }
?>