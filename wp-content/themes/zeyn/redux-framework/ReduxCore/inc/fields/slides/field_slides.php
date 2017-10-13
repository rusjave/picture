<?php
/**
 * Redux Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Redux Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Redux Framework. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     ReduxFramework
 * @subpackage  Field_slides
 * @author      Luciano "WebCaos" Ubertini
 * @author      Daniel J Griffiths (Ghost1227)
 * @author      Dovy Paukstys
 * @version     3.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// Don't duplicate me!
if (!class_exists('DethemeReduxFramework_slides')) {

    /**
     * Main ReduxFramework_slides class
     *
     * @since       1.0.0
     */
    class DethemeReduxFramework_slides extends DethemeReduxFramework{

        /**
         * Field Constructor.
         *
         * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        function __construct( $field = array(), $value ='', $parent ) {
        
            $this->args=$parent->args;
            $this->parent = $parent;
            $this->field = $field;
            $this->value = $value;
        
        }

        /**
         * Field Render Function.
         *
         * Takes the vars and outputs the HTML for the field in the settings
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function render() {


            echo '<div class="redux-slides-accordion">';

            $x = 0;

            $multi = (isset($this->field['multi']) && $this->field['multi']) ? ' multiple="multiple"' : "";

           if (isset($this->value) && is_array($this->value)) {

                $slides = $this->value;

                foreach ($slides as $slide) {
                    
                    if ( empty( $slide ) ) {
                        continue;
                    }


                    $defaults = array(
                        'title' => '',
                        'description' => '',
                        'sort' => '',
                        'url' => '',
                        'image'=>'',
                        'thumb' => '',
                        'slideurl' => '',
                        'slidelabel' => '',
                        'attachment_id' => '',
                        'height' => '',
                        'width' => '',
                        'logothumb' => '',
                        'logourl' => '',
                        'logo_id' => '',
                        'direction'=>'from-left',
                        'logowidth'=>120,
                        'logoheight'=>120,
                        'logomove'=>'0','logomovemobile'=>'0',
                        'logodirection'=>'from-top',
                        'titledirection'=>'from-top',
                        'titlemove'=>'0','titlemovemobile'=>'0',
                        'contentmove'=>'0','contentmovemobile'=>'0',
                        'contentdirection'=>'from-top',
                        'buttonmove'=>'0','buttonmovemobile'=>'0',
                        'buttondirection'=>'from-top',
                        'select' => array(),
                    );

                    $slide = wp_parse_args( $slide, $defaults );

                    if (empty($slide['url']) && !empty($slide['attachment_id'])) {
                        $img = wp_get_attachment_image_src($slide['attachment_id'], 'full');
                        $slide['url'] = $img[0];
                        $slide['width'] = $img[1];
                        $slide['height'] = $img[2];
                    }

                    echo '<div class="redux-slides-accordion-group"><fieldset class="redux-field" data-id="'.$this->field['id'].'"><h3><span class="redux-slides-header">' . $slide['title'] . '</span></h3><div>';
                    echo '<ul id="' . $this->field['id'] . '-ul" class="redux-slides-list">';
                    echo '<li><label>'.__( 'Slide Title', 'redux-framework' ).'</label> <input type="text" id="' . $this->field['id'] . '-title_' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][title]" value="' . esc_attr($slide['title']) . '" class="full-text slide-title" />';
                    echo '<br/><br/>'.__( 'Animation', 'redux-framework' );
                    echo '<div><ul>
                <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-titledirection_'.$x.'_logo_left" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][titledirection]" value="from-top" '.checked($slide['titledirection'], 'from-top', false).'/>
                <span>From Top</span></li>
                <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-titledirection_'.$x.'_logo_right" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][titledirection]" value="from-bottom" '.checked($slide['titledirection'], 'from-bottom', false).'/>
                <span>From Bottom</span></li>
                <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-titledirection_'.$x.'_title_fade" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][titledirection]" value="fade" '.checked($slide['titledirection'], 'fade', false).'/>
                <span>Fade</span></li>
                </ul>
                </div>';

                    echo __( 'Vertical Position', 'redux-framework' ).' :<br/></br/>Desktop <input type="text" id="' . $this->field['id'] . '-title_move_' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][titlemove]" value="' . esc_attr($slide['titlemove']) . '" style="width:100px" class="value" /> px';
                    echo '<br/>Mobile&nbsp;&nbsp;&nbsp; <input type="text" id="' . $this->field['id'] . '-title_move_mobile' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][titlemovemobile]" value="' . esc_attr($slide['titlemovemobile']) . '" style="width:100px" class="value" /> px';
                    echo '</li>';
                    echo '<li><label>'.__( 'Slide Content', 'redux-framework' ).'</label> <textarea name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][description]" id="' . $this->field['id'] . '-description_' . $x . '" class="large-text" rows="6">' . esc_attr($slide['description']) . '</textarea>';
                    echo '<br/><br/>'.__( 'Animation', 'redux-framework' );
                    echo '<div><ul>
                    <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-contentdirection_'.$x.'_content_left" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][contentdirection]" value="from-top" '.checked($slide['contentdirection'], 'from-top', false).'/>
                <span>From Top</span></li>
                <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-contentdirection_'.$x.'_content_right" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][contentdirection]" value="from-bottom" '.checked($slide['contentdirection'], 'from-bottom', false).'/>
                <span>From Bottom</span></li>
                <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-contentdirection_'.$x.'_content_fade" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][contentdirection]" value="fade" '.checked($slide['contentdirection'], 'fade', false).'/>
                <span>Fade</span></li>
                </ul>
                </div>';

                    echo __( 'Vertical Position', 'redux-framework' ).' :<br/><br/>Desktop<input type="text" id="' . $this->field['id'] . '-content_move_' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][contentmove]" value="' . esc_attr($slide['contentmove']) . '" style="width:100px" class="value" /> px';
                    echo '<br/>Mobile&nbsp;&nbsp;&nbsp; <input type="text" id="' . $this->field['id'] . '-content_move_mobile' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][contentmovemobile]" value="' . esc_attr($slide['contentmovemobile']) . '" style="width:100px" class="value" /> px';

                    echo '</li>';
                    echo '<li><label>'.__( 'Button', 'redux-framework' ).'</label><br/>'.__( 'Button Label', 'redux-framework' ).'<br/><input type="text" id="' . $this->field['id'] . '-label_' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][slidelabel]" value="'.esc_attr($slide['slidelabel']).'" class="full-text" /></li>';
                    echo '<li>'.__( 'Button Link', 'redux-framework' ).' <input type="text" id="' . $this->field['id'] . '-url_' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][slideurl]" value="' . esc_attr($slide['slideurl']) . '" class="full-text"  />';
                    echo'<br/><br/>';
                    echo __( 'Animation', 'redux-framework' );
                    echo '<div><ul>
                <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-buttondirection_'.$x.'_button_left" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][buttondirection]" value="from-top" '.checked($slide['buttondirection'], 'from-top', false).'/>
                <span>From Top</span></li>
                <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-buttondirection_'.$x.'_button_right" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][buttondirection]" value="from-bottom" '.checked($slide['buttondirection'], 'from-bottom', false).'/>
                <span>From Bottom</span></li>
                <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-buttondirection_'.$x.'_button_fade" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][buttondirection]" value="fade" '.checked($slide['buttondirection'], 'fade', false).'/>
                <span>Fade</span></li>
                </ul>
                </div>';

                    echo __( 'Vertical Position', 'redux-framework' ).' :<br/><br/>Desktop <input type="text" id="' . $this->field['id'] . '-button_move_' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][buttonmove]" value="' . esc_attr($slide['buttonmove']) . '" style="width:100px" class="value" /> px';
                    echo '<br/>Mobile&nbsp;&nbsp;&nbsp; <input type="text" id="' . $this->field['id'] . '-button_move_mobile' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][buttonmovemobile]" value="' . esc_attr($slide['buttonmovemobile']) . '" style="width:100px" class="value" /> px';


                    echo '</li>';
                    echo '<li><label>'.__( 'Image', 'redux-framework' ).'</label>';

                    $hide = '';
                    if ( empty( $slide['logourl'] ) ) {
                        $hide = ' hide';
                    }

                    echo '<div class="logo-image"><div class="logoscreenshot' . $hide . '">';
                    echo '<a class="of-uploaded-image" href="' . $slide['logourl'] . '" target="_blank">';
                    echo '<img class="redux-slides-image" id="image_image_id_' . $x . '" src="' . $slide['logothumb'] . '" alt="" target="_blank" rel="external" />';
                    echo '</a>';
                    echo '</div>';
                    echo '<div class="redux_slides_add_remove">';

                    echo '<span class="button logo_upload_button" id="add_logo_' . $x . '">' . __('Upload Image', 'redux-framework') . '</span>';
                    $hide = '';
                    if (empty($slide['logourl']) || $slide['logourl'] == '')
                        $hide = ' hide';

                    echo ' <span class="button remove-logo' . $hide . '" id="logo_reset_' . $x . '" rel="' . $slide['logo_id'] . '">' . __('Remove', 'redux-framework') . '</span>';
                    echo '</div>';
                    echo __( 'Dimension', 'redux-framework' ).' : <input type="text" id="' . $this->field['id'] . '-logo_width_' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][logowidth]" value="' . esc_attr($slide['logowidth']) . '" style="width:100px" class="" /> X ';
                    echo ' <input type="text" id="' . $this->field['id'] . '-logo_height_' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][logoheight]" value="' . esc_attr($slide['logoheight']) . '" style="width:100px" class="" /> px';
                    echo'<br/><br/>';
                    echo __( 'Animation', 'redux-framework' );
                    echo '<br/><div><ul>
                <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-logodirection_'.$x.'_logo_left" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][logodirection]" value="from-top" '.checked($slide['logodirection'], 'from-top', false).'/>
                <span>From Top</span></li>
                <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-logodirection_'.$x.'_logo_right" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][logodirection]" value="from-bottom" '.checked($slide['logodirection'], 'from-bottom', false).'/>
                <span>From Bottom</span></li>
                <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-logodirection_'.$x.'_logo_fade" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][logodirection]" value="fade" '.checked($slide['logodirection'], 'fade', false).'/>
                <span>Fade</span></li>
                </ul>
                </div>';

                    echo __( 'Vertical Position', 'redux-framework' ).' :<br/><br/>Desktop <input type="text" id="' . $this->field['id'] . '-logo_move_' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][logomove]" value="' . esc_attr($slide['logomove']) . '" style="width:100px" class="value" /> px';
                    echo '<br/>Mobile&nbsp;&nbsp;&nbsp; <input type="text" id="' . $this->field['id'] . '-logo_move_mobile' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][logomovemobile]" value="' . esc_attr($slide['logomovemobile']) . '" style="width:100px" class="value" /> px';


                    echo '</div>';
                    echo '</li>';
                    echo '<li>';
                   $hide = '';
                    if ( empty( $slide['url'] ) ) {
                        $hide = ' hide';
                    }

                    echo '<div class="slide-image"><label>'.__( 'Background Image', 'redux-framework' ).'</label><div class="screenshot' . $hide . '">';
                    echo '<a class="of-uploaded-image" href="' . $slide['url'] . '" target="_blank">';
                    echo '<img class="redux-slides-image" id="image_image_id_' . $x . '" src="' . $slide['thumb'] . '" alt="" target="_blank" rel="external" />';
                    echo '</a>';
                    echo '</div>';

                    echo '<div class="redux_slides_add_remove">';

                    echo '<span class="button media_upload_button" id="add_' . $x . '">' . __('Upload Background', 'redux-framework') . '</span>';

                    $hide = '';
                    if (empty($slide['url']) || $slide['url'] == '')
                        $hide = ' hide';

                    echo '<span class="button remove-image' . $hide . '" id="reset_' . $x . '" rel="' . $slide['attachment_id'] . '">' . __('Remove', 'redux-framework') . '</span>';

                    echo '</div>'.__( 'Slide Direction', 'redux-framework' ).'<br/><div>
                <input type="radio" class="radio" id="'.$this->field['id'].'-direction_'.$x.'_left" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][direction]" value="from-left" '.checked($slide['direction'], 'from-left', false).'/>
                <span>From Left</span>
                <input type="radio" class="radio" id="'.$this->field['id'].'-direction_'.$x.'_right" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][direction]" value="from-right" '.checked($slide['direction'], 'from-right', false).'/>
                <span>From Right</span>
                </div>
                </div>' . "\n";                    echo '</li>';
                    echo '<li><input type="hidden" class="slide-sort" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][sort]" id="' . $this->field['id'] . '-sort_' . $x . '" value="' . $slide['sort'] . '" />';

                    echo '<li><input type="hidden" class="upload-logo-id" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][logo_id]" id="' . $this->field['id'] . '-logo_id_' . $x . '" value="' . $slide['logo_id'] . '" />';
                    echo '<input type="hidden" class="upload-logo-thumbnail" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][logothumb]" id="' . $this->field['id'] . '-logo_thumb_url_' . $x . '" value="' . $slide['logothumb'] . '" readonly="readonly" />';
                    echo '<input type="hidden" class="upload-logo" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][logourl]" id="' . $this->field['id'] . '-logo_url_' . $x . '" value="' . $slide['logourl'] . '" readonly="readonly" />';

                    echo '<li><input type="hidden" class="upload-id" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][attachment_id]" id="' . $this->field['id'] . '-image_id_' . $x . '" value="' . $slide['attachment_id'] . '" />';
                    echo '<input type="hidden" class="upload-thumbnail" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][thumb]" id="' . $this->field['id'] . '-thumb_url_' . $x . '" value="' . $slide['thumb'] . '" readonly="readonly" />';
                    echo '<input type="hidden" class="upload" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][image]" id="' . $this->field['id'] . '-image_url_' . $x . '" value="' . $slide['image'] . '" readonly="readonly" />';
                    echo '<input type="hidden" class="upload-height" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][height]" id="' . $this->field['id'] . '-image_height_' . $x . '" value="' . $slide['height'] . '" />';
                    echo '<input type="hidden" class="upload-width" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][width]" id="' . $this->field['id'] . '-image_width_' . $x . '" value="' . $slide['width'] . '" /></li>';
                    echo '<li><a href="javascript:void(0);" class="button deletion redux-slides-remove">' . __('Delete Slide', 'redux-framework') . '</a></li>';
                    echo '</ul></div></fieldset></div>';
                    $x++;
                
                }
            }


            if ($x == 0) {
                echo '<div class="redux-slides-accordion-group"><fieldset class="redux-field" data-id="'.$this->field['id'].'"><h3><span class="redux-slides-header">New Slide</span></h3><div>';

                $hide = ' hide';



                echo '<ul id="' . $this->field['id'] . '-ul" class="redux-slides-list">';
                echo '<li><label>'.__( 'Slide Title', 'redux-framework' ).'</label> <input type="text" id="' . $this->field['id'] . '-title_' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][title]" value="" class="full-text slide-title" />';

                echo '<br/><br/>'.__( 'Animation', 'redux-framework' );
                echo '<div><ul>
                <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-titledirection_'.$x.'_logo_left" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][titledirection]" value="from-top" checked="checked"/>
                <span>From Top</span></li>
                <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-titledirection_'.$x.'_logo_right" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][titledirection]" value="from-bottom" />
                <span>From Bottom</span></li>
                <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-titledirection_'.$x.'_title_fade" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][titledirection]" value="fade" />
                <span>Fade</span></li>
                </ul>
                </div>';

                echo __( 'Vertical Position', 'redux-framework' ).' :<br/><br/>Desktop <input type="text" id="' . $this->field['id'] . '-title_move_' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][titlemove]" value="0" style="width:100px" class="value" /> px';
                echo '<br/>Mobile&nbsp;&nbsp;&nbsp; <input type="text" id="' . $this->field['id'] . '-title_move_mobile' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][titlemovemobile]" value="0" style="width:100px" class="value" /> px';
                echo '</li>';
                echo '<li><label>'.__( 'Slide Content', 'redux-framework' ).'</label> <textarea name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][description]" id="' . $this->field['id'] . '-description_' . $x . '" class="large-text" rows="6"></textarea>';

                echo '<br/><br/>'.__( 'Animation', 'redux-framework' );
                echo '<div><ul>
                <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-contentdirection_'.$x.'_content_left" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][contentdirection]" value="from-top" checked="checked"/>
                <span>From Top</span></li>
                <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-contentdirection_'.$x.'_content_right" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][contentdirection]" value="from-bottom" />
                <span>From Bottom</span></li>
                <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-contentdirection_'.$x.'_content_fade" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][contentdirection]" value="fade" />
                <span>Fade</span></li>
                </ul>
                </div>';

                echo __( 'Vertical Position', 'redux-framework' ).' :<br/><br/>Desktop <input type="text" id="' . $this->field['id'] . '-content_move_' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][contentmove]" value="0" style="width:100px" class="value" /> px';
                echo '<br/>Mobile&nbsp;&nbsp;&nbsp; <input type="text" id="' . $this->field['id'] . '-content_move_mobile' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][contentmovemobile]" value="0" style="width:100px" class="value" /> px';

                echo '</li>';
                echo '<li><label>'.__( 'Button Label', 'redux-framework' ).'</label><br/><input type="text" id="' . $this->field['id'] . '-label_' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][slidelabel]" value="" class="full-text" /></li>';
                echo '<li>'.__( 'Button Link', 'redux-framework' ).'<input type="text" id="' . $this->field['id'] . '-url_' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][slideurl]" value="" class="full-text" />';
                echo'<br/><br/>';
                echo __( 'Animation', 'redux-framework' );

                echo '<div><ul>
                <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-buttondirection_'.$x.'_button_left" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][buttondirection]" value="from-top" checked="checked"/>
                <span>From Top</span></li>
                <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-buttondirection_'.$x.'_button_right" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][buttondirection]" value="from-bottom" />
                <span>From Bottom</span></li>
                <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-buttondirection_'.$x.'_button_fade" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][buttondirection]" value="fade" />
                <span>Fade</span></li>
                </ul>
                </div>';

                echo __( 'Vertical Position', 'redux-framework' ).' : <input type="text" id="' . $this->field['id'] . '-button_move_' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][buttonmove]" value="0" style="width:100px" class="value" /> px';
                echo '<br/>Mobile&nbsp;&nbsp;&nbsp; <input type="text" id="' . $this->field['id'] . '-button_move_mobile' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][buttonmovemobile]" value="" style="width:100px" class="value" /> px';

                echo '</li>';
                echo '<li>';
                echo '<div class="slide-image"><label>'.__( 'Background Image', 'redux-framework' ).'</label><div class="screenshot' . $hide . '">';
                echo '<a class="of-uploaded-image" href="">';
                echo '<img class="redux-slides-image" id="image_image_id_' . $x . '" src="" alt="" target="_blank" rel="external" />';
                echo '</a>';
                echo '</div>';

                //Upload controls DIV
                echo '<div class="upload_button_div">';

                //If the user has WP3.5+ show upload/remove button
                echo '<span class="button media_upload_button" id="add_' . $x . '">' . __('Upload Background', 'redux-framework') . '</span>';

                echo '<span class="button remove-image' . $hide . '" id="reset_' . $x . '" rel="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][attachment_id]">' . __('Remove', 'redux-framework') . '</span>';

                echo '</div>'.__( 'Slide Direction', 'redux-framework' ).'<br/><div>
                <input type="radio" class="radio" id="'.$this->field['id'].'-direction_'.$x.'_left" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][direction]" value="from-left" checked="checked" />
                <span>From Left</span>
                <input type="radio" class="radio" id="'.$this->field['id'].'-direction_'.$x.'_right" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][direction]" value="from-right" />
                <span>From Right</span>
                </div>
                </div>' . "\n";
                echo '</li>';
                echo '<li>';
                echo '<div class="logo-image"><label>'.__( 'Image', 'redux-framework' ).'</label><div class="logoscreenshot' . $hide . '">';
                echo '<a class="of-uploaded-image" href="" target="_blank">';
                echo '<img class="redux-slides-image" id="image_image_id_' . $x . '" src="" alt="" target="_blank" rel="external" />';
                echo '</a>';
                echo '</div>';
                echo '<div class="redux_slides_add_remove">';

                echo '<span class="button logo_upload_button" id="add_logo_' . $x . '">' . __('Upload Image', 'redux-framework') . '</span>';

                echo ' <span class="button remove-logo' . $hide . '" id="logo_reset_' . $x . '" rel="' .$this->args['opt_name'] . '[' . $this->field['id'] . '][logo_id]">' . __('Remove', 'redux-framework') . '</span>';
                echo '</div>';
                echo __( 'Dimension', 'redux-framework' ).' : <input type="text" id="' . $this->field['id'] . '-logo_width_' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][logowidth]" value="0" style="width:100px" class="value" /> X ';
                echo ' <input type="text" id="' . $this->field['id'] . '-logo_height_' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][logoheight]" value="" style="width:100px" class="" /> px';
                echo'<br/><br/>';
                echo __( 'Animation', 'redux-framework' );
                echo '<div><ul>
                <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-logodirection_'.$x.'_logo_left" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][logodirection]" value="from-top" checked="checked" />
                <span>From Top</span></li>
                <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-logodirection_'.$x.'_logo_right" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][logodirection]" value="from-bottom" />
                <span>From Bottom</span></li>
                <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-logodirection_'.$x.'_logo_fade" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][logodirection]" value="fade" />
                <span>Fade</span></li>
                </ul>
                </div>';

                echo __( 'Vertical Position', 'redux-framework' ).' :<br/><br/>Desktop <input type="text" id="' . $this->field['id'] . '-logo_move_' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][logomove]" value="" style="width:100px" class="" /> px';
                echo '<br/>Mobile&nbsp;&nbsp;&nbsp; <input type="text" id="' . $this->field['id'] . '-logo_move_mobile' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][logomovemobile]" value="" style="width:100px" class="value" /> px';
                echo '</div>';
                echo '</li>';
                echo '<li><input type="hidden" class="slide-sort" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][sort]" id="' . $this->field['id'] . '-sort_' . $x . '" value="' . $x . '" />';

                echo '<li><input type="hidden" class="upload-logo-id" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][logo_id]" id="' . $this->field['id'] . '-logo_id_' . $x . '" value="" />';
                echo '<input type="hidden" class="upload-logo-thumbnail" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][logothumb]" id="' . $this->field['id'] . '-logo_thumb_url_' . $x . '" value="" readonly="readonly" />';
                echo '<input type="hidden" class="upload-logo" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][logourl]" id="' . $this->field['id'] . '-logo_url_' . $x . '" value="" readonly="readonly" />';

                echo '<li><input type="hidden" class="upload-id" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][attachment_id]" id="' . $this->field['id'] . '-image_id_' . $x . '" value="" />';
                echo '<input type="hidden" class="upload" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][image]" id="' . $this->field['id'] . '-image_url_' . $x . '" value="" readonly="readonly" />';
                echo '<input type="hidden" class="upload-height" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][height]" id="' . $this->field['id'] . '-image_height_' . $x . '" value="" />';
                echo '<input type="hidden" class="upload-width" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][width]" id="' . $this->field['id'] . '-image_width_' . $x . '" value="" /></li>';
                echo '<li><a href="javascript:void(0);" class="button deletion redux-slides-remove">' . __('Delete Slide', 'redux-framework') . '</a></li>';
                echo '</ul></div></fieldset></div>';
            }
            echo '</div><a href="javascript:void(0);" class="button redux-slides-add button-primary" rel-id="' . $this->field['id'] . '-ul" rel-name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][title][]">' . __('Add Slide', 'redux-framework') . '</a><br/>';
            
        }         

        /**
         * Enqueue Function.
         *
         * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */

        public function enqueue() {


            wp_enqueue_script(
                'redux-field-media-js',
                DethemeReduxFramework::$_url . 'inc/fields/media/field_media.js',
                array( 'jquery', 'wp-color-picker' ),
                time(),
                true
            );

            wp_enqueue_style(
                'redux-field-media-css',
                DethemeReduxFramework::$_url . 'inc/fields/media/field_media.css',
                time(),
                true
            );            

            wp_enqueue_script(
                'redux-field-slides-js',
                DethemeReduxFramework::$_url . 'inc/fields/slides/field_slides.js',
                array('jquery', 'jquery-ui-core', 'jquery-ui-accordion', 'wp-color-picker'),
                time(),
                true
            );

            wp_enqueue_style(
                'redux-field-slides-css',
                DethemeReduxFramework::$_url . 'inc/fields/slides/field_slides.css',
                time(),
                true
            );


        }

    }
}
