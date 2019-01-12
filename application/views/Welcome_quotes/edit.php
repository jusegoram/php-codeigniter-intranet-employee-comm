<main class="mdl-layout__content mdl-color--grey-100" id="content">    
	<div class="mdl-grid demo-content">
		<div class="mdl-card mdl-shadow--2dp demo-todo">
			<div class="mdl-card__title">
				<h2 class="mdl-card__title-text">Edit</h2>
			</div>

			<div class="mdl-card__supporting-text">
				<div class="mdl-grid">
					<?php if(!empty($result)) : ?>	
						<div class="mdl-layout-spacer"></div>
						<div class="mdl-cell mdl-cell--4-col">
							<form action="<?php echo site_url('welcome_quotes/edit/' . $result->id ); ?>" method="post" id="form_welcome_quotes">
							    
								<?php $error_class = ( form_error('welcome_quote') != '' )? 'has-error' : '' ?>
							    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							       <label class="mdl-textfield__label" for="welcome_quote">Welcome Quote</label>
							       <textarea class="mdl-textfield__input" type="text" id="welcome_quote" name="welcome_quote" ><?php echo set_value('welcome_quote', $result->welcome_quote); ?></textarea>
							    </div>
						       	<?php echo form_error('welcome_quote'); ?>

							    <?php $error_class = ( form_error('welcome_quote_date') != '' )? 'has-error' : '' ?>
							    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" >
							       <label class="mdl-textfield__label" for="welcome_quote_date">Quotes Date</label>
							       <input id="welcome_quote_date" type="text" class="mdl-textfield__input common-date-class" name="welcome_quote_date" value="<?php echo set_value('welcome_quote_date', date('Y-m-d', $result->welcome_quote_date)); ?>" readonly="readonly">
							    </div>
						       	<?php echo form_error('welcome_quote_date'); ?>
							    
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