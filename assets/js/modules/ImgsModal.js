/**
 * ImgsModal shows a bootstrap modal when an image is clicked
 */

'use strict';

(function (window, document, undefined) {

	var ImgsModal = function (new_options) {



		this.defaults = {
			'selector': '[data-toggle="modal"]',
			'data_selector': 'target'
		};



		var me = this,
			opts = { ...me.defaults, ...new_options };



		this.init = function () {

			let modals = document.querySelectorAll(opts.selector);

			for (let i = 0; i < modals.length; i++) {
				modals[i].addEventListener('click', me.modalClick);
			}

		};



		this.modalClick = function (e) {

			e.preventDefault();

			let src = this.querySelectorAll('img').getAttribute('src'),
				target = this.data(opts.data_selector),
				$target = document.querySelector(target);

			$target.querySelector('img').setAttribute('src', src);

		};



	};

})(window, document);