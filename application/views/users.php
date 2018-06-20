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
    <div class="row">
        <div class="col-md-12">
          <a class="btn btn-primary to-right" href="users/new" name="top">Create User</a>
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            Full Name
                        </th>
                        <th>
                            Email
                        </th>
                        <th>
                            Is Admin?
                        </th>
                        <th>
                            
                        </th>
                    </tr>
                </thead>
                <tbody>
                  <?php if(count($users) <= 0){ ?>
                    <tr>
                      <td colspan="14" align="center"><center><font color="red" >No Record</font></center></td>
                    </tr>
                  <?php 
                  }
                  else{
                  ?>
                  <?php
                  foreach ($users as $record){
                  ?>
                  <tr class="active">
                    <td>
                        <?php echo $record->email; ?>
                    </td>
                    <td>
                        <?php echo($record->firstName . " " . $record->lastName); ?>
                    </td>
                    <td>
                        <?php 
                          if ($record->isAdmin == 1)
                            echo "Yes";
                          else
                            echo "No";
                        ?>
                    </td>
                    <td class="text-center">
                      <?php if ($record->id != $user_id){ ?>
                      <a href="users/edit_user/<?php echo $record->id ;?>"><i class="icon-edit"></i> Edit</a> <a href="users/delete_user/<?php echo $record->id ;?>" ><i class="icon-trash"></i> Delete</a>
                      <?php } ?>
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