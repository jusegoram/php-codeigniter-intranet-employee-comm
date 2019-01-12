
<main class="mdl-layout__content mdl-color--grey-100" id="content">    
	<div class="mdl-grid demo-content">
		<div class="mdl-card mdl-shadow--2dp demo-todo">
			<div class="mdl-card__title">
				<h2 class="mdl-card__title-text">Logs Details</h2>
			</div>

			<div class="mdl-layout__content layout-padding">
				<div class="mdl-grid">
					<?php if(!empty($field_results)) : ?>
						<?php foreach ($field_results as $field_result_obj) { ?>
						<?php if(isset($logs_arr[$field_result_obj->field_title]) && !empty($logs_arr[$field_result_obj->field_title])) { ?>
							<div class="mdl-cell mdl-cell--2-col cell-logs"><?php echo $field_result_obj->field_value; ?></div>
					    	<div class="mdl-cell mdl-cell--10-col cell-logs"><?php echo $logs_arr[$field_result_obj->field_title]; ?></div>

						<?php }

						}?>
						<div class="mdl-cell mdl-cell--1-col">
							<a href="<?php echo site_url('logs/index') ?>" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">
								Back
							</a>
						</div>
					<?php else : ?>
						No record found!
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</main>