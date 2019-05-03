<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<title><?php wp_title(''); ?></title>

	<!-- Bootstrap -->
	<link href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/bootstrap.min.css" rel="stylesheet">

	<!-- Theme stylesheet -->
	<link href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/custombox.min.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">

	<!-- Awesome Fonts -->
	<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/fonts/awesome/css/font-awesome.min.css">

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700,900" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400" rel="stylesheet">

  <!-- Video JS CSS -->
  <link href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/video-js.css" rel="stylesheet">

  <!-- JS -->
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <!-- Bootstrap latest compiled and minified JavaScript -->
  <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/bootstrap.min.js"></script>

  <!-- Video JS -->
  <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/videojs-ie8.min.js"></script>
  <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/video.js"></script>

  <?php wp_head(); ?>

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
    </head>
    <body>
    	<header>
       <div id="up"></div>

       <div class="container">
         <div class="row">
          <div class="col-md-12">
           <nav class="navbar navbar-inverse">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
             <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="navbar-collapse">
           <ul class="nav navbar-nav">
            <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Início</a></li>
            <li>
              <a href="#" id="link-sobre">Sobre</a>
            </li>
            <li>
              <a href="#" id="link-equipe">A Equipe</a>
            </li>
            <li>
              <a href="#" id="link-contribua">Contribua</a>
            </li>
            <li>
              <a href="#" id="link-contato">Contato</a>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </nav>
      <h1>Dicionário de Libras</h1>
      <h2>
      A obtenção de vocabulário é indispensável para o processo de ensino-aprendizagem da Língua Brasileira de Sinais. 
      Este dicionário é constituído por sinais regionais básicos.
      </h2>
    </div>
  </div>
</div>
</header>

<script>
$(document).ready(function() {
  $("#link-sobre").click(function(){
      $("#about-modal").modal();
  });
  $("#link-contato").click(function(){
      $("#contact-modal").modal();
  });
  $("#link-contribua").click(function(){
      $("#contribute-modal").modal();
  });
  $("#link-equipe").click(function(){
      $("#team-modal").modal();
  });
});
</script>

<?php wp_reset_query(); ?>
