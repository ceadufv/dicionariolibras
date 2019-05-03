<div class="blocks" id="units">
<?php
  $units = new WP_Query(array(
    'post_type' => 'units',
    'post_status' => 'publish',
    'posts_per_page' => -1
  ));


  while ($units->have_posts()): $units->the_post();
?>
  <a href="<?php the_permalink(); ?>">
    <div class="block pangolin hvr-float">
      <img src="<?php $icone = get_field('icone'); echo $icone['url']; ?>" alt="Ícone da unidade <?php the_title(); ?>">
      <span><?php the_title(); ?></span>
    </div>
  </a>
<?php
  endwhile;
  wp_reset_query();
?>
</div>
