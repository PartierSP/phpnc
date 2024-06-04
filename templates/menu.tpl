{include file="header.tpl" title="NC Editor"}

<div class="w3-panel w3-card w3-white">
	<p><a href="editor.php" class="w3-button">New File</a></p>
	<p><a href="open.php" class="w3-button">View File on Drive</a></p>
	<p><a href="load.php" class="w3-button">Open File</a></p>
	<p><a href="send.php" class="w3-button">Send File</a></p>
	<p>Recieve File</p>
	<p><a href="machine.php" class="w3-button">Edit Machine Settings</a></p>
	{if $showetimport eq 1}<p><a href="etimport.php" class="w3-button">Import EasyTalk directory</a></p>{/if}
</div>

{include file="footer.tpl"}
