<?php
get_header();
enqueue_course_stylesheet();
$term = get_queried_object();
$lesson_ids = get_lesson_ids_by_course( $term->term_id );
$associated_product_id = get_field('associated_product', "course_{$term->term_id}");
$image = wp_get_attachment_image_src( get_post_thumbnail_id( $associated_product_id ), 'single-post-thumbnail' );
$progress = get_user_meta( get_current_user_id(), 'progress', true );
?>

<div class="wrapper">
  <div class='left'>
    <div class='course-image' style="background-image: url(<?= $image[0] ?>)"></div>
  </div>
  <div class='right'>
    <div class="header">
      <h3>Progress</h3>
      <h1><?= $term->name ?></h1>
    </div>
    <div class="class-list">
      <ol>
        <?php foreach ( $lesson_ids as $lesson_id ): ?>
          <li>
            <a class="class-wrap" href="<?= get_permalink( $lesson_id ) ?>">
              <span class="link-title"><?= get_the_title( $lesson_id ) ?></span>
              <span class="type"><?= get_field('type', $lesson_id) ?></span>
            </a>
            <div class="progress-marker <?= get_progress_marker_class( $lesson_id, $progress ) ?>"></div>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>
  </div>
</div>

<?php
get_footer();
