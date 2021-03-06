<?php 
ob_start();
session_start();
include realpath(__DIR__.'/../').'/_init.php';

// dd(explode('T', trim("2020-05-02","&quot;Z")));

// Redirect, If user is not logged in
if (!is_loggedin()) {
  redirect(root_url() . '/index.php?redirect_to=' . url());
}

// dd(checkValidationServerConnection());
// dd(!checkValidationServerConnection() || !checkEnvatoServerConnection());

// Set Document Title
$document->setTitle(trans('title_dashboard'));

// Add Script
$document->addScript('../assets/itsolution24/angular/controllers/DashboardController.js');
$document->addScript('../assets/itsolution24/angular/controllers/ReportCollectionController.js');
$document->addScript('../assets/itsolution24/angular/modals/QuotationViewModal.js');

// ADD BODY CLASS
$document->setBodyClass('dashboard'); 
$banking_model = registry()->get('loader')->model('banking');

// Include Header and Footer
include ("header.php");
include ("left_sidebar.php");
?>

<!-- Content Wrapper Start -->
<div class="content-wrapper" ng-controller="DashboardController">

  <!-- Content Header Start -->
  <section class="content-header">
    <?php include ("../_inc/template/partials/apply_filter.php"); ?>
    <h1>
      <?php echo trans('text_dashboard'); ?>
      <small>
        <?php echo store('name'); ?>
      </small>
    </h1>
  </section>
  <!-- ContentH eader End -->

  <!-- Content Start -->
  <section class="content">

    <?php if(DEMO || settings('is_update_available')) : ?>
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-body">
            <?php if (settings('is_update_available')) : ?>
            <div class="alert alert-warning mb-0">
              <p><span class="fa fa-fw fa-info-circle"></span> Version <span class="label label-info"><?php echo settings('update_version');?></span> is available now. <a href="<?php echo settings('update_link');?>" target="_blink">Read changelog & update instructions here</a></p>
            </div>
            <?php endif; ?>
            <?php if (DEMO) : ?>
            <div class="alert alert-info mb-0">
              <p><span class="fa fa-fw fa-info-circle"></span> <?php echo $demo_text; ?></p>
            </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>

    
    
    <!-- Small Boxes Start -->
    <div class="row">
      <div class="col-md-3 col-xs-6">
        <div id="invoice-count" class="small-box bg-green">
          <div class="inner">
            <h4>
              <i><?php echo trans('text_total_invoice'); ?></i> <span class="total-invoice"><?php echo number_format(total_invoice(from(), to())); ?></span>
            </h4>
            <h4>
              <i><?php echo trans('text_total_invoice_today'); ?></i> <span class="total-invoice"><?php echo number_format(total_invoice_today()); ?></span>
            </h4>
          </div>
          <div class="icon">
            <i class="fa fa-pencil"></i>
          </div>
          <?php if (user_group_id() == 1 || has_permission('access', 'read_customer')) : ?>
            <a href="invoice.php" class="small-box-footer">
              <?php echo trans('text_details'); ?> 
              <i class="fa fa-arrow-circle-right"></i>
            </a>
          <?php else:?>
            <a href="#" class="small-box-footer">
              &nbsp;
            </a>
          <?php endif;?>
        </div>
      </div>
      <div class="col-md-3 col-xs-6">
        <div id="customer-count" class="small-box bg-red">
          <div class="inner">
            <h4>
              <i><?php echo trans('text_total_customer'); ?></i> <span class="total-customer"><?php echo number_format(total_customer(from(), to())); ?></span>
            </h4>
            <h4>
              <i><?php echo trans('text_total_customer_today'); ?></i> <span class="total-customer"><?php echo number_format(total_customer_today()); ?></span>
            </h4>
          </div>
          <div class="icon">
            <i class="fa fa-users"></i>
          </div>
          <?php if (user_group_id() == 1 || has_permission('access', 'read_customer')) : ?>
            <a href="customer.php" class="small-box-footer">
              <?php echo trans('text_details'); ?> 
              <i class="fa fa-arrow-circle-right"></i>
            </a>
          <?php else:?>
            <a href="#" class="small-box-footer">
              &nbsp;
            </a>
          <?php endif;?>
        </div>
      </div>
      <div class="col-md-3 col-xs-6">
        <div id="supplier-count" class="small-box bg-purple">
          <div class="inner">
            <h4>
              <i><?php echo trans('text_total_supplier'); ?></i> <span class="total-suppier"><?php echo total_supplier(from(), to()); ?></span>
            </h4>
            <h4>
              <i><?php echo trans('text_total_supplier_today'); ?></i> <span class="total-suppier"><?php echo total_supplier_today(); ?></span>
            </h4>
          </div>
          <div class="icon">
            <i class="fa fa-fw fa-shopping-cart"></i>
          </div>
          <?php if (user_group_id() == 1 || has_permission('access', 'read_supplier')) : ?>
            <a href="supplier.php" class="small-box-footer">
              <?php echo trans('text_details'); ?> 
              <i class="fa fa-arrow-circle-right"></i>
            </a>
          <?php else:?>
            <a href="#" class="small-box-footer">
              &nbsp;
            </a>
          <?php endif;?>
        </div>
      </div>
      <div class="col-md-3 col-xs-6">
        <div id="product-count" class="small-box bg-yellow">
          <div class="inner">
            <h4>
              <i><?php echo trans('text_total_product'); ?></i> <span class="total-product"><?php echo number_format(total_product(from(), to())); ?></span>
            </h4>
            <h4>
              <i><?php echo trans('text_total_product_today'); ?></i> <span class="total-product"><?php echo number_format(total_product_today()); ?></span>
            </h4>
          </div>
          <div class="icon">
            <i class="fa fa-star"></i>
          </div>
          <?php if (user_group_id() == 1 || has_permission('access', 'read_product')) : ?>
            <a href="product.php" class="small-box-footer">
              <?php echo trans('text_details'); ?> 
              <i class="fa fa-arrow-circle-right"></i>
            </a>
          <?php else:?>
            <a href="#" class="small-box-footer">
              &nbsp;
            </a>
          <?php endif;?>
        </div>
      </div>
    </div>
    <!--Small Box End -->
	<div class="hidden-xs action-button-sm">
    <?php include '../_inc/template/partials/action_buttons.php'; ?>
    </div>


    <?php if (user_group_id() == 1 || has_permission('access', 'read_recent_activities')) : ?>
    <?php if (user_group_id() == 1 || has_permission('access', 'read_sell_list') || has_permission('access', 'read_quotation') || has_permission('access', 'read_purchase_list') || has_permission('access', 'read_transfer') || has_permission('access', 'read_customer') || has_permission('access', 'read_supplier')):?>
    <div class="row">
      <div class="col-md-12">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title"><?php echo trans('text_recent_activities'); ?></h3>
          </div>
          <div class="box-body">
            <?php include('../_inc/template/partials/recent_activities.php'); ?>
          </div>
        </div>
      </div>
    </div> 
    <?php endif;?>
    <?php endif;?>



    <hr>

    <?php if (user_group_id() == 1 || has_permission('access', 'read_income_and_expense_report')) : ?>
      <div class="row">
        <div class="col-md-12 tour-item">
          <?php include ROOT.'/_inc/template/partials/income_expense_graph.php'; ?>
        </div>
      </div>
    <?php endif; ?>
  </section>
  <!-- Content End -->

</div>
<!-- Content Wrapper End -->
    
<?php include ("footer.php"); ?>