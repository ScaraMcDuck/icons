// JavaScript Document

//init dropdown elements for IE6

function initDropDowns(){

	$("ul.dropdown li").hover( function() {
   		// On mouse-over...
   		$(this).addClass("over");
	}, function() {
	   // On mouse-out...
	   $(this).removeClass("over");
	});
	
}

//focus prototype

$.fn.setfocus = function() {
	
	return this.focus(function() {
		if( this.value == this.defaultValue ) {
			this.value = "";
		}
	}).blur(function() {
		if( !this.value.length ) {
			this.value = this.defaultValue;
		}
	});
};