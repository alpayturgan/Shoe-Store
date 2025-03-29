<?php
session_start();
error_reporting(0);
include('includes/config.php');
$cid = intval($_GET['scid']);
if ($cid>=13 && $cid<=17){
	$test = 3;
}
if ($cid>=19 && $cid<=23){
	$test = 4;
}
if ($cid>=24 && $cid<=28){
	$test = 5;
}


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
if (isset($_GET['pid']) && $_GET['action'] == "wishlist") {
	if (strlen($_SESSION['login']) == 0) {
		header('location:login.php');
	} else {
		mysqli_query($con, "insert into wishlist(userId,productId) values('" . $_SESSION['id'] . "','" . $_GET['pid'] . "')");
		echo "<script>alert('Product aaded in wishlist');</script>";
		header('location:my-wishlist.php');
	}
}
$sql = "SELECT sc.id AS subcategory_id, sc.subcategory, c.id AS category_id, c.categoryName
        FROM subcategory sc
        JOIN category c ON sc.categoryid = c.id
        WHERE sc.id = '$cid'";

$query = mysqli_query($con, $sql);

if ($query) {
	$row = mysqli_fetch_array($query);

	// Now, you have both subcategory and category information
	$subcategory_id = $row['subcategory_id'];
	$subcategory_name = $row['subcategory'];
	$category_id = $row['category_id'];
	$category_name = $row['categoryName'];
	
} else {
	// Handle query error
	die(mysqli_error($con));
}
?>
<!DOCTYPE html>
<html lang="en">
<style>
		.image {
			height: inherit;
		}
</style>
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

	<title>Product Category</title>
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
	<style>
		/* Bu stil öğeleri, alt kategori renklendirmesi için kullanılır */
		.sidebar-filter .nav .menu-item a {
			transition: background-color 0.3s;
		}

		.sidebar-filter .nav .menu-item a.selected {
			color: #fff;
		}
	</style>
</head>

<body class="cnt-home">
	<header class="header-style-1">
		<?php include('includes/top-header.php'); ?>
		<?php include('includes/main-header.php'); ?>
		<?php include('includes/menu-bar.php'); ?>
	</header>
	</div><!-- /.breadcrumb -->
	<div class="body-content outer-top-xs">
		<div class='container'>
			<div class='row outer-bottom-sm'>
				<div class='col-md-3 sidebar'>
					<div class="sidebar-module-container">
						<div class="sidebar-filter">
							<div class="side-menu animate-dropdown outer-bottom-xs">
								<div class="side-menu animate-dropdown outer-bottom-xs">
									<div class="head"><i class="icon fa fa-align-justify fa-fw"></i>Sub Categories</div>
									<nav class="yamm megamenu-horizontal" role="navigation">
										<ul class="nav">
											<li class="dropdown menu-item">
												<?php $sql = mysqli_query($con, "select id,subcategory  from subcategory where categoryid='$category_id'");
												while ($row = mysqli_fetch_array($sql)) {

												?>
													<a href="sub-category.php?scid=<?php echo $row['id']; ?>" class="dropdown-toggle"><svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 32px;">
													<path d="M31.9999 25.8864C31.9999 24.2687 30.7833 22.9129 29.17 22.7327C28.3706 22.6435 27.5792 22.4953 26.8181 22.2924C23.8697 21.506 15.853 17.9597 13.4662 16.8916C12.6647 16.5328 11.7446 16.7033 11.1221 17.3259L8.32985 20.1181C8.03272 20.4152 7.60048 20.5173 7.20185 20.3844L4.06279 19.3381C3.83048 19.2606 3.67455 19.0442 3.67455 18.7994V18.5009C3.67455 17.9299 3.21005 17.4654 2.63905 17.4654H2.03955C1.2128 17.4654 0.524552 18.1118 0.472677 18.9368L0.00299028 26.4069C-0.0264472 26.9676 0.16224 27.5014 0.534552 27.9179V30.2587C0.534552 30.8297 0.999051 31.2942 1.57005 31.2942H19.2067C24.4395 31.2942 28.578 30.2562 30.1144 29.81C30.535 29.6878 30.8881 29.3939 31.0832 29.0037L31.9471 27.2761C31.9826 27.205 31.9994 27.1284 31.9994 27.052H32L31.9999 25.8864ZM26.5599 23.2605C27.3691 23.4764 28.2099 23.6338 29.0588 23.7286C29.1221 23.7357 29.1845 23.7457 29.246 23.7579C29.0646 23.8167 28.8579 23.8798 28.6217 23.9462C27.6211 24.2277 25.9023 24.6213 23.3951 24.8978C22.9629 24.9454 22.5636 25.1185 22.2403 25.3981L21.4974 26.0408C21.4609 26.0291 21.4228 26.021 21.3829 26.0179C20.034 25.9142 18.6199 25.769 17.2179 25.6028L21.0477 23.3084C22.7441 23.323 23.8899 23.089 24.5308 22.6002C25.3238 22.8869 26.0191 23.1162 26.5599 23.2605ZM12.4475 24.9617C11.917 24.8829 11.4047 24.8047 10.9163 24.7284L14.195 22.7642C14.426 22.6258 14.698 22.576 14.9608 22.6238C15.3282 22.6907 15.6875 22.7526 16.0393 22.8099L12.4475 24.9617ZM17.6051 23.0401C18.1803 23.1148 18.729 23.1743 19.2485 23.2182L15.6032 25.402C15.0673 25.3324 14.538 25.2607 14.0193 25.1884L17.6051 23.0401ZM20.4503 26.9465L19.0809 28.1311C17.411 28.0868 15.9016 27.9863 14.43 27.8882C12.5324 27.7617 10.5719 27.6314 8.27872 27.6209L6.8626 25.0719C9.27735 25.4967 15.2141 26.4887 20.4503 26.9465ZM1.47242 18.9996C1.49142 18.7012 1.7403 18.4674 2.03936 18.4674H2.63886C2.6573 18.4674 2.67223 18.4824 2.67223 18.5008V18.7993C2.67223 19.4761 3.10367 20.0746 3.74573 20.2887L6.88473 21.3351C7.64579 21.5886 8.47091 21.394 9.03822 20.8267L11.8305 18.0344C12.1565 17.7084 12.6379 17.6187 13.0567 17.8062C13.2442 17.8901 13.4483 17.9812 13.6663 18.0784L13.1594 18.6294C12.9721 18.833 12.9852 19.15 13.1888 19.3374C13.2851 19.4259 13.4067 19.4696 13.528 19.4696C13.6632 19.4696 13.798 19.4152 13.8968 19.3078L14.6335 18.5071C14.9067 18.6277 15.1934 18.7538 15.491 18.8842L15.0614 19.3511C14.8741 19.5547 14.8872 19.8717 15.0908 20.0591C15.1871 20.1477 15.3087 20.1914 15.43 20.1914C15.5651 20.1914 15.7 20.1369 15.7988 20.0296L16.4625 19.3081C16.7439 19.4302 17.0318 19.5547 17.3243 19.6806L16.9634 20.0729C16.7761 20.2765 16.7892 20.5935 16.9928 20.7809C17.0891 20.8694 17.2107 20.9131 17.332 20.9131C17.4671 20.9131 17.602 20.8587 17.7008 20.7513L18.3011 20.0988C18.5881 20.221 18.8774 20.3436 19.168 20.4658L18.8655 20.7946C18.6781 20.9982 18.6913 21.3152 18.8949 21.5026C18.9911 21.5912 19.1128 21.6349 19.234 21.6349C19.3692 21.6349 19.504 21.5804 19.6028 21.473L20.1514 20.8768C21.2095 21.3157 22.2579 21.7392 23.2231 22.1109C21.7994 22.485 18.9094 22.3242 15.1399 21.6377C14.6379 21.5462 14.1192 21.6409 13.6796 21.9043L9.3771 24.4819C7.78372 24.2209 6.61048 24.0102 6.15098 23.9263C5.55198 23.1593 4.75029 22.5653 3.83011 22.2202L1.32886 21.2823L1.47242 18.9996ZM1.0033 26.4647L1.2633 22.328L3.47848 23.1587C4.43548 23.5176 5.23586 24.2073 5.73223 25.1007L7.13173 27.6198H2.10442C1.79899 27.6198 1.51499 27.4978 1.30474 27.2762C1.09455 27.0546 0.987551 26.7646 1.0033 26.4647ZM30.1869 28.5555C30.1163 28.6967 29.988 28.8032 29.8348 28.8477C28.6682 29.1865 24.4539 30.292 19.2066 30.292H1.56999C1.55155 30.292 1.53661 30.2771 1.53661 30.2587V28.6208C1.54767 28.6215 1.55886 28.6219 1.57011 28.6219H7.98335C10.3717 28.6219 12.401 28.7572 14.3633 28.888C16.3422 29.0199 18.3884 29.1563 20.81 29.1563C25.0873 29.1563 28.7652 28.3331 30.5366 27.8563L30.1869 28.5555ZM30.9978 26.6824C29.8077 27.0361 25.6597 28.1543 20.8099 28.1543C20.7349 28.1543 20.6611 28.1537 20.5867 28.1535L22.8958 26.156C23.0624 26.0119 23.2786 25.9188 23.5048 25.8939C27.6081 25.4413 29.7294 24.6846 30.4087 24.4025C30.7754 24.7924 30.9977 25.3153 30.9977 25.8863V26.6824H30.9978Z" fill="black" />
												</svg>

												<?php echo $row['subcategory']; ?></a>
												<?php } ?>
											</li>
										</ul>
									</nav>
								</div>
							</div><!-- /.side-menu -->
						</div><!-- /.sidebar-filter -->
					</div><!-- /.sidebar-module-container -->
				</div><!-- /.sidebar -->
				<div class='col-md-9'>
					<div id="category" class="category-carousel hidden-xs">
						<div class="item">
							<div class="image">
							<?php
								$sql = mysqli_query($con, "SELECT categoryImage FROM category WHERE id='$test'");

								while ($row = mysqli_fetch_array($sql)) {
									$categoryImage = $row['categoryImage'];
								?>
									<img src="admin/categoryimages/<?php echo $categoryImage; ?>" alt="" class="img-responsive" style="width: 847.5px; height: 255px;">
								<?php } ?>
								<!--<img src="assets/images/banners/cat-banner-2.jpg" alt="" class="img-responsive">-->
							</div>
							<div class="container-fluid">
								<div class="caption vertical-top text-left">
									<div class="big-text">
									</div>
									
								</div><!-- /.caption -->
							</div><!-- /.container-fluid -->
						</div>
					</div>
					<div class="search-result-container">
						<div id="myTabContent" class="tab-content">
							<div class="tab-pane active " id="grid-container">
								<div class="category-product  inner-top-vs">
									<div class="row">
										<?php
										$ret = mysqli_query($con, "select * from products where subCategory='$cid'");
										$num = mysqli_num_rows($ret);
										if ($num > 0) {
											while ($row = mysqli_fetch_array($ret)) {
										?>

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
																		<?php echo htmlentities($row['productPrice']); ?> TL</span>
																	<span class="price-before-discount"> <?php echo htmlentities($row['productPriceBeforeDiscount']); ?> TL</span>
																</div><!-- /.product-price -->
															</div><!-- /.product-info -->
															<div class="cart clearfix animate-effect">
																<div class="action">
																	<ul class="list-unstyled">
																		<li class="add-cart-button btn-group">
																			<?php if ($row['productAvailability'] == 'In Stock') { ?>

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
		function changeSubCategoryColor(subcategoryId) {
			// Tüm alt kategorilerin arkaplan rengini sıfırla
			var subcategories = document.querySelectorAll('.sidebar-filter .nav .menu-item a');
			for (var i = 0; i < subcategories.length; i++) {
				subcategories[i].style.backgroundColor = '';
				// Eski seçimi temizle
				subcategories[i].classList.remove('selected');
			}

			// Seçilen alt kategorinin rengini değiştir
			var selectedSubCategory = document.querySelector('.sidebar-filter .nav .menu-item a[href="sub-category.php?scid=' + subcategoryId + '"]');
			if (selectedSubCategory) {
				selectedSubCategory.style.backgroundColor = 'grey';
				// Yeni seçimi işaretle
				selectedSubCategory.classList.add('selected');
			}
		}

		// Sayfa yüklendiğinde mevcut alt kategorinin rengini ayarla
		document.addEventListener('DOMContentLoaded', function() {
			var currentSubCategoryId = <?php echo $cid; ?>;
			changeSubCategoryColor(currentSubCategoryId);
		});
	</script>
</body>

</html>