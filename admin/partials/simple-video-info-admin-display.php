<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Simple_Video_Info
 * @subpackage Simple_Video_Info/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
    <h2>Simple Video Info Settings</h2>
    <form action="options.php" method="post">
        <?php settings_fields('plugin_options'); ?>
        <?php do_settings_sections('plugin'); ?>
        <input name="Submit" type="submit" value="<?php esc_attr_e('Save Key'); ?>" />
    </form>

    <br />
    <hr />

    <h3>FAQ</h3>
    <p>Wondering how to get your YouTube Data API Key? <a href="https://developers.google.com/youtube/v3/getting-started" title="">Here's how</a>.</p>

    <br />
    <hr />
    
    <h3>Shortcode Usage:</h3>
    <p><code>[simplevideoinfo platform="{platform (vimeo or youtube)}" videoid="{your video ID}" getinfo="{the type of info you want to get}"]</code></p>

    <br />
    <hr />

    <h3>Available Parameters</h3>
    <p><strong>platform:</strong></p>
    <ul>
        <li>youtube - For a video hosted on YouTube</li>
        <li>vimeo - For a video hosted on Vimeo</li>
    </ul>
    <p><strong>videoid:</strong></p>
    <ul>
        <li>The ID of your video</li>
    </ul>
    <p><strong>getinfo:</strong></p>
    <ul>
        <li>comments - Number of comments on the video</li>
        <li>description - The description of the video</li>
        <li>duration - The duration of the video</li>
        <li>likes - The number of likes on the video</li>
        <li>link - The URL of the video</li>
        <li>published - The publish date for the video</li>
        <li>tags - A comma seperated list of tags for the video</li>
        <li>title - The title of the video</li>
        <li>thumbnail-small - The small thumbnail image for the video</li>
        <li>thumbnail-medium - The medium thumbnail image for the video</li>
        <li>thumbnail-large - The large thumbnail image for the video</li>
        <li>views - The number of plays for the video</li>
    </ul>

</div>
