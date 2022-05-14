<?php
/**
 * Displays the site header.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since 1.0.0
 */

$wrapper_classes  = 'site-header';
$wrapper_classes .= has_custom_logo() ? ' has-logo' : '';
$wrapper_classes .= true === get_theme_mod( 'display_title_and_tagline', true ) ? ' has-title-and-tagline' : '';
$wrapper_classes .= has_nav_menu( 'primary' ) ? ' has-menu' : '';
$freeassoStats = Freeasso_Api_Stats::getFactory();
?>

<header id="masthead" class="<?php echo esc_attr( $wrapper_classes ); ?>" role="banner">

	<?php get_template_part( 'template-parts/header/site-branding' ); ?>
	<?php get_template_part( 'template-parts/header/site-nav' ); ?>
	Kalaweit a déjà <?php echo $freeassoStats->getAmis(); ?> amis
	Kalaweit soigne <?php do_shortcode('[FreeAsso_Gibbons]', '00'); ?> Gibbons
	<?php do_shortcode('[FreeAsso_Hectares]', '00'); ?> hectares de forêt protégés


	<?php do_shortcode('[FreeAsso_Causes]', '00'); ?>
</header><!-- #masthead -->
