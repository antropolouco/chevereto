<?php
use Chevereto\Legacy\Classes\Login;
use function Chevereto\Legacy\G\get_base_url;

// @phpstan-ignore-next-line
if (!defined('ACCESS') || !ACCESS) {
    die('This file cannot be directly accessed.');
}
$providersEnabled = Login::getProviders('enabled');
if (count($providersEnabled) > 0) {
    ?>
    <div class="margin-top-30 margin-bottom-30">
        <div class="or-separator"></div>
    </div>
    <div class="content-section"><?php _se('Sign in with another account'); ?></div>
    <div class="content-section social-icons">
<?php

    $tpl = '<a class="login-provider-button login-provider-button--%s" href="%u"><span class="icon fab fa-%s"> </span><span class="text">' . _s('Sign in with %label%') . '</span></a>';
    foreach ($providersEnabled as $name => $provider) {
        echo strtr($tpl, [
                    '%s' => $name,
                    '%label%' => $provider['label'],
                    '%u' => get_base_url('connect/' . $name),
                ]);
    } ?>
    </div>
<?php
}
?>
