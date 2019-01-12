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

										<tr><th> Hire Date </th><td><?php echo date('Y-m-d', $user_session->hire_date); ?></td></tr>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php if(!empty($agreement_notifiation_results)) : ?>
			<div class="mdl-card__supporting-text">	
				<div class="mdl-grid">
					<div class="mdl-card mdl-shadow--2dp demo-todo">
						<div class="mdl-card__title cca-background-color cca-text-color-white">
							<i class="material-icons custom">library_books</i>  <h2 class="mdl-card__title-text"> Agreement Notifications</h2>
						</div>

						<div class="mdl-layout--middle">

							<?php foreach( $agreement_notifiation_results as $agreement_notifiation_result) : ?>

								<div class="square-card mdl-card mdl-shadow--2dp">
									<div class="mdl-card__supporting-text">
										<p>								
											<?php echo 'Document Name: ' . $agreement_notifiation_result->document_name; ?>
										</p>

										<p>
											<?php echo 'Submited By: '. $agreement_notifiation_result->submit_first_name .' '.  $agreement_notifiation_result->submit_last_name; ?>
										</p>
										
										<?php if( 2 == $agreement_notifiation_result->is_global ) { ?>

											<div class="mdl-card--border">
												<a href="<?php echo site_url('global_notification/details/' . $agreement_notifiation_result->id ) ?>" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">More...</a>	
											</div>
											
											<?php } else { ?>
												<div class="mdl-card--border">
												<a href="<?php echo site_url('notification/details/' . $agreement_notifiation_result->id ) ?>" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">More...</a>	
											</div>	
										<?php } ?>

									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php if(!empty($traning_notifiation_results)) : ?>
			<div class="mdl-card__supporting-text">	
				<div class="mdl-grid">
					<div class="mdl-card mdl-shadow--2dp demo-todo">
						<div class="mdl-card__title cca-background-color cca-text-color-white">
							<i class="material-icons custom">add_alert</i> <h2 class="mdl-card__title-text"> Training Notifications</h2>
						</div>

						<div class="mdl-layout--middle">
							
							<?php foreach( $traning_notifiation_results as $traning_notifiation_result) : ?>

								<div class="square-card mdl-card mdl-shadow--2dp">
									<div class="mdl-card__supporting-text">
										<p>
											<?php echo 'Document Name: ' . $traning_notifiation_result->document_name; ?>
										</p>

										<p>
											<?php echo 'Submited By: '. $traning_notifiation_result->submit_first_name .' '.  $traning_notifiation_result->submit_last_name; ?>
										</p>
										<div class="mdl-card--border">
											<a href="<?php echo site_url('notification/details/' . $traning_notifiation_result->id ) ?>" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">More...</a>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php if(!empty($warning_notifiation_results)) : ?>
			<div class="mdl-card__supporting-text">
				<div class="mdl-grid">
					<div class="mdl-card mdl-shadow--2dp demo-todo">
					
						<div class="mdl-card__title cca-background-color-warning cca-text-color-white">
							<i class="material-icons custom">warning</i> <h2 class="mdl-card__title-text"> Warning Notifications</h2>
						</div>

						<div class="mdl-layout--middle">
							
							<?php foreach( $warning_notifiation_results as $warning_notifiation_result) : ?>
								<div class="square-card mdl-card mdl-shadow--2dp">
									<div class="mdl-card__supporting-text">
										<p>
											<?php echo 'Document Name: ' . $warning_notifiation_result->document_name; ?>
										</p>

										<p>
											<?php echo 'Submited By: '. $warning_notifiation_result->submit_first_name .' '.  $warning_notifiation_result->submit_last_name; ?>
										</p>
										
										<?php if( 2 == $warning_notifiation_result->is_global ) { ?>

											<div class="mdl-card--border">
												<a href="<?php echo site_url('global_notification/details/' . $warning_notifiation_result->id ) ?>" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">More...</a>
											</div>

											<?php } else { ?>
												<div class="mdl-card--border">
												<a href="<?php echo site_url('notification/details/' . $warning_notifiation_result->id ) ?>" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">More...</a>
											</div>	
										<?php } ?>
									</div>
								</div>
							<?php endforeach; ?>
							
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</main>