<?php
    ob_start();

    include_once 'func.php';

/***
 * Generally common files should be added here, as this file is added to every other page.
 */

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?=$GLOBALS['c_site_title']?></title>


    <!-- Bootstrap Core CSS -->
     <!-- <link href="./assests/css/bootstrap.min.css" rel="stylesheet"> -->

    <!-- Custom CSS -->
    <link rel="stylesheet" href="./assests/css/w3.css">
    <link rel="stylesheet" href="./assests/css/style.css">


    <!-- jQuery -->
    <script src="./assests/js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="./assests/js/bootstrap.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
