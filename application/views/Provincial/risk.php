<?php $this->load->view('header') ?>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/highcharts-more.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
<script src="http://code.highcharts.com/modules/export-data.js"></script>
<script src="<?php echo base_url();?>assets/js/dashboard.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/provincial.css">
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
    <H4>Who are the new positives (client type) ?</H4>
    <input type='hidden' value="<?php echo($total); ?>" id="total-risk" /> 
    <?php foreach($type_client as $t){ ?>
    <input type='hidden' value="<?php echo($type[$t['TypeClient']][0]['total']); ?>" id="<?php echo str_replace(" ", "-",$t['TypeClient']); ?>" />
    <div id="chart-<?php echo str_replace(" ", "-",$t['TypeClient']); ?>" style="min-width: 310px; max-width: 400px; height: 300px; margin: 0 auto; float: left;">
    </div>
    <?php } ?>
    <div class="clear"></div>
    <div id="chart-confirmed" style="min-width: 310px; max-width: 400px; height: 300px; margin: 0 auto">
    </div>
    <H4>Are there any unsual pattern or trends ?</H4>
    <div id="chart3" style="min-width: 310px; max-width: 400px; height: 300px; margin: 0 auto">
    </div>
    <?php foreach($graph as $key => $od){ ?>
      <div id="graph-<?php echo str_replace(" ", "-",$key); ?>" style="min-width: 310px; max-width: 400px; height: 300px; margin: 0 auto; float: left;">
      </div>
    <?php } ?>
    <div class="clear"></div>
    <H4>Who are the new positives?</H4>
    <div class="row">
      <div class="column4">
        <div id="percentage" style="min-width: 300px; max-width: 300px; height: 300px; margin: 0 auto">
        </div>
        <div id="percentage-types" style="min-width: 300px; max-width: 300px; height: 300px; margin: 0 auto;">
        </div>
      </div>
      <?php foreach($graph as $key => $od){ ?>
        <div class="column4">
          <div id="percentage-od-<?php echo str_replace(" ", "-",$key); ?>" style="min-width: 300px; max-width: 300px; height: 300px; margin: 0 auto">
          </div>
          <div id="percentage-types-od-<?php echo str_replace(" ", "-",$key); ?>" style="min-width: 300px; max-width: 300px; height: 300px; margin: 0 auto;">
          </div>
        </div>
      <?php } ?>
      <div class="clear"></div>
    </div>
    <H4>Which site are finding the most new positives?</H4>
    <div class="row">
      <div class="column4">
        <div id="most_found_hc" style="min-width: 800px; max-width: 800px; height: 300px; margin: 0 auto">
        </div>
      </div>
    </div>
  </div>
<script type="text/javascript">
  <?php foreach($type_client as $t){ ?>
  $(function () {
    $('#chart-<?php echo str_replace(" ", "-",$t['TypeClient']); ?>').highcharts({
        chart: {
          type: 'gauge',
          plotBackgroundColor: null,
          plotBackgroundImage: null,
          plotBorderWidth: 0,
          plotShadow: false
        },
        
        title: {
          text: '<?php echo $t['TypeClient']; ?>'
        },
        
        pane: {
          startAngle: -90,
          endAngle: 90,
          background: null
        },
        
        plotOptions: {
          gauge: {
            dataLabels: {
              enabled: false
            },
            dial: {
              baseLength: '0%',
              baseWidth: 10,
              radius: '100%',
              rearLength: '0%',
              topWidth: 1
            }
          }
        },
           
        // the value axis
        yAxis: {
          labels: {
              enabled: false
          },
          minorTickLength: 0,
          min: 0,
          max: 100,
          tickLength: 0,
          plotBands: [{
            from: 0,
            to: 50,
            color: 'rgb(255, 192, 0)', // yellow
            thickness: '50%'
          }
          , {
              from: 50,
              to: 100,
              color: 'rgb(155, 187, 89)', // green
              thickness: '50%'
          }]        
        },
    
        series: [{
          name: 'Speed',
          data: [80]
        }]
    
    }, 
    // Add some life
    function (chart) {
      if (!chart.renderer.forExport) {
        var point = chart.series[0].points[0],
            newVal,
            inc = Math.round((Math.random() - 0.5) * 20);
        
        newVal = parseInt($("#<?php echo str_replace(" ", "-",$t['TypeClient']); ?> ")[0].value) / parseInt($("#total-risk")[0].value);
        point.update(newVal*100);
            
      }
    });
});
<?php } ?>

$(function () {
    $('#chart-confirmed').highcharts({
        chart: {
          type: 'gauge',
          plotBackgroundColor: null,
          plotBackgroundImage: null,
          plotBorderWidth: 0,
          plotShadow: false
        },
        
        title: {
          text: 'Percentage of confirm positive'
        },
        
        pane: {
          startAngle: -90,
          endAngle: 90,
          background: null
        },
        
        plotOptions: {
          gauge: {
            dataLabels: {
              enabled: false
            },
            dial: {
              baseLength: '0%',
              baseWidth: 10,
              radius: '100%',
              rearLength: '0%',
              topWidth: 1
            }
          }
        },
           
        // the value axis
        yAxis: {
          labels: {
              enabled: false
          },
          minorTickLength: 0,
          min: 0,
          max: 100,
          tickLength: 0,
          plotBands: [{
            from: 0,
            to: 50,
            color: 'rgb(255, 192, 0)', // yellow
            thickness: '50%'
          }
          , {
              from: 50,
              to: 100,
              color: 'rgb(155, 187, 89)', // green
              thickness: '50%'
          }]        
        },
    
        series: [{
          name: 'Speed',
          data: [80]
        }]
    
    }, 
    // Add some life
    function (chart) {
      if (!chart.renderer.forExport) {
        var point = chart.series[0].points[0],
            newVal,
            inc = Math.round((Math.random() - 0.5) * 20);
        
        newVal = parseInt(<?php echo $total_confirm[0]['total']; ?>) / parseInt($("#total-risk")[0].value);
        point.update(newVal*100);
            
      }
    });
});
</script>
<script type="text/javascript">
var months = [];
<?php foreach($graph as $od_name => $od){ 
?>
$(function () {
    var data = [];
    months = [];
    var central_lines = [];
    <?php
        foreach($od as $key => $value){
        if ($key != "central_line" and $key != "upper_line" and $key != "lower_line") {
    ?>
      data.push(parseInt("<?php echo $value[0]['total']; ?>"));
      months.push(parseInt("<?php echo $key; ?>"));
      central_lines.push(parseInt("<?php echo $od["central_line"]; ?>"));
    <?php }} ?>
    var upper_line = "<?php echo $od["upper_line"]; ?>";
    var lower_line = "<?php echo $od["lower_line"]; ?>";
    $("#graph-<?php echo str_replace(" ", "-",$od_name);?>").highcharts({
    chart: {
        type: 'areaspline'
    },
    title: {
        text: '<?php echo $od_name ;?>'
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
  var data = [];
  var central_lines = [];
  <?php
      foreach($graph_province[$province] as $key => $value){
      if ($key != "central_line" and $key != "upper_line" and $key != "lower_line") {
  ?>
    data.push(parseInt("<?php echo $value[0]['total']; ?>"));
    central_lines.push(parseInt("<?php echo $graph_province[$province]["central_line"]; ?>"));
  <?php }} ?>
  var upper_line = parseFloat("<?php echo $graph_province[$province]["upper_line"]; ?>");
  var lower_line = parseFloat("<?php echo $graph_province[$province]["lower_line"]; ?>");
  $(function () {
    $('#chart3').highcharts({
    chart: {
        type: 'areaspline'
    },
    title: {
        text: '<?php echo $province; ?>'
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
  var types = [];
  var type_value = [];
  var type_notvalue = [];
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
  ?>
    type_notvalue.push(100 - parseFloat("<?php echo $percentage_type[$t["TypeClient"]]; ?>"))
  <?php } ?>
  $(function () {
    $('#percentage-types').highcharts({
      chart: {
          type: 'bar'
      },
      title: {
          text: '<?php echo $province; ?> = <?php echo $total_in_province[0]["total"]; ?> cases'
      },
      xAxis: {
          categories: types
      },
      yAxis: {
          min: 0,
          title: {
              text: 'Total fruit consumption'
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
          name: 'Negative Percentage',
          data: type_notvalue
      }, {
          name: 'Positive Percentage',
          data: type_value
      }]
    })
});
</script>
<script type="text/javascript">
  $(function () {
    $('#percentage').highcharts({
      chart: {
          type: 'bar'
      },
      title: {
          text: "<?php echo $province; ?> = <?php echo $total_in_province[0]["total"]; ?> cases"
      },
      xAxis: {
          categories: ["Female", "Male"]
      },
      yAxis: {
          min: 0,
          title: {
              text: 'Total fruit consumption'
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
          name: 'Negative Percentage',
          data: [<?php echo $percentage_male; ?>, <?php echo $percentage_female; ?>]
      }, {
          name: 'Positive Percentage',
          data: [<?php echo $percentage_female; ?>,<?php echo $percentage_male; ?>]
      }]
    })
});
</script>

<script type="text/javascript">
<?php 
  foreach($ods as $od){ 
?>
  $(function () {
    var od_types = [];
    var od_type_value = [];
    var od_type_notvalue = [];
    <?php foreach($type_client as $t){ 
    ?>
      od_types.push("<?php echo $t["TypeClient"] ; ?>");
    <?php
      if(isset($percentage_type_od[$od["ODname"]][$t["TypeClient"]])){
    ?>
      od_type_value.push(parseFloat("<?php echo $percentage_type_od[$od["ODname"]][$t["TypeClient"]]; ?>"));
      
    <?php }
    else{
    ?>
      od_type_value.push(0);
    <?php
      $percentage_type_od[$od["ODname"]][$t["TypeClient"]] = 0;
    } 
    ?>
      od_type_notvalue.push(100 - parseFloat("<?php echo $percentage_type_od[$od["ODname"]][$t["TypeClient"]]; ?>"))
    <?php } ?>
    $('#percentage-types-od-<?php echo str_replace(" ", "-",$od['ODname']);?>').highcharts({
      chart: {
          type: 'bar'
      },
      title: {
          text: 'OD <?php echo $od["ODname"]; ?>'
      },
      xAxis: {
          categories: od_types
      },
      yAxis: {
          min: 0,
          title: {
              text: 'Total fruit consumption'
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
          name: 'Negative Percentage',
          data: od_type_notvalue
      }, {
          name: 'Positive Percentage',
          data: od_type_value
      }]
    })
  });

  $(function () {
    $('#percentage-od-<?php echo str_replace(" ", "-",$od['ODname']);?>').highcharts({
      chart: {
          type: 'bar'
      },
      title: {
          text: 'OD <?php echo $od["ODname"]; ?>'
      },
      xAxis: {
          categories: ["Female", "Male"]
      },
      yAxis: {
          min: 0,
          title: {
              text: 'Total fruit consumption'
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
          name: 'Negative Percentage',
          data: [100 - parseFloat(<?php echo $percentage_type_od[$od["ODname"]]["percentage_female"]; ?>), 100 - parseFloat(<?php echo $percentage_type_od[$od["ODname"]]["percentage_male"]; ?>)]
      }, {
          name: 'Positive Percentage',
          data: [parseFloat(<?php echo $percentage_type_od[$od["ODname"]]["percentage_female"]; ?>), parseFloat(<?php echo $percentage_type_od[$od["ODname"]]["percentage_male"]; ?>)]
      }]
    })
});
<?php } ?>
</script>

<script type="text/javascript">
  $(function () {
    var column = [];
    var data_value = [];
    <?php foreach($most_hc_found_positive as $hc){ 
    ?>
      column.push("<?php echo $hc["PlaceTest"] ; ?>");
      data_value.push(parseFloat("<?php echo $hc["total"] ; ?>"));
    
    <?php } ?>
    $('#most_found_hc').highcharts({
      chart: {
          type: 'bar'
      },
      title: {
          text: "<?php echo $province; ?> = <?php echo $total_in_province[0]["total"]; ?> cases"
      },
      xAxis: {
          categories: column
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
          name: 'Negative Percentage',
          data: data_value
      }]
    })
});
</script>
















<?php $this->load->view('footer') ?>