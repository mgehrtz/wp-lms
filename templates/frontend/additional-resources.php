<?php

defined('ABSPATH') || die;

?>

<div class="resource-wrapper">

  <?php foreach ( $resources as $resource ): ?>

    <a href="<?= get_field( 'external_url', $resource ) ?>" class="resource" target="_blank"><span class="category"><?= get_the_terms( $resource, 'resource-type' )[0]->name ?></span><?= get_the_title( $resource ) ?></a>

  <?php endforeach; ?>

</div>