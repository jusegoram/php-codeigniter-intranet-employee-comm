<main class="mdl-layout__content mdl-color--grey-100" id="content">    
	<div class="mdl-grid demo-content">
		<div class="mdl-card mdl-shadow--2dp demo-todo">
			<div class="mdl-card__title">
				<h2 class="mdl-card__title-text">Global Notification Details</h2>
			</div>
			<div class="mdl-card__supporting-text">
				<div class="mdl-grid">
					<?php if(!empty($result)) : ?>
						<div class="mdl-cell mdl-cell--10-col">
							<form action="<?php echo site_url('global_notification/details/' . $result->id);?>" method="post" class="mdl-layout" id="form_notification_details" >
							    
							    <?php if( !empty($result->file_name)) { ?>
									
									<?php if( !file_exists(NOTIFICATION_ROOT_UPLOAD_PATH.'/'.$result->file_name) ) { ?>
										<p style="font-weight:bold;font-size:20px;">File does not exists</p>
									<?php } else { ?>
										<iframe id="iframe1" name="iframe1" src="<?php echo ASSETS_PATH .'/ViewerJS/#../uploads/notification_data/'.$result->file_name; ?>" style="width:100%; min-height:600px; margin:0px; padding:0px;" allowfullscreen webkitallowfullscreen></iframe>
									<video src="<?php echo ASSETS_PATH .'/uploads/notification_data/'.$result->file_name; ?>" autoplay="false" controls style="width:100%; min-height:400px; margin:0px; padding:0px;" ></video>
									<?php }  ?>
								<?php } ?>

									
									<div class="cca-block">
										<div class="cca-pull-left cca-text-align-left">
											<div><strong>Submitted By</strong></div>
											<?php echo $result->submit_first_name . ' ' . $result->submit_last_name; ?> 
										</div>

										<div class="cca-pull-right cca-text-align-right">
											<div><strong>Submitted To</strong></div>
											<?php echo $result->first_name . ' ' . $result->last_name; ?> 
										</div>
									</div>

									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<label class="mdl-textfield__label" for="notification_text">Notification Text</label>
										<textarea class="mdl-textfield__input" disabled="disabled" id="notification_text" name="notification_text"><?php echo ( !empty( $result->manager_comment ) )  ? $result->notification_text : ''; ?></textarea>
									</div>

									<?php $error_class 		= ( form_error('employee_comment') != '' )? 'has-error' : ''; ?>
									<?php $disabled_attr 	= ( ( $user_session->user_type == 3 ) || ( $user_session->user_type == 4 ) || ( $result->is_accepted == 1 ) || ($result->user_id != $user_session->id) ) ? 'disabled="disabled"' : ''; ?>
									<?php $checked_attr 	= ( $result->is_accepted == 1 ) ? 'checked="checked"' : ''; ?>

									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<label class="mdl-textfield__label" for="text2">Manager Comment</label>
										<textarea class="mdl-textfield__input" disabled="disabled" id="manager_comment" name="manager_comment"><?php echo ( !empty( $result->manager_comment ) )  ? $result->manager_comment : ''; ?></textarea>
									</div>

									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<label class="mdl-textfield__label" for="text2">Employee Comment</label>
										<textarea class="mdl-textfield__input" <?php echo $disabled_attr; ?> id="employee_comment" name="employee_comment"><?php echo ( !empty( $result->employee_comment ) )  ? $result->employee_comment : ''; ?></textarea>
									</div>
									<?php echo form_error('employee_comment'); ?>

									<?php $error_class = ( form_error('is_accepted') != '' )? 'has-error' : '' ?>
									<div class="mdl-layout cca-width-100" style="min-height:100px;">
										<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect " for="is_accepted">
											
											<input type="checkbox" id="is_accepted" name="is_accepted" <?php echo $checked_attr; ?> <?php echo $disabled_attr; ?> class="mdl-checkbox__input" >
											<?php if($result->notification_type == 1) : ?>
												<p>
													I agree to follow the instructions above. By agreeing to this document I understand that I have received a warning and not following its instructions can lead to dismissal and an end to my employment contract.
												</p>
											<?php else: ?>

												<p>
												 	I agree that I have read this document and will do my best to follow all the instructions in it to become a better agent.
												</p>
											<?php endif; ?>								
											
										</label>
									</div>
									<?php echo form_error('is_accepted'); ?>

									<div class="mdl-cell mdl-cell--6-col">
										<div class="mdl-layout">
											<table>
												<tr>
													<?php if( ( $result->is_accepted != 1 ) && ( ( $user_session->user_type != 3) && ( $user_session->user_type != 4) ) && ($result->user_id == $user_session->id) ):?>
														<td>
														 	<button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect cca-background-color-dark-green submit_notification">Save</button>
														</td>
													<?php endif ?>

													<td>

														<?php if(  (( 1 == $user_session->user_type ) || ( 5 == $user_session->user_type ) || ( 6 == $user_session->user_type ) )  && ( $result->user_id == $user_session->id ) ): ?>
															<a  href="<?php echo site_url('home') ?>" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" >
																Back
															</a>
														<?php elseif( ( 3 == $user_session->user_type ) || ( 4 == $user_session->user_type ) ) : ?>
															<a  href="<?php echo site_url('global_notification/index') ?>" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" >
																Back
															</a>
														<?php else : ?>
															<a  href="<?php echo site_url('notification/index') ?>" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" >
																Back
															</a>
														<?php endif; ?>
													</td>
												</tr>
											</table>
										</div>
									</div>

									<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
								<!-- </div> -->
								<!-- <div class="mdl-layout-spacer"></div>	 -->
								<!-- </div> -->
							</form>
						</div>
					<?php else : ?>
						No record found!
					<?php endif; ?>	
				</div>
			</div>
		</div>
	</div>
</main>