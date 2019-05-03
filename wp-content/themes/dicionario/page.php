<?php get_header(); ?>

<main>
  <div class="container">
    <div class="row">
      <div class="boxResults boxSingle">
        <div class="col-md-12">
          <div class="termSingleLinks">
            <h3>
            <span><?php the_title(); ?></span>
          </h3>
        </div>
      </div>
      <div class="col-md-12">
        <div class="content">
          <section class="single">
            <?php the_content(); ?>
            <?php edit_post_link(); ?>
          </section>
        </div>
      </div>
    </div>
  </div>
</div>
</main>

<?php get_footer(); ?>
