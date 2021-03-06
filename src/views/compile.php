<div class="container-fluid">
	<pre style="color:white;background-color:black;margin-top:0.5em;">
		<?= $output; ?>
	</pre>
</div>

<?php
if (isset($delay)) { ?>
<script type="text/javascript">
/*
	Autorunning watch loop for SCSS Compiler

	setTimeout() doesn't stop script execution, so we can't use loops.
	Solution is to reschedule the timer each time when setTimeout finishes
	See: http://javascript.info/tutorial/settimeout-setinterval
*/

	// Script vars - set them in App\Controller::actionWatch() method
	// The delay in ms (microseconds), 1000 ms = 1 sec; if < min_delay - stop watching
	var watch_delay = <?= $delay; ?>;
	var min_delay = <?= $min_delay; ?>;

	// URL for ajax query
	var url_ajax = "<?= $url_ajax; ?>";

	// On document ready autorun function - start watching
	(function($)
	{
		// Check delay
		if (watch_delay < min_delay) {
			alert('Incorrect delay! Min delay is ' + min_delay + ' msecs. Current delay is: ' + watch_delay + ' msecs');
			return;
		}

		setTimeout(function()
		{
			// Check stop condition
			if (watch_delay < min_delay) {
				return;
			}

			// Ajax request for conditional compiling
			jQuery.get(url_ajax, function(response){
				$("pre").append(response);				// Add response to compiler output
			});

			// Reschedule itself as next task
			setTimeout(arguments.callee, watch_delay);
		}, watch_delay);

	}(jQuery));

	// Stop watching
	function watchStop()
	{
		watch_delay = 0;
	}
</script>
<?php } ?>
