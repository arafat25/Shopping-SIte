<?php
	include("dbconnect.php");
	ob_start();
	session_start();
	
	if(isset($_POST['register'])) {
	  $myusername = trim($_POST['username']);
	  $mypassword = trim($_POST['password']);
	  
	  $myusername = strip_tags($myusername);
	  $mypassword = strip_tags($mypassword);
      
      $sql = "SELECT username FROM USER WHERE username = '$myusername'";
      $result = mysqli_query($db,$sql);
      $count = mysqli_num_rows($result);
	  
	  //Username field is required
	  if(empty($_POST['username'])){
		 $message = 'Username field is required';
	  }
	  
	  //Check username is exist or not
	  else if($count == 1){
		 $message = "Sorry, your username is not available.";
      }
	  
	  //Password field is required
	  else if(empty($_POST['password'])){
		 $message = 'Password field is required';
	  }
	  
	  //Password Matching Validation
	  else if($_POST['password'] != $_POST['cfpassword']){ 
		 $message = 'Passwords should be same<br>'; 
	  }
	  
      else if($count == 0) {
         $query = "INSERT INTO USER (username, password) VALUES ('$myusername','$mypassword')";
		 $res = mysqli_query($db,$query);
		 if($res){
			$success = "You have registered successfully!";
		 }
      }
   }
   error_reporting(E_ALL ^ E_NOTICE);
?>

<!DOCTYPE>
<html>
   
   <head>
      <title>Register</title>
      
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
		 .message {color: #FF0000;font-weight: bold;text-align: center;width: 100%;padding: 10;}
		 .success {color: green;font-weight: bold;text-align: center;width: 100%;padding: 10;}
		 ul {
			list-style-type: none;
			margin: 0;
			padding: 0;
			overflow: hidden;
			background-color: #333;
		}

		li a{
			display: inline-block;
			color: white;
			text-align: center;
			padding: 14px 16px;
			text-decoration: none;
		}

		li a:hover{
			background-color: green;
		}
      </style>
      
   </head>
   
   <body bgcolor = "#FFFFFF">
	<ul>
		<li style="float:left"><a href="login.php">Login</a></li>
	</ul>
	<br /><br />
      <div align = "center">
         <div style = "width:300px; border: solid 1px #333333; " align = "left">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Login</b></div>	
            <div style = "margin:30px">   
               <form action = "" method = "post">
			   <div class="message"><?php if(isset($message)) echo $message; ?></div>
                  <label>Username  :</label><input type = "text" name = "username" class = "box" value="<?php if(isset($_POST['username'])) echo $_POST['username']; ?>" /><br /><br />
                  <label>Password  :</label><input type = "password" name = "password" class = "box" /><br/><br />
				  <label>Confirm Password  :</label><input type = "password" name = "cfpassword" class = "box" /><br/><br />
                  <div class="success"><?php if(isset($success)) echo $success; ?></div>
				  <input type = "submit" value = " Register " name="register"/><br />
               </form>
            </div>	
         </div>	
      </div>
   </body>
</html>