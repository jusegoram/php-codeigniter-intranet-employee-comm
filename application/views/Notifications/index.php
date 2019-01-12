<main class="mdl-layout__content mdl-color--grey-100" id="content">
	<div class="mdl-grid demo-content">
		<div class="mdl-card mdl-shadow--2dp demo-todo">
			<div class="mdl-card__title">
				<h2 class="mdl-card__title-text">Coming soon...</h2>
			</div>
			<!-- <div class="mdl-layout--middle">
				<table id="user-table" class="mdl-data-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--2dp" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th class="mdl-data-table__cell--non-numeric" data-field="id">ID</th>
							<th class="mdl-data-table__cell--non-numeric" data-field="name">Title</th>
							<th class="mdl-data-table__cell--non-numeric" data-field="email">Description</th>
							<th class="mdl-data-table__cell--non-numeric" data-field="status">Status</th>
							<th class="mdl-data-table__cell--non-numeric" data-field="action">Action</th>
						</tr>
					</thead>

					<tbody>
						<?php if( !empty($results)) : ?>
							<?php foreach ($results as $record) : ?>
								<tr>
									<td class="mdl-data-table__cell--non-numeric" ><?php echo $record->id; ?></td>
									<td class="mdl-data-table__cell--non-numeric" ><?php echo $record->title; ?></td>
									<td class="mdl-data-table__cell--non-numeric" ><?php echo $record->description; ?></td>
									<td class="mdl-data-table__cell--non-numeric" ><?php echo $record->is_enabled; ?></td>
									<td class="mdl-data-table__cell--non-numeric" >
										<a href="<?php echo site_url('notications/edit/'.$record->id); ?>" title="Edit">
											<i class="small material-icons" title="Edit">mode_edit</i>
										</a>
										
										<a href="<?php echo site_url('notifications/remove/'.$record->id); ?>" title="Trash">
											<i class="tiny material-icons" title="Trash">delete</i>
										</a>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>
				</table>
			</div> -->
		</div>
	</div>
</main>

