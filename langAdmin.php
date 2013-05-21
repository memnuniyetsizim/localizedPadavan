<?php
$_GET['Lang']="";
?><!DOCTYPE html>
<html>
    <head>
        <title>localizedPadavan Language Administration Naber</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script type='text/javascript' src='js/jquery-1.7.2.min.js'></script>
		<script type="text/javascript" src="js/localizedPadavan.0.8.js"></script>
		<script type="text/javascript">
		$(document).load(function(){
            var nowLang = ('<?php echo $_GET["Lang"];?>' != '') ? '<?php echo $_GET["Lang"];?>' : $(document).cookieControl({ key:'langVal' });
			$(document).localizedPadavan({ changeLang:nowLang ,langUL: 'langList',cookieName: 'langVal', pane: 'Admin' }); 
			
			$('[alt="onoff"]').each(function(){
				var now = $(this).val();
				var inid = $(this).attr('id');
				$(this).focus(function(){
					var text = $(this).val();
					if(text != '' && text == now){ $(this).val(''); } else { $(this).val(now); }
				});
				$(this).blur(function(){
					var text = $(this).val();
					if(text == ''){ $(this).val(now); }
				});
			});
			$('.newLangContainerButton').css("display",( ($('.createLangTempContainerButton').css("display")=="block")? "none":"block"));
			$('.newLangContainerButton').Click(function(){
				$(this).fadeOut(20);
				
			});
		});
		function NewField(state){
			var FieldText = "Please enter a key value to create";
			var FieldBtnText = "Add New Field";
			var fields = new String();
			var NewFieldItem = new String();
			if(state==0){
				$('#NewFieldKey').val(FieldText).fadeIn(0);
				$('#NewFieldBtn').val("Insert");
				$('#NewFieldBtn').attr("onclick","NewField(1);");
			} else {
				if($('#NewFieldKey').val() != null || $('#NewFieldKey').val() != ''){
					NewFieldItem = $('#NewFieldKey').val();
					$('#NewFieldBtn').val(FieldBtnText);
					fields = '<tr class="' + (($('.langController tr').length % 2 == 0 ) ? 'odd' : 'even') + '">';
					fields += '	<td>'+ NewFieldItem +'</td>';
					fields += '	<td><input type="text" name="' + NewFieldItem + '" value=""/></td>';
					fields += '</tr>';
					$('.langController').append(fields);
					fields = '';
					$('#NewFieldBtn').attr("onclick","NewField(0);");
					$('#NewFieldKey').val('').fadeOut(0);
				}
			}
		}
		</script>
        <style type="text/css">
			* { font-family: Arial; font-size:10px; }
			body { font-family: Arial; font-size:10px;background-color: #CFCFCF; }
			input { font-family: Arial; font-size:10px; }
			.logoContainer { float:left;background-color: #333; width: 100%;padding:4px 20px 4px 20px;margin:0px; }
			.logoContainer h1 { color: #CFCFCF;font-size:22px; font-family: Arial; }
			#pageContainer { float:left; width:420px;}
			
            .contentTitle { position:relative;top:10px;bottom:10px;left:6px; width:400px;height:30px; }
			.menuContainer { position:relative;top:10px;bottom:10px;left:6px;text-align:left; width:400px; height:50px;}
			.formContainer { position:relative;top:10px;bottom:10px;left:6px; }
			.createLangTempContainerButton { width: 140px;height: 20px;padding:4px; padding-top:18px; cursor: pointer; position: absolute; top: 50px; left: 340px; border-radius: 8px;-moz-border-radius:8px; -webkit-border-radius:8px; background-color: #333; color: #E5E5E5; text-align: center; display:none; }
			.newLangContainerButton { width: 140px;height: 20px;padding:4px; padding-top:18px; cursor: pointer; position: absolute; top: 50px; left: 500px; border-radius: 8px;-moz-border-radius:8px; -webkit-border-radius:8px; background-color: #333; color: #E5E5E5; text-align: center; }
			.newLangContainer { position: absolute; top:50px; left:500px; width: 200px;height: 48px; display: none;}

			.langContainer { height:40px; float:left; margin-left:0px; width:400px; text-align:left; }
            .langContainer ul,li{ list-style: none; padding:4px; margin: 2px; background-color: #000; color: #FFF; cursor:pointer;width: 16px; float:left; text-align:center; font-size:12px;font-weight:bold; }
			.langContainer ul,li:hover { background-color:#E5E5E5; color:#333; }
			.active{ background-color:#E5E5E5; color:#333; }
			.langController, tr { width:200px; }
			.langController, tr,td { float:left;padding:4px; }
			.odd { background-color:#E5E5E5;color:#333; }
			.even { background-color:#444444;color:#FFF; }
			.submit { position:relative; border:none; background-color:#444444;color:#FFF; color:#FFF; padding:4px; left:6px; }
        </style>
    </head>
    <body>
	<?php
	/// Temp dosyası oluşturma
	if (isset($_GET["TempCreate"])) {
		$co = array("_main_Title" => " Anasayfa Başlık", "_main_Meta" => "Meta tagları türkçe");
		file_put_contents("lang_temp.json", $dos);
	}

	///// Dil dosyasına oluşturma ve yazma
	if (isset($_GET["Save"]) && trim($_GET["Save"]) != '') {
		$dos .= "{";
		$i=0;
		foreach ($_POST as $key => $value) {
			if($value != ''){
				$dos .= '"'.$key . '":"' . $value.'"' .(($i < (count($_POST)-1)) ? "," : "");
				$i++;
			}
		}
		$dos .= "}";
		file_put_contents("json/lang_" . strtolower($_GET["Save"]) . ".json", $dos);
	}
	?>
		<div id="logoContainer" class="logoContainer">
			<h1>LocalizedPadavan v0.3</h1>
		</div>
		<div class="createLangTempContainerButton">> Create Template</div>
		<div class="newLangContainerButton">> Add New Language</div>
		<div class="newLangContainer">
			<?
			if($_GET['Lang'] == null) {
				/// Giriş sayfası 
				echo "Lütfen dil seçin.";
				?>
				<form method="get">
					Oluşturulacak Dil Kısa Adı
					<input type="text" name="Lang" maxlength="2">
					<input type="submit" value="ekle" />
				</form>
				<?
			}
			?>
		</div>
		<div id="pageContainer">
			
			<div class="contentTitle">Click below list to change language </div>
			<div class="menuContainer">
				<ul id="langList"></ul>
			</div>
			
			<div class="formContainer">
				<form method="post" action="?Save=<?=$_GET['Lang'];?>">
					<input type="submit" value="Save Language" class="submit"/> &nbsp; <br /><br />
					<input type="button" id="NewFieldBtn" value="Add New Field" class="submit" onclick="NewField(0);" />&nbsp; &nbsp; 
					<input type="text" id="NewFieldKey" alt="onoff" style="display:none" />
					<table class="langController"></table>
				</form>
			</div>
        </div>
    </body>
</html>