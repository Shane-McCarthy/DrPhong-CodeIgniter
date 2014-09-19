
<?php $this->load->view('web/template_top'); ?>

<div id="content">
	<div class="span-24">
		<div class="corner-all column">
			<div class="column-padding">
				
				<h1>Doctor Phong Feeds</h1>
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
				<a href="/phongalator/feeds/add">[ Add a Feed ]</a>
				
				<table>
					<thead>
						<tr>
							<th>Site Name</th>
							<th>Site URL</th>
							<th>Feed URL</th>
							<th>Last Crawled</th>
						</tr>
					</thead>
					<?php foreach ($feeds as $feed): ?>
						<tr>
							<td><a href="/phongalator/feeds/edit/<?php echo $feed->id; ?>"><?php echo $feed->name; ?></a></td>
							<td><?php echo $feed->url; ?></td>
							<td><?php echo $feed->feed_url; ?></td>
							<td><?php echo $feed->last_crawled; ?></td>
						</tr>
					<?php endforeach; ?>
					<tfoot>
						<td colspan="3">Showing <?php echo sizeof($feeds); ?> blogs currently being agregated</td>
					</tfoot>
				</table>
				
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('web/template_bottom'); ?>
