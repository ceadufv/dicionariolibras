	<?php 
	session_start();

	//variavel para definir o maximo de palavras que serao guardadas pelo historico
	$max_h = 50;
	
	if (!isset($_SESSION['historico'])) {
		$_SESSION['historico'] = array();
		$_SESSION['count_h'] = 0;
	}

	
	$curr = $_SESSION['count_h']; //guarda qual a posição da última palavra colocada
	$flag = true;
	//verifica se a palavra acessada já está no histórico. Se já estiver, flag = false e a palavra
	//não será colocada novamente no histórico (evita duplicatas)
	for ($i=0;$i<$max_h;$i++){
		if($_SESSION['historico'][$i]['cadastros'] == $_REQUEST['cadastros']){
			$flag=false;
			break;
		}
	}

	//caso a palavra não esteja no histórico, coloca
	if($flag){
		//se o numero de palavras já estiver no limite, reseta o valor do contador pra -1 para que a palavra na posição 0
		//possa sair da lista
		if($curr+1 == $max_h){
			$curr=-1;
		}
		$_SESSION['historico'][$curr+1] = array(
			"term" => $_REQUEST['term'],
			"value" => $_REQUEST['value'],
			"cadastros" => $_REQUEST['cadastros'],
			"titulo" => the_title("","",false)
		);		
		$_SESSION['count_h'] = $curr+1; //guarda qual a palavra mais nova na lista
	}

	
	



	get_header();
	search_js();

	$MAOS_POR_PAGINA = 18;
	

	$id_post = $id;
	$my_hand_term = wp_get_post_terms(intval($id_post), 'configuracao_mao')[0];
	$my_hand_term_ID = $my_hand_term->term_id;
	if(isset($_GET['term']) && isset($_GET['value'])){
		$termType = $_GET['term'];
		$termValue = $_GET['value'];
	}




	?>

	<main>

		<div class="container">
			<div class="row">
				<div class="boxResults">
				<div class="col-lg-8 col-lg-push-4">
						<div class="content">
							<h3 id="term_headers_mobile">
								<?php
								if(isset($termType) && isset($termValue)){
									echo wpdocs_custom_taxonomies_terms_links($termType, $termValue);
								}else{
									echo "Resultado da pesquisa";
								}
								?>
								<span id="term_title"><?php the_title() ?></span>
							</h3>
							<section class="single">

								<div class="videos">

									<div class="video" id="videos">
										<?php if( get_field('videos', $id_post) ): $first = true; ?>
											<div id="carousel-videos" class="carousel slide" data-ride="carousel" data-interval="false">
												<!--Wrapper for slides -->
												<div class="carousel-inner" id="carousel-video" role="listbox">
													<?php 
														$count_videos = sizeof(get_field('videos', $id_post));
														while( has_sub_fields('videos', $id_post) ): 
													?>
														<div class="item<?php if($first) echo ' active'; $first = false; ?>">

															<div class="embed-responsive embed-responsive-16by9 video-content">
															<?php
																$browser = get_browser_name($_SERVER['HTTP_USER_AGENT']);
																$vid = str_replace(array("[video", "src=", "/]"), array("", "", ""), get_sub_field('link'));
																
																if($browser == "Firefox"){
																	$html="<video src=".$vid." controls='true' preload='auto' width='640' height='264'></video>";
																}else{																	
																	$html="<video src=".$vid." class='video-js vjs-default-skin' controls='true' preload='auto' width='640' height='264'></video>";
																}	
																echo($html);
															?>

															</div>
															
															<div class="legenda">
																<?php if ( $count_videos > 1) {?>
																	<a class="left carousel-control" href="#carousel-videos" role="button" data-slide="prev">
																		<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
																		<span class="sr-only">Previous</span>
																	</a>
																	<a class="right carousel-control" href="#carousel-videos" role="button" data-slide="next">
																		<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
																		<span class="sr-only">Next</span>
																	</a>
																<?php } ?>
																<?php the_sub_field('legenda'); ?>
															</div>
															
														</div>
													<?php endwhile; ?>
												</div>


											</div>
										<?php endif; ?>
									</div>


									<div class="box flex">
										<div class="pull-left">
											<h3>Exemplo em português</h3>
											<h4>
												<?php if( get_field('cadastro_palavras_portugues', $id_post) ): ?>
													<?php the_field('cadastro_palavras_portugues', $id_post); ?>
												<?php endif; ?>
											</h4>
										</div>
										<div class="pull-left">
											<h3>Exemplo em libras</h3>
											<h4>
												<?php if( get_field('cadastro_palavras_libras', $id_post) ): ?>
													<?php the_field('cadastro_palavras_libras', $id_post); ?>
												<?php endif; ?>
											</h4>
										</div>
										<div class="pull-right">
											<img src="<?php echo do_shortcode(sprintf('[wp_custom_image_category onlysrc="true" term_id="%s"]', intval($my_hand_term_ID))); ?>" />
										</div>
									</div>
								</div>

							</section>
						</div>

					</div>
					<div class="col-lg-4 col-lg-pull-8">
						<div class="termSingleLinks">
							<h3 id="term_headers_pc">
								<?php
								if(isset($termType) && isset($termValue)){
									echo wpdocs_custom_taxonomies_terms_links($termType, $termValue);
								}else{
									echo "Resultado da pesquisa";
								}
								?>
								<span id="term_title"><?php the_title() ?></span>
							</h3>
							<div id="carousel-example-generic-one" class="carousel slide" data-ride="carousel" data-interval="false">
								<!-- Indicators -->
								<!-- Wrapper for slides -->
								<div class="carousel-inner">
									<?php

										$results = filtrar($termType, $termValue);

										$num_pages = 1;

										$active_page = 0;

										$itens = array();
										for($i=0; $i < count($results); $i++){	
											if(!($i%14) && $i!=0){
												//echo '</div><div class="item" data-posicao="'.$num_pages.'">';
												$num_pages++;
											}
											if($results[$i]["slug"] == $_REQUEST["cadastros"]){
												$active_page = $num_pages;
											}
											$itens[$num_pages] .= '<a href="https://sistemas.cead.ufv.br/capes/dicionario/?cadastros='.$results[$i]["slug"].'&term='.$termType.'&value='.$termValue.'">'.$results[$i]["title"].'</a>';
										}

										for($i=0; $i<$num_pages; $i++){
											if($i == $active_page-1){
												echo '<div class="item active" id="results" data-posicao="'.$i.'">';
											}else{
												echo '<div class="item" id="results" data-posicao="'.$i.'">';
											}
											echo $itens[$i+1];
											echo '</div>';
										}
									?>
								</div>
								<?php
									//caso tenha mais de uma página irá criar a navegação 
								if ($num_pages > 1){
									?>
									<div class="navigation">
										<div class="pull-left">
											<ol class="carousel-indicators">
												<?php
												/*echo '<li class="circle active" data-target="#carousel-example-generic-one" data-slide-to="0" ></li>';*/
												for($i=0; $i < $num_pages; $i++){
													if($i == $active_page-1){
														echo '<li class="circle active" data-target="#carousel-example-generic-one" data-slide-to="'.$i.'"></li>';
													}else{
														echo '<li class="circle" data-target="#carousel-example-generic-one" data-slide-to="'.$i.'"></li>';
													}
													
												}
												?>
											</ol>
										</div>
										<div class="pull-right">
											<!-- Controls -->
											<a class="left" href="#carousel-example-generic-one" role="button" data-slide="prev">
												<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/left.png" class="glyphicon glyphicon-chevron-left" />
											</a>
											<a class="right" href="#carousel-example-generic-one" role="button" data-slide="next">
												<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/right.png" class="glyphicon glyphicon-chevron-right" />
											</a>
										</div>
									</div>

									<?php
									} //fim if($num_pages > 1)
									?>
							</div> <!-- Carousel -->	

							<div class="edit_post_link"><?php edit_post_link( $link, $before, $after, intval($id_post), $class ); ?></div>

								<?php
								//if ($mao)
									//echo custom_taxonomy_term_single_links_hand();
								//else
									//echo custom_taxonomy_term_single_links(); 
								?>
						</div>
						<div class="busca"><input type="text" name="cadastros" id="s" class="form-control" placeholder="Pesquisar" ></div>
					</div>
					

					</div>
				</div>
			</div>
			<?php $aux =0; ?>
			<div class="container">

				<div class="tabs tabs-style-tzoid">
					<nav>
						<ul class="nav-tabs" id="myTabs" role="tablist">
							<li role="presentation" <?php if($termType=='sinalario'){echo 'class="active"';$aux=1;}?>><a href="#sinalario"  aria-controls="sinalario" role="tab" data-toggle="tab">Sinalário</a></li>
							<li role="presentation" <?php if($termType=='temas'){echo 'class="active"'; $aux=1;}?>><a href="#temas" aria-controls="temas" role="tab" data-toggle="tab">Temas</a></li>
							<li role="presentation" <?php if($termType=='configuracao_mao' || $aux==0){echo 'class="active"'; $aux=0;}?>><a href="#configuracao" aria-controls="configuracao" role="tab" data-toggle="tab">Configuração de mão</a></li>
							<li role="presentation"><a href="#historico" aria-controls="historico" role="tab" data-toggle="tab">Histórico de Acessos</a></li>
						</ul>
					</nav>
					<!-- Tab panes -->
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane fade <?php if($termType=='temas'){$aux = 1; echo 'active in';}?>" id="temas">
							<div class="row">
								<div class="col-md-12 othersThemes">
									<div class="content selectorContent temas" >
										<?php 
										$results = get_categories(array('taxonomy' => 'temas'));
										$count = count($results);

										if ( $count > 0 ){

											

											foreach ( $results as $result ) {
												$res = taxonomy_first('temas', $result->slug );
												echo "<a class='result' href='https://sistemas.cead.ufv.br/capes/dicionario/?cadastros=".$res."&term=temas&value=".$result->slug."'>" . $result->name . "</a>";
											}
										}
										

										//wp_list_categories( array('taxonomy' => 'temas', 'title_li' => '', 'style'=> '', 'separator' => '', 'echo'=>0,'orderby' => 'name')); 
										?>
									</div>
								</div>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade <?php if($termType=='sinalario'){$aux = 1; echo 'active in';}?>" id="sinalario">
							<div class="row">
								<div class="col-md-12 othersTaxonomies">
									<div class="content selectorContent sinalario">
										
										<?php 
										
										$results = get_categories(array('taxonomy' => 'sinalario'));
										$count = count($results);
										if ( $count > 0 ){

											foreach ( $results as $result ) {
												$res = taxonomy_first('sinalario', $result->slug );
												echo "<a class='result' href='https://sistemas.cead.ufv.br/capes/dicionario/?cadastros=".$res."&term=sinalario&value=".$result->slug."'>" . $result->name . "</a>";
											}
										}
										
										?>
									</div>
								</div>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade <?php if($termType=='configuracao_mao' || $aux==0){echo 'active in';}?>" id="configuracao">
							<div class="row">
								<div class="col-md-12 othersHands">
									<div class="content selectorContent configuracao">
										<div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="false">
											<?php
												wpdl_show_paginated_hands("cadastros", $MAOS_POR_PAGINA, $termValue);
											?>
										</div>
									</div> <!-- Carousel -->
								</div>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="historico">
							<div class="row">
								<div class="col-md-12">
									<div class="content selectorContent historico">
										<?php 
											foreach ($_SESSION['historico'] as $elem){
												echo '<a href="https://sistemas.cead.ufv.br/capes/dicionario/?cadastros='.$elem["cadastros"].'&term='.$elem["term"].'&value='.$elem["value"].'">'.$elem["titulo"].'</a>';
											}
										?>	
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</main>



	<script>

		var actualTax;

		function convert_to_slug(str) {
			var newStr = str.trim().toLowerCase();
			newStr = newStr.replace(/[àáâãäå]/g,"a");
			newStr = newStr.replace(/[èéêë]/g,"e");
			newStr = newStr.replace(/[ìíîï]/g,"i");
			newStr = newStr.replace(/[òóôö]/g,"o");
			newStr = newStr.replace(/[ùúûü]/g,"u");
			newStr = newStr.replace(/[ç]/g,"c");

			newStr = newStr.replace(/\s+/g, '-');
			return newStr.replace(/[^a-z0-9-]/gi,'');
		}



		$(document).ready(function() {

			videojs(document.querySelector('.video-js'), {
				controls: true,
				autoplay: false,
				preload: 'auto',
				playbackRates: [0.25, 0.5, 1, 1.5, 2]
			});


			$('html,body').scrollTop($('.boxResults').offset().top - 30);

			var isMobile = window.matchMedia("(max-width: 760px)").matches;
			if (isMobile) {
				console.log("MOBILE");
				var hands_per_page = 8;
				var selector = $('.hands > ul');
				var qtdPag = selector.length;
				var selectedLI = $('.othersHands .hands li a.active').parent();
				console.log(selectedLI);
				for (var i=0; i<qtdPag; i++) {
					var thisHands = $(selector[i]).children();
					var nextPage = "#pagina-"+(i+2);
					//console.log(nextPage);
					var moveHands;
					//console.log(thisHands);
					if (thisHands.length > hands_per_page) {
						if (i == qtdPag-1) { //Current last Page
							//console.log("AQUI");
							var html = '<li data-target="#carousel-example-generic" data-slide-to="'+(i+2)+'"></li>';
							$(html).appendTo("ol.carousel-indicators");
							html = '<div class="item"><div class="hands"><ul id="'+nextPage.substr(1)+'" class="imgExpande"></ul></div></div>';
							$(html).appendTo("div.carousel-inner");
							qtdPag++;
							selector = $('.hands > ul');
						} 
						moveHands = thisHands.splice(hands_per_page, thisHands.length-hands_per_page).reverse();
						//console.log("moveHands", moveHands);
						$(moveHands).each(function(idx, item) {
							$(item).prependTo(nextPage);
						});
					}
				}
			}
			$('.selectorContent button').on('click', function(){
				var tax, term_name;

				term_name = $(this).attr('data-slug');

				if($(this).parent().hasClass('temas'))
					tax = 'temas';
				else if($(this).parent().hasClass('sinalario'))
					tax = 'sinalario';
				else
					tax = 'configuracao_mao';

				console.log(tax, term_name);
				$('#results').text('');

				$.post(ajaxurl, { action: 'results', tax: tax, termo: term_name }, function(output) {
					var res = JSON.parse(output);

					res.forEach(function(elem, indice){
						$('#results').append('<button id="'+elem.id+'" class="btn btn-default cadastros" data-slug="'+elem.slug+'">'+elem.title+'</button>');
					}); 

				});

				
			}); 

			                                                                                                              
			
		});

		function mostrarAtivo(tag, /*actual_page*/){

			tag.style.backgroundColor = "#0092a7";
			tag.style.color="#ffffff";
			$('.carousel-indicators .active').attr('data-slide-to', actual_page);
		}

		document.addEventListener("DOMContentLoaded", function() {
			var alvo = document.querySelectorAll(".themesTitle")[0].innerText.toLowerCase();
			
			var actual_page = $('.carousel-indicators .active').attr('data-slide-to');
			//alert(actual_page);

			document.querySelectorAll(".result").forEach(function(elem) {
				if(elem.innerText.toLowerCase() ===  alvo){
					mostrarAtivo(elem, /*actual_page*/);
					console.log(elem);
					$('.item').removeClass('active');
					//$(elem).parent().addClass('active');

					//alert($(elem).parent().attr("data-posicao"));

					$('.circle').removeClass('active');
					document.querySelectorAll('.circle').forEach(function (res){
						if($(res).attr("data-slide-to") == $(elem).parent().attr("data-posicao")){
							$(res).addClass("active");
						}

					})

				}

			})
		});
		

	</script>

	

	<?php get_footer(); 
	?>

