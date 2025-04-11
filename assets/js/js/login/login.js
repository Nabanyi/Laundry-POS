$(document).ready(function(){
	$("#loginForm").on("submit", function(e) {
		e.preventDefault();
		let form = $(this);
		console.error(form.serialize());
		let btn = form.find("#login_btn");
		let msg = form.find("#msg");
		$.ajax({
			url: base_url +"login/auth",
            type: "POST",
            data: form.serialize(),
            dataType: 'json',
            beforeSend: function(){
            	btn.prop('disabled', true).html('Authenticating...')
            },
            success:function(response){
            	if (response.status) {
            		msg.html(`<div class="alert alert-success alert-dismissible fade show" role="alert">
					  <strong>Success!</strong> ${response.message}
					  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>`);
            		location.replace(base_url+response.result);

            		btn.prop('disabled', false).html('Redirecting....')
            	}else{
            		msg.html(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
					  <strong>Sorry!</strong> ${response.message}
					  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>`);
					// setTimeout(function(){
					// 	msg.fadeOut('slow')
					// 	msg.html('')
					// }, 3000);

					btn.prop('disabled', false).html('Login')
            	}

            },
            error: function(xhr, error) {
            	btn.prop('disabled', false).html('Login')
            }
		})
	});
})