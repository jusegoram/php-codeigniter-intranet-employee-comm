<main class="mdl-layout__content">
	<div class="mdl-grid">
	<?php if( !empty($results) ) : ?>
	 		<?php $i = 0; ?>
			<?php foreach( $results as $result) : ?>
				<?php if( $i < 4 ) : ?>
			    	<div class="mdl-cell mdl-cell--4-col graybox" style="border:1px solid #666666; padding:1px; margin:1px;">
			    		<a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" target="_blank" href="<?php echo $result->url; ?>" style="width:88%;">
							<?php echo  $result->title; ?>
						</a>
					</div>
				<?php endif; ?>
			    <?php $i++ ?>
			    <?php if( $i == 4 ) : $i = 0;?>
			   <?php endif; ?>    
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</main>