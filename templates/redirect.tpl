{include file="header.tpl" title="NC Editor"}

<div>
	File ready. Press Open to continue.
	<form action="{$url}" method="post" id="form">
		{foreach from=$data key=k item=v}
			<input type="hidden" name="{$k}" value="{$v}">
		{/foreach}
		<input type="submit" value="Open">
	</form>
	<br>
</div>

<script>
	window.onload=function(){
		//Wait 1 sec to allow Back Button to work.
		var auto_refresh=setInterval(function() { submitform(); }, 1000);
	
		function submitform() {
			document.forms["form"].submit();
		}
	}
</script>

{include file="footer.tpl"}
