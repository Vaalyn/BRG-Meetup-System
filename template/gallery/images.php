<div class="col s12 gallery white-text">
	<?php foreach ($gallery->listContents($year) as $image) : ?>
		<?php if (in_array($gallery->getMimetype($image['path']), ['image/jpeg', 'image/png'])) : ?>
			<figure>
				<img src="img/meetup/<?php echo $image['path']; ?>" alt="<?php echo $image['basename']; ?>" class="materialboxed" />
			</figure>
		<?php endif; ?>
	<?php endforeach; ?>
</div>
