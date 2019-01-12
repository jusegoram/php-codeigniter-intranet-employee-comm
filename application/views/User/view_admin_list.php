<main class="mdl-layout__content mdl-color--grey-100" id="content">
	<meta name="csrf_rcc" content="<?php echo $csrf['hash']; ?>" />
	
	<div class="mdl-grid demo-content">
		<div class="mdl-card mdl-shadow--2dp demo-todo">
			<div class="mdl-card__title">
				<div class="mdl-cell mdl-cell--2-col">
					<h2 class="mdl-card__title-text">Admin list</h2>
				</div>
			</div>

			<div class="mdl-layout--middle">
				<table id="admin-table" class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th data-field="id">S.No</th>
							<th data-field="name">Name</th>
							<th data-field="employee_id">Employee ID</th>
							<th data-field="avaya_number">Avaya Number</th>
							<th data-field="email">Email</th>
							<th data-field="type">Type</th>
							<?php if( 3 == $user_session->user_type ): ?>
								<th class="mdl-data-table__cell--non-numeric" data-field="action">Action</th>
							<?php endif; ?>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</main>



