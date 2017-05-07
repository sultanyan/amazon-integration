<?php
  /*
    Amazon Web Services SDK
    composer require aws/aws-sdk-php
    Must create unique bucket in console aws
    Must go to security credentials -> users -> create new user -> get keys
  */
?>

<?php
    require_once "../includes/header.php";
    require_once "../app/init.php";
?>

<?php
    // get the object for looping then
    $objs = $s3->getIterator('ListObjects', [
        "Bucket" => $config["s3"]["bucket"]
    ]);

    // EXPIRATION
    $file = "uploads/imageName.jpg";

    //Get the bucket with the file inside
    $cmd = $s3->getCommand("GetObject", [
        "Bucket" => $config["s3"]["bucket"],
        "Key" => $file
    ]);

    $request = $s3->createPresignedRequest($cmd, "100"); // The command, the amount of seconds
    $url = (string) $request->getUri(); // Finalize getting the direct uri
?>


<div class="main">
  <div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Dashboard</h3>
  </div>
  <div class="panel-body">
    <table class="table">
      <tr>
        <th>Filename</th>
        <th>Download</th>
      </tr>
      <tr>
        <?php foreach ($objs as $object): ?>
            <td>
                <?php
                    // Getting the name
                    $objectName = explode("/", $object["Key"]); // Explode with /
                    echo end($objectName); // get the ending part, after the /
                ?>
            </td>

            <!-- Get the direct link for downloading -->
            <td>
                <a
                    href="
                            <?php echo $s3->getObjectUrl($config["s3"]["bucket"], $object["Key"])
                    ?>"
                    download="<?php echo $object["Key"]?>">Download</a>
                <!--
                    But if you want to add a link with expiration,
                    <a href="<?php // echo $url ?>" download="<?php // echo $url ?>">Download</a>
                 -->
            </td>
        <?php endforeach; ?>
      </tr>
    </table>
  </div>
  </div>
</div>

<?php
  require_once "../includes/footer.php";
?>
