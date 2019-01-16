<main class="mdl-layout__content mdl-color--grey-100" id="content">
	<meta name="csrf_rcc" content="<?php echo $csrf['hash']; ?>" />
	<div class="mdl-grid demo-content">
		<div class="mdl-card mdl-shadow--2dp demo-todo" style="min-height:15px !important;">
			<div class="mdl-card__title">
				<h2 class="mdl-card__title-text">View Performance Score</h2>
			</div>


			<div class="mdl-layout__content">

				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--2-col">
						<button style="width:100%;" href="javascript:void(0);" data-score-type="1" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored add_users_table" onclick="document.getElementById('name_score').innerHTML='Quality score list';">Quality</button>
					</div>
					<div class="mdl-cell mdl-cell--2-col">
						<button style="width:100%;" href="javascript:void(0);" data-score-type="2" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored add_users_table" onclick="document.getElementById('name_score').innerHTML='Productivity score list';">Productivity</button>
					</div>
					<div class="mdl-cell mdl-cell--2-col">
						<button style="width:100%;" href="javascript:void(0);" data-score-type="3" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored add_users_table" onclick="document.getElementById('name_score').innerHTML='Hours score list';">Hours</button>
					</div>

					<div class="mdl-cell mdl-cell--2-col">
						<button style="width:100%;" href="javascript:void(0);" data-score-type="4" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored add_users_table" onclick="document.getElementById('name_score').innerHTML='Other scores list';">Other</button>
					</div>

					<div class="mdl-cell mdl-cell--2-col">
						<button style="width:100%;" href="javascript:void(0);" data-score-type="5" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored add_users_table" onclick="document.getElementById('name_score').innerHTML='Lateness score list';">Lateness</button>
					</div>

					<div class="mdl-cell mdl-cell--2-col">
						<button style="width:100%;" href="javascript:void(0);" data-score-type="6" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored add_users_table" onclick="document.getElementById('name_score').innerHTML='Break time score list';">Break Time</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- <div class="mdl-grid demo-content">
		<div class="mdl-card mdl-shadow--2dp demo-todo">
			<div class="mdl-card__title">
				<h2 class="mdl-card__title-text" id="name_score">Score list</h2>
			</div>

			<div class="mdl-layout--middle">
				<table id="performance_users_table" class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
					<thead>
						<tr>
							 <th class="mdl-data-table__cell--non-numeric" data-field="id">S.No</th>
							<th class="mdl-data-table__cell--non-numeric" data-field="performance_for">Name</th>
							<th class="mdl-data-table__cell--non-numeric" data-field="performance_date">Employee ID</th>
							<th class="mdl-data-table__cell--non-numeric" data-field="quality">test</th>
							<th class="mdl-data-table__cell--non-numeric" >S.N</th>
							<th class="mdl-data-table__cell--non-numeric" >Name</th>
							<th class="mdl-data-table__cell--non-numeric" >Employee Id</th>
							<th class="mdl-data-table__cell--non-numeric" >Score</th>
							<th class="mdl-data-table__cell--non-numeric" >Client</th>
							<th class="mdl-data-table__cell--non-numeric" >Date</th>
							<th class="mdl-data-table__cell--non-numeric" >Action</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div> -->
	<div class="mdl-grid demo-content">
		<div class="mdl-card mdl-shadow--2dp demo-todo">
			<div class="mdl-card__title">
				<h2 class="mdl-card__title-text" id="name_score">List for Quality Scores</h2>
			</div>

			<div class="mdl-layout--middle">
				<table id="performance_users_table" class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
					<thead>
						<tr>
							<th class="mdl-data-table__cell--non-numeric" >S.N</th>
							<th class="mdl-data-table__cell--non-numeric" >Name</th>
							<th class="mdl-data-table__cell--non-numeric" >Employee Id</th>
							<th class="mdl-data-table__cell--non-numeric" >Score</th>
							<th class="mdl-data-table__cell--non-numeric" >Client</th>
							<th class="mdl-data-table__cell--non-numeric" >Date</th>
							<th class="mdl-data-table__cell--non-numeric" >Action</th>
						</tr>
					</thead>
				</table>
			</div>

		</div>
	</div>
</main>

<div id="main_push" style="display:none;">
	<section class="mdl-layout__content mdl-color--grey-100 dialog-section dialog_class_div">
		<div class="mdl-grid demo-content">
			<div class="mdl-card mdl-shadow--2dp demo-todo">
				<div class="mdl-card__title">
				</div>

				<div class="mdl-layout--middle">
					<table id="performance_score_popup" class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
						<thead>
							<tr>
							<th class="mdl-data-table__cell--non-numeric" >Employee Id</th>
							<th class="mdl-data-table__cell--non-numeric" >Name</th>
							<th class="mdl-data-table__cell--non-numeric" >Client</th>
							<th class="mdl-data-table__cell--non-numeric" >Date</th>
							<th class="mdl-data-table__cell--non-numeric" >Score</th>
							</tr>
						</thead>
					</table>
				</div>

			</div>
		</div>
	</section>
</div>