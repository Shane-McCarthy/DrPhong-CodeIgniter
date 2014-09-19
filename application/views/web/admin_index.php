
<?php $this->load->view('web/template_top'); ?>

<div id="content">
	<div class="span-16">
		<div class="corner-all column">
			<div class="column-padding">
				
				<h1>Doctor Phong Administration</h1>
				
				<dl>
					<dd>
						<a href="/phongalator/users/">Users</a><br />
						Administer system users
					</dd>
					<dd style="margin-top: 1em;">
						<a href="/phongalator/feeds/">Approved Feeds</a><br />
						Add, Edit and Remove blog feeds to be aggregated.
					</dd>
					<dd style="margin-top: 1em;">
						<a href="/phongalator/feeds/approval">Feeds awaiting Approval</a><br />
						Add, Edit and Remove blog feeds waiting to be approved.
					</dd>
				</dl>
				
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('web/template_bottom'); ?>
