<?php $this->load->view('header') ?>
  <div class="navbar">
    <div class="navbar-inner">
      <div class="container-fluid">
        <a class="brand" href="#" name="top">BIACM Data Aggregation</a>
          <ul class="nav">
            <li><a href="#"><i class="icon-home"></i> Dashboard</a></li>
            <li class="divider-vertical"></li>
            <li class="active"><a href="#"><i class="icon-home"></i> Import Wizard</a></li>
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
    <div class="stepwizard">
        <div class="stepwizard-row">
            <div class="stepwizard-step">
                <a class="brand" href="../show_upload" name="top">
                  <button type="button" class="btn btn-disabled btn-circle">1</button>
                  <p>Upload File</p>
                </a>
            </div>
            <div class="stepwizard-step">
                <a class="brand" href="../show_validation/<?php echo $file_name ?>" name="top">
                  <button type="button" class="btn btn-disabled btn-circle">2</button>
                  <p>Validation</p>
                </a>
            </div>
            <div class="stepwizard-step">
                <button type="button" class="btn btn-primary btn-circle" disabled="disabled">3</button>
                <p>Import</p>
            </div> 
        </div>
    </div>
    
    Import file is ready to do import.
    Application is processing import please stay in the page until the process is completed.<br />
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
                       <a href="#" style="padding-top:5px;">Total record : <?php echo $list[0]["total"]; ?></a>
                       <img src="../../../assets/img/waiting.png" id="<?php echo $table_name; ?>" width="16"/>
                       <?php $j = $j + 1; ?>
                    </li>
                    <?php $i = $i + 1; ?>
                 </ol>
              </li>
            <?php }} ?>
          </ol>
      </div>
    </div>
    <center>
      <div class="row text-center" id="success-div" style="display: none;">
        <div class="col-sm-6 col-sm-offset-3">
          <br><br> <h2 style="color:#0fad00" id="lblSuccess">Success</h2>
          <p style="font-size:20px;color:#5C5C5C;">System successfully import all of your data into the system.</p>
          <a href="../../dashboard/show_dashboard" class="btn btn-success">     Go to Dashboard      </a>
          <br><br>
          </div>
      </div>
    </center>
    
  </div>

  <script>

    var table_list = [];
    <?php
        foreach ($record_info as $table_name => $table_properties)
        {
          if($table_name != "total") {
    ?>
    table_list.push("<?php echo $table_name; ?>");
    <?php
       }}
    ?>

    var ignor_list = [];
    <?php
        foreach ($response_data as $case_id => $list)
        {
    ?>
      ignor_list.push("<?php echo $case_id; ?>");
    <?php
       }
    ?>
    var startUpload = function(index, file_name, table_name, max_size) {
      if(index <= max_size)
        jQuery.ajax({
            url: "../../imports/import_data/" + table_name ,
            type: "POST",
            data: JSON.stringify({excluded_case_ids : ignor_list}),
            processData: true,
            contentType: 'application/json',
            start: function(){
              $("#" + table_name).attr("src", "../../../assets/img/loading.gif")
            },
            success: function (result) {
                $("#" + table_name).attr("src", "../../../assets/img/check.png")
                var next_index = index + 1;
                startUpload(index+1, file_name, table_list[next_index], max_size);
            }
        });
      else
        removeUploadFile(file_name);
    };

    var removeUploadFile = function(file_name) {
      jQuery.ajax({
          url: "../../../index.php/file/remove/" + file_name,
          type: "POST",
          processData: false,
          contentType: 'application/json',
          success: function (result) {
            $("#success-div")[0].style.display = "block";
            window.location.hash = '#lblSuccess';
          }
      });
    };

    var i =0;
    var max_size = table_list.length - 1;
    startUpload(i, "<?php echo $file_name; ?>", table_list[i], max_size);

  </script>
<?php $this->load->view('footer') ?>