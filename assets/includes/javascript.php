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

<script src="assets/js/apexchart/apexcharts.min.js"></script>
<script src="assets/js/apexchart/chart.js"></script>

<?php 
$sales_1 = $pdo->read("sales_1", ['company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);
$sales_2 = $pdo->read("sales_2", ['company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);
$total_sales = count($sales_1) + count($sales_2);

$purchases_1 = $pdo->read("purchases_1", ['company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);
$purchases_2 = $pdo->read("purchases_2", ['company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);
$total_purchase = count($purchases_1) + count($purchases_2);

$gernel_expenses = count($pdo->read("gernel_expenses", ['company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]));


?>
<script>
$(document).ready(e => {
    function chartL() {
        var options = {
            chart: {
                width: 360,
                type: 'pie',
                fontFamily: 'Poppins, sans-serif',
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: false
                },
            },
            labels: ['Sales', 'Purchase', 'Gernel Expenses'],
            series: [+<?php echo $total_sales; ?>, +<?php echo $total_purchase; ?>, +
                <?php echo $gernel_expenses; ?>
            ],
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200,
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }],
            colors: ['#1b4962', '#ffa000', '#00a3ff']
        }

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