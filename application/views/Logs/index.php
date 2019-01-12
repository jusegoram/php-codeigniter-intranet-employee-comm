<main class="mdl-layout__content mdl-color--grey-100" id="content">
<meta name="csrf_rcc" content="<?php echo $csrf['hash']; ?>" />
	<div class="mdl-grid demo-content">
		<div class="mdl-card mdl-shadow--2dp demo-todo">
			<div class="mdl-card__title">
				<div>
					<h2 class="mdl-card__title-text">Logs</h2>
				</div>

				<div class="mdl-cell offset 4">
				<?php if( $user_session->user_type != 2 ): ?>
					<a id="view_issue" href="<?php echo site_url('issues/index'); ?>"><label for="view_issue" class="mdl-button mdl-js-button mdl-button--icon"><i class="material-icons" title="Manage Issues">assignment</i></label></a>
									
					<?php if( ( 3 == $user_session->user_type ) || ( 4 == $user_session->user_type ) ): ?>
						<a id="export_logs" href="<?php echo site_url('logs/export_logs'); ?>"><label for="export_logs" class="mdl-button mdl-js-button mdl-button--icon"><i class="material-icons" title="Export Logs">file_download</i></label></a>	
						<a id="logs_field_name" href="<?php echo site_url('logs/logs_field_name'); ?>"><label for="logs_field_name" class="mdl-button mdl-js-button mdl-button--icon"><i class="material-icons" title="Add Field Name">add_box</i></label></a>
					<?php endif; ?>

				<?php endif; ?>
				</div>
			</div>

			<div class="mdl-layout--middle">
				<table id="logs-table" class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th class="mdl-data-table__cell--non-numeric" data-field="id">S.No</th>
							<th class="mdl-data-table__cell--non-numeric" data-field="name">Name</th>
							<th class="mdl-data-table__cell--non-numeric" data-field="avaya_number">Avaya Number</th>
							<th class="mdl-data-table__cell--non-numeric" data-field="Issue">Issue</th>
							<th class="mdl-data-table__cell--non-numeric" data-field="date">Date</th>
							<th class="mdl-data-table__cell--non-numeric" data-field="action">Action</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</main>

