<?php
  defined('ABSPATH') || die;
  wp_enqueue_script(
    'thegift_tabs_script', 
    THEGIFT_PLUGIN_ROOT . '/wc-dashboard/js/tabs.js', 
    ['jquery'], 
    '1.1', 
    true
  );
  wp_enqueue_style(
    'thegift_tabs_style',
    THEGIFT_PLUGIN_ROOT . '/wc-dashboard/css/tabs.css', 
    [], 
    '1.0', 
    'all'
  );
?>

<div class="resources-wrapper">
  <div class="tabs-wrapper">
    <?php foreach ( $tab_content as $id => $tab ): ?>
      <button class="tab-handle<?= ( $id === array_key_first( $tab_content ) ) ? ' active' : '' ?>" data-tab-id="<?= $id ?>">
        <?= $tab['term']->name ?>
      </button>
    <?php endforeach; ?>
  </div>
  <?php foreach ( $tab_content as $id => $tab ): ?>
    <div class="tab-content<?= ( $id === array_key_first( $tab_content ) ) ? ' active' : '' ?>" style="display: none;" data-tab-content-id="<?= $id ?>">
      <?php foreach( $tab['children'] as $resource_group ): ?>
      <h3 class="resource-category"><?= $resource_group['term']->name ?></h3>
      <div class="resource-category-wrapper">
        <?php 
          if( ! empty( $resource_group['resources'] ) ): 
          foreach( $resource_group['resources'] as $resource ): 
          if( get_field( 'resource_format', $resource ) === 'ext_url' ):
        ?>
        <a href="<?= get_field( 'external_url', $resource ) ?>" class="resource" target="_blank"><?= get_the_title( $resource ) ?></a>
        <?php 
          elseif ( get_field( 'resource_format', $resource ) === 'html' ):
        ?> 
        <div class='general-content'><?= get_field( 'resource_content', $resource ) ?></div>
        <?php
          endif;
          endforeach; 
          else: 
        ?>
          <p class='empty-info'>There are no resources of this type at this time, but check back soon! There's more to come...</p>
        <?php endif; ?>
      </div>
      <?php endforeach; ?>
    </div>
  <?php endforeach; ?>
</div>