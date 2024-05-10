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


<script src="assets/js/customSelect.js"></script>
<script src="assets/js/custom.js"></script>

<script>
$(document).ready(function() {
    $('#example1').DataTable();
    $('#example2').DataTable();
    $('#example9').DataTable();

    $("#customer_name").select2();
    $(".booker-select").select2();

    $("#product").select2();
    $("#item_names").select2();
    // $("#company_name").select2();
    $("#last_rate").select2();
    $("#book").select2();


});
</script>


<?php 
if ($name == "index.php") {
?>
<script src="assets/js/apexchart/apexcharts.min.js"></script>
<script src="assets/js/apexchart/chart.js"></script>

<?php 

?>
<script>
$(document).ready(e => {
    function chartL() {
        var options = {
            chart: {
                width: 1000,
                type: 'bar',
                fontFamily: 'Poppins, sans-serif',
                toolbar: {
                    show: true
                },
                zoom: {
                    enabled: true
                },
            },
            plotOptions: {
                bar: {
                    horizontal: false // Set to true if you want horizontal bars
                }
            },
            dataLabels: {
                enabled: true // If you want data labels, set this to true
            },
            xaxis: {
                categories: ['Customers', 'Today orders', 'Total sales'
                , 'Total revenue'
                , 'Today sales'
                , 'Today purchase'
                , 'Today gernel expenses'
                ], // X-axis labels
                labels: {
                    style: {
                        colors: '#000000' // Black color for labels
                    }
                }
            },
            yaxis: {
                title: {
                    text: 'Value' // Y-axis label
                }
            },
            colors: ['#1b4962', '#1b4962', '#1b4962'], // Blue color for bars
            series: [{
                name: 'Value',
                data: [<?php echo $total_customers; ?>, <?php echo $today_orders; ?>,
                    <?php echo $total_sales; ?>,
                    <?php echo $total_amount; ?>,
                    <?php echo $today_sales; ?>,
                    <?php echo $today_purchase; ?>,
                    <?php echo $today_gernel_expenses; ?>
                ]
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