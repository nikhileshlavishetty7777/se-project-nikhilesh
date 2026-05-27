<?php
include('../Customer/config/constants.php');
// include('login-check.php');

// Function to check database query results
function checkQuery($result, $queryName) {
    if (!$result) {
        die("Error in $queryName query: " . mysqli_error($GLOBALS['conn']));
    }
}

// Sales by Hour Query
$sales_by_hour = "SELECT HOUR(payment_time) AS hname, SUM(amount) AS total_sales
                  FROM phonepe
                  GROUP BY HOUR(payment_time)";
$res_sales_by_hour = mysqli_query($conn, $sales_by_hour);
checkQuery($res_sales_by_hour, 'sales_by_hour');

// Most Sold Items Query
$most_sold_items = "SELECT SUM(Quantity) AS total_qty, Item_Name AS item_name
                    FROM online_orders_new
                    GROUP BY Item_Name";
$res_most_sold_items = mysqli_query($conn, $most_sold_items);
checkQuery($res_most_sold_items, 'most_sold_items');

// Notification Queries
$ei_order_notif = "SELECT order_status from tbl_eipay WHERE order_status='Pending' OR order_status='Processing'";
$res_ei_order_notif = mysqli_query($conn, $ei_order_notif);
$row_ei_order_notif = mysqli_num_rows($res_ei_order_notif);

$online_order_notif = "SELECT order_status from order_manager WHERE order_status='Pending' OR order_status='Processing'";
$res_online_order_notif = mysqli_query($conn, $online_order_notif);
$row_online_order_notif = mysqli_num_rows($res_online_order_notif);

// Stock Notification
$stock_notif = "SELECT stock FROM tbl_food WHERE stock < 50";
$res_stock_notif = mysqli_query($conn, $stock_notif);
$row_stock_notif = mysqli_num_rows($res_stock_notif);

// Revenue and Orders Delivered
$revenue = "SELECT SUM(total_amount) AS total_amount FROM order_manager WHERE order_status='Delivered'";
$res_revenue = mysqli_query($conn, $revenue);
$total_revenue = mysqli_fetch_array($res_revenue);

$orders_delivered = "SELECT order_status FROM order_manager WHERE order_status='Delivered'";
$res_orders_delivered = mysqli_query($conn, $orders_delivered);
$total_orders_delivered = mysqli_num_rows($res_orders_delivered);

// Message Notification
$message_notif = "SELECT message_status FROM message WHERE message_status = 'unread'";
$res_message_notif = mysqli_query($conn, $message_notif);
$row_message_notif = mysqli_num_rows($res_message_notif);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="style-admin.css">
	<link rel="icon" 
      type="image/png" 
      href="../images/logo.png">

	<!-- Chart ---> 
		
	
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
	
        var data = google.visualization.arrayToDataTable([
          ['Item Name', 'Sales'], 
          <?php
		  while($row_sales=mysqli_fetch_array($res_most_sold_items))
		  {
			  echo "['".$row_sales["item_name"]."', ".$row_sales["total_qty"]."],";
		  }
		  ?>
          ]);
		   
        var options = {
          title: 'Most Sold Items',
          pieHole: 0.4,
		  fontName: 'Poppins',
		  fontSize: 12,
		  //is3D:true,
		  titleTextStyle: { color: "Grey",
  							fontName: "Poppins",
  							fontSize: 16,
  							bold: false,
  							italic: false },
		
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart_msi'));
        chart.draw(data, options);	
      }
	  
    </script>

	<!-- Chart End --> 

	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Time' , 'Sales'],
		   <?php
		  while($row_sales_by_hour=mysqli_fetch_array($res_sales_by_hour))
		  {
			  echo "['".$row_sales_by_hour["hname"]."', ".$row_sales_by_hour["total_sales"]."],";
		  }

		  ?>
		
          
        ]);

        var options = 
		{
			hAxis: 
			{
				title: 'Time', titleTextStyle:
				{
					color: 'Black'
				}
			},
      		colors: ['#eb2f06','green'],
			
            chart: 
			{
            title: 'Sales By Hour',
           } 
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
	

	<title>Superworls Cafe Admin</title>
</head>
<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<img src="..\images\logo2.png" width="120px" alt="">
			
		</a>
		<ul class="side-menu top">
			<li class="active">
				<a href="#">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="manage-admin.php">
					<i class='bx bxs-group' ></i>
					<span class="text">Admin Panel</span>
				</a>
			</li>
			<li>
				<a href="manage-online-order.php">
					<i class='bx bxs-cart'></i>
					<span class="text">Online Orders &nbsp;</span>
						<?php 
					if($row_online_order_notif>0)
					{
						?>
						<span class="num-ei"><?php echo $row_online_order_notif; ?></span>
						<?php
					}
					else
					{
						?>
						<span class=""> </span>
						<?php
					}
					?>
				</a>
			</li>
			<li>
				<a href="manage-ei-order.php">
					<i class='bx bx-qr-scan'></i>
					<span class="text" >Eat In Orders &nbsp;&nbsp;&nbsp;
						
					</span>
					
					<?php 
					if($row_ei_order_notif>0)
					{
						?>
						<span class="num-ei"><?php echo $row_ei_order_notif; ?></span>
						<?php
					}
					else
					{
						?>
						<span class=""> </span>
						<?php
					}
					?>
					
				</a>
			</li>
			<li>
				<a href="manage-category.php">
					<i class='bx bxs-category'></i>
					<span class="text">Category</span>
				</a>
			</li>
			<li>
				<a href="manage-food.php">
					<i class='bx bxs-food-menu'></i>
					<span class="text">Food Menu</span>
				</a>
			</li>
			<li class="">
				<a href="inventory.php">
					<i class='bx bxs-box'></i>
					<span class="text">Inventory</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
		<!-- index.php or dashboard.php -->
<li>
				<a href="Profile Setting.php">
					<i class='bx bxs-cog' ></i>
					<span class="text">Profile Setting</span>
				</a>
			</li>

			<li>
				<a href="logout.php" class="logout">
					<i class='bx bxs-log-out-circle' ></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->
	
	 <!-- Dynamic Dashborad --> 

            <?php
            //Categories

            $sql = "SELECT * FROM tbl_category";

            $res = mysqli_query($conn, $sql);

            $row_cat = mysqli_num_rows($res);
            
            //Items

            $sql2 = "SELECT * FROM tbl_food";

            $res2 = mysqli_query($conn, $sql2);

            $row_item = mysqli_num_rows($res2);

            //Orders

            $sql3 = "SELECT * FROM order_manager";

            $res3 = mysqli_query($conn, $sql3);

            $row_order = mysqli_num_rows($res3);

			//Eat In Orders


	  		$sql4 = "SELECT * FROM tbl_eipay";

            $res4 = mysqli_query($conn, $sql4);

            $row_ei_order = mysqli_num_rows($res4);

        ?>


	<!-- Dynamic DashBoard --> 


	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu' ></i>
			<a href="#" class="nav-link"></a>
			<form action="#">
				<div class="form-input">
					<input type="search" placeholder="Search...">
					<button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
				</div>
			</form>
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
			<div class="fetch_message">
				<div class="action_message notfi_message">
					<a href="messages.php"><i class='bx bxs-envelope'></i></a>
					<?php 

					if($row_message_notif>0)
					{
						?>
						<span class="num"><?php echo $row_message_notif; ?></span>
						<?php
					}
					else
					{
						?>
						<span class=""></span>
						<?php

					}
					?>
					
				</div>
					
			</div>
			
			<div class="notification" onclick= "menuToggle();">
				<div class="action notif " onclick= "menuToggle();">
				<i class='bx bxs-bell ' onclick= "menuToggle();"></i>
				<div class="notif_menu">
				<ul><?php 
							
							if($row_stock_notif>0 and $row_stock_notif !=1 )
							{
								?>
								<li><a href="inventory.php"><?php echo $row_stock_notif ?>&nbsp;Items are running out of stock</li></a>
								<?php
							}
							else if($row_stock_notif == 1)
							{
								?>
								<li><a href="inventory.php"><?php echo $row_stock_notif ?>&nbsp;Item is running out of stock</li></a>
								<?php
							}
							else
							{
								
							}
							if($row_ei_order_notif>0)
							{
								?>
								<li><a href="manage-online-order.php"><?php echo $row_online_order_notif ?>&nbsp;New Online Order</li></a>
								<?php

							}
							if($row_online_order_notif>0)
							{
								?>
								<li><a href="manage-ei-order.php"><?php echo $row_ei_order_notif ?>&nbsp;New Eat In Order</li></a>
								<?php

							}
							?>
						
					</ul>
				</div>
				<?php 
				if($row_stock_notif>0 || $row_online_order_notif>0 || $row_ei_order_notif>0)
				{
					$total_notif = $row_online_order_notif+$row_ei_order_notif+$row_stock_notif;
					?>
					
					<span class="num"><?php echo $total_notif; ?></span>
					<?php
				}
				else
				{
					?>
					<span class=""></span>
					<?php
				}
				?>
			</a>
			</div>
			</div>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
		

<div class="cards-list">
  
<div class="card-stock">
  <a href="inventory.php"><div class="card_image"> <img src="../images/inventory.png" /> </div></a>
  <div class="card_title title-white">
	  <p></p>
    <p>Inventory</p>
  </div>
</div>

  <div class="card-stock2">
  <div class="card_image">
    <a href=""><img src="../images/revenue.png" /></a>
    </div>
  <div class="card_title title-white">
	  <p>৳<?=$total_revenue['total_amount']?></p>
    <p>Revenue Generated</p>
  </div>
</div>

<div class="card-stock3">
  <div class="card_image">
    <a href=""><img src="../images/orders_completed.png" /></a>
  </div>
  <div class="card_title title-white">
	  <p><?php echo $total_orders_delivered; ?></p>
    <p>Orders Completed</p>
  </div>
</div>
  
  <div class="card-stock4">
  <div class="card_image">
    <a href=""><img src="../images/folder2.png" /></a>
    </div>
  <div class="card_title title-white">
	  <p><?php echo $row_item; ?></p>
    <p>Menu Items</p>
  </div>
  </div>

</div>


<!-- Chart --> 
		
<br>
		<ul class="box-info">
				<li>
					<div class ="chart" id="donutchart_msi" style="width: 650px; height: 320px;"></div>
				</li>
				<li>
					<div class ="chart" id="columnchart_material" style="width: 650px; height: 320px;"></div>	
				</li>
			</ul>

<!-- Chart End ---> 


</main>

<!-- MAIN -->
</section>
<!-- CONTENT -->
<script src="script-admin.js"></script>

</body>
</html>