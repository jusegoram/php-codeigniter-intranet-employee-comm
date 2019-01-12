<main class="mdl-layout__content mdl-color--grey-100" id="content">
	<meta name="csrf_rcc" content="<?php echo $csrf['hash']; ?>" />
	<div class="mdl-grid demo-content">
		<div class="mdl-card mdl-shadow--2dp demo-todo">
			<div class="mdl-card__title">
				<div>
					<h2 class="mdl-card__title-text">Site Link</h2>
				</div>
				<div class="mdl-cell offset 4">
					<?php if(( 3 == $user_session->user_type ) || ( 4 ==  $user_session->user_type ) ): ?> 
						<a id="add_site_link" href="<?php echo site_url('site_link/create'); ?>"><label for="add_site_link" class="mdl-button mdl-js-button mdl-button--icon"><i class="material-icons" title="Add Site Link">add_box</i></label></a>
					<?php endif; ?>
				</div>
			</div>

			<div class="mdl-layout--middle">
				<table id="site-link-table" class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" cellspacing="0" style="width:100%;table-layout:fixed">
					<thead>
						<tr>
							<th  data-field="id">S.No</th>
							<th  data-field="notification_for">Title</th>
							<th  data-field="notification_type">URL</th>
							<?php if(( 3 == $user_session->user_type ) || ( 4 == $user_session->user_type ) ): ?>
								<th class="mdl-data-table__cell--non-numeric" data-field="action">Action</th>
							<?php endif; ?>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</main>

