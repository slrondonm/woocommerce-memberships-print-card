<?php

/**
 * 
 * 
 */

use WMPC\WMPC;

global $current_user;

$user = wp_get_current_user();

$user_id = get_current_user_id();

if (!function_exists('wc_memberships')) {
    return;
}

$args = array(
    'status' => array('active'),
);

$memberships = wc_memberships_get_user_membership($user_id);

$plans = wc_memberships_get_membership_plans();

// $current_plan = $memberships->get_plan();

// if ($current_plan && $current_plan->is_access_length_type( 'fixed' ) && date( 'Y' ) !== get_post_meta( $current_plan->get_id(), '_dates_last_bumped', true )) {
//     $current_end_date   = $current_plan->get_access_end_date( 'timestamp' );
//     $current_plan_name = $current_plan->get_name();
// }

foreach ($plans as $plan) {
    $plan_name = $plan->name;
}

if (!empty($memberships)) {
    foreach ($memberships as $member) {
        $expire_date = $member->get_end_date();
    }
}


$options = WMPC::get_options();

$site_title       = stripslashes(get_option('blogname'));

$name = $heading  =  ($user->first_name . $user->last_name) ? WMPC::get_member_name($user) : _e('No hay nombre para mostrar');

$register = date_i18n(get_option('date_format'), strtotime($user->user_registered), true);

$registered = $register;

$expires = $expire_date;

$membership_title = $plan_name;

$number           = (!empty($options['membership_number_label'])) ? $options['membership_number_prefix'] . $user : '';

if ($options['show_site_title']) {
    $heading = "{$site_title} - {$name}";
}

if ($is_shortcode) {
    ob_start();
}

//Printing the bg image is a royal PITA - https://ungapped.com/support/user-manuals/other/print-with-bg-image-and-bg-color/

do_action('wc_memberships_before_members_area', 'welcome');
?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap');

body {
    background: transparent;
}

.wmpc-membership-card-area {
    font-family: 'Oswald', sans-serif;
    color: #ffffff;
    width:380px;
    min-height:250px;
    background-image: url(<?php echo $options['membership_background_img_url']; ?>);
    background-position: center center;
    background-repeat: no-repeat;
    background-size: cover;
    border:1px solid lightgrey;
    border-radius:10px;
    padding-left:20px;
    margin:10px;
    position:relative;
}

.wmpc-membership-card-area h3 {
    font-family: 'Oswald', sans-serif;
    font-size: 18px;
    font-weight: 500;
    text-transform: uppercase;
    color: #ffffff;
    margin-bottom:2px;
    margin-top: 100px
}

.wmpc-membership-card-area p {
    font-family: 'Oswald', sans-serif;
    font-size: 14px;
    text-align:left;
    text-transform: uppercase;
    padding:0;
    margin-bottom:3px;
    line-height:1.2;
}

p.plan {
    font-size: 15px;
    font-weight: 400;
    text-transform: uppercase;
    border-top:1px solid lightgrey;
    margin-top: -3px;
}

p.expire-date {
    font-size: 12px;
    font-weight: 300;
    text-align: right !important;
    text-transform: uppercase;
    margin-top: 3px;
    margin-right: 15px;
    padding:0;
    line-height:1;
}
p.expire-date b {
    font-size: 10px !important;
    font-weight: 400;
}

.mt-25 {
    margin-top: 25px !important;
}
</style>
<p style="text-align:left;padding:0;margin:0;line-height:1;">
    <a href="#" class="print-click rb_button simple small">Imprimir Carnet</a>
</p><br />

Gracias por adquirir nuestros servicios. Este carnet es personal e intransferible <br>
<small>
    Si el "Botón de impresión" no funciona, intente imprimir desde su navegador. <br>
    Use CTRL + P en Windows o Comando + P en una Mac.<br>
</small><br /><br />

<div class="wmpc-membership-card-area">

    <h3><?php echo $heading; ?></h3>
    <p class="plan"><?php echo $membership_title; ?></p>

    <p class="mt-25 mb">
        <small><?php echo $options['registered_label']; ?></small><br>
        <?php print_r($registered); ?>
    </p>

    <p class="expire-date"><b><?php echo $options['renews_expires_label']; ?></b> <?php echo $expires; ?></p>

    <p><b><?php echo $options['membership_number_label']; ?></b> <?php echo $number; ?></p>
</div>

<?php if (!wp_script_is('jquery', 'enqueued')) : ?>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<?php endif; ?>

<script src="<?php echo WMPC_SCRIPTS_URL . '/js/printThis.js'; ?>"></script>
<script src="<?php echo WMPC_SCRIPTS_URL . '/js/html2canvas.min.js'; ?>"></script>

<script type="text/javascript">
    (function($) {
        $(document).ready(function() {
            // HTML2Canvas
            html2canvas(document.querySelector("div.wmpc-membership-card-area")).then(canvas => {
                document.body.appendChild(canvas).classList.add("canvas");
            });

            // PrintThis button
            $('body').on('click', '.print-click', function(e) {
                e.preventDefault();
                $(".canvas").printThis({
                    importCSS: true, // import page CSS
                    importStyle: true, // import style tags
                    printContainer: true, // grab outer container as well as the contents of the selector
                    removeInline: false, // remove all inline styles from print elements
                    printDelay: 500, // variable print delay; depending on complexity a higher value may be necessary
                    canvas: true, //Allow printing canvas
                });
            });

            // Hide original DIV
            // $("div.wmpc-membership-card-area").hide();
        });
    })(jQuery);
</script>

<?php
do_action('wc_memberships_after_members_area', 'welcome');
?>