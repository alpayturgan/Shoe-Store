<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (isset($_POST['submit'])) {
	if (!empty($_SESSION['cart'])) {
		$exceededLimit = false;
		foreach ($_POST['quantity'] as $key => $val) {
			if ($val > 10) {
				$exceededLimit = true;
				$val = 10;
			}
			if ($val == 0) {
				unset($_SESSION['cart'][$key]);
			} else {
				$_SESSION['cart'][$key]['quantity'] = $val;
			}
		}
		if ($exceededLimit) {
			echo "<script>
		  document.addEventListener('DOMContentLoaded', function() {
			  showToast('You can only add up to 10 units of a product', 'error');
		  });
		</script>";
		} else {

			echo "<script>
              document.addEventListener('DOMContentLoaded', function() {
                  showToast('Your card is updated', 'success');
              });
            </script>";
			header("refresh:1.2");
		}
	}
}
if (isset($_POST['remove_code'])) {
	if (!empty($_SESSION['cart'])) {
		foreach ($_POST['remove_code'] as $key) {
			unset($_SESSION['cart'][$key]);
		}
		echo "<script>
              document.addEventListener('DOMContentLoaded', function() {
                  showToast('Your item removed succesfully', 'success');
              });
            </script>";
	}
}
if (isset($_POST['ordersubmit'])) {
	if (strlen($_SESSION['login']) == 0) {
		header('location:login.php');
	} else {
		$quantity = $_POST['quantity'];
		$pdd = $_SESSION['pid'];
		$value = array_combine($pdd, $quantity);
		foreach ($value as $qty => $val34) {
			mysqli_query($con, "insert into orders(userId,productId,quantity) values('" . $_SESSION['id'] . "','$qty','$val34')");
			header('location:payment-method.php');
		}
	}
}
if (isset($_POST['update'])) {
	$baddress = $_POST['billingaddress'];
	$bstate = $_POST['bilingstate'];
	$bcity = $_POST['billingcity'];
	$bpincode = $_POST['billingpincode'];
	$query = mysqli_query($con, "update users set billingAddress='$baddress',billingState='$bstate',billingCity='$bcity',billingPincode='$bpincode' where id='" . $_SESSION['id'] . "'");
	if ($query) {
		echo "<script>
              document.addEventListener('DOMContentLoaded', function() {
                  showToast('Billing Address Updated', 'success');
              });
            </script>";
	}
}
if (isset($_POST['shipupdate'])) {
	$saddress = $_POST['shippingaddress'];
	$sstate = $_POST['shippingstate'];
	$scity = $_POST['shippingcity'];
	$spincode = $_POST['shippingpincode'];
	$query = mysqli_query($con, "update users set shippingAddress='$saddress',shippingState='$sstate',shippingCity='$scity',shippingPincode='$spincode' where id='" . $_SESSION['id'] . "'");
	if ($query) {
		echo "<script>
              document.addEventListener('DOMContentLoaded', function() {
                  showToast('Shipping Address Updated', 'success');
              });
            </script>";
	}
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
	<title>My Cart</title>
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
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet">
	<link href="https://fonts.cdnfonts.com/css/valorant" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="NEW_INTEGRITY_VALUE" crossorigin="anonymous">
	<script src="https://kit.fontawesome.com/4b0cb5662c.js" crossorigin="anonymous"></script>
	<style>
		.custom-popup {
			position: absolute;
			/* Change this to 'fixed' or 'absolute' based on your preference */
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
				<ul class="list-inline list-unstyled">
					<li><a href="#">Home</a></li>
					<li class='active'>Shopping Cart</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="body-content outer-top-xs">
		<div class="container">
			<div class="row inner-bottom-sm">
				<div class="shopping-cart">
					<div class="col-md-12 col-sm-12 shopping-cart-table ">
						<div class="table-responsive">
							<form name="cart" method="post" id="cartForm">
								<?php
								if (!empty($_SESSION['cart'])) {
								?>
									<table class="table table-bordered">
										<thead>
											<tr>
												<th class="cart-romove item">Remove</th>
												<th class="cart-description item">Image</th>
												<th class="cart-product-name item">Product Name</th>


												<th class="cart-qty item">Quantity</th>
												<th class="cart-sub-total item">Price Per unit</th>
												<th class="cart-sub-total item">Shipping Charge</th>
												<th class="cart-total last-item">Grandtotal</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<td colspan="7">
													<div class="shopping-cart-btn">
														<span class="">
															<input type="submit" name="submit" value="Remove Items" class="btn btn-upper btn-primary outer-left-xs">

														</span>
													</div>
												</td>
											</tr>
										</tfoot>
										<tbody>
											<?php
											$pdtid = array();
											$sql = "SELECT * FROM products WHERE id IN(";
											foreach ($_SESSION['cart'] as $id => $value) {
												$sql .= $id . ",";
											}
											$sql = substr($sql, 0, -1) . ") ORDER BY id ASC";
											$query = mysqli_query($con, $sql);
											$totalprice = 0;
											$totalqunty = 0;
											if (!empty($query)) {
												while ($row = mysqli_fetch_array($query)) {
													$quantity = $_SESSION['cart'][$row['id']]['quantity'];
													$subtotal = $_SESSION['cart'][$row['id']]['quantity'] * $row['productPrice'] + $row['shippingCharge'];
													$totalprice += $subtotal;
													$_SESSION['qnty'] = $totalqunty += $quantity;
													array_push($pdtid, $row['id']); ?>
													<tr>
														<td class="romove-item">

															<input type="checkbox" name="remove_code[]" value="<?php echo htmlentities($row['id']); ?>" />

														</td>
														<td class="cart-image">
															<img src="admin/productimages/<?php echo $row['id']; ?>/<?php echo $row['productImage1']; ?>" alt="" width="114" height="146">
														</td>
														<td class="cart-product-name-info">
															<h4 class='cart-product-description'><a href="product-details.php?pid=<?php echo htmlentities($pd = $row['id']); ?>"><?php echo $row['productName'];
																																													$_SESSION['sid'] = $pd; ?></a></h4>
															<div class="row">
																<div class="col-sm-5">
																	<div class="rating rateit-small"></div>
																</div>
																<div class="col-sm-5">
																	<?php $rt = mysqli_query($con, "select * from productreviews where productId='$pd'");
																	$num = mysqli_num_rows($rt); {
																	?>
																		<div class="reviews">
																			( <?php echo htmlentities($num); ?> )
																		</div>
																	<?php } ?>
																</div>
															</div>
														</td>
														<td class="cart-product-quantity">
															<div class="quant-input">
																<div class="arrows">
																	<div class="arrow plus gradient"><span class="ir"><button class="btn1 btn-outline-primary" type="submit" name="submit"><i class="icon fa fa-sort-asc ico1"></i></button></span></div>
																	<div class="arrow minus gradient"><span class="ir"><button class="btn1" type="submit" name="submit"><i class="icon fa fa-sort-desc ico2"></i></button></span></div>
																</div>
																<input type="text" value="<?php echo $_SESSION['cart'][$row['id']]['quantity']; ?>" name="quantity[<?php echo $row['id']; ?>]">
															</div>
														</td>
														<td style="font-size: 18px"><span class="cart-sub-total-price"><?php echo $row['productPrice']; ?>.00 TL</span></td>
														<td style="font-size: 18px"><span class="cart-sub-total-price"><?php echo  $row['shippingCharge']; ?>.00 TL</span></td>
														<td style="font-size: 18px"><span class="cart-grand-total-price"><?php echo ($_SESSION['cart'][$row['id']]['quantity'] * $row['productPrice'] + $row['shippingCharge']); ?>.00TL</span></td>
													</tr>
											<?php }
											}
											$_SESSION['pid'] = $pdtid;
											?>
										</tbody>
									</table>
						</div>
					</div>
					<div class="col-md-4 col-sm-12 estimate-ship-tax">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>
										<span class="estimate-title">Shipping Address</span>
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<div class="form-group">
											<?php
											$query = mysqli_query($con, "select * from users where id='" . $_SESSION['id'] . "'");
											while ($row = mysqli_fetch_array($query)) {
											?>
												<div class="form-group">
													<label class="info-title" for="Billing Address">Billing Address<span>*</span></label>
													<textarea class="form-control unicase-form-control text-input" name="billingaddress" required="required"><?php echo $row['billingAddress']; ?></textarea>
												</div>
												<div class="form-group">
													<label class="info-title" for="Billing State ">Billing State <span>*</span></label>
													<input type="text" class="form-control unicase-form-control text-input" id="bilingstate" name="bilingstate" value="<?php echo $row['billingState']; ?>" required>
												</div>
												<div class="form-group">
													<label class="info-title" for="Billing City">Billing City <span>*</span></label>
													<input type="text" class="form-control unicase-form-control text-input" id="billingcity" name="billingcity" required="required" value="<?php echo $row['billingCity']; ?>">
												</div>
												<div class="form-group">
													<label class="info-title" for="Billing Pincode">Billing Pincode <span>*</span></label>
													<input type="text" class="form-control unicase-form-control text-input" id="billingpincode" name="billingpincode" required="required" value="<?php echo $row['billingPincode']; ?>">
												</div>
												<button type="submit" name="update" class="btn-upper btn btn-primary checkout-page-button">Update</button>
											<?php } ?>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="col-md-4 col-sm-12 estimate-ship-tax">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>
										<span class="estimate-title">Billing Address</span>
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<div class="form-group">
											<?php
											$query = mysqli_query($con, "select * from users where id='" . $_SESSION['id'] . "'");
											while ($row = mysqli_fetch_array($query)) {
											?>
												<div class="form-group">
													<label class="info-title" for="Shipping Address">Shipping Address<span>*</span></label>
													<textarea class="form-control unicase-form-control text-input" name="shippingaddress" required="required"><?php echo $row['shippingAddress']; ?></textarea>
												</div>
												<div class="form-group">
													<label class="info-title" for="Billing State ">Shipping State <span>*</span></label>
													<input type="text" class="form-control unicase-form-control text-input" id="shippingstate" name="shippingstate" value="<?php echo $row['shippingState']; ?>" required>
												</div>
												<div class="form-group">
													<label class="info-title" for="Billing City">Shipping City <span>*</span></label>
													<input type="text" class="form-control unicase-form-control text-input" id="shippingcity" name="shippingcity" required="required" value="<?php echo $row['shippingCity']; ?>">
												</div>
												<div class="form-group">
													<label class="info-title" for="Billing Pincode">Shipping Pincode <span>*</span></label>
													<input type="text" class="form-control unicase-form-control text-input" id="shippingpincode" name="shippingpincode" required="required" value="<?php echo $row['shippingPincode']; ?>">
												</div>
												<button type="submit" name="shipupdate" class="btn-upper btn btn-primary checkout-page-button">Update</button>
											<?php } ?>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="col-md-4 col-sm-12 cart-shopping-total">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>
										<div class="cart-grand-total">
											Grand Total<span class="inner-left-md"><?php echo $_SESSION['tp'] = "$totalprice" . ".00TL"; ?></span>
										</div>
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<div class="cart-checkout-btn pull-right">
											<button type="submit" name="ordersubmit" class="btn btn-primary1">PROCCED TO CHEKOUT</button>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					<?php } else {
									echo "Your shopping Cart is empty";
								} ?>
					</div>
				</div>
			</div>
			</form>
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
		document.addEventListener('DOMContentLoaded', function() {
			const checkboxes = document.querySelectorAll('input[type="checkbox"]');

			checkboxes.forEach(function(checkbox) {
				checkbox.addEventListener('change', function() {
					const checkboxIcon = this.nextElementSibling;

					if (this.checked) {
						checkboxIcon.innerHTML = '<i class="fas fa-check-square" style="color: #000000;"></i>';
					} else {
						checkboxIcon.innerHTML = '<i class="fa-regular fa-square" style="color: #000000;"></i>';
					}
				});
			});
		});

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