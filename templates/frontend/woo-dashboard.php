<?php
  $current_user = wp_get_current_user();
  $course_ids = get_purchased_course_ids();
?>

<h1>Hello, <?= $current_user->display_name ?>.</h1>
<h2>Enrolled Courses</h2>
<div class="course-wrapper">
  <?php 
    if(count($course_ids) < 1): 
  ?>
  <p class="no-course-alert">It looks like you haven't purchased a course yet. When you have purchased a course, it will appear in this section.</p>
  <?php else:
    foreach($course_ids as $course_id):
      $term = get_term( $course_id );
  ?>
  <a href="<?= get_term_link($term) ?>" class="course-link"><?= $term->name ?></a>
  <?php 
    endforeach; 
    endif; 
  ?>
</div>