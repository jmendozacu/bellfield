var EsNewsSubscribers = {
    cookieLiveTime: 100,
    cookieName: 'es_newssubscriber',
    baseUrl: '',
    setCookieLiveTime: function(value)
    { this.cookieLiveTime = value;},
    setCookieName: function(value)
    {this.cookieName = value;},
    setBaseUrl: function(url)
    {this.baseUrl = url;},
    getBaseUrl: function(url)
    {return this.baseUrl;},
    createCookie: function() {
        var days = this.cookieLiveTime;
        var value = 1;
        var name = this.cookieName;
        if (days) {var date = new Date();date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();}
	else var expires = ""; document.cookie = escape(name)+"="+escape(value)+expires+"; path=/"; },
    readCookie: function(name) {
        var name = this.cookieName;
        var nameEQ = escape(name) + "=";
        var ca = document.cookie.split(';');
        for(var i=0;i < ca.length;i++) {var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return unescape(c.substring(nameEQ.length,c.length));
        } return null;
    },
    boxClose: function(){
		_bottom_height = parseInt(jQuery('#esns_box_layer').height());
		_header_height = parseInt(jQuery('.newsletter-popup-header').height());
		_bottom = _bottom_height - _header_height;
		jQuery('#esns_box_layer').css({'bottom':'-'+(_bottom-12)+'px'});
		window.setTimeout(function(){jQuery('#esns_box_layer').removeClass("shown"); }, 300);
    },
boxOpen: function(){jQuery('#esns_box_layer').addClass("shown").css({'bottom':0});}};
jQuery(function() {jQuery('#esns_box_close').click(function(){EsNewsSubscribers.boxClose(); });});
jQuery.noConflict();