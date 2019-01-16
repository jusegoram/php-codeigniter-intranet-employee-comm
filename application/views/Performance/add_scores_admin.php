<main class="mdl-layout__content mdl-color--grey-100" id="content">
	<meta name="csrf_rcc" content="<?php echo $csrf['hash']; ?>" />
	<div class="mdl-grid demo-content">
		<div class="mdl-card mdl-shadow--2dp demo-todo" style="min-height:15px !important;">
			<div class="mdl-card__title">
				<div class="mdl-grid" style="margin:0 !important; width:100% !important;">
					<div class="mdl-cell mdl-cell--3-col">
						<h2 class="mdl-card__title-text">Add Performance</h2>
					</div>
					<div class="mdl-cell mdl-cell--2-col">
						<a href="<?php echo site_url('performance_score/view_performance_score'); ?>" id="view_score"><label for="view_score" class="mdl-button mdl-js-button mdl-button--icon"><i class="material-icons" title="View all scores">visibility</i></label></a>
						<a href="<?php echo site_url('performance_score/export_sample_score'); ?>" id="download_sample"><label for="download_sample" class="mdl-button mdl-js-button mdl-button--icon"><i class="material-icons" title="Download sample file to upload performance scores">file_download</i></label></a>
						<!-- <span style="margin-left:5%;" id='preview'></span> -->
					</div>
					<div id="show-progress-bar" class="mdl-cell mdl-cell--7-col" style="margin-top:10px; display:none" >

						<div id="progress-div"><div id="progress-bar"></div></div>
						<div id="targetLayer"></div>

					</div>
				</div>
			</div>


			<div class="mdl-layout__content">

				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--2-col">
						<form action="<?php echo site_url("performance_score"); ?>" id="submit_form1" method="post" enctype="multipart/form-data" name="Quality"><input name="score_type" value="1" type="hidden" /><label style="width:80%;" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored" >Quality<input name="file_name" class="select_file" type="file" /></label></form>
					</div>

					<div class="mdl-cell mdl-cell--2-col">
						<form action="<?php echo site_url("performance_score"); ?>" id="submit_form2" method="post" enctype="multipart/form-data" name="Productivity"><input name="score_type" value="2" type="hidden" /><label style="width:80%;" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored" >Productivity<input name="file_name" class="select_file" type="file" /></label></form>
					</div>

					<div class="mdl-cell mdl-cell--2-col">
						<form action="<?php echo site_url("performance_score"); ?>" id="submit_form3" method="post" enctype="multipart/form-data" name="Hours"><input name="score_type" value="3" type="hidden" /><label style="width:80%;" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored" >Hours<input name="file_name" class="select_file" type="file" /></label></form>
					</div>

					<div class="mdl-cell mdl-cell--2-col">
						<form action="<?php echo site_url("performance_score"); ?>" id="submit_form4" method="post" enctype="multipart/form-data" name="Other"><input name="score_type" value="4" type="hidden" /><label style="width:80%;" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored" >Other<input name="file_name" class="select_file" type="file" /></label></form>
					</div>

					<div class="mdl-cell mdl-cell--2-col">
						<form action="<?php echo site_url("performance_score"); ?>" id="submit_form5" method="post" enctype="multipart/form-data" name="Lateness">
							<input name="score_type" value="5" type="hidden" />
							<label style="width:80%;" data-score-type="5" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored" >Lateness<input name="file_name" class="select_file" type="file" /></label></form>
					</div>

					<div class="mdl-cell mdl-cell--2-col">
						<form action="<?php echo site_url("performance_score"); ?>" id="submit_form6" method="post" enctype="multipart/form-data" name="Break Time">
							<input name="score_type" value="6" type="hidden" />
							<label style="width:80%;" data-score-type="6" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored" >Break Time<input name="file_name" class="select_file" type="file" /></label></form>
					</div>
				</div>
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
							<th class="mdl-data-table__cell--non-numeric" >Client</th>
							<th class="mdl-data-table__cell--non-numeric" >Date</th>
							<th class="mdl-data-table__cell--non-numeric" >Score</th>
							<th class="mdl-data-table__cell--non-numeric" >Status</th>
						</tr>
					</thead>
				</table>
			</div>

		</div>
	</div>
</main>