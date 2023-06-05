<script type="text/javascript">
	(function($) {
		'use strict';
		var w = $(window);
		var infsp;
		infsp = {
			init: function() {
				
				var type = '<?php echo $general_option['infinite_sp_pagination_type']; ?>';
				var status = '<?php echo $general_option['infinite_sp_pagination_on_off'];?>';
				var scrolltop = '<?php echo $advanced_option['infinite_scroll_to_top_enable'];?>';
				
						if( status == 'on') {


							if(type == 'infinite_ajax_select') {
								$('body').on('click', '<?php echo esc_attr($general_option['infinite_sp_woo_prev_selector']).' a'; ?>', function(e) {
									e.preventDefault();
									var href = $.trim($(this).attr('href'));
									if(href != '') {
										if(!infsp.msieversion()) {
											history.pushState(null, null, href);
										}
										<?php if(trim($general_option['infinite_loader_image']) != '') { ?>
										$('<?php echo esc_attr($general_option['infinite_sp_woo_prev_selector']); ?>').before('<div id="isp-infinite-scroll-loader" class="isp-infinite-scroll-loader"><img src="<?php echo esc_url($general_option['infinite_loader_image']); ?>" alt=" " /><span><?php echo esc_html($general_option['infinite_loading_btn_text']); ?></span></div>');
										<?php } ?>
										$.get(href, function(response) {
											if(!infsp.msieversion()) {
												document.title = $(response).filter('title').html();
											}
											<?php
												$infinite_sp_content_selectors = $general_option['infinite_sp_content_selector'].','.$general_option['infinite_sp_woo_prev_selector'];
												$infinite_sp_content_selectors = explode(',', $infinite_sp_content_selectors);
												foreach($infinite_sp_content_selectors as $infinite_sp_content_selector) {
													if(trim($infinite_sp_content_selector) == '')
														continue;
													?>
													var html = $(response).find('<?php echo $infinite_sp_content_selector; ?>').html();
													$('<?php echo $infinite_sp_content_selector; ?>').html(html);
													<?php
												} ?>
												$('.isp-infinite-scroll-loader').remove();
												
												if( scrolltop == 'on') { 
													var scrollto = 0;
													<?php if(trim($advanced_option['infinite_scroll_totop']) != '') { ?>
														if($('<?php echo $advanced_option['infinite_scroll_totop']; ?>').length) {
															var scrollto = $('<?php echo $advanced_option['infinite_scroll_totop']; ?>').offset().top;
														}
													<?php } ?>
													$('html, body').animate({ scrolltop: scrollto }, 500);
												} 
											
											$('<?php echo esc_attr($general_option['infinite_sp_content_selector']).' '.$general_option['infinite_sp_woo_item_selector']; ?>').addClass('animated <?php echo esc_attr($advanced_option['infinite_sp_animation']);?>').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
												$(this).removeClass('animated <?php echo esc_attr($advanced_option['infinite_sp_animation']);?>');
											});
										});
									}
								});
							}
							
							
							if(type == 'infinite_load_more_btn' || type == 'infinite_scrolling') {
								$(document).ready(function() {
									if($('<?php echo esc_attr($general_option['infinite_sp_woo_prev_selector']); ?>').length) {
										$('<?php echo esc_attr($general_option['infinite_sp_woo_prev_selector']); ?>').before('<div id="isp-infinite-scroll-load-more" class="isp-infinite-scroll-load-more"><a isp-processing="0"><?php echo esc_attr($general_option['infinite_load_more_btn_text']);?></a><br class="ispw-clear" /></div>');
										if(type == 'infinite_scrolling') {
											$('#isp-infinite-scroll-load-more').addClass('isp-hide');
										}
									}
									$('<?php echo esc_attr($general_option['infinite_sp_woo_prev_selector']); ?>').addClass('isp-hide');
									$('<?php echo esc_attr($general_option['infinite_sp_content_selector']).' '.$general_option['infinite_sp_woo_item_selector']; ?>').addClass('isp-added');
								});
								$('body').on('click', '#isp-infinite-scroll-load-more a', function(e) {
									e.preventDefault();
									if($('<?php echo esc_attr($general_option['infinite_sp_woo_next_selector']); ?>').length) {
										$('#isp-infinite-scroll-load-more a').attr('isp-processing', 1);
										var href = $('<?php echo $general_option['infinite_sp_woo_next_selector']; ?>').attr('href');
										<?php if(trim($general_option['infinite_loader_image']) != '') { ?>
										$('<?php echo esc_attr($general_option['infinite_sp_woo_prev_selector']); ?>').before('<div id="isp-infinite-scroll-loader" class="isp-infinite-scroll-loader"><img src="<?php echo esc_url($general_option['infinite_loader_image']); ?>" alt=" " /><span><?php echo esc_html($general_option['infinite_loading_btn_text']); ?></span></div>');
										<?php } ?>
										
										$.get(href, function(response) {
											$('<?php echo esc_attr($general_option['infinite_sp_woo_prev_selector']); ?>').html($(response).find('<?php echo esc_attr($general_option['infinite_sp_woo_prev_selector']); ?>').html());
											
											$(response).find('<?php echo esc_attr($general_option['infinite_sp_content_selector']).' '.$general_option['infinite_sp_woo_item_selector']; ?>').each(function() {
												$('<?php echo esc_attr($general_option['infinite_sp_content_selector']).' '.$general_option['infinite_sp_woo_item_selector']; ?>:last').after($(this));
											});
											
											$('#isp-infinite-scroll-loader').remove();
											$('#isp-infinite-scroll-load-more').show();
											$('#isp-infinite-scroll-load-more a').attr('isp-processing', 0);
										
											$('<?php echo esc_attr($general_option['infinite_sp_content_selector']).' '.$general_option['infinite_sp_woo_item_selector']; ?>').not('.isp-added').addClass('animated <?php echo esc_attr($advanced_option['infinite_sp_animation']);?>').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
												$(this).removeClass('animated <?php echo esc_attr($advanced_option['infinite_sp_animation']);?>').addClass('isp-added');
											});
											
											if($('<?php echo esc_attr($general_option['infinite_sp_woo_next_selector']); ?>').length == 0) {
												$('#isp-infinite-scroll-load-more').addClass('finished').removeClass('isp-hide');
												$('#isp-infinite-scroll-load-more a').show().html('No More Product Available').css('cursor', 'default');
											}
											
										});
									} else {
										$('#isp-infinite-scroll-load-more').addClass('finished').removeClass('isp-hide');
										$('#isp-infinite-scroll-load-more a').show().html('No More Product Available').css('cursor', 'default');
									}
								});
								
							}
							
							if(type == 'infinite_scrolling') {
							
								var sp_woo_buffer_pixels = Math.abs(<?php echo esc_attr($advanced_option['infinite_sp_woo_buffer_pixels']); ?>);
								w.scroll(function () {
									if($('<?php echo esc_attr($general_option['infinite_sp_content_selector']); ?>').length) {
										var a = $('<?php echo esc_attr($general_option['infinite_sp_content_selector']); ?>').offset().top + $('<?php echo $general_option['infinite_sp_content_selector']; ?>').outerHeight();
										var b = a - w.scrollTop();
										if ((b - sp_woo_buffer_pixels ) < w.height()) {
											if($('#isp-infinite-scroll-load-more a').attr('isp-processing') == 0) {
												$('#isp-infinite-scroll-load-more a').trigger('click');
											}
										}
									}
								});
							
							} 
						}
			},

			msieversion: function() {
				var ua = window.navigator.userAgent;
				var inf_scroll_index = ua.indexOf("MSIE ");
	
				if (inf_scroll_index > 0) 
					return parseInt(ua.substring(inf_scroll_index + 5, ua.indexOf(".", inf_scroll_index)));

				return false;
			},
			
		};
		infsp.init();
		
	})(jQuery);
	
</script>
