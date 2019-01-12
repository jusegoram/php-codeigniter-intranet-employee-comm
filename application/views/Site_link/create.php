<main class="mdl-layout__content mdl-color--grey-100" id="content">    
	<div class="mdl-grid demo-content">
		<div class="mdl-card mdl-shadow--2dp demo-todo">
			<div class="mdl-card__title">
				<h2 class="mdl-card__title-text">Add Site Link</h2>
			</div>
			<div class="mdl-card__supporting-text">
				<div class="mdl-grid">
					<div class="mdl-layout-spacer"></div>
					<div class="mdl-cell mdl-cell--4-col">
						<form action="<?php echo site_url("site_link/create"); ?>" method="post" id="form_site_link" enctype="multipart/form-data">
						    
						    <?php $error_class = ( form_error('title') != '' )? 'has-error' : '' ?>
						    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						       <label class="mdl-textfield__label" for="title"> Title </label>
						       <input class="mdl-textfield__input" type="text" id="title" name="title" value="<?php echo set_value('title'); ?>">
						    </div>
					       	<?php echo form_error('title'); ?>
						    
						    <?php $error_class = ( form_error('url') != '' )? 'has-error' : '' ?>
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						       	<label class="mdl-textfield__label" for="url">Site Url</label>
								<textarea class="mdl-textfield__input" id="url" name="url"><?php echo set_value('url'); ?></textarea>
							</div>
			       			<?php echo form_error('url'); ?>

							<div class="clear"> </div>
							<div class="mdl-layout">
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