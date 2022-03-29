<?php 
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['fname'])) {
 ?>

			<?php


      error_reporting(0); 
   $weather = "";
   $error = "";
     
   if(array_key_exists('submit',$_GET)){

       if (!$_GET['city']){

        $error = "Your input field is empty";

       }else{ 

     
      if($_GET['city']){
         
         $apiData = file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=".$_GET['city']."&appid=aa8176b8ee208df3e864866f2286e1c7&units=metric");
         
        //  print_r($apiData);
     

         $weatherArray = json_decode($apiData,true);
         if( $weatherArray['cod'] == 200){

          $c_city =  $weatherArray['name'];
          $c_country = $weatherArray['sys']['country'];
          $temp = $weatherArray['main']['temp'];
          $pressure = $weatherArray['main']['pressure'];
          $wind = $weatherArray['wind']['speed'];
          $clouds = $weatherArray['clouds']['all'];

           $icon = $weatherArray['0']['icon'];

          date_default_timezone_set('Asia/Calcutta');
          $rise =  $weatherArray['sys']['sunrise'];
          $sunset =  $weatherArray['sys']['sunset'];
          $sunrise = date('h:i a',$rise);
          $today = date("F d, Y, h:i a "); 
      //  print_r($weatherArray);

          $weather = "<b>".$c_city.", ".$c_country." </b>  ".$temp." °C <br><b>Weather Conditions : </b>".$weatherArray['weather']['0']['description']."<br>
          <b> Atmospheric Pressure :</b>".$pressure." mbar<br><b> Wind Speed : </b>".$wind." m/s<br><b>sunrise : </b>". $sunrise."
          <br><b> Today's date : </b>".$today;
        }else{

        $error = "Could not proccess your city right now";

      }

      

        
        
         
    }
  }
}
 
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	 <title>Weather App</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="styles.css">
	<!-- <link rel="stylesheet" type="text/css" href="css/style.css"> -->
	
	

</head>
<body>
    <div class="d-flex justify-content-center align-items-center vh-100">
    	
        <div class="container ">
          
      <div class="d-flex justify-content-center us">

            <h4  class="display-4 fs-3 text-uppercase mx-5">Hello, <?=$_SESSION['fname']?></h4>
            <div class="d-flex  align-items-center">
            <a href="logout.php" class="btn btn-outline-warning fs-6 mx-2 py-0 ">
            	Logout
            </a>
          </div>
      </div>

      <div class="card cb1" >


      <form action="home.php" method="GET">
        
         <h4 class="display-4 text-uppercase fs-1">SEARCH GLOBAL WEATHER</h4>

      
      <div class="">
        <label  class="form-label" >Enter city name </label>
      <input id="city" class="fc"  type="text" name="city">

      
      </div>

       <button type="submit" name="submit" class="btn btn-outline-light">submit</button>

       </form>
      <p class="card-text">

      
            <?php

          
               
               if($weather){


                 echo '<div >
             '.$weather.'
              </div>';

               }

               if($error){

                echo '<div class="at">
             '.$error.'
              </div>';

             }

             
               
              ?>
        
      </p>
     
      </div>
      </div>
    </div>

     <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  
</body>
</html>

<?php }else {
	header("Location: login.php");
	exit;
} ?>