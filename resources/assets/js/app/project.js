var Project = {
	$container: null,
	$slider: null,
	selectors: {
		container: '.js-project',
		slider:    '.js-slider',
		browser: {
			prev:  '.js-browser-prev',
			pause: '.js-browser-pause',
			next:  '.js-browser-next'
		}
	},
	sliderOptions: {
		isPaused:        false,
		imagesLoaded:    true,
		pageDots:        false,
		autoPlay:        true,
		wrapAround:      true,
		autoPlay:        4000,
		prevNextButtons: false,
		resizeBound:     true
	},
	init: function(){
		this.$container = $(this.selectors.container);
		this.$slider = this.$container.find(this.selectors.slider);
		this.bind();
	},
	bind: function(){
		this.$slider.flickity(this.sliderOptions);
		this.$container.find(this.selectors.browser.prev).on('click', $.proxy(this.eventBrowserMove, this, 'previous'));
		this.$container.find(this.selectors.browser.pause).on('click', $.proxy(this.eventBrowserPause, this));
		this.$container.find(this.selectors.browser.next).on('click', $.proxy(this.eventBrowserMove, this, 'next'));
	},
	eventBrowserPause: function(e){
		var $slider = Flickity.data(this.$slider.get(0)); // Hax it up!
		if(this.sliderOptions.isPaused){
			$slider.activatePlayer();
			this.sliderOptions.isPaused = false;
		}
		else {
			$slider.deactivatePlayer();
			this.sliderOptions.isPaused = true;
		}
		$(e.currentTarget).toggleClass('active');
	},
	eventBrowserMove: function(direction){
		this.$slider.flickity(direction);
	}
};
$(Project.init());
