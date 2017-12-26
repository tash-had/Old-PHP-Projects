<?php 
require 'functions.php'; 
startSession();
session_destroy(); 
@ob_end_flush();
echo "<script>window.location='index'</script>";
?>