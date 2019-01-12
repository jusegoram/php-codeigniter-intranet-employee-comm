<main class="mdl-layout__content mdl-color--grey-100" id="content">    
	<div class="mdl-grid demo-content">
		<div class="mdl-card mdl-shadow--2dp demo-todo">
			<div class="mdl-card__title">
				<h2 class="mdl-card__title-text">Update Global Notification</h2>
			</div>
			<div class="mdl-card__supporting-text">	
				<div class="mdl-grid">
					<?php if(!empty($result)) :?>
						<div class="mdl-layout-spacer"></div>
						<div class="mdl-cell mdl-cell--4-col">	
							<form action="<?php echo site_url('global_notification/edit/' . $result->id);?>" method="post" id="edit_form_global_notifications" enctype="multipart/form-data">
							    
								<?php $error_class = ( form_error('user_id') != '' )? 'has-error' : '' ?>
							    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<label class="mdl-textfield__label" for="user_id" >User</label>
								    <input class="mdl-textfield__input" type="text" id="user_id" name="user_id" disabled="disabled" value="<?php echo set_value('user_id', $result->first_name.' '.$result->last_name); ?>">
								</div>
								<?php echo form_error('user_id'); ?>

							    <?php $error_class = ( form_error('notification_type') != '' )? 'has-error' : '' ?>
								<div class="mdl-textfield mdl-js-textfield mdl-textfield">
									<label class="mdl-textfield__label" for="user_id" >Notification Type</label>
								    <select id="notification_type"  name="notification_type" class="mdl-textfield__input" <?php echo set_select('notification_type', $result->notification_type); ?> >
										<option value="1" <?php echo ( 1 == $result->notification_type ) ? 'selected="selected"' : '' ?>> Warning </option>
										<option value="2" <?php echo ( 2 == $result->notification_type ) ? 'selected="selected"' : '' ?>> Agreement </option>
									</select>
								</div>
								<?php echo form_error('notification_type'); ?>

								<?php $error_class = ( form_error('notification_text') != '' )? 'has-error' : '' ?>
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							       	<label class="mdl-textfield__label" for="notification_text">Notification Text</label>
									<textarea class="mdl-textfield__input" id="notification_text" name="notification_text"><?php echo set_value('notification_text', $result->notification_text); ?></textarea>
								</div>
							    <?php echo form_error('notification_text'); ?>
								
								<?php $error_class = ( form_error('notification_date') != '' )? 'has-error' : '' ?>
							    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">

							       <label class="mdl-textfield__label" for="notification_date"> Notification Date </label>
							       <input class="mdl-textfield__input common-date-class" type="text" id="notification_date" name="notification_date" value="<?php echo set_value('notification_date',  date('Y-m-d', $result->notification_date)); ?>">
							    </div>
								<?php echo form_error('notification_date'); ?>

							    <?php $error_class = ( form_error('document_name') != '' )? 'has-error' : '' ?>
							    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							       <label class="mdl-textfield__label" for="document_name">Document Name</label>
							       <input class="mdl-textfield__input" type="text" id="document_name" name="document_name" value="<?php echo set_value('document_name', $result->document_name); ?>">
							    </div>
						    	<?php echo form_error('document_name'); ?>

						    	<input class="mdl-textfield__input" type="hidden" id="uploaded_file" name="uploaded_file" value="<?php echo set_value('uploaded_file', $result->file_name); ?>">
						    	<?php if( !empty($result->file_name) ) { ?>
							    	<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								       <strong>Uploaded File : </strong><?php echo set_value('uploaded_file1', substr($result->file_name, 0, -15).$file_ext); ?>
								       <a class="delete_file_name" href="javascript:void(0);" data-url="<?php echo site_url('global_notification/delete_file');?>" data-id="<?php echo $result->id; ?>" title="Remove File"><i style="top-margin:2px;" class="material-icons" title="Remove File">cancel</i></a>
								    </div>
								<?php } ?>

						    	<?php $error_class = ( form_error('file_name') != '' )? 'has-error' : '' ?>
							    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							       <input class="mdl-textfield__input" type="file" id="file_name" name="file_name">
							    </div>
						       	<?php echo form_error('file_name'); ?>

							    <?php $error_class = ( form_error('manager_comment') != '' )? 'has-error' : '' ?>
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							       	<label class="mdl-textfield__label" for="manager_comment">Manager Comment</label>
									<textarea class="mdl-textfield__input" id="manager_comment" name="manager_comment"><?php echo set_value('manager_comment', $result->manager_comment); ?></textarea>
								</div>
							    <?php echo form_error('manager_comment'); ?>

								<div class="clear"> </div>
								<div class="mdl-layout">
									<button type="submit" class="mdl-button cca-background-color-dark-green cca-text-color-white">Save</button>
								</div>

								<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
						  	</form>
						</div>
						<div class="mdl-layout-spacer"></div>
					<?php else :?>
						No record found!
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</main>