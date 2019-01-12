<main class="mdl-layout__content mdl-color--grey-100" id="content">    
	<div class="mdl-grid demo-content">
		<div class="mdl-card mdl-shadow--2dp demo-todo">
			<div class="mdl-card__title">
				<h2 class="mdl-card__title-text">Logs Field Name</h2>
			</div>
			<div class="mdl-card__supporting-text">
				<div class="mdl-grid">
					<div class="mdl-layout-spacer"></div>
					<div class="mdl-cell mdl-cell--4-col">
						
						<?php if(!empty($records)) { ?>
							<form action="<?php echo site_url("logs/logs_field_name"); ?>" method="post" id="form_logs_field_name">

								<?php foreach ($records as $key => $record) { ?>
									<?php //echo $record->field_value; ?>	
									<?php $error_class = ( form_error("field_<?php echo $key + 1; ?>_name") != '' )? 'has-error' : '' ?>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								       <label class="mdl-textfield__label" for="field_<?php echo $key + 1; ?>_name" >Field <?php echo $key + 1; ?> Name</label>

								       <input class="mdl-textfield__input add_field_name" type="text" id="field_<?php echo $key+1; ?>_name" name="field_<?php echo $key+1; ?>_name" 
								       value="<?php echo $record->field_value; ?>" data-url="<?php echo site_url("logs/add_field_name"); ?>" data-id="<?php echo $record->id; ?>" data-field-number="Field <?php echo $key + 1; ?> Name"  />
								    </div>
								    <?php echo form_error("field_<?php echo $key + 1; ?>_name"); ?>
							    <?php } ?>

								<div class="mdl-layout" style="margin-top:3%;">
									<a  href="<?php echo site_url('logs/index') ?>" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" >
										Back							
									</a>
								</div>
								<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
						  	</form>
						<?php } else { ?>
							No record found!
						<?php } ?>
				  	</div>
	   				<div class="mdl-layout-spacer"></div>
				</div>
			</div>
		</div>
	</div>
</main>