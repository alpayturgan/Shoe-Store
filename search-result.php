<?php
session_start();
error_reporting(0);
include('includes/config.php');
$sortOrder = "";

$find = "%" . mysqli_real_escape_string($con, $_POST['product']) . "%";
if (isset($_GET['action']) && $_GET['action'] == "add") {
	$id = intval($_GET['id']);
	if (isset($_SESSION['cart'][$id])) {
		$_SESSION['cart'][$id]['quantity']++;
	} else {
		$sql_p = "SELECT * FROM products WHERE id={$id}";
		$query_p = mysqli_query($con, $sql_p);
		if (mysqli_num_rows($query_p) != 0) {
			$row_p = mysqli_fetch_array($query_p);
			$_SESSION['cart'][$row_p['id']] = array("quantity" => 1, "price" => $row_p['productPrice']);
			echo "<script>alert('Product has been added to the cart')</script>";
			echo "<script type='text/javascript'> document.location ='my-cart.php'; </script>";
		} else {
			$message = "Product ID is invalid";
		}
	}
}
// COde for Wishlist
if (isset($_GET['pid']) && $_GET['action'] == "wishlist") {
	if (strlen($_SESSION['login']) == 0) {
		header('location:login.php');
	} else {
		mysqli_query($con, "insert into wishlist(userId,productId) values('" . $_SESSION['id'] . "','" . $_GET['pid'] . "')");
		echo "<script>alert('Product aaded in wishlist');</script>";
		header('location:my-wishlist.php');
	}
}

if (isset($_POST['category'])) {
	$sortOption = $_POST['category'];
	if ($sortOption == 'price') {
		$sortOrder = "ORDER BY productPrice ASC";
	} elseif ($sortOption == 'price-desc') {
		$sortOrder = "ORDER BY productPrice DESC";
	}
}

$find = "%" . mysqli_real_escape_string($con, $_POST['product']) . "%";
$query = "SELECT * FROM products WHERE productName LIKE '$find' $sortOrder";
$ret = mysqli_query($con, $query);
$num = mysqli_num_rows($ret);

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
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet">
	<link href="https://fonts.cdnfonts.com/css/valorant" rel="stylesheet">


	<title>Product Category</title>

	<!-- Bootstrap Core CSS -->
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

	<!-- Favicon -->
	<link rel="shortcut icon" href="assets/images/favicon.ico">

	<!-- HTML5 elements and media queries Support for IE8 : HTML5 shim and Respond.js -->
	<!--[if lt IE 9]>
			<script src="assets/js/html5shiv.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]-->

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
	</div><!-- /.breadcrumb -->
	<div class="body-content outer-top-xs">
		<div class='container'>
			<div class='row outer-bottom-sm'>

				<!-- Size options container -->




				<!-- ========================================== SECTION – HERO ========================================= -->
				<div style="margin-top: 10px">

					<!-- Sort by price and size -->
					<form name="sort" method="post">
						<select style="width: 150px;float: right;margin: 5px" class="form-control" name="category" id="category" onchange="this.form.submit()">
							<option value="">Sort by</option>
							<option value="price">Price: Low to High</option>
							<option value="price-desc">Price: High to Low</option>
						</select>

						<!-- Size filter -->
					</form>
				</div>

				<div id="sizeOptionsContainer" style="display: none;">
					<!-- Size options will be dynamically added here -->
				</div>

				<div class="search-result-container">
					<div id="myTabContent" class="tab-content">
						<div class="tab-pane active " id="grid-container">
							<div class="category-product  inner-top-vs">
								<div class="row">
									<?php
									if ($num > 0) {
										while ($row = mysqli_fetch_array($ret)) { ?>
											<div class="col-sm-6 col-md-4 wow fadeInUp">
												<div class="products">
													<div class="product">
														<div class="product-image">
															<div class="image">
																<a href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>"><img src="assets/images/blank.gif" data-echo="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage1']); ?>" alt="" width="200" height="240"></a>
															</div><!-- /.image -->
														</div><!-- /.product-image -->
														<div class="product-info text-left">
															<h3 class="name"><a href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>"><?php echo htmlentities($row['productName']); ?></a></h3>
															<div class="rating rateit-small"></div>
															<div class="description"></div>
															<div class="product-price">
																<span class="price">
																	<?php echo htmlentities($row['productPrice']); ?> TL </span>
																<span class="price-before-discount"><?php echo htmlentities($row['productPriceBeforeDiscount']); ?>TL</span>

															</div><!-- /.product-price -->
														</div><!-- /.product-info -->
														<div class="cart clearfix animate-effect">
															<div class="action">
																<ul class="list-unstyled">
																	<li class="add-cart-button btn-group">
																		<?php if ($row['productAvailability'] == 'In Stock') { ?>
																			<button class="btn btn-primary icon" data-toggle="dropdown" type="button">
																				<i class="fa fa-shopping-cart"></i>
																			</button>
																			<a href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>">
																				<button class="btn btn-primary" type="button">View Product</button></a>
																		<?php } else { ?>
																			<div class="action" style="color:red">Out of Stock</div>
																		<?php } ?>
																	</li>
																	<li class="lnk wishlist">
																		<a class="add-to-cart" href="category.php?pid=<?php echo htmlentities($row['id']) ?>&&action=wishlist" title="Wishlist">
																			<i class="icon fa fa-heart"></i>
																		</a>
																	</li>
																</ul>
															</div><!-- /.action -->
														</div><!-- /.cart -->
													</div>
												</div>
											</div>
										<?php }
									} else { ?>
										<div class="col-sm-6 col-md-4 wow fadeInUp">
											<h3>No Product Found</h3>
										</div>
									<?php } ?>
								</div><!-- /.row -->
							</div><!-- /.category-product -->
						</div><!-- /.tab-pane -->
					</div><!-- /.search-result-container -->
				</div><!-- /.col -->
			</div>
		</div>
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
	<script>
		$(document).ready(function() {
			// Function to generate size options
			function generateSizeOptions() {
				// Clear previous options
				$("#sizeOptionsContainer").empty();

				// Add 15 size options (3x5)
				for (let i = 1; i <= 15; i++) {
					$("#sizeOptionsContainer").append('<div>Size ' + i + '</div>');
				}

				// Add Size - button
				$("#sizeOptionsContainer").append('<button type="button" class="btn btn-danger" id="sizeFilterMinus">Size -</button>');
			}

			// Handle Size + button click
			$("#sizeFilter").click(function() {
				// Toggle the display of size options container
				$("#sizeOptionsContainer").toggle();

				// If the container is visible, generate size options dynamically
				if ($("#sizeOptionsContainer").is(":visible")) {
					generateSizeOptions();
				}
			});

			// Handle Size - button click
			$("#sizeOptionsContainer").on("click", "#sizeFilterMinus", function() {
				// Hide the size options container
				$("#sizeOptionsContainer").hide();
			});
		});
	</script>
</body>

</html>