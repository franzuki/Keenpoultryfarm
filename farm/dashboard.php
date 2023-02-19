<?php 
include('includes/checklogin.php');
check_login();

?>
<!DOCTYPE html>
<html lang="en">

<?php @include("includes/head.php");?>
<body>

<style>
#my-pie-chart-container {
  display: flex;
  align-items: center;
  /* float: right; */
}

/*#my-pie-chart {
  background: conic-gradient(brown 0.00deg, black 55deg, blue 55deg 116.08deg, green 6.08deg 13.68deg, yellow 13.68deg 23.27deg, orange 23.27deg 40.47deg, red 40.47deg);
  border-radius: 50%;
    width: 250px;
    height: 250px;
} */

.float{
  position:fixed;
  width:60px;
  height:60px;
  bottom:40px;
  right:40px;
  background-color:#25d366;
  color:#FFF;
  border-radius:50px;
  text-align:center;
  font-size:30px;
  box-shadow: 2px 2px 3px #999;
  z-index:100;
}

.my-float{
  margin-top:16px;
}
</style>
<a href="https://api.whatsapp.com/send?phone=254701723886&text=Hi%20Francis,%20I%20saw%20your%20Project%20KEEN%20Poultry%20Farm.%20I%20like%20your%20project." class="float" target="_blank">
<i class="fa fa-whatsapp my-float"></i>
</a>
  <div class="container-scroller">
    
    <?php @include("includes/header.php");
    // $myquery=mysqli_query($con,"SELECT * From tbladmin");
    // $auth=mysqli_fetch_query($myquery);
    ?>
    
    <div class="container-fluid page-body-wrapper">
       

      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
          <div class="col-l-6">
                <div class="center navbar-brand-wrapper  align-items-center justify-content-center">
                                        
                    <a class="navbar-brand brand-logo " href="dashboard.php"><img class="img-avatar" style="height: 150PX; border-radius:10px" src="assets/img/companyimages/poultrylogo.png" alt="Company Logo"></a>
                    <div id="my-pie-chart-container">
                      <div id="my-pie-chart"></div>
                    </div>
              </div>
              <?php
               // if ($auth['AdminName']=="Admin"){
              ?>
            <div class="col-l-6">
              <div class="row">
              <div class="col-md-6 stretch-card grid-margin">
              <div class="card bg-gradient-info card-img-holder text-white"style="height: 150px;">
                <div class="card-body">
                  
                  <h4 class="font-weight-normal mb-3">Today's Total Sales 
                  </h4>
                  <?php
                  $querybb=mysqli_query($con,"select sum(tblorders.Quantity*tblproducts.ProductPrice) as today  from tblorders join tblproducts on tblproducts.id=tblorders.ProductId where date(tblorders.InvoiceGenDate)=CURDATE()");
                  $today=mysqli_fetch_array($querybb);
                  ?>
                  <h2 class="mb-5"><?php echo number_format($today['today'],2);?></h2>
                </div>
              </div>
            </div>
            <div class="col-md-6 stretch-card grid-margin">
              <div class="card bg-gradient-primary card-img-holder text-white" style="height: 150px;">
                <div class="card-body">
                  
                  <h4 class="font-weight-normal mb-3">Weekly Sales 
                    
                  </h4>
                  <?php
                  $qury=mysqli_query($con,"select sum(tblorders.Quantity*tblproducts.ProductPrice) as week  from tblorders join tblproducts on tblproducts.id=tblorders.ProductId where date(tblorders.InvoiceGenDate)>=(DATE(NOW()) - INTERVAL 7 DAY)");
                  $row=mysqli_fetch_array($qury);
                  ?>
                  <h2 class="mb-5"><?php echo number_format($row['week'],2);?></h2>
                </div>
              </div>
            </div>
            <div class="col-md-6 stretch-card grid-margin">
              <div class="card bg-gradient-success card-img-holder text-white" style="height: 150px;">
                <div class="card-body">
                  <h4 class="font-weight-normal mb-3">Total sales till date 
                  </h4>
                  <?php
                  $query=mysqli_query($con,"select sum(tblorders.Quantity*tblproducts.ProductPrice) as total  from tblorders join tblproducts on tblproducts.id=tblorders.ProductId ");
                  $row=mysqli_fetch_array($query);
                  ?>
                  <h2 class="mb-5"><?php echo number_format($row['total'],2);?></h2>
                </div>
              </div>
            </div>
            
            <div class="col-md-6 stretch-card grid-margin">
              <div class="card bg-gradient-warning card-img-holder text-white"style="height: 150px;">
                <div class="card-body">
                  
                  <h4 class="font-weight-normal mb-3">Yesterday Total Sales
                  </h4>
                  <?php
                  $qurys=mysqli_query($con,"select sum(tblorders.Quantity*tblproducts.ProductPrice) as yesterday  from tblorders join tblproducts on tblproducts.id=tblorders.ProductId where date(tblorders.InvoiceGenDate)=CURDATE()-1");
                  $rw=mysqli_fetch_array($qurys);
                  ?>
                  <h2 class="mb-5"><?php echo number_format($rw['yesterday'],2);?></h2>
                </div>
              </div>
            </div>
           
          </div>
         </div>
         <?php// } ?>
        
              
                <div class="main-panel">
        <div class="">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="modal-header">
                  <h5 class="modal-title" style="float: left;">Recent Invoice</h5>
                </div>
                
                <div class="card-body table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                   <thead>
                    <tr>
                      <th>#</th>
                      <th>Invoice Number</th>
                      <th>Customer Name</th>
                      <th>Customer Contact no.</th>
                      <th>Payment Mode</th>
                      <th>Payment Date</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $rno=mt_rand(10000,99999); 
                    $sql="select distinct InvoiceNumber,CustomerName,CustomerContactNo,PaymentMode,InvoiceGenDate    from tblorders ORDER BY id DESC";
                    $query = $dbh -> prepare($sql);
                    $query->execute();
                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                    $cnt=1;
                    if($query->rowCount() > 0)
                    {
                      foreach($results as $row)
                      {  
                        ?>
                        <tr>
                          <td><?php echo $cnt;?></td>

                          <td class="font-w600"><?php  echo htmlentities($row->InvoiceNumber);?></td>
                          <td class="font-w600"><?php  echo htmlentities($row->CustomerName);?></td>
                          <td class="font-w600">0<?php  echo htmlentities($row->CustomerContactNo);?></td>
                          <td class="font-w600"><?php  echo htmlentities($row->PaymentMode);?></td>
                          <td class="font-w600"><?php  echo htmlentities(date("d-m-Y", strtotime($row->InvoiceGenDate)));?></td>
                          
                        </tr>

                        <?php 
                        $cnt++;
                      }
                    }?>
                  </tbody>                  
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
        </div>

        
        
        <?php @include("includes/footer.php");?>
        
      </div>
      
    </div>
    
  </div>
  
  <?php  @include("includes/foot.php");?>
  <script >
    $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

    var areaChartData = {
      labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      datasets: [
      {
        label               : 'Digital Goods',
        backgroundColor     : 'rgba(60,141,188,0.9)',
        borderColor         : 'rgba(60,141,188,0.8)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
        data                : [28, 48, 40, 19, 86, 27, 90]
      },
      {
        label               : 'Electronics',
        backgroundColor     : 'rgba(200, 150, 30, 1)',
        borderColor         : 'rgba(210, 214, 222, 1)',
        pointRadius         : false,
        pointColor          : 'rgba(210, 214, 222, 1)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(220,220,220,1)',
        data                : [66, 59, 80, 81, 56, 55, 41]
      },
      ]
    }

    var areaChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          }
        }]
      }
    }

    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(areaChartCanvas, { 
      type: 'bar',
      data: areaChartData, 
      options: areaChartOptions
    })

    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
    var lineChartOptions = jQuery.extend(true, {}, areaChartOptions)
    var lineChartData = jQuery.extend(true, {}, areaChartData)
    lineChartData.datasets[0].fill = false;
    lineChartData.datasets[1].fill = false;
    lineChartOptions.datasetFill = false

    var lineChart = new Chart(lineChartCanvas, { 
      type: 'line',
      data: lineChartData, 
      options: lineChartOptions
    })

    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    
    var donutData        = {
      labels: [
      'Chrome', 
      'IE',
      'FireFox', 
      'Safari', 
      'Opera', 
      'Navigator', 
      ],
      datasets: [
      {
        data: [700,500,400,600,300,100],
        backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
      }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var donutChart = new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions      
    })

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.

    // var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    // var pieData        = donutData;
    // var pieOptions     = {
    //   maintainAspectRatio : false,
    //   responsive : true,
    // }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var pieChart = new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions      
    })

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = jQuery.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    var barChart = new Chart(barChartCanvas, {
      type: 'bar', 
      data: barChartData,
      options: barChartOptions
    })

    //---------------------
    //- STACKED BAR CHART -
    //---------------------
    var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
    var stackedBarChartData = jQuery.extend(true, {}, barChartData)

    var stackedBarChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      scales: {
        xAxes: [{
          stacked: true,
        }],
        yAxes: [{
          stacked: true
        }]
      }
    }

    var stackedBarChart = new Chart(stackedBarChartCanvas, {
      type: 'bar', 
      data: stackedBarChartData,
      options: stackedBarChartOptions
    })
  })
// $(document).ready(function () {
//   showGraph();
// });


// function showGraph()
// {
//   {
//     $.post("data.php",
//       function (data)
//       {
//         console.log(data);
//         var name = [];
//         var marks = [];

//         for (var i in data) {
//           name.push(data[i].ServiceName);
//           marks.push(data[i].population);
//         }
//         var barChartOptions = {
//           responsive              : true,
//           maintainAspectRatio     : false,
//           datasetFill             : false,
//           scales:{
//             yAxes:[{
//                 ticks:{
//                     beginAtZero: true
//                 }
//             }]
//           }
//         }

//           var chartdata = {
//             labels: name,
//             datasets: [
//             {
//               label: 'Student Marks',
//               backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
//               borderColor: '#46d5f1',
//               hoverBackgroundColor: '#CCCCCC',
//               hoverBorderColor: '#666666',
//               data: marks
//             }
//             ]
//           };


//           var graphTarget = $("#graphCanvas");

//           var barGraph = new Chart(graphTarget, {
//             type: 'bar',
//             data: chartdata,
//             options: barChartOptions
//           });
//         });
//   }
// }


$(document).ready(function(){
  $.ajax({
    url: "data.php",
    method: "GET",
    success: function(data){
      console.log(data);
      var name = [];
      var marks = [];

      for (var i in data){
        name.push(data[i].Sector);

        marks.push(data[i].total);
      }
      var chartdata = {
        labels: name,
        datasets: [{
          label: 'student marks',
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
          borderColor: 'rgba(134, 159, 152, 1)',
          hoverBackgroundColor: 'rgba(230, 236, 235, 0.75)',
          hoverBorderColor: 'rgba(230, 236, 235, 0.75)',
          data: marks

        }]
      };
      var graphTarget = $("#graphCanvas");
      var barGraph = new Chart(graphTarget, {
        type: 'bar',
        data: chartdata,
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          }
        }
      });
    },
    error: function(data) {
      console.log(data);
    }

  });
});

$(document).ready(function () {
  showGraph2();
});
function showGraph2()
{
  {
    $.post("data.php",
      function (data)
      {
        console.log(data);
        var name = [];
        var marks = [];

        for (var i in data) {
          name.push(data[i].Sector);
          marks.push(data[i].total);
        }

        var chartdata = {
          labels: name,
          datasets: [
          {
            label: 'Student Marks',
            backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
            // borderColor: '#46d5f1',
            hoverBackgroundColor: '#CCCCCC',
            hoverBorderColor: '#666666',
            data: marks
          }
          ]
        };

        var graphTarget = $("#graphCanvas2");

        var pieChart = new Chart(graphTarget, {
          type: 'pie',
          data: chartdata
        });
      });
  }
}

</script>
<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Chik',     11],
          ['Birds',      2],
          ['Meat',  2],
          ['Egg', 2]
        ]);

        var options = {
          title: 'Farm Store'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
<script >
  $(document).ready(function(){
    $.ajax({
      url: "data.php",
      method: "GET",
      success: function(data){
        console.log(data);
        var name = [];
        var marks = [];

        for (var i in data){
          name.push(data[i].Sector);

          marks.push(data[i].total);
        }
        var chartdata = {
          labels: name,
          datasets: [{
            label: 'student marks',
            backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
            borderColor: 'rgba(134, 159, 152, 1)',
            hoverBackgroundColor: 'rgba(230, 236, 235, 0.75)',
            hoverBorderColor: 'rgba(230, 236, 235, 0.75)',
            data: marks

          }]
        };
        var graphTarget = $("#graphCanvas");
        var barGraph = new Chart(graphTarget, {
          type: 'bar',
          data: chartdata,
          options: {
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero: true
                }
              }]
            }
          }
        });
      },
      error: function(data) {
        console.log(data);
      }

    });
  });



  $(document).ready(function(){
    $.ajax({
      url: "data.php",
      method: "GET",
      success: function(data){
        console.log(data);
        var name = [];
        var marks = [];

        for (var i in data){
          name.push(data[i].Sector);

          marks.push(data[i].total);
        }
        var chartdata = {
          labels: name,
          datasets: [{
            label: 'No of Bids',
            backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
            borderColor: 'rgba(134, 159, 152, 1)',
            hoverBackgroundColor: 'rgba(230, 236, 235, 0.75)',
            hoverBorderColor: 'rgba(230, 236, 235, 0.75)',
            data: marks

          }]
        };
        var graphTarget = $("#graphCanvas3");
        var barGraph = new Chart(graphTarget, {
          type: 'bar',
          data: chartdata,
          options: {
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero: true
                }
              }]
            }
          }
        });
      },
      error: function(data) {
        console.log(data);
      }

    });
  });





  $(document).ready(function(){
    $.ajax({
      url: "data1.php",
      method: "GET",
      success: function(data1){
        console.log(data1);
        var name = [];
        var marks = [];

        for (var i in data1){
          name.push(data1[i].Status);

          marks.push(data1[i].total);
        }
        var chartdata = {
          labels: name,
          datasets: [{
            label: 'No of bids',
            backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
            borderColor: 'rgba(134, 159, 152, 1)',
            hoverBackgroundColor: 'rgba(230, 236, 235, 0.75)',
            hoverBorderColor: 'rgba(230, 236, 235, 0.75)',
            data: marks

          }]
        };
        var graphTarget = $("#graphCanvas4");
        var barGraph = new Chart(graphTarget, {
          type: 'bar',
          data: chartdata,
          options: {
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero: true
                }
              }]
            }
          }
        });
      },
      error: function(data) {
        console.log(data);
      }

    });
  });




  $(document).ready(function(){
    $.ajax({
      url: "data2.php",
      method: "GET",
      success: function(data2){
        console.log(data2);
        var name = [];
        var marks = [];

        for (var i in data2){
          name.push(data2[i].Source);

          marks.push(data2[i].total);
        }
        var chartdata = {
          labels: name,
          datasets: [{
            label: 'No of bids',
            backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
            borderColor: 'rgba(134, 159, 152, 1)',
            hoverBackgroundColor: 'rgba(230, 236, 235, 0.75)',
            hoverBorderColor: 'rgba(230, 236, 235, 0.75)',
            data: marks

          }]
        };
        var graphTarget = $("#graphCanvas5");
        var barGraph = new Chart(graphTarget, {
          type: 'bar',
          data: chartdata,
          options: {
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero: true
                }
              }]
            }
          }
        });
      },
      error: function(data) {
        console.log(data);
      }

    });
  });



  $(document).ready(function(){
    $.ajax({
      url: "data3.php",
      method: "GET",
      success: function(data3){
        console.log(data3);
        var name = [];
        var marks = [];

        for (var i in data3){
          name.push(data3[i].Newspaper);

          marks.push(data3[i].total);
        }
        var chartdata = {
          labels: name,
          datasets: [{
            label: 'No of Bids',
            backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
            borderColor: 'rgba(134, 159, 152, 1)',
            hoverBackgroundColor: 'rgba(230, 236, 235, 0.75)',
            hoverBorderColor: 'rgba(230, 236, 235, 0.75)',
            data: marks

          }]
        };
        var graphTarget = $("#graphCanvas6");
        var barGraph = new Chart(graphTarget, {
          type: 'bar',
          data: chartdata,
          options: {
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero: true
                }
              }]
            }
          }
        });
      },
      error: function(data) {
        console.log(data);
      }

    });
  });

</script>

</body>
</html>


