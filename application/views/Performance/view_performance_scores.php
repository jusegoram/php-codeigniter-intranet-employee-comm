<main class="mdl-layout__content mdl-color--grey-100" id="content">    
	<meta name="csrf_rcc" content="<?php echo $csrf['hash']; ?>" />
	<div class="mdl-grid demo-content">
		<div class="mdl-card mdl-shadow--2dp demo-todo" style="min-height:15px !important;">
			<div class="mdl-card__title">
				<div class="mdl-grid" style="margin:0 !important; width:100% !important;">
					<div class="mdl-cell mdl-cell--3-col">
						<h2 class="mdl-card__title-text">View Scores</h2>
					</div>
				</div>
			</div>
				

			<div class="mdl-layout__content">

				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--2-col">
						<button style="width:100%;" href="javascript:void(0);" data-score-type="1" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored add_users_table" onclick="document.getElementById('name_score').innerHTML='List for External Quality Scores';">External Quality</button>
					</div>
					<div class="mdl-cell mdl-cell--2-col">
						<button style="width:100%;" href="javascript:void(0);" data-score-type="2" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored add_users_table" onclick="document.getElementById('name_score').innerHTML='List for Internal Quality Scores';">Internal Quality</button>
					</div>
					<div class="mdl-cell mdl-cell--2-col">
						<button style="width:100%;" href="javascript:void(0);" data-score-type="3" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored add_users_table" onclick="document.getElementById('name_score').innerHTML='List for Adherence Scores';">Adherence</button>
					</div>

					<div class="mdl-cell mdl-cell--2-col">
						<button style="width:100%;" href="javascript:void(0);" data-score-type="4" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored add_users_table" onclick="document.getElementById('name_score').innerHTML='List for Transfer Rate Scores';">Transfer Rate</button>
					</div>

					<div class="mdl-cell mdl-cell--2-col">
						<button style="width:100%;" href="javascript:void(0);" data-score-type="5" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored add_users_table" onclick="document.getElementById('name_score').innerHTML='List for Lateness Scores';">Lateness</button>
					</div>

					<div class="mdl-cell mdl-cell--2-col">
						<button style="width:100%;" href="javascript:void(0);" data-score-type="6" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored add_users_table" onclick="document.getElementById('name_score').innerHTML='List for Conversion Rate Scores';">Conversion Rate</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="mdl-grid demo-content">		
		<div class="mdl-card mdl-shadow--2dp demo-todo">
			<div class="mdl-card__title">
				<h2 class="mdl-card__title-text" id="name_score">List for External Quality Scores</h2>
			</div>

			<div class="mdl-layout--middle">
				<table id="performance_users_table" class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
					<thead>
						<tr>
							<th class="mdl-data-table__cell--non-numeric" >S.N</th>
							<th class="mdl-data-table__cell--non-numeric" >Name</th>
							<th class="mdl-data-table__cell--non-numeric" >Employee Id</th>
							<th class="mdl-data-table__cell--non-numeric" >Score</th>
							<th class="mdl-data-table__cell--non-numeric" >Avaya Number</th>
							<th class="mdl-data-table__cell--non-numeric" >Date</th>
							<th class="mdl-data-table__cell--non-numeric" >Action</th>
						</tr>
					</thead>
				</table>
			</div>

		</div>
	</div>
</main>