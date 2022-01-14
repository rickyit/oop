<?php
include('connect.php');
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
                    $result = $mysqli->query("SELECT * FROM `products`");
                    if($result->num_rows > 0) :
                        while($row = mysqli_fetch_array($result)) :
                           echo '<p>' . $row['title'] . '= ' . $row['price'] . ' <a href="cart.php?action=add&productId=' . $row['id'] . '">Add to cart</a></p>'; 
                        endwhile;
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