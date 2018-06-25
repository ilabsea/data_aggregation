<script type="text/javascript">
  var num_ltf = 0;
  var num_death = 0;
  var num_moved = 0;
  var num_total = 0;

  <?php foreach ($reason_not_confirm as $obj) {
    ?>
    
    <?php
    if($obj["Status"] == 0){
      ?>
      num_death = parseInt("<?php echo $obj['total'];?>");
      num_total = num_total + parseInt("<?php echo $obj['total'];?>");
      <?php
    }
    if($obj["Status"] == 1){
      ?>
      num_ltf = parseInt("<?php echo $obj['total'];?>");
      num_total = num_total + parseInt("<?php echo $obj['total'];?>");
      <?php
    }
    if($obj["Status"] == 2){
      ?>
      num_moved = parseInt("<?php echo $obj['total'];?>");
      num_total = num_total + parseInt("<?php echo $obj['total'];?>");
      <?php
    }
  }

  ?>
  if(num_total == 0){
    num_death = 0;
    num_ltf = 0;
    num_moved = 0;
  }
  else{
    num_death = 100 * parseFloat(num_death)/num_total;
    num_ltf = 100 * parseFloat(num_ltf)/num_total;
    num_moved = 100 * parseFloat(num_moved)/num_total;
  }
  console.log();
  $(function () {
    $('#losing_confirm').highcharts({
      chart: {
          type: 'bar'
      },
      title: {
          text: "Losing confirm"
      },
      xAxis: {
          categories: ["LTF", "Death", "Moved"]
      },
      yAxis: {
          min: 0,
          title: {
              text: ''
          },
          stackLabels: {
            enabled: true,
            style: {
                fontWeight: 'bold',
                color:'gray'
            }
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
          name: 'Percentage',
          data: [num_ltf, num_death,num_moved]
      }]
    })
  });

  var confirm_one_two = 0;
  var confirm_three_seven = 0;
  var confirm_more_than_seven = 0;
  var confirm_total = 0
  <?php foreach ($duration_confirmed as $key => $obj) {
    ?>
    confirm_total = confirm_total + parseInt("<?php echo $obj[0]['total'];?>");
    <?php
    if($key == "one_to_two_days"){
      ?>
      confirm_one_two = parseInt("<?php echo $obj[0]['total'];?>");
      <?php
    }
    if($key == "three_to_seven_days"){
      ?>
      confirm_three_seven = parseInt("<?php echo $obj[0]['total'];?>");
      <?php
    }
    if($key == "more_than_seven_days"){
      ?>
      confirm_more_than_seven = parseInt("<?php echo $obj[0]['total'];?>");
      <?php
    }
  }
  ?>
  if(confirm_total == 0){
    confirm_one_two = 0;
    confirm_three_seven = 0;
    confirm_more_than_seven = 0;
  }
  else{
    confirm_one_two = 100 * parseFloat(confirm_one_two)/confirm_total;
    confirm_three_seven = 100 * parseFloat(confirm_three_seven)/confirm_total;
    confirm_more_than_seven = 100 * parseFloat(confirm_more_than_seven)/confirm_total;
  }
  $(function () {
    $('#duration_link_confirm').highcharts({
      chart: {
          type: 'bar'
      },
      title: {
          text: "Confirmed"
      },
      xAxis: {
          categories: ["1-2 days", "3-7 days", "> 1 week"]
      },
      yAxis: {
          min: 0,
          title: {
              text: ''
          },
          stackLabels: {
            enabled: true,
            style: {
                fontWeight: 'bold',
                color:'gray'
            }
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
          name: 'Percentage',
          data: [confirm_one_two, confirm_three_seven,confirm_more_than_seven]
      }]
    })
  });


  var not_enroll_num_ltf = 0;
  var not_enroll_num_death = 0;
  var not_enroll_num_moved = 0;
  var not_enroll_total = 0;
  <?php foreach ($reason_not_enroll as $obj) {
    ?>
    not_enroll_total = not_enroll_total + parseInt("<?php echo $obj['total'];?>")
    <?php
    if($obj["Status"] == 0){
      ?>
      not_enroll_num_death = parseInt("<?php echo $obj['total'];?>");
      <?php
    }
    if($obj["Status"] == 1){
      ?>
      not_enroll_num_ltf = parseInt("<?php echo $obj['total'];?>");
      <?php
    }
    if($obj["Status"] == 2){
      ?>
      not_enroll_num_moved = parseInt("<?php echo $obj['total'];?>");
      <?php
    }
  }
  ?>
  if(not_enroll_total == 0){
    not_enroll_num_ltf = 0;
    not_enroll_num_death = 0;
    not_enroll_num_moved = 0;
  }
  else{
    not_enroll_num_ltf = 100 * parseFloat(not_enroll_num_ltf)/not_enroll_total;
    not_enroll_num_death = 100 * parseFloat(not_enroll_num_death)/not_enroll_total;
    not_enroll_num_moved = 100 * parseFloat(not_enroll_num_moved)/not_enroll_total;
  }
  $(function () {
    $('#losing_enroll').highcharts({
      chart: {
          type: 'bar'
      },
      title: {
          text: "Losing enrollment"
      },
      xAxis: {
          categories: ["LTF", "Death", "Moved"]
      },
      yAxis: {
          min: 0,
          title: {
              text: ''
          },
          stackLabels: {
            enabled: true,
            style: {
                fontWeight: 'bold',
                color:'gray'
            }
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
          name: 'Percentage',
          data: [not_enroll_num_ltf, not_enroll_num_death,not_enroll_num_moved]
      }]
    })
  });



  var enroll_one_two = 0;
  var enroll_three_seven = 0;
  var enroll_more_than_seven = 0;
  var enroll_total = 0;
  <?php foreach ($duration_enroll as $key => $obj) {
    ?>
      enroll_total = enroll_total + parseFloat("<?php echo $obj[0]['total'];?>");
    <?php
    if($key == "one_to_two_days"){
      ?>
      enroll_one_two = parseInt("<?php echo $obj[0]['total'];?>");
      <?php
    }
    if($key == "three_to_seven_days"){
      ?>
      enroll_three_seven = parseInt("<?php echo $obj[0]['total'];?>");
      <?php
    }
    if($key == "more_than_seven_days"){
      ?>
      enroll_more_than_seven = parseInt("<?php echo $obj[0]['total'];?>");
      <?php
    }
  }
  ?>
  if(enroll_total == 0){
    enroll_one_two = 0;
    enroll_three_seven = 0;
    enroll_more_than_seven = 0;
  }
  else{
    enroll_one_two = 100 * parseFloat(enroll_one_two)/enroll_total;
    enroll_three_seven = 100 * parseFloat(enroll_three_seven)/enroll_total;
    enroll_more_than_seven = 100 * parseFloat(enroll_more_than_seven)/enroll_total;
  }
  $(function () {
    $('#duration_link_enrollment').highcharts({
      chart: {
          type: 'bar'
      },
      title: {
          text: "Enrollment"
      },
      xAxis: {
          categories: ["1-2 days", "3-7 days", "> 1 week"]
      },
      yAxis: {
          min: 0,
          title: {
              text: ''
          },
          stackLabels: {
            enabled: true,
            style: {
                fontWeight: 'bold',
                color:'gray'
            }
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
          name: 'Percentage',
          data: [enroll_one_two, enroll_three_seven,enroll_more_than_seven]
      }]
    })
  });



  var not_confirm_male = 0;
  var not_confirm_female = 0;
  var not_confirm_gender_total = 0;
  <?php foreach ($reason_not_confirm_as_sex as $key => $obj) {
    ?>
      not_confirm_gender_total = not_confirm_gender_total + parseFloat("<?php echo $obj['total'];?>");
    <?php
    if($obj["Sex"] == "Male"){
      ?>
      not_confirm_male = parseInt("<?php echo $obj['total'];?>");
      <?php
    }
    if($obj["Sex"] == "Female"){
      ?>
      not_confirm_female = parseInt("<?php echo $obj['total'];?>");
      <?php
    }
  }
  ?>
  if(not_confirm_gender_total == 0){
    not_confirm_male = 0;
    not_confirm_female = 0;
  }
  else{
    not_confirm_male = 100 * parseFloat(not_confirm_male)/not_confirm_gender_total;
    not_confirm_female = 100 * parseFloat(not_confirm_female)/not_confirm_gender_total;
  }
  $(function () {
    $('#sex_lost_confirm').highcharts({
      chart: {
          type: 'bar'
      },
      title: {
          text: "Gender"
      },
      xAxis: {
          categories: ["Male", "Female"]
      },
      yAxis: {
        min: 0,
        title: {
            text: ''
        },
        stackLabels: {
          enabled: true,
          style: {
              fontWeight: 'bold',
              color:'gray'
          }
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
          name: 'Percentage',
          data: [not_confirm_male,not_confirm_female]
      }]
    })
  });


  var not_confirm_as_type_data = [];
  var not_confirm_gender_total = 0;
  var not_confirm_column = [];
  <?php foreach ($type_client as $type) {
      if(isset($reason_not_confirm_as_type[$type['TypeClient']])){
    ?>
        not_confirm_gender_total = not_confirm_gender_total + parseInt("<?php echo $reason_not_confirm_as_type[$type['TypeClient']];?>");
    <?php 
      } 
  } ?>
  <?php foreach ($type_client as $type) {
    ?>
    
    <?php 
      if(isset($reason_not_confirm_as_type[$type['TypeClient']])){
    ?>
        not_confirm_column.push("<?php echo $type['TypeClient'];?>");
        not_confirm_as_type_data.push(100 * parseFloat("<?php echo $reason_not_confirm_as_type[$type['TypeClient']];?>") / not_confirm_gender_total);
    <?php 
      } 
    ?>
  <?php } ?>
  $(function () {
    $('#type_lost_confirm').highcharts({
      chart: {
          type: 'bar'
      },
      title: {
          text: "Type of client"
      },
      xAxis: {
          categories: not_confirm_column
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
          name: 'Percentage',
          data: not_confirm_as_type_data
      }]
    })
  });



  var not_enroll_male = 0;
  var not_enroll_female = 0;
  var not_enroll_gender_total = 0;
  <?php foreach ($reason_not_enroll_as_sex as $key => $obj) {
    ?>
      not_enroll_gender_total = not_enroll_gender_total + parseFloat("<?php echo $obj['total'];?>");
    <?php
    if($obj["Sex"] == "Male"){
      ?>
      not_enroll_male = parseInt("<?php echo $obj['total'];?>");
      <?php
    }
    if($obj["Sex"] == "Female"){
      ?>
      not_enroll_female = parseInt("<?php echo $obj['total'];?>");
      <?php
    }
  }
  ?>
  if(not_enroll_gender_total == 0){
    not_enroll_male = 0;
    not_enroll_female = 0;
  }
  else{
    not_enroll_male = 100 * parseFloat(not_enroll_male)/not_enroll_gender_total;
    not_enroll_female = 100 * parseFloat(not_enroll_female)/not_enroll_gender_total;
  }
  $(function () {
    $('#sex_lost_enroll').highcharts({
      chart: {
          type: 'bar'
      },
      title: {
          text: "Gender"
      },
      xAxis: {
          categories: ["Male", "Female"]
      },
      yAxis: {
          min: 0,
          title: {
              text: ''
          },
          stackLabels: {
            enabled: true,
            style: {
                fontWeight: 'bold',
                color:'gray'
            }
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
          name: 'Percentage',
          data: [not_enroll_male,not_enroll_female]
      }]
    })
  });


  var not_enroll_as_type_data = [];
  var not_enroll_as_type_gender_total = 0;
  var not_enroll_column = [];
  <?php foreach ($type_client as $type) {
      if(isset($reason_not_enroll_as_type[$type['TypeClient']])){
    ?>
        not_enroll_as_type_gender_total = not_enroll_as_type_gender_total + parseInt("<?php echo $reason_not_enroll_as_type[$type['TypeClient']];?>");
    <?php 
      } 
  } ?>
  <?php foreach ($type_client as $type) {
    ?>
    
    <?php 
      if(isset($reason_not_confirm_as_type[$type['TypeClient']])){
    ?>
        not_enroll_column.push("<?php echo $type['TypeClient'];?>");
        not_enroll_as_type_data.push(100 * parseFloat("<?php echo $reason_not_enroll_as_type[$type['TypeClient']];?>")/not_enroll_as_type_gender_total);
    <?php 
      } 
    ?>
  <?php } ?>
  $(function () {
    $('#type_lost_enroll').highcharts({
      chart: {
          type: 'bar'
      },
      title: {
          text: "Type of client"
      },
      xAxis: {
          categories: not_enroll_column
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
          name: 'Percentage',
          data: not_enroll_as_type_data
      }]
    })
  });
</script>