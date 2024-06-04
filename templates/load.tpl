{include file="header.tpl" title="NC Editor"}

<div>
	<form method="post">
		<div>
			Select machine:
			<select name="mc" onchange="showprograms(this.value)">
				{html_options values=$machineid output=$machine selected=$mc}
			</select>
		</div>
		
		<div id="prgtable">
			{include file="prgtable.tpl" list=$list}
		</div>
		
		<div>
			<div id="selrow">
			</div>
			<label><input type="checkbox" name="whitesp" value="spaces" checked>Add White Space (if required)</label>
			<label><input type="checkbox" name="tabs" value="tabs">Use Tabs</label>
			<button type="submit" name="action" value="open">
				Go
			</button>
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

	function showprograms(mc) {
		var tbl=new XMLHttpRequest();
		tbl.onreadystatechange=function(){
			if(this.readyState==4 && this.status==200){
				document.getElementById("prgtable").innerHTML=this.responseText;
			}
		};
		tbl.open("GET", "prglist.php?mc="+mc,true);
		tbl.send();
	}


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
