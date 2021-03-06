<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../css/styles.css">
	</head>

	<body>
		<h1>Online Store</h1>

		<div id="main">
			<?php
				include "../autoload.php";

				try {
					$dbh = new PDO('mysql:host=' . env('DB_HOST') . ';dbname=' . env('DB_NAME'), env('DB_USERNAME'), env('DB_PASSWORD'));
				}
				catch (PDOException $e) {
					echo $e->getMessage();
				}

				$product_id = intval($_GET['product_id']);
				$stmt = $dbh->prepare("SELECT * FROM products WHERE product_id = " . $product_id);
				$stmt->execute();

				echo "<table class=\"product\">";

				while ($row = $stmt->fetch(PDO::FETCH_NAMED, PDO::FETCH_ORI_NEXT)) {
					$image = $row['image'];

					if (!file_exists('images/' . $image)) {
						$image = 'placeholder.png';
					}

					echo "<h3>" . $row['name'] . "</h3>";
					echo "<tr style=\"text-align:center\"><td>" . "<img src=\"../images/" . $image . "\" style=\"width:300;height:300;\">" . "</td></tr>";
					echo "<tr><td><h4>Description:</h4>" . $row['description'] . "</td></tr>";
					echo "<tr><td><h4>Price:</h4>$" . $row['price'] . "</td></tr>";
				}

				echo "<tr><td>";
				echo "<h4>Request Discount Code:</h4>";
				echo "<form>";
				echo "<input type=\"textbox\"><br><br>";
				echo "<input type=\"submit\">";
				echo "</form>";
				echo "</td></tr>";
				echo "<tr><td>";
				echo "<h4>Order:</h4>";
				echo "<form action=\"order.php\" method=\"post\">";
				echo "Code: <input type=\"text\" name=\"code\"> Credit Card ID: <input type=\"text\" name=\"credit_card_id\"><br><br>";
				echo "<input name=\"product_id\" type=\"hidden\" value=" . $product_id .">";
				echo "<input type=\"submit\">";
				echo "</form>";
				echo "</td></tr>";
				echo "</table><br>";

				$dbh = null;
			?>
		</div>

		<a href="../index.html">Back</a>
	</body>
</html>
