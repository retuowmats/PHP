<html>
<body>
<form method="get">
Country: <input type="text" name="country">
<br>
Language: <input type="text" name="language">
<br>
<input type="submit" value="Submit">
</form>
<br>
<p>Your language is: <?=$_GET["language"];?></p>
<p>Your country is: <?=$_GET["country"];?></p>
<a href="index.php">Reset</a>
<!-- boven GET onder POST -->

<form method="post">
Favorite Color:
<input type="text" name="color">
<br>
Favorite Food:
<input type="text" name="food">
<br>
<input type="submit" value="Submit">
</form>
<br>
<p>Best food is: <?=$_POST["food"]?></p>
<p>Best color is: <?=$_POST["color"]?></p>
<a href="index.php">Reset</a>

<!-- action om naar een andere pagina te gaan na een submit -->
<p>Thanks!</p>
<p>Your name has been recorded as:</p>
<p><?=$_GET["first"] ." ". $_GET["last"];?></p>
<a href="index.php">Reset</a>


<h1>index.php</h1>
<h2>Superglobals:</h2>
$_REQUEST:
<?php print_r($_REQUEST)?>
<br>
$_GET:
<?php print_r($_GET)?>
<br>
$_POST:
<?php print_r($_POST)?>
<h2>Forms:</h2>
<form method="get" action="handle_get.php">
GET Form: <input type="text" name="get_name">
<input type="submit" value="Submit GET">
</form>
<form method="post">
POST Form: <input type="text" name="post_name">
<input type="submit" value="Submit POST">
</form>
<a href="index.php">Reset</a>












</body>
</html>