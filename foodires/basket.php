<?php 
	
	session_start();
	require "admin/includes/functions.php";
	require "admin/includes/db.php";
	
?>

<?php 

	if (isset($_GET['fid']) && isset($_GET['qty'])) {
		$fid = $_GET['fid'];
		$qty = isset($_GET['qty']) ? (int)$_GET['qty'] : 1;
		$wasFound = false;
        $i = 0;
        if (!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1) { 
			
			$_SESSION["cart_array"] = array(0 => array("item_id" => $fid, "quantity" => $qty));
		}
        else {
			
            $qty = isset($_GET['qty']) ? (int)$_GET['qty'] : 1;
            foreach ($_SESSION["cart_array"] as $each_item) { 
                $i++;
                while (list($key, $value) = each($each_item)) {
                    if ($key == "item_id" && $value == $fid) {
                        // That item is in cart already so let's adjust its quantity using array_splice()
                        array_splice($_SESSION["cart_array"], $i-1, 1, array(array("item_id" => $fid, "quantity" => $each_item['quantity'] + $qty)));
                        $wasFound = true;
                    } 
                }
    }
    if ($wasFound == false) {
        array_push($_SESSION["cart_array"], array("item_id" => $fid, "quantity" => $qty));
    }
    header("location: basket.php"); 
		exit();
}
    ?>

<?php
 
 if (isset($_GET['cmd']) && $_GET['cmd'] == "emptycart") {
     unset($_SESSION["cart_array"]); //empty the foody cart
 }
 
?>

<?php 

	if (isset($_POST['index_to_remove']) && $_POST['index_to_remove'] != "") {
		// Access the array and run code to remove that array index
		$key_to_remove = $_POST['index_to_remove'];
		if (count($_SESSION["cart_array"]) <= 1) {
			unset($_SESSION["cart_array"]);
		} else {
			unset($_SESSION["cart_array"]["$key_to_remove"]);
			sort($_SESSION["cart_array"]);
		}
	}
	
?>
<?php 

$cartOutput = "";
$cartTotal = "";
$chkbtn = "";
$empty_cart = "";
$chkprice = "";
$product_id_array = "";
if (!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1) {
		
    $cartOutput = "<h3 style=' text-align: center; font-weight: lighter; padding: 10px 0px; background: #ffeeee; color: #333;'>Your shopping basket is empty</h3>";
    
} else{
		
    $cartOutput = "<div class='single_order_head'>
            
                        <h3>Food</h3>
                        <h3>Price(N)</h3>
                        <h3>Qty</h3>
                        <h3>Total</h3>
                        <h3>Remove</h3>
                        
                    </div>";
                    
    
    $i = 0;

    foreach ($_SESSION["cart_array"] as $each_item) { 
        $item_id = $each_item['item_id'];
        $sql = $db->query("SELECT * FROM food WHERE id='$item_id' LIMIT 1");
        while ($row = $sql->fetch_assoc()) {
				
            $foodName = $row['food_name'];
            $price = $row['food_price'];
            
        }
        $pricetotal = $price * $each_item['quantity'];
        while ($row = $sql->fetch_assoc()) {
				
            $foodName = $row['food_name'];
            $price = $row['food_price'];
            
        }
        $pricetotal = $price * $each_item['quantity'];
        $cartTotal = $pricetotal + $cartTotal;
        $x = $i + 1;

        $empty_cart = '<div class="empty_cart">
				
        <a href="basket.php?cmd=emptycart">Empty Basket</a>
								
                            </div>';
                            
        $chkbtn = '<div class="checkout">
				
				<a href="#" onclick="show_overlay(); return false">Checkout</a>
							
        </div>';       
        $product_id_array .= "$foodName-".$each_item['quantity'].", ";            
        $cartOutput .= '<form style="display: inline; padding: 0; margin: 0;" action="basket.php" method="post">
        <div class="single_order">
					
					<p>' . $foodName . '</p>
					<p>' . $price . '</p>
					<p><select name="quantity" id="'.$item_id.'" onChange="update_qty(\''.$item_id.'\')"> 
						'.render_options($each_item['quantity'], $item_id).'
					</select></p>
					<p id="ajax_qty_'.$item_id.'">'.$pricetotal.'</p>
					<p><input name="deleteBtn' . $item_id . '" class="remove" onclick="return verify_choice();" type="submit" value="x" /><input name="index_to_remove" type="hidden" value="' . $i . '" /></p>
					
				</div>
			
            </form>';
            $chkprice .= '<input type="hidden" id="chkprice" name="chkprice" value="'.$cartTotal.'" />';
			$chkfood = '<input type="hidden" id="chkfood" name="chkfood" value="'.$product_id_array.'" />';
				
			$i++;
    }
    $cartTotal = '<p class="p_total"><span>Basket Total</span> : #'.$cartTotal.'</p>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>foodires</title>
</head>
<body>
<?php require "includes/header.php"; ?>
<div class="parallax_basket" onclick="remove_class()">
	
	<div class="parallax_head_basket">
		
		<h2>Your</h2>
		<h3>Basket</h3>
		
	</div>
	
</div>
</body>
</html>