<?php
include('connect.php');

$userId = 2;

if(isset($_GET['action'])) :
    $productId = $_GET['productId'];
    switch($_GET['action']) :
        case 'add':
            $result = $mysqli->query("SELECT `qty` FROM `cart` WHERE `userId` = $userId AND `productId` = " . $productId);
            if($result->num_rows > 0) :
                $row = mysqli_fetch_array($result);
                $qty = ($row['qty'] + 1);
                $result = $mysqli->query("UPDATE `cart` SET `qty` = $qty  WHERE `userId` = $userId AND `productId` = " . $productId);
            else:
                $result = $mysqli->query("INSERT INTO `cart` (`userId`, `productId`, `qty`) VALUES ('$userId', '$productId', '1')");
            endif;
            header("Location: cart.php");
            break;
        case 'delete': 
            $result = $mysqli->query("SELECT `qty` FROM `cart` WHERE `userId` = $userId AND `productId` = " . $productId);
            if($result->num_rows > 0) :
                $row = mysqli_fetch_array($result);
                $qty = ($row['qty'] - 1);
                $result = $mysqli->query("UPDATE `cart` SET `qty` = $qty  WHERE `userId` = $userId AND `productId` = " . $productId);
            endif;
            header("Location: cart.php");
            break;
        case 'remove': 
            $result = $mysqli->query("DELETE FROM `cart` WHERE `userId` = $userId AND `productId` = " . $productId);
            header("Location: cart.php");
            break;
        default:
            header("Location: index.php");
    endswitch;
endif;

$cart = $mysqli->query("SELECT `cart`.*, `products`.`title`, `products`.`price` FROM `cart` LEFT JOIN `products` ON `products`.`id` = `cart`.`productId` WHERE `cart`.`userId` = " . $userId);

if(isset($_GET['checkout']) && $cart->num_rows > 0) {

    $grandTotal = $_GET['checkout'];

    $insertOrder = $mysqli->query("
        INSERT INTO `orders`
        (`userId`, `grandTotal`)
        VALUES
        ('$userId', '$grandTotal')
    ");
    if($insertOrder) {
        $orderId = $mysqli->insert_id;
        while($row = mysqli_fetch_array($cart)) {
            echo "INSERT INTO `order_items`
            (`orderId`, `productId`, `qty`, `price`)
            VALUES
            ('$orderId', '".$row['productId']."', '".$row['qty']."', '".$row['price']."')";
            $result = $mysqli->query("
                INSERT INTO `order_items`
                (`orderId`, `productId`, `qty`, `price`)
                VALUES
                ('$orderId', '".$row['productId']."', '".$row['qty']."', '".$row['price']."')
            ");   
        }
        $result = $mysqli->query("
            DELETE FROM `cart` WHERE `userId` = $userId
        ");
        if($result) {
            header("Location: checkout.php");
        }
    }
} 


?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/js/scripts.js" type="text/javascript"></script>
    <title>Document</title>
</head>
<body>
<div id="wrapper">
    <header id="header">
        <div class="container">
            <div class="row">
                <div class="col-4">
                    <a href="/oop/">Logo</a>
                </div>
                <div class="col-8">

                </div>
            </div>
        </div>
    </header>
    <main id="main">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <?php
                    if($cart->num_rows > 0) :
                        $grandTotal = 0;
                        echo '<table class="cart">';
                        echo '<tr><th>Product</th><th>Quantity</th><th>Total</th></tr>';
                        while($row = mysqli_fetch_array($cart)) :
                           echo '<tr>';
                                echo '<td class="products">';
                                echo '<a href="cart.php?action=remove&productId='.$row['productId'].'">x</a>';
                                    echo  $row['title'];
                                    echo '<a href="cart.php?action=add&productId='.$row['productId'].'">+</a>';
                                    echo '<a href="cart.php?action=delete&productId='.$row['productId'].'">-</a>';
                                echo '</td>';
                                echo '<td>x' . $row['qty'] . '</td>';
                                $subtotal = ($row['qty'] * $row['price']);
                                $grandTotal = $grandTotal + $subtotal;
                                echo '<td>P'.number_format($subtotal, 2).'</td>';
                           echo '</tr>';
                        endwhile;
                        echo '<tr><th colspan="2">Grand Total<br /><a href="cart.php?checkout='.$grandTotal.'">Checkout</a></th><th>P'.number_format($grandTotal,2).'</th></tr>';
                        echo '</table>';
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </main>
    <footer id="footer">
    <div class="container">
            <div class="row">
                <div class="col-3">1</div>
                <div class="col-3">2</div>
                <div class="col-3">3</div>
                <div class="col-3">4</div>
            </div>
        </div>
    </footer>
</div>
</body>

</html>