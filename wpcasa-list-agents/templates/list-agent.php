<?php
/**
 * Template: List Agent
 *
 * Available vars:
 *
 *	- object $user WP_User object
 *	- array	$args Array of Arguments
 */
?>

<div class="wpsight-list-agent-section">
	
	<?php do_action( 'wpsight_list_agent_before', $user->ID ); ?>

	<div class="wpsight-list-agent clearfix">
	
		<?php if( wpsight_get_agent_image( $user->ID ) && $args['show_image'] !== false ) : ?>

	    	<div class="wpsight-list-agent-image">
	    		<?php wpsight_agent_image( $user->ID, array( 150, 150 ) ); ?></span>
	    	</div><!-- .wpsight-list-agent-image -->

	    <?php endif; ?>
	    
	    <div class="wpsight-list-agent-info">

	        <div class="wpsight-list-agent-name">

	        	<?php wpsight_agent_name( $user->ID ); ?>

	        	<?php if( wpsight_get_agent_company( $user->ID ) ) : ?>
	        	<span class="wpsight-list-agent-company">(<?php wpsight_agent_company( $user->ID ); ?>)</span>
	        	<?php endif; ?>
	        	
	        	<?php if( wpsight_get_agent_phone( $user->ID ) && $args['show_phone'] !== false ) : ?>
	        	<span class="wpsight-list-agent-phone"><?php wpsight_agent_phone( $user->ID ); ?></span>
	        	<?php endif; ?>

	        </div>
	        
	        <?php if( $args['show_links'] !== false ) : ?>
	        
	        	<div class="wpsight-list-agent-links">
	        	
	        		<?php if( wpsight_get_agent_website( $user->ID ) ) : ?>
	        		<a href="<?php wpsight_agent_website( $user->ID ); ?>" class="agent-website" title="<?php echo esc_attr( wpsight_get_agent_website( $user->ID ) ); ?>" itemprop="url" target="_blank" rel="nofollow"><?php _e( 'Website', 'wpsight-list-agents' ); ?></a>
	        		<?php endif; ?>
	        		
	        		<?php if( wpsight_get_agent_twitter( $user->ID ) ) : ?>
	        		<a href="<?php wpsight_agent_twitter( $user->ID, 'url' ); ?>" class="agent-twitter" title="@<?php echo esc_attr( wpsight_get_agent_twitter( $user->ID ) ); ?>" target="_blank" rel="nofollow"><?php _e( 'Twitter', 'wpsight-list-agents' ); ?></a>
	        		<?php endif; ?>
	        		
	        		<?php if( wpsight_get_agent_facebook( $user->ID ) ) : ?>
	        		<a href="<?php wpsight_agent_facebook( $user->ID, 'url' ); ?>" class="agent-facebook" title="<?php echo esc_attr( wpsight_get_agent_facebook( $user->ID ) ); ?>" target="_blank" rel="nofollow"><?php _e( 'Facebook', 'wpsight-list-agents' ); ?></a>
	        		<?php endif; ?>
				
	        	</div>
	        
	        <?php endif; ?>

	        <div class="wpsight-list-agent-description" itemprop="description">
	        	<?php wpsight_agent_description( $user->ID ); ?>
	        </div>
	        
	        <?php if( wpsight_get_agent_archive( $user->ID ) && $args['show_archive'] !== false ) : ?>	        
	        <div class="wpsight-list-agent-archive">
	        	<a href="<?php wpsight_agent_archive( $user->ID ); ?>"><?php _e( 'My Listings', 'wpsight-list-agents' ); ?></a>
	        </div>
	        <?php endif; ?>
	    
	    </div><!-- .wpsight-list-agent-info -->
	    
	</div><!-- .wpsight-list-agent -->
	
	<?php do_action( 'wpsight_list_agent_after', $user->ID ); ?>

</div><!-- .wpsight-list-agent-section -->