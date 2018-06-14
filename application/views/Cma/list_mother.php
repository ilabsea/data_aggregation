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
      List for Mothers
    </h4>
    <div class="row">
        <div class="col-md-12">
          <h5>Mother expected to deliver within two weeks</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            PW ID
                        </th>
                        <th>
                            Expected Delivery Date
                        </th>
                        <th>
                            Name of ANC Facility
                        </th>
                        <th>
                            Client Name
                        </th>
                        <th>
                            Phone Number
                        </th>
                        <th>
                            On ART
                        </th>
                        <th>
                            Birth Date Two Weeks
                        </th>
                    </tr>
                </thead>
                <tbody>
                  <?php if(count($deliver_within_two_week) <= 0){ ?>
                    <tr>
                      <td colspan="7" align="center"><center><font color="red" >No Record</font></center></td>
                    </tr>
                  <?php 
                  }
                  else{
                  ?>
                  <?php
                  foreach ($deliver_within_two_week as $record){
                  ?>
                  <tr class="active">
                    <td>
                        <?php echo $record["case_id"]; ?>
                    </td>
                    <td>
                        <?php echo $record["exp_date"]; ?>
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
                        <?php if($record["art"] != "" or $record["art" != null]) {
                          echo "Yes";
                        }
                        else{
                          echo "No";
                        }
                        ?>
                    </td>
                    <td>
                        Yes
                    </td>
                  </tr>
                  <?php 
                    }
                  }
                  ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-12">
          <h5>Mother missing a birth outcome</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            PW ID
                        </th>
                        <th>
                            Expected Delivery Date
                        </th>
                        <th>
                            Name of ANC Facility
                        </th>
                        <th>
                            Client Name
                        </th>
                        <th>
                            Phone Number
                        </th>
                        <th>
                            On ART
                        </th>
                        <th>
                            Actual Birth Date
                        </th>
                        <th>
                            Birth Outcome
                        </th>
                       
                    </tr>
                </thead>
                <tbody>
                  <?php if(count($missing_birth_outcome) <= 0){ ?>
                    <tr>
                      <td colspan="8" align="center"><center><font color="red" >No Record</font></center></td>
                    </tr>
                  <?php 
                  }
                  else{
                  ?>
                  <?php
                  foreach ($missing_birth_outcome as $record){
                  ?>
                  <tr class="active">
                    <td>
                        <?php echo $record["case_id"]; ?>
                    </td>
                    <td>
                        <?php echo $record["exp_date"]; ?>
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
                        <?php if($record["art"] != "" or $record["art" != null]) {
                          echo "Yes";
                        }
                        else{
                          echo "No";
                        }
                        ?>
                    </td>
                    <td>
                        <?php if($record["delivery_date"] != "" or $record["delivery_date" != null]) {
                          echo "Yes";
                        }
                        else{
                          echo "No";
                        }
                        ?>
                    </td>
                    <td>
                        NO
                    </td>
                  </tr>
                  <?php 
                    }
                  }
                  ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-12">
          <h5>Mother missing an actual delivery date</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            PW ID
                        </th>
                        <th>
                            Expected Delivery Date
                        </th>
                        <th>
                            Name of ANC Facility
                        </th>
                        <th>
                            Client Name
                        </th>
                        <th>
                            Phone Number
                        </th>
                        <th>
                            On ART
                        </th>
                        <th>
                            Actual Birth Date
                        </th>
                        <th>
                            Birth Outcome
                        </th>
                    </tr>
                </thead>
                <tbody>
                  <?php if(count($missing_actual_dilivery) <= 0){ ?>
                    <tr>
                      <td colspan="8" align="center"><center><font color="red" >No Record</font></center></td>
                    </tr>
                  <?php 
                  }
                  else{
                  ?>
                  <?php
                  foreach ($missing_actual_dilivery as $record){
                  ?>
                  <tr class="active">
                    <td>
                        <?php echo $record["case_id"]; ?>
                    </td>
                    <td>
                        <?php echo $record["exp_date"]; ?>
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
                        <?php if($record["art"] != "" or $record["art" != null]) {
                          echo "Yes";
                        }
                        else{
                          echo "No";
                        }
                        ?>
                    </td>
                    <td>
                        <?php if($record["delivery_date"] != "" or $record["delivery_date" != null]) {
                          echo "Yes";
                        }
                        else{
                          echo "No";
                        }
                        ?>
                    </td>
                    <td>
                      <?php
                        switch ($record["result"]) {
                          case '-1':
                            echo "No information";
                            break;
                          case '0':
                            echo "No information";
                            break;
                          case '1':
                            echo "Miscarriage";
                            break;
                          case '2':
                            echo "Abort";
                            break;
                          case '3':
                            echo "Live Birth";
                            break;
                          case '4':
                            echo "Dead Birth";
                            break;
                          default:
                            # code...
                            break;
                        }
                      ?>
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