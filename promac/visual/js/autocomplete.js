var MIN_LENGTH = 3;
$( document ).ready(function() {
	$("#keyword").keyup(function() {
		var keyword = $("#nomeResponsavel").val();
		if (keyword.length >= MIN_LENGTH) {
			$.get( "autocomplete.php", { keyword: keyword } )
			  .done(function( data ) {
			    console.log(data);
			  });
		}
	});

});