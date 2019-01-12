<main class="mdl-layout__content mdl-color--grey-100" id="content">    
	<div class="mdl-grid demo-content">
		<div class="mdl-card mdl-shadow--2dp demo-todo">
			<div class="mdl-card__title">
				<h2 class="mdl-card__title-text">Export</h2>
			</div>
			<div class="mdl-card__supporting-text">
				<div class="mdl-grid">
					<div class="mdl-layout-spacer"></div>
					<div class="mdl-cell mdl-cell--4-col">
						
						<form action="<?php echo site_url("Logs/export_logs"); ?>" method="post" id="form_export_logs" name="form_export_logs">
						   
							<?php $error_class = ( form_error('regarding_issue_id') != '' ) ? 'has-error' : '' ?>
							<div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label">
								<label class="mdl-selectfield__label" for="regarding_issue_id" >Select Issue for Export</label>
							    <select id="regarding_issue_id" class="mdl-selectfield__select user_select" name="regarding_issue_id" >
									<option value=""></option>
									<?php if( !empty( $issues ) ): ?>
										<?php foreach ($issues as $issue) { ?>
											<option value="<?php echo $issue->id; ?>" ><?php echo $issue->issue_name; ?></option>
										<?php } ?>
									<?php endif; ?>
								</select>
							</div>
							<?php echo form_error('regarding_issue_id'); ?>

							<?php $error_class = ( form_error('date_start') != '' )? 'has-error' : '' ?>
						    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						       <label class="mdl-textfield__label" for="date_start"> Export Logs From Date </label>
						       <input class="mdl-textfield__input" type="text" id="date_start" name="date_start" >
						    </div>
					       	<?php echo form_error('date_start'); ?>

					       	<?php $error_class = ( form_error('date_end') != '' )? 'has-error' : '' ?>
						    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						       <label class="mdl-textfield__label" for="date_end"> Export Logs To Date </label>
						       <input class="mdl-textfield__input" type="text" id="date_end" name="date_end" >
						    </div>
					       	<?php echo form_error('date_end'); ?>

						    <div class="mdl-layout">
								<button type="submit" class="mdl-button cca-background-color-dark-green cca-text-color-white">Export</button>
							</div>

							<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
					  	</form>
				  	</div>
	   				<div class="mdl-layout-spacer"></div>
				</div>
			</div>
		</div>
	</div>
</main>