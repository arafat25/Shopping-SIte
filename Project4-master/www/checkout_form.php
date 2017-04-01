<?php
 ob_start();
 session_start();
 require_once 'dbconnect.php';
 
 if( !isset($_SESSION['user']) ) {
    header("Location: login.php");
    exit;
 }
?>
<?php
if(isset($_POST['submit'])){
	$cc_num = $_POST['cc'];
	$type = $_POST['cardtype'];
	$cc_num =strip_tags(trim($cc_num));
	$type =strip_tags(trim($type));

    if($type == "amex") {
    $denum = "American Express";
    } elseif($type == "disc") {
    $denum = "Discover";
    } elseif($type == "mc") {
    $denum = "Master Card";
    } elseif($type == "visa") {
    $denum = "Visa";
    }

    if($type == "amex") {
    $pattern = "/^([34|37]{2})([0-9]{13})$/";//American Express
    if (preg_match($pattern,$cc_num)) {
    $verified = true;
    } else {
    $verified = false;
    }


    } elseif($type == "disc") {
    $pattern = "/^([6011]{4})([0-9]{12})$/";//Discover Card
    if (preg_match($pattern,$cc_num)) {
    $verified = true;
    } else {
    $verified = false;
    }


    } elseif($type == "mc") {
    $pattern = "/^([51|52|53|54|55]{2})([0-9]{14})$/";//Mastercard
    if (preg_match($pattern,$cc_num)) {
    $verified = true;
    } else {
    $verified = false;
    }


    } elseif($type == "visa") {
    $pattern = "/^([4]{1})([0-9]{12,15})$/";//Visa
    if (preg_match($pattern,$cc_num)) {
    $verified = true;
    } else {
    $verified = false;
    }

    }
	
    if($verified == false) {
    //Do something here in case the validation fails
    $error = "Invalid card type";

    } else { //if it will pass...do something
		$total =0;
		$i =1;

		//get last 4 digits
		$last4 = substr($cc_num, -4,4);
		
		//split string into array
		$cc_num =str_split($cc_num);
		
		//reverse array
		$cc_num =array_reverse($cc_num);
		
		//loop through array and calculate
		foreach($cc_num as $digit){
			//if even number
			if($i % 2 == 0){
				//multiply digit by 2
				$digit *=2;
				
				//if >9
				if($digit >9){
					//subtract 9
					$digit -=9;
				}
			}
			//total = total + digit
			$total += $digit;
			
			//increase incrementor by 1
			$i++;
		}
		if($total % 10 ==0){
			header("location: confirmation.php"); 
			exit();
		}else {
			$error = "Invalid credit card number";
		}
    }
}
error_reporting(E_ALL ^ E_NOTICE);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Credit Card Info</title>
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
			background-color: red;
		}
      </style>
</head>
<body bgcolor = "#FFFFFF">
	<ul>
		<li style="float:right"><a href="cart.php">Go Back</a></li>
	</ul><br /><br />
      <div align = "center">
         <div style = "width:300px; border: solid 1px #333333; " align = "left">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Credit Card Info</b></div>
				
            <div style = "margin:30px">
				<form method="post">
					<h3>CREDIT CARD INFORMATION</h3>
					<label>Name: </label><input type="text" name="name" class = "box" value="<?php if(isset($_POST['name'])) echo $_POST['name']; ?>"/><br /><br />
					<label>Credit Card Type: </label><select name="cardtype" id="cctype" class = "box">
						<option value="visa" id="cctype">VISA</option>
						<option value="mc" id="cctype">Master Card</option>
						<option value="amex" id="cctype">American Express</option>
						<option value="disc" id="cctype">Discover</option>
						</select><br /><br />
					<label>Credit Card Number: </label><input type="text" name="cc" class = "box" id="cc" value="<?php if(isset($_POST['cc'])) echo $_POST['cc']; ?>"/><br /><br />
					<label>Expiration date: </label><input type="month" name="month-and-year" class = "box" /><br /><br />
					<h3>Billing Information</h3>
					<label>Address: </label><br /><input type="text" class="box" placeholder="Street" name="street" value="<?php if(isset($_POST['street'])) echo $_POST['street']; ?>" /><br /><br />
					<input type="text" class="box" placeholder="City" name="city" value="<?php if(isset($_POST['city'])) echo $_POST['city']; ?>"/><br /><br />
					<select class = "box">
						<option value="AL">Alabama</option>
						<option value="AK">Alaska</option>
						<option value="AZ">Arizona</option>
						<option value="AR">Arkansas</option>
						<option value="CA">California</option>
						<option value="CO">Colorado</option>
						<option value="CT">Connecticut</option>
						<option value="DE">Delaware</option>
						<option value="DC">District Of Columbia</option>
						<option value="FL">Florida</option>
						<option value="GA">Georgia</option>
						<option value="HI">Hawaii</option>
						<option value="ID">Idaho</option>
						<option value="IL">Illinois</option>
						<option value="IN">Indiana</option>
						<option value="IA">Iowa</option>
						<option value="KS">Kansas</option>
						<option value="KY">Kentucky</option>
						<option value="LA">Louisiana</option>
						<option value="ME">Maine</option>
						<option value="MD">Maryland</option>
						<option value="MA">Massachusetts</option>
						<option value="MI">Michigan</option>
						<option value="MN">Minnesota</option>
						<option value="MS">Mississippi</option>
						<option value="MO">Missouri</option>
						<option value="MT">Montana</option>
						<option value="NE">Nebraska</option>
						<option value="NV">Nevada</option>
						<option value="NH">New Hampshire</option>
						<option value="NJ">New Jersey</option>
						<option value="NM">New Mexico</option>
						<option value="NY">New York</option>
						<option value="NC">North Carolina</option>
						<option value="ND">North Dakota</option>
						<option value="OH">Ohio</option>
						<option value="OK">Oklahoma</option>
						<option value="OR">Oregon</option>
						<option value="PA">Pennsylvania</option>
						<option value="RI">Rhode Island</option>
						<option value="SC">South Carolina</option>
						<option value="SD">South Dakota</option>
						<option value="TN">Tennessee</option>
						<option value="TX">Texas</option>
						<option value="UT">Utah</option>
						<option value="VT">Vermont</option>
						<option value="VA">Virginia</option>
						<option value="WA">Washington</option>
						<option value="WV">West Virginia</option>
						<option value="WI">Wisconsin</option>
						<option value="WY">Wyoming</option>
					</select><br /><br />
					<input type="text" class="box" placeholder="Zipcode" name="zip" value="<?php if(isset($_POST['zip'])) echo $_POST['zip']; ?>"/><br /><br />
					<label>Phone Number: </label><input type="text" class="box" placeholder="XXX-XXX-XXXX" name="phone" value="<?php if(isset($_POST['phone'])) echo $_POST['phone']; ?>"/><br /><br />
					<input type="submit" name="submit" value="Pay Now" id="Paynow" />
				</form>
				<div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
			</div>
         </div>
      </div>
</body>
</html>

