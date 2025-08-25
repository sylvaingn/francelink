<?php

const TEXT_DOMAIN = 'contentify';

define( "DEFAULT_POSTS_PER_PAGE", get_option( 'posts_per_page' ) );
define( "BLOG_PAGE_ID", get_option( 'page_for_posts' ) );

$contact_page = get_field( 'contact-page', 'options' );
define( "CONTACT_PAGE_ID", isset( $contact_page ) ? $contact_page : null );


/**
 * Retourne l’objet WP_Term “principal” selon Yoast, ou le premier terme en fallback.
 *
 * @param  string     $taxonomy Slug de la taxonomy.
 * @param  int|null   $post_id  ID du post (défaut = courant).
 * @return WP_Term|false
 */
function get_yoast_primary_term( string $taxonomy = 'category', ?int $post_id = null ) {
	$post_id = $post_id ?? get_the_ID();

	if ( class_exists( 'WPSEO_Primary_Term' ) ) {
		$primary = new WPSEO_Primary_Term( $taxonomy, $post_id );
		$term_id = $primary->get_primary_term();
		if ( $term_id && ! is_wp_error( $term_id ) ) {
			return get_term( $term_id, $taxonomy );
		}
	}

	$terms = get_the_terms( $post_id, $taxonomy );
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		return array_shift( $terms );
	}

	return false;
}
