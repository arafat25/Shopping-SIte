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
if (isset($_GET['cmd']) && $_GET['cmd'] == "emptycart") {
    unset($_SESSION["cart_array"]);
}
?>
<?php 
  // Run a select query to get my letest 6 items
  // Connect to the MySQL database  

  $dynamicList = "";
  $sql = mysqli_query($db,"SELECT * FROM PRODUCT ORDER BY date_created DESC LIMIT 6");
  $productCount = mysqli_num_rows($sql); // count the output amount

  if ($productCount > 0) {
    while($row = mysqli_fetch_array($sql)){ 
		$image = $row["image"];
        $id = $row["id"];
        $product_name = $row["name"];
        $price = $row["price"];
        $dynamicList .= '
		<div class="product-item">
			<form method="post" action="cart.php">
			<div class="product-image"><img src="image/'.$image.'"></div>
			<div><strong>'.$product_name.'</strong></div>
			<div class="product-price">$'.$price.'</div>
			<input type="hidden" name="pid" id="pid" value="'.$id.'" />
			<div><input type="submit" name="add" value="Add to cart" class="btnAddAction" /></div>
			</form>
		</div>';
      }
    } else {
      $dynamicList = "We have no products listed in our store yet";
    }
	error_reporting(E_ALL ^ E_NOTICE);
?>

<!DOCTYPE html>
<html>
<head>
<style>
ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #333;
}

li {
    float: left;
}

li a, .dropbtn {
    display: inline-block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

li a:hover, .dropdown:hover .dropbtn {
    background-color: red;
}

li.dropdown {
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    text-align: left;
}

.dropdown-content a:hover {background-color: #f1f1f1}

.dropdown:hover .dropdown-content {
    display: block;
}

.active {
    background-color: #4CAF50;
}
.txt-heading{padding: 5px 10px;font-size:1.1em;font-weight:bold;color:black;}
.btnAddAction{background-color:#79b946;border:0;padding:3px 10px;color:#FFF;margin-left:1px;}
#product-grid {border-top: #F08426 2px solid;margin-bottom:30px;}
#product-grid .txt-heading{background-color: #FFD0A6;}
.product-item {	float:left;	background:#F0F0F0;	margin:15px;	padding:5px;}
.product-item div{text-align:center;	margin:10px;}
.product-price {color:#F08426;}
.product-image {height:100px;background-color:#FFF;}
</style>

</head>
<body>
<ul>
  <li><a class="active" href="index.php">Home</a></li>
  <li style="float:right"><a href="cart.php"><img style="width:14px" src="cart.png" /></a></li>
  <li class="dropdown" style="float:right"><a href="javascript:void(0)" class="dropbtn"><img style="width:14px" src="profile.png" /></a>
  <div class="dropdown-content">
    <a href="logout.php?logout">Log out</a>
   </div></li>
</ul>
<br /><br />
<div id="product-grid">
	<div class="txt-heading">Products</div>
		<?php echo $dynamicList; ?>
</div>
</body>
</html>