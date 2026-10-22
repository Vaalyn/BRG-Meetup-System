<div class="col s12 gallery white-text">
	<?php foreach ($gallery->listContents($year) as $image) : ?>
		<?php if ($image->isFile() && in_array($gallery->mimeType($image->path()), ['image/jpeg', 'image/png'])) : ?>
			<figure>
				<img src="img/meetup/<?php echo $image->path(); ?>" alt="<?php echo basename($image->path()); ?>" class="materialboxed" />
			</figure>
		<?php endif; ?>
	<?php endforeach; ?>
</div>
