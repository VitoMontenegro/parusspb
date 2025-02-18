<?php
/**
 * Страница с кастомным шаблоном (page-custom.php)
 * @package WordPress
 * Template Name: Контакты
 */


$options = get_fields( 'option');
$fields = get_fields();
get_header();
?>
<section class="primary content--reviews">
	<main id="main">
		<?php get_template_part( 'template-parts/layout/breadcrumbs', 'content' ); ?>



		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="container">
					<div class="overflow-x-hidden">
						<div class="entry-content">
							<h1 class="mt-0 text-2xl sm:text-3xl font-bold tracking-tight mb-[22px] sm:mb-6"><?php the_title() ; ?></h1>
							<?php the_content(); ?>

							<div class="self-stretch justify-start items-start gap-12 mb-12 flex flex-col md:flex-row">
								<div class="flex-col justify-start items-start gap-6 flex">
									<div class="sm:w-full max-w-[348px] justify-start items-start gap-3 inline-flex">
										<div class="pt-0.5 justify-start items-start gap-2.5 flex">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<path d="M17.6569 16.6569C16.7202 17.5935 14.7616 19.5521 13.4138 20.8999C12.6327 21.681 11.3677 21.6814 10.5866 20.9003C9.26234 19.576 7.34159 17.6553 6.34315 16.6569C3.21895 13.5327 3.21895 8.46734 6.34315 5.34315C9.46734 2.21895 14.5327 2.21895 17.6569 5.34315C20.781 8.46734 20.781 13.5327 17.6569 16.6569Z" stroke="#1A1A18" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
												<path d="M15 11C15 12.6569 13.6569 14 12 14C10.3431 14 9 12.6569 9 11C9 9.34315 10.3431 8 12 8C13.6569 8 15 9.34315 15 11Z" stroke="#1A1A18" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>
										</div>
										<div class="grow shrink basis-0 flex-col justify-start items-start gap-2 inline-flex">
											<div class="self-stretch text-[#1a1a18] text-lg font-medium font-['Inter'] leading-7">Адрес офиса: </div>
											<div class="self-stretch text-gray-500 text-base font-normal font-['Inter'] leading-normal">Лиговский проспект 43/45, БЦ Ретро, 3 этаж, 309 офис (около Московского вокзала)</div>
										</div>
									</div>
									<div class="sm:w-full max-w-[348px] justify-start items-start gap-3 inline-flex">
										<div class="pt-0.5 justify-start items-start gap-2.5 flex">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<path d="M3 5C3 3.89543 3.89543 3 5 3H8.27924C8.70967 3 9.09181 3.27543 9.22792 3.68377L10.7257 8.17721C10.8831 8.64932 10.6694 9.16531 10.2243 9.38787L7.96701 10.5165C9.06925 12.9612 11.0388 14.9308 13.4835 16.033L14.6121 13.7757C14.8347 13.3306 15.3507 13.1169 15.8228 13.2743L20.3162 14.7721C20.7246 14.9082 21 15.2903 21 15.7208V19C21 20.1046 20.1046 21 19 21H18C9.71573 21 3 14.2843 3 6V5Z" stroke="#1A1A18" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>
										</div>
										<div class="grow shrink basis-0 flex-col justify-start items-start gap-2 inline-flex">
											<div class="self-stretch text-[#1a1a18] text-lg font-medium font-['Inter'] leading-7">Номера телефонов:</div>
											<div class="self-stretch text-gray-500 text-base font-normal font-['Inter'] leading-normal"> <a href="tel:<?php echo  preg_replace('/[^0-9+]/', '', $options['phone']);  ?>"><?php echo $options['phone'];?></a>, <a href="tel:<?php echo  preg_replace('/[^0-9+]/', '', $options['second_phone']);  ?>"><?php echo $options['second_phone'];?></a></div>
										</div>
									</div>
									<div class="sm:w-full max-w-[348px] justify-start items-start gap-3 inline-flex">
										<div class="pt-0.5 justify-start items-start gap-2.5 flex">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<path d="M3 8L10.8906 13.2604C11.5624 13.7083 12.4376 13.7083 13.1094 13.2604L21 8M5 19H19C20.1046 19 21 18.1046 21 17V7C21 5.89543 20.1046 5 19 5H5C3.89543 5 3 5.89543 3 7V17C3 18.1046 3.89543 19 5 19Z" stroke="#1A1A18" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>
										</div>
										<div class="grow shrink basis-0 flex-col justify-start items-start gap-2 inline-flex">
											<div class="self-stretch text-[#1a1a18] text-lg font-medium font-['Inter'] leading-7">Электронная почта:</div>
											<a href="mailto:<?php echo $options['email'];?>" class="self-stretch text-gray-500 text-base font-normal font-['Inter'] leading-normal">Email: <?php echo $options['email'];?></a>
										</div>
									</div>
									<div class="sm:w-full max-w-[348px] justify-start items-start gap-3 inline-flex">
										<div class="grow shrink basis-0 flex-col justify-start items-start gap-2 inline-flex">
											<div class="self-stretch text-[#1a1a18] text-lg font-medium font-['Inter'] leading-7"> Мессенджеры и социальные сети:</div>
											<div class="justify-start items-start gap-3 inline-flex">
												<div class="justify-start items-start gap-2.5 flex">
													<a target="_blank" href="https://api.whatsapp.com/send?phone=<?php echo preg_replace('/[^0-9]/', '', $options['watsapp']);  ?>&text=Здравствуйте.+Я+обращаюсь+с+сайта+groupspb.ru" class="w-12 h-12 relative  overflow-hidden">
														<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" fill="none">
															<g clip-path="url(#clip0_395_7076)">
																<path d="M24 0C10.752 0 0 10.752 0 24C0 37.248 10.752 48 24 48C37.248 48 48 37.248 48 24C48 10.752 37.248 0 24 0Z" fill="#0DC143"/>
																<path d="M34.7465 13.2115C32.1736 10.5628 28.6168 9.125 24.9844 9.125C17.2655 9.125 11.0601 15.4061 11.1357 23.0493C11.1357 25.4709 11.8168 27.8169 12.9519 29.9358L10.9844 37.125L18.3249 35.2331C20.3682 36.3682 22.6384 36.898 24.9087 36.898C32.5519 36.898 38.7573 30.6169 38.7573 22.9736C38.7573 19.2655 37.3195 15.7845 34.7465 13.2115ZM24.9844 34.552C22.9411 34.552 20.8979 34.0223 19.1573 32.9628L18.7033 32.7358L14.3141 33.8709L15.4492 29.5574L15.1465 29.1034C11.8168 23.7304 13.406 16.6169 18.8546 13.2872C24.3033 9.95743 31.3411 11.5466 34.6709 16.9953C38.0006 22.4439 36.4114 29.4818 30.9628 32.8115C29.2222 33.9466 27.1033 34.552 24.9844 34.552ZM31.6438 26.152L30.8114 25.7736C30.8114 25.7736 29.6006 25.2439 28.8438 24.8655C28.7682 24.8655 28.6925 24.7899 28.6168 24.7899C28.3898 24.7899 28.2384 24.8655 28.0871 24.9412C28.0871 24.9412 28.0114 25.0169 26.9519 26.2277C26.8763 26.3791 26.7249 26.4547 26.5736 26.4547H26.4979C26.4222 26.4547 26.2709 26.3791 26.1952 26.3034L25.8168 26.152C24.9844 25.7736 24.2276 25.3196 23.6222 24.7142C23.4709 24.5628 23.2438 24.4115 23.0925 24.2601C22.5628 23.7304 22.033 23.125 21.6546 22.4439L21.579 22.2926C21.5033 22.2169 21.5033 22.1412 21.4276 21.9899C21.4276 21.8385 21.4276 21.6872 21.5033 21.6115C21.5033 21.6115 21.806 21.2331 22.033 21.0061C22.1844 20.8547 22.2601 20.6277 22.4114 20.4764C22.5628 20.2493 22.6384 19.9466 22.5628 19.7196C22.4871 19.3412 21.579 17.298 21.3519 16.8439C21.2006 16.6169 21.0492 16.5412 20.8222 16.4655H20.5952C20.4438 16.4655 20.2168 16.4655 19.9898 16.4655C19.8384 16.4655 19.6871 16.5412 19.5357 16.5412L19.4601 16.6169C19.3087 16.6926 19.1573 16.8439 19.006 16.9196C18.8546 17.0709 18.779 17.2223 18.6276 17.3736C18.0979 18.0547 17.7952 18.8872 17.7952 19.7196C17.7952 20.325 17.9465 20.9304 18.1736 21.4601L18.2492 21.6872C18.9303 23.125 19.8384 24.4115 21.0492 25.5466L21.3519 25.8493C21.579 26.0764 21.806 26.2277 21.9573 26.4547C23.5465 27.8169 25.3628 28.8007 27.406 29.3304C27.633 29.4061 27.9357 29.4061 28.1628 29.4818C28.3898 29.4818 28.6925 29.4818 28.9195 29.4818C29.2979 29.4818 29.7519 29.3304 30.0546 29.1791C30.2817 29.0277 30.433 29.0277 30.5844 28.8764L30.7357 28.725C30.8871 28.5736 31.0384 28.498 31.1898 28.3466C31.3411 28.1953 31.4925 28.0439 31.5682 27.8926C31.7195 27.5899 31.7952 27.2115 31.8709 26.8331C31.8709 26.6818 31.8709 26.4547 31.8709 26.3034C31.8709 26.3034 31.7952 26.2277 31.6438 26.152Z" fill="white"/>
															</g>
															<defs>
																<clipPath id="clip0_395_7076">
																	<rect width="48" height="48" fill="white"/>
																</clipPath>
															</defs>
														</svg>
													</a>
													<a target="_blank" href="tg://resolve?domain=<?php echo $options['telegram'];  ?>" class="w-12 h-12 relative  overflow-hidden">
														<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" fill="none">
															<g clip-path="url(#clip0_395_7080)">
																<path d="M24 0C10.7625 0 0 10.7625 0 24C0 37.2375 10.7625 48 24 48C37.2375 48 48 37.2375 48 24C48 10.7625 37.2375 0 24 0Z" fill="#419FD9"/>
																<path fill-rule="evenodd" clip-rule="evenodd" d="M29.3331 35.885C31.0106 36.619 31.6397 35.0812 31.6397 35.0812L36.0781 12.7843C36.0432 11.2816 34.0162 12.1902 34.0162 12.1902L9.16807 21.9407C9.16807 21.9407 7.97983 22.3601 8.08468 23.094C8.18952 23.8279 9.13312 24.1774 9.13312 24.1774L15.3888 26.2743C15.3888 26.2743 17.276 32.4601 17.6605 33.6484C18.0099 34.8016 18.3245 34.8366 18.3245 34.8366C18.674 34.9764 18.9885 34.7318 18.9885 34.7318L23.0425 31.0622L29.3331 35.885ZM30.4158 16.733C30.4158 16.733 31.2895 16.2088 31.2546 16.733C31.2546 16.733 31.3944 16.8029 30.94 17.2922C30.5207 17.7115 20.6304 26.5884 19.3023 27.7766C19.1975 27.8465 19.1276 27.9513 19.1276 28.0911L18.7432 31.3763C18.6733 31.7257 18.2189 31.7607 18.1141 31.4461L16.4715 26.0641C16.4016 25.8544 16.4715 25.6098 16.6812 25.47L30.4158 16.733Z" fill="white"/>
															</g>
															<defs>
																<clipPath id="clip0_395_7080">
																	<rect width="48" height="48" fill="white"/>
																</clipPath>
															</defs>
														</svg>
													</a>
													<a target="_blank" href="https://www.youtube.com/<?php echo $options['youtube'];  ?>" class="w-12 h-12 relative">
														<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" fill="none">
															<circle cx="24" cy="24" r="24" fill="#FF0000"/>
															<path d="M32.8934 32.4705H15.9508C13.6839 32.4705 11.8574 30.4656 11.8574 27.9996V20.0002C11.8574 17.5241 13.693 15.5293 15.9508 15.5293H32.8934C35.1604 15.5293 36.9868 17.5342 36.9868 20.0002V27.9996C36.996 30.4756 35.1604 32.4705 32.8934 32.4705Z" fill="white"/>
															<path d="M28.8675 23.8746L21.7402 19.7646V27.9846L28.8675 23.8746Z" fill="#FF0000"/>
														</svg>
													</a>
													<a target="_blank" href="https://vk.com/<?php echo $options['vk'];  ?>" class="w-12 h-12 relative  overflow-hidden">
														<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" fill="none">
															<g clip-path="url(#clip0_395_7092)">
																<path d="M24 0C10.752 0 0 10.752 0 24C0 37.248 10.752 48 24 48C37.248 48 48 37.248 48 24C48 10.752 37.248 0 24 0Z" fill="#5181B8"/>
																<path d="M25.4399 33.7202C14.4999 33.7202 8.26 26.2202 8 13.7402H13.48C13.66 22.9002 17.6999 26.7802 20.8999 27.5802V13.7402H26.0601V21.6402C29.2201 21.3002 32.5397 17.7002 33.6597 13.7402H38.8198C37.9598 18.6202 34.3598 22.2202 31.7998 23.7002C34.3598 24.9002 38.46 28.0402 40.02 33.7202H34.3398C33.1198 29.9202 30.0801 26.9802 26.0601 26.5802V33.7202H25.4399Z" fill="white"/>
															</g>
															<defs>
																<clipPath id="clip0_395_7092">
																	<rect width="48" height="48" fill="white"/>
																</clipPath>
															</defs>
														</svg>
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="grow shrink basis-0 flex-col justify-start items-start flex w-full">
									
										<iframe src="https://yandex.ru/map-widget/v1/?z=12&ol=biz&oid=92802349227" class="w-full h-[200px] sm:h-[384px]"  frameborder="0"></iframe>
								</div>
							</div>





							<div class="flex-col justify-start items-start flex overflow-hidden mb-12">
								<div class="self-stretch pb-12 flex-col justify-start items-center gap-8 flex overflow-hidden">
									<div class="self-stretch h-[493px] flex-col justify-start items-start flex">
										<div class="self-stretch h-[493px] flex-col justify-start items-start gap-12 flex">
											<div class="self-stretch h-0.5 bg-[#d6bd7f]"></div>
											<div class="self-stretch h-[443px] flex-col justify-start items-start gap-8 flex">
												<div class="flex-col justify-start items-start gap-6 flex">
													<div class="text-[#1a1a18] text-2xl font-bold font-['Inter'] leading-7">Наш офис на Лиговском проспекте</div>
												</div>
												<div class="self-stretch h-[383px] flex-col justify-start items-start gap-8 flex swiper_small">
													<div class="swiper-wrapper self-stretch h-[180px] justify-start items-start inline-flex">
														<?php if(isset($fields['slider']) & !empty($fields['slider'])): ?>
															<?php foreach($fields['slider'] as $item) : ?>
																<div class="swiper-slide">
																	<img  data-fancybox="gallery" src="<?php echo $item ?>" class="h-[180px] rounded object-cover w-full cursor-pointer" src="<?php echo $item; ?>" />
																</div>
															<?php endforeach; ?>
														<?php endif; ?>
														
														
													</div>
													<div class="self-stretch justify-start items-start gap-8 inline-flex">
														<div class="grow shrink basis-0 text-gray-500 text-base font-normal font-['Inter']">Реквизиты:<br/><?php echo $options['info'];  ?></div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>

			</div>


		</article><!-- #post-<?php the_ID(); ?> -->






	</main>
</section>

<?php get_footer(); ?>
