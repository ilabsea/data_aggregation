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