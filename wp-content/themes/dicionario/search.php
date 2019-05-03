<?php get_header(); ?>

<main>
  <div class="content">
    <div class="container search">
      <div class="row">
        <div class="col-md-12">
          <h2>Resultados da pesquisa por "<?php the_search_query(); ?>"</h2>

          <?php if(have_posts()): ?>

            
              <?php while(have_posts()): the_post();?>
                <a href="<?php the_permalink(); ?>">
                  <h4><?php the_title(); ?></h4>
                  <?php the_excerpt(); ?>
                </a>
              <?php endwhile; ?>
            

            <nav>
              <ul class="pager">
                <li class="previous"><?php previous_posts_link( '<span aria-hidden="true">&larr;</span> Página anterior' ); ?></li>
                <li class="next"><?php next_posts_link( 'Próxima página <span aria-hidden="true">&rarr;</span>' ); ?></li>
              </ul>
            </nav>
          <?php else: ?>
            <p>Nenhum resultado encontrado para o que você procura. Por favor, tente novamente.</p>
          <?php endif; ?>
        </div>

        <div class="col-sm-4 col-md-3 left">
          <div class="sidebar news">
            <?php get_template_part('news_sidebar'); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<?php get_footer(); ?>
