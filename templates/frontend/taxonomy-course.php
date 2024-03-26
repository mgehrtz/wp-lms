<?php
get_header();
$term = get_queried_object();

?>

<h1><?= $term->name ?></h1>

<?php
get_footer();
