var LabsTwitter = {
	$container: null,
	api: {
		user: '/api/labs/twitter/account'
	},
	selectors: {
		container: '.js-twitter',
		results:   '.js-results',
		user: {
			container: '.js-user',
			form:      '.js-user-form',
			name:      '.js-user-name',
			go:        '.js-user-go',
			loading:   '.js-user-loading',
		},
		followings: '.js-followings',
		followers:  '.js-followers',
		count:      '.js-count',
		accounts:   '.js-accounts',
		loading:    '.js-loading',
		template: {
			container: '.js-account-template',
			image:     '.js-account-image',
			name:      '.js-account-name',
			link:      '.js-account-link',
			date:      '.js-account-date'
		},
		error: {
			container: '.js-error',
			message:   '.js-error-message'
		}
	},
	init: function(){
		this.$container = $(this.selectors.container);
		this.userFocus();
		this.bindEvents();
	},
	bindEvents: function(){
		this.$container.find(this.selectors.user.form).on('submit', $.proxy(this.userSubmit, this));
	},

	// User
	userFocus: function(){
		this.$container.find(this.selectors.user.name).focus();
	},
	userSubmit: function(e){
		e.preventDefault();
		var username = this.$container.find(this.selectors.user.name).val();
		if(username){
			this.$container.find(this.selectors.user.container).addClass('twitter__user--top');
			this.userShowLoader();
			this.userFetch(username);
		}
	},
	userFetch: function(username){
		this.errorClear();
		this.profileResetAll();
		this.profileShowLoader();
		$.ajax({
			cache:   false,
			type:    'GET',
			data:    this.$container.find(this.selectors.user.form).serialize(),
			url:     this.api.user,
			success: $.proxy(this.userFetchSuccess, this),
			error:   $.proxy(this.userFetchError, this)
		});
	},
	userFetchSuccess: function(data){
		if(data.success){
			this.$container.find(this.selectors.results).removeClass('twitter__results--hidden');
			this.profileRender(this.selectors.followings, data.data.following);
			this.profileRender(this.selectors.followers, data.data.followers);
		}
		else {
			this.errorHandle(data.error);
		}
		this.userHideLoader();
		this.profileHideLoader();
	},
	userFetchError: function(xhr, status, error){
		this.errorHandle({ code: 900 });
	},
	userShowLoader: function(){
		this.$container.find(this.selectors.user.loading).removeClass('twitter__loader--hidden');
	},
	userHideLoader: function(){
		this.$container.find(this.selectors.user.loading).addClass('twitter__loader--hidden');
	},

	// Profiles
	profileResetAll: function(){
		this.profileReset(this.selectors.followings);
		this.profileReset(this.selectors.followers);
	},
	profileReset: function(container){
		var $el = this.$container.find(container);
		$el.find(this.selectors.count).empty();
		$el.find(this.selectors.accounts).empty();
	},
	profileRender: function(container, accounts){
		var $el = this.$container.find(container);
		$.each(accounts, $.proxy(function(i, item){
			var $profile = this.$container.find(this.selectors.template.container).children().clone();
			$profile.find(this.selectors.template.image).attr('src', item.image);
			$profile.find(this.selectors.template.name).text(item.name);
			$profile.find(this.selectors.template.link).attr('href', 'http://twitter.com/'+item.screen_name);
			$profile.find(this.selectors.template.date).attr('title', item.last_tweet);
			$el.find(this.selectors.accounts).append($profile);
		}, this));
		$el.find(this.selectors.count).text(accounts.length);
	},
	profileShowLoader: function(){
		this.$container.find(this.selectors.loading).show();
	},
	profileHideLoader: function(){
		this.$container.find(this.selectors.loading).hide();
	},

	// Errors
	errorClear: function(){
		this.$container.find(this.selectors.error.container).addClass('twitter__error--hidden');
		this.$container.find(this.selectors.error.message).text('');
	},
	errorHandle: function(error){
		switch(error.code){
			case 34:
				this.errorShow('The Screen Name / User ID entered was invalid.');
				break;
			case 900:
				this.errorShow('An unexpected error has occurred. Please try again later.');
				break;
			case 88:
				this.errorShow('Request rate limit reached. Please try again later.');
				break;
			default:
				this.errorShow(error.message);
		}
	},
	errorShow: function(message){
		this.$container.find(this.selectors.error.container).removeClass('twitter__error--hidden');
		this.$container.find(this.selectors.error.message).text(message);
	}

};
$(LabsTwitter.init());
