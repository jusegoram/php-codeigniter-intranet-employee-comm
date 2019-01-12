<main class="mdl-layout__content mdl-color--grey-100" id="content">    
	<div class="mdl-grid demo-content">
		<div class="mdl-card mdl-shadow--2dp demo-todo">
			<div class="mdl-card__title">
				<h2 class="mdl-card__title-text">Add</h2>
			</div>
			<div class="mdl-card__supporting-text">
				<div class="mdl-grid">
					<div class="mdl-layout-spacer"></div>
					<div class="mdl-cell mdl-cell--4-col">
						
						<form action="<?php echo site_url("logs/index"); ?>" method="post" id="form_logs">

							<?php $error_class = ( form_error('regarding_issue_id') != '' ) ? 'has-error' : '' ?>
							<div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label">
								<label class="mdl-selectfield__label" for="regarding_issue_id" >Select Issue</label>
							    <select id="regarding_issue_id" class="mdl-selectfield__select user_select" name="regarding_issue_id" >
									<option value=""></option>
									<?php if( !empty( $issues ) ): ?>
										<?php foreach ($issues as $issue) { ?>
											<option value="<?php echo $issue->id; ?>"  <?php echo set_select('regarding_issue_id', $issue->id); ?>  ><?php echo $issue->issue_name; ?></option>
										<?php } ?>
									<?php endif; ?>
								</select>
							</div>
							<?php echo form_error('regarding_issue_id'); ?>

							
						   	<?php $error_class = ( form_error('avaya_number') != '' )? 'has-error' : '' ?>
						    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						       <label class="mdl-textfield__label" for="avaya_number">Avaya Number</label>
						       <input class="mdl-textfield__input" type="text" id="avaya_number" name="avaya_number" value="<?php echo set_value('avaya_number'); ?>" >
						    </div>
					    	<?php echo form_error('avaya_number'); ?>

					    	<?php foreach ($all_field_name as $value) { ?>
					    		<?php $error_class = ( form_error("logs_array[$value->field_title]") != '' )? 'has-error' : '' ?>
						   			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						       			<label class="mdl-textfield__label" for="<?php echo $value->field_title?>"><?php echo $value->field_value; ?></label>
						       			<input class="mdl-textfield__input" type="text" id="<?php echo $value->field_title?>" name="logs_array[<?php echo $value->field_title ?>]" value="<?php echo set_value('logs_array['.$value->field_title.']'); ?>" >
						    		</div>
						    	<?php echo form_error("logs_array[$value->field_title]"); ?>
					    	<?php } ?>

					    	<div class="mdl-layout" style="margin-top:3%;">
								<button type="submit" class="mdl-button cca-background-color-dark-green cca-text-color-white">Save</button>
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