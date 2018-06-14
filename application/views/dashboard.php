<?php $this->load->view('header') ?>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/highcharts-more.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
<script src="http://code.highcharts.com/modules/export-data.js"></script>
<script src="<?php echo base_url();?>assets/js/dashboard.js"></script>
  <div class="navbar">
    <div class="navbar-inner">
      <div class="container-fluid">
        <a class="brand" href="#" name="top">BIACM Data Aggregation</a>
          <ul class="nav">
            <li class="active"><a href="<?php echo base_url()."index.php/dashboard/show_dashboard";?>"><i class="icon-home"></i> Dashboard</a></li>
            <li class="divider-vertical"></li>
            <li><a href="<?php echo base_url()."index.php/imports/show_upload";?>"><i class="icon-download"></i> Import Wizard</a></li>
            <li class="divider-vertical"></li>
            <li>
              <a href="<?php echo base_url()."index.php/users";?>" style="padding:10px;">
                <i class="icon-user"></i> Users
              </a>
            </li>
            <li class="divider-vertical"></li>
          </ul>
          <div class="btn-group pull-right">
              <a class="btn" href="<?php echo base_url() ?>/index.php/login/logout_user"><i class="icon-share"></i> Logout</a>
          </div>
      </div>
      <!--/.container-fluid -->
    </div>
    <!--/.navbar-inner -->
  </div>
  <!--/.navbar -->

  <div id="container" style="min-width: 310px; max-width: 400px; height: 300px; margin: 0 auto">
    
  </div>
<?php $this->load->view('footer') ?>