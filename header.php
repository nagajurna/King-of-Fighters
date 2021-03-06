<?php
session_start();
include('configuration.php');
$bdd = mysqli_connect($serveur, $utilisateur, $motdepasse, $basededonnees);
include('kof.php');

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <style>
      td
      {
        border: 2px solid black;
        min-width: 60px;
        height: 40px;
        text-align: center;
      }

  </style>

    <title>T-KOF : tournois de King of Fighters</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="jumbotron.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
<br><br><br>
  <?php 


    if (isset($_POST['name']))
    {
    setcookie('name', $_POST['name'], time() + 10*24*3600, null, null, false, true);
    }



    if (isset($_POST['Pseudo']) && isset($_POST['mdpInput']))
    {

      $query = "SELECT mdp, Pseudo FROM joueurs WHERE Pseudo = \"". $_POST['Pseudo'] . "\"" ;

      $result = mysqli_query($bdd, $query);

      $data = mysqli_fetch_array($result);
      $motDePasse = $data['mdp'];


      if($_POST['mdpInput'] != $motDePasse)
      {        
        echo "<div id='alert' class='alert alert-danger' role='alert'>Mauvais identifiants.</div>";
        echo "
        <script>
            setTimeout(function(){
              $('#alert').fadeOut();
            },3000);
        </script>";
      }

      else
      {
        $_SESSION['pseudo'] = $_POST['Pseudo'];

        echo "<div id='alert' class='alert alert-success' role='alert'>BIENVENUE ".$_POST['Pseudo']."</div>";
        echo "<script>
                setTimeout(function(){
                $('#alert').fadeOut();
              },3000);
              </script>";
      }



    }

    if(isset($_POST['logout']))
    {
      $_SESSION['pseudo'] = array();
      session_destroy();
      header('Location:index.php');
    }

  ?>

    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="">T-KOF</a>
        </div>
      <ul class="nav navbar-nav">
        <li>
          <a href="classement.php">Classement actuel</a>
        </li>
        <li>
          <a href="ancienClassement.php">Anciens classements</a>
        </li>
        <li>
          <a href="joueurs.php">Liste des joueurs</a>
        </li>
      </ul>
        <div id="login" class="navbar-collapse collapse">
          
          <?php

            if(!estConnecte())
            {
              ?>
                <form class='navbar-form navbar-right' role='form' action='index.php' method='POST'>
                  <div class='form-group'>
                    <input type='text' placeholder='Pseudo' name='Pseudo' class='form-control'>
                  </div>
                  <div class='form-group'>
                    <input type='password' placeholder='Mot de passe' name='mdpInput' class='form-control'>
                  </div>
                  <button type='submit' class='btn btn-success'>Se connecter</button>
                </form>
                <?php
            }
            if(estConnecte())
            {
              echo "
                <form id='logout' class='navbar-form navbar-right' action='index.php' method='POST'>
                  <span style='color:white'>".$_SESSION['pseudo']."&nbsp</span>
                  <button name='logout' type='submit' class='btn btn-default'>Se déconnecter</button>
            
                </form>";
            }

          ?>

        </div><!--/.navbar-collapse -->
      </div>
    </nav>