			<table id="proglist">
				<thead>
					<tr>
						<th width=305>Description</th>
						<th width=109>Name &#8595</th>
						<th width=75>Created</th>
						<th width=75>Edited</th>
					</tr>
				</thead>
				<tbody>
					{foreach $list as $d_row}<tr id="{$d_row.programid}">
						<td>{$d_row.description}</td>
						<td>{$d_row.name}</td>
						<td>{$d_row.createddate}</td>
						<td>{$d_row.editeddate}</td>
					</tr>
					{/foreach}
				</tbody>
			</table>
