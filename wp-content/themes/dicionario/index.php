<?php get_header();
search_js();
 ?>

<section class="introduction gradiente-gray arrow_box">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2>Comece por aqui</h2>
				<h3>Busque a palavra desejada a partir das seguintes opções:<br />Pesquisa geral, tema, sinalário ou configuração de mão
					ou filtre através de um sinal ou configuração de mão</h3>
					<hr />
				</div>
			</div>

			<div class="row">
				<div class="col-md-4">
					<div class="busca"><input type="text" name="cadastros" id="s" class="form-control" placeholder="Pesquisar" ></div>
					<div class="categories">
						<h3>Busque sinais por tema:</h3>				
						<?php wp_list_categories( array('taxonomy' => 'temas', 'title_li' => '', 'separator' => '', 'style'=> '')); ?>
					</div>
					<div class="categories">
						<h3>Histórico de acesso:</h3>
						<a id="history-btn" href="#" >Acessar histórico</a>
					</div>
				</div>
				<div class="col-md-8 videos">
					<div class="embed-responsive embed-responsive-16by9 video-content">
						<?php
							$browser = get_browser_name($_SERVER['HTTP_USER_AGENT']);
							
							if($browser == "Firefox"){
								echo "<video src='https://sistemas.cead.ufv.br/capes/dicionario/wp-content/uploads/2018/09/VA_projetoinovar_dicionario-1.mp4' controls='true' preload='none' width='640' height='264'></video>";
							}else{
								echo "<video src='https://sistemas.cead.ufv.br/capes/dicionario/wp-content/uploads/2018/09/VA_projetoinovar_dicionario-1.mp4' class='video-js vjs-default-skin' controls='true' preload='none' width='640' height='264'></video>";
							}
						?>


						<!--<?php
							//$browser = get_browser_name($_SERVER['HTTP_USER_AGENT']);
							
							//if($browser == "Firefox"){
								//echo "<video src='https://sistemas.cead.ufv.br/capes/dicionario/wp-content/uploads/2018/07/apresentacao.mp4' controls='true' preload='none' width='640' height='264'></video>";
							//}else{
								//echo "<video src='https://sistemas.cead.ufv.br/capes/dicionario/wp-content/uploads/2018/07/apresentacao.mp4' class='video-js vjs-default-skin' controls='true' preload='none' width='640' height='264'></video>";
							//}
						?>-->
					</div>

					<!--<div class="box flex">
						<div class="pull-left">
							<h3>Exemplo em português</h3>
							<h4 style="display: block !important">Tudo bem? Você parece cansada.</h4>
						</div>
						<div class="pull-left">
							<h3>Exemplo em libras</h3>
							<h4 style="display: block !important">TUDO BEM VOCE PARECER CANSAD@</h4>
						</div>
						<div class="pull-right">
							<img src="<?php // echo esc_url( get_template_directory_uri() ); ?>/img/hand-home.jpg" />
						</div>
					</div>-->
				</div>
			</div>
		</div>
	</section>

	<section class="results">
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<div class="content categories">
						<h2>Sinalário</h2>
						<hr />					
						<h3>Encontre os sinais da sua área</h3>
						<?php wp_list_categories( array('taxonomy' => 'sinalario', 'title_li' => '', 'style'=> '')); ?>
					</div>
				</div>
				<div class="col-md-8">
					<div class="content">
						<h2>Configuração de mão</h2>
						<hr />
						<h3>Pesquise através das configurações de mãos abaixo</h3>
						<div class="content selectorContent">
							<div id="carousel-example-generic" class="carousel slide carousel-home" data-ride="carousel" data-interval="false">
								<?php
									wpdl_show_paginated_hands("home", 14);
								?>
							</div> <!-- Carousel -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<script>
	$(document).ready(function() {
		$('#history-btn').click(function(){
			$('#history-modal').modal();
		});

		videojs(document.querySelector('.video-js'), {
			controls: true,
			autoplay: false,
			preload: 'auto',
			playbackRates: [0.25, 0.5, 1, 1.5, 2]
		});

		

	});
</script>

<?php get_footer(); ?>
