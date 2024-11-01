<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Simple_Video_Info
 * @subpackage Simple_Video_Info/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Simple_Video_Info
 * @subpackage Simple_Video_Info/public
 * @author     Your Name <email@example.com>
 * @author     Jason Pollock <jason@studioaceofspade.com>
 */
class Simple_Video_Info_Public {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Simple_Video_Info_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Simple_Video_Info_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/simple-video-info-public.css', array(), $this->version, 'all' );

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Simple_Video_Info_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Simple_Video_Info_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/simple-video-info-public.js', array( 'jquery' ), $this->version, false );

    }
    
    /**
     * Register the shortcodes for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function plugin_add_shortcodes() {
        function simplevideoinfo_shortcodes($atts) {
            $options = get_option('plugin_options');
            $a = shortcode_atts( array(
                // TODO: Allow for a comma delineated string of type 'getinfo' to reduce number of HTTP requests for a single video ID
                'platform' => '', // youtube or vimeo
                'videoid' => '', // the ID for the video
                'getinfo' => 'views' // views or comments or thumbnail or whatever other type of stuff we can get from the api
            ), $atts );

            switch ($a['getinfo']) {
            case "comments" :
                $youtube_params = array("fields=items(statistics(commentCount))&part=statistics", array("items", 0, "statistics", "commentCount"), "comments");
                $vimeo_params = array("stats_number_of_comments", "comments");
                break;
            case "description" :
                $youtube_params = array("fields=items(snippet(description))&part=snippet", array("items", 0, "snippet", "description"), "description");
                $vimeo_params = array("description", "description");
                break;
            case "duration" :
                $youtube_params = array("fields=items(contentDetails(duration))&part=contentDetails", array("items", 0, "contentDetails", "duration"), "duration");
                $vimeo_params = array("duration", "duration");
                break;
            case "likes" :
                $youtube_params = array("fields=items(statistics(likeCount))&part=statistics", array("items", 0, "statistics", "likeCount"), "likes");
                $vimeo_params = array("stats_number_of_likes", "likes");
                break;
            case "link" :
                $youtube_params = array("fields=items(id)&part=statistics", array("items", 0, "id"), "link");
                $vimeo_params = array("id", "link");
                break;
            case "published" :
                $youtube_params = array("fields=items(snippet(publishedAt))&part=snippet", array("items", 0, "snippet", "publishedAt"), "published");
                $vimeo_params = array("upload_date", "published");
                break;
            case "tags" :
                $youtube_params = array("fields=items(snippet(tags))&part=snippet", array("items", 0, "snippet", "tags"), "tags");
                $vimeo_params = array("tags", "tags");
                break;
            case "title" :
                $youtube_params = array("fields=items(snippet(title))&part=snippet", array("items", 0, "snippet", "title"), "title");
                $vimeo_params = array("title", "title");
                break;
            case "thumbnail-small" :
                $youtube_params = array("fields=items(snippet(thumbnails))&part=snippet", array("items", 0, "snippet", "thumbnails"), "thumbnail-small");
                $vimeo_params = array("thumbnail_small", "thumbnail-small");
                break;
            case "thumbnail-medium" :
                $youtube_params = array("fields=items(snippet(thumbnails))&part=snippet", array("items", 0, "snippet", "thumbnails"), "thumbnail-medium");
                $vimeo_params = array("thumbnail_medium", "thumbnail-medium");
                break;
            case "thumbnail-large" :
                $youtube_params = array("fields=items(snippet(thumbnails))&part=snippet", array("items", 0, "snippet", "thumbnails"), "thumbnail-large");
                $vimeo_params = array("thumbnail_large", "thumbnail-large");
                break;
            case "views" :
                $youtube_params = array("fields=items(statistics(viewCount))&part=statistics", array("items", 0, "statistics", "viewCount"), "views");
                $vimeo_params = array("stats_number_of_plays", "views");
                break;
            }

            if($a['platform'] == 'youtube') {
                // Ping google api to get the video object
                $json_output = file_get_contents("https://www.googleapis.com/youtube/v3/videos?id={$a['videoid']}&key={$options['text_string']}&{$youtube_params[0]}");
                $json = json_decode($json_output, true);
                // Sometimes we need to go 3 levels deep, other times 4
                if(count($youtube_params[1]) == 3) {
                    $video_info = $json[$youtube_params[1][0]][$youtube_params[1][1]][$youtube_params[1][2]];
                } elseif(count($youtube_params[1]) == 4) {
                    $video_info = $json[$youtube_params[1][0]][$youtube_params[1][1]][$youtube_params[1][2]][$youtube_params[1][3]];
                } else {
                    // We may want to add additional levels to this at some point, but not right now.
                }

                // var_dump($video_info);
                // var_dump($youtube_params);

                switch($youtube_params[2]) { // handle any further processing before returning
                case "comments" :
                    return number_format($video_info);
                    break;
                case "duration" :
                    // YouTube API provides date in ISO8601 format. Must convert!
                    $di = new DateInterval($video_info); 
                    $string = '';
                    if($di->h > 0)
                    $string .= $di->h.':';
                    return $string.$di->i.':'.$di->s;
                    break;
                case "likes" :
                    return number_format($video_info);
                    break;
                case "link" :
                    return "https://www.youtube.com/watch?v=".$video_info;
                    break;
                case "published" :
                    // Make readable by humans
                    // TODO: Provide options for other date formats
                    $dateObject = new DateTime($video_info);
                    $video_date = date_format($dateObject , 'F jS, Y'); 
                    return $video_date;
                    break;
                case "tags" :
                    // Tags is an array so let's convert it to a string
                    $tags = implode(", ", $video_info);
                    return $tags;
                    break;
                case "thumbnail-small" :
                    return $video_info['default']['url'];
                    break;
                case "thumbnail-medium" :
                    return $video_info['medium']['url'];
                    break;
                case "thumbnail-large" :
                    return $video_info['high']['url'];
                    break;
                case "views" :
                    return number_format($video_info);
                    break;
                default :
                    // If all else fails we just need to return the string
                    return $video_info;
                }
            }
            elseif($a['platform'] == 'vimeo') {
                // Ping vimeo api to get info
                $curl = curl_init('vimeo.com/api/v2/video/'.$a['videoid'].'.json');
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                $return = curl_exec($curl);
                curl_close($curl);
                $video = json_decode($return);
                $video_info = $video[0]->$vimeo_params[0];

                switch($vimeo_params[1]) { // handle any further processing before returning
                case "comments" :
                    return number_format($video_info);
                    break;
                case "duration" :
                    // Make human readable
                    // TODO: Remove hour place when video less than an hour
                    return gmdate("H:i:s", $video_info);
                    break;
                case "likes" :
                    return number_format($video_info);
                    break;
                case "link" :
                    return "https://vimeo.com/".$video_info;
                    break;
                case "published" :
                    // Make human readable
                    // TODO: Provide options for other date formats
                    $dateObject = new DateTime($video_info);
                    $video_date = date_format($dateObject , 'F jS, Y'); 
                    return $video_date;
                    break;
                case "tags" :
                    return $video_info;
                    break;
                case "thumbnail-small" :
                    return $video_info;
                    break;
                case "thumbnail-medium" :
                    return $video_info;
                    break;
                case "thumbnail-large" :
                    return $video_info;
                    break;
                case "views" :
                    return number_format($video_info);
                    break;
                default :
                    // If all else fails
                    return $video_info;
                }

            }
            else { // This should not happen
                return;
            }

        }
        add_shortcode('simplevideoinfo', 'simplevideoinfo_shortcodes');
    }

}
