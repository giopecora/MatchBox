<?php

session_start();
include 'conexaoWatson.php';

?>


 <!DOCTYPE html>
 <html>
 <head>
     <title>PHP Starter Application</title>
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
     <link rel="stylesheet" href="style.css" />
 </head>
 <body>
 
 <?php



 $watson = new Conexion_Watson();
 $watson->set_credenciales("084210ba-f47e-4d7c-91f7-6430d04a6301","TyDSJamHaQ1i");



 // define variables and set to empty values
 $Pregunta = "";
 $respuesta = "";

 

 function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
 }

 

 if ($_SERVER["REQUEST_METHOD"] == "POST") {  
         
	   $Pregunta = test_input($_POST["Pregunta"]);
      $respuesta = $watson->Enviar_Pregunta($Pregunta, "211cb5de-fb59-48d8-b1c5-7d656e2648e6");
	    $watson->set_contexto(json_encode($respuesta['context']));
      
      
      echo $respuesta['output']['text'][0];
      echo "<br><br>";
      echo json_encode($respuesta);


    
 }
 

 ?>
 
     <table>
         <tr>
             <td style='width:50%;'>
             </td>
             <td>
                 <h2>ChatBot</h2>
                 
                  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <input type="text" name="Pregunta">          
                       <input type="submit" name="submit" value="Submit">
                 </form>
             </td>
         </tr>
     </table>
 </body>
 </html>