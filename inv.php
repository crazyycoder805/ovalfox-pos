<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
    @media print {
        .hide {
            display: none;
        }
    }

    body {
        font-family: Arial, sans-serif;
    }

    .product {
        margin-bottom: 20px;
    }

    .pagination {
        margin-top: 20px;
    }

    .pagination a {
        padding: 5px 10px;
        margin: 0 5px;
        border: 1px solid #ccc;
        text-decoration: none;
        color: #333;
    }

    .pagination a.active {
        background-color: #333;
        color: #fff;
    }
    </style>
</head>
<?php
// Assuming $products is an array containing all your products
// Function to generate random products
function generateRandomProduct() {
    $names = ['Product A', 'Product B', 'Product C', 'Product D', 'Product E'];
    $descriptions = ['Lorem ipsum dolor sit amet', 'Consectetur adipiscing elit', 'Sed do eiusmod tempor incididunt', 'Ut labore et dolore magna aliqua', 'Ut enim ad minim veniam'];
    $prices = [10.99, 20.49, 15.79, 30.99, 25.99];

    $name = $names[array_rand($names)];
    $description = $descriptions[array_rand($descriptions)];
    $price = $prices[array_rand($prices)];

    return ['name' => $name, 'description' => $description, 'price' => $price];
}

// Generate 40 random products
$products = [];
for ($i = 0; $i < 40; $i++) {
    $products[] = generateRandomProduct();
}

// Pagination code...
$perPage = 5;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$totalPages = ceil(count($products) / $perPage);

$start = ($page - 1) * $perPage;
$end = $start + $perPage;
$productsToShow = array_slice($products, $start, $perPage);
?>

<body>
    <div id="invoice">
        <div class="hide"><?php foreach ($productsToShow as $product): ?></div>

        <div class="product">
            <h2><?php echo $product['name']; ?></h2>
            <p><?php echo $product['description']; ?></p>
            <p><?php echo $product['price']; ?></p>
        </div>
        <div class="hide">
            <?php endforeach; ?>
        </div>
    </div>

    <div class="pagination">
        <?php if ($page > 1): ?>
        <a href="?page=<?php echo ($page - 1); ?>">Previous</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?php echo $i; ?>" <?php if ($i == $page) echo 'class="active"'; ?>><?php echo $i; ?></a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
        <a href="?page=<?php echo ($page + 1); ?>">Next</a>
        <?php endif; ?>
    </div>

    <script>
    // This script ensures that when printing, it automatically goes to the next page
    window.onload = function() {
        var printingCss = document.createElement('style');
        printingCss.innerHTML =
            '@media print { .pagination { display: none; } @page { size: A4 portrait; margin: 10mm; } }';
        document.head.appendChild(printingCss);
    };
    </script>
</body>

</html>