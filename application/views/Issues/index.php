<main class="mdl-layout__content mdl-color--grey-100" id="content">
	<meta name="csrf_rcc" content="<?php echo $csrf['hash']; ?>" />
	<div class="mdl-grid demo-content">
		<div class="mdl-card mdl-shadow--2dp demo-todo">
			<div class="mdl-card__title">
				<div>
					<h2 class="mdl-card__title-text">Issues</h2>
				</div>

				<div class="mdl-cell offset 4">
					<a id="add-issues" href="<?php echo site_url('issues/create'); ?>">
						<label for="add-issues" class="mdl-button mdl-js-button mdl-button--icon">
							<i class="material-icons" title="Add Issue">add_circle</i>
						</label>
					</a>
				</div>
			</div>

				
			<div class="mdl-layout--middle">
				<table id="issues-table" class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th class="mdl-data-table__cell--non-numeric" data-field="id">S.N</th>
							<th class="mdl-data-table__cell--non-numeric" data-field="name">Issue Name</th>
							<th class="mdl-data-table__cell--non-numeric" data-field="action">Action</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</main>

