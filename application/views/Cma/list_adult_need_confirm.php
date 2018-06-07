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
    <h4>
      List for Adults and Adolescents that need confirmation at VCCT:
    </h4>
    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            Client ID
                        </th>
                        <th>
                            HTC Code
                        </th>
                        <th>
                            Name of HC
                        </th>
                        <th>
                            Client Name
                        </th>
                        <th>
                            Phone Number
                        </th>
                    </tr>
                </thead>
                <tbody>
                  <tr>
                    <td colspan="5"><b>PREGNANT WOMEN:</b></td>
                  </tr>
                  <?php if(count($record_need_confirmation_is_pregnant) <= 0){ ?>
                    <tr>
                      <td colspan="5" align="center"><center><font color="red" >No Record</font></center></td>
                    </tr>
                  <?php 
                  }
                  else{
                  ?>
                  <?php
                  foreach ($record_need_confirmation_is_pregnant as $record){
                  ?>
                  <tr class="active">
                    <td>
                        <?php echo $record["case_id"]; ?>
                    </td>
                    <td>
                        <?php echo $record["name_place"]; ?>
                    </td>
                    <td>
                        <?php echo $record["place_test"]; ?>
                    </td>
                    <td>
                        <?php echo $record["name"]; ?>
                    </td>
                    <td>
                        <?php echo $record["phone_number"]; ?>
                    </td>
                  </tr>
                  <?php 
                    }
                  } 
                  ?>
                  <tr>
                    <td colspan="5"><b>0-7 DAYS:</b></td>
                  </tr>
                  <?php if(count($record_need_confirmation_within_7) <= 0){ ?>
                    <tr>
                      <td colspan="5"><center><font color="red" >No Record</font></center></td>
                    </tr>
                  <?php 
                  }
                  else{
                  ?>
                  <?php
                  foreach ($record_need_confirmation_within_7 as $record){
                  ?>
                  <tr class="active">
                    <td>
                        <?php echo $record["case_id"]; ?>
                    </td>
                    <td>
                        <?php echo $record["name_place"]; ?>
                    </td>
                    <td>
                        <?php echo $record["place_test"]; ?>
                    </td>
                    <td>
                        <?php echo $record["name"]; ?>
                    </td>
                    <td>
                        <?php echo $record["phone_number"]; ?>
                    </td>
                  </tr>
                  <?php }} ?>
                  <tr>
                    <td colspan="5"><b>8-30 DAYS:</b></td>
                  </tr>
                  <?php if(count($record_need_confirmation_8_to_30) <= 0){ ?>
                    <tr>
                      <td colspan="5"><center><font color="red" >No Record</font></center></td>
                    </tr>
                  <?php 
                  }
                  else{
                  ?>
                  <?php
                  foreach ($record_need_confirmation_8_to_30 as $record){
                  ?>
                  <tr class="active">
                    <td>
                        <?php echo $record["case_id"]; ?>
                    </td>
                    <td>
                        <?php echo $record["name_place"]; ?>
                    </td>
                    <td>
                        <?php echo $record["place_test"]; ?>
                    </td>
                    <td>
                        <?php echo $record["name"]; ?>
                    </td>
                    <td>
                        <?php echo $record["phone_number"]; ?>
                    </td>
                  </tr>
                  <?php }} ?>
                  <tr>
                    <td colspan="5"><b>31-90 DAYS:</b></td>
                  </tr>
                  <?php if(count($record_need_confirmation_31_to_90) <= 0){ ?>
                    <tr>
                      <td colspan="5"><center><font color="red" >No Record</font></center></td>
                    </tr>
                  <?php 
                  }
                  else{
                  ?>
                  <?php
                  foreach ($record_need_confirmation_31_to_90 as $record){
                  ?>
                  <tr class="active">
                    <td>
                        <?php echo $record["case_id"]; ?>
                    </td>
                    <td>
                        <?php echo $record["name_place"]; ?>
                    </td>
                    <td>
                        <?php echo $record["place_test"]; ?>
                    </td>
                    <td>
                        <?php echo $record["name"]; ?>
                    </td>
                    <td>
                        <?php echo $record["phone_number"]; ?>
                    </td>
                  </tr>
                  <?php }} ?>
                </tbody>
            </table>
        </div>
    </div>
  </div>
    
<?php $this->load->view('footer') ?>