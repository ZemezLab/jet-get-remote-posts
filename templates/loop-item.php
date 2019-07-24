<?php
/**
 * Posts loop start template
 */

$date          = $item['date'];
$formated_date = date( 'F d, Y', strtotime( $date ) );
$permalink     = $item['link'];
$title         = $item['title']['rendered'];

if ( ! empty( $trim_title ) ) {
	$title = wp_trim_words( $title, $trim_title, '...' );
}

?>
<div class="jet-posts__item col-desk-1">
	<div class="jet-posts__inner-box">
		<div class="jet-posts__inner-content">
			<h4 class="entry-title">
				<a href="<?php echo $permalink; ?>"><?php
					echo $title;
				?></a>
			</h4>
			<div class="post-meta">
				<span class="post__date post-meta__item">
					<a href="<?php echo $permalink; ?>" class="post__date-link">
						<time datetime="<?php echo $date; ?>" title="<?php echo $date; ?>">
							<?php echo $formated_date; ?>
						</time>
					</a>
				</span>
			</div>
		</div>
	</div>
</div>