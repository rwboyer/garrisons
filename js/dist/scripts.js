// Menu Toggle
jQuery(document).ready(function($){
  var menuToggle = $('#js-mobile-menu').unbind();
  $('#js-navigation-menu').removeClass("show");

  menuToggle.on('click', function(e) {
    e.preventDefault();
    $('#js-navigation-menu').slideToggle(function(){
      if($('#js-navigation-menu').is(':hidden')) {
        $('#js-navigation-menu').removeAttr('style');
      }
    });
  });
});

/**
 *   Unslider
 *   version 2.0
 *   by @idiot and friends
 */
 
(function($) {
	//  Don't throw any errors when jQuery
	if(!$) {
		return console.warn('Unslider needs jQuery');
	}

	$.Unslider = function(context, options) {
		var self = this;

		//  Create an Unslider reference we can use everywhere
		self._ = 'unslider';

		//  Store our default options in here
		//  Everything will be overwritten by the jQuery plugin though
		self.defaults = {
			//  Should the slider move on its own or only when
			//  you interact with the nav/arrows?
			//  Only accepts boolean true/false.
			autoplay: false,

			//  3 second delay between slides moving, pass
			//  as a number in milliseconds.
			delay: 3000,

			//  Animation speed in millseconds
			speed: 750,

			//  An easing string to use. If you're using Velocity, use a
			//  Velocity string otherwise you can use jQuery/jQ UI options.
			easing: 'swing', // [.42, 0, .58, 1],
			
			//  Does it support keyboard arrows?
			//  Can pass either true or false -
			//  or an object with the keycodes, like so:
			//  {
			//	 prev: 37,
			//	 next: 39
			// }
			//  You can call any internal method name
			//  before the keycode and it'll be called.
			keys: {
				prev: 37,
				next: 39
			},
			
			//  Do you want to generate clickable navigation
			//  to skip to each slide? Accepts boolean true/false or
			//  a callback function per item to generate.
			nav: true,

			//  Should there be left/right arrows to go back/forth?
			//   -> This isn't keyboard support.
			//  Either set true/false, or an object with the HTML
			//  elements for each arrow like below:
			arrows: {
				prev: '<a class="' + self._ + '-arrow prev">Prev</a>',
				next: '<a class="' + self._ + '-arrow next">Next</a>'
			},

			//  How should Unslider animate?
			//  It can do one of the following types:
			//  "fade": each slide fades in to each other
			//  "horizontal": each slide moves from left to right
			//  "vertical": each slide moves from top to bottom
			animation: 'horizontal',

			//  If you don't want to use a list to display your slides,
			//  you can change it here. Not recommended and you'll need
			//  to adjust the CSS accordingly.
			selectors: {
				container: 'ul:first',
				slides: 'li'
			},

			//  Do you want to animate the heights of each slide as
			//  it moves
			animateHeight: false,

			//  Active class for the nav
			activeClass: self._ + '-active',

			//  Have swipe support?
			//  You can set this here with a boolean and always use
			//  initSwipe/destroySwipe later on.
			swipe: true
		};

		//  Set defaults
		self.$context = context;
		self.options = {};

		//  Leave our elements blank for now
		//  Since they get changed by the options, we'll need to
		//  set them in the init method.
		self.$parent = null;
		self.$container = null;
		self.$slides = null;
		self.$nav = null;
		self.$arrows = [];
		
		//  Set our indexes and totals
		self.total = 0;
		self.current = 0;

		//  Generate a specific random ID so we don't dupe events
		self.prefix = self._ + '-';
		self.eventSuffix = '.' + self.prefix + ~~(Math.random() * 2e3);

		//  In case we're going to use the autoplay
		self.interval = null;

		//  Get everything set up innit
		self.init = function(options) {
			//  Set up our options inside here so we can re-init at
			//  any time
			self.options = $.extend({}, self.defaults, options);

			//  Our elements
			self.$container = self.$context.find(self.options.selectors.container).addClass(self.prefix + 'wrap');
			self.$slides = self.$container.children(self.options.selectors.slides);

			//  We'll manually init the container
			self.setup();

			//  We want to keep this script as small as possible
			//  so we'll optimise some checks
			$.each(['nav', 'arrows', 'keys', 'infinite'], function(index, module) {
				self.options[module] && self['init' + $._ucfirst(module)]();
			});

			//  Add swipe support
			if(jQuery.event.special.swipe && self.options.swipe) {
				self.initSwipe();
			}

			//  If autoplay is set to true, call self.start()
			//  to start calling our timeouts
			self.options.autoplay && self.start();

			//  We should be able to recalculate slides at will
			self.calculateSlides();

			//  Listen to a ready event
			self.$context.trigger(self._ + '.ready');

			//  Everyday I'm chainin'
			return self.animate(self.options.index || self.current, 'init');
		};

		self.setup = function() {
			//  Add a CSS hook to the main element
			self.$context.addClass(self.prefix + self.options.animation).wrap('<div class="' + self._ + '" />');
			self.$parent = self.$context.parent('.' + self._);

			//  We need to manually check if the container is absolutely
			//  or relatively positioned
			var position = self.$context.css('position');

			//  If we don't already have a position set, we'll
			//  automatically set it ourselves
			if(position === 'static') {
				self.$context.css('position', 'relative');
			}

			self.$context.css('overflow', 'hidden');
		};

		//  Set up the slide widths to animate with
		//  so the box doesn't float over
		self.calculateSlides = function() {
			self.total = self.$slides.length;

			//  Set the total width
			if(self.options.animation !== 'fade') {
				var prop = 'width';

				if(self.options.animation === 'vertical') {
					prop = 'height';
				}

				self.$container.css(prop, (self.total * 100) + '%').addClass(self.prefix + 'carousel');
				self.$slides.css(prop, (100 / self.total) + '%');
			}
		};


		//  Start our autoplay
		self.start = function() {
			self.interval = setTimeout(function() {
				//  Move on to the next slide
				self.next();

				//  If we've got autoplay set up
				//  we don't need to keep starting
				//  the slider from within our timeout
				//  as .animate() calls it for us
			}, self.options.delay);

			return self;
		};

		//  And pause our timeouts
		//  and force stop the slider if needed
		self.stop = function() {
			clearTimeout(self.interval);

			return self;
		};


		//  Set up our navigation
		self.initNav = function() {
			var $nav = $('<nav class="' + self.prefix + 'nav"><ol /></nav>');

			//  Build our click navigation item-by-item
			self.$slides.each(function(key) {
				//  If we've already set a label, let's use that
				//  instead of generating one
				var label = this.getAttribute('data-nav') || key + 1;

				//  Listen to any callback functions
				if($.isFunction(self.options.nav)) {
					label = self.options.nav.call(self.$slides.eq(key), key, label);
				}

				//  And add it to our navigation item
				$nav.children('ol').append('<li data-slide="' + key + '">' + label + '</li>');
			});
			
			//  Keep a copy of the nav everywhere so we can use it
			self.$nav = $nav.insertAfter(self.$context);

			//  Now our nav is built, let's add it to the slider and bind
			//  for any click events on the generated links
			self.$nav.find('li').on('click' + self.eventSuffix, function() {
				//  Cache our link and set it to be active
				var $me = $(this).addClass(self.options.activeClass);

				//  Set the right active class, remove any other ones
				$me.siblings().removeClass(self.options.activeClass);

				//  Move the slide
				self.animate($me.attr('data-slide'));
			});
		};


		//  Set up our left-right arrow navigation
		//  (Not keyboard arrows, prev/next buttons)
		self.initArrows = function() {
			if(self.options.arrows === true) {
				self.options.arrows = self.defaults.arrows;
			}

			//  Loop our options object and bind our events
			$.each(self.options.arrows, function(key, val) {
				//  Add our arrow HTML and bind it
				self.$arrows.push(
					$(val).insertAfter(self.$context).on('click' + self.eventSuffix, self[key])
				);
			});
		};


		//  Set up our keyboad navigation
		//  Allow binding to multiple keycodes
		self.initKeys = function() {
			if(self.options.keys === true) {
				self.options.keys = self.defaults.keys;
			}

			$(document).on('keyup' + self.eventSuffix, function(e) {
				$.each(self.options.keys, function(key, val) {
					if(e.which === val) {
						$.isFunction(self[key]) && self[key].call(self);
					}
				});
			});
		};

		//  Requires jQuery.event.swipe
		//  -> stephband.info/jquery.event.swipe
		self.initSwipe = function() {
			var width = self.$slides.width();

			self.$container.on({
				swipeleft: self.next,
				swiperight: self.prev,

				movestart: function(e) {
					//  If the movestart heads off in a upwards or downwards
					//  direction, prevent it so that the browser scrolls normally.
					if((e.distX > e.distY && e.distX < -e.distY) || (e.distX < e.distY && e.distX > -e.distY)) {
						return !!e.preventDefault();
					}

					self.$container.css('position', 'relative');
				}
			});

			//  We don't want to have a tactile swipe in the slider
			//  in the fade animation, as it can cause some problems
			//  with layout, so we'll just disable it.
			if(self.options.animation !== 'fade') {
				self.$container.on({
					move: function(e) {
						self.$container.css('left', -(100 * self.current) + (100 * e.distX / width) + '%');
					},

					moveend: function(e) {
						if((Math.abs(e.distX) / width) < $.event.special.swipe.settings.threshold) {
							return self._move(self.$container, {left: -(100 * self.current) + '%'}, false, 200);
						}
					}
				});
			}
		};

		//  Infinite scrolling is a massive pain in the arse
		//  so we need to create a whole bloody function to set
		//  it up. Argh.
		self.initInfinite = function() {
			var pos = ['first', 'last'];

			$.each(pos, function(index, item) {
				self.$slides.push.apply(
					self.$slides,
					
					//  Exclude all cloned slides and call .first() or .last()
					//  depending on what `item` is.
					self.$slides.filter(':not(".' + self._ + '-clone")')[item]()

					//  Make a copy of it and identify it as a clone
					.clone().addClass(self._ + '-clone')

					//  Either insert before or after depending on whether we're
					//  the first or last clone
					['insert' + (index === 0 ? 'After' : 'Before')](
						//  Return the other element in the position array
						//  if item = first, return "last"
						self.$slides[pos[~~!index]]()
					)
				);
			});
		};

		//  Remove any trace of arrows
		//  Loop our array of arrows and use jQuery to remove
		//  It'll unbind any event handlers for us
		self.destroyArrows = function() {
			$.each(self.$arrows, function($arrow) {
				$arrow.remove();
			});
		};

		//  Remove any swipe events and reset the position
		self.destroySwipe = function() {
			//  We bind to 4 events, so we'll unbind those
			self.$container.off('movestart move moveend');
		};

		//  Unset the keyboard navigation
		//  Remove the handler 
		self.destroyKeys = function() {
			//  Remove the event handler
			$(document).off('keyup' + self.eventSuffix);
		};

		self.setIndex = function(to) {
			if(to < 0) {
				to = self.total - 1;
			}

			self.current = Math.min(Math.max(0, to), self.total - 1);

			if(self.options.nav) {
				self.$nav.find('[data-slide="' + self.current + '"]')._active(self.options.activeClass);
			}

			self.$slides.eq(self.current)._active(self.options.activeClass);

			return self;
		};
		
		//  Despite the name, this doesn't do any animation - since there's
		//  now three different types of animation, we let this method delegate
		//  to the right type, keeping the name for backwards compat.
		self.animate = function(to, dir) {
			//  Animation shortcuts
			//  Instead of passing a number index, we can now
			//  use .data('unslider').animate('last');
			//  or .unslider('animate:last')
			//  to go to the very last slide
			if(to === 'first') to = 0;
			if(to === 'last') to = self.total;

			//  Don't animate if it's not a valid index
			if(isNaN(to)) {
				return self;
			}

			if(self.options.autoplay) {
				self.stop().start();
			}

			self.setIndex(to);

			//  Add a callback method to do stuff with
			self.$context.trigger(self._ + '.change', [to, self.$slides.eq(to)]);

			//  Delegate the right method - everything's named consistently
			//  so we can assume it'll be called "animate" + 
			var fn = 'animate' + $._ucfirst(self.options.animation);

			//  Make sure it's a valid animation method, otherwise we'll get
			//  a load of bug reports that'll be really hard to report
			if($.isFunction(self[fn])) {
				self[fn](self.current, dir);
			}

			return self;
		};


		//  Shortcuts for animating if we don't know what the current
		//  index is (i.e back/forward)
		//  For moving forward we need to make sure we don't overshoot.
		self.next = function() {
			var target = self.current + 1;

			//  If we're at the end, we need to move back to the start
			if(target >= self.total) {
				target = 0;
			}

			return self.animate(target, 'next');
		};

		//  Previous is a bit simpler, we can just decrease the index
		//  by one and check if it's over 0.
		self.prev = function() {
			return self.animate(self.current - 1, 'prev');
		};
		

		//  Our default animation method, the old-school left-to-right
		//  horizontal animation
		self.animateHorizontal = function(to) {
			var prop = 'left';

			//  Add RTL support, slide the slider
			//  the other way if the site is right-to-left
			if(self.$context.attr('dir') === 'rtl') {
				prop = 'right';
			}

			if(self.options.infinite) {
				//  So then we need to hide the first slide
				self.$container.css('margin-' + prop, '-100%');
			}

			return self.slide(prop, to);
		};

		//  The same animation methods, but vertical support
		//  RTL doesn't affect the vertical direction so we
		//  can just call as is
		self.animateVertical = function(to) {
			self.options.animateHeight = true;

			//  Normal infinite CSS fix doesn't work for
			//  vertical animation so we need to manually set it
			//  with pixels. Ah well.
			if(self.options.infinite) {
				self.$container.css('margin-top', -self.$slides.outerHeight());
			}

			return self.slide('top', to);
		};

		//  Actually move the slide now
		//  We have to pass a property to animate as there's
		//  a few different directions it can now move, but it's
		//  otherwise unchanged from before.
		self.slide = function(prop, to) {
			//  If we want to change the height of the slider
			//  to match the current slide, you can set
			//  {animateHeight: true}
			if(self.options.animateHeight) {
				self._move(self.$context, {height: self.$slides.eq(to).outerHeight()}, false);
			}

			//  For infinite sliding we add a dummy slide at the end and start
			//  of each slider to give the appearance of being infinite
			if(self.options.infinite) {
				var dummy;

				//  Going backwards to last slide
				if(to === self.total - 1) {
					//  We're setting a dummy position and an actual one
					//  the dummy is what the index looks like
					//  (and what we'll silently update to afterwards),
					//  and the actual is what makes it not go backwards
					dummy = self.total - 3;
					to = -1;
				}

				//  Going forwards to first slide
				if(to === self.total - 2) {
					dummy = 0;
					to = self.total - 2;
				}

				//  If it's a number we can safely set it
				if(typeof dummy === 'number') {
					self.setIndex(dummy);

					//  Listen for when the slide's finished transitioning so
					//  we can silently move it into the right place and clear
					//  this whole mess up.
					self.$context.on(self._ + '.moved', function() {
						if(self.current === dummy) {
							self.$container.css(prop, -(100 * dummy) + '%').off(self._ + '.moved');
						}
					});
				}
			}

			//  We need to create an object to store our property in
			//  since we don't know what it'll be.
			var obj = {};

			//  Manually create it here
			obj[prop] = -(100 * to) + '%';

			//  And animate using our newly-created object
			return self._move(self.$container, obj);
		};


		//  Fade between slides rather than, uh, sliding it
		self.animateFade = function(to) {
			var $active = self.$slides.eq(to).addClass(self.options.activeClass);

			//  Toggle our classes
			self._move($active.siblings().removeClass(self.options.activeClass), {opacity: 0});
			self._move($active, {opacity: 1}, false);
		};

		self._move = function($el, obj, callback, speed) {
			if(callback !== false) {
				callback = function() {
					self.$context.trigger(self._ + '.moved');
				};
			}

			return $el._move(obj, speed || self.options.speed, self.options.easing, callback);
		};

		//  Allow daisy-chaining of methods
		return self.init(options);
	};

	//  Internal (but global) jQuery methods
	//  They're both just helpful types of shorthand for
	//  anything that might take too long to write out or
	//  something that might be used more than once.
	$.fn._active = function(className) {
		return this.addClass(className).siblings().removeClass(className);
	};

	//  The equivalent to PHP's ucfirst(). Take the first
	//  character of a string and make it uppercase.
	//  Simples.
	$._ucfirst = function(str) {
		//  Take our variable, run a regex on the first letter
		return (str + '').toLowerCase().replace(/^./, function(match) {
			//  And uppercase it. Simples.
			return match.toUpperCase();
		});
	};

	$.fn._move = function() {
		this.stop(true, true);
		return $.fn[$.fn.velocity ? 'velocity' : 'animate'].apply(this, arguments);
	};

	//  And set up our jQuery plugin
	$.fn.unslider = function(opts) {
		return this.each(function() {
			var $this = $(this);

			//  Allow usage of .unslider('function_name')
			//  as well as using .data('unslider') to access the
			//  main Unslider object
			if(typeof opts === 'string' && $this.data('unslider')) {
				opts = opts.split(':');

				var call = $this.data('unslider')[opts[0]];

				//  Do we have arguments to pass to the string-function?
				if($.isFunction(call)) {
					return call.apply($this, opts[1] ? opts[1].split(',') : null);
				}
			}

			return $this.data('unslider', new $.Unslider($this, opts));
		});
	};
	
})(window.jQuery);

/*
 * Lean Slider v1.0.1
 * http://dev7studios.com/lean-slider
 *
 * Copyright 2012, Dev7studios
 * Free to use and abuse under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 */

;(function($) {

    $.fn.leanSlider = function(options) {

        // Set up plugin vars
        var plugin = this,
            settings = {},
            slider = $(this),
            slides = slider.children(),
            currentSlide = 0,
            timer = 0;

        var init = function() {
            // Set up settings
            settings = $.extend({}, $.fn.leanSlider.defaults, options);

            // Add inital classes
            slider.addClass('lean-slider');
            slides.addClass('lean-slider-slide');

            currentSlide = settings.startSlide;
            if(settings.startSlide < 0 || settings.startSlide >= slides.length) currentSlide = 0;
            $(slides[currentSlide]).addClass('current');

            // Set up directionNav
            if(settings.directionNav && $(settings.directionNav).length){
                var prevNav = $('<a href="#" class="lean-slider-prev">'+ settings.prevText +'</a>'),
                    nextNav = $('<a href="#" class="lean-slider-next">'+ settings.nextText +'</a>');
                if(settings.directionNavPrevBuilder) prevNav = $(settings.directionNavPrevBuilder.call(this, settings.prevText));
                if(settings.directionNavNextBuilder) nextNav = $(settings.directionNavNextBuilder.call(this, settings.nextText));

                prevNav.on('click', function(e){
                    e.preventDefault();
                    plugin.prev();
                });
                nextNav.on('click', function(e){
                    e.preventDefault();
                    plugin.next();
                });

                $(settings.directionNav).append(prevNav);
                $(settings.directionNav).append(nextNav);
            }

            // Set up controlNav
            if(settings.controlNav && $(settings.controlNav).length){
                slides.each(function(i){
                    var controlNav = $('<a href="#" class="lean-slider-control-nav">'+ (i + 1) +'</a>');
                    if(settings.controlNavBuilder) controlNav = $(settings.controlNavBuilder.call(this, i, $(slides[i])));

                    controlNav.on('click', function(e){
                        e.preventDefault();
                        plugin.show(i);
                    });

                    $(settings.controlNav).append(controlNav);
                });
            }

            // Set up pauseOnHover
            if(settings.pauseOnHover && settings.pauseTime && settings.pauseTime > 0){
                slider.hover(
                    function () {
                        clearTimeout(timer);
                    },
                    function () {
                        doTimer();
                    }
                );
            }

            // Initial processing
            updateControlNav();
            doTimer();

            // Trigger the afterLoad callback
            settings.afterLoad.call(this);

            return plugin;
        };

        // Process timer
        var doTimer = function(){
            if(settings.pauseTime && settings.pauseTime > 0){
                clearTimeout(timer);
                timer = setTimeout(function(){ plugin.next(); }, settings.pauseTime);
            }
        };

        // Update controlNav
        var updateControlNav = function(){
            if(settings.controlNav){
                $('.lean-slider-control-nav', settings.controlNav).removeClass('active');
                $($('.lean-slider-control-nav', settings.controlNav).get(currentSlide)).addClass('active');
            }
        };

        // Prev
        plugin.prev = function(){
            // Trigger the beforeChange callback
            settings.beforeChange.call(this, currentSlide);

            currentSlide--;
            if(currentSlide < 0) currentSlide = slides.length - 1;
            slides.removeClass('current');
            $(slides[currentSlide]).addClass('current');
            updateControlNav();
            doTimer();

            // Trigger the afterChange callback
            settings.afterChange.call(this, currentSlide);
        };

        // Next
        plugin.next = function(){
            // Trigger the beforeChange callback
            settings.beforeChange.call(this, currentSlide);

            currentSlide++;
            if(currentSlide >= slides.length) currentSlide = 0;
            slides.removeClass('current');
            $(slides[currentSlide]).addClass('current');
            updateControlNav();
            doTimer();

            // Trigger the afterChange callback
            settings.afterChange.call(this, currentSlide);
        };

        // Show
        plugin.show = function(index){
            // Trigger the beforeChange callback
            settings.beforeChange.call(this, currentSlide);

            currentSlide = index;
            if(currentSlide < 0) currentSlide = slides.length - 1;
            if(currentSlide >= slides.length) currentSlide = 0;
            slides.removeClass('current');
            $(slides[currentSlide]).addClass('current');
            updateControlNav();
            doTimer();

            // Trigger the afterChange callback
            settings.afterChange.call(this, currentSlide);
        };

        // Call constructor
        return init();
    };

    // Defaults
    $.fn.leanSlider.defaults = {
        pauseTime: 4000,
        pauseOnHover: true,
        startSlide: 0,
        directionNav: '',
        directionNavPrevBuilder: '',
        directionNavNextBuilder: '',
        controlNav: '',
        controlNavBuilder: '',
        prevText: 'Prev',
        nextText: 'Next',
        beforeChange: function(){},
        afterChange: function(){},
        afterLoad: function(){}
    };

})(jQuery);


/*!
* Clamp.js 0.5.1
*
* Copyright 2011-2013, Joseph Schmitt http://joe.sh
* Released under the WTFPL license
* http://sam.zoy.org/wtfpl/
*/

(function(){
    /**
     * Clamps a text node.
     * @param {HTMLElement} element. Element containing the text node to clamp.
     * @param {Object} options. Options to pass to the clamper.
     */
    function clamp(element, options) {
        options = options || {};

        var self = this,
            win = window,
            opt = {
                clamp:              options.clamp || 2,
                useNativeClamp:     typeof(options.useNativeClamp) != 'undefined' ? options.useNativeClamp : true,
                splitOnChars:       options.splitOnChars || ['.', '-', '–', '—', ' '], //Split on sentences (periods), hypens, en-dashes, em-dashes, and words (spaces).
                animate:            options.animate || false,
                truncationChar:     options.truncationChar || '…',
                truncationHTML:     options.truncationHTML
            },

            sty = element.style,
            originalText = element.innerHTML,

            supportsNativeClamp = typeof(element.style.webkitLineClamp) != 'undefined',
            clampValue = opt.clamp,
            isCSSValue = clampValue.indexOf && (clampValue.indexOf('px') > -1 || clampValue.indexOf('em') > -1),
            truncationHTMLContainer;
            
        if (opt.truncationHTML) {
            truncationHTMLContainer = document.createElement('span');
            truncationHTMLContainer.innerHTML = opt.truncationHTML;
        }


// UTILITY FUNCTIONS __________________________________________________________

        /**
         * Return the current style for an element.
         * @param {HTMLElement} elem The element to compute.
         * @param {string} prop The style property.
         * @returns {number}
         */
        function computeStyle(elem, prop) {
            if (!win.getComputedStyle) {
                win.getComputedStyle = function(el, pseudo) {
                    this.el = el;
                    this.getPropertyValue = function(prop) {
                        var re = /(\-([a-z]){1})/g;
                        if (prop == 'float') prop = 'styleFloat';
                        if (re.test(prop)) {
                            prop = prop.replace(re, function () {
                                return arguments[2].toUpperCase();
                            });
                        }
                        return el.currentStyle && el.currentStyle[prop] ? el.currentStyle[prop] : null;
                    }
                    return this;
                }
            }

            return win.getComputedStyle(elem, null).getPropertyValue(prop);
        }

        /**
         * Returns the maximum number of lines of text that should be rendered based
         * on the current height of the element and the line-height of the text.
         */
        function getMaxLines(height) {
            var availHeight = height || element.clientHeight,
                lineHeight = getLineHeight(element);

            return Math.max(Math.floor(availHeight/lineHeight), 0);
        }

        /**
         * Returns the maximum height a given element should have based on the line-
         * height of the text and the given clamp value.
         */
        function getMaxHeight(clmp) {
            var lineHeight = getLineHeight(element);
            return lineHeight * clmp;
        }

        /**
         * Returns the line-height of an element as an integer.
         */
        function getLineHeight(elem) {
            var lh = computeStyle(elem, 'line-height');
            if (lh == 'normal') {
                // Normal line heights vary from browser to browser. The spec recommends
                // a value between 1.0 and 1.2 of the font size. Using 1.1 to split the diff.
                lh = parseInt(computeStyle(elem, 'font-size')) * 1.2;
            }
            return parseInt(lh);
        }


// MEAT AND POTATOES (MMMM, POTATOES...) ______________________________________
        var splitOnChars = opt.splitOnChars.slice(0),
            splitChar = splitOnChars[0],
            chunks,
            lastChunk;
        
        /**
         * Gets an element's last child. That may be another node or a node's contents.
         */
        function getLastChild(elem) {
            //Current element has children, need to go deeper and get last child as a text node
            if (elem.lastChild.children && elem.lastChild.children.length > 0) {
                return getLastChild(Array.prototype.slice.call(elem.children).pop());
            }
            //This is the absolute last child, a text node, but something's wrong with it. Remove it and keep trying
            else if (!elem.lastChild || !elem.lastChild.nodeValue || elem.lastChild.nodeValue == '' || elem.lastChild.nodeValue == opt.truncationChar) {
                elem.lastChild.parentNode.removeChild(elem.lastChild);
                return getLastChild(element);
            }
            //This is the last child we want, return it
            else {
                return elem.lastChild;
            }
        }
        
        /**
         * Removes one character at a time from the text until its width or
         * height is beneath the passed-in max param.
         */
        function truncate(target, maxHeight) {
            if (!maxHeight) {return;}
            
            /**
             * Resets global variables.
             */
            function reset() {
                splitOnChars = opt.splitOnChars.slice(0);
                splitChar = splitOnChars[0];
                chunks = null;
                lastChunk = null;
            }
            
            var nodeValue = target.nodeValue.replace(opt.truncationChar, '');
            
            //Grab the next chunks
            if (!chunks) {
                //If there are more characters to try, grab the next one
                if (splitOnChars.length > 0) {
                    splitChar = splitOnChars.shift();
                }
                //No characters to chunk by. Go character-by-character
                else {
                    splitChar = '';
                }
                
                chunks = nodeValue.split(splitChar);
            }
            
            //If there are chunks left to remove, remove the last one and see if
            // the nodeValue fits.
            if (chunks.length > 1) {
                // console.log('chunks', chunks);
                lastChunk = chunks.pop();
                // console.log('lastChunk', lastChunk);
                applyEllipsis(target, chunks.join(splitChar));
            }
            //No more chunks can be removed using this character
            else {
                chunks = null;
            }
            
            //Insert the custom HTML before the truncation character
            if (truncationHTMLContainer) {
                target.nodeValue = target.nodeValue.replace(opt.truncationChar, '');
                element.innerHTML = target.nodeValue + ' ' + truncationHTMLContainer.innerHTML + opt.truncationChar;
            }

            //Search produced valid chunks
            if (chunks) {
                //It fits
                if (element.clientHeight <= maxHeight) {
                    //There's still more characters to try splitting on, not quite done yet
                    if (splitOnChars.length >= 0 && splitChar != '') {
                        applyEllipsis(target, chunks.join(splitChar) + splitChar + lastChunk);
                        chunks = null;
                    }
                    //Finished!
                    else {
                        return element.innerHTML;
                    }
                }
            }
            //No valid chunks produced
            else {
                //No valid chunks even when splitting by letter, time to move
                //on to the next node
                if (splitChar == '') {
                    applyEllipsis(target, '');
                    target = getLastChild(element);
                    
                    reset();
                }
            }
            
            //If you get here it means still too big, let's keep truncating
            if (opt.animate) {
                setTimeout(function() {
                    truncate(target, maxHeight);
                }, opt.animate === true ? 10 : opt.animate);
            }
            else {
                return truncate(target, maxHeight);
            }
        }
        
        function applyEllipsis(elem, str) {
            elem.nodeValue = str + opt.truncationChar;
        }


// CONSTRUCTOR ________________________________________________________________

        if (clampValue == 'auto') {
            clampValue = getMaxLines();
        }
        else if (isCSSValue) {
            clampValue = getMaxLines(parseInt(clampValue));
        }

        var clampedText;
        if (supportsNativeClamp && opt.useNativeClamp) {
            sty.overflow = 'hidden';
            sty.textOverflow = 'ellipsis';
            sty.webkitBoxOrient = 'vertical';
            sty.display = '-webkit-box';
            sty.webkitLineClamp = clampValue;

            if (isCSSValue) {
                sty.height = opt.clamp + 'px';
            }
        }
        else {
            var height = getMaxHeight(clampValue);
            if (height <= element.clientHeight) {
                clampedText = truncate(getLastChild(element), height);
            }
        }
        
        return {
            'original': originalText,
            'clamped': clampedText
        }
    }

    window.$clamp = clamp;
})();

jQuery(window).on('resize', function(){
  var cw = jQuery('.big-block').outerWidth();
  jQuery('.big-block').css({'height':cw+'px'});
  cw = jQuery('.post-block').outerWidth();
  jQuery('.post-block').css({'height':cw+'px'});
  jQuery('.post-block article p').each(function(){
    $clamp(this, {clamp: 6});
  });
});

jQuery(document).ready(function(){
  jQuery(window).trigger('resize');
  jQuery(window).trigger('resize');
  jQuery(window).trigger('resize');
});



jQuery(function() {
  jQuery("#modal-1").on("change", function() {
    if (jQuery(this).is(":checked")) {
      jQuery("body").addClass("modal-open");
    } else {
      jQuery("body").removeClass("modal-open");
    }
  });

  jQuery(".modal-fade-screen, .modal-close").on("click", function() {
    jQuery(".modal-state:checked").prop("checked", false).change();
  });

  jQuery(".modal-inner").on("click", function(e) {
    e.stopPropagation();
  });
});

jQuery(document).ready(function( $ ) {
  $(window).stellar();
});


