<?php

class lkar_shortcode {
    public function __construct() {
       add_shortcode('lkar_password_protector_form' , array( $this, 'password_protector_form' ));
    }

    public function password_protector_form() {
        $form = new lkar_password_form();
        return $form->render();
    }
}