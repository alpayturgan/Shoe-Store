<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['login']) == 0) {
	header('location:login.php');
} else {
	// Code for product deletion from wishlist	
	$wid = intval($_GET['del']);
	if (isset($_GET['del'])) {
		$query = mysqli_query($con, "delete from wishlist where id='$wid'");
	}

	if (isset($_GET['action']) && $_GET['action'] == "add") {
		$id = intval($_GET['id']);

		// Check if the product is already in the wishlist
		$checkQuery = mysqli_query($con, "select * from wishlist where productId='$id' AND userId='" . $_SESSION['id'] . "'");
		$num = mysqli_num_rows($checkQuery);

		if ($num == 0) {
			// Product is not in the wishlist, add it
			$query = mysqli_query($con, "delete from wishlist where productId='$id'");
			if (isset($_SESSION['cart'][$id])) {
				$_SESSION['cart'][$id]['quantity']++;
			} else {
				$sql_p = "SELECT * FROM products WHERE id={$id}";
				$query_p = mysqli_query($con, $sql_p);
				if (mysqli_num_rows($query_p) != 0) {
					$row_p = mysqli_fetch_array($query_p);
					$_SESSION['cart'][$row_p['id']] = array("quantity" => 1, "price" => $row_p['productPrice']);
					header('location:my-wishlist.php');
				} else {
					$message = "Product ID is invalid";
				}
			}
		} else {
			// Product is already in the wishlist, handle accordingly
			echo "Product is already in the wishlist";
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Meta -->
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="keywords" content="MediaCenter, Template, eCommerce">
	<meta name="robots" content="all">

	<title>My Wishlist</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">

	<!-- Customizable CSS -->
	<link rel="stylesheet" href="assets/css/main.css">
	<link rel="stylesheet" href="assets/css/green.css">
	<link rel="stylesheet" href="assets/css/owl.carousel.css">
	<link rel="stylesheet" href="assets/css/owl.transitions.css">
	<!--<link rel="stylesheet" href="assets/css/owl.theme.css">-->
	<link href="assets/css/lightbox.css" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/animate.min.css">
	<link rel="stylesheet" href="assets/css/rateit.css">
	<link rel="stylesheet" href="assets/css/bootstrap-select.min.css">

	<!-- Demo Purpose Only. Should be removed in production -->
	<link rel="stylesheet" href="assets/css/config.css">

	<link href="assets/css/green.css" rel="alternate stylesheet" title="Green color">
	<link href="assets/css/blue.css" rel="alternate stylesheet" title="Blue color">
	<link href="assets/css/red.css" rel="alternate stylesheet" title="Red color">
	<link href="assets/css/orange.css" rel="alternate stylesheet" title="Orange color">
	<link href="assets/css/dark-green.css" rel="alternate stylesheet" title="Darkgreen color">
	<!-- Demo Purpose Only. Should be removed in production : END -->


	<!-- Icons/Glyphs -->
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">

	<!-- Fonts -->
	<link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
	<link rel="shortcut icon" href="assets/images/favicon.ico">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet">
	<link href="https://fonts.cdnfonts.com/css/valorant" rel="stylesheet">

</head>

<body class="cnt-home">
	<header class="header-style-1">

		<!-- ============================================== TOP MENU ============================================== -->
		<?php include('includes/top-header.php'); ?>
		<!-- ============================================== TOP MENU : END ============================================== -->
		<?php include('includes/main-header.php'); ?>
		<!-- ============================================== NAVBAR ============================================== -->
		<?php include('includes/menu-bar.php'); ?>
		<!-- ============================================== NAVBAR : END ============================================== -->

	</header>

	<!-- ============================================== HEADER : END ============================================== -->
	<div class="breadcrumb">
		<div class="container">
			<div class="breadcrumb-inner">
				<ul class="list-inline list-unstyled">
					<li><a href="home.html">Home</a></li>
					<li class='active'>Wishlish</li>
				</ul>
			</div><!-- /.breadcrumb-inner -->
		</div><!-- /.container -->
	</div><!-- /.breadcrumb -->

	<div class="body-content outer-top-bd">
		<div class="container">
			<div class="my-wishlist-page inner-bottom-sm">
				<div class="row">
					<div class="col-md-12 my-wishlist">
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th colspan="4">my wishlist</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$ret = mysqli_query($con, "SELECT 
products.productName AS pname,
products.productName AS proid,
products.productImage1 AS pimage,
products.productPrice AS pprice,
wishlist.productId AS pid,
wishlist.id AS wid 
FROM wishlist 
JOIN products ON products.id = wishlist.productId 
WHERE wishlist.userId='" . $_SESSION['id'] . "'");
									$num = mysqli_num_rows($ret);
									if ($num > 0) {
										$prevProductId = null; // Initialize variable to store the previous product ID

										while ($row = mysqli_fetch_array($ret)) {
											if ($row['pid'] != $prevProductId) {

									?>

												<tr>
													<td class="col-md-2"><img src="admin/productimages/<?php echo htmlentities($row['pid']); ?>/<?php echo htmlentities($row['pimage']); ?>" alt="<?php echo htmlentities($row['pname']); ?>" width="60" height="100"></td>
													<td class="col-md-6">
														<div class="product-name"><a href="product-details.php?pid=<?php echo htmlentities($pd = $row['pid']); ?>"><?php echo htmlentities($row['pname']); ?></a></div>
														<?php $rt = mysqli_query($con, "select * from productreviews where productId='$pd'");
														$num = mysqli_num_rows($rt); {
														?>

															<div class="rating">
																<i class="fa fa-star rate"></i>
																<i class="fa fa-star rate"></i>
																<i class="fa fa-star rate"></i>
																<i class="fa fa-star rate"></i>
																<i class="fa fa-star non-rate"></i>
																<span class="review">( <?php echo htmlentities($num); ?> Reviews )</span>
															</div>
														<?php } ?>
														<div class="price">
															<?php echo htmlentities($row['pprice']); ?>.00 TL

														</div>
													</td>
													<td class="col-md-2">
														<a href="product-details.php?pid=<?php echo htmlentities($row['pid']); ?>" class="btn-upper btn btn-primary">View Product</a>
													</td>
													<td class="col-md-2 close-btn">
														<a href="my-wishlist.php?del=<?php echo htmlentities($row['wid']); ?>" onClick="return confirm('Are you sure you want to delete?')" class=""><i class="fa fa-times"></i></a>
													</td>
												</tr>
										<?php }
											$prevProductId = $row['pid'];
										}
									} else { ?>
										<tr>
											<td style="font-size: 18px; font-weight:bold ">Your Wishlist is Empty</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div><!-- /.row -->
			</div><!-- /.sigin-in-->
		</div>
	</div>
	<?php include('includes/footer.php'); ?>

	<script src="assets/js/jquery-1.11.1.min.js"></script>

	<script src="assets/js/bootstrap.min.js"></script>

	<script src="assets/js/bootstrap-hover-dropdown.min.js"></script>
	<script src="assets/js/owl.carousel.min.js"></script>

	<script src="assets/js/echo.min.js"></script>
	<script src="assets/js/jquery.easing-1.3.min.js"></script>
	<script src="assets/js/bootstrap-slider.min.js"></script>
	<script src="assets/js/jquery.rateit.min.js"></script>
	<script type="text/javascript" src="assets/js/lightbox.min.js"></script>
	<script src="assets/js/bootstrap-select.min.js"></script>
	<script src="assets/js/wow.min.js"></script>
	<script src="assets/js/scripts.js"></script>

	<!-- For demo purposes – can be removed on production -->

	<script src="switchstylesheet/switchstylesheet.js"></script>

	<script>
		$(document).ready(function() {
			$(".changecolor").switchstylesheet({
				seperator: "color"
			});
			$('.show-theme-options').click(function() {
				$(this).parent().toggleClass('open');
				return false;
			});
		});

		$(window).bind("load", function() {
			$('.show-theme-options').delay(2000).trigger('click');
		});
	</script>
</body>

</html>