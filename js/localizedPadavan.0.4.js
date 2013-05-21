$.fn.cookieControl = function(options){
	var defaults = {
		state: 'Read',
		value: '',
		key: '',
		days: 1
	}
	var opts = $.extend(defaults, options);
	if(opts.state == 'Read'){
		var nameEQ = opts.key + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		}
	}
	else if(opts.state == 'Delete'){
		var expires = "";
		document.cookie = opts.key+"="+expires+"; path=/";
	} else {
		if (opts.days) {
			var date = new Date();
			date.setTime(date.getTime()+(opts.days*24*60*60*1000));
			var expires = "; expires="+date.toGMTString();
		}
		else var expires = "";
		document.cookie = opts.key+"="+opts.value+expires+"; path=/";
	}
}
$.fn.localizedPadavan = function(options){
	  var defaults = {
		defaultLang: 'en',
		changeLang: '',
		langUL: 'langList',
		cookieName: 'langVal',
		pane: ''
	  };
	  var docLocation = 'http://'+location.hostname + location.pathname.substr(0, location.pathname.lastIndexOf("/"))+"/";
	  var opts = $.extend(defaults, options);
	  var langFile = docLocation + 'json/lang_' + ((opts.changeLang) ? opts.changeLang : opts.defaultLang)+ '.json';
	  var langContainer = $('#' + opts.langUL);
	  var rowClass,rowText = new String();
	  var count = 0;
		$.getJSON(langFile, function(data) {
			$.each(data, function(key, val) {
				if(opts.pane == 'Admin'){
					rowClass = (count % 2 == 0)? 'odd':'even';
					rowText = '<tr class="'+ rowClass+'"><td> ' + key + ' </td><td> <input type="text" name="' + key + '" value="' + val + '" /> </td></tr>';
					$('.langController').append(rowText);
				}
				var n = $('[rel="'+key+'"]');
				(n.is("input")) ? n.val(val) : n.text(val);
				count++;
			});
			$(document).cookieControl({ state: 'Write',value: ((opts.changeLang) ? opts.changeLang : opts.defaultLang),key: opts.cookieName,days: 30 });
		}).success(function() {
		  })
		  .error(function(e) {
		  	$('.createLangTempContainerButton').css("display","block");
		  })
		  .complete(function() { 

		  });
		
			if(!langContainer){
				$(document).append("<ul id=\""+opts.langUL+"\"></ul>");
			}
			langContainer.html('');
			langContainer.addClass("langContainer");
			$.getJSON(docLocation + 'connectors/langList.php', function(data) {
				$.each(data, function(key, val) {
					if(key != 'lang_temp.json'){
						langContainer.append('<li '+ ((val == ((opts.changeLang) ? opts.changeLang : opts.defaultLang))? 'class="active"' : '') +' ' + ((opts.pane == 'Admin')? 'onclick="window.location=\'?Lang='+val+'\';"': "")+ '>' + val + '</li>');
					} else { $(this).removeClass("active"); }
				});
				$('#' + opts.langUL + ' > li').each(function(){
					$(this).click(function(){ $(document).localizedPadavan({ changeLang: $(this).text(),langUL: opts.langUL, cookieName: opts.cookieName }); $(this).addClass("active"); });
				});
			});
			
};