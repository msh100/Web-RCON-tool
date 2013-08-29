<?php if(REQ !== true) die(); ?>
<h2><i class="icon-list-alt" style="margin-top:16px;"></i> Server List</h2>
<table class="table table-hover table-condensed table-striped">
	<thead>
		<tr>
			<th><i class="icon-cog" style="margin-top:2px;"></i> ID</th>
			<th><i class="icon-comment" style="margin-top:2px;"></i> Name</th>
			<th><i class="icon-globe" style="margin-top:2px;"></i> IP Address</th>
			<th><i class="icon-lock" style="margin-top:2px;"></i> RCON</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach($servers as $server){
		?>
			<tr>
				<td><?php echo $server['sid']; ?></td>
				<td>
					<img src="./img/<?php echo $server['type']; ?>.gif" style="margin-top:-3px;"/> 
					<?php echo q3cols($server['name']); ?>
				</td>
				<td><img src="flags/<?php echo strtolower(ip2country($server['ip'])); ?>.png"/> <?php echo long2ip($server['ip']); ?>:<?php echo $server['port']; ?></td>
				<td><?php echo $server['rcon']; ?></td>
				<td><i class="icon-edit" style="margin-top:2px;"></i></td>
			</tr>
		<?php
		}
		?>
	</tbody>
</table>
