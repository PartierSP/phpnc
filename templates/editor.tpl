{include file="header.tpl" title="NC Editor"}
<div class="w3-panel w3-card w3-white">
	<form method="post">
		<lable><input class="w3-check" type="checkbox" name="whitesp" value="spaces" id="cbSpacing" checked>Auto spacing</label>
		<label><input class="w3-check" type="checkbox" name="tabs" value="tabs" id="cbTabs">Use Tabs</label>
		<label><input class="w3-check" type="checkbox" name="LineNo" id="cbLineNo" checked>Auto line number</label>
		<br>
		{if isset($prgid)}<input type="hidden" name="prgid" value="{$prgid}">{/if}
		<textarea name="program" id="editor" onkeyup="getLineNumber(this, document.getElementById('current_line'));" onmouseup="this.onkeyup();" rows="30" cols="80" wrap="virtual" spellcheck="false">{$program}</textarea>
		<br>
		<button type="submit" name="action" value="save">
			Save <img src="images/filesave.png">
		</button>
		<div id="renumber">
			<button type="submit" name="action" value="renumber">
				Renumber <img src="images/renumber.png">
			</button>
			Starting:<input type="number" name="startline" value="{$startline}" min="0" step="1" style="width: 4em">
			Increment:<input type="number" name="increment" value="{$increment}" min="1" step="1" style="width: 4em">
		</div>
		<div id="modify">
			<button type="submit" name="action" value="scale">
				Scale
			</button>
			<button type="submit" name="action" value="shift">
				Shift
			</button>
			Axis:<input type="text" name="axis" value="{$axis}" maxlength="1" size="1" style="text-transform: uppercase">
			Modifcation:<input type="number" name="mod" value="{$mod}" step="any" style="width: 6em">
			Precision:<input type="number" name="prec" value="{$prec}" step="1" min="0" max="5" style="width: 3em">
			First Line:<input type="number" name="firstline" value="{$firstline}" min="0" step="1" style="width: 4em">
			Last Line:<input type="number" name="lastline" value="{$lastline}" min="0" step="1" style="width: 4em">
		</div>
	</form>
</div>
<!--<div id="debug"></div> -->
<div id="current_line">Line: 0</div>
<script type="text/javascript">
{literal}
	function getLineNumber(textarea, indicator){
		indicator.innerHTML="Line: "+textarea.value.substr(0, textarea.selectionStart).split("\n").length;
	}

	$("#editor").keypress(function(e){
		var cbSpacing=document.getElementById("cbSpacing");
		var cbTabs=document.getElementById("cbTabs");
//		var debug=document.getElementById("debug");
		var cbLineNo=document.getElementById("cbLineNo");

		var charInput=e.which;
		//debug.innerHTML="Debug: charInput="+charInput;
		if((charInput==13) && (cbLineNo.checked==true)){
			var start = e.target.selectionStart;
			var end = e.target.selectionEnd;
			e.target.value = e.target.value.substring(0, start) + String.fromCharCode(13) + "N0" + e.target.value.substring(end);
			e.target.setSelectionRange(start+3, start+3);
			e.preventDefault();
		}
		if(((charInput >= 97) && (charInput <= 122)) || ((charInput >= 65) && (charInput <= 90)) || (charInput==40) || (charInput==47)) { // Upper or lower case letters, open bracket, or slash
			if(cbSpacing.checked==true){
				if(!e.ctrlKey && !e.metaKey && !e.altKEY) { // no modifier key
					var newChar = charInput - 32;
					var start = e.target.selectionStart;
					var end = e.target.selectionEnd;
					if(start>0){
						if(e.target.value.substring(start-1,start)>"-" && e.target.value.substring(start-1,start)<":"){
							if(cbTabs.checked==true){
								var wscode=9;
							} else {
								var wscode=32;
							}
							e.target.value = e.target.value.substring(0, start) + String.fromCharCode(wscode) + e.target.value.substring(end);
							e.target.setSelectionRange(start+1, start+1);
						}
					}
				}
			}
		}
	});

{/literal}	{if $message>""}window.onload=alert("{$message}");{/if}
 
</script>

{include file="footer.tpl"}
