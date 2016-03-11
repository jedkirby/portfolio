var Main = {
	selectors: {
		nav:       '.js-nav',
		navToggle: '.js-nav-toggle'
	},
	init: function(){
		this.bind();
	},
	bind: function(){
		$(this.selectors.navToggle).on('click', $.proxy(this.eventToggleNav, this));
	},
	eventToggleNav: function(){
		$(this.selectors.nav).toggleClass('header__nav--visible');
		$(this.selectors.navToggle).toggleClass('header__handle--active');
	}
};
$(Main.init());
