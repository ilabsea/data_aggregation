<?php $this->load->view('header') ?>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/highcharts-more.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
<script src="http://code.highcharts.com/modules/export-data.js"></script>
<script src="<?php echo base_url();?>assets/js/dashboard.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/national.css">
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

  <div class="container">
    <H4>Are there any unsual pattern or trends ?</H4>
    <div id="chart-country" style="min-width: 310px; max-width: 400px; height: 300px; margin: 0 auto">
    </div>
    <?php foreach($graph_province as $key => $value){ ?>
      <div id="graph-province-<?php echo str_replace(" ", "-",$key); ?>" style="min-width: 310px; max-width: 400px; height: 300px; margin: 0 auto; float: left;">
      </div>
    <?php } ?>
    <div class="clear"></div>
    <H4>Who are the new positives?</H4>
    <div class="row">
      <div class="column4">
        <div id="percentage-country" style="min-width: 300px; max-width: 300px; height: 150px; margin: 0 auto">
        </div>
        <div id="percentage-country-types" style="min-width: 300px; max-width: 300px; height: 300px; margin: 0 auto;">
        </div>
      </div>
      <?php foreach($graph_province as $key => $value){ ?>
        <div class="column4">
          <div id="percentage-province-<?php echo str_replace(" ", "-",$key); ?>" style="min-width: 300px; max-width: 300px; height: 150px; margin: 0 auto">
          </div>
          <div id="percentage-types-province-<?php echo str_replace(" ", "-",$key); ?>" style="min-width: 300px; max-width: 300px; height: 300px; margin: 0 auto;">
          </div>
        </div>
      <?php } ?>
    </div>
    <div class="clear"></div>
    <div id="number_positive_by_province" style="min-width: 300px; max-width: 300px; height: 500px; margin: 0 auto;"></div>
    <div class="clear"></div>
    <div id="number_positive_by_quater" ></div>
    <div class="row">
      <div class="column4">
        <div id="lost_confirmation" style="min-width: 300px; max-width: 300px; height: 500px; margin: 0 auto;">></div>
      </div>
      <div class="column4">
        <div id="lost_enrollment" style="min-width: 300px; max-width: 300px; height: 500px; margin: 0 auto;">></div>
      </div>
      <div class="column4">
        <div id="average_linktime" style="min-width: 300px; max-width: 300px; height: 500px; margin: 0 auto;">></div>
      </div>
    </div>
  </div>
<script type="text/javascript">
  var data = [];
  var central_lines = [];
  var months = [];
  <?php
      foreach($list_months as $m){
  ?>
    months.push("<?php echo $m; ?>");
  <?php 
      } 
      foreach($graph_country as $key => $value){
      if ($key != "central_line" and $key != "upper_line" and $key != "lower_line") {
  ?>
    data.push(parseInt("<?php echo $value[0]['total']; ?>"));
    central_lines.push(parseInt("<?php echo $graph_country["central_line"]; ?>"));
  <?php }} ?>
  var upper_line = parseFloat("<?php echo $graph_country["upper_line"]; ?>");
  var lower_line = parseFloat("<?php echo $graph_country["lower_line"]; ?>");
  $(function () {
    $('#chart-country').highcharts({
    chart: {
        type: 'areaspline'
    },
    title: {
        text: 'Cambodia'
    },
    xAxis: {
        categories: months
    },
    yAxis: {
        title: {
            text: ''
        },
        plotBands: [{ // visualize the weekend
            from: lower_line,
            to: upper_line,
            color: 'rgba(68, 170, 213, .2)'
        }]
    },
    tooltip: {
        shared: true,
        valueSuffix: ' units'
    },
    credits: {
        enabled: false
    },
    plotOptions: {
        areaspline: {
            fillOpacity: 0
        }
    },
    series: [{
        name: 'New Positive',
        data: data
    },{
        name: 'Central Line',
        data: central_lines
    }]
})
});
</script>
<script type="text/javascript">
var months = [];
<?php 
  foreach($graph_province as $province_name => $province_value){ 
?>
$(function () {
    var data = [];
    months = [];
    var central_lines = [];
    <?php
        foreach($province_value as $key => $value){
        if ($key != "central_line" and $key != "upper_line" and $key != "lower_line") {
    ?>
      data.push(parseInt("<?php echo $value[0]['total']; ?>"));
      months.push(parseInt("<?php echo $key; ?>"));
      central_lines.push(parseInt("<?php echo $province_value["central_line"]; ?>"));
    <?php }} ?>
    var upper_line = "<?php echo $province_value["upper_line"]; ?>";
    var lower_line = "<?php echo $province_value["lower_line"]; ?>";
    $("#graph-province-<?php echo str_replace(" ", "-",$province_name);?>").highcharts({
    chart: {
        type: 'areaspline'
    },
    title: {
        text: '<?php echo $province_name ;?>'
    },
    xAxis: {
        categories: months
    },
    yAxis: {
        title: {
            text: ''
        },
        plotBands: [{ // visualize the weekend
            from: parseFloat(lower_line),
            to: parseFloat(upper_line),
            color: 'rgba(68, 170, 213, .2)'
        }]
    },
    tooltip: {
        shared: true,
        valueSuffix: ' units'
    },
    credits: {
        enabled: false
    },
    plotOptions: {
        areaspline: {
            fillOpacity: 0
        }
    },
    series: [{
        name: 'New Positive',
        data: data
    },{
        name: 'Central Line',
        data: central_lines
    }]
})
});
<?php } ?>
</script>
<script type="text/javascript">
  $(function () {
    $('#percentage-country').highcharts({
      chart: {
          type: 'bar'
      },
      title: {
          text: "<?php echo "Cambodia"; ?> = <?php echo $total_in_country[0]["total"]; ?> cases"
      },
      xAxis: {
          categories: ["Female", "Male"]
      },
      yAxis: {
          min: 0,
          title: {
              text: ''
          }
      },
      legend: {
          reversed: true
      },
      plotOptions: {
          series: {
              stacking: 'normal'
          }
      },
      series: [{
          name: 'Positive Percentage',
          data: [<?php echo $percentage_female; ?>,<?php echo $percentage_male; ?>]
      }]
    })
});
</script>
<script type="text/javascript">
  var types = [];
  var type_value = [];
  <?php foreach($type_client as $t){ 
  ?>
    types.push("<?php echo $t["TypeClient"] ; ?>");
  <?php
    if(isset($percentage_type[$t["TypeClient"]])){
  ?>
    type_value.push(parseFloat("<?php echo $percentage_type[$t["TypeClient"]]; ?>"));
    
  <?php }
  else{
  ?>
    type_value.push(0);
  <?php
    $percentage_type[$t["TypeClient"]] = 0;
  } 
  } ?>
  $(function () {
    $('#percentage-country-types').highcharts({
      chart: {
          type: 'bar'
      },
      title: {
          text: '<?php echo "Cambodia"; ?> = <?php echo $total_in_country[0]["total"]; ?> cases'
      },
      xAxis: {
          categories: types
      },
      yAxis: {
          min: 0,
          title: {
              text: ''
          }
      },
      legend: {
          reversed: true
      },
      plotOptions: {
          series: {
              stacking: 'normal'
          }
      },
      series: [{
          name: 'Positive Percentage',
          data: type_value
      }]
    })
});
</script>
<script type="text/javascript">
<?php 
  foreach($provinces as $province){ 
?>
  $(function () {
    var province_types = [];
    var province_type_value = [];
    <?php foreach($type_client as $t){ 
    ?>
      province_types.push("<?php echo $t["TypeClient"] ; ?>");
    <?php
      if(isset($percentage_type_province[$province["ProvinceEng"]][$t["TypeClient"]])){
    ?>
      province_type_value.push(parseFloat("<?php echo $percentage_type_province[$province["ProvinceEng"]][$t["TypeClient"]]; ?>"));
      
    <?php }
    else{
    ?>
      province_type_value.push(0);
    <?php
      $percentage_type_province[$province["ProvinceEng"]][$t["TypeClient"]] = 0;
    } 
    ?>
    <?php } ?>
    $('#percentage-types-province-<?php echo str_replace(" ", "-",$province["ProvinceEng"]);?>').highcharts({
      chart: {
          type: 'bar'
      },
      title: {
          text: '<?php echo $province["ProvinceEng"]; ?>'
      },
      xAxis: {
          categories: province_types
      },
      yAxis: {
          min: 0,
          title: {
              text: ''
          }
      },
      legend: {
          reversed: true
      },
      plotOptions: {
          series: {
              stacking: 'normal'
          }
      },
      series: [{
          name: 'Positive Percentage',
          data: province_type_value
      }]
    })
  });

  $(function () {
    $('#percentage-province-<?php echo str_replace(" ", "-",$province["ProvinceEng"]);?>').highcharts({
      chart: {
          type: 'bar'
      },
      title: {
          text: ' <?php echo $province["ProvinceEng"]; ?>'
      },
      xAxis: {
          categories: ["Female", "Male"]
      },
      yAxis: {
          min: 0,
          title: {
              text: ''
          }
      },
      legend: {
          reversed: true
      },
      plotOptions: {
          series: {
              stacking: 'normal'
          }
      },
      series: [{
          name: 'Positive Percentage',
          data: [parseFloat(<?php echo $percentage_type_province[$province["ProvinceEng"]]["percentage_female"]; ?>), parseFloat(<?php echo $percentage_type_province[$province["ProvinceEng"]]["percentage_male"]; ?>)]
      }]
    })
});
<?php } ?>
</script>






<script type="text/javascript">
  var prov_column = [];
  var prov_data = [];
  <?php foreach($number_infected as $province_name => $total){ 
  ?>
    prov_column.push("<?php echo $province_name; ?>");
    prov_data.push(parseInt("<?php echo $total; ?>"));
  <?php } ?>
  <?php foreach($provinces as $province){ 
  ?>
    if(prov_column.includes("<?php echo $province['ProvinceEng']; ?>") == false){
      prov_column.push("<?php echo $province['ProvinceEng']; ?>");
      prov_data.push(0);
    }
  <?php } ?>
  $(function () {
    $('#number_positive_by_province').highcharts({
      chart: {
          type: 'bar'
      },
      title: {
          text: "Number of new case by province"
      },
      xAxis: {
          categories: prov_column
      },
      yAxis: {
          min: 0,
          title: {
              text: ''
          }
      },
      legend: {
          reversed: true
      },
      plotOptions: {
          series: {
              stacking: 'normal'
          }
      },
      series: [{
          name: 'Number of infected',
          data: prov_data
      }]
    })
});
</script>

<script type="text/javascript">
    var data_quater = [];
    var cat_quater = [];
    <?php 
      foreach($percentage_type_by_quater as $type_name => $type_value){
    ?>
      tmp = [];
      cat_quater =[];
      <?php 
        foreach($type_value as $quater_name => $quater_value){
          if(count($quater_value) > 0){
      ?>
        console.log("<?php echo $type_name; ?>");
        cat_quater.push("<?php echo $quater_name; ?>");
        tmp.push(parseInt("<?php echo $quater_value[0]['total']; ?>"));
      <?php 
          }
          else{?>
            cat_quater.push("<?php echo $quater_name; ?>");
            tmp.push(0);
          <?php 
          }
        } 
      ?>
      data_quater.push({ name : "<?php echo $type_name; ?>", data : tmp}); 
    <?php
     } 
    ?>

    $('#number_positive_by_quater').highcharts({
    chart: {
        type: 'areaspline'
    },
    title: {
        text: 'Cambodia'
    },
    xAxis: {
        categories: cat_quater
    },
    yAxis: {
        title: {
            text: ''
        }
    },
    tooltip: {
        shared: true,
        valueSuffix: ' units'
    },
    credits: {
        enabled: false
    },
    plotOptions: {
        areaspline: {
            fillOpacity: 0
        }
    },
    series: data_quater
});
</script>


<script type="text/javascript">
  var prov_column = [];
  var prov_data = [];
  <?php foreach($provinces as $province){ 
  ?>
      prov_column.push("<?php echo $province['ProvinceEng']; ?>");
      prov_data.push(parseInt("<?php echo $reason_not_confirm[$province['ProvinceEng']][0]["total"]; ?>"));
  <?php } ?>
  $(function () {
    $('#lost_confirmation').highcharts({
      chart: {
          type: 'bar'
      },
      title: {
          text: "Lost to confirmation"
      },
      xAxis: {
          categories: prov_column
      },
      yAxis: {
          min: 0,
          title: {
              text: ''
          }
      },
      legend: {
          reversed: true
      },
      plotOptions: {
          series: {
              stacking: 'normal'
          }
      },
      series: [{
          name: '',
          data: prov_data
      }]
    })
});
</script>

<script type="text/javascript">
  var prov_enrollment_column = [];
  var prov_enrollment_data = [];
  <?php foreach($provinces as $province){ 
  ?>
      prov_enrollment_column.push("<?php echo $province['ProvinceEng']; ?>");
      prov_enrollment_data.push(parseInt("<?php echo $reason_not_enrollment[$province['ProvinceEng']][0]["total"]; ?>"));
  <?php } ?>
  $(function () {
    $('#lost_enrollment').highcharts({
      chart: {
          type: 'bar'
      },
      title: {
          text: "Lost to enrollment"
      },
      xAxis: {
          categories: prov_enrollment_column
      },
      yAxis: {
          min: 0,
          title: {
              text: ''
          }
      },
      legend: {
          reversed: true
      },
      plotOptions: {
          series: {
              stacking: 'normal'
          }
      },
      series: [{
          name: '',
          data: prov_enrollment_data
      }]
    })
});
</script>


<script type="text/javascript">
  var prov_avg_column = [];
  var prov_avg_data = [];
  <?php foreach($provinces as $province){ 
  ?>
      prov_avg_column.push("<?php echo $province['ProvinceEng']; ?>");
      prov_avg_data.push(parseInt("<?php echo $reg_oi[$province['ProvinceEng']]; ?>"));
  <?php } ?>
  $(function () {
    $('#average_linktime').highcharts({
      chart: {
          type: 'bar'
      },
      title: {
          text: "Average Linkage Time (days)"
      },
      xAxis: {
          categories: prov_avg_column
      },
      yAxis: {
          min: 0,
          title: {
              text: ''
          }
      },
      legend: {
          reversed: true
      },
      plotOptions: {
          series: {
              stacking: 'normal'
          }
      },
      series: [{
          name: '',
          data: prov_avg_data
      }]
    })
});
</script>

<?php $this->load->view('footer') ?>