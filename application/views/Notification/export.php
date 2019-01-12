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
						
					<form action="<?php echo site_url("Notification/export"); ?>" method="post" id="form_export_notification" name="form_export_notification">
							<?php $error_class = ( form_error('date_start') != '' )? 'has-error' : '' ?>
						    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						       <label class="mdl-textfield__label" for="date_start"> Export Notifications From Date </label>
						       <input class="mdl-textfield__input" type="date" id="date_start" name="date_start" >
						    </div>
					       	<?php echo form_error('date_start'); ?>

					       	<?php $error_class = ( form_error('date_end') != '' )? 'has-error' : '' ?>
						    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						       <label class="mdl-textfield__label" for="date_end"> Export Notifications To Date </label>
						       <input class="mdl-textfield__input" type="date" id="date_end" name="date_end" >
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