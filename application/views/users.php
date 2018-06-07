
<?php $this->load->view('header') ?>
<script src="<?php echo base_url();?>assets/js/script.js"></script>
  <div class="navbar">
    <div class="navbar-inner">
      <div class="container-fluid">
        <a class="brand" href="#" name="top">BIACM Data Aggregation</a>
          <ul class="nav">
            <li><a href="../dashboard/show_dashboard"><i class="icon-home"></i> Dashboard</a></li>
            <li class="divider-vertical"></li>
            <li class="active"><a href="../imports/show_upload"><i class="icon-home"></i> Import Wizard</a></li>
            <li class="divider-vertical"></li>
            <li>
              <a href="#" style="padding:10px;">
                <i class="icon-user"></i> Users
              </a>
            </li>
            <li class="divider-vertical"></li>
          </ul>
          <div class="btn-group pull-right">
            <?php if ($is_admin) : ?>
            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
              <i class="icon-wrench"></i> admin	<span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li><a data-toggle="modal" href="#myModal"><i class="icon-user"></i> New User</a></li>
              <li class="divider"></li>
              <li><a href="<?php echo base_url() ?>/index.php/login/logout_user"><i class="icon-share"></i> Logout</a></li>
            </ul>
            <?php else : ?>
              <a class="btn" href="<?php echo base_url() ?>/index.php/login/logout_user"><i class="icon-share"></i> Logout</a>
            <?php endif; ?>
          </div>
      </div>
      <!--/.container-fluid -->
    </div>
    <!--/.navbar-inner -->
  </div>
  <!--/.navbar -->

  <div class="container">
    <div class="stepwizard">
        <div class="stepwizard-row">
            <div class="stepwizard-step">
                <button type="button" class="btn btn-primary btn-circle">1</button>
                <p>Upload File</p>
            </div>
            <div class="stepwizard-step">
                <button type="button" class="btn btn-disabled btn-circle">2</button>
                <p>Validation</p>
            </div>
            <div class="stepwizard-step">
                <button type="button" class="btn btn-disabled btn-circle" disabled="disabled">3</button>
                <p>Import</p>
            </div> 
        </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <small>
          Upload Attachments
        </small>
      </div>
      <div class="panel-body">

        <!-- Standar Form -->
        <h4>Please upload the files</h4>
        <form action="" method="post" enctype="multipart/form-data" id="js-upload-form">
          <div class="form-inline">
            <div class="form-group">
              <input type="file" name="files[]" id="js-upload-files" multiple>
            </div>
            <button type="submit" class="btn btn-sm btn-primary" id="js-upload-submit">Upload files</button>
          </div>
        </form>
      </div>
    </div>
  </div>

    
<?php $this->load->view('footer') ?>