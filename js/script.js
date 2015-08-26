jQuery(function($){
		$('#registration-form').submit(function( e ){	
		e.preventDefault();
		//console.log('form submitted');
		
		var data = $( this ).serializeArray();
		
		$.ajax({
			type: "POST",
			url: "http://localhost/crud/php/process.php",
			data: data,
			beforeSend: function(){
				$('.message').html("Registering...");
			},
			success: function(msg){
				$('.message').html(msg);
			}

		}); // Ajax Call
	}); //event handler	

});
