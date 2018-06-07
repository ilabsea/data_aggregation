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
            <li class="active"><a href="#"><i class="icon-home"></i> Dashboard</a></li>
            <li class="divider-vertical"></li>
            <li><a href="../imports/show_upload"><i class="icon-home"></i> Import Wizard</a></li>
            <li class="divider-vertical"></li>
            <li>
              <a href="../users" style="padding:10px;">
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
  <div class="row">
    <div class="column4">
      <div class="dash-box-blue dash-box-color-1">
        <div class="dash-box-body">
          <div class="column3">
            <a href="show_list_adult_need_confirm" >
              <span class="dash-box-count"><?php echo count($record_need_confirmation); ?></span>
            </a>
          </div>
          <div class="column7">
            <span class="dash-box-title">need confirmation at VCCT</span>
          </div>
          <div class="clear"></div>
          <div class="column3">
            <span class="dash-box-count">&nbsp;</span>
          </div>
          <div class="column7">
            <span class="dash-box-title"> <b><?php echo count($record_need_confirmation_within_7); ?></b> within 0-7 days</span><br/>
            <span class="dash-box-title"><b><?php echo count($record_need_confirmation_8_to_30); ?></b> within 8-30 days</span><br/>
            <span class="dash-box-title"><b><?php echo count($record_need_confirmation_31_to_90); ?></b> within 31-90 days</span><br/>
            <span class="dash-box-title"><b><?php echo count($record_need_confirmation_is_pregnant); ?></b> are pregnant women</span><br/>
          </div>
          <div class="clear"></div>
          <div class="column3">
            <a href="show_list_adult_need_enroll" >
              <span class="dash-box-count"><?php echo count($record_need_enrollment); ?></span>
            </a>
          </div>
          <div class="column7">
            <span class="dash-box-title">need enrollment into cared</span>
          </div>
          <div class="clear"></div>
          <div class="column3">
            <span class="dash-box-count">&nbsp;</span>
          </div>
          <div class="column7">
            <span class="dash-box-title"> <b><?php echo count($record_need_enrollment_within_7); ?></b> within 0-7 days</span><br/>
            <span class="dash-box-title"><b><?php echo count($record_need_enrollment_8_to_30); ?></b> within 8-30 days</span><br/>
            <span class="dash-box-title"><b><?php echo count($record_need_enrollment_31_to_90); ?></b> within 31-90 days</span><br/>
            <span class="dash-box-title"><b><?php echo count($record_need_enrollment_is_pregnant); ?></b> are pregnant women</span><br/>
          </div>
          <div class="clear"></div>
        </div>
        <div class="dash-box-action">
          <button>ADULTS & ADOLESCENTS</button>
        </div>        
      </div>
    </div>
    <div class="column4">
      <div class="dash-box-yellow dash-box-color-1">
        <div class="dash-box-body">
          <div class="column3">
            <span class="dash-box-count"><?php echo count($deliver_within_two_week); ?></span>
          </div>
          <div class="column7">
            <span class="dash-box-title">are expected to deliver within two weeks</span>
          </div>
          <div class="clear"></div><br />
          <div class="column3">
            <span class="dash-box-count"><?php echo count($missing_birth_outcome); ?></span>
          </div>
          <div class="column7">
            <span class="dash-box-title">are missing a birth outcome</span>
          </div>
          <div class="clear"></div><br />
          <div class="column3">
            <span class="dash-box-count"><?php echo count($missing_actual_dilivery); ?></span>
          </div>
          <div class="column7">
            <span class="dash-box-title">are missing an actual delivery date</span>
          </div>
          <div class="clear"></div>
        </div>
        
        <div class="dash-box-action">
          <button>MOTHERS</button>
        </div>        
      </div>
    </div>
    <div class="column4">
      <div class="dash-box dash-box-color-1">
        <div class="dash-box-body">
          
          <div class="column3">
            <span class="dash-box-count">8,252</span>
          </div>
          <div class="column7">
            <span class="dash-box-title">need a PCR test</span>
          </div>
          <div class="clear"></div><br />
          <div class="column3">
            <span class="dash-box-count">8,252</span>
          </div>
          <div class="column7">
            <span class="dash-box-title">need a confirmation test</span>
          </div>
          <div class="clear"></div><br />
          <div class="column3">
            <span class="dash-box-count">8,252</span>
          </div>
          <div class="column7">
            <span class="dash-box-title">were not enrolled in PAC at birth</span>
          </div>
          <div class="clear"></div><br />
          <div class="column3">
            <span class="dash-box-count">8,252</span>
          </div>
          <div class="column7">
            <span class="dash-box-title">need to be enrolled in PAC as a positive</span>
          </div>
          <div class="clear"></div><br />
          <div class="column3">
            <span class="dash-box-count">8,252</span>
          </div>
          <div class="column7">
            <span class="dash-box-title">need to post-exposure treatment</span>
          </div>
          <div class="clear"></div>
        </div>
        
        <div class="dash-box-action">
          <button>BABIES</button>
        </div>        
      </div>
    </div>
  </div>
</div>
    
<?php $this->load->view('footer') ?>