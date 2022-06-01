<?php get_header(); ?>

<?php

function getNews()
{
    $newsArr = [];
    $newsQuery = new WP_Query(['post_type' => 'news']);
    while ($newsQuery->have_posts()) {
        $news = [];
        $newsQuery->the_post();
        $news['newsTitle'] = get_the_title();
        $news['newsText'] = get_post_field('_crb_news_text', get_the_ID());
        $news['newsDate'] = get_post_field('_crb_news_date', get_the_ID());
        $news['imageSrc'] = wp_get_attachment_url(get_post_field('_crb_news_image', get_the_ID()));
        $newsArr[] = $news;
    }

    return $newsArr;
}

function drawNews($newsArray)
{
    $PLACEHOLDER_IMAGE_PATH = 'http://localhost/wordpress/wp-content/uploads/2022/06/no_image_placeholder.jpg';
    echo "<div class='m-5 d-flex justify-content-center flex-wrap'>";
    foreach ($newsArray as $news) {
        $imageSrc = $news['imageSrc'];
        $newsTitle = $news['newsTitle'];
        $newsText = $news['newsText'];
        $newsDate = $news['newsDate'];
        echo "<div class='card m-2' style='width: 18rem;'>";
        if ($imageSrc) {
            echo "<img class='card-img-top' src='$imageSrc' alt='Card image cap'>";
        } else {
            echo "<img class='card-img-top' src='$PLACEHOLDER_IMAGE_PATH' alt='Card image cap'>";
        }
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'>Заголовок: $newsTitle</h5>";
        echo "<p class='card-text'>Текст новости: $newsText</p>";
        echo "<p class='card-text'>Дата новости: $newsDate</p>";
        echo "<a href='#' class='btn btn-primary' style='display: flex; justify-content: center'>Watch</a>";
        echo "</div>";
        echo "</div>";
    }
    echo "</div>";
}

function sortNewsByDate($news)
{
    $dates = array_column($news, 'newsDate');
    array_multisort($dates, SORT_DESC, $news);
    return $news;
}

function setupNewsPage()
{
    $news = getNews();
    $sortedNews = sortNewsByDate($news);
    drawNews($sortedNews);
}

function getProducts()
{
    $productsArr = [];
    $productsQuery = new WP_Query(['post_type' => 'product']);
    while ($productsQuery->have_posts()) {
        $product = [];
        $productsQuery->the_post();
        $product['productTitle'] = get_the_title();
        $product['productDescription'] = get_post_field('_crb_product_description', get_the_ID());
        $product['productGallery'] = carbon_get_post_meta(get_the_ID(), 'crb_product_gallery');
        $product['productEquipment'] = get_post_field('_crb_product_equipment', get_the_ID());
        $product['productMaker'] = get_post_field('_crb_product_maker', get_the_ID());
        $product['productPrice'] = get_post_field('_crb_product_price', get_the_ID());
        $productsArr[] = $product;
    }

    return $productsArr;
}

function drawProducts($productsArray)
{
    echo "<div class='m-5 d-flex justify-content-center flex-wrap'>";
    foreach ($productsArray as $product) {
        $firstGalleryImage = wp_get_attachment_image_url($product['productGallery'][0]);
        $productTitle = $product['productTitle'];
        $productDescription = $product['productDescription'];
        $productEquipment = $product['productEquipment'];
        $productMaker = $product['productMaker'];
        $productPrice = $product['productPrice'];
        echo "<div class='card m-2' style='width: 18rem;'>";
        if ($firstGalleryImage) {
            echo "<img class='card-img-top' src='$firstGalleryImage' alt='Card image cap'>";
        }
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'>Название: $productTitle</h5>";
        echo "<p class='card-text'>Описание: $productDescription</p>";
        echo "<p class='card-text'>Комплектация: $productEquipment</p>";
        echo "<p class='card-text'>Производитель: $productMaker</p>";
        echo "<p class='card-text'>Стоимость: $productPrice</p>";
        echo "<a href='#' class='btn btn-primary' style='display: flex; justify-content: center'>Buy</a>";
        echo "</div>";
        echo "</div>";
    }
    echo "</div>";
}

function sortProductsByPrice($products)
{
    $prices = array_column($products, 'productPrice');
    array_multisort($prices, SORT_ASC, $products);
    return $products;
}

function setupProductsPage()
{
    $products = getProducts();
    $sortedProducts = sortProductsByPrice($products);
    drawProducts($sortedProducts);
}

function getFirstThreeNews()
{
    $news = getNews();
    $sortedNews = sortNewsByDate($news);
    return array_slice($sortedNews, 0, 3);
}

function getFirstThreeCheapProducts()
{
    $products = getProducts();
    $sortedProducts = sortProductsByPrice($products);
    return array_slice($sortedProducts, 0, 3);
}

?>

    <div class="m-5">
        <?php
        if (have_posts()) {
            while (have_posts()) {
                the_post();
                the_content();
            }
        }
        ?>
    </div>


<?php
if (get_the_title() === 'Главная') {
    echo '<h2 class="text-center">First three news</h2>';
    echo drawNews(getFirstThreeNews());
    echo '<h2 class="text-center">First three cheapest products</h2>';
    echo drawProducts(getFirstThreeCheapProducts());
} elseif (get_the_title() === 'Новости') {
    setupNewsPage();
} elseif (get_the_title() === 'Продукция') {
    setupProductsPage();
}
?>

<?php get_footer(); ?>