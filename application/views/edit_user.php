<?php $this->load->view('header') ?>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/highcharts-more.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
<script src="http://code.highcharts.com/modules/export-data.js"></script>
<script src="<?php echo base_url();?>assets/js/dashboard.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/cma.css">
  <div class="navbar">
    <div class="navbar-inner">
      <div class="container-fluid">
        <a class="brand" href="#" name="top">BIACM Data Aggregation</a>
          <ul class="nav">
            <li><a href="<?php echo base_url()."index.php/dashboard/show_dashboard";?>"><i class="icon-home"></i> Dashboard</a></li>
            <li class="divider-vertical"></li>
            <li><a href="<?php echo base_url()."index.php/imports/show_upload";?>"><i class="icon-download"></i> Import Wizard</a></li>
            <li class="divider-vertical"></li>
            <li class="active">
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

  <div class="container">
    <div class="alert alert-danger alert-normal-danger" hidden="hidden" style="display: block;">
        <button type="button" class="close">×</button>
      I'm a normal danger message. To close use  the appropriate button.
    </div>
    <div class="area">
      <form action="create_new_user" class="form-horizontal" method="POST">
          <div class="heading">
              <h4 class="form-heading">Edit user </h4>
          </div>

          <div class="control-group">
              <label class="control-label" for="inputFirst">First
              Name</label>

              <div class="controls">
                  <input id="inputFirst" placeholder=
                  "E.g. Ashwin" name="firstName" type="text" value="<?php echo $user->firstName; ?>">
              </div>
          </div>

          <div class="control-group">
              <label class="control-label" for="inputLast">Last
              Name</label>

              <div class="controls">
                  <input id="inputLast" name="lastName" placeholder="E.g. Hegde"
                  type="text" value="<?php echo $user->lastName; ?>">
              </div>
          </div>

          <div class="control-group">
              <label class="control-label" for=
              "inputEmail">Email</label>

              <div class="controls">
                  <input id="inputEmail" name="email" placeholder=
                  "E.g. ashwinh@cybage.com" type="text" value="<?php echo $user->email; ?>">
              </div>
          </div>

          <div class="control-group">
              <label class="control-label" for=
              "inputPassword">Password</label>

              <div class="controls">
                  <input id="inputPassword"  name="password" placeholder=
                  "Min. 8 Characters" type="password" value="<?php echo $user->password; ?>">
              </div>
          </div>

          <div class="control-group">
              <label class="control-label" for=
              "inputPassword">Password confirmation</label>

              <div class="controls">
                  <input id="inputPassword" name="passwordConfirmation" placeholder=
                  "Min. 8 Characters" type="password" value="<?php echo $user->password; ?>">
              </div>
          </div>

          <div class="control-group">
            <label class="control-label" for=
              "inputPassword">Is admin ?</label>

              <div class="controls">
                <?php if ($user->isAdmin) {?>
                  <input type="checkbox" checked="checked"  name="isAdmin">
                <?php}
                else{ ?>
                  <input type="checkbox" name="isAdmin">
                <?php } ?>
              </div>
          </div>

          <div class="control-group">
              <div class="controls">
                  <button class="btn btn-success" type="submit">
                    Update
                  </button>
              </div>
          </div>
      </form>
    </div>
  </div>    
<?php $this->load->view('footer') ?>