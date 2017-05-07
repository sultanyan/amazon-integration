<?php require_once "../includes/header.php" ?>

<?php
    $obj = "upload/video.mp4";
    $stremHostUrl = "{$config['cloudfront']['url']}";
    $expires = new DateTime("5 seconds");

    // Get the real url
    $url = $cloudfront->getSignedUrl([
        "url" => $stremHostUrl."/".$obj,
        "expires" => $expires->getTimestamp(),
        "private_key" => "../{$config['cloudfront']['private_key']}",
        "key_pair_id" => $config['cloudfront']['key_pair_id']
    ]);
?>

<video width="600" controls>
    <source src="<?php echo $url ?>" type="video/mp4">
</video>

<?php require_once "../includes/footer.php" ?>