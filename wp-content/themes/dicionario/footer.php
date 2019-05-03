<?php
	session_start();
?>
<footer class="container-fluid footer pangolin" id="contato">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <div class="address">
          <span class="align-middle">
						<h3>Contato</h3>
            <p>Universidade Federal de Viçosa - Câmpus Viçosa</p>
						<p>Prédio CCH2</p>
            <p>36570-900 – Viçosa – MG – BR</p>
						<p>Tel.: +55 (31) 3899-4914 (DLA)</p>
						<p>Tel.: +55 (31) 3899-4808 (DCS)</p>
						<p>E-mail: dla@ufv.br</p>
          </span>
        </div>
      </div>
      <div class="col-md-8">
        <div class="logos">

					<a href="http://www.capes.gov.br/uab" target="blank"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/uab.png"></a>
					<a href="#" target="blank"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/inovar.png"></a>
					<a href="http://www.cead.ufv.br" target="blank"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/cead.png"></a>
					<a href="http://www.capes.gov.br/" target="blank"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/capes.png"></a>
					<a href="http://www.ufv.br" target="blank"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/ufv.png"></a>

				</div>
				<div class="logos-mobile" style="display:none">
					<div class="row">
						<div class="col-md-2">
							<a href="http://www.capes.gov.br/uab" target="blank"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/uab.png"></a>
						</div>
						<div class="col-md-2">
							<a href="#" target="blank"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/inovar.png"></a>
						</div>
						<div class="col-md-2">
							<a href="http://www.cead.ufv.br" target="blank"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/cead.png"></a>
						</div>
						<div class="col-md-2">
							<a href="http://www.capes.gov.br/" target="blank"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/capes.png"></a>
						</div>
						<div class="col-md-2">					
							<a href="http://www.ufv.br" target="blank"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/ufv.png"></a>
						</div>
						<div class="col-md-2"></div>
					</div>
				</div>
      </div>
    </div>
  </div>
  <div class="copyright">
    <div class="container">
      <div class="row">
        <div class="col-md-12 ">
          <div class="pull-left">
            <h4>©2017 - Todos os Direitos Reservados - Desenvolvido pela Cead</h4>
          </div>
          <div class="pull-right">
            <img src="https://acervo.cead.ufv.br/wp-content/themes/acervo/img/creativecommons.png">
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>

<div id="about-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title">Sobre o Dicionário de Libras</h1>
			</div>
			<div class="modal-body">
				<h3>Projeto Inovar +</h3>
				<p>
					O Inovar + tem o objetivo principal de desenvolver um Dicionário Online Libras-Português e um Ambiente Virtual de Aprendizagem (AVA)  inclusivo e acessível, denominado Plataforma Inclua. 
					As ações realizadas pelo Inovar Mais visam a atuação direta de toda a equipe com a elaboração dos software citados, além da promoção de ações voltadas para o aprimoramento da formação em educação inclusiva, possibilitando maior acesso das pessoas com deficiência ao Ensino Superior, algo historicamente negado. 
					Sendo um projeto interdepartamental, o Inovar + e financiado pelo Edital Capes (no âmbito do Edital 03/2015) ,  este projeto também fomenta o debate sobre direitos humanos, acessibilidade, inclusão e tecnologias assistivas, para a melhoria do processo de ensino-aprendizagem. 
				</p>
				<br />
				<h3>Dicionário Online Libras-Português</h3>
				<p>
					O Dicionário é uma inovação didática tecnológica voltada para pessoas Surdas que estudam ou trabalham na Universidade Federal de Viçosa (UFV), como ferramenta de mediação dos processos comunicacionais entre Surdos e ouvintes. 
					Esta ferramenta, ainda, tem objetivo pedagógico no ensino e aprendizagem da Língua Brasileira de Sinais (Libras) como segunda língua aos estudantes em formação nas licenciaturas e aos professores que ministram aulas para alunos Surdos. 
					O Dicionário, possibilita ao usuário a busca de sinais a partir da identificação de categorias como “lugares”, “objetos”, “animais”, “transporte”, dentre outros temas. 
					Além disso, este software tem sido organizado de modo a apresentar frases no formato da estrutura sintática da Libras bem como a busca por configurações de mão a partir do sinalário. 
				</p>
			</div>
			<div class="modal-footer">
				<button type="button" id="about-modal-btn" class="btn btn-close" data-dismiss="modal" aria-label="Fechar">Fechar</button>
			</div>
		</div>
	</div>
</div>

<!-- Equipe Modal -->
<div id="team-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title">A equipe</h1>
			</div>
			<div class="modal-body">
				<h3>Coordenador UAB/UFV</h3>
				<p>Prof. Frederico José Vieira Passos - PRE/UFV</p>
				<h3>Coordenação do Projeto</h3>
				<p>Profa. Ana Luisa Borba Gediel - DLA/UFV</p>
				<p>Pedro de Almeida Sacramento - Cead/UFV</p>
				<p>Prof. Victor Luiz Alves Mourão - DCS/UFV </p>
				<h3>Coordenação Cead/UFV</h3>
				<p>Profa. Silvane Guimarães - Cead/UFV</p>
				<h3>Coordenação de Desenvolvimento</h3>
				<p>Pedro de Almeida Sacramento - Cead/UFV</p>
				<h3>Desenvolvimento</h3>
				<p>Alan Mariano - Programação - Cead/UFV; DPI/UFV</p>
				<p>Edson Ney Duarte Nogueira - Design de Interfaces - Cead/UFV</p>
				<p>Hevellin Ferreira Aguiar e Ferraz - Programação - Cead/UFV; DPI/UFV</p>
				<p>Lucas Pereira Marques - Programação - Cead/UFV; DPI/UFV</p>
				<p>Pedro de Almeida Sacramento - Programação - Cead/UFV</p>
				<h3>Consultoria</h3>
				<p>Dâmaris Pires Arruda - DPI/UFV</p>
				<h3>Pesquisa</h3>
				<p>Carolina Macedo Lopes - DHI/UFV</p>
				<p>Daiane Araújo Meireles - DPE/UFV</p>
				<p>Isabela Martins Miranda - DLA/UFV</p>
				<p>Ramon Silva Teixeira - DCS/UFV</p>
				<p>Sheila Silva de Farias Xisto - DED/UFV</p>
				<h3>Realização</h3>
				DPE/UFV; DLA/UFV; DCS/UFV; Cead/UFV
			</div>
			<div class="modal-footer">
				<button type="button" id="team-modal-btn" class="btn btn-close" data-dismiss="modal" aria-label="Fechar">Fechar</button>
			</div>
		</div>
	</div>
</div>

<!-- Contact modal -->
<div id="contact-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title">Entre em contato</h1>
			</div>
			<div class="modal-body">			 
				<h4>Universidade Federal de Viçosa - Câmpus Viçosa</h4>
				<h4>Departamento de Letras</h4> 
				<h4>36570-900 – Viçosa – MG – BR</h4>
				<h4>Tel.: +55 (31) 3899-2410</h4>
				<h4>E-mail: dla@ufv.br</h4>
			</div>
			<div class="modal-footer">
				<button type="button" id="contact-modal-btn" class="btn btn-close" data-dismiss="modal" aria-label="Fechar">Fechar</button>
			</div>
		</div>
	</div>
</div>

<!-- Contribute modal -->
<div id="contribute-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title">Contribua com o Dicionário!</h1>
			</div>
			<div class="modal-body">		
				<h4>Para contribuir com o projeto, envie um email para o endereço sugestao.inovar.ufv@gmail.com com as informações e o vídeo referente à contribuição</h4>	 
			</div>
			<div class="modal-footer">
				<button type="button" id="contribute-modal-btn" class="btn btn-close" data-dismiss="modal" aria-label="Fechar">Fechar</button>
			</div>
		</div>
	</div>
</div>

<!-- history modal -->
<div id="history-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title">Confira seu histórico de acessos</h1>
			</div>
			<div class="modal-body">
			<?php		
			foreach ($_SESSION['historico'] as $elem){
												echo '<a href="https://sistemas.cead.ufv.br/capes/dicionario/?cadastros='.$elem["cadastros"].'&term='.$elem["term"].'&value='.$elem["value"].'">'.$elem["titulo"].'</a>';
										}
			?>
			</div>
			<div class="modal-footer">
				<button type="button" id="history-modal-btn" class="btn btn-close" data-dismiss="modal" aria-label="Fechar">Fechar</button>
			</div>
		</div>
	</div>
</div>



  <link href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/hover.css" rel="stylesheet">

  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/legacy.min.js"></script>

  <script type="text/javascript">
    $('#myTabs a').click(function (e) {
      e.preventDefault()
      $(this).tab('show')
    })
  </script>

  <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/legacy.min.js"></script>
  <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/custombox.min.js"></script>
  <script>
  	$(function() {
  		$('a[rel="search"]').on('click', function( e ) {
  			Custombox.open({
  				target: '#modal',
  				effect: 'fadein',
  				overlayColor: '#cc5860',
  				overlayOpacity: 0.4,
  				speed: 300
  			});
  			e.preventDefault();
  		});
  	});
  </script>

  <!-- Desativa as setas do carousel caso só tenha um vídeo cadastrado -->
  <script type="text/javascript">
    $(function () { // on document.ready()
      if ($('#videos').length) { // only if page has a #videos element
        if ($('.carousel-inner .item').length === 1 ) { // if have only one video
          $('.carousel-control').hide(); // hide the navigation
        }
      }
    });
  </script>

  <?php wp_footer(); ?>

</body>
</html>
