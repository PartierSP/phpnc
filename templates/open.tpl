{include file="header.tpl" title="NC Editor"}

<div>
	<form method="post">
	<select size="15" name="sbfile" multiple="no">
		{html_options values=$filename output=$desc}
	</select>
	<br>
	<label><input type="checkbox" name="cb1" value="spaces" checked>Add White Space (if required)</label>
	<label><input type="checkbox" name="cb2" value="tabs">Use Tabs</label>
	<br>
	<button type="submit" name="action" value="open">
		Open
	</button>
	</form>
</div>

{include file="footer.tpl"}
