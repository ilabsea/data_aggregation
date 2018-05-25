<?php $this->load->view('header') ?>
  <div class="navbar">
    <div class="navbar-inner">
      <div class="container-fluid">
        <a class="brand" href="#" name="top">BIACM Data Aggregation</a>
          <ul class="nav">
            <li><a href="#"><i class="icon-home"></i> Dashboard</a></li>
            <li class="divider-vertical"></li>
            <li><a href="#"><i class="icon-home"></i> Import Wizard</a></li>
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
                <a class="brand" href="../show_main" name="top">
                  <button type="button" class="btn btn-disabled btn-circle">1</button>
                  <p>Upload File</p>
                </a>
            </div>
            <div class="stepwizard-step">
                <button type="button" class="btn btn-primary btn-circle">2</button>
                <p>Validation</p>
            </div>
            <div class="stepwizard-step">
                <button type="button" class="btn btn-disabled btn-circle" disabled="disabled">3</button>
                <p>Import</p>
            </div> 
        </div>
    </div>
    <?php $excluded_case_ids = array(); ?>
    <?php if(count($response) > 0){ ?>
      * There are some validation errors that block the application todo import. Please fix the following error and reupload again to do import.
      <br /><br />
      <div class="row">
        <div class="col-md-12">
            <ol class="tree-structure">
              <?php 
                $i = 1;    
              ?>
              <?php foreach ($response as $case_id => $list) { ?>
                <li>
                  <span class="num">1</span>
                  <?php 
                    array_push($excluded_case_ids, $case_id);
                  ?>
                  <a href="#"> Case ID <?php echo $case_id; ?> </a>
                  <ol>
                    <?php $j = 1; ?>
                    <?php foreach ($list as $key => $value) { ?>
                      <li>
                        <span class="num"><?php echo (string)$i.".".(string)$j; ?></span>
                        <a href="#"><?php echo $value; ?></a>
                        <?php $j = $j + 1; ?>
                      </li>
                    <?php } ?>
                    <?php $i = $i + 1; ?>
                  </ol>
                </li>
              <?php } ?>
            </ol>
        </div>
      </div>
    <?php 
    }
    else {
    ?>
      Import file is ready to do import.
      Summary record going to import to the system.<br />
      Total Record : <?php echo $record_info["total"]; ?>
      <br /><br />
      <div class="row">
        <div class="col-md-12">
            <ol class="tree-structure">
              <?php $i = 1; ?>
              <?php foreach ($record_info as $table_name => $list) { ?>
                <?php if($table_name != "total") { ?>
                <li>
                   <span class="num"><?php echo $i; ?></span>
                   <a href="#">  <?php echo $table_name; ?> </a>
                   <ol>
                      <?php $j = 1; ?>
                      <li>
                         <span class="num"><?php echo (string)$i.".".(string)$j; ?></span>
                         <a href="#">Total record : <?php echo $list[0]["total"]; ?></a>
                         <?php $j = $j + 1; ?>
                      </li>
                      <?php $i = $i + 1; ?>
                   </ol>
                </li>
              <?php }} ?>
            </ol>
        </div>
      </div>
    <?php } ?>
    <form action="../show_import/<?php echo $file_name; ?>" method="post" enctype="multipart/form-data" id="js-upload-form">
      <div class="form-inline">
        <div class="form-group">
          <input type="hidden" name="excluded_case_ids" id="excluded_case_ids" value="<?php echo join(',', $excluded_case_ids) ?>">
        </div>
        <button type="submit" class="btn btn-sm btn-primary" id="js-upload-submit">Proceed to Upload</button>
      </div>
    </form>
  </div>

<?php $this->load->view('footer') ?>