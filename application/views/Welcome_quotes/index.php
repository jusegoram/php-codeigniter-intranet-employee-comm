<main class="mdl-layout__content mdl-color--grey-100" id="content">
	<meta name="csrf_rcc" content="<?php echo $csrf['hash']; ?>" />
	<div class="mdl-grid demo-content">
		<div class="mdl-card mdl-shadow--2dp demo-todo">
			<div class="mdl-card__title">
				<div>
					<h2 class="mdl-card__title-text">Quotes</h2>
				</div>
				<div class="mdl-cell offset 4">
					<?php if( ( 3 == $user_session->user_type ) || ( 4 == $user_session->user_type ) ): ?>
						<a id="add_welcome_quote" href="<?php echo site_url('welcome_quotes/create'); ?>">	
							<label for="add_welcome_quote" class="mdl-button mdl-js-button mdl-button--icon">
								<i class="material-icons" title="Add Quote">add_box</i>
							</label>
						</a>
					<?php endif; ?>
				</div>
			</div>
			<div class="mdl-layout--middle">
				<table id="welcome_quotes-table" class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" cellspacing="0" style="width:100%;table-layout:fixed">
					<thead>
						<tr>
							<th class="mdl-data-table__cell--non-numeric" data-field="id">S.No</th>
							<th class="mdl-data-table__cell--non-numeric" data-field="email">Welcome Quote</th>
							<?php if( ( 3 == $user_session->user_type ) || ( 4 == $user_session->user_type ) ): ?>
								<th class="mdl-data-table__cell--non-numeric" data-field="action">Action</th>
							<?php endif; ?>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</main>

