<?php
include 'Upload.class.php';
$uploader = new Upload;
$files = $uploader->make(1048576,['png','jpg'],1);
print_r($files);
?>