{include file="header.tpl" title="NC Editor"}

<div>
	<form method="post">
	<div>
		Select directory to import:</br>
		<select size="15" name="dir" multiple="no">
			{html_options values=$dirs output=$dirs}
		</select>
	</div>

	<div>
		Select machine to associate files to:</br>
		<select name="machine">
			{html_options values=$machineid output=$machine}
		</select>
	</div>
	
	<div>
		</br>
		<button type="submit" name="action" value="open">
			Open
		</button>
	</div>
	</form>
</div>

{include file="footer.tpl"}
