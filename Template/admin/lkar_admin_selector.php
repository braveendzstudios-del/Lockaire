<?php

class lkar_admin_selector{
    
    public function render() {
       ob_start();

       // Ge saved options
        $saved_password = get_option('lkar_password_id', '');
        $saved_protection_page_id = get_option('lkar_protection_page_id', 0);
        $saved_page_id = get_option('lkar_page_id', 0);
        $saved_post_id = get_option('lkar_post_id', 0);
        
       ?>
         <div class="wrap">
           
         <h1>Lockaire Configuration</h1>
         <p>Use Shortcode [lkar_password_protector_form] to display the password 
          protection form on any page or post.</p>
           
         <div class="lkar-content-wrapper">

              <form method="post" action="lkar_save_settings" id="lkar-settings-form">
                <input type="hidden" name="lkar_action" value="save_settings">
                <?php wp_nonce_field( 'lkar_save_settings', 'lkar_nonce' ); ?>

                <!--#Password Field-->
                 <div class="lkar-password-field">
                  <label for='lkar_password'>Your Password</label>
                  <p>Add a password to protect your content.</p>
                  <input type='password'name='lkar_password' id='lkar_password_id' 
                   value='<?php echo esc_attr($saved_password); ?>' required>
                  <button type="button" id="lkar-show-password" class="button">Show Password</button>
                 </div>
                <!--#Password Field End-->
                 
                <!--#Password Page Selector-->
                 <div class="lkar-password-page-selector">
                  <label for="lkar_protection_page">Select Protection Page</label>
                  <p>If You don't have a password-protected page yet, 
                    create one using the [lkar_password_protector_form] shortcode.</p>
                  
                    <select name="lkar_protection_page" id="lkar_protection_page_id">
                       <!-- Default option -->
                      <option value="">--No Protection Page--</option>
                      <?php
                          $pages = get_pages(array('numberpages'=>-1));
                            foreach ( $pages as $page ) {

                            if (has_shortcode($page->post_content, 'lkar_password_protector_form')) {
                                  echo "<option value='" . esc_attr($page->ID) . "' " 
                                  . selected($saved_protection_page_id, $page->ID, false) . ">
                                  " . esc_html($page->post_title) . "</option>";
                            }

                        }
                      ?>
                    </select>
                 </div>
                <!--#Password Page Selector End-->

                <!--#Password Protected Page Selector-->

                 <div class="lkar-protection-page-to-protect-selector">

                     <label for="lkar_page_id">Select Page You Want To Protect  </label>
                      <p>Select a page from the list below to apply password protection.</p>
                      <select name="lkar_page_id" id="lkar_page_id">
                      
                        <!-- Default option -->
                        <option value="" >--No Page--</option>
                      
                        <?php
                        $pages = get_pages(array('numberpages'=>-1));
                          foreach ( $pages as $page ) {
                            if (!has_shortcode($page->post_content, 'lkar_password_protector_form')) {
                                

                                 echo "<option value='" . esc_attr($page->ID) . "' " 
                                 . selected($saved_page_id, $page->ID, false) . ">" . esc_html($page->post_title) . "</option>";

                            }
                        }

                      ?>

                      </select>

                 </div>
                <!--#Password Protected Page Selector End-->

                <!-- #Password Protected Post Selector -->
                  
                  <div class="lkar-protection-post-to-protect-selector">

                    <label for="lkar_post_id">Select Post You Want to Protect:</label>
                     <p>select a post from the list below to apply password protection.</p>
                    <select name="lkar_post_id" id="lkar_post_id">
                      
                       <!-- Default option -->
                       <option value="">-- No Post --</option>
                      
                      <?php
                      $posts = get_posts( array( 'numberposts' => -1 ) );
                      foreach ( $posts as $post ) {
                          if ( ! has_shortcode( $post->post_content, 'lkar_password_protector_form' ) ) {
                              echo "<option value='" . esc_attr($post->ID) . "' " 
                              . selected( $saved_post_id, $post->ID, false ) . "
                              >" . esc_html($post->post_title) ."</option>";
                          }
                      }
                      ?>
                    </select>

                  </div>

                <!-- #Password Protected Post Selector End -->
                 
                  
                <button type="submit"  id="lkar-save-btn" class="button button-primary">Save Settings</button>
              </form>


         </div>
             
       <?php

       return ob_get_clean();
    } 

}


