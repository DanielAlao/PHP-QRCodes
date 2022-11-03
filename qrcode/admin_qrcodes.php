<?php

session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

// Dynamic qrcode class
require_once BASE_PATH . '/lib/Dynamic_Qrcode/Dynamic_Qrcode.php';
$dynamic_qrcode = new Dynamic_Qrcode();

// Get DB instance. i.e instance of MYSQLiDB Library
$db = getDbInstance();
$select = $db->get("dynamic_qrcodes","filename","link","qrcode","scan","created_at","created_by_user");

// Search and order php code
$search_fields = array('filename', 'identifier', 'link');
require_once BASE_PATH . '/includes/search_order.php';

// Get current page
$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? 1;

// Set pagination limit
$db->pageLimit = 15;

// Get result of the query
$rows = $db->arraybuilder()->paginate('dynamic_qrcodes', $page,$select);
$rows2 = $db->arraybuilder()->paginate('static_qrcodes', $page, $select);
$total_pages = $db->totalPages;
?>


<!DOCTYPE html>
<html lang="en">
    <title>List dynamic - Qrcode Generator</title>
    <head>
    <?php include './includes/head.php'; ?>
    </head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <?php include './includes/navbar.php'; ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include './includes/sidebar.php'; ?>
    <!-- /.Main Sidebar Container -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
            
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">User Qr codes</h1>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div><!-- /.content-header -->
    
    <!-- Flash message-->
    <?php include BASE_PATH . '/includes/flash_messages.php'; ?>
    <!-- /.Flash message-->
            
    <!-- Filters -->
    <?php $options = $dynamic_qrcode->setOrderingValues();
          include BASE_PATH . '/forms/filters.php'; ?>  
    <!-- /.Filters-->
    
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
          
        <!-- Table -->
        <?php include BASE_PATH . '/admin_all_users_qrcodes.php'; ?>  
        <!-- /.Table -->
    
        </div><!-- /.container-fluid -->
    </section>
  </div><!-- /.content-wrapper -->

    <!-- Footer and scripts -->
    <?php include './includes/footer.php'; ?>
    <!-- /.Footer and scripts -->
</body>
</html>
