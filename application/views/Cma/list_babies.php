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
      List for Babies
    </h4>
    <div class="row">
        <div class="col-md-12">
          <h5>Mother expected to deliver within two weeks</h5>
            <table class="table">
                <thead>
                    <tr>
                        <td colspan="4">
                            
                        </td>
                        <td colspan="4"  align="center">
                            AT BIRTH
                        </td>
                        <td colspan="3" align="center">
                            AT 6 WEEKS
                        </td>
                        <td colspan="3" align="center">
                            AT 18 MONTHS
                        </td>
                    </tr>
                    <tr>
                        <th>
                            EID Code
                        </th>
                        <th>
                            Place of delivery
                        </th>
                        <th>
                            Date of delivery
                        </th>
                        <th>
                            Phone number
                        </th>
                        <th>
                            PCR Test
                        </th>
                        <th>
                            PCR Confirmation
                        </th>
                        <th>
                            Enroll in PAC
                        </th>
                        <th>
                            Post-exposoure Treatment
                        </th>
                        <th>
                            PCR Test
                        </th>
                        <th>
                            PCR Confirmation
                        </th>
                        <th>
                            Enrolled PAC as +
                        </th>
                        <th>
                            HIV AB Test
                        </th>
                        <th>
                            PCR Test
                        </th>
                        <th>
                            PCR Confirmation
                        </th>
                    </tr>
                </thead>
                <tbody>
                  <?php if(count($record_all_babies) <= 0){ ?>
                    <tr>
                      <td colspan="14" align="center"><center><font color="red" >No Record</font></center></td>
                    </tr>
                  <?php 
                  }
                  else{
                  ?>
                  <?php
                  foreach ($record_all_babies as $record){
                  ?>
                  <tr class="active">
                    <td>
                        <?php echo $record["CodePac"]; ?>
                    </td>
                    <td>
                        <?php echo $record["Place"]; ?>
                    </td>
                    <td>
                        <?php echo $record["Dadelivery"]; ?>
                    </td>
                    <td>
                        <?php echo $record["Phone"]; ?>
                    </td>
                    <td>
                        <?php echo $record["phone_number"]; ?>
                    </td>
                    <td>
                        <?php echo $record["place"]; ?>
                    </td>
                    <td>
                        <?php echo $record["name"]; ?>
                    </td>
                    <td>
                        <?php echo $record["phone_number"]; ?>
                    </td>
                    <td>
                        <?php echo $record["place"]; ?>
                    </td>
                    <td>
                        <?php echo $record["name"]; ?>
                    </td>
                    <td>
                        <?php echo $record["phone_number"]; ?>
                    </td>
                    <td>
                        <?php echo $record["place"]; ?>
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
                </tbody>
            </table>
        </div>
    </div>
  </div>
    
<?php $this->load->view('footer') ?>