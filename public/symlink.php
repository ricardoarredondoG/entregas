<?php
$targetFolder = $_SERVER['DOCUMENT_ROOT'].'/../../entregas/storage/app';
$linkFolder = $_SERVER['DOCUMENT_ROOT'].'/storage';
symlink($targetFolder,$linkFolder);
echo 'Symlink process successfully completed';
?>