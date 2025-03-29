<?php
session_start();
error_reporting(0);
if (isset($_GET['action'])) {
	if (!empty($_SESSION['cart'])) {
		foreach ($_POST['quantity'] as $key => $val) {
			if ($val == 0) {
				unset($_SESSION['cart'][$key]);
			} else {
				$_SESSION['cart'][$key]['quantity'] = $val;
			}
		}
	}
}
?>
<div class="main-header">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-3 logo-holder">
				<div class="logo">
					<a href="index.php">
						<h2>InfiniteStride </h2>
					</a>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-6 top-search-holder">
				<form name="search" method="post" action="search-result.php">
					<div class="search-box">
						<button type="submit" class="btn-search">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search" width="16" height="16">
								<circle cx="11" cy="11" r="8" />
								<line x1="21" y1="21" x2="16.65" y2="16.65" />
							</svg>
						</button>
						<input type="text" class="input-search" name="product" placeholder="Type to Search...">
					</div><!-- /.search-box -->
				</form>



			</div><!-- /.top-search-holder -->
			<div class="col-xs-12 col-sm-12 col-md-3 animate-dropdown top-cart-row">
				<?php
				// Check if the user is logged in
				if (strlen($_SESSION['login']) > 0) {
					// User is logged in
					if (!empty($_SESSION['cart'])) {
				?>
						<div class="dropdown dropdown-cart">
							<a href="#" class="dropdown-toggle lnk-cart" data-toggle="dropdown">
								<div class="items-cart-inner">
									<div class="total-price-basket">
										<span class="lbl">cart -</span>
										<span class="total-price">
											<span class="value"><?php echo number_format($_SESSION['tp'], 2); ?></span>
											<span class="sign">TL</span>
										</span>
									</div>
									<div class="basket">
										<i class="glyphicon glyphicon-shopping-cart"></i>
									</div>
									<div class="basket-item-count"><span class="count"><?php echo $_SESSION['qnty']; ?></span></div>
								</div>
							</a>
							<ul class="dropdown-menu">
								<?php
								
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
								?>
										<li>
											<div class="cart-item product-summary">
												<div class="row">
													<div class="col-xs-4">
														<div class="image">
															<a href="product-details.php?pid=<?php echo $row['id']; ?>"><img src="admin/productimages/<?php echo $row['id']; ?>/<?php echo $row['productImage1']; ?>" width="35" height="50" alt=""></a>
														</div>
													</div>
													<div class="col-xs-7">
														<h3 class="name"><a href="product-details.php?pid=<?php echo $row['id']; ?>"><?php echo $row['productName']; ?></a>
														</h3>
														<div class="price"><?php echo ($row['productPrice'] + $row['shippingCharge']); ?>*<?php echo $_SESSION['cart'][$row['id']]['quantity']; ?>
														</div>
													</div>
												</div>
											</div><!-- /.cart-item -->
									<?php }
								} ?>
									<div class="clearfix"></div>
									<hr>
									<div class="clearfix cart-total">
										<div class="pull-right">
											<span class="text">Total :</span><span class='price'><?php echo number_format($totalprice, 2); ?></span>
											<?php $_SESSION['tp'] = $totalprice; ?>
										</div>
										<div class="clearfix"></div>
										<a href="my-cart.php" class="btn btn-upper btn-primary btn-block m-t-20">My Cart</a>
									</div><!-- /.cart-total-->
										</li>
							</ul><!-- /.dropdown-menu-->
						</div><!-- /.dropdown-cart -->
					<?php } else { ?>
						<div class="dropdown dropdown-cart">
							<a href="#" class="dropdown-toggle lnk-cart" data-toggle="dropdown">
								<div class="items-cart-inner">
									<div class="total-price-basket">
										<span class="lbl">cart -</span>
										<span class="total-price">
											<span class="value">00.00</span>
										</span>
									</div>
									<div class="basket">
										<i class="glyphicon glyphicon-shopping-cart"></i>
									</div>
									<div class="basket-item-count"><span class="count">0</span></div>
								</div>
							</a>
							<ul class="dropdown-menu">
								<li>
									<div class="cart-item product-summary">
										<div class="row">
											<div class="col-xs-12">
												Your Shopping Cart is Empty.
											</div>
										</div>
									</div><!-- /.cart-item -->
									<hr>
									<div class="clearfix cart-total">
										<div class="clearfix"></div>
										<a href="index.php" class="btn btn-upper btn-primary btn-block m-t-20">Continue Shooping</a>
									</div><!-- /.cart-total-->
								</li>
							</ul><!-- /.dropdown-menu-->
						</div>
				<?php }
				}
				?>
			</div><!-- /.top-cart-row -->
		</div><!-- /.row -->
	</div><!-- /.container -->
</div>