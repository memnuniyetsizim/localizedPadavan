<!DOCTYPE html>
<html>
    <head>
        <title>Lang Parser</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script type='text/javascript' src='js/jquery-1.7.2.min.js'></script>
		<script type="text/javascript" src="js/localizedPadavan.0.8.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
            var nowLang = $(document).cookieControl({ key:'langVal' });
			$(document).localizedPadavan({ changeLang:nowLang ,langUL: 'langList',cookieName: 'langVal' }); 
		});
		</script>
        <style type="text/css">
            #_main_Meta { background-color: #FF66CC; }
			#langList { height:40px; float:left}
            .langContainer ul,li{ list-style: none;padding:4px; margin: 2px; background-color: #000; color: #FFF; cursor:pointer;width: 16px; float:left; text-align:center; }
			.langContainer ul,li:hover { background-color:#E5E5E5; color:#333; }
			.active { background-color:#E5E5E5; color:#333; }
            #pageContainer { float:left; width:100%;}
        </style>
    </head>
    <body>
		<ul id="langList"></ul>
		<div id="pageContainer">
            <span rel="_main_Title"></span> 
            <br />
            <br />
            <span rel="_main_Meta"></span>
        </div>
    </body>
</html>
