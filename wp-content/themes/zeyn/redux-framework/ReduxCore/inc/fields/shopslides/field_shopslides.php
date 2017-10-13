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
if (!class_exists('DethemeReduxFramework_shopslides')) {

    /**
     * Main ReduxFramework_slides class
     *
     * @since       1.0.0
     */
    class DethemeReduxFramework_shopslides extends DethemeReduxFramework{

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
                        'sort' => '',
                        'url' => '',
                        'image'=>'',
                        'thumb' => '',
                        'slideurl' => '',
                        'slidelabel' => '',
                        'attachment_id' => '',
                        'height' => '',
                        'width' => '',
                        'direction'=>'from-left',
                        'titledirection'=>'from-top',
                        'titlemove'=>'0','titlemovemobile'=>'0',
                        'text_2' => '',
                        'text_2move'=>'0','text_2movemobile'=>'0',
                        'text_2direction'=>'from-top',
                        'buttonmove'=>'0','buttonmovemobile'=>'0',
                        'text_3' => '',
                        'text_3move'=>'0','text_3movemobile'=>'0',
                        'text_3direction'=>'from-top',
                        'text_2' => '',
                        'text_4move'=>'0','text_4movemobile'=>'0',
                        'text_4direction'=>'from-top',
                        'buttondirection'=>'from-top',
                        'title_font'=>'','title_fontweight'=>'','title_fontstyle'=>'','title_fontcolor'=>'',
                        'text_2_font'=>'','text_2_fontweight'=>'','text_2_fontstyle'=>'','text_2_fontcolor'=>'',
                        'text_3_font'=>'','text_3_fontweight'=>'','text_3_fontstyle'=>'','text_3_fontcolor'=>'',
                        'text_4_font'=>'','text_4_fontweight'=>'','text_4_fontstyle'=>'','text_4_fontcolor'=>'',
                        'button_font'=>'','button_fontweight'=>'','button_fontstyle'=>'','button_fontcolor'=>'',
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
                    echo '<li><label>'.__( '1st Text', 'redux-framework' ).'</label> <input type="text" id="' . $this->field['id'] . '-title_' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][title]" value="' . esc_attr($slide['title']) . '" class="full-text slide-title" />';
                    echo '<br/><br/>'.__( 'Animation :', 'redux-framework' );
                    echo '<div><ul class="inline-style">
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

                    echo __( 'Vertical Position', 'redux-framework' ).' :<ul class="inline-style"><li>Desktop <input type="text" id="' . $this->field['id'] . '-title_move_' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][titlemove]" value="' . esc_attr($slide['titlemove']) . '" style="width:100px" class="value" /> px</li>';
                    echo '<li>Mobile&nbsp;&nbsp;&nbsp; <input type="text" id="' . $this->field['id'] . '-title_move_mobile' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][titlemovemobile]" value="' . esc_attr($slide['titlemovemobile']) . '" style="width:100px" class="value" /> px</li>';
                    echo '</ul></li>';

                    echo '<li>'.__( 'Style :', 'redux-framework' );
                    echo '<ul class="inline-style">';
                    echo '<li>Font size <input type="text" id="' . $this->field['id'] . '-title_font' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][title_font]" value="' . esc_attr($slide['title_font']) . '" style="width:50px" class="value" /> px</li>';
                    echo '<li>Font weight <input type="text" id="' . $this->field['id'] . '-title_fontweight' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][title_fontweight]" value="' . esc_attr($slide['title_fontweight']) . '" style="width:50px" class="value" /></li>';
                    echo '<li>Font color <input type="text" id="' . $this->field['id'] . '-title_fontcolor' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][title_fontcolor]" value="' . esc_attr($slide['title_fontcolor']) . '" style="width:50px" class="redux-color redux-color-init" /></li>';
                    echo '<li>Font style <select id="' . $this->field['id'] . '-title_fontstyle' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][title_fontstyle]" style="width:150px" class="select">';
                    echo "<option value=''".((!isset($slide['title_fontstyle']) || ''==$slide['title_fontstyle'])?' selected="selected"':"").">Default</option>";    
                    echo "<option value='italic'".(('italic'==$slide['title_fontstyle'])?' selected="selected"':"").">Italic</option>";    
                    echo "<option value='normal'".(('normal'==$slide['title_fontstyle'])?' selected="selected"':"").">Normal</option>";    
                    echo "<option value='oblique'".(('oblique'==$slide['title_fontstyle'])?' selected="selected"':"").">Oblique</option>";    
                    echo '</select></li>';
                    echo '</ul>';
                    echo "</li>";

                    echo '<li><label>'.__( '2nd Text', 'redux-framework' ).'</label> <input type="text" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_2]" id="' . $this->field['id'] . '-text_2_' . $x . '" value="'.esc_attr($slide['text_2']).'" class="full-text slide-title" />';
                    echo '<br/><br/>'.__( 'Animation', 'redux-framework' );
                    echo '<div><ul class="inline-style">
                    <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-text_2direction_'.$x.'_text_2_left" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][text_2direction]" value="from-top" '.checked($slide['text_2direction'], 'from-top', false).'/>
                <span>From Top</span></li>
                <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-text_2direction_'.$x.'_text_2_right" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][text_2direction]" value="from-bottom" '.checked($slide['text_2direction'], 'from-bottom', false).'/>
                <span>From Bottom</span></li>
                <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-text_2direction_'.$x.'_text_2_fade" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][text_2direction]" value="fade" '.checked($slide['text_2direction'], 'fade', false).'/>
                <span>Fade</span></li>
                </ul>
                </div>';

                    echo __( 'Vertical Position', 'redux-framework' ).' :<ul class="inline-style"><li>Desktop <input type="text" id="' . $this->field['id'] . '-text_2_move_' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_2move]" value="' . esc_attr($slide['text_2move']) . '" style="width:100px" class="value" /> px</li>';
                    echo '<li>Mobile&nbsp;&nbsp;&nbsp; <input type="text" id="' . $this->field['id'] . '-text_3_move_mobile' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_2movemobile]" value="' . esc_attr($slide['text_2movemobile']) . '" style="width:100px" class="value" /> px</li>';
                    echo '</ul></li>';

                    echo '<li>'.__( 'Style :', 'redux-framework' );
                    echo '<ul class="inline-style">';
                    echo '<li>Font size <input type="text" id="' . $this->field['id'] . '-text_2_font' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_2_font]" value="' . esc_attr($slide['text_2_font']) . '" style="width:50px" class="value" /> px</li>';
                    echo '<li>Font weight <input type="text" id="' . $this->field['id'] . '-text_2_fontweight' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_2_fontweight]" value="' . esc_attr($slide['text_2_fontweight']) . '" style="width:50px" class="value" /></li>';
                    echo '<li>Font color <input type="text" id="' . $this->field['id'] . '-text_2_fontcolor' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_2_fontcolor]" value="' . esc_attr($slide['text_2_fontcolor']) . '" style="width:50px" class="redux-color redux-color-init" /></li>';
                    echo '<li>Font style <select id="' . $this->field['id'] . '-text_2_fontstyle' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_2_fontstyle]" style="width:150px" class="select">';
                    echo "<option value=''".((!isset($slide['text_2_fontstyle']) || ''==$slide['text_2_fontstyle'])?' selected="selected"':"").">Default</option>";    
                    echo "<option value='italic'".(('italic'==$slide['text_2_fontstyle'])?' selected="selected"':"").">Italic</option>";    
                    echo "<option value='normal'".(('normal'==$slide['text_2_fontstyle'])?' selected="selected"':"").">Normal</option>";    
                    echo "<option value='oblique'".(('oblique'==$slide['text_2_fontstyle'])?' selected="selected"':"").">Oblique</option>";    
                    echo '</select></li>';
                    echo '</ul>';
                    echo "</li>";

                    echo '<li><label>'.__( '3rd Text', 'redux-framework' ).'</label> <input type="text" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_3]" id="' . $this->field['id'] . '-text_3_' . $x . '" value="'.esc_attr($slide['text_3']).'" class="full-text slide-title" />';
                    echo '<br/><br/>'.__( 'Animation', 'redux-framework' );
                    echo '<div><ul class="inline-style">
                    <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-text_3direction_'.$x.'_text_3_left" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][text_3direction]" value="from-top" '.checked($slide['text_3direction'], 'from-top', false).'/>
                <span>From Top</span></li>
                <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-text_3direction_'.$x.'_text_3_right" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][text_3direction]" value="from-bottom" '.checked($slide['text_3direction'], 'from-bottom', false).'/>
                <span>From Bottom</span></li>
                <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-text_3direction_'.$x.'_text_3_fade" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][text_3direction]" value="fade" '.checked($slide['text_3direction'], 'fade', false).'/>
                <span>Fade</span></li>
                </ul>
                </div>';

                    echo __( 'Vertical Position', 'redux-framework' ).' :<ul class="inline-style"><li>Desktop <input type="text" id="' . $this->field['id'] . '-text_3_move_' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_3move]" value="' . esc_attr($slide['text_3move']) . '" style="width:100px" class="value" /> px</li>';
                    echo '<li>Mobile&nbsp;&nbsp;&nbsp; <input type="text" id="' . $this->field['id'] . '-text_3_move_mobile' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_3movemobile]" value="' . esc_attr($slide['text_3movemobile']) . '" style="width:100px" class="value" /> px</li>';

                    echo '</ul></li>';

                    echo '<li>'.__( 'Style :', 'redux-framework' );
                    echo '<ul class="inline-style">';
                    echo '<li>Font size <input type="text" id="' . $this->field['id'] . '-text_3_font' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_3_font]" value="' . esc_attr($slide['text_3_font']) . '" style="width:50px" class="value" /> px</li>';
                    echo '<li>Font weight <input type="text" id="' . $this->field['id'] . '-text_3_fontweight' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_3_fontweight]" value="' . esc_attr($slide['text_3_fontweight']) . '" style="width:50px" class="value" /></li>';
                    echo '<li>Font color <input type="text" id="' . $this->field['id'] . '-text_3_fontcolor' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_3_fontcolor]" value="' . esc_attr($slide['text_3_fontcolor']) . '" style="width:50px" class="redux-color redux-color-init" /></li>';
                    echo '<li>Font style <select id="' . $this->field['id'] . '-text_3_fontstyle' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_3_fontstyle]" style="width:150px" class="select">';
                    echo "<option value=''".((!isset($slide['text_3_fontstyle']) || ''==$slide['text_3_fontstyle'])?' selected="selected"':"").">Default</option>";    
                    echo "<option value='italic'".(('italic'==$slide['text_3_fontstyle'])?' selected="selected"':"").">Italic</option>";    
                    echo "<option value='normal'".(('normal'==$slide['text_3_fontstyle'])?' selected="selected"':"").">Normal</option>";    
                    echo "<option value='oblique'".(('oblique'==$slide['text_3_fontstyle'])?' selected="selected"':"").">Oblique</option>";    
                    echo '</select></li>';
                    echo '</ul>';
                    echo "</li>";

                    echo '<li><label>'.__( '4th Text', 'redux-framework' ).'</label> <input type="text" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_4]" id="' . $this->field['id'] . '-text_4_' . $x . '" value="'.esc_attr($slide['text_4']).'" class="full-text slide-title" />';
                    echo '<br/><br/>'.__( 'Animation', 'redux-framework' );
                    echo '<div><ul class="inline-style">
                    <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-text_4direction_'.$x.'_text_4_left" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][text_4direction]" value="from-top" '.checked($slide['text_4direction'], 'from-top', false).'/>
                <span>From Top</span></li>
                <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-text_4direction_'.$x.'_text_4_right" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][text_4direction]" value="from-bottom" '.checked($slide['text_4direction'], 'from-bottom', false).'/>
                <span>From Bottom</span></li>
                <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-text_4direction_'.$x.'_text_4_fade" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][text_4direction]" value="fade" '.checked($slide['text_4direction'], 'fade', false).'/>
                <span>Fade</span></li>
                </ul>
                </div>';

                    echo __( 'Vertical Position', 'redux-framework' ).' :<ul class="inline-style"><li>Desktop <input type="text" id="' . $this->field['id'] . '-text_4_move_' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_4move]" value="' . esc_attr($slide['text_4move']) . '" style="width:100px" class="value" /> px</li>';
                    echo '<li>Mobile&nbsp;&nbsp;&nbsp; <input type="text" id="' . $this->field['id'] . '-text_4_move_mobile' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_4movemobile]" value="' . esc_attr($slide['text_4movemobile']) . '" style="width:100px" class="value" /> px</li>';

                    echo '</ul></li>';

                    echo '<li>'.__( 'Style :', 'redux-framework' );
                    echo '<ul class="inline-style">';
                    echo '<li>Font size <input type="text" id="' . $this->field['id'] . '-text_4_font' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_4_font]" value="' . esc_attr($slide['text_4_font']) . '" style="width:50px" class="value" /> px</li>';
                    echo '<li>Font weight <input type="text" id="' . $this->field['id'] . '-text_4_fontweight' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_4_fontweight]" value="' . esc_attr($slide['text_4_fontweight']) . '" style="width:50px" class="value" /></li>';
                    echo '<li>Font color <input type="text" id="' . $this->field['id'] . '-text_4_fontcolor' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_4_fontcolor]" value="' . esc_attr($slide['text_4_fontcolor']) . '" style="width:50px" class="redux-color redux-color-init" /></li>';
                    echo '<li>Font style <select id="' . $this->field['id'] . '-text_4_fontstyle' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_4_fontstyle]" style="width:150px" class="select">';
                    echo "<option value=''".((!isset($slide['text_4_fontstyle']) || ''==$slide['text_4_fontstyle'])?' selected="selected"':"").">Default</option>";    
                    echo "<option value='italic'".(('italic'==$slide['text_4_fontstyle'])?' selected="selected"':"").">Italic</option>";    
                    echo "<option value='normal'".(('normal'==$slide['text_4_fontstyle'])?' selected="selected"':"").">Normal</option>";    
                    echo "<option value='oblique'".(('oblique'==$slide['text_4_fontstyle'])?' selected="selected"':"").">Oblique</option>";    
                    echo '</select></li>';
                    echo '</ul>';
                    echo "</li>";

                    echo '<li><label>'.__( 'Button', 'redux-framework' ).'</label><br/>'.__( 'Button Label', 'redux-framework' ).'<br/><input type="text" id="' . $this->field['id'] . '-label_' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][slidelabel]" value="'.esc_attr($slide['slidelabel']).'" class="full-text" /></li>';
                    echo '<li>'.__( 'Button Link', 'redux-framework' ).' <input type="text" id="' . $this->field['id'] . '-url_' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][slideurl]" value="' . esc_attr($slide['slideurl']) . '" class="full-text"  />';
                    echo'<br/><br/>';
                    echo __( 'Animation', 'redux-framework' );
                    echo '<div><ul class="inline-style">
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

                    echo __( 'Vertical Position', 'redux-framework' ).' :<ul class="inline-style"><li>Desktop <input type="text" id="' . $this->field['id'] . '-button_move_' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][buttonmove]" value="' . esc_attr($slide['buttonmove']) . '" style="width:100px" class="value" /> px</li>';
                    echo '<li>Mobile&nbsp;&nbsp;&nbsp; <input type="text" id="' . $this->field['id'] . '-button_move_mobile' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][buttonmovemobile]" value="' . esc_attr($slide['buttonmovemobile']) . '" style="width:100px" class="value" /> px</li>';


                    echo '</ul></li>';
                    echo '<li>'.__( 'Style :', 'redux-framework' );
                    echo '<ul class="inline-style">';
                    echo '<li>Font size <input type="text" id="' . $this->field['id'] . '-button_font' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][button_font]" value="' . esc_attr($slide['button_font']) . '" style="width:50px" class="value" /> px</li>';
                    echo '<li>Font weight <input type="text" id="' . $this->field['id'] . '-button_fontweight' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][button_fontweight]" value="' . esc_attr($slide['button_fontweight']) . '" style="width:50px" class="value" /></li>';
                    echo '<li>Font color <input type="text" id="' . $this->field['id'] . '-button_fontcolor' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][button_fontcolor]" value="' . esc_attr($slide['button_fontcolor']) . '" style="width:50px" class="redux-color redux-color-init" /></li>';
                    echo '<li>Font style <select id="' . $this->field['id'] . '-button_fontstyle' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][button_fontstyle]" style="width:150px" class="select">';
                    echo "<option value=''".((!isset($slide['button_fontstyle']) || ''==$slide['button_fontstyle'])?' selected="selected"':"").">Default</option>";    
                    echo "<option value='italic'".(('italic'==$slide['button_fontstyle'])?' selected="selected"':"").">Italic</option>";    
                    echo "<option value='normal'".(('normal'==$slide['button_fontstyle'])?' selected="selected"':"").">Normal</option>";    
                    echo "<option value='oblique'".(('oblique'==$slide['button_fontstyle'])?' selected="selected"':"").">Oblique</option>";    
                    echo '</select></li>';
                    echo '</ul>';
                    echo "</li>";

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
                <ul class="inline-style"><li><input type="radio" class="radio" id="'.$this->field['id'].'-direction_'.$x.'_left" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][direction]" value="from-left" '.checked($slide['direction'], 'from-left', false).'/>
                <span>From Left</span></li><li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-direction_'.$x.'_right" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][direction]" value="from-right" '.checked($slide['direction'], 'from-right', false).'/>
                <span>From Right</span></li></ul>
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
                    echo '<li><a href="javascript:void(0);" class="button deletion redux-shop-slides-remove">' . __('Delete Slide', 'redux-framework') . '</a></li>';
                    echo '</ul></div></fieldset></div>';
                    $x++;
                
                }
            }


            if ($x == 0) {
                echo '<div class="redux-slides-accordion-group"><fieldset class="redux-field" data-id="'.$this->field['id'].'"><h3><span class="redux-slides-header">New Slide</span></h3><div>';

                $hide = ' hide';



                echo '<ul id="' . $this->field['id'] . '-ul" class="redux-slides-list">';
                echo '<li><label>'.__( '1st Text', 'redux-framework' ).'</label> <input type="text" id="' . $this->field['id'] . '-title_' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][title]" value="" class="full-text slide-title" />';

                echo '<br/><br/>'.__( 'Animation', 'redux-framework' );
                echo '<div><ul class="inline-style">
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

                echo __( 'Vertical Position', 'redux-framework' ).' :<ul class="inline-style"><li>Desktop <input type="text" id="' . $this->field['id'] . '-title_move_' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][titlemove]" value="0" style="width:100px" class="value" /> px</li>';
                echo '<li>Mobile&nbsp;&nbsp;&nbsp; <input type="text" id="' . $this->field['id'] . '-title_move_mobile' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][titlemovemobile]" value="0" style="width:100px" class="value" /> px</li>';
                echo '</li></ul></li>';

                    echo '<li>'.__( 'Style :', 'redux-framework' );
                    echo '<ul class="inline-style">';
                    echo '<li>Font size <input type="text" id="' . $this->field['id'] . '-title_font' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][title_font]" value="" style="width:50px" class="value" /> px</li>';
                    echo '<li>Font weight <input type="text" id="' . $this->field['id'] . '-title_fontweight' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][title_fontweight]" value="" style="width:50px" class="value" /></li>';
                    echo '<li>Font color <input type="text" id="' . $this->field['id'] . '-title_fontcolor' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][title_fontcolor]" value="" style="width:50px" class="redux-color redux-color-init" /></li>';
                    echo '<li>Font style <select id="' . $this->field['id'] . '-title_fontstyle' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][title_fontstyle]" style="width:150px" class="select">';
                    echo "<option value=''>Default</option>";    
                    echo "<option value='italic'>Italic</option>";    
                    echo "<option value='normal'>Normal</option>";    
                    echo "<option value='oblique'>Oblique</option>";    
                    echo '</select></li>';
                    echo '</ul>';
                    echo "</li>";

                echo '<li><label>'.__( '2nd Text', 'redux-framework' ).'</label> <input type="text" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_2]" id="' . $this->field['id'] . '-text_2_' . $x . '" class="full-text slide-title" />';

                echo '<br/><br/>'.__( 'Animation', 'redux-framework' );
                echo '<div><ul class="inline-style">
                <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-text_2direction_'.$x.'_text_2_left" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][text_2direction]" value="from-top" checked="checked"/>
                <span>From Top</span></li>
                <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-text_2direction_'.$x.'_text_2_right" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][text_2direction]" value="from-bottom" />
                <span>From Bottom</span></li>
                <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-text_2direction_'.$x.'_text_2_fade" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][text_2direction]" value="fade" />
                <span>Fade</span></li>
                </ul>
                </div>';

                echo __( 'Vertical Position', 'redux-framework' ).' :<ul class="inline-style"><li>Desktop <input type="text" id="' . $this->field['id'] . '-text_2_move_' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_2move]" value="0" style="width:100px" class="value" /> px</li>';
                echo '<li>Mobile&nbsp;&nbsp;&nbsp; <input type="text" id="' . $this->field['id'] . '-text_2_move_mobile' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_2movemobile]" value="0" style="width:100px" class="value" /> px</li>';

                echo '</li></ul></li>';

                    echo '<li>'.__( 'Style :', 'redux-framework' );
                    echo '<ul class="inline-style">';
                    echo '<li>Font size <input type="text" id="' . $this->field['id'] . '-text_2_font' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_2_font]" value="" style="width:50px" class="value" /> px</li>';
                    echo '<li>Font weight <input type="text" id="' . $this->field['id'] . '-text_2_fontweight' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_2_fontweight]" value="" style="width:50px" class="value" /></li>';
                    echo '<li>Font color <input type="text" id="' . $this->field['id'] . '-text_2_fontcolor' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_2_fontcolor]" value="" style="width:50px" class="redux-color redux-color-init" /></li>';
                    echo '<li>Font style <select id="' . $this->field['id'] . '-text_2_fontstyle' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_2_fontstyle]" style="width:150px" class="select">';
                    echo "<option value=''>Default</option>";    
                    echo "<option value='italic'>Italic</option>";    
                    echo "<option value='normal'>Normal</option>";    
                    echo "<option value='oblique'>Oblique</option>";    
                    echo '</select></li>';
                    echo '</ul>';
                    echo "</li>";

                echo '<li><label>'.__( '3rd Text', 'redux-framework' ).'</label> <input type="text" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_3]" id="' . $this->field['id'] . '-text_3_' . $x . '" class="full-text slide-title" />';

                echo '<br/><br/>'.__( 'Animation', 'redux-framework' );
                echo '<div><ul class="inline-style">
                <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-text_3direction_'.$x.'_text_3_left" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][text_3direction]" value="from-top" checked="checked"/>
                <span>From Top</span></li>
                <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-text_3direction_'.$x.'_text_3_right" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][text_3direction]" value="from-bottom" />
                <span>From Bottom</span></li>
                <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-text_3direction_'.$x.'_text_3_fade" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][text_3direction]" value="fade" />
                <span>Fade</span></li>
                </ul>
                </div>';

                echo __( 'Vertical Position', 'redux-framework' ).' :<ul class="inline-style"><li>Desktop <input type="text" id="' . $this->field['id'] . '-text_3_move_' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_3move]" value="0" style="width:100px" class="value" /> px</li>';
                echo '<li>Mobile&nbsp;&nbsp;&nbsp; <input type="text" id="' . $this->field['id'] . '-text_3_move_mobile' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_3movemobile]" value="0" style="width:100px" class="value" /> px</li>';

                echo '</li></ul></li>';

                    echo '<li>'.__( 'Style :', 'redux-framework' );
                    echo '<ul class="inline-style">';
                    echo '<li>Font size <input type="text" id="' . $this->field['id'] . '-text_3_font' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_3_font]" value="" style="width:50px" class="value" /> px</li>';
                    echo '<li>Font weight <input type="text" id="' . $this->field['id'] . '-text_3_fontweight' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_3_fontweight]" value="" style="width:50px" class="value" /></li>';
                    echo '<li>Font color <input type="text" id="' . $this->field['id'] . '-text_3_fontcolor' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_3_fontcolor]" value="" style="width:50px" class="redux-color redux-color-init" /></li>';
                    echo '<li>Font style <select id="' . $this->field['id'] . '-text_3_fontstyle' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_3_fontstyle]" style="width:150px" class="select">';
                    echo "<option value=''>Default</option>";    
                    echo "<option value='italic'>Italic</option>";    
                    echo "<option value='normal'>Normal</option>";    
                    echo "<option value='oblique'>Oblique</option>";    
                    echo '</select></li>';
                    echo '</ul>';
                    echo "</li>";


                echo '<li><label>'.__( '4th Text', 'redux-framework' ).'</label> <input type="text" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_4]" id="' . $this->field['id'] . '-text_4_' . $x . '" class="full-text slide-title" />';

                echo '<br/><br/>'.__( 'Animation', 'redux-framework' );
                echo '<div><ul class="inline-style">
                <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-text_4direction_'.$x.'_text_4_left" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][text_4direction]" value="from-top" checked="checked"/>
                <span>From Top</span></li>
                <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-text_4direction_'.$x.'_text_4_right" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][text_4direction]" value="from-bottom" />
                <span>From Bottom</span></li>
                <li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-text_4direction_'.$x.'_text_4_fade" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][text_4direction]" value="fade" />
                <span>Fade</span></li>
                </ul>
                </div>';

                echo __( 'Vertical Position', 'redux-framework' ).' :<ul class="inline-style"><li>Desktop <input type="text" id="' . $this->field['id'] . '-text_4_move_' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_4move]" value="0" style="width:100px" class="value" /> px</li>';
                echo '<li>Mobile&nbsp;&nbsp;&nbsp; <input type="text" id="' . $this->field['id'] . '-text_4_move_mobile' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_4movemobile]" value="0" style="width:100px" class="value" /> px</li>';

                echo '</li></ul></li>';

                    echo '<li>'.__( 'Style :', 'redux-framework' );
                    echo '<ul class="inline-style">';
                    echo '<li>Font size <input type="text" id="' . $this->field['id'] . '-text_4_font' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_4_font]" value="" style="width:50px" class="value" /> px</li>';
                    echo '<li>Font weight <input type="text" id="' . $this->field['id'] . '-text_4_fontweight' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_4_fontweight]" value="" style="width:50px" class="value" /></li>';
                    echo '<li>Font color <input type="text" id="' . $this->field['id'] . '-text_4_fontcolor' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_4_fontcolor]" value="" style="width:50px" class="redux-color redux-color-init" /></li>';
                    echo '<li>Font style <select id="' . $this->field['id'] . '-text_4_fontstyle' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][text_4_fontstyle]" style="width:150px" class="select">';
                    echo "<option value=''>Default</option>";    
                    echo "<option value='italic'>Italic</option>";    
                    echo "<option value='normal'>Normal</option>";    
                    echo "<option value='oblique'>Oblique</option>";    
                    echo '</select></li>';
                    echo '</ul>';
                    echo "</li>";


                echo '<li><label>'.__( 'Button Label', 'redux-framework' ).'</label><br/><input type="text" id="' . $this->field['id'] . '-label_' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][slidelabel]" value="" class="full-text" /></li>';
                echo '<li>'.__( 'Button Link', 'redux-framework' ).'<input type="text" id="' . $this->field['id'] . '-url_' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][slideurl]" value="" class="full-text" />';
                echo'<br/><br/>';
                echo __( 'Animation', 'redux-framework' );

                echo '<div><ul class="inline-style">
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

                echo __( 'Vertical Position', 'redux-framework' ).' : <ul class="inline-style"><li><input type="text" id="' . $this->field['id'] . '-button_move_' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][buttonmove]" value="0" style="width:100px" class="value" /> px</li>';
                echo '<li>Mobile&nbsp;&nbsp;&nbsp; <input type="text" id="' . $this->field['id'] . '-button_move_mobile' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][buttonmovemobile]" value="" style="width:100px" class="value" /> px</li>';

                echo '</li></ul></li>';

                    echo '</ul></li>';
                    echo '<li>'.__( 'Style :', 'redux-framework' );
                    echo '<ul class="inline-style">';
                    echo '<li>Font size <input type="text" id="' . $this->field['id'] . '-button_font' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][button_font]" value="" style="width:50px" class="value" /> px</li>';
                    echo '<li>Font weight <input type="text" id="' . $this->field['id'] . '-button_fontweight' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][button_fontweight]" value="" style="width:50px" class="value" /></li>';
                    echo '<li>Font color <input type="text" id="' . $this->field['id'] . '-button_fontcolor' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][button_fontcolor]" value="" style="width:50px" class="redux-color redux-color-init" /></li>';
                    echo '<li>Font style <select id="' . $this->field['id'] . '-button_fontstyle' . $x . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . '][' . $x . '][button_fontstyle]" style="width:150px" class="select">';
                    echo "<option value=''>Default</option>";    
                    echo "<option value='italic'>Italic</option>";    
                    echo "<option value='normal'>Normal</option>";    
                    echo "<option value='oblique'>Oblique</option>";    
                    echo '</select></li>';
                    echo '</ul>';
                    echo "</li>";

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
                <ul class="inline-style"><li><input type="radio" class="radio" id="'.$this->field['id'].'-direction_'.$x.'_left" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][direction]" value="from-left" checked="checked" />
                <span>From Left</span></li><li>
                <input type="radio" class="radio" id="'.$this->field['id'].'-direction_'.$x.'_right" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$x.'][direction]" value="from-right" />
                <span>From Right</span></li></ul>
                </div>
                </div>' . "\n";
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


            wp_enqueue_style( 'wp-color-picker' );

            wp_enqueue_script(
                'redux-field-color-js', 
                DethemeReduxFramework::$_url . 'inc/fields/color/field_color.js', 
                array( 'jquery', 'wp-color-picker' ),
                time(),
                true
            );

            wp_enqueue_style(
                'redux-field-color-css', 
                DethemeReduxFramework::$_url . 'inc/fields/color/field_color.css', 
                time(),
                true
            );

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
                DethemeReduxFramework::$_url . 'inc/fields/shopslides/field_shopslides.js',
                array('jquery', 'jquery-ui-core', 'jquery-ui-accordion', 'wp-color-picker'),
                time(),
                true
            );

            wp_enqueue_style(
                'redux-field-shopslides-css',
                DethemeReduxFramework::$_url . 'inc/fields/shopslides/field_shopslides.css',
                time(),
                true
            );


        }

    }
}