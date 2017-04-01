<?php
	ob_start();
    session_start();
    require_once 'dbconnect.php';
	
	if ( isset($_SESSION['admin'])!="" ) {
        header("Location: manage.php");
        exit;

    }
	
	if (isset($_POST['login'])) {

		$userName = $_POST['username'];
        $userPassword = $_POST['password'];
        
        $userName = strip_tags(trim($userName));
        $userPassword = strip_tags(trim($userPassword));
        
        $sql = mysqli_query($db,"SELECT id FROM ADMIN WHERE username='$userName' AND password='$userPassword'");
        
        $row = mysqli_fetch_array($sql);
        
        $count = mysqli_num_rows($sql); // if uname/pass correct it returns must be 1 row
    
        if( $count == 1) {
            $_SESSION['admin'] = $row['id'];
            header("Location: manage.php");
        } else {
            $error = "Invalid username or password!";
        }

    }
error_reporting(E_ALL ^ E_NOTICE);
?>

<!DOCTYPE>
<html>
   
   <head>
      <title>Login Page</title>
      
      <style type = "text/css">
         body {
            font-family:Arial, Helvetica, sans-serif;
            font-size:14px;
         }
         
         label {
            font-weight:bold;
            width:100px;
            font-size:14px;
         }
         
         .box {
            border:#666666 solid 1px;
         }
      </style>
      
   </head>
   
   <body bgcolor = "#FFFFFF">
	
      <div align = "center">
         <div style = "width:300px; border: solid 1px #333333; " align = "left">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Login</b></div>
				
            <div style = "margin:30px">
               
               <form action = "" method = "post">
                  <label>Username  :</label><input type = "text" name = "username" class = "box"/><br /><br />
                  <label>Password  :</label><input type = "password" name = "password" class = "box" /><br/><br />
                  <input type = "submit" value = " Login " name="login" /><br />
               </form>
               
               <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
					
            </div>
				
         </div>
			
      </div>

   </body>
</html>