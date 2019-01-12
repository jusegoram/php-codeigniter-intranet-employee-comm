<main class="mdl-layout__content mdl-color--grey-100" id="content">    
	<meta name="csrf_rcc" content="<?php echo $csrf['hash']; ?>" />
	<div class="mdl-grid demo-content">
		<div class="mdl-card mdl-shadow--2dp demo-todo" style="min-height:15px !important;">
			<div class="mdl-card__title">
				<h2 class="mdl-card__title-text">Add Performance</h2> <span style="margin-left:5%;" id='preview'></span>
			</div>
				
			<div class="mdl-card__supporting-text">	
				<table border="0" align="center">
					<tbody>
						<tr>
							<td style="padding:4px;">
							<form action="<?php echo site_url("performance_score"); ?>" id="submit_form1" method="post" enctype="multipart/form-data">
								<input name="score_type" value="1" type="hidden" />
								<label class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored" >External Quality<input name="file_name" class="select_file" type="file" /></label>
							</form></td>
							
							<td style="padding:4px;">
							<form action="<?php echo site_url("performance_score"); ?>" id="submit_form2" class="submit_form" method="post" enctype="multipart/form-data">
								<input name="score_type" value="2" type="hidden" />
								<label class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored" >Internal Quality<input name="file_name" class="select_file" type="file" /></label>
							</form></td>
							
							<td style="padding:4px;">
							<form action="<?php echo site_url("performance_score"); ?>" id="submit_form3" method="post" enctype="multipart/form-data">
								<input name="score_type" value="3" type="hidden" />
								<label class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored" >Adherence<input name="file_name" class="select_file" type="file" /></label>
							</form></td>
							
							<td style="padding:4px;">
							<form action="<?php echo site_url("performance_score"); ?>" id="submit_form4" method="post" enctype="multipart/form-data">
								<input name="score_type" value="4" type="hidden" />
								<label class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored" >Transfer Rate<input name="file_name" class="select_file" type="file" /></label>
							</form></td>
							
							<td style="padding:4px;">
							<form action="<?php echo site_url("performance_score"); ?>" id="submit_form5" method="post" enctype="multipart/form-data">
								<input name="score_type" value="5" type="hidden" />
								<label data-score-type="5" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored" >Lateness<input name="file_name" class="select_file" type="file" /></label>
							</form></td>
							
							<td style="padding:4px;">
							<form action="<?php echo site_url("performance_score"); ?>" id="submit_form6" method="post" enctype="multipart/form-data">
								<input name="score_type" value="6" type="hidden" />
								<label data-score-type="6" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored" >Conversion Rate<input name="file_name" class="select_file" type="file" /></label>
							</form></td> 
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	<div class="mdl-grid demo-content show-second-times">		
		<div class="mdl-card mdl-shadow--2dp demo-todo">
			<div class="mdl-card__title">
				<h2 class="mdl-card__title-text" id="name_score_added"></h2>
			</div>

			<div class="mdl-layout--middle">
				<table id="added_score_table" class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
					<thead>
						<tr>
							<th class="mdl-data-table__cell--non-numeric" >Employee Id</th>
							<th class="mdl-data-table__cell--non-numeric" >Name</th>
							<th class="mdl-data-table__cell--non-numeric" >Avaya Number</th>
							<th class="mdl-data-table__cell--non-numeric" >Date</th>
							<th class="mdl-data-table__cell--non-numeric" >Score</th>

						</tr>
					</thead>
				</table>
			</div>

		</div>
	</div>
</main>