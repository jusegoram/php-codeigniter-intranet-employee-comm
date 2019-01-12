<main class="mdl-layout__content mdl-color--grey-100" id="content">
	<div class="mdl-card mdl-shadow--2dp demo-todo">
		<div class="mdl-card__supporting-text">
			<div class="mdl-grid" style="width:100%;">
				<div class="mdl-cell mdl-cell--6-col">
					<div class="mdl-card mdl-shadow--2dp">
						<div class="mdl-card__title cca-background-color cca-text-color-white">
							<i class="material-icons custom">mic</i> <h2 class="mdl-card__title-text"> Welcome
							<?php echo $user_session->first_name .' '. $user_session->last_name; ?>
							(<?php echo date('Y-m-d', $user_session->hire_date); ?>)
							</h2>
						</div>

						<div class="mdl-layout--middle">
						
							<?php if(!empty($welcome_quotes_results)) : ?>
								<div class="square-card mdl-card mdl-shadow--2dp">
									<div class="mdl-card__supporting-text">
										<?php echo $welcome_quotes_results->welcome_quote; ?>
									</div>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>

				<div class="mdl-cell mdl-cell--6-col">
					<div class="mdl-card mdl-shadow--2dp ">
						<div class="mdl-card__title cca-background-color cca-text-color-white">
							<i class="material-icons custom">contacts</i> <h2 class="mdl-card__title-text"> Personal Information </h2>
						</div>

						<div class="mdl-layout--middle" >
							<div class="square-card mdl-card mdl-shadow--2dp">
								<div class="mdl-card__supporting-text" >
									<table style="text-align:left; width:100%; ">
										<tr><th> Name </th><td><?php echo $user_session->first_name .' '. $user_session->last_name; ?></td></tr>

										<tr><th> Employee ID </th><td><?php echo $user_session->employee_id; ?></td></tr>

										<tr><th> Avaya Number </th><td><?php echo $user_session->avaya_number; ?></td></tr>

										<tr><th>Hire Date </th><td><?php echo date('Y-m-d', $user_session->hire_date); ?></td></tr>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>