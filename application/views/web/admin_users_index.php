
<?php $this->load->view('web/template_top'); ?>

<div id="content">
	<div class="span-24">
		<div class="corner-all column">
			<div class="column-padding">
				
				<h1>Doctor Phong Users</h1>
				
				<table>
					<thead>
						<tr>
							<th>Username</th>
							<th>Email</th>
							<th>Last Seen</th>
							<th>&nbsp;</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<?php foreach ($users as $user): ?>
						<tr>
							<td><a href="/phongalator/users/edit/<?php echo $user->id; ?>"><?php echo $user->username; ?></a></td>
							<td><?php echo $user->email; ?></td>
							<td><?php echo $user->last_seen; ?></td>
							<td><a href="/phongalator/users/edit/<?php echo $user->id; ?>">Edit</a></td>
							<td><a href="/phongalator/users/delete/<?php echo $user->id; ?>">Delete</a></td>
						</tr>
					<?php endforeach; ?>
				</table>
				
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('web/template_bottom'); ?>
