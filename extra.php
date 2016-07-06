				<?php 
                    // Checks to see if the bullet color values are set
					$color1 = (get_field('bullet_1_color') ? 'background:' . get_field('bullet_1_color') . ';' : '');
					$color2 = (get_field('bullet_2_color') ? 'background:' . get_field('bullet_2_color') . ';' : '');
					$color3 = (get_field('bullet_3_color') ? 'background:' . get_field('bullet_3_color') . ';' : ''); 
				?>

				<ul class="bullets">
				  <li class="bullet">
				    <div class="bullet-icon bullet-icon-1" style="<?php echo $color1; ?>">
				    	<?php if(get_field('bullet_1_image')) {
							echo '<img src="' . get_field('bullet_1_image') . '" alt="">';
						} else { ?>
							<img src="<?php bloginfo('template_url'); ?>/images/bullet-1.png" alt="">
						<?php } ?>
				    </div>
				    <div class="bullet-content">
				      <?php the_field('bullet_1_content') ?>
				  </div>
				  </li>  
				  <li class="bullet">
				    <div class="bullet-icon bullet-icon-2" style="<?php echo $color2; ?>">
				      <?php if(get_field('bullet_2_image')) {
							echo '<img src="' . get_field('bullet_2_image') . '" alt="">';
						} else { ?>
							<img src="<?php bloginfo('template_url'); ?>/images/bullet-2.png" alt="">
						<?php } ?>
				    </div>
				    <div class="bullet-content">
				      <?php the_field('bullet_2_content') ?>
				  </div>
				  </li>
				  <li class="bullet">
				    <div class="bullet-icon bullet-icon-3" style="<?php echo $color3; ?>">
				      <?php if(get_field('bullet_3_image')) {
							echo '<img src="' . get_field('bullet_3_image') . '" alt="">';
						} else { ?>
							<img src="<?php bloginfo('template_url'); ?>/images/bullet-3.png" alt="">
						<?php } ?>
				    </div>
				    <div class="bullet-content">
				      <?php the_field('bullet_3_content') ?>
				  </div>
				  </li> 
				</ul>
