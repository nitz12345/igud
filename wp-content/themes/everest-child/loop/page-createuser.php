<?php
/**
 * Template Name: new user
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

$fields       = $_POST['fields'];
$user_name    = $fields['name']['value'];
$user_email   = $fields['email']['value'];
$company_name = $fields['field_1']['value'];
$password     = $fields['password']['value'];
$user_id      = username_exists( $user_email );
if ( ! $user_id and email_exists( $user_email ) == false ) {
	$user_id         = wp_create_user( $user_email, $password, $user_email );
	echo $user_id;
	wp_update_user( array( 'ID' => $user_id, 'role' => 'editor' ) );
	$post_data = array(
		'post_title'  => $company_name,
		'post_type'   => 'companies',
		'post_status' => 'pending',
		'post_author' => $user_id,
	);
	$post_id   = wp_insert_post( $post_data );
	update_field( 'company_user', $user_id, $post_id );
	update_user_meta($user_id,'companyId',$post_id);

	$to = get_option('admin_email');
	$subject = 'נרשם חדש באתר';
	$body = 'The email body content';
	$headers = array('Content-Type: text/html; charset=UTF-8');

	wp_mail( $to, $subject, $body, $headers );
} else {
	$random_password = __( 'User already exists.  Password inherited.' );
}

