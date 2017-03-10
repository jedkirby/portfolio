var Interest = {
	$container: null,
	api: {
		interest: '/api/interest/register'
	},
	selectors: {
		container: '.js-interest',
		form:      '.js-form',
		error:     '.js-error',
		input:     '.js-input',
		complete:  '.js-complete'
	},
	init: function(){
		this.$container = $(this.selectors.container);
		this.bind();
	},
	bind: function(){
		this.$container.find(this.selectors.form).on('submit', $.proxy(this.submit, this));
	},
	submit: function(e){
		e.preventDefault();
		$.ajax({
			cache: false,
			url: this.api.interest,
			type: 'post',
			data: this.$container.find(this.selectors.form).serialize(),
			success: $.proxy(this.handleSuccess, this),
			error: $.proxy(this.handleError, this)
		});
	},
	handleSuccess: function(data){
		if(data.complete){
			this.$container.find(this.selectors.input).addClass('hidden');
			this.$container.find(this.selectors.complete).removeClass('hidden');
		}
		else {
			this.showError(data.errors.email);
		}
	},
	handleError: function(xhr, status, error){
		this.showError('An unexpected error has occurred.');
	},
	showError: function(string){
		var $span = $('<p>', {
			'text':  string,
			'class': 'interest__error'
		});
		this.$container.find(this.selectors.error).html($span);
	}
};
$(Interest.init());
