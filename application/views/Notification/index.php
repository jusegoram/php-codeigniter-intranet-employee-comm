<main class="mdl-layout__content mdl-color--grey-100" id="content">
	<meta name="csrf_rcc" content="<?php echo $csrf['hash']; ?>" />
	
	<div class="mdl-grid demo-content">
		<div class="mdl-card mdl-shadow--2dp demo-todo">
			<div class="mdl-card__title">
				<div>
					<h2 class="mdl-card__title-text">Notification</h2>
				</div>
				<div class="mdl-cell offset 4">
					<?php if( $user_session->user_type != 2): ?>
						<a id="add_notification" href="<?php echo site_url('notification/create'); ?>">
							<label for="add_notification" class="mdl-button mdl-js-button mdl-button--icon">
								<i class="material-icons" title="Add Notification">add_box</i>
							</label>
						</a>
						<a id="export" href="<?php echo site_url('notification/export'); ?>">
							<label for="export" class="mdl-button mdl-js-button mdl-button--icon">
								<i class="material-icons" title="Add Notification">file_download</i>
							</label>
						</a>
					<?php endif; ?>
				</div>
			</div>

			<div class="mdl-layout--middle">
				<table id="notification-table" class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th class="mdl-data-table__cell--non-numeric" data-field="id">S.No.</th>
							<th class="mdl-data-table__cell--non-numeric" data-field="notification_for">Notification for</th>
							<th class="mdl-data-table__cell--non-numeric" data-field="notification_type">Notification Type</th>
							<th class="mdl-data-table__cell--non-numeric " data-field="notification_date">Notification Date</th>
							<th class="mdl-data-table__cell--non-numeric " data-field="document_name">Document Name</th>
							<th class="mdl-data-table__cell--non-numeric " data-field="submitted_by">Submitted By</th>
							<th class="mdl-data-table__cell--non-numeric " data-field="status">Accepted</th>
							<th class="mdl-data-table__cell--non-numeric " data-field="action">Action</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</main>

