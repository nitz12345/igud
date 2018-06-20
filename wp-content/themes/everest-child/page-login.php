<?php
/**
 * Created by PhpStorm.
 * User: amitmatat
 * Date: 27/03/2018
 * Time: 21:25
 */
// Template Name: Login form

if(isset($_COOKIE['userRegisteredID']) && wp_verify_nonce( $_COOKIE['theNonce'], 'login_user' )){
	$user_id = unserialize(stripslashes($_COOKIE['userRegisteredID']));
	wp_set_auth_cookie( $user_id );
	setcookie('userRegisteredID', null, -1, '/');
	setcookie('theNonce', null, -1, '/');
	wp_safe_redirect(get_permalink( get_user_meta( $user_id, 'companyId', true ) ));
}

get_header();
?>
    <div class="uk-grid uk-grid-collapse">
        <form action="" class="login_form">
            <!-- customer details -->
            <div class="uk-width-3-4">
                <div class="main-area">
                    <h1>פרטי התחברות</h1>
                    <div class="uk-form-row">
                        <div class="uk-grid uk-grid-small" data-uk-grid-margin="">
                            <div class="uk-width-medium-1-3">
                                <label class="uk-form-label">שם משתמש (אימייל)</label>
                                <div class="uk-form-controls">
                                        <input type="text" class="mandatory" name="username">
                                </div>
                            </div>
                            <div class="uk-width-medium-1-3">
                                <label class="uk-form-label">סיסמה</label>
                                <div class="uk-form-controls">
                                    <input type="password" class="mandatory" name="password">
                                </div>
                            </div>
														<div class="uk-width-medium-1-3">
															<div class="error hidden"></div>
														</div>
														<a href="<?php echo wp_lostpassword_url(); ?>" title="שכחתי סיסמה">שכחתי סיסמה</a>
                            <button type="submit">התחברות</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
<?php
get_footer();