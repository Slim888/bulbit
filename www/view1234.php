<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
$(function(){
	$( "#slider-range" ).slider({
		range: true,
		min: 1000,
		max: 60000,
		values: [ 1000, 30000 ],
		slide: function( event, ui ){
			$("#amount0").val(ui.values[0]);
			$("#amount1").val(ui.values[1]);
			var v = Math.log(ui.value-998);
			//$("#test").val(ui.value+'||'+Math.ceil(v*ui.value/1000));
			$( "#slider-range" ).slider( "option", "step", Math.ceil(v*ui.value/1000));
		}
	});
	$( "#amount0" ).keyup(function(){
		if($(this).val()<$( "#slider-range" ).slider("values", 1))
			$( "#slider-range" ).slider("values", 0, $(this).val());
		else
		{
			$( "#slider-range" ).slider("values", 0, $( "#slider-range" ).slider("values", 1)-1);
			$(this).val($( "#slider-range" ).slider("values", 1)-1);
		}
	});
	$( "#amount1" ).keyup(function(){
		if($(this).val()>$( "#slider-range" ).slider("values", 0))
			$( "#slider-range" ).slider("values", 1, $(this).val());
		else
		{
			$( "#slider-range" ).slider("values", 1, $( "#slider-range" ).slider("values", 0)+1);
			$(this).val($( "#slider-range" ).slider("values", 0)+1);
		}
	});
});
  </script>
<p>
	<label for="amount">Price range:</label>
	<input type="text" autocomplete="off" value="1000" id="amount0" style="border:0; color:#f6931f; font-weight:bold;width:100%"><br />
	<input type="text" autocomplete="off" value="30000" id="amount1" style="border:0; color:#f6931f; font-weight:bold;width:100%"><br />
	<!--<input type="text" id="test" readonly style="border:0; color:#f6931f; font-weight:bold;width:100%">-->
</p>
 
<div id="slider-range"></div>
<hr />

<div class="search">
	<input id="search_input" type="text">
	<div id="search_vars"></div>
	<input type="hidden" id="region">
</div>
<style>
#search_input {
	background-color: transparent;
}
#search_vars {
	width: 100%;
	display: none;
	background-color: #ffffff;
	margin: auto;
	width: 90%;
}
</style>
<script>
$(document).ready(function()
{
	$('#search_input').keyup(function()
	{
		if ($('#search_input').val().length >= 2)
			PSearch();
		else
			$('#search_vars').hide();
	});
});
function createObject() {
var request_type;
var browser = navigator.appName;
if(browser == "Microsoft Internet Explorer"){
request_type = new ActiveXObject("Microsoft.XMLHTTP");
}else{
request_type = new XMLHttpRequest();
}
return request_type;
}
var http = createObject();

var nocache = 0;
function PSearch()
{
	var searchTxt = encodeURIComponent($('#search_input').val());
	
	nocache = Math.random();
	http.open('get', '/PSearch.php?searchTxt='+searchTxt+'&nocache='+nocache);
	http.onreadystatechange = function() {PSearchReply();};
	http.send(null);
}
function PSearchReply()
{
	if(http.readyState == 4)
	{
		var response = http.responseText;
		$('#search_vars').html(response);
		$('#search_vars').show();
		$('#region_result td').click(function()
		{
			$('#region').val($(this).data("ids"));
		});
	}
 }
</script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
