<?php
use function Chevereto\Legacy\G\require_theme_file;

// @phpstan-ignore-next-line
if (!defined('ACCESS') || !ACCESS) {
    die('This file cannot be directly accessed.');
} ?>

<div data-modal="new-sub-album" class="hidden" data-is-xhr data-submit-fn="CHV.fn.submit_create_album" data-ajax-deferred="CHV.fn.complete_create_album">
    <h1><i class="fas fa-folder-tree"></i> <?php _se('Create %s', _s('sub %s', _n('album', 'albums', 1))); ?></h1>
	<div class="modal-form">
	<?php require_theme_file("snippets/form_sub_album.php", ['album-switch' => false]); ?>
	</div>
</div>
