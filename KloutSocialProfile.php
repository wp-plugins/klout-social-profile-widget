<?php
/*
Plugin Name: Klout Social Profile Widget
Plugin URI: http://www.darrensim.com/plugins
Description: Klout Social Profile Widget displays your Klout score together with you social media profiles (Facebook, Twitter, LinkedIn, etc) on your Wordpress Sidebar.
Author: Darren Sim
Version: 1.0.0 Beta
Author URI: http://www.darrensim.com/
*/
 
 
class KloutSocialProfileWidget extends WP_Widget
{
  function KloutSocialProfileWidget()
  {
    $widget_ops = array('classname' => 'KloutSocialProfile', 'description' => 'Displays your Klout score together with you social media profiles.' );
    $this->WP_Widget('KloutSocialProfileWidget', 'Klout Social Profile Widget', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ), array( 'description' => '' ), 
    							array( 'kloutId' => '' ), array( 'profileAvatarURL' => ''), 
    							array( 'customHTML' => '' ), array( 'wordpress' => '' ),
    							array( 'facebook' => '' ), array( 'twitter' => '' ), 
    							array( 'linkedin' => '' ), array( 'skype' => '' ), 
    							array( 'youtube' => '' ));
    							
    $title = $instance['title'];
    $kloutId = $instance['kloutId'];
    $description = $instance['description'];
    $profileAvatarURL = $instance['profileAvatarURL'];
    $customHTML = $instance['customHTML'];
    $wordpress = $instance['wordpress'];
    $facebook = $instance['facebook'];
    $twitter = $instance['twitter'];
    $linkedin = $instance['linkedin'];
    $skype = $instance['skype'];
    $youtube = $instance['youtube'];
    
?>
	<p>
		<label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label>
		<label for="<?php echo $this->get_field_id('description'); ?>">Description: <input class="widefat" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>" type="text" value="<?php echo attribute_escape($description); ?>" /></label>
		<label for="<?php echo $this->get_field_id('kloutId'); ?>">Klout ID: (<a href='http://www.darrensim.com/plugins' target='_blank'>What is my Klout ID</a>)<input class="widefat" id="<?php echo $this->get_field_id('kloutId'); ?>" name="<?php echo $this->get_field_name('kloutId'); ?>" type="text" value="<?php echo attribute_escape($kloutId); ?>" /></label>
		<label for="<?php echo $this->get_field_id('profileAvatarURL'); ?>">Profile Image URL: <input class="widefat" id="<?php echo $this->get_field_id('profileAvatarURL'); ?>" name="<?php echo $this->get_field_name('profileAvatarURL'); ?>" type="text" value="<?php echo attribute_escape($profileAvatarURL); ?>" /></label>
		
		<label for="<?php echo $this->get_field_id('wordpress'); ?>">Blog URL: <input class="widefat" id="<?php echo $this->get_field_id('wordpress'); ?>" name="<?php echo $this->get_field_name('wordpress'); ?>" type="text" value="<?php echo attribute_escape($wordpress); ?>" /></label>
		<label for="<?php echo $this->get_field_id('facebook'); ?>">Facebook URL: <input class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" type="text" value="<?php echo attribute_escape($facebook); ?>" /></label>
		<label for="<?php echo $this->get_field_id('twitter'); ?>">Twitter URL: <input class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" type="text" value="<?php echo attribute_escape($twitter); ?>" /></label>
		<label for="<?php echo $this->get_field_id('linkedin'); ?>">LinkedIn URL: <input class="widefat" id="<?php echo $this->get_field_id('linkedin'); ?>" name="<?php echo $this->get_field_name('linkedin'); ?>" type="text" value="<?php echo attribute_escape($linkedin); ?>" /></label>
		<label for="<?php echo $this->get_field_id('youtube'); ?>">YouTube URL: <input class="widefat" id="<?php echo $this->get_field_id('youtube'); ?>" name="<?php echo $this->get_field_name('youtube'); ?>" type="text" value="<?php echo attribute_escape($youtube); ?>" /></label>
		<label for="<?php echo $this->get_field_id('skype'); ?>">Skype URL: <input class="widefat" id="<?php echo $this->get_field_id('skype'); ?>" name="<?php echo $this->get_field_name('skype'); ?>" type="text" value="<?php echo attribute_escape($skype); ?>" /></label>
		
		<label for="<?php echo $this->get_field_id('customHTML'); ?>">Custom HTML: (appears at the end)<input class="widefat" id="<?php echo $this->get_field_id('customHTML'); ?>" name="<?php echo $this->get_field_name('customHTML'); ?>" type="text" value="<?php echo attribute_escape($customHTML); ?>" /></label>
		
	</p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    $instance['kloutId'] = $new_instance['kloutId'];
    $instance['description'] = $new_instance['description'];
    $instance['profileAvatarURL'] = $new_instance['profileAvatarURL'];
    $instance['customHTML'] = $new_instance['customHTML'];
    $instance['wordpress'] = $new_instance['wordpress'];
    $instance['facebook'] = $new_instance['facebook'];
    $instance['twitter'] = $new_instance['twitter'];
    $instance['linkedin'] = $new_instance['linkedin'];
    $instance['skype'] = $new_instance['skype'];
    $instance['youtube'] = $new_instance['youtube'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    //echo $before_widget;
    
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);

 	$description = empty($instance['description']) ? '' : $instance['description'];

	$profileAvatarURL = empty($instance['profileAvatarURL']) ? '' : $instance['profileAvatarURL'];
		
	$customHTML = empty($instance['customHTML']) ? '' : '<br/>'.$instance['customHTML'];

 	$kloutId = $instance['kloutId'];
	$kloutScore = 'N/A';
 	
 	
 	if(!empty($kloutId))
 	{
 		$opts = array(
		  'http'=>array(
			'method'=>"GET",
			'header'=>"Accept-language: en\r\n" .
					  "Cookie: foo=bar\r\n"
		  )
		);
		
		$context = stream_context_create($opts);
		
		$url_getKloutScore = 'http://darrensim.com/KloutService.php?kloutId=' . $kloutId;
		
		$kloutScore = @file_get_contents($url_getKloutScore, false, $context);
		
		if(!empty($kloutScore))
		{
			$kloutScore = Round($kloutScore);
		}
		else
		{
			$kloutScore = 'N/A';
		}
 	}
 	
 
    echo '<div id="kloutSocialContainer" style="width: 100%; position: absolute;">';
    echo '<div id="kloutSocialAvatar" style="width: 75px; height: 75px; background-color: #999; position: absolute; top: 5px; left: 5px; z-index: 10; border: 1px solid #CCC; box-shadow: 3px 3px 3px #CCC;">';
    echo '<img src="' . $profileAvatarURL . '" style="width: 75px; height: 75px; " />';
    echo '</div>';
    echo "<div id='kloutSocialTitle' style='font-family: Arial, Helvetica, sans-serif; font-size: 24px; color: #666; position: absolute; top: 5px; left: 90px; line-height:normal;'>";
    echo $title;
    echo '</div>';
    echo "<div id='kloutSocialKloutScore' style='font-family: Georgia, Times, serif; font-size: 14px; color: #fff; background-image: url(http://www.darrensim.com/wp-content/plugins/KloutSocialProfile/images/klout.png); background-repeat: no-repeat; background-size: 100%; position: absolute; top: 65px; left: 50px; width: 40px; height: 30px; z-index: 11; text-align: center; padding-top: 5px; padding-left: 2px;'>";
    echo $kloutScore;
    echo '</div>';
    echo '<div id="kloutSocialKloutSocialProfiles" style="position: absolute; top: 70px; left: 100px;">';

    echo empty($instance['wordpress']) ? '' : '<a href="'. $instance['wordpress'] .'"><img src="http://www.darrensim.com/wp-content/plugins/KloutSocialProfile/images/wordpress.png" border="0" /></a>&nbsp;';
    echo empty($instance['facebook']) ? '' : '<a href="'. $instance['facebook'] .'"><img src="http://www.darrensim.com/wp-content/plugins/KloutSocialProfile/images/facebook.png" border="0" /></a>&nbsp;';
    echo empty($instance['twitter']) ? '' : '<a href="'. $instance['twitter'] .'"><img src="http://www.darrensim.com/wp-content/plugins/KloutSocialProfile/images/twitter.png" border="0" /></a>&nbsp;';
    echo empty($instance['linkedin']) ? '' : '<a href="'. $instance['linkedin'] .'"><img src="http://www.darrensim.com/wp-content/plugins/KloutSocialProfile/images/linkedin.png" border="0" /></a>&nbsp;';
    echo empty($instance['youtube']) ? '' : '<a href="'. $instance['youtube'] .'"><img src="http://www.darrensim.com/wp-content/plugins/KloutSocialProfile/images/youtube.png" border="0" /></a>&nbsp;';
    echo empty($instance['skype']) ? '' : '<a href="'. $instance['skype'] .'"><img src="http://www.darrensim.com/wp-content/plugins/KloutSocialProfile/images/skype.png" border="0" /></a>&nbsp;';
    echo '</div>';
    echo '<div id="kloutSocialKloutDescription" style="font-family: Arial, Helvetica, sans-serif; font-size: 10px; color: #333; position: absolute;	top: 105px; left: 5px; width: 95%;">';
    echo $description; 
 	echo $customHTML;
    echo '</div>';
    echo '</div>';
 
    echo $after_widget;
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("KloutSocialProfileWidget");') );?>