<main class="mdl-layout__content mdl-color--grey-100" id="content">    
	<div class="mdl-grid demo-content">
		<div class="mdl-card mdl-shadow--2dp demo-todo">
			<div class="mdl-card__title">
				<h2 class="mdl-card__title-text">Add Performance</h2>
			</div>
			<div class="mdl-card__supporting-text">
				<div class="mdl-grid">
					<div class="mdl-layout-spacer"></div>
					<div class="mdl-cell mdl-cell--4-col">
						<form action="<?php echo site_url('performance/add_scores/'.$id ); ?>" method="post" id="form_score" enctype="multipart/form-data">
						    
						    <?php $error_class = ( form_error('quality') != '' )? 'has-error' : '' ?>
						    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label get-score">
						       <label class="mdl-textfield__label" for="quality">Quality</label>
						       <input class="mdl-textfield__input" type="text" id="quality" name="quality" value="<?php echo set_value('quality'); ?>">
						    </div>
					       	<?php echo form_error('quality'); ?>

						    <?php $error_class = ( form_error('adherence') != '' )? 'has-error' : '' ?>
						    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label get-score">
						       <label class="mdl-textfield__label" for="adherence">Adherence</label>
						       <input class="mdl-textfield__input" type="text" id="adherence" name="adherence" value="<?php echo set_value('adherence'); ?>">
						    </div>
					       	<?php echo form_error('adherence'); ?>

						    <?php $error_class = ( form_error('hold_time') != '' )? 'has-error' : '' ?>
						    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label get-score">
						       <label class="mdl-textfield__label" for="hold_time">Hold Time</label>
						       <input class="mdl-textfield__input" type="text" id="hold_time" name="hold_time" value="<?php echo set_value('hold_time'); ?>">
						    </div>
					       	<?php echo form_error('hold_time'); ?>

						    <?php $error_class = ( form_error('transfer_rate') != '' )? 'has-error' : '' ?>
						    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label get-score">
						       <label class="mdl-textfield__label" for="transfer_rate">Transfer Rate</label>
						       <input class="mdl-textfield__input" type="text" id="transfer_rate" name="transfer_rate" value="<?php echo set_value('transfer_rate'); ?>">
						    </div>
					       	<?php echo form_error('transfer_rate'); ?>

					       	<?php $error_class = ( form_error('add_score') != '' )? 'has-error' : '' ?>
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" id="set-focused">
									<label class="mdl-textfield__label" for="add_score">Total Score</label>
									<input type="text" class="mdl-textfield__input" id="add_score" name="add_score" value="<?php echo set_value('add_score'); ?>" readonly="readonly">
								</div>
								<?php echo form_error('add_score'); ?>

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