{if $jobinfo.rps > 1}
  {include file="header.tpl" title="O'Hara Machine Quality Control System - Data Entry" scp = "dataentry.reading1" color = $color}
{else}
  {include file="header.tpl" title="O'Hara Machine Quality Control System - Data Entry" scp = "dataentry.reading" color = $color}
{/if}

{if $jobid > 0}

	<form name="dataentry" method="post" autocomplete="off">
	<tr><td colspan="6" align="center">
		<b>{$jobinfo.jobname}</b></br>
		Check and record {if $jobinfo.intrval eq "1"}<b>{/if}every {if $jobinfo.intrval>1}<b>{$jobinfo.intrval}{if $jobinfo.intrval eq "2"}nd{else}{if $jobinfo.intrval eq "3"}rd{else}th{/if}{/if}{/if}</b> piece.</br>
		{$jobinfo.jobdesc}
	</td></tr>
{if $jobinfo.rps > 1}
	{for $i=1 to $jobinfo.rps}
		<tr><td>
		</td><td>
		Reading {$i}:
		</td><td>
			<input type="text" name="reading{$i}"/>
		</td>
		{if $i eq 1}
			{if ($curp*50)>1}
				<td bgcolor="#FF0000" align="center" colspan="2">
					<b>Basket requires 100% inspection. ID: {$data[0].dataid}</b>
			{elseif $curcpk < 1}
				<td bgcolor="#FFAA00" align="center" colspan="2">
					Basket marginal. Inspection ID: <b>{$data[0].dataid}</b>
			{else}
					<td bgcolor="90EE90" align="center" colspan="2">
					Basket passed. Inspection ID: <b>{$data[0].dataid}</b>
			{/if}
			</td>
		{/if}
		</tr>
		<tr><td>
	{/for}
{else}
	<tr><td>
	</td><td>
	Reading:
	</td><td>
		<input type="text" name="reading"/>
	</td>
	{if ($curp*50)>1}
		<td bgcolor="#FF0000" align="center" colspan="2">
			<b>Basket requires 100% inspection. ID: {$data[0].dataid}</b>
	{elseif $curcpk < 1}
		<td bgcolor="#FFAA00" align="center" colspan="2">
			Basket marginal. Inspection ID: <b>{$data[0].dataid}</b>
	{else}
		<td bgcolor="90EE90" align="center" colspan="2">
			Basket passed. Inspection ID: <b>{$data[0].dataid}</b>
	{/if}
	</td></tr>
	<tr><td>
{/if}
	</td><td>
	Heat Number:
	</td><td>
		<input type="text" name="heat" value="{$data[0].heat}"/>
	</td></tr>
	<tr><td>
	</td><td>
		<p></p>
	</td>
	{foreach $events as $d_row}
		<td><input type="checkbox" name="evnt{$d_row.eventid}" id="evnt{$d_row.eventid}" value="1" /><label for="evnt{$d_row.eventid}">{$d_row.event} ({$d_row.ecount})</label></td>
		{if $d_row@iteration is div by 3}
			</tr>
			<tr><td>
			</td><td>
				<p></p>
			</td>
		{/if}
	{/foreach}
	</td></tr>
	</td><td>
	</td><td>
		Notes:
	</td><td colspan="3">
		<textarea name="notes" rows="5" cols="80" wrap="virtual"></textarea>
	</td></tr>
	<tr><td colspan="6" align="center">
		<input type="hidden" value="{$jobid}" name="jobid" />
		<input type="hidden" value="{$jobinfo.multiplier}" name="multiplier"/>
		<input type="hidden" value="{$jobinfo.offset}" name="offset"/>
		<input type="hidden" value="{$jobinfo.rps}" name="rps"/>
		<button type="submit">
			Save <img src="images/filesave.png" />
		</button>
	</td></tr>
	</form>

	{if $delete eq "1" }
	{if $lastdatapoint.userid eq $userid}
	<form name="datadelete" method="post">
	<tr><td colspan="6" align="center">
		<input type="hidden" value="{$jobid}" name="jobid" />
		<input type="hidden" value="true" name="deletelast" />
		<button type="submit">
			Delete Last Entry <img src="images/remove.png" />
		</button>
	</td></tr>
	</form>
	{/if}
	{/if}

	<tr><td colspan="6" align="center">
		<b>Current Data Points:</b>
	</td></tr>
	<tr><td align="center">
		<u>Date/Time</u>
	</td><td align="center">
		<u>Measurement</u>
	</td><td align="center">
		<u>In Spec</u>
	</td><td align="center">
		<u>Controlled</u>
	</td><td colspan="2">
		<u>Notes</u>
	</td></tr>
	{foreach $data as $d_row}
		<tr><td align="center">
			{$d_row.time}
		</td><td align="center">
			{$d_row.reading}
		</td>
			{if $d_row.reading>=$jobinfo.minsize && $d_row.reading<=$jobinfo.maxsize}
				<td bgcolor="#90EE90" align="center">
					Good
			{elseif $d_row.reading>$jobinfo.maxsize}
				<td bgcolor="#FF0000" align="center">
					Big
			{else}
				<td bgcolor="#FF0000" align="center">
					Small
			{/if}
		</td>
			{if !empty($d_row.nonconformance)}
				{$severity=0}
				{foreach $d_row.nonconformance as $nc_row}
					{if ((($nc_row.rulenumber <> 7) && ($nc_row.rulenumber <> 4)) && ($nc_row.rulenumber <> 3)) && ($nc_row.rulenumber <> 2)}
						{$severity=$severity + 1}
					{/if}
				{/foreach}
				{if $severity > 0 }
					<td bgcolor="#FF0000" align="center">
						Failed
				{else}
					<td bgcolor="#FFAA00" align="center">
						Warning
				{/if}
			{else}
				<td bgcolor="#90EE90" align="center">
					Good
			{/if}
		</td><td colspan="2">
			{if $d_row.notes>""}
				<p>{$d_row.notes}</p>
			{/if}
			{foreach $d_row.event as $ev_row}
				<p>{$ev_row.event}</p>
			{/foreach}
			{foreach $d_row.nonconformance as $nc_row}
				<p><b>Rule #{$nc_row.rulenumber}</b> - {$nc_row.rule}</p>
			{/foreach}
		</td></tr>
	{/foreach}
	
	<tr><td colspan="6" align="center">
		<b>Current Stats:</b>
	</td></tr>
	<tr><td>
	</td><td>
		Samples: {$curstats.reading_count}
	</td><td>
		Average: {$curstats.reading_avg|ROUND:4}
	</td><td>
		Max: {$curstats.reading_max|ROUND:4}
	</td><td>
		Min: {$curstats.reading_min|ROUND:4}
	</td></tr>
	<tr><td>
	</td><td>
		StdDev: {$curstats.reading_stdev|ROUND:4}
	</td><td>
		Cp: {$curcp|ROUND:2}
	</td><td>
		Cpk: {$curcpk|ROUND:2}
	</td></tr>
	<tr><td>
	</td><td>
		Rejects per 1000: <b>{($curp*1000)|ROUND:2}</b>
	</td><td>
		Rejects per 50: <b>{($curp*50)|ROUND:2}</b>
	</td>
	{if ($curp*50)>1}
		<td bgcolor="#FF0000" align="center" colspan="3">
			<b>Basket requires 100% inspection. ID: {$data[0].dataid}</b>
	{elseif $curcpk < 1}
		<td bgcolor="#FFAA00" align="center" colspan="2">
			Basket marginal. Inspection ID: <b>{$data[0].dataid}</b>
	{else}
		<td bgcolor="90EE90" align="center" colspan="3">
			Basket passed. Inspection ID: <b>{$data[0].dataid}</b>
	{/if}
	</td>
	</td></tr>		
	<tr><td colspan="6" align="center">
		<img src="conchart.php?jobid={$jobid}&limit=10" />
	</td></tr>
	<tr><td colspan="6" align="center">
		<b>Recent Stats:</b>
	</td></tr>
	<tr><td>
	</td><td>
		Samples: {$midstats.reading_count}
	</td><td>
		Average: {$midstats.reading_avg|ROUND:4}
	</td><td>
		Max: {$midstats.reading_max|ROUND:4}
	</td><td>
		Min: {$midstats.reading_min|ROUND:4}
	</td></tr>
	<tr><td>
	</td><td>
		StdDev: {$midstats.reading_stdev|ROUND:4}
	</td><td>
		Cp: {$midcp|ROUND:2}
	</td><td>
		Cpk: {$midcpk|ROUND:2}
	</td></tr>
	<tr><td>
	</td><td>
		Rejects per 1000: <b>{($midp*1000)|ROUND:2}</b>
	</td><td>
		Rejects per 50: <b>{($midp*50)|ROUND:2}</b>
	</td></tr>		
	<tr><td colspan="6" align="center">
		<img src="conchart.php?jobid={$jobid}&limit=30" />
	</td></tr>
	<tr><td colspan="6" align="center">
		<b>Longterm Stats:</b>
	</td></tr>
	<tr><td>
	</td><td>
		Samples: {$stats.reading_count}
	</td><td>
		Average: {$stats.reading_avg|ROUND:4}
	</td><td>
		Max: {$stats.reading_max|ROUND:4}
	</td><td>
		Min: {$stats.reading_min|ROUND:4}
	</td></tr>
	<tr><td>
	</td><td>
		StdDev: {$stats.reading_stdev|ROUND:4}
	</td><td>
		Cp: {$cp|ROUND:2}
	</td><td>
		Cpk: {$cpk|ROUND:2}
	</td></tr>
	<tr><td>
	</td><td>
		Rejects per 1000: <b>{($p*1000)|ROUND:2}</b>
	</td><td>
		Rejects per 50: <b>{($p*50)|ROUND:2}</b>
	</td></tr>		
	<tr><td colspan="6" align="center">
		<img src="conchart.php?jobid={$jobid}&limit=200" />
	</td></tr>
	<tr><td colspan="6" align="center">
		<b>Longterm Trends</b>
	</td></tr>
	<tr><td colspan="6" align="center">
		Running Cpk
	</td></tr>
	<tr><td colspan="6" align="center">
		<img src="cpkchart.php?jobid={$jobid}&limit=1000" />
	</td></tr>
	<tr><td colspan="6" align="center">
		Average Size from Spec Mean
	</td></tr>
	<tr><td colspan="6" align="center">
		<img src="avgchart.php?jobid={$jobid}&limit=1000" />
	</td></tr>
	<tr><td colspan="6" align="center">
		Daily Production Rates
	</td></tr>
	<tr><td colspan="6" align="center">
		<img src="prodchart.php?jobid={$jobid}&limit=1000&group=0" />
	</td></tr>
	<tr><td colspan="6" align="center">
		Weekly Production Rates
	</td></tr>
	<tr><td colspan="6" align="center">
		<img src="prodchart.php?jobid={$jobid}&limit=1000&group=1" />
	</td></tr>

{else}

	<form method="post">
	<tr><td>
	</td><td colspan="2" align="center">
		Select a Job:
		<select name="jobid">
			{html_options values=$jobids output=$jobnames selected=0}
		</select>
		<button type="submit">
		Select <img src="images/ok.png" />
		</button>
	</td></form>

{/if}

{include file="footer.tpl"}
