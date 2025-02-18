<?php
$options = get_fields( 'option');
$fields = get_fields();
?>
<div class="justify-start items-start lg:items-center gap-4 lg:gap-12 flex mt-6 sm:mt-12 mb-9 flex-col lg:flex-row">
	<div class="w-full sm:w-[322px] px-[42px] py-[15px] bg-white border-2 border-[#d6bd7f] justify-center items-center gap-3.5 flex mb-2.5 order-2 sm:order-1">
		<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/logo-sigur.svg" alt="" class="object-cover ">
		<div>
			<div class="text-[14px] font-bold leading-[16px] mb-[4px]">Мы внесены в единый реестр туроператоров<br/></div>
			<div class="text-gray-900 text-[12px] font-normal leading-[22px]">№<?php echo $options['reestr']; ?> ИНН <?php echo $options['inn']; ?></div>
		</div>
	</div>
	<div class="grow shrink basis-0 justify-center items-center gap-2.5 flex order-1 sm:order-2">
		<?php echo $fields['about_desc'] ?>
	</div>
</div>

<div class="self-stretch h-0.5 bg-[#d6bd7f]"></div>

<h2 class="sm:mt-[48px]"><?php echo $fields['title_h2'] ?></h2>

<?php foreach ($fields['about_items'] as $key => $item): ?>
	<div class="flex-col justify-start items-start mb-12">
		<div class="flex-col justify-start items-start gap-3 flex">
			<div class="self-stretch flex-col justify-start items-start gap-6 flex">
				<div class="text-[20px] sm:text-[24px] font-semibold"><?php echo $item['title']; ?></div>
			</div>
			<div class="text-[16px] sm:text-[18px] font-medium leading-[1.3]"><?php echo $item['description']; ?></div>
		</div>
		<div class="self-stretch flex-col justify-start items-start gap-8 flex mt-12 mb-12">
			<?php if(count($item['gallery'])>4): ?>
				<div class="swiper swiper_five overflow-hidde">
					<div class="swiper-wrapper flex h-auto py-0">
						<?php foreach ($item['gallery'] as $img): ?>
								<img data-fancybox="gallery_<?php echo $key; ?>" class="swiper-slide rounded-[4px] shadows_custom overflow-hidden relative object-cover h-[180px] cursor-pointer" src="<?php echo $img; ?>" />
						<?php endforeach; ?>
					</div>
				</div>
			<?php else: ?>
				<div class="swiper swiper_four overflow-hidde">
					<div class="swiper-wrapper flex h-auto py-0">
						<?php foreach ($item['gallery'] as $img): ?>
							<img data-fancybox="gallery_<?php echo $key; ?>" class="swiper-slide rounded-[4px] shadows_custom overflow-hidden relative object-cover h-[180px] cursor-pointer" src="<?php echo $img; ?>" />
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
		<?php if(isset($item['dop_text']) && !empty($item['dop_text'])): ?>
		<div class="px-6 pt-6 pb-3 bg-[#f1efe9] rounded text-[16px] sm:text-[18px] mb-12">
			<?php echo $item['dop_text']; ?>
		</div>
		<?php endif; ?>
		<div class="self-stretch h-0.5 bg-[#d6bd7f]"></div>
	</div>

<?php endforeach; ?>
