<?php
/**
* Oculta alguns itens do menu para tornar a navegação no painel administrativo mais fácil
**/
//wp_localize_script( 'my-ajax-request', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
add_action('wp_ajax_results', 'results');
add_action('wp_ajax_nopriv_results', 'results');
add_action('wp_ajax_wpdl_get_post_infos', 'wpdl_get_post_infos');
add_action('wp_ajax_nopriv_wpdl_get_post_infos', 'wpdl_get_post_infos');
add_action('wp_head','ajaxurl');
function ajaxurl() {
?>
<script type="text/javascript">
var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>
<?php
}

function filtrar($tax,$termo) {
  
  $args = array(
    'post_type' => 'cadastros',
    'orderby' => 'name',
    'posts_per_page' => -1,
    'order' => 'ASC',
    'tax_query' => array(
      array(
        'taxonomy' => $tax,
        'field' => 'slug',
        'terms' => $termo
        ),
      )
  );

  $loop = new WP_Query($args);

  $result = array();

  if($loop->have_posts()) {
    while($loop->have_posts()) : $loop->the_post();
        $result[] = array("id" => get_the_ID(), "title" => get_the_title(), "slug" => the_slug());
    endwhile;
  }
  
  return $result;
}

function wpdl_get_post_infos(){
  $cadastro_slug = $_POST['cadastro_slug'];
  $post_id= $_POST['id'];

  $p = get_post($post_id);
  $my_hand_term = wp_get_post_terms(intval($p->ID), 'configuracao_mao')[0];
	$my_hand_term_ID = $my_hand_term->term_id;

  $post = array(
    'title' => $p->post_title,
    'id' => $p->ID,
    'my_hand_term_ID' => $my_hand_term_ID
  );
  
  if(has_sub_fields('videos', $post_id)){
    //$post[] =  get_field('videos', $post_id);
    $link = explode('"', explode(" ", get_sub_field('link'))[2])[1];
    $post['videos'][] = $link;//str_replace(array("[", "/]"), array("<", " controls></video>"), get_sub_field('link'));
    
  }
  
  echo json_encode($post);
  exit;

  
}

function results() {
  $tax = $_POST['tax'];
  $termo = $_POST['termo'];
 

  $posts = get_terms(array('taxonomy'=>'configuracao_mao'));

  $data = filtrar($tax, $termo);

  echo json_encode($data);
  exit;
  }


global $actual_taxonomy;

function the_slug() {
  $post_data = get_post($post->ID, ARRAY_A);
  $slug = $post_data['post_name'];
  return $slug; 
}

function remove_menus(){
  //remove_menu_page( 'index.php' );                  //Dashboard
  //remove_menu_page( 'edit.php' );                   //Posts
  //remove_menu_page( 'upload.php' );                 //Media
  //remove_menu_page( 'edit.php?post_type=page' );    //Pages
  //remove_menu_page( 'edit-comments.php' );          //Comments
  //remove_menu_page( 'themes.php' );                 //Appearance
  //remove_menu_page( 'plugins.php' );                //Plugins
  //remove_menu_page( 'users.php' );                  //Users
  remove_menu_page( 'tools.php' );                  //Tools
  //remove_menu_page( 'options-general.php' );        //Settings
}
add_action( 'admin_menu', 'remove_menus' );
add_action( 'wp_ajax_nopriv_wpdl_first_post', 'wp_ajax_nopriv_wpdl_first_post' );

/**
* Função responsável por definir os Custom Post Types
**/
function create_post_type() {
  register_post_type( 'cadastros',
  // CPT Options
    array(
      'labels' => array(
        'name' => __( 'Cadastros' ),
        'singular_name' => __( 'Cadastro' )
      ),
      'supports' => array('title', 'editor'),
      'public' => true,
      'menu_icon' => 'dashicons-playlist-video',
      'menu_position' => 5,
      'has_archive' => true,
      //'taxonomies'  => array( 'category' ),
      //'rewrite' => array('slug' => 'cadastros')
    )
  );

  register_taxonomy('temas', 'cadastros', array(
      'hierarchical' => true, 
      'label' => 'Temas', 
      'show_ui' => true, 
      'query_var' => true, 
      'labels' => array ('add_new_item' => 'Adicionar'),
      'singular_label' => 'Tema') 
  );

  register_taxonomy('sinalario', 'cadastros', array(
      'hierarchical' => true, 
      'label' => 'Sinalário', 
      'show_ui' => true, 
      'query_var' => true, 
      'labels' => array ('add_new_item' => 'Adicionar'),
      'singular_label' => 'Sinalário') 
  );

  register_taxonomy('configuracao_mao', 'cadastros', array(
      //'hierarchical' => true, 
      'label' => 'Configuração de mão', 
      'show_ui' => true, 
      'query_var' => true, 
      'labels' => array ('add_new_item' => 'Adicionar'),
      //'rewrite' => array('slug' => 'product/brands'),
      'singular_label' => 'Configuração de mão') 
  );
}
add_action( 'init', 'create_post_type' );


/**
  *
  * Direciona o link da categoria para o arquivo single-cadastros.php 
  *
*/
add_action('template_redirect', 'wpdl_first_post');

function wpdl_first_post(){
  global $wp_query;
  global $post;

  global $wp;
  if (isset($_GET['temas'])) {
    $tema = $_GET['temas'];
    $args = array(
      'post_type' => 'cadastros',
      'posts_per_page' => 1,
      'orderby' => 'name',
      'order' => 'ASC',
      'tax_query' => array(
        array(
          'taxonomy' => 'temas',
          'field' => 'slug',
          'terms' => $tema
        )
      )
    );
    $first_post = get_posts($args);
    print_r($first_post);
    foreach($first_post as $post) : setup_postdata($post);
      wp_redirect(get_permalink($post)."&term=temas&value=".$tema);
    exit;
    endforeach;
  }
  else if (isset($_GET['sinalario'])) {
    $sinalario = $_GET['sinalario'];
    $args = array(
      'post_type' => 'cadastros',
      'posts_per_page' => 1,
      'orderby' => 'name',
      'order' => 'ASC',
      'tax_query' => array(
        array(
          'taxonomy' => 'sinalario',
          'field' => 'slug',
          'terms' => $sinalario
        )
      )
    );
    $first_post = get_posts($args);
    print_r($first_post);
    foreach($first_post as $post) : setup_postdata($post);
      wp_redirect(get_permalink($post)."&term=sinalario&value=".$sinalario);
    exit;
    endforeach;
  }
  else if (isset($_GET['configuracao_mao'])) {
    $configuracao_mao = $_GET['configuracao_mao'];
    $args = array(
      'post_type' => 'cadastros',
      'posts_per_page' => 1,
      'orderby' => 'name',
      'order' => 'ASC',
      'tax_query' => array(
        array(
          'taxonomy' => 'configuracao_mao',
          'field' => 'slug',
          'terms' => $configuracao_mao
        )
      )
    );
    $first_post = get_posts($args);
    print_r($first_post);
    foreach($first_post as $post) : setup_postdata($post);
      wp_redirect(get_permalink($post)."&term=configuracao_mao&value=".$configuracao_mao);
    exit;
    endforeach;
  }
  
}

function taxonomy_first($tax,$ter) {
	global $post;

  $term_name = $terms[0]->name;
  wp_reset_query();
  $args = array(
    'post_type' => 'cadastros',
    'orderby' => 'name',
    'order' => 'ASC',
		'posts_per_page' => 1,
    'tax_query' => array(
      array(
        'taxonomy' => $tax,
        'field' => 'slug',
        'terms' => $ter
        ),
      )
    );

  $loop = new WP_Query($args);
	$out = 0;
  if($loop->have_posts()) {
    while($loop->have_posts()) : $loop->the_post();
			$out = $post->post_name;
    endwhile;
  }

	return $out;
}


function wpdl_show_paginated_hands($MAOS_POR_PAGINA, $my_term=0) {
  $the_terms = get_terms(array('taxonomy' => 'configuracao_mao'));

  
  $term_count = count($the_terms);
  $term_count_var = $term_count;
  if (gettype($my_term) == "string") {
    
    $my_term_explode = explode("-", $my_term);
    $my_hand_num = ($my_term_explode[0] == "configuracao") ? $my_term_explode[3] : 0;
    
    for($i=0; $i < $term_count_var; $i++){
      if($the_terms[$i]->slug == $my_term){
        $active_page= intval($i/intval($MAOS_POR_PAGINA));
        break;
      }
    }
    //print_r($the_terms);
    //$active_page = $active_page = intval(intval($my_hand_num) / intval($MAOS_POR_PAGINA));
  } else {
     $active_page = 0;
  }
  $ini = 0;
  $curr_page = 0;
  $paginas = 0;

  // Indicators
  echo '<ol class="carousel-indicators">';
  while ($term_count_var > 0) {
    ($curr_page == $active_page) ? $active="active" : $active="";
    echo '<li data-target="carousel-example-generic" data-slide-to="'.$curr_page.'" class="'.$active.'"></li>';
    $term_count_var -= $MAOS_POR_PAGINA;
    $curr_page++;
    $paginas++;
  }
  echo '</ol>';

  // Wrapper for slides
  echo '<div class="carousel-inner">';
  $term_count_var = $term_count;
  $ini=0;
  $curr_page=0;
  while ($term_count_var > 0 ) { 
    ($curr_page == $active_page) ? $active="active" : $active="";
    echo '<div class="item '.$active.'">';
    echo '<div class="hands">';
    $curr_page_num = $curr_page+1;
    echo '<ul id="pagina-'.$curr_page_num.'" class="imgExpande">';
    $a_qtd = ($term_count_var <= $MAOS_POR_PAGINA) ? $term_count_var : $MAOS_POR_PAGINA;

    $i=0;
    for (; $i < $a_qtd; $i++) {
      echo sprintf('<li><a id="%s" href="%s">',
        $the_terms[$ini+$i]->slug,
        esc_url( get_term_link( $the_terms[$ini+$i]->slug, "configuracao_mao" ) )
      );

      echo '<img src="'.do_shortcode(sprintf('[wp_custom_image_category onlysrc="true" term_id="%s"]', $the_terms[$ini+$i]->term_id)).'"></img></a></li>';
    }
    echo '</ul></div></div>';
    $term_count_var -= $MAOS_POR_PAGINA;
    $curr_page++;
    $ini = $i;
  }
  echo '</div>';

  //Controls
  if ($paginas > 0) {
    echo '<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">';
    echo '<img src="'.esc_url(get_template_directory_uri()).'/img/left.png" class="glyphicon glyphicon-chevron-left" />';
    echo '</a>';
    echo '<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">';
    echo '<img src="'.esc_url(get_template_directory_uri()).'/img/right.png" class="glyphicon glyphicon-chevron-right" />';
    echo '</a>';
  }
}

/**
 * Retorna os títulos das taxonomias
 *
 * @see get_object_taxonomies()
 */
function wpdocs_custom_taxonomies_terms_links($termType, $termValue) {
  $term = get_term_by( 'slug', $termValue, $termType);
  $tax = get_taxonomy($termType);
  //$term = get_term_by('slug', 'temas')
  if ( isset( $term ) ) {
    $out[] = "<span>" . ucfirst($tax->label) . "</span>\n"."<i class='fa fa-angle-right' aria-hidden='true'></i>";


        $termName = esc_html( $term->name );
        $out[] = '<span class="themesTitle">'.$termName.'</span>';
        /*$out[] = sprintf( '<span class="themesTitle"">%2$s</span>',
            esc_url( get_term_link( $term->slug, $taxonomy_slug ) ),
            $termName
        );*/
      $out[] = "\n\n";
  }

  return implode( '', $out );
}

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function theme_name_wp_title( $title, $sep ) {
  if ( is_feed() ) {
    return $title;
  }
  if( empty( $title ) && ( is_home() || is_front_page() ) ) {
    return __( 'Início', 'theme_domain' ) . ' | ' . get_bloginfo( 'name' ) . ' - ' . get_bloginfo( 'description' );
  }
  if ( is_tax() ) {
    $title = single_term_title( '', false );
  }
  global $page, $paged;
  // Add the blog name
  $title .= " | " . get_bloginfo( 'name', 'display' );
  // Add the blog description for the home/front page.
  $site_description = get_bloginfo( 'description', 'display' );
  //$title .= " - $site_description";
  // Add a page number if necessary:
  if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
    $title .= " | " . sprintf( __( 'Página %s', '_s' ), max( $paged, $page ) );
  }
  return $title;
}
add_filter( 'wp_title', 'theme_name_wp_title', 10, 2 );

/**
* Registra o menu superior
**/
function register_menu() {
  register_nav_menu('top-menu',__( 'Top Menu' ));
}
add_action( 'init', 'register_menu' );


/**
Remover Slug do Post Type
**/
function wpse_remove_cpt_slug( $post_link, $post, $leavename ) {

    // leave these CPT alone
    $whitelist = array ('units');

    if ( ! in_array( $post->post_type, $whitelist ) || 'publish' != $post->post_status )
        return $post_link;

    if( isset($GLOBALS['wp_post_types'][$post->post_type],
             $GLOBALS['wp_post_types'][$post->post_type]->rewrite['slug'])){
        $slug = $GLOBALS['wp_post_types'][$post->post_type]->rewrite['slug'];
    } else {
        $slug = $post->post_type;
    }

    // remove post slug from url
    $post_link = str_replace( '/' . $slug  . '/', '/', $post_link );

    return $post_link;
}
add_filter( 'post_type_link', 'wpse_remove_cpt_slug', 10, 3 );
add_filter( 'post_link', 'wpse_remove_cpt_slug', 10, 3 );

function wpse_parse_request( $query ) {

    // Only noop the main query
    if ( ! $query->is_main_query() )
        return;

    // Only noop our very specific rewrite rule match
    if ( 2 != count( $query->query )
         || ! isset( $query->query['page'] ) )
        return;

    // 'name' will be set if post permalinks are just post_name, otherwise the page rule will match
    if ( ! empty( $query->query['name'] ) )
        $query->set( 'post_type', array( 'post', 'units', 'page' ) );
}
add_action( 'pre_get_posts', 'wpse_parse_request' );

/**
 * Botão de editar personalizado
 */
function custom_edit_post_link($output) {

 $output = str_replace('class="post-edit-link"', 'class="post-edit-link btn btn-danger"', $output);
 return $output;
}
add_filter('edit_post_link', 'custom_edit_post_link');

function my_get_current_page_url() {
  global $wp;
  return add_query_arg( $_SERVER['QUERY_STRING'], '', home_url( $wp->request ) );
}


function mysite_js() {
  wp_enqueue_script('autocomplete', get_stylesheet_directory_uri().'/js/jquery.auto-complete.js', array('jquery'));
  
  wp_enqueue_script('mysite-js', get_stylesheet_directory_uri().'/js/mysite.js', array('jquery', 'autocomplete'));
 
  wp_enqueue_style('autocomplete.css', get_stylesheet_directory_uri().'/js/jquery.auto-complete.css');
 
}
add_action('wp_enqueue_scripts', 'mysite_js');

//get listings for 'works at' on submit listing page
add_action('wp_ajax_nopriv_get_listing_names', 'ajax_listings');
add_action('wp_ajax_get_listing_names', 'ajax_listings');
 
function ajax_listings() {
  global $wpdb; //get access to the WordPress database object variable
 
  //get names of all businesses
  $name = $wpdb->esc_like(stripslashes($_POST['name'])).'%'; //escape for use in LIKE statement
  $sql = "select post_title
    from $wpdb->posts 
    where post_title like %s 
    and post_type='cadastros' and post_status='publish'";
 
  $sql = $wpdb->prepare($sql, $name);
  
  $results = $wpdb->get_results($sql);
 
  //copy the business titles to a simple array
  $titles = array();
  foreach( $results as $r )
    $titles[] = addslashes($r->post_title);
    
  echo json_encode($titles); //encode into JSON format and output
 
  die(); //stop "0" from being output
}
  //}

?>
