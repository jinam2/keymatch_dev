<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 13:51:50 */
function SkyTpl_Func_2770571809 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
	<!-- SlidesJS Required: Link to jQuery -->
	<SCRIPT type='text/javascript'>
	if ( !window.jQuery )
	{
		document.write("<script type='text/javascript' src='js/jquery-1.9.1.min.js'><"+"/script>");
	}
	</SCRIPT>
	<!-- End SlidesJS Required -->

	<!-- SlidesJS Required: Link to jquery.slides.js -->
	<script src='<?=$_data['js_file']?>'></script>
	<!-- End SlidesJS Required -->

	<!-- SlidesJS Required: Initialize SlidesJS with a jQuery doc ready -->
	<script>
	$(function() {
		$('#slides').slidesjs({
			width: <?=$_data['HAPPY_CONFIG']['slidesjs_width_pc']?>,
			height: <?=$_data['HAPPY_CONFIG']['slidesjs_height_pc']?>,
			start: <?=$_data['HAPPY_CONFIG']['slidesjs_start_pc']?>,
			navigation: true,

			play: {
				active: false,
				// [boolean] Generate the play and stop buttons.
				// You cannot use your own buttons. Sorry.
				effect: "<?=$_data['HAPPY_CONFIG']['slidesjs_play_effect_pc']?>",
				// [string] Can be either "slide" or "fade".
				interval: <?=$_data['HAPPY_CONFIG']['slidesjs_play_interval_pc']?>,
				// [number] Time spent on each slide in milliseconds.
				auto: <?=$_data['HAPPY_CONFIG']['slidesjs_play_auto_pc']?>,
				// [boolean] Start playing the slideshow on load.
				swap: true,
				// [boolean] show/hide stop and play buttons
				pauseOnHover: <?=$_data['HAPPY_CONFIG']['slidesjs_play_pauseOnHover_pc']?>,
				// [boolean] pause a playing slideshow on hover
				restartDelay: <?=$_data['HAPPY_CONFIG']['slidesjs_play_restartDelay_pc']?>

				// [number] restart delay on inactive slideshow
			},

			effect: {
				slide: {
				// Slide effect settings.
				speed: <?=$_data['HAPPY_CONFIG']['slidesjs_effect_slide_speed_pc']?>

				// [number] Speed in milliseconds of the slide animation.
				},
				fade: {
				speed: <?=$_data['HAPPY_CONFIG']['slidesjs_effect_fade_speed_pc']?>,
				// [number] Speed in milliseconds of the fade animation.
				crossfade: <?=$_data['HAPPY_CONFIG']['slidesjs_crossfade_pc']?>

				// [boolean] Cross-fade the transition.
				}
			}

		});
	});
	</script>
	<!-- End SlidesJS Required -->
<? }
?>