<?php

use Chevereto\Legacy\G\Handler;
use function Chevereto\Legacy\G\require_theme_footer;
use function Chevereto\Legacy\G\require_theme_header;
use function Chevereto\Legacy\G\safe_html;

// @phpstan-ignore-next-line
if (!defined('ACCESS') || !ACCESS) {
    die('This file cannot be directly accessed.');
} ?>
<?php require_theme_header(); ?>
<div class="center-box c24 margin-top-20 padding-bottom-10">
	<div class="content-width">
		<div class="header default-margin-bottom">
			<h1 class="header-title"><i class="fa-solid fa-plug-circle-plus color-accent margin-right-5"></i><?php _se('Upload plugin'); ?></h1>
		</div>
		<div class="text-content">
			<p><?php _se('Add media uploading and sharing to your website, blog or forum by installing our upload plugin.'); ?> <?php _se('It provides file uploading to any website by placing a button that will allow your users to directly upload to our service and it will automatically handle the codes needed for insertion.'); ?> <?php _se('All features included like drag and drop, remote upload, image resizing and more.'); ?></p>
			<h2><i class="fa-solid fa-circle-check color-accent margin-right-5"></i><?php _se('Supported software'); ?></h2>
			<p><?php _se('The plugin works in any website with user-editable content and for %sv, it will place an upload button that will match the target editor toolbar so no extra customization is needed.', ['%sv' =>  _s('supported software')]); ?></p>
			<ul>
				<?php
                    foreach (Handler::var('plugin')['vendors'] as $k => $v) {
                        echo '<li>' . $v . '</li>' . "\n";
                    }
                ?>
			</ul>
			<h2><i class="fa-solid fa-wand-magic-sparkles color-accent margin-right-5"></i><?php _se('Add it to your website'); ?></h2>
			<p><?php _se('Copy and paste the plugin code into your website HTML code (preferably inside the head section). There are plenty %o to make it fit better to your needs.', ['%o' => _s('options')]); ?></p>
			<div data-content="pup-options">
				<div class="input-label">
					<label for="palette"><?php _se('Color palette'); ?></label>
					<div class="c9 phablet-c1">
						<select type="text" name="palette" id="palette" class="text-input">
							<?php
                                foreach (Handler::var('plugin')['palettes'] as $k => $v) {
                                    $attr = 'value="' . ($k == 'default' ? '' : $k) . '"';
                                    if ($k == 'default') {
                                        $attr .= ' selected="selected"';
                                    }
                                    echo '<option ' . $attr . '>' . ucfirst($k) . '</option>' . "\n";
                                }
                            ?>
						</select>
					</div>
					<div class="input-below"><?php _se('Button color scheme'); ?></div>
				</div>
				<div class="input-label">
					<label for="auto-insert"><?php _se('Embed codes'); ?></label>
						<div class="c9 phablet-c1">
						<select type="text" name="auto-insert" id="auto-insert" class="text-input">
							<?php
                                foreach (Handler::var('plugin')['embed'] as $k => $v) {
                                    $attr = 'value="' . $k . '"';
                                    if (!$k) {
                                        $attr .= ' selected="selected"';
                                    }
                                    echo '<option ' . $attr . '>' . $v . '</option>' . "\n";
                                }
                            ?>
						</select>
					</div>
					<div class="input-below"><?php _se('Embed codes that will be auto-inserted in editor box'); ?></div>
				</div>
				<div class="input-label">
					<label for="sibling"><?php _se('Sibling selector'); ?></label>
					<div class="c9 phablet-c1">
						<input type="text" name="sibling" id="sibling" class="text-input" placeholder="Empty string">
					</div>
					<div class="input-below"><?php _se('Sibling element selector where to place the button next to'); ?></div>
				</div>
				<div class="input-label">
					<label for="sibling-pos"><?php _se('Sibling position'); ?></label>
					<div class="c9 phablet-c1">
						<select type="text" name="sibling-pos" id="sibling-pos" class="text-input">
							<option value="" selected="selected"><?php _se('After'); ?></option>
							<option value="before"><?php _se('Before'); ?></option>
						</select>
					</div>
					<div class="input-below"><?php _se('Position relative to sibling element'); ?></div>
				</div>
			</div>

			<h4 class="margin-bottom-10"><i><?php _se('Preview'); ?></i></h4>
			<div><?php echo Handler::var('plugin')['stylesheet']; echo Handler::var('plugin')['button']; ?></div>

			<h4 class="margin-bottom-10"><i><?php _se('HTML code'); ?></i></h4>
			<div class="input-label margin-bottom-0">
				<textarea id="pup-insert-code" data-focus="select-all" class="code code--snippet code--inline-auto" autocomplete="off" spellcheck="false" readonly><?php echo safe_html(Handler::var('plugin')['tagCode']); ?></textarea>
				<button type="button" class="input-action" data-action="copy" data-action-target="#pup-insert-code"><i class="far fa-copy"></i> <?php _se('copy'); ?></button>
			</div>
			<div class="margin-bottom-40">
				<h3><?php _se('Advanced options'); ?></h3>
				<p><?php _se('The plugin has a large set of additional options that allow full customization. You can use custom HTML, CSS, own color palette, set observers and more. Check the %d and the plugin source to get a better idea of these advanced options.', ['%d' => '<a rel="external" href="https://chevereto.com/go/v4pup" target="_blank">' . _s('documentation') . '</a>']); ?></p>
			</div>
		</div>
	</div>
</div>
<?php require_theme_footer(); ?>
<script>
document.addEventListener("DOMContentLoaded", function(event) {
	var $pluginButton = $("#pup-preview");
	var tagAttrs = <?php echo json_encode(Handler::var('plugin')['tagAttrs']); ?>;
	var el = document.createElement("script");
	for(var key in tagAttrs) {
		el.setAttribute(key, tagAttrs[key]);
	}
	$(document).on("keyup change", "[data-content=pup-options] *:input", function(e) {
		var attr = 'data-' + $(this).attr("name");
		var val = $(this).val();
		if(val) {
			el.setAttribute(attr, val);
		} else {
			el.removeAttribute(attr);
		}
		$("#pup-insert-code").val(el.outerHTML.replace('=""', '')).highlight();
	});
	$(document).on("change", "#palette", function(e) {
		var val = $(this).val() || "default";
		$pluginButton.removeClass(function(i, className) {
			return (className.match (/(^|\s)chevereto-pup-button--palette-\S+/g) || []).join(' ');
		}).addClass('chevereto-pup-button--palette-' + val);
	});
});
</script>
