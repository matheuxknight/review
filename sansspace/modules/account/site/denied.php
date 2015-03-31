<?php

	echo <<<END

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Wayside</title>

    <!-- Bootstrap -->
    <link href='http://fonts.googleapis.com/css?family=Lato:300,100,700' rel='stylesheet' type='text/css'>
    <!--link rel="stylesheet" href="css/styles.css"--> 
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

		<main class="container error">
    		<div class="row">
     		<div class="col-md-8" style="margin-top: -22px">
         	<h2>
            	Sorry, you don't have permission to view this page.
          	</h2>
      		</div>

      
      		<div class="container col-md-8">
                <p>You have requested access to a site that requires authentication.</p>
       		</div>
      		</div>
      
    		</main>

END;

//$server = getdbo('Server', 1);
//if($server) echo "<div style='width: 640px;'>$server->accessdenied</div>";





	
	