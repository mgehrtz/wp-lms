<?php
  $current_user = wp_get_current_user();
  $course_ids = get_purchased_course_ids();
?>

<h1>Hello, <?= $current_user->display_name ?>.</h1>
<h2>Enrolled Courses</h2>
<hr>
<div class="course-wrapper">
  <?php 
    if(count($course_ids) < 1): 
  ?>
  <p class="no-course-alert">It looks like you haven't purchased a course yet. When you have purchased a course, it will appear in this section.</p>
  <?php else:
    foreach($course_ids as $course_id):
      $term = get_term( $course_id );
      $product_id = get_field('associated_product', "course_{$course_id}");
      $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'single-post-thumbnail' );
  ?>
  <a href="<?= get_term_link($term) ?>" class="course-link" style="background-image: url(<?= $image[0] ?>)"><?= $term->name ?></a>
  <?php 
    endforeach; 
    endif; 
  ?>
</div>