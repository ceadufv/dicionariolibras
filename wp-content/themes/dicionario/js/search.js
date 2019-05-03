jQuery(document).ready(function($) {	

	$('input[name="cadastros"]').autoComplete({
		onSelect: function(event, term, item){
			if(term!=""){
				url_atual = document.location.protocol +"//"+ document.location.hostname + document.location.pathname;
				window.location.replace(url_atual+'/?cadastros='+term);
			}
		},
		source: function(name, response) {
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: 'wp-admin/admin-ajax.php',
				data: 'action=get_listing_names&name='+name,
				success: function(data) {
					console.log(data);
					if(data.length==0){
						data = {
							titles: ["Sem Resultados"],
							slugs: [""]
						}
					}
					response(data);
				}
			});
		}
	});
 
});