<?php

class lkar_password_form{
    public function render() {
        ob_start();
        ?>
        <form method="post" class="lkar-password-form" id="lkar-password-form">
            <label for="lkar_password_id">Enter Password:</label>

            <div class="lkar-password-wrapper">  
                <input type="password" id="lkar_password_id" name="lkar_password_id" required autocomplete="current-password">
                <button type="button" id="lkar-password-toggle">
                 <span class="dashicons dashicons-visibility" aria-hidden="true"></span>
                </button>
            </div>

            <input id="lkar-password-submit" type="submit" value="Submit">
        </form>
        <?php
        return ob_get_clean();
    }
}
