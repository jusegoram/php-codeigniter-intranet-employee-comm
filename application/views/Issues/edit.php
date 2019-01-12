<main class="mdl-layout__content mdl-color--grey-100" id="content">    
	<div class="mdl-grid demo-content">
		<div class="mdl-card mdl-shadow--2dp demo-todo">
			<div class="mdl-card__title">
				<h2 class="mdl-card__title-text">Issue</h2>
			</div>
			<div class="mdl-card__supporting-text">
				<div class="mdl-grid">
					<?php if(!empty($result)) : ?>	
						<div class="mdl-layout-spacer"></div>
						<div class="mdl-cell mdl-cell--4-col">
							
							<form action="<?php echo site_url('issues/edit/'.$result->id); ?>" method="post" id="form_issue" name="form_issue">
							   	<?php $error_class = ( form_error('issue_name') != '' )? 'has-error' : '' ?>
							    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							       <label class="mdl-textfield__label" for="issue_name">Issue Name</label>
							       <input class="mdl-textfield__input" type="text" id="issue_name" name="issue_name" value="<?php echo set_value('issue_name', $result->issue_name); ?>">
							    </div>
						       	<?php echo form_error('issue_name'); ?>

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