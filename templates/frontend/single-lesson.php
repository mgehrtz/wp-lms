<?php

  defined('ABSPATH') || die;
  
  enqueue_lesson_stylesheet();
  get_header();
  global $post;
  $course_ids = get_purchased_course_ids();
  track_course_progress();
  if( get_field('type') === 'Application'){
    get_user_answers( $post->ID );
  }
?>

<div class="wrapper">
  <?php if( count( $course_ids ) ): ?>
  <div class="sidebar">
    <?php 
      foreach ( $course_ids as $course_id ):  
        $term = get_term( $course_id ); 
    ?>
    <div class="course-nav">
      <a class="course-link" href="<?= get_term_link( $course_id ) ?>"><?= $term->name ?></a>
      <div class="course-link-wrap">
        <?php
          $lesson_ids = get_lesson_ids_by_course( $course_id );
          foreach( $lesson_ids as $lesson_id ):
        ?>
        <a class="lesson-link <?= ($post->ID === $lesson_id) ? 'active-link' : '' ?>" href="<?= get_permalink( $lesson_id ) ?>">
          <?php if( get_field('type', $lesson_id) !== "Info" ): ?>
            <span class="type">
              <?= get_field('type', $lesson_id); ?>
            </span>
          <?php endif; ?>
          <?= get_the_title( $lesson_id ) ?>
        </a>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endforeach; ?>
    <div class="footer-links"></div>
  </div>
  <?php endif; ?>
  <div class="lesson">
    <div class="header">
      <?php if( get_field('type') !== "Info" ): ?>
      <h4 class="subtitle"><?= get_field('type') ?></h4>
      <?php endif; ?>
      <h1 class="title"><?= get_the_title() ?></h1>
      <div class="quote"><?php if(has_excerpt()): the_excerpt(); endif; ?></div>
    </div>
    <div class="content"><?= apply_filters( 'the_content', get_the_content() ) ?></div>
    <div class="course-nav-buttons">
      <?php 
        $prev_post = get_next_post(); // post order is technically reversed 
        $next_post = get_previous_post(); 
      ?>
      <?php if($prev_post): ?>
        <a class="nav-button prev" href="<?= get_the_permalink( $prev_post ) ?>">
          <span class="type">Previous</span>
          <?php
            if( get_field('type', $prev_post->ID) !== "Info" ){
              echo get_field('type', $prev_post->ID) . ": ";
            }
          ?>
          <?= get_the_title( $prev_post ) ?>
        </a>
      <?php else: ?>
        <div></div>
      <?php endif; ?>
      <?php if($next_post): ?>
        <a class="nav-button next" href="<?= get_the_permalink( $next_post ) ?>?complete=<?= $post->ID ?>">
          <span class="type">Next</span>
          <?php
            if( get_field('type', $next_post->ID) !== "Info" ){
              echo get_field('type', $next_post->ID) . ": ";
            }
          ?>
          <?= get_the_title( $next_post ) ?>
        </a>
      <?php else: ?>
        <a class="nav-button next" href="/my-account?complete=<?= $post->ID ?>">
          <span class="type">Complete Course</span>
          <?= get_the_terms( $post, 'course' )[0]->name ?>
        </a>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php
  get_footer();
?>
