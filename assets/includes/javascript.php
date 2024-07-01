<!-- Script Start -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/dt.js"></script>
<script src="assets/js/dataTables.responsive.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/swiper.min.js"></script>
<!--  -->
<!-- Page Specific -->
<script src="assets/js/nice-select.min.js"></script>
<!-- Custom Script -->


<script src="assets/js/selectCustom.js"></script>
<script src="assets/js/custom.js"></script>

<script>
$(document).ready(function() {
    $('#example1').DataTable();
    $('#example2').DataTable();
    $('#example9').DataTable();

    $(".customer-select").select2();
    $(".booker-select").select2();

    $("#product").select2();
    $("#item_names").select2();
    // $("#company_name").select2();
    $("#last_rate").select2();
    $("#book").select2();
    $("#customerPreviosTable").DataTable();


});
</script>


<?php 
if ($name == "index.php") {
?>
<script src="assets/js/apexchart/apexcharts.min.js"></script>

<?php 


// Extract dates and amounts
$dates = array_column($sales_2, 'date');
$amounts = array_column($sales_2, 'final_amount');

// Convert PHP arrays to JavaScript arrays
$dates_js = json_encode($dates);
$amounts_js = json_encode($amounts);
?>

<script>
$(document).ready(e => {
    function chartL() {
        var options = {
            chart: {
                type: 'area',
                fontFamily: 'Poppins, sans-serif',
                toolbar: {
                    show: true,
                    tools: {
                        download: true,
                        selection: true,
                        zoom: true,
                        zoomin: true,
                        zoomout: true,
                        pan: true,
                        reset: true
                    }
                },
                zoom: {
                    enabled: true
                },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800
                }
            },
            title: {
                text: 'Chart',
                align: 'left',
                style: {
                    fontSize: '20px',
                    color: '#000000'
                }
            },
            subtitle: {
                text: 'Sales chart',
                align: 'left',
                margin: 10,
                offsetX: 0,
                offsetY: 30,
                floating: false,
                style: {
                    fontSize: '14px',
                    color: '#666666'
                }
            },
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '12px',
                    colors: ['#000000']
                },
                formatter: function(val) {
                    return val.toFixed(2);
                }
            },
            xaxis: {
                categories: <?php echo $dates_js; ?>,
                labels: {
                    style: {
                        colors: '#000000',
                        fontSize: '12px'
                    }
                },
                title: {
                    text: 'Date',
                    style: {
                        color: '#000000',
                        fontSize: '14px'
                    }
                },
                crosshairs: {
                    show: true,
                    width: 1,
                    position: 'back',
                    opacity: 0.9,
                    stroke: {
                        color: '#b6b6b6',
                        width: 1,
                        dashArray: 3
                    }
                }
            },
            yaxis: [{
                title: {
                    text: 'Primary Value',
                    style: {
                        color: '#000000',
                        fontSize: '14px'
                    }
                },
                labels: {
                    style: {
                        colors: '#000000',
                        fontSize: '12px'
                    }
                }
            }, {
                opposite: true,
                title: {
                    text: 'Secondary Value',
                    style: {
                        color: '#000000',
                        fontSize: '14px'
                    }
                },
                labels: {
                    style: {
                        colors: '#000000',
                        fontSize: '12px'
                    }
                }
            }],
            tooltip: {
                enabled: true,
                theme: 'dark',
                x: {
                    format: 'dd MMM yyyy'
                },
                y: {
                    formatter: function(value) {
                        return 'Value: ' + value.toFixed(2);
                    },
                    title: {
                        formatter: function(seriesName) {
                            return seriesName + " (per unit): ";
                        }
                    }
                }
            },
            grid: {
                show: true,
                borderColor: '#e0e0e0',
                strokeDashArray: 4,
                xaxis: {
                    lines: {
                        show: true
                    }
                },
                yaxis: {
                    lines: {
                        show: true
                    }
                },
                padding: {
                    top: 10,
                    right: 30,
                    bottom: 10,
                    left: 10
                }
            },
            markers: {
                size: 5,
                colors: ['#1b4962'],
                strokeColor: '#ffffff',
                strokeWidth: 2,
                hover: {
                    size: 7
                }
            },
            colors: ['#1b4962'],
            series: [{
                name: 'Value',
                data: <?php echo $amounts_js; ?>
            }],
            legend: {
                show: true,
                position: 'top',
                horizontalAlign: 'right',
                floating: true,
                offsetY: -25,
                offsetX: -5,
                labels: {
                    colors: '#000000',
                    useSeriesColors: false
                },
                markers: {
                    width: 12,
                    height: 12,
                    strokeWidth: 0,
                    radius: 12
                }
            },
            annotations: {
                yaxis: [{
                    y: 30,
                    borderColor: '#ff4560',
                    label: {
                        borderColor: '#ff4560',
                        style: {
                            color: '#fff',
                            background: '#ff4560'
                        },
                        text: 'Y-axis annotation'
                    }
                }],
                xaxis: [{
                    x: new Date('01 Jan 2021').getTime(),
                    borderColor: '#775dd0',
                    label: {
                        borderColor: '#775dd0',
                        style: {
                            color: '#fff',
                            background: '#775dd0'
                        },
                        text: 'X-axis annotation'
                    }
                }]
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.9,
                    stops: [0, 90, 100]
                }
            },
            responsive: [{
                breakpoint: 600,
                options: {
                    chart: {
                        width: '100%'
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        var chart = new ApexCharts(
            document.querySelector("#chartL"),
            options
        );

        chart.render();
    }

    chartL();





    <?php 
    
    if ($_SERVER['SCRIPT_NAME'] == '/ovalfoxpos/food.php') {
    
    ?>
    $("body").toggleClass('mini-sidebar');
    $(this).toggleClass('checked');
    <?php } ?>


});
</script>
<?php } ?>