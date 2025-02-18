<?php

$get_params = custom_get_params();

$sidebar_term = get_query_var('sidebar_term');
$options = get_fields( 'option');

if ($sidebar_term) {
	$current_category = $sidebar_term;
} else {
	$current_category = get_queried_object(); // Текущая категория
}
$queryParams = $_SERVER['QUERY_STRING'] ? '?' .$_SERVER['QUERY_STRING'] : '';


?>
<aside id="sidebar-menu" class="no-scrollbar transition-all duration-300 ease-in-out z-[9999999] lg:z-10 top-0 fixed lg:sticky top-3 lg:top-[-400px] w-full max-w-[96vw] h-full transform lg:relative filter lg:w-[322px] min-w-[322px] overflow-auto bg-white left-[2vw]  -translate-x-[1700px] lg:translate-x-0">
	<div class="p-5 rounded-lg lg:h-full border border-1 border-[#E5E7EB] shadows_custom rounded-[6px]">
		<div class="flex lg:hidden justify-end relative -top-[10px] -right-1 bg-white relative">
			<button class="close-filter-btn">
				<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
					<path d="M12 20L16 16M16 16L19.6667 12.3333M16 16L12 12M16 16L20 20M29 16C29 23.1797 23.1797 29 16 29C8.8203 29 3 23.1797 3 16C3 8.8203 8.8203 3 16 3C23.1797 3 29 8.8203 29 16Z" stroke="#9CA3AF" stroke-width="2.67" stroke-linecap="round" stroke-linejoin="round"></path>
				</svg>
			</button>
		</div>
		<form class="search-form flex px-5 h-10 bg-white items-center rounded-[6px] border border-[#000000] w-full  flex items-center mb-0 text-[16px] mb-[24px] relative">
			<button type="submit" class="me-3" aria-label="Поиск">
				<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
					<path d="M18.0126 16.9873L17.9419 17.058L18.0126 16.9873L14.165 13.1405C15.2765 11.77 15.8287 10.0285 15.7084 8.26582C15.586 6.47275 14.777 4.79591 13.4497 3.58412C12.1225 2.37233 10.3791 1.71888 8.58234 1.75971C6.78557 1.80055 5.07371 2.53252 3.80287 3.80336C2.53203 5.0742 1.80006 6.78606 1.75923 8.58283C1.71839 10.3796 2.37184 12.123 3.58363 13.4502C4.79542 14.7775 6.47226 15.5865 8.26533 15.7089C10.028 15.8292 11.7695 15.277 13.14 14.1655L16.9868 18.0131L17.0575 17.9424L16.9868 18.0131C17.0541 18.0804 17.1341 18.1339 17.2221 18.1703C17.3101 18.2068 17.4044 18.2255 17.4997 18.2255C17.5949 18.2255 17.6893 18.2068 17.7773 18.1703C17.8653 18.1339 17.9452 18.0804 18.0126 18.0131C18.0799 17.9457 18.1334 17.8658 18.1698 17.7778C18.2063 17.6898 18.225 17.5954 18.225 17.5002C18.225 17.4049 18.2063 17.3106 18.1698 17.2226C18.1334 17.1346 18.0799 17.0546 18.0126 16.9873ZM3.22469 8.75018C3.22469 7.65744 3.54873 6.58923 4.15582 5.68065C4.76292 4.77207 5.6258 4.06392 6.63536 3.64574C7.64493 3.22757 8.75582 3.11816 9.82756 3.33134C10.8993 3.54452 11.8838 4.07073 12.6565 4.84341C13.4291 5.6161 13.9553 6.60056 14.1685 7.6723C14.3817 8.74405 14.2723 9.85494 13.8541 10.8645C13.436 11.8741 12.7278 12.737 11.8192 13.344C10.9107 13.9511 9.8425 14.2752 8.7498 14.2752C7.28495 14.2736 5.88056 13.6909 4.84475 12.6551C3.80897 11.6193 3.22634 10.215 3.22469 8.75018Z" fill="#373F41" stroke="#373F41" stroke-width="0.2"></path>
				</svg>
			</button>
			<input type="text" placeholder="Что вы ищете?" class="md:max-w-[113px]">
		</form>
		<!--catName-->
		<?php $cats = get_nested_categories_by_main_parent($current_category->term_id); ?>
		<div class="flex gap-1 flex-col w-full pb-[20px] mb-[24px] border-b-2 border-[#E5E7EB]">
			<div class="flex gap-2 flex-wrap radio-group" id="cat_sidebar">
				<?php foreach($cats as $cat): ?>
					<?php
						$current_term = get_queried_object();
						$fieldsCat = get_fields("term_".$cat['id']);
					?>
					<?php if( !isset($fieldsCat['exclude']) || empty($fieldsCat['exclude'] || !$fieldsCat['exclude'])): ?>
						<div class="flex items-center">
							<?php if($cat['current']): ?>
								<span  class="rounded-[6px] bg-[#52a6b2] text-white transition px-[13px] h-8 flex items-center">
									<?php echo $cat['name'] ?>
								</span>
							<?php else: ?>
								<a href="<?php echo $cat['link'] . $queryParams; ?>" class="rounded-[6px] bg-[#E6E9EC] hover:bg-[#52a6b2] hover:text-white transition px-[13px] h-8 flex items-center">
									<?php echo $cat['name'] ?>
								</a>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
		<form id="filter-form" class="mb-0 excursions-container pb-12 sm:pb-0" data-category-id="<?php echo $current_category->term_id; ?>">
			<div class="pb-[20px] mb-[24px] border-b-2 border-[#E5E7EB]">
				<input type="hidden" id="category_id" value="<?php echo $current_category->term_id; ?>">

				<div id="calendar" class="w-full"></div>

				<div class="button-group flex w-full gap-3 font-medium">
					<button type="button" class="close-filter-btn button-cancel h-10 w-full flex items-center justify-center border border-neutral-300 rounded-[6px]" id="cancelBtn">Отмена</button>
					<button type="button" class="button-ok h-10 w-full flex items-center justify-center border border-[#52A6B2] bg-[#52A6B2] hover:bg-[#44909B] rounded-[6px] text-white" id="okBtn">Ок</button>
				</div>
			</div>

			<!--duration-->
			<div class="flex gap-3 flex-col w-full pb-[20px] mb-[24px] border-b-2 border-[#E5E7EB]">
				<div class="font-bold flex items-center gap-[10px]">
					<svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19" fill="none">
						<g clip-path="url(#clip0_78_2880)">
							<path d="M9.20006 1.06006C13.6901 1.06006 17.3301 4.70006 17.3301 9.19006C17.3301 13.6801 13.6901 17.3201 9.20006 17.3201C4.71006 17.3201 1.06006 13.6901 1.06006 9.20006C1.06006 4.71006 4.70006 1.06006 9.20006 1.06006Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M8.47021 5.15002V9.55002" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M12.2802 11.75L8.47021 9.55005" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
						</g>
						<defs>
							<clipPath id="clip0_78_2880">
								<rect width="18.39" height="18.39" fill="white"/>
							</clipPath>
						</defs>
					</svg>
					Длительность
				</div>
				<div class="flex gap-2 flex-wrap radio-group">
					<label class="flex items-center cursor-pointer relative">
						<input type="checkbox" name="duration" value="0-4" class="hidden peer" <?php  if (!empty($get_params["duration"]) && in_array('0-4', $get_params["duration"])) echo 'checked'; ?>>
						<span class="ps-4 pe-4 h-[32px] flex items-center border rounded-md bg-[#E6E9EC]  peer-checked:bg-[#52A6B2] peer-checked:text-white transition font-medium">
							<span>2,5-4 часа</span>
						</span>
					</label>
					<label class="flex items-center cursor-pointer relative">
						<input type="checkbox" name="duration" value="5-6" class="hidden peer" <?php  if (!empty($get_params["duration"]) && in_array('5-6', $get_params["duration"])) echo 'checked'; ?>>
						<span class="ps-4 pe-4 h-[32px] flex items-center border rounded-md bg-[#E6E9EC]  peer-checked:bg-[#52A6B2] peer-checked:text-white transition font-medium">
							<span>5-6 часов</span>
						</span>
					</label>
					<label class="flex items-center cursor-pointer relative">
						<input type="checkbox" name="duration" value="7-8" class="hidden peer" <?php  if (!empty($get_params["duration"]) && in_array('7-8', $get_params["duration"])) echo 'checked'; ?>>
						<span class="ps-4 pe-4 h-[32px] flex items-center border rounded-md bg-[#E6E9EC]  peer-checked:bg-[#52A6B2] peer-checked:text-white transition font-medium">
							<span>7-8 часов</span>
						</span>
					</label>
					<label class="flex items-center cursor-pointer relative">
						<input type="checkbox" name="duration" value="9-20" class="hidden peer" <?php  if (!empty($get_params["duration"]) && in_array('9-20', $get_params["duration"])) echo 'checked'; ?>>
						<span class="ps-4 pe-4 h-[32px] flex items-center border rounded-md bg-[#E6E9EC]  peer-checked:bg-[#52A6B2] peer-checked:text-white transition font-medium">
							<span>9-16 часов</span>
						</span>
					</label>
				</div>
			</div>

			<!--price-->
			<div class="flex gap-3 flex-col w-full">
				<div class="font-bold flex items-center gap-[10px]">
					<svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19" fill="none">
						<path d="M2 4.55556V13.4444C2 15.4081 5.18375 17 9.11111 17C13.0385 17 16.2222 15.4081 16.2222 13.4444V4.55556M2 4.55556C2 6.51923 5.18375 8.11111 9.11111 8.11111C13.0385 8.11111 16.2222 6.51923 16.2222 4.55556M2 4.55556C2 2.59188 5.18375 1 9.11111 1C13.0385 1 16.2222 2.59188 16.2222 4.55556M16.2222 9C16.2222 10.9637 13.0385 12.5556 9.11111 12.5556C5.18375 12.5556 2 10.9637 2 9" stroke="#111827" stroke-width="2"/>
					</svg>
					Стоимость
				</div>
				<div class="flex gap-2 flex-wrap radio-group">
					<label class="flex items-center cursor-pointer relative">
						<input type="checkbox" name="price" value="1-500" class="hidden peer" <?php  if (!empty($get_params["price"]) && in_array('1-500', $get_params["price"])) echo 'checked'; ?>>
						<span class="ps-4 pe-4 h-[32px] flex items-center border rounded-md bg-[#E6E9EC]  peer-checked:bg-[#52A6B2] peer-checked:text-white transition font-medium">
                                <span>300-500 ₽</span>
                                </span>

					</label>
					<label class="flex items-center cursor-pointer relative">
						<input type="checkbox" name="price" value="500-800" class="hidden peer" <?php  if (!empty($get_params["price"]) && in_array('500-800', $get_params["price"])) echo 'checked'; ?>>
						<span class="ps-4 pe-4 h-[32px] flex items-center border rounded-md bg-[#E6E9EC]  peer-checked:bg-[#52A6B2] peer-checked:text-white transition font-medium">
                                <span>500-800 ₽</span>
                                </span>
					</label>
					<label class="flex items-center cursor-pointer relative">
						<input type="checkbox" name="price" value="800-1200" class="hidden peer" <?php  if (!empty($get_params["price"]) && in_array('800-1200', $get_params["price"])) echo 'checked'; ?>>
						<span class="ps-4 pe-4 h-[32px] flex items-center border rounded-md bg-[#E6E9EC]  peer-checked:bg-[#52A6B2] peer-checked:text-white transition font-medium">
                                <span>800-1 200 ₽</span>
                                </span>
					</label>
					<label class="flex items-center cursor-pointer relative">
						<input type="checkbox" name="price" value="1200-10000" class="hidden peer" <?php  if (!empty($get_params["price"]) && in_array('1200-10000', $get_params["price"])) echo 'checked'; ?>>
						<span class="ps-4 pe-4 h-[32px] flex items-center border rounded-md bg-[#E6E9EC]  peer-checked:bg-[#52A6B2] peer-checked:text-white transition font-medium">
                                <span>1 200-1 800 ₽</span>
                                </span>
					</label>
				</div>
			</div>

			<!--dateForm-->
			<input type="hidden" name="dateForm" id="dateForm">
		</form>
	</div>

	<div class="w-full px-[42px] py-[15px] bg-white border-2 border-[#d6bd7f] justify-center items-center gap-3.5 flex mt-6">
		<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/logo-sigur.svg" alt="" class="object-cover ">
		<div>
			<div class="text-[14px] font-bold leading-[16px] mb-[4px]">Мы внесены в единый реестр туроператоров<br/></div>
			<div class="text-gray-900 text-[12px] font-normal leading-[22px]">№<?php echo $options['reestr']; ?> ИНН <?php echo $options['inn']; ?></div>
		</div>
	</div>
	<div class="w-full mt-6">
		<iframe src="https://yandex.ru/sprav/widget/rating-badge/92802349227?type=rating" width="150" height="50" frameborder="0"></iframe>
	</div>
</aside>
