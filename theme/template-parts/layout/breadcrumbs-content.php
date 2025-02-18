<?php
/*var_dump(get_post_type()); // excursion везде
var_dump(is_singular('excursion')); //true на экскурсиях
var_dump(is_tax()); //категория экскурсии*/
$fields = get_fields();
$i=0
?>
<section class="breadcrumbs mt-1.5 mb-3 lg:mt-5 lg:mb-12 text-[12px] sm:text-[14px]">
	<div class="container">
		<ol itemscope itemtype="http://schema.org/BreadcrumbList" class="flex flex-wrap gap-x-1 text-[#999]">
			<?php if(is_category()): ?>
				<li itemprop="itemListElement" itemscope
					itemtype="http://schema.org/ListItem" class="inline">
					<a itemprop="item"  href="<?php echo get_site_url();?>">
						<span itemprop="name">Главная</span>
					</a>
					<meta itemprop="position" content="<?php echo ++$i; ?>" />
				</li>
				<li class="inline">-</li>
				<li itemprop="itemListElement" itemscope
					itemtype="http://schema.org/ListItem" class="inline">
					<a itemprop="item"  href="<?php echo get_permalink(203); ?>">
						<span itemprop="name">Блог</span>
					</a>
					<meta itemprop="position" content="<?php echo ++$i; ?>" />
				</li>
				<li class="inline">-</li>
				<?php
				$category = get_queried_object();
				$ancestors = get_ancestors($category->term_id, 'category');
				?>
				<?php if($ancestors): ?>
					<?php foreach(array_reverse($ancestors) as $ancestor_id) : ?>
						<?php $ancestor = get_term($ancestor_id, 'category'); ?>
						<li itemprop="itemListElement" itemscope
							itemtype="https://schema.org/ListItem" class="inline">
							<a itemprop="item" href="<?php echo get_term_link($ancestor)?>">
								<span itemprop="name"><?php echo $ancestor->name; ?></span></a>
							<meta itemprop="position" content="<?php echo ++$i; ?>" />
						</li>
						<li class="inline">-</li>
					<?php endforeach; ?>
				<?php endif; ?>
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="inline">
					<span itemprop="name"><?php echo $category->name; ?></span>
					<meta itemprop="position" content="<?php echo ++$i; ?>" />
				</li>
			<?php elseif(get_post_type() === 'promos') : ?>
				<li itemprop="itemListElement" itemscope
					itemtype="https://schema.org/ListItem" class="inline">
					<a itemprop="item" href="/">
						<span itemprop="name">Главная</a>
					<meta itemprop="position" content="<?php echo ++$i; ?>" />
				</li>
				<li class="inline">-</li>
				<li itemprop="itemListElement" itemscope
					itemtype="https://schema.org/ListItem" class="inline">
					<a itemprop="item" href="<?php echo get_permalink(199) ?>">
						<span itemprop="name">Акции</a>
					<meta itemprop="position" content="<?php echo ++$i; ?>" />
				</li>
				<li class="inline">-</li>
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="inline">
					<span itemprop="name" class="text-[#D6BD7F]"><?php echo get_the_title(); ?></span>
					<meta itemprop="position" content="<?php echo ++$i; ?>" />
				</li>
			<?php elseif(is_single()): ?>
				<?php $post_type = get_post_type(); ?>
				<?php if($post_type === 'tours'): ?>

					<?php $terms = wp_get_post_terms(get_the_ID(), 'excursion'); ?>
					<?php if (!empty($terms) && !is_wp_error($terms)) : ?>

						<?php
						$term = $fields['cat_hk'] ? get_term($fields['cat_hk']) : $terms[0];
						$ancestors = get_ancestors($term->term_id, 'excursion');
						?>
						<?php if ($ancestors) : ?>
							<?php  foreach (array_reverse($ancestors) as $ancestor_id) : ?>
								<?php $ancestor = get_term($ancestor_id, 'excursion'); ?>
								<li itemprop="itemListElement" itemscope
									itemtype="https://schema.org/ListItem" class="inline">
									<a itemprop="item" href="<?php echo get_term_link($ancestor); ?>">
										<span itemprop="name"><?php echo $ancestor->name; ?></span></a>
									<meta itemprop="position" content="<?php echo ++$i; ?>" />
								</li>
								<li class="inline">-</li>
							<?php endforeach; ?>
						<?php endif; ?>
						<li itemprop="itemListElement" itemscope
							itemtype="https://schema.org/ListItem" class="inline">
							<a itemprop="item" href="<?php echo get_term_link($term); ?>">
								<span itemprop="name"><?php echo $term->name; ?></span></a>
							<meta itemprop="position" content="<?php echo ++$i; ?>" />
						</li>
						<li class="inline">-</li>
					<?php endif; ?>
				<?php else: ?>
					<?php $categories = get_the_category(); ?>
					<?php if (!empty($categories)): ?>
						<?php
						$category = $categories[0];
						$ancestors = get_ancestors($category->term_id, 'category');
						?>
						<?php if ($ancestors): ?>
							<?php foreach(array_reverse($ancestors) as $ancestor_id) : ?>
								<?php $ancestor = get_term($ancestor_id, 'category'); ?>
								<li itemprop="itemListElement" itemscope
									itemtype="https://schema.org/ListItem" class="inline">
									<a itemprop="item" href="<?php echo get_term_link($ancestor)?>">
										<span itemprop="name"><?php echo $ancestor->name; ?></span></a>
									<meta itemprop="position" content="<?php echo ++$i; ?>" />
								</li>
								<li class="inline">-</li>
							<?php endforeach; ?>
						<?php endif; ?>
						<li itemprop="itemListElement" itemscope
							itemtype="http://schema.org/ListItem" class="inline">
							<a itemprop="item"  href="<?php echo get_site_url();?>">
								<span itemprop="name">Главная</span>
							</a>
							<meta itemprop="position" content="<?php echo ++$i; ?>" />
						</li>
						<li class="inline">-</li>
						<li itemprop="itemListElement" itemscope
							itemtype="http://schema.org/ListItem" class="inline">
							<a itemprop="item"  href="<?php echo get_permalink(203); ?>">
								<span itemprop="name">Блог</span>
							</a>
							<meta itemprop="position" content="<?php echo ++$i; ?>" />
						</li>
						<li class="inline">-</li>
					<?php endif; ?>
				<?php endif; ?>
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="inline">
					<span itemprop="name" class="text-[#D6BD7F]"><?php echo get_the_title(); ?></span>
					<meta itemprop="position" content="<?php echo ++$i; ?>" />
				</li>
			<?php elseif (is_tax('excursion')) : ?>
				<?php
				$term = get_queried_object();
				$ancestors = get_ancestors($term->term_id, 'excursion');
				?>

				<?php if ($ancestors) : ?>
					<?php foreach (array_reverse($ancestors) as $ancestor_id) : ?>
						<?php $ancestor = get_term($ancestor_id, 'excursion'); ?>

						<li itemprop="itemListElement" itemscope
							itemtype="https://schema.org/ListItem" class="inline">
							<a itemprop="item" href="<?php echo get_term_link($ancestor); ?>">
								<span itemprop="name"><?php echo $ancestor->name; ?></span></a>
							<meta itemprop="position" content="<?php echo ++$i; ?>" />
						</li>
						<li class="inline">-</li>
					<?php endforeach; ?>

				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="inline">
					<span itemprop="name" class="text-[#D6BD7F]"><?php echo $term->name; ?></span>
					<meta itemprop="position" content="<?php echo ++$i; ?>" />
				</li>
			<?php endif; ?>

			<?php elseif (is_home() || is_front_page()) : ?>
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="inline">
					<span itemprop="name" class="text-[#D6BD7F]">Блог</span>
					<meta itemprop="position" content="<?php echo ++$i; ?>" />
				</li>

				// Для остальных случаев (например, страниц)
			<?php elseif(is_page()) : ?>
				<li itemprop="itemListElement" itemscope
					itemtype="https://schema.org/ListItem" class="inline">
					<a itemprop="item" href="/">
						<span itemprop="name">Главная</a>
					<meta itemprop="position" content="<?php echo ++$i; ?>" />
				</li>
				<li class="inline">-</li>
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="inline">
					<span itemprop="name" class="text-[#D6BD7F]"><?php echo get_the_title(); ?></span>
					<meta itemprop="position" content="<?php echo ++$i; ?>" />
				</li>
			<?php else : ?>
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="inline">
					<span itemprop="name" class="text-[#D6BD7F]"><?php echo get_the_title(); ?></span>
					<meta itemprop="position" content="<?php echo ++$i; ?>" />
				</li>
			<?php endif; ?>
		</ol>
	</div>
</section>
