<?php
if ( ! isset( $item ) || ! is_array( $item ) ) {
	return;
}

$name = $item['quote_name'] ?? '';
$content = $item['quote_content'] ?? '';
?>
<div class="swiper-slide quote-card">
	<i class="fa-kit fa-quote"></i>
	<?php if ( $content ) : ?>
		<div class="card--content">
			<?php echo $content  ?>
		</div>
	<?php endif; ?>
	<?php if ( $name ) : ?>
		<div class="card--name"> <?php echo esc_html( $name ); ?> </div>
	<?php endif; ?>
</div>