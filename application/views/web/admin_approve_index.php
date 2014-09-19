
<?php $this->load->view('web/template_top'); ?>

<div id="content">
	<div class="span-24">
		<div class="corner-all column">
			<div class="column-padding">
				
				<h1>Doctor Phong Feeds for Approval</h1>
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
							<th>Feed URL</th>
							<th>Owner</th>
							<th>&nbsp;</th>
							<th>&nbsp;</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<?php foreach ($feeds as $feed): ?>
						<tr>
							<td valign="top"><a href="/phongalator/feeds/edit/<?php echo $feed->id; ?>"><?php echo $feed->name; ?></a></td>
							<td valign="top">
                                <span class="small">Site URL: <a href="<?php echo $feed->url; ?>"><?php echo $feed->url; ?></a></span><br />
                                <span class="small">Feed URL: <a href="<?php echo $feed->feed_url; ?>"><?php echo $feed->feed_url; ?></a></span>
                            </td>
							<td valign="top"><?php echo $feed->owner; ?></td>
                            <td valign="top"><a href="/phongalator/feeds/edit/<?php echo $feed->id; ?>">Edit</a></td>
                            <td valign="top"><a href="/phongalator/feeds/approve/<?php echo $feed->id; ?>" style="color:#00CC00;">Approve</a></td>
                            <td valign="top"><a href="/phongalator/feeds/disapprove/<?php echo $feed->id; ?>" style="color:#CC0000;">Disapprove</a></td>
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
