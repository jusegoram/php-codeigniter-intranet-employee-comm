<main class="mdl-layout__content mdl-color--grey-100" id="content">
	<meta name="csrf_rcc" content="<?php echo $csrf['hash']; ?>" />
	<div class="mdl-grid demo-content">
		<div class="mdl-card mdl-shadow--2dp demo-todo">
			<?php if( $user_session->user_type != 2): ?>
			<div class="mdl-card__title">
				<div>
					<h2 class="mdl-card__title-text">Performance</h2>
				</div>

				<div class="mdl-cell offset 4">
					<a id="add_notification" href="<?php echo site_url('performance/create'); ?>">
						<label for="add_notification" class="mdl-button mdl-js-button mdl-button--icon">
							<i class="material-icons" title="Add Performance Commitment">add_box</i>
						</label>
					</a>
				</div>
			</div>
			<?php else: ?>
				<div class="mdl-card__title">
					<div>
						<h2 class="mdl-card__title-text">Performance</h2>
					</div>
				</div>
			<?php endif; ?>	
			
			<div class="mdl-layout--middle">
				<table id="performance-table" class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
					<thead>
						<tr>
							<th class="mdl-data-table__cell--non-numeric" data-field="id">S.No</th>
							<th class="mdl-data-table__cell--non-numeric" data-field="performance_for">Performance for</th>
							<th class="mdl-data-table__cell--non-numeric" data-field="performance_date">Performance Date</th>
							<th class="mdl-data-table__cell--non-numeric " data-field="quality">Quality</th>
							<th class="mdl-data-table__cell--non-numeric " data-field="adherence">Adherence</th>
							<th class="mdl-data-table__cell--non-numeric " data-field="hold_time">Hold Time</th>
							<th class="mdl-data-table__cell--non-numeric " data-field="transfer_rate">Transfer Rate</th>
							<th class="mdl-data-table__cell--non-numeric " data-field="status">Accepted</th>
							<th class="mdl-data-table__cell--non-numeric " data-field="action">Action</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</main>

