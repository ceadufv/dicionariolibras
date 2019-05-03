<?php get_header(); ?>

<main>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="title">
					<h1>SEM USO!!!!</h1>
					<h2><?php the_title(); ?></h2>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="content">
					
					<?php wp_list_categories( array('taxonomy' => 'temas', 'title_li' => '', 'style'=> '')); ?>

					<?php 
						$custom_terms = get_terms('temas');

						foreach($custom_terms as $custom_term) {
							wp_reset_query();
							$args = array('post_type' => 'cadastros',
								'tax_query' => array(
									array(
										'taxonomy' => 'temas',
										'field' => 'slug',
										'terms' => $custom_term->slug,
										),
									),
								);

							$loop = new WP_Query($args);
							if($loop->have_posts()) {
								echo '<h2>'.$custom_term->name.'</h2>';

								while($loop->have_posts()) : $loop->the_post();
								echo '<a href="'.get_permalink().'">'.get_the_title().'</a>';
								endwhile;
							}
						}
					?>

					<?php the_content(); ?>

					<?php edit_post_link(); ?>

				</div>
			</div>
		</div>
	</div>

	<div class="container">


	</div>

</main>

<section class="units">
	<div class="container-fluid">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="content">
						<h2 class="text-center">Conheça<br />as unidades</h2>
						<?php get_template_part('partials/units', 'blocks'); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
