{include file="header.tpl" title="NC Editor"}

<div>
	<form method="post">
		<div>
			Select machine:
			<select name="mc">
				{html_options values=$machineid output=$machine selected=$mc}
			</select>
		</div>
		
		<div>
			Port:
			<input type="text" name="port" value="{$port}">
			<br>
			Baud Rate:
			<select name="bd">
				{html_options values=$baudid output=$baud selected=$bd}
			</select>
			<br>
			Parity:
			<select name="par">
				{html_options values=$parityid output=$parity selected=$par}
			</select>
			<br>
			Data Bits:
			<select name="dat">
				{html_options values=$datasizeid output=$datasize selected=$dat}
			</select>
			<br>
			Stop Bits:
			<select name="stp">
				{html_options values=$stopid output=$stop selected=$stp}
			</select>
			<br>
			Flowcontrol:
			<select name="flw">
				{html_options values=$flowid output=$flow selected=$flw}
			</select>
		</div>
		
		<div>
			{if $mc>0}
			<button type="submit" name="action" value="save">
				Save
			</button>
			{else}
			<button type="submit" name="action" value="load">
				Load
			</button>
			{/if}
		</div>
	</form>
</div>

{literal}
<script>
	function highlight(e) {
		if (selected[0]) selected[0].className = '';
		e.target.parentNode.className = 'selected';
	}

	var table = document.getElementById('proglist'),
		selected = table.getElementsByClassName('selected');
	table.onclick = highlight;

	$(document).ready(function () {
		$('#proglist tr').click(function (event) {
			var elID=$(this).attr('id');
			//alert(elID);
			document.getElementById('selrow').innerHTML="<input type=hidden name=prgid value="+elID+">";
		});
	});


//	var rows = document.querySelectorAll("#proglist tr");
//	for (var i = 0; i < rows.length; i++) {
//		rows[i].addEventListener('click', function() {
//			[].forEach.call(rows, function(el) {
//				el.classList.remove("highlight");
//				});
//			this.className += ' highlight';
//		}, false);
//	}

</script>
{/literal}
{include file="footer.tpl"}
