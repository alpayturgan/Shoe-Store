<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (isset($_GET['action']) && $_GET['action'] == "add") {
	// Check if the user is logged in
	if (strlen($_SESSION['login']) > 0) {
		$id = intval($_GET['id']);

		if (isset($_SESSION['cart'][$id])) {
			$_SESSION['cart'][$id]['quantity']++;
			$_SESSION['cart'][$id]['size'] = $_POST['size'];
			$_SESSION['cart'][$id]['color'] = $_POST['color'];
		} else {
			$sql_p = "SELECT * FROM products WHERE id={$id}";
			$query_p = mysqli_query($con, $sql_p);

			if (mysqli_num_rows($query_p) != 0) {
				$row_p = mysqli_fetch_array($query_p);
				$_SESSION['cart'][$row_p['id']] = array(
					"quantity" => 1,
					"price" => $row_p['productPrice'],
					"size" => $_POST['size'],
					"color" => $_POST['color']
				);

				// Eklediğiniz ürün bilgilerini sessiona kaydetmek istiyorsanız:
				$_SESSION['lastAddedProduct'] = array(
					"id" => $row_p['id'],
					"name" => $row_p['productName'],
					"price" => $row_p['productPrice'],
					"size" => $_POST['size'],
					"color" => $_POST['color']
				);

				echo "<script>
                  document.addEventListener('DOMContentLoaded', function() {
                      showToast('Your item added to cart', 'success');
                  });
                </script>";
			} else {
				$message = "Product ID is invalid";
			}
		}
	} else {
		// Redirect or show an error message indicating that the user needs to be logged in.
		echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                showToast('You need to be logged in to add items to the cart', 'error');
            });
        </script>";
	}
}



$pid = intval($_GET['pid']);
if (isset($_GET['pid']) && $_GET['action'] == "wishlist") {
	if (strlen($_SESSION['login']) == 0) {
		header('location:login.php');
	} else {
		mysqli_query($con, "insert into wishlist(userId,productId) values('" . $_SESSION['id'] . "','$pid')");
		echo "<script>alert('Product added to wishlist');</script>";
		header('location:my-wishlist.php');
	}
}

if (isset($_POST['submit'])) {
	$qty = $_POST['quality'];
	$price = $_POST['price'];
	$value = $_POST['value'];
	$name = $_POST['name'];
	$summary = $_POST['summary'];
	$review = $_POST['review'];
	mysqli_query($con, "insert into productreviews(productId,quality,price,value,name,summary,review) values('$pid','$qty','$price','$value','$name','$summary','$review')");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
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
	<title>Product Details</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/main.css">
	<link rel="stylesheet" href="assets/css/green.css">
	<link rel="stylesheet" href="assets/css/owl.carousel.css">
	<link rel="stylesheet" href="assets/css/owl.transitions.css">
	<link href="assets/css/lightbox.css" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/animate.min.css">
	<link rel="stylesheet" href="assets/css/rateit.css">
	<link rel="stylesheet" href="assets/css/bootstrap-select.min.css">
	<link rel="stylesheet" href="assets/css/config.css">
	<link href="assets/css/green.css" rel="alternate stylesheet" title="Green color">
	<link href="assets/css/blue.css" rel="alternate stylesheet" title="Blue color">
	<link href="assets/css/red.css" rel="alternate stylesheet" title="Red color">
	<link href="assets/css/orange.css" rel="alternate stylesheet" title="Orange color">
	<link href="assets/css/dark-green.css" rel="alternate stylesheet" title="Darkgreen color">
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">
	<link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
	<link rel="shortcut icon" href="assets/images/favicon.ico">
	<script src="https://kit.fontawesome.com/4b0cb5662c.js" crossorigin="anonymous"></script>

	<style>
		.color-buttons,
		.size-buttons {
			display: flex;
			align-items: center;
		}

		.color-button,
		.size-button {
			margin-right: 5px;
			padding: 10px;
			border: 1px solid #ccc;
			cursor: pointer;
			border-radius: 50%;
		}

		.color-button:hover,
		.color-button.active,
		.size-button:hover,
		.size-button.active {
			border-color: black;
		}

		@keyframes scaleAnimation {
			0% {
				transform: scale(1);
			}

			50% {
				transform: scale(1.1);
			}

			100% {
				transform: scale(1);
			}
		}

		.cart-button {
			animation: scaleAnimation 0.5s ease-in-out;
		}

		.custom-popup {
			position: fixed;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			padding: 15px;
			background-color: #fff;
			border: 1px solid #ccc;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
			z-index: 9999;
		}

		.custom-popup p {
			margin: 0;
		}

		#toastBox {
			position: absolute;
			bottom: 30px;
			right: 30px;
			display: flex;
			align-items: flex-end;
			flex-direction: column;
			overflow: hidden;
			padding: 20px;
		}

		.toast {
			width: 400px;
			height: 80px;
			background: #fff;
			font-weight: 500;
			margin: 15px 0;
			box-shadow: 0 0 20px rgba(red, green, blue, alpha);
			display: flex;
			align-items: center;
			position: relative;
			transform: translateX(100%);
			animation: moveleft 0.5s linear forwards, moveright 0.5s linear forwards 1s;
		}

		@keyframes moveleft {
			0% {
				transform: translateX(100%);
			}

			100% {
				transform: translateX(0);
			}
		}

		@keyframes moveright {
			0% {
				transform: translateX(0%);
			}

			100% {
				transform: translateX(100%);
			}
		}

		.toast i {
			margin: 0 20px;
			font-size: 35px;
			color: green;
		}

		.toast.error i {
			color: red;
		}

		.toast.invalid i {
			color: orange;
		}

		.toast::after {
			content: '';
			position: absolute;
			left: 0;
			bottom: 0;
			width: 100%;
			height: 5px;
			background-color: green;
			animation: anim 1s linear forwards;
		}

		@keyframes anim {
			100% {
				width: 0;
			}
		}

		.toast.error::after {
			background: red;
		}

		.toast.invalid::after {
			background: orange;
		}

		.image {
			height: inherit;
		}
	</style>
</head>

<body class="cnt-home">
	<header class="header-style-1">
		<?php include('includes/top-header.php'); ?>
		<?php include('includes/main-header.php'); ?>
		<?php include('includes/menu-bar.php'); ?>
	</header>
	<div class="breadcrumb">
		<div class="container">
			<div class="breadcrumb-inner">
				<?php
				$ret = mysqli_query($con, "select category.categoryName as catname,subCategory.subcategory as subcatname,products.productName as pname from products join category on category.id=products.category join subcategory on subcategory.id=products.subCategory where products.id='$pid'");
				while ($rw = mysqli_fetch_array($ret)) { ?>
					<ul class="list-inline list-unstyled">
						<li><a href="index.php">Home</a></li>
						<li><?php echo htmlentities($rw['catname']); ?></a></li>
						<li><?php echo htmlentities($rw['subcatname']); ?></li>
						<li class='active'><?php echo htmlentities($rw['pname']); ?></li>
					</ul>
				<?php } ?>
			</div>
		</div>
	</div>

	<div class="body-content outer-top-xs">
		<div class='container'>
			<div class='row single-product outer-bottom-sm '>
				<?php
				$ret = mysqli_query($con, "select * from products where id='$pid'");
				while ($row = mysqli_fetch_array($ret)) { ?>
					<div class='col-md-9' style="float:none;margin:auto;">
						<div class="row  wow fadeInUp">
							<div class="col-xs-12 col-sm-6 col-md-5 gallery-holder">
								<div class="product-item-holder size-big single-product-gallery small-gallery">
									<div id="owl-single-product">
										<div class="single-product-gallery-item" id="slide1">
											<a data-lightbox="image-1" data-title="<?php echo htmlentities($row['productName']); ?>" href="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage1']); ?>">
												<img class="img-responsive" alt="" src="assets/images/blank.gif" data-echo="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage1']); ?>" width="370" height="350" />
											</a>
										</div>
										<div class="single-product-gallery-item" id="slide1">
											<a data-lightbox="image-1" data-title="<?php echo htmlentities($row['productName']); ?>" href="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage1']); ?>">
												<img class="img-responsive" alt="" src="assets/images/blank.gif" data-echo="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage1']); ?>" width="370" height="350" />
											</a>
										</div>
										<div class="single-product-gallery-item" id="slide2">
											<a data-lightbox="image-1" data-title="Gallery" href="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage2']); ?>">
												<img class="img-responsive" alt="" src="assets/images/blank.gif" data-echo="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage2']); ?>" />
											</a>
										</div>
										<div class="single-product-gallery-item" id="slide3">
											<a data-lightbox="image-1" data-title="Gallery" href="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage3']); ?>">
												<img class="img-responsive" alt="" src="assets/images/blank.gif" data-echo="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage3']); ?>" />
											</a>
										</div>
									</div>
									<div class="single-product-gallery-thumbs gallery-thumbs">
										<div id="owl-single-product-thumbnails">
											<div class="item">
												<a class="horizontal-thumb active" data-target="#owl-single-product" data-slide="1" href="#slide1">
													<img class="img-responsive" alt="" src="assets/images/blank.gif" data-echo="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage1']); ?>" />
												</a>
											</div>
											<div class="item">
												<a class="horizontal-thumb" data-target="#owl-single-product" data-slide="2" href="#slide2">
													<img class="img-responsive" width="85" alt="" src="assets/images/blank.gif" data-echo="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage2']); ?>" />
												</a>
											</div>
											<div class="item">
												<a class="horizontal-thumb" data-target="#owl-single-product" data-slide="3" href="#slide3">
													<img class="img-responsive" width="85" alt="" src="assets/images/blank.gif" data-echo="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage3']); ?>" height="200" />
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class='col-sm-6 col-md-7 product-info-block'>
								<div class="product-info">
									<h1 class="name"><?php echo htmlentities($row['productName']); ?></h1>
									<?php $rt = mysqli_query($con, "select * from productreviews where productId='$pid'");
									$num = mysqli_num_rows($rt); {
									?>
										<div class="rating-reviews m-t-20">
											<div class="row">
												<div class="col-sm-3">
													<div class="rating rateit-small"></div>
												</div>
												<div class="col-sm-8">
													<div class="reviews">
														<a href="#" class="lnk">(<?php echo htmlentities($num); ?> Reviews)</a>
													</div>
												</div>
											</div>
										</div>
									<?php } ?>
									<div class="stock-container info-container m-t-10">
										<div class="row">
											<div class="col-sm-3">
												<div class="stock-box">
													<span class="label">Availability :</span>
												</div>
											</div>
											<div class="col-sm-9">
												<div class="stock-box">
													<span class="value"><?php echo htmlentities($row['productAvailability']); ?></span>
												</div>
											</div>
										</div>
									</div>
									<div class="stock-container info-container m-t-10">
										<div class="row">
											<div class="col-sm-3">
												<div class="stock-box">
													<span class="label">Product Brand :</span>
												</div>
											</div>
											<div class="col-sm-9">
												<div class="stock-box">
													<span class="value"><?php echo htmlentities($row['productCompany']); ?></span>
												</div>
											</div>
										</div>
									</div>
									<div class="stock-container info-container m-t-10">
										<div class="row">
											<div class="col-sm-3">
												<div class="stock-box">
													<span class="label">Shipping Charge :</span>
												</div>
											</div>
											<div class="col-sm-9">
												<div class="stock-box">
													<span class="value"><?php if ($row['shippingCharge'] == 0) {
																			echo "Free";
																		} else {
																			echo htmlentities($row['shippingCharge']);
																		}
																		?></span>
												</div>
											</div>
										</div>
									</div>
									<div class="stock-container info-container m-t-10">
										<div class="row">
											<div class="col-sm-3">
												<div class="stock-box">
													<span class="label">Color :</span>
												</div>
											</div>
											<div class="col-sm-9">
												<div class="color-buttons">
													<button class="color-button active" style="background-color: pink;"></button>
													<button class="color-button" style="background-color: blue;"></button>
													<button class="color-button" style="background-color: white;"></button>
												</div>
											</div>
										</div><!-- /.row -->
									</div>
									<!-- Size Options -->
									<?php
									$ct = $row['category'];
									$sql = "SELECT * FROM size WHERE category_id ='$ct'";
									$result = mysqli_query($con, $sql);
									?>
									<div class="stock-container info-container m-t-10">
										<div class="row">
											<div class="col-sm-3">
												<div class="stock-box">
													<span class="label">Size :</span>
												</div>
											</div>
											<div class="col-sm-9">
												<div class="size-buttons">
													<?php
													// Fetch sizes from the database and generate buttons
													while ($sizeRow = mysqli_fetch_assoc($result)) {
														$size1 = $sizeRow['size1'];
														$size2 = $sizeRow['size2'];
														$size3 = $sizeRow['size3'];
														$size4 = $sizeRow['size4'];
														$size5 = $sizeRow['size5'];
														echo '<button class="size-button active">' . $size1 . '</button>';
														echo '<button class="size-button">' . $size2 . '</button>';
														echo '<button class="size-button">' . $size3 . '</button>';
														echo '<button class="size-button">' . $size4 . '</button>';
														echo '<button class="size-button">' . $size5 . '</button>';
													}
													?>
												</div>
											</div>
										</div><!-- /.row -->
									</div>
									<div class="price-container info-container m-t-20">
										<div class="row">
											<div class="col-sm-6">
												<div class="price-box">
													<span class="price"><?php echo htmlentities($row['productPrice']); ?> TL</span>
													<span class="price-strike"><?php echo htmlentities($row['productPriceBeforeDiscount']); ?> TL</span>
												</div>
											</div>
											<div class="col-sm-6">
												<?php if ($row['productAvailability'] == 'In Stock') { ?>
													<div class="btn-group" role="group" style="margin-top: 10px;">
														<a href="#" onclick="addToCart(<?php echo $row['id']; ?>);" class="btn btn-primary1 cart-button" style="border-radius: 5px;">
															<i class="fa fa-shopping-cart inner-right-vs"></i> Add to Cart
														</a>
														<a class="btn btn-pink" data-toggle="tooltip" data-placement="right" style="border-radius: 5px; margin-left: 10px;" title="Wishlist" href="product-details.php?pid=<?php echo htmlentities($row['id']) ?>&&action=wishlist">
															<i class="fa-solid fa-heart" style="color: #ff0000;"></i> </a>
													</div>
												<?php } else { ?>
													<div class="action" style="color:red">Out of Stock</div>
												<?php } ?>
											</div>
										</div><!-- /.row -->
									</div><!-- /.price-container -->
									<div class="product-social-link m-t-20 text-right">
										<span class="social-label">Share :</span>
										<div class="social-icons">
											<ul class="list-inline">
												<li><a href="http://facebook.com/transvelo" class=''><i class="icon fa fa-facebook"></i></a></li>
												<li><a href="https://twitter.com/"><i class="icon fa fa-twitter"></i></a></li>
												<li><a href="https://www.linkedin.com/"><i class="icon fa fa-linkedin"></i></a></li>
												<li><a href="https://www.instagram.com/?hl=en"><i class="icon fa fa-instagram"></i></a></li>
												<li><a href="https://www.pinterest.com/"><i class="icon fa fa-pinterest"></i></a></li>
											</ul><!-- /.social-icons -->
										</div>
									</div>
								</div><!-- /.product-info -->
							</div><!-- /.col-sm-7 -->
						</div><!-- /.row -->
						<div class="product-tabs inner-bottom-xs  wow fadeInUp">
							<div class="row">
								<div class="col-sm-3">
									<ul id="product-tabs" class="nav nav-tabs nav-tab-cell">
										<li class="active"><a data-toggle="tab" href="#description">DESCRIPTION</a></li>
										<li><a data-toggle="tab" href="#review">REVIEW</a></li>
									</ul><!-- /.nav-tabs #product-tabs -->
								</div>
								<div class="col-sm-9">
									<div class="tab-content">
										<div id="description" class="tab-pane in active">
											<div class="product-tab">
												<p class="text"><?php echo $row['productDescription']; ?></p>
											</div>
										</div><!-- /.tab-pane -->
										<div id="review" class="tab-pane">
											<div class="product-tab">
												<div class="product-reviews">
													<h4 class="title">Customer Reviews</h4>
													<?php $qry = mysqli_query($con, "select * from productreviews where productId='$pid'");
													while ($rvw = mysqli_fetch_array($qry)) {
													?>
														<div class="reviews" style="border: solid 1px #000; padding-left: 2% ">
															<div class="review">
																<div class="review-title"><span class="summary"><?php echo htmlentities($rvw['summary']); ?></span><span class="date"><i class="fa fa-calendar"></i><span><?php echo htmlentities($rvw['reviewDate']); ?></span></span></div>
																<div class="text">"<?php echo htmlentities($rvw['review']); ?>"</div>
																<div class="text"><b>Quality :</b> <?php echo htmlentities($rvw['quality']); ?> Star</div>
																<div class="text"><b>Price :</b> <?php echo htmlentities($rvw['price']); ?> Star</div>
																<div class="text"><b>value :</b> <?php echo htmlentities($rvw['value']); ?> Star</div>
																<div class="author m-t-15"><i class="fa fa-pencil-square-o"></i> <span class="name"><?php echo htmlentities($rvw['name']); ?></span></div>
															</div>
														</div>
													<?php } ?><!-- /.reviews -->
												</div><!-- /.product-reviews -->
												<form role="form" class="cnt-form" name="review" method="post">
													<div class="product-add-review">
														<h4 class="title">Write your own review</h4>
														<div class="review-table">
															<div class="table-responsive">
																<table class="table table-bordered">
																	<thead>
																		<tr>
																			<th class="cell-label">&nbsp;</th>
																			<th>1 star</th>
																			<th>2 stars</th>
																			<th>3 stars</th>
																			<th>4 stars</th>
																			<th>5 stars</th>
																		</tr>
																	</thead>
																	<tbody>
																		<tr>
																			<td class="cell-label">Quality</td>
																			<td><input type="radio" name="quality" class="radio" value="1"></td>
																			<td><input type="radio" name="quality" class="radio" value="2"></td>
																			<td><input type="radio" name="quality" class="radio" value="3"></td>
																			<td><input type="radio" name="quality" class="radio" value="4"></td>
																			<td><input type="radio" name="quality" class="radio" value="5"></td>
																		</tr>
																		<tr>
																			<td class="cell-label">Price</td>
																			<td><input type="radio" name="price" class="radio" value="1"></td>
																			<td><input type="radio" name="price" class="radio" value="2"></td>
																			<td><input type="radio" name="price" class="radio" value="3"></td>
																			<td><input type="radio" name="price" class="radio" value="4"></td>
																			<td><input type="radio" name="price" class="radio" value="5"></td>
																		</tr>
																		<tr>
																			<td class="cell-label">Value</td>
																			<td><input type="radio" name="value" class="radio" value="1"></td>
																			<td><input type="radio" name="value" class="radio" value="2"></td>
																			<td><input type="radio" name="value" class="radio" value="3"></td>
																			<td><input type="radio" name="value" class="radio" value="4"></td>
																			<td><input type="radio" name="value" class="radio" value="5"></td>
																		</tr>
																	</tbody>
																</table><!-- /.table .table-bordered -->
															</div><!-- /.table-responsive -->
														</div><!-- /.review-table -->
														<div class="review-form">
															<div class="form-container">
																<div class="row">
																	<div class="col-sm-6">
																		<div class="form-group">
																			<label for="exampleInputName">Your Name <span class="astk">*</span></label>
																			<input type="text" class="form-control txt" id="exampleInputName" placeholder="" name="name" required="required">
																		</div><!-- /.form-group -->
																		<div class="form-group">
																			<label for="exampleInputSummary">Summary <span class="astk">*</span></label>
																			<input type="text" class="form-control txt" id="exampleInputSummary" placeholder="" name="summary" required="required">
																		</div><!-- /.form-group -->
																	</div>
																	<div class="col-md-6">
																		<div class="form-group">
																			<label for="exampleInputReview">Review <span class="astk">*</span></label>
																			<textarea class="form-control txt txt-review" id="exampleInputReview" rows="4" placeholder="" name="review" required="required"></textarea>
																		</div><!-- /.form-group -->
																	</div>
																</div><!-- /.row -->
																<div class="action text-right">
																	<button name="submit" class="btn btn-primary btn-upper">SUBMIT REVIEW</button>
																</div><!-- /.action -->
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
			</div>
		</div>
	<?php $cid = $row['category'];
					$subcid = $row['subCategory'];
				} ?>
	<section class="section featured-product wow fadeInUp">
		<h3 class="section-title">Related Products </h3>
		<div class="owl-carousel home-owl-carousel upsell-product custom-carousel owl-theme outer-top-xs">
			<?php
			$qry = mysqli_query($con, "select * from products where category='$cid'");
			while ($row = mysqli_fetch_array($qry)) {
				$currentProductId = $row['id'];
				$relatedProductsQuery = mysqli_query($con, "select * from products where id != '$currentProductId'");
				while ($rw = mysqli_fetch_array($relatedProductsQuery)) {
			?>
					<div class="item item-carousel">
						<div class="products">
							<div class="product">
								<div class="product-image">
									<div class="image">
										<a href="product-details.php?pid=<?php echo htmlentities($rw['id']); ?>"><img src="assets/images/blank.gif" data-echo="admin/productimages/<?php echo htmlentities($rw['id']); ?>/<?php echo htmlentities($rw['productImage1']); ?>" width="200" height="240" alt=""></a>
									</div>
								</div>
								<div class="product-info text-left">
									<h3 class="name"><a href="product-details.php?pid=<?php echo htmlentities($rw['id']); ?>"><?php echo htmlentities($rw['productName']); ?></a></h3>
									<div class="rating rateit-small"></div>
									<div class="description"></div>
									<div class="product-price">
										<span class="price">
											TL<?php echo htmlentities($rw['productPrice']); ?> </span>
										<span class="price-before-discount">TL
											<?php echo htmlentities($rw['productPriceBeforeDiscount']); ?></span>
									</div>
								</div>
								<div class="cart clearfix animate-effect">
									<div class="action">
										<ul class="list-unstyled">
											<li class="add-cart-button btn-group">
												<button class="btn btn-primary icon" data-toggle="dropdown" type="button">
													<i class="fa fa-shopping-cart"></i>
												</button>
												<a href="product-details.php?pid=<?php echo htmlentities($rw['id']); ?>" class="lnk btn btn-primary">View Product</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
			<?php }
			} ?>
		</div>
	</section>
	</div>
	<div class="clearfix"></div>
	</div>
	</div>
	</div>
	<div id="toastBox">
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
		const colorButtons = document.querySelectorAll('.color-button');
		const sizeButtons = document.querySelectorAll('.size-button');
		colorButtons.forEach(button => {
			button.addEventListener('click', () => {
				colorButtons.forEach(btn => btn.classList.remove('active'));
				button.classList.add('active');
			});
		});
		sizeButtons.forEach(button => {
			button.addEventListener('click', () => {
				sizeButtons.forEach(btn => btn.classList.remove('active'));
				button.classList.add('active');
			});
		});
	</script>
	<script>
		function addToCart(productId) {
			// Check if the user is logged in
			if (<?php echo (strlen($_SESSION['login']) > 0) ? 'true' : 'false'; ?>) {
				// AJAX ile ürünü sepete ekleme işlemi burada gerçekleştirilebilir
				// Bu işlem tamamlandıktan sonra showToast fonksiyonunu çağırabilir ve sayfa değişikliği yapabilirsiniz.

				// Örneğin:
				$.ajax({
					type: "POST",
					url: "product-details.php?action=add&id=" + productId,
					data: {
						/* Gerekli verileri buraya ekleyin */
					},
					success: function(response) {
						showToast('Your item added to cart', 'success');
						setTimeout(function() {
							window.location.href = 'my-cart.php'; // Bu satırı kaldırın
						}, 2000);
					},
					error: function(error) {
						showToast('Error adding item to cart', 'error');
					}
				});
			} else {
				// Show an error message or take appropriate action if the user is not logged in
				showToast('You need to be logged in to add items to the cart', 'error');
			}
		}

		let toastBox = document.getElementById('toastBox');

		function showToast(msg, type) {
			let toast = document.createElement('div');
			toast.classList.add('toast');
			toast.innerHTML = `<i class="fa-solid fa-circle-${type === 'error' ? 'xmark' : 'check'}"></i> ${msg}`;
			toastBox.appendChild(toast);

			if (type === 'error') {
				toast.classList.add('error');
			} else if (type === 'invalid') {
				toast.classList.add('invalid');
			}

			setTimeout(() => {
				toast.remove();
			}, 2000);
		}
	</script>
</body>

</html>