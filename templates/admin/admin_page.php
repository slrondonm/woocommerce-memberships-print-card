<?php if(!defined('ABSPATH')) { die('You are not allowed to call this page directly.'); } ?>
<div class="wrap">
  <h2>
    <?php _e('Printable Membership Cards - Options', WMPC_SLUG); ?>
  </h2>
  <br/>
  <form action="" method="post">
    
  <label for="wmpc-registered-label"><?php _e('Registered Label Text', WMPC_SLUG); ?></label><br/>
    <small>
      <?php _e('Leave blank to disable this from showing on the card.', WMPC_SLUG); ?>
    </small><br/>
    
    <input type="text" name="wmpc-registered-label" id="wmpc-registered-label" value="<?php echo $options['registered_label']; ?>" /><br/><br/>
    
    <label for="wmpc-memberships-label"><?php _e('Membership(s) Label Text', WMPC_SLUG); ?></label><br/>
    
    <small>
      <?php _e('Leave blank to disable this from showing on the card.', WMPC_SLUG); ?>
    </small><br/>
    
    <input type="text" name="wmpc-memberships-label" id="wmpc-memberships-label" value="<?php echo $options['memberships_label']; ?>" /><br/><br/>
    
    <label for="wmpc-renews-expires-label"><?php _e('Renews/Expires Label Text', WMPC_SLUG); ?></label><br/>
    
    <small>
      <?php _e('Leave blank to disable this from showing on the card.', WMPC_SLUG); ?>
    </small><br/>
    
    <input type="text" name="wmpc-renews-expires-label" id="wmpc-renews-expires-label" value="<?php echo $options['renews_expires_label']; ?>" /><br/><br/>
    
    <label for="wmpc-membership-number-label"><?php _e('Membership # Label Text', WMPC_SLUG); ?></label><br/>
    
    <small>
      <?php _e('Leave blank to disable this from showing on the card.', WMPC_SLUG); ?>
    </small><br/>
    
    <input type="text" name="wmpc-membership-number-label" id="wmpc-membership-number-label" value="<?php echo $options['membership_number_label']; ?>" /><br/><br/>
    
    <label for="wmpc-membership-number-prefix"><?php _e('Membership # Prefix', WMPC_SLUG); ?></label><br/>
    
    <small>
      <?php _e('Add a prefix in front of the members WordPress User ID. So for example, if your prefix is M-NUM- and the members ID was 97 then their full member number would be M-NUM-97.', WMPC_SLUG); ?>
    </small><br/>
    
    <input type="text" name="wmpc-membership-number-prefix" id="wmpc-membership-number-prefix" value="<?php echo $options['membership_number_prefix']; ?>" /><br/><br/>
    
    <label for="wmpc-background-img-url"><?php _e('Background Image URL', WMPC_SLUG); ?></label><br/>
    
    <small>
      <?php _e('Leave blank for no background image. Otherwise a 150x150 pixels image works best.', WMPC_SLUG); ?>
    </small><br/>
    
    <input type="text" name="wmpc-background-img-url" id="wmpc-background-img-url" value="<?php echo $options['membership_background_img_url']; ?>" style="width:60%;min-width:350px;" /><br/><br/>
    
    <input type="checkbox" name="wmpc-show-site-title" id="wmpc-show-site-title" <?php checked($options['show_site_title']); ?> />
    
    <label for="wmpc-show-site-title"><?php _e('Display Site Title at top of card', WMPC_SLUG); ?></label><br/>
    
    <small>
      <?php _e('If your site title is long, it may not fit on the card very well. So consider turning this off, and using the background image as your site branding on the card instead.', WMPC_SLUG); ?>
    </small><br/><br/>
    
    <input type="submit" name="wmpc-admin-page-submit" class="button button-primary" value="<?php _e('Save Options', WMPC_SLUG); ?>" />
  </form>
</div>