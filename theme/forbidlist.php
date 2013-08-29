<?php if(REQ !== true) die(); ?>
<h2><i class="icon-ban-circle" style="margin-top:16px;"></i> Forbid List</h2>
The forbid list is lists of banned commands, these commands can not be ran via the rcon console by any user. The normal commands here should prevent users from changing/viewing the server rcon password, or killing the server.<br/><br/>

<table class="table table-hover table-condensed table-striped">
	<thead>
		<tr>
			<th><i class="icon-cog" style="margin-top:2px;"></i> Name</th>
			<th><i class="icon-comment" style="margin-top:2px;"></i> Description</th>
			<th><i class="icon-ban-circle" style="margin-top:2px;"></i> Blocked</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach($forbids as $forbid){
		?>
			<tr>
				<td><?php echo $forbid['name']; ?></td>
				<td><?php echo $forbid['description']; ?></td>
				<td>
				<?php 
					foreach($forbid['vals'] as $cmd){				
				?>
					<?php echo $cmd;?><br/>
				<?php } ?>
				</td>
				<td style="vertical-align:middle;"><i class="icon-edit"></i></td>
			</tr>
		<?php
		}
		?>
	</tbody>
</table>