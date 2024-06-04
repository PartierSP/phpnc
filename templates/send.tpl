{include file="header.tpl" title="NC Editor"}
<div>
	<form method="post">
		<input type="hidden" name="prgid" value="{$prgid}">
		<input type="hidden" name="mc" value="{$mc}">
		<textarea name="program" id="editor" rows="30" cols="80" wrap="virtual" spellcheck="false">{$program}</textarea>
		<br>
		<button type="submit" name="action" value="send">
			Send <img src="images/upload.png">
		</button>
	</form>
</div>
<div id="progress"></div>

{include file="footer.tpl"}
