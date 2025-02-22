<?php
/**
 * Template part for displaying single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package _tw
 */

$fields = get_fields($post['id']);
$date = ($fields['date']) ?? get_the_date('j F Y');

$sub = array(".01." => " января ", ".02." => " февраля ",
		".03." => " марта ", ".04." => " апреля ", ".05." => " мая ", ".06." => " июня ",
		".07." => " июля ", ".08." => " августа ", ".09." => " сентября ",
		".10." => " октября ", ".11." => " ноября ", ".12." => " декабря ", "2022" => '2022', '2023' => '2023', '2024'=>'2024', '2025'=>'2025','2026'=>'2026','00:00'=>'');



?>
<div class="shadows_custom p-6 bg-[#FAFAFA]">
	<div class="text-[16px] mb-1"><?php echo get_the_title($post['id']) ?></div>
	<div class="text-[16px] text-[#6B7280] mb-3">
		<?php
			if (isset($fields['date']) && !empty($fields['date'])) {
				echo trim(strtr($fields['date'], $sub));
			} else {
				echo trim(strtr(get_the_date(), $sub));
			}
		?>
	</div>
	<div class="text_toggle">
		<div class="mb-3 text-[#111827]  rev-text short-rev recepient"><?php echo  get_the_content($post['id']); ?></div>
		<?php
			$content = get_the_content();
			$content = apply_filters('the_content', $content);
			$content = strip_tags($content);
			$content_length = mb_strlen($content, 'UTF-8');
		?>
		<?php if ($content_length > 453): ?>
		<div class="text-[#52A6B2] cursor-pointer togler hidden sm:block">Читать весь отзыв</div>
		<?php endif; ?>
	</div>

	<?php if(isset($fields['gallery']) && !empty($fields['gallery'])): ?>
		<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 mt-4">
			<?php foreach($fields['gallery'] as $item) : ?>
				<img data-fancybox="gallery" src="<?php echo $item ?>" class="h-[75px] rounded-0.5 cursor-pointer object-cover w-full">
			<?php endforeach; ?>
		</div>
	<?php endif; ?>


	<?php if(isset($fields['excursion']) && !empty($fields['excursion']) || (isset($fields['excursion_obj']) && !empty($fields['excursion_obj']))) : ?>
	<div class="mt-4 font-bold text-[#52A6B2] lines three-lines">


		<?php if(isset($fields['excursion_obj']) && $fields['excursion_obj']):  ?>
			<?php if(get_post_status($fields['excursion_obj']) === 'publish') :?>
				<a href="<?php echo esc_url(get_permalink($fields['excursion_obj'])); ?>">
					<?php  echo get_the_title($fields['excursion_obj']);  ?>
				</a>
			<?php else: ?>
				<span>
				<?php  echo get_the_title($fields['excursion_obj']);  ?></span>
			<?php endif; ?>

		<?php elseif(isset($fields['excursion']) && $fields['excursion']) : ?>
			Экскурсия: <?php echo $fields['excursion']; ?>
		<?php endif; ?>



	</div>
	<?php endif; ?>
	<?php if(isset($fields['gid']) && !empty($fields['gid'])): ?>
	<div class="text-[#6B7280] sm:pb-4 mt-3">Гид: <?php echo $fields['gid']; ?></div>
	<?php endif; ?>

	<?php if(isset($fields['review_answer']) && !empty($fields['review_answer'])): ?>
	<div class="px-4 pt-3 flex flex-col gap-3 bg-[#EFEDE7] rounded-[14px]">
		<div class="text-[14px]">Ответ ГРУПСПБ <span class="text-[#6B7280]">
		<?php
			if (isset($fields['date']) && !empty($fields['date'])) {
				echo trim(strtr($fields['date'], $sub));
			} else {
				echo trim(strtr(get_the_date(), $sub));
			}
		?>
		</span></div>
		<div class=""><?php echo $fields['review_answer']; ?></div>
	</div>
	<?php endif; ?>

</div>
