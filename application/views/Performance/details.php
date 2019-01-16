<main class="mdl-layout__content mdl-color--grey-100" id="content">
	<div class="mdl-grid demo-content">
		<div class="mdl-card mdl-shadow--2dp demo-todo">
			<div class="mdl-card__title">
				<h2 class="mdl-card__title-text">Performance Details</h2>
			</div>
			<div class="mdl-card__supporting-text">
				<?php if(!empty($result)) : ?>
				<div class="mdl-layout--middle table-responsive">
					<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" id="performance-detail" align="center">
						<thead>
							<tr>
								<th class="mdl-data-table__cell--non-numeric" data-field="date">Date</th>
								<th class="mdl-data-table__cell--non-numeric" data-field="quality">Quality</th>
								<th class="mdl-data-table__cell--non-numeric" data-field="adherence">Hours</th>
								<th class="mdl-data-table__cell--non-numeric" data-field="hold_time">Productivity</th>
								<th class="mdl-data-table__cell--non-numeric" data-field="transfer_rate">Other</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="mdl-data-table__cell--non-numeric" ><?php echo (!empty($result->performance_date)) ?  date('m/d/Y', $result->performance_date ) : '' ; ?></td>
								<td class="mdl-data-table__cell--non-numeric" ><?php echo $result->quality_commitment; ?></td>
								<td class="mdl-data-table__cell--non-numeric" ><?php echo $result->adherence_commitment; ?></td>
								<td class="mdl-data-table__cell--non-numeric" ><?php echo $result->hold_time_commitment; ?></td>
								<td class="mdl-data-table__cell--non-numeric" ><?php echo $result->transfer_rate_commitment; ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="mdl-card__supporting-text">
				<div class="mdl-grid">
					<div class="mdl-layout-spacer"></div>
					<div class="mdl-cell mdl-cell--4-col">
						<form action="<?php echo site_url('performance/details/' . $result->id);?>" method="post" class="mdl-layout" id="form_performance_details" >

							<?php $error_class 		= ( form_error('employee_commitment') != '' )? 'has-error' : ''; ?>
							<?php $disabled_attr 	= ( ( $user_session->user_type != 2 ) || ( $result->is_accepted == 1 ) ) ? 'disabled="disabled"' : ''; ?>
							<?php $checked_attr 	= ( $result->is_accepted == 1 ) ? 'checked="checked"' : ''; ?>

							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<label class="mdl-textfield__label" for="manager_commitment">Manager Commitment</label>
								<textarea class="mdl-textfield__input" disabled="disabled" id="manager_commitment" name="manager_commitment"><?php echo ( !empty( $result->manager_commitment ) )  ? $result->manager_commitment : ''; ?></textarea>
							</div>

							<?php $error_class = ( form_error('employee_commitment') != '' )? 'has-error' : '' ?>
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<label class="mdl-textfield__label" for="employee_commitment">Employee Commitment</label>
								<textarea class="mdl-textfield__input" <?php echo $disabled_attr; ?> id="employee_commitment" name="employee_commitment"><?php echo ( !empty( $result->employee_commitment ) )  ? $result->employee_commitment : ''; ?></textarea>
							</div>
							<?php echo form_error('employee_commitment'); ?>

							<?php //if( $user_session->user_type != 2 ): ?>
								<?php //$error_class = ( form_error('add_score') != '' )? 'has-error' : '' ?>
								<!-- <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<label class="mdl-textfield__label" for="add_score">Add Score</label>
									<input type="text" class="mdl-textfield__input" id="add_score" name="add_score" value="<?php //echo ( !empty( $result->score ) )  ? $result->score : ''; ?>">
								</div> -->
								<?php //echo form_error('add_score'); ?>
							<?php //endif ?>


							<?php $error_class = ( form_error('is_accepted') != '' )? 'has-error' : '' ?>
							<div class="mdl-layout cca-width-100" style="min-height:100px;">
								<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect " for="is_accepted">
								<input type="checkbox" id="is_accepted" name="is_accepted" <?php echo $checked_attr; ?> <?php echo $disabled_attr; ?> class="mdl-checkbox__input" >
									<p>
									 	I agree that I have read this document and will do my best to follow all the instructions in it to become a better agent.
									</p>
								</label>
							</div>
							<?php echo form_error('is_accepted'); ?>

							<div class="mdl-layout">
								<table>
									<tr>
										<?php if( ( $result->is_accepted != 1 ) && ( $user_session->user_type == 2 ) ) :?>
										<?php //if( $result->is_accepted != 1 ) :?>
											<td>
											 	<button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect cca-background-color-dark-green submit_performance">Save</button>
											</td>
										<?php endif?>
										<td>
											<a  href="<?php echo site_url('performance/index') ?>" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" >
												Back
											</a>
										</td>
									</tr>
								</table>
							</div>

							<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
						</form>
					</div>
					<div class="mdl-layout-spacer"></div>
				</div>
				<?php else : ?>
					No record found!
				<?php endif; ?>
			</div>
		</div>
	</div>
</main>