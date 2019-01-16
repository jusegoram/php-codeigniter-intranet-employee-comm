<main class="mdl-layout__content mdl-color--grey-100" id="content">
	<div class="mdl-grid demo-content">
		<div class="mdl-card mdl-shadow--2dp demo-todo">
			<div class="mdl-card__title">
				<div>
					<h2 class="mdl-card__title-text">Logs</h2>
				</div>

				<div class="mdl-cell offset 4">
				<?php if( $user_session->user_type != 2): ?>
					<a id="view_issue" href="<?php echo site_url('issues/index'); ?>">
						<label for="view_issue" class="mdl-button mdl-js-button mdl-button--icon">
							<i class="material-icons" title="Manage Issues">assignment</i>
						</label>
					</a>

					<a href="<?php echo site_url('logs/export_logs'); ?>">
						<label for="view_issue" class="mdl-button mdl-js-button mdl-button--icon">
							<i class="material-icons" title="Export Logs">file_download</i>
						<label>
					</a>

				<?php endif; ?>
				</div>
			</div>

			<div class="mdl-layout--middle">
				<table id="logs-table" class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th class="mdl-data-table__cell--non-numeric" data-field="id">ID</th>
							<th class="mdl-data-table__cell--non-numeric" data-field="name">Name</th>
							<th class="mdl-data-table__cell--non-numeric" data-field="avay_number">Avaya Number</th>
							<th class="mdl-data-table__cell--non-numeric" data-field="date">Issue</th>
							<th class="mdl-data-table__cell--non-numeric" data-field="date">Date</th>
							<th class="mdl-data-table__cell--non-numeric" data-field="action">Action</th>
						</tr>
					</thead>

					<tbody>
						<?php if( !empty($results)) : ?>
							<?php foreach ($results as $record) : ?>
								<tr id="<?php echo $record->id; ?>" >
									<td class="mdl-data-table__cell--non-numeric" ><?php echo $record->id; ?></td>
									<td class="mdl-data-table__cell--non-numeric" ><?php echo $record->first_name .' '. $record->last_name; ?></td>
									<td class="mdl-data-table__cell--non-numeric" ><?php echo $record->avaya_number; ?></td>
									<td class="mdl-data-table__cell--non-numeric" ><?php echo $record->issue_name; ?></td>
									<td class="mdl-data-table__cell--non-numeric" ><?php echo date('Y-m-d H:i:s', $record->created_date); ?></td>
									<td class="mdl-data-table__cell--non-numeric">
										<a href="<?php echo site_url('logs/details/' . $record->id) ?>" title="View Log">
											<i class="material-icons">pageview</i>
										</a>

										<?php if( $user_session->user_type == 3): ?>
											<a class="delete_data" href="javascript:void(0);" data-url="<?php echo site_url('logs/remove') ?>" data-id="<?php echo $record->id; ?>" title="Trash">
												<i class="tiny material-icons" title="Trash">delete</i>
											</a>
											<?php endif; ?>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</main>

