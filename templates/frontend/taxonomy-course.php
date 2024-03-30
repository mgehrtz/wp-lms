<?php
get_header();
enqueue_course_stylesheet();
$term = get_queried_object();
$lesson_ids = get_lesson_ids_by_course( $term->term_id );
?>

<div class="wrapper">
  <div class="header">
    <h3>Progress</h3>
    <h1><?= $term->name ?></h1>
  </div>
  <div class="class-list">
    <?php foreach ( $lesson_ids as $lesson_id ): ?>
    <a class="class-wrap" href="<?= get_permalink( $lesson_id ) ?>">
      <span class="type"><?= get_field('type', $lesson_id) ?></span>
      <span class="link-title"><?= get_the_title( $lesson_id ) ?></span>
    </a>
    <?php endforeach; ?>
  </div>
</div>

<?php
get_footer();
