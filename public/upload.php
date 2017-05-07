<?php
use Aws\S3\Exception\S3Exception;

require_once "../includes/header.php";
    require_once "../app/init.php";
?>

<?php
    if (isset($_FILES["file"])){

        $file = $_FILES["file"]; // assign to var
        $name = $file["name"]; // get the permanent name
        $tmp_name = $file["tmp_name"]; // get the temporary name

        $ext = explode(".", $name); // separating by .
        $ext = strtolower(end($ext)); // all lowercase, and take the last part (like jpg)

        $key = md5(uniqid()); // get random hash
        $temp_filename = "{$key} . {$ext}"; // assign the a name
        $temp_filepath = "uploads/{$temp_filename}"; // locate the file

        move_uploaded_file($tmp_name, $temp_filepath);

        // Upload and put into amazon's bucket
        try{
            $s3 -> putObject([
                "Bucket" => $config["s3"]["bucket"], // The bucket specified
                "Key" => "uploads/{$name}", // The name and location
                "Body" => fopen($temp_filepath, "rb"), // The real file
                "ACL" => "public-read" // Access control list
            ]);
        }catch (S3Exception $e){
            die("Unexpected error occured" . $e -> getMessage());
        }



        unlink($temp_filepath);
    }
?>

<div class="main">
  <div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Upload</h3>
  </div>
  <div class="panel-body">

    <form action="" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <input type="file" name="file">
      </div>

      <div class="form-group">
        <input type="submit" value="Upload" class="btn btn-primary">
      </div>

    </form>
  </div>
  </div>
</div>

<?php
  require_once "../includes/footer.php";
?>
