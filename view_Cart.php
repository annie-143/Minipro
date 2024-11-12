<?php
session_start(); // Start the session
include('db_con.php'); // Include the database connection
error_reporting(E_ERROR | E_PARSE);

// Check if the user is logged in
if (!isset($_SESSION['usr'])) {
    echo '<script>location.replace("index.php");</script>'; // Redirect to login page
    exit();
}

// Get the user ID from the session
$user_id = $_SESSION['usr'];

// Query to fetch items from the cart for the logged-in user
$cart_sql = "SELECT product_id FROM cart WHERE user_id = '$user_id'";
$cart_result = $connection->query($cart_sql);

// Check if the user has items in the cart
if ($cart_result->num_rows > 0) {
    // Fetch product IDs from the cart
    $product_ids = [];
    while ($row = $cart_result->fetch_assoc()) {
        $product_ids[] = $row['product_id'];
    }

    // Convert product IDs array to a comma-separated string for the SQL query
    $product_ids_str = implode(",", $product_ids);

    // Query to fetch product details from the product table
    $sql = "SELECT id, image, name, price, description, category FROM product WHERE id IN ($product_ids_str)";
    $product_result = $connection->query($sql);

    
}

// Close the database connection
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>PetConnect | View Products</title>
  <meta content="View, update, and delete products in PetConnect's inventory." name="description">
  <meta content="PetConnect, Admin, View Products, Dashboard" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">PetConnect </span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <!-- Existing Header Content (Search Bar, Notifications, Messages, Profile) -->

  </header><!-- End Header -->

   <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

  <li class="nav-item">
    <a class="nav-link " href="../home/index.php">
      <i class="bi bi-grid"></i>
      <span>HOME</span>
    </a>
  </li><!-- End Dashboard Nav -->

  <li class="nav-item">
    <a class="nav-link " href="index.php">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="View_order.php">
      <i class="bi bi-menu-button-wide"></i><span>ORDERS</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="components-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
      <li>
        <a href="view_order.php">
          <i class="bi bi-circle"></i><span>MY ORDERS</span>
        </a>
      </li>
      <li>
        <a href="view_Cart.php">
          <i class="bi bi-circle"></i><span>CART</span>
        </a>
      </li>
    </ul>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#missing-pets-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-menu-button-wide"></i><span>MISSING PETS</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="missing-pets-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
      <li>
        <a href="add_missPet.php">
          <i class="bi bi-circle"></i><span>ADD MISSING PETS</span>
        </a>
      </li>
      <li>
        <a href="view_missing.php">
          <i class="bi bi-circle"></i><span>VIEW MISSING POST</span>
        </a>
      </li>
    </ul>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#adoption-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-menu-button-wide"></i><span>ADOPTION</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="adoption-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
      <li>
        <a href="add_adopt.php">
          <i class="bi bi-circle"></i><span>ADD ADOPTION</span>
        </a>
      </li>
      <li>
        <a href="view_adopt.php">
          <i class="bi bi-circle"></i><span>VIEW ADOPTIONS</span>
        </a>
      </li>
    </ul>
  </li>
</ul>

</aside><!-- End Sidebar -->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>View Cart</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Orders</li>
          <li class="breadcrumb-item active">View Cart</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">CART</h5>

              <!-- Products Table -->
              <table class="table table-striped ">
                <thead>
                  <tr>
                  
                    <th scope="col">Product Image</th>
                    <th scope="col">Name</th>
                    <th scope="col">Category</th>
                    <th scope="col">Price ($)</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if ($product_result->num_rows > 0) {
                      while ($product = $product_result->fetch_assoc()) {
                          echo '<tr>';
                        
                          echo '    <td><img src="../admin/uploads/product/' . htmlspecialchars($product["image"]) . '" alt="' . htmlspecialchars($product["name"]) . '" class="img-thumbnail" style="width: 100px;"></td>';
                          echo '    <td>' . htmlspecialchars($product["name"]) . '</td>';
                          echo '    <td>' . htmlspecialchars($product["category"]) . '</td>';
                          echo '    <td>$' . htmlspecialchars(number_format($product["price"], 2)) . '</td>';
                          echo '    <td>' . htmlspecialchars($product["description"]) . '</td>';
                          echo '  <td>                                  
                                    <form action="../home/detail_product.php" method="POST">
                                      <button type="submit"  name="id" class="btn btn-sm btn-success" value="' . htmlspecialchars($product['id']) . '"><i class="bi bi-pencil-square"></i> CHECKOUT</button>
                                    </form> 
                                    <form action="del_cart.php" method="POST">
                                       <button type="submit"   name="id" class="btn btn-sm btn-danger" value="' . htmlspecialchars($product['id']) . '"><i class="bi bi-trash"></i>REMOVE</button>
                                    </form> 

                                  </td>'; 

                          echo '</tr>';
                      }
                  } else {
                      echo '<tr><td colspan="6" class="text-center">Your Cart is Empty</td></tr>';
                  }
             
            
                  ?>
                </tbody>
              </table>

            </div>
          </div>

        </div>
      </div>
    </section>

  </main>

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>PetConnect</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      Designed by <a href="">PetConnect</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>




