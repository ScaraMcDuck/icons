var ImageSearch = {
	// Create form
	'initialize': function () {
		var container = document.getElementById('image-search');
		if (!container) return;
		ImageSearch.container = container;
		
		var config = container.getElementsByTagName('span');
		for (var i = 0; i < config.length; i++) { 
			if (config[i].getAttribute('title') == 'equalHeight') 
				ImageSearch.equalHeight = config[i].getAttribute('class');
		}
		while (container.firstChild)
			container.removeChild(container.firstChild);
		
		var form = document.createElement('form');
		form.setAttribute('action', wgScript);
		form.style.cssText = 'background-color: #effbf2; border: 1px solid #52c040; ' +
			'text-align: center; height: 100%; float: right; width: 360px;' + 
			'margin-bottom: 0.5em;';
		
		var fieldset = document.createElement('div');
		var legend = document.createElement('p');
		legend.style.cssText = 'border-bottom: 1px solid #52c040; background-color: #d0f0d5; ' + 
			'font-weight: bold; ' + 
			'margin: 0; padding: 0 0.2em; text-align: left;';
		legend.appendChild(document.createTextNode(ImageSearch.msg('desc')));
		fieldset.appendChild(legend);
		fieldset.appendChild(document.createTextNode('\n'));
		
		var image = document.createElement('img');
		image.setAttribute('src', ImageSearch.image);
		image.style.cssText = 'float: left; margin: 4px;';
		if ( !ImageSearch.equalHeigth ) image.style.height = '24px';
		fieldset.appendChild(image);
		
		var input = document.createElement('input');
		input.setAttribute('id', 'search-query');
		input.setAttribute('size', '50');
		input.setAttribute('name', 'search');
		input.style.cssText = 'position: relative; top: ' + 
			(6 - input.scrollHeight / 2) + 'px';
		ImageSearch.input = input;
		fieldset.appendChild(input);
		fieldset.appendChild(document.createTextNode('\n'));
		
		var submit = document.createElement('input');
		submit.setAttribute('type', 'submit');
		submit.setAttribute('value', ImageSearch.msg('submit'));
		submit.style.cssText = 'position: relative; top: ' + 
			(6 - submit.scrollHeight / 2) + 'px; ' + 
			'margin-left: 2px;';
		ImageSearch.submit = submit;
		fieldset.appendChild(submit);
		
		var clear = document.createElement('p');
		clear.style.cssText = 'clear: both;';
		fieldset.appendChild(clear);
		
		ImageSearch.fieldset = fieldset;
		form.appendChild(fieldset)

		function hidden(name, value) {
			var element = document.createElement('input');
			element.setAttribute('type', 'hidden');
			element.setAttribute('name', name);
			element.setAttribute('value', value);
			return element;
		}

		form.appendChild(hidden('title', 'Special:Search'));
		form.appendChild(hidden('ns6', '1'));
		form.appendChild(hidden('searchx', '1'));

		container.appendChild(form);
		hookEvent('resize', ImageSearch.resize);
		
		ImageSearch.resize();
	},
	
	'resize': function () {
		var width = ImageSearch.fieldset.scrollWidth - 64 - ImageSearch.submit.offsetWidth;
		ImageSearch.input.style.width = width + 'px';
		if (ImageSearch.equalHeight) {
			ImageSearch.container.style.position = 'relative';
			ImageSearch.container.style.height = document.getElementById(
				ImageSearch.equalHeight).offsetHeight + 'px';
		}
	},
	
	'image': 'http://upload.wikimedia.org/wikipedia/commons/thumb/0/0d/Crystal_128_kview.png/24px-Crystal_128_kview.png',
	'submit': null,
	'input': null,
	'fieldset': null,
	'container': null,
	'equalHeight': null,

	// i18n functions

	'lang': wgContentLanguage,
	'msg' : function(key) {
		if (ImageSearch.i18n[ImageSearch.lang][key]) 
			return ImageSearch.i18n[ImageSearch.lang][key];
		return ImageSearch.i18n['en'][key];
	},
	
	'i18n': {
		'en': {
			'desc': 'Search files on Commons',
			'term': 'Search file:',
			'submit': 'Search'
		}
	}
};

addOnloadHook(ImageSearch.initialize);