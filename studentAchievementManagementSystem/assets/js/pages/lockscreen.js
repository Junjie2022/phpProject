//------------- lockscreen.js -------------//
$(document).ready(function() {
	//add class to body for login styling
	$('body').addClass('login-page');

	//add css animation to login container
	$('#login').addClass('animated bounceIn');

	//validate login form 
	$("#login-form").validate({
		ignore: null,
		ignore: 'input[type="hidden"]',
		errorPlacement: function(error, element) {
			wrap = element.parent();
			wrap1 = wrap.parent();
			if (wrap1.hasClass('checkbox')) {
				error.insertAfter(wrap1);
			} else {
				if (element.attr('type')=='file') {
					error.insertAfter(element.next());
				} else {
					error.insertAfter(element);
				}
			}
		}, 
		errorClass: 'help-block',
		rules: {
			password: {
				required: true,
				minlength: 5
			}
		},
		messages: {
			password: {
				required: "请输入密码",
				minlength: "密码必须至少有5个字符"
			}
		},
		highlight: function(element) {
			if ($(element).offsetParent().parent().hasClass('form-group')) {
				$(element).offsetParent().parent().removeClass('has-success').addClass('has-error');
			} else {
				if ($(element).attr('type')=='file') {
					$(element).parent().parent().removeClass('has-success').addClass('has-error');
				}
				$(element).offsetParent().parent().parent().parent().removeClass('has-success').addClass('has-error');
				
			}
	    },
	    unhighlight: function(element,errorClass) {
	    	if ($(element).offsetParent().parent().hasClass('form-group')) {
	    		$(element).offsetParent().parent().removeClass('has-error').addClass('has-success');
		    	$(element.form).find("label[for=" + element.id + "]").removeClass(errorClass);
	    	} else if ($(element).offsetParent().parent().hasClass('checkbox')) {
	    		$(element).offsetParent().parent().parent().parent().removeClass('has-error').addClass('has-success');
	    		$(element.form).find("label[for=" + element.id + "]").removeClass(errorClass);
	    	} else if ($(element).next().hasClass('bootstrap-filestyle')) {
	    		$(element).parent().parent().removeClass('has-error').addClass('has-success');
	    	}
	    	else {
	    		$(element).offsetParent().parent().parent().removeClass('has-error').addClass('has-success');
	    	}
		}
	});

});