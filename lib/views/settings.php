<?php
    global $Speaker;
    $settings = get_option($Speaker->options['settings']);
?>
<div class="wrap">
    <div id="upf-icon-edit-pages" class="icon32 icon32-posts-page"><br/></div>
    <h2><?php _e('Speaker Settings', SPEAKER_SLUG);?></h2>
    <div class="tlp-content-holder">
        <div class="tch-left">
            <form id="tlp-settings" onsubmit="speakerSettings(this); return false;">

                <h3><?php _e('General settings',SPEAKER_SLUG);?></h3>

                <table class="form-table">

                    <tr>
                        <th scope="row"><label for="primary-color"><?php _e('Primary Color',SPEAKER_SLUG);?></label></th>
                        <td class="">
                            <input name="primary_color" id="primary_color" type="text" value="<?php echo (isset($settings['primary_color']) ? ($settings['primary_color'] ? $settings['primary_color'] : '#0367bf') : '#0367bf'); ?>" class="tlp-color">
                            
                        </td>
                    </tr>

                    <tr>
                        <th scope="row"><label for="Square/Rounded image"><?php _e('Square/Rounded image',SPEAKER_SLUG);?></label></th>
                        <td class="">
                            <input name="border_radius" id="border_radius" type="text" value="<?php echo (isset($settings['border_radius']) ? ($settings['border_radius'] ? $settings['border_radius'] : '0%') : '0%'); ?>">
                            
                        </td>
                    </tr>

                   <!--  <tr>
                        <th scope="row"><label for="imgWidth"><?php _e('Image Size',SPEAKER_SLUG);?></label></th>
                        <td><input name="feature_img[width]" type="text" value="<?php echo (isset($settings['feature_img']['width']) ? ($settings['feature_img']['width'] ? intval($settings['feature_img']['width']) : 400 ) : 400); ?>" size="4" class=""> * <input name="feature_img[height]" type="text" value="<?php echo (isset($settings['feature_img']['height']) ? ($settings['feature_img']['height'] ? intval($settings['feature_img']['height']) : 400 ) : 400); ?>" size="4" class=""> <?php _e('(Width * Height)',SPEAKER_SLUG); ?></td>
                        
                    </tr> -->

                    <tr>
                        <th scope="row"><label for="imgWidth"><?php _e('Image Size',SPEAKER_SLUG);?></label></th>
                        <td>
                            <input name="feature_imgw" type="text" value="<?php echo (isset($settings['feature_imgw']) ? ($settings['feature_imgw'] ? intval($settings['feature_imgw']) : 'auto' ) : 'auto'); ?>" size="4" class=""> * 
                            <input name="feature_imgh" type="text" value="<?php echo (isset($settings['feature_imgh']) ? ($settings['feature_imgh']? intval($settings['feature_imgh']) : 'auto' ) : 'auto'); ?>" size="4" class=""> <?php _e('(Width * Height)',SPEAKER_SLUG); ?>
                        </td>
                        
                    </tr>

                    <tr>
                        <th scope="row"><label for="imgborder"><?php _e('Image Border',SPEAKER_SLUG);?></label></th>
                        <td>
                            <input name="imgborder" type="text" value="<?php echo (isset($settings['imgborder']) ? ($settings['imgborder'] ? intval($settings['imgborder']) : 'none' ) : 'none'); ?>"  class=""> 
                        </td>
                        
                    </tr>


                    <tr>
                        <th scope="row"><label for="slug"><?php _e('Slug',SPEAKER_SLUG);?></label></th>
                        <td class="">
                            <input name="slug" id="slug" type="text" value="<?php echo (isset($settings['slug']) ? ($settings['slug'] ? sanitize_title_with_dashes($settings['slug']) : 'speaker' ) : 'speaker'); ?>" size="15" class="">
                            <p class="description"><?php _e('Slug configuration',SPEAKER_SLUG);?></p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row"><label for="full_biolink"><?php _e('Full Bio Button',SPEAKER_SLUG);?></label></th>
                        <td>
                            <input name="full_biolink" type="text" value="<?php echo (isset($settings['full_biolink']) ? ($settings['full_biolink'] ? intval($settings['full_biolink']) : '#333333' ) : '#333333'); ?>"  class="tlp-color"> 
                        </td>
                        
                    </tr>

                    <tr>
                        <th scope="row"><label for="text-color"><?php _e('Text Color',SPEAKER_SLUG);?></label></th>
                        <td class="">
                            <div class="settingCss">
                                <span>Speaker Name</span>
                                <span>Speaker Role</span>
                                <span>Speaker Organisation</span>
                                <span>Speaker Description</span>
                            </div>
                            <span style="display:block;">
                                <input name="heading_color" id="text_color" type="text" value="<?php echo (isset($settings['heading_color']) ? ($settings['heading_color'] ? $settings['heading_color'] : '#000') : '#000'); ?>" class="tlp-color">
                                <input name="desg_color" id="text_color" type="text" value="<?php echo (isset($settings['desg_color']) ? ($settings['desg_color'] ? $settings['desg_color'] : '#333') : '#333'); ?>" class="tlp-color">
                                <input name="org_color" id="text_color" type="text" value="<?php echo (isset($settings['org_color']) ? ($settings['org_color'] ? $settings['org_color'] : '#333') : '#333'); ?>" class="tlp-color">
                                <input name="text_color" id="text_color" type="text" value="<?php echo (isset($settings['text_color']) ? ($settings['text_color'] ? $settings['text_color'] : '#000') : '#000'); ?>" class="tlp-color">
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="text-color"><?php _e('Text Size',SPEAKER_SLUG);?></label></th>
                        <td>
                            <span class="asmin-color-three" style="display:block;margin-bottom:8px;">
                                <input name="heading_size" id="text_size" size="10" type="text" value="<?php echo (isset($settings['heading_size']) ? ($settings['heading_size'] ? $settings['heading_size'] : '20px') : '20px'); ?>">
                                 <input name="desg_size" id="text_size" size="10" type="text" value="<?php echo (isset($settings['desg_size']) ? ($settings['desg_size'] ? $settings['desg_size'] : '15px') : '15px'); ?>">
                                <input name="org_size" id="text_size" size="10" type="text" value="<?php echo (isset($settings['org_size']) ? ($settings['org_size'] ? $settings['org_size'] : '15px') : '15px'); ?>">
                                <input name="text_size" id="text_size" size="10" type="text" value="<?php echo (isset($settings['text_size']) ? ($settings['text_size'] ? $settings['text_size'] : '15px') : '15px'); ?>">
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="text-color"><?php _e('Text Align',SPEAKER_SLUG);?></label></th> 
                        <td>
                            <span class="asmin-color-three" style="display:block;">
                                <input name="heading_align" size="10" id="text_align" type="text" value="<?php echo (isset($settings['heading_align']) ? ($settings['heading_align'] ? $settings['heading_align'] : 'none') : 'none'); ?>">
                                <input name="desg_align" id="text_align" size="10" type="text" value="<?php echo (isset($settings['desg_align']) ? ($settings['desg_align'] ? $settings['desg_align'] : 'none') : 'none'); ?>">
                                <input name="org_align" id="text_align" size="10" type="text" value="<?php echo (isset($settings['org_align']) ? ($settings['org_align'] ? $settings['org_align'] : 'none') : 'none'); ?>">
                                <input name="text_align" id="text_align" size="10" type="text" value="<?php echo (isset($settings['text_align']) ? ($settings['text_align'] ? $settings['text_align'] : 'none') : 'none'); ?>">
                            </span>  
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="text-color"><?php _e('Text Style',SPEAKER_SLUG);?></label></th>
                        <td>
                            <span class="asmin-color-three" style="display:block;">
                                 <select name="textstylehead" id="textstylehead" type="text"
                                        value="<?php echo(isset($settings['textstylehead']) ? ($settings['textstylehead'] ? $settings['textstylehead'] : 'normal') : 'normal'); ?>">
                                    <option value="normal">select</option>
                                    <option value="bold">bold</option>
                                    <option value="italic">italic</option>
                                    <option value="underline">underline</option>
                                </select>
                                <select name="textstyledesg" id="textstyledesg" type="text"
                                        value="<?php echo(isset($settings['textstyledesg']) ? ($settings['textstyledesg'] ? $settings['textstyledesg'] : 'normal') : 'normal'); ?>">
                                    <option value="normal">select</option>
                                    <option value="bold">bold</option>
                                    <option value="italic">italic</option>
                                    <option value="underline">underline</option>
                                </select>
                                 <select name="textstyleorg" id="textstyleorg" type="text"
                                        value="<?php echo(isset($settings['textstyleorg']) ? ($settings['textstyleorg'] ? $settings['textstyleorg'] : 'normal') : 'normal'); ?>">
                                    <option value="normal">select</option>
                                    <option value="bold">bold</option>
                                    <option value="italic">italic</option>
                                    <option value="underline">underline</option>
                                </select>
                                 <select name="textstyledesc" id="textstyledesc" type="text"
                                        value="<?php echo(isset($settings['textstyledesc']) ? ($settings['textstyledesc'] ? $settings['textstyledesc'] : 'normal') : 'normal'); ?>">
                                    <option value="normal">select</option>
                                    <option value="bold">bold</option>
                                    <option value="italic">italic</option>
                                    <option value="underline">underline</option>
                                </select>
                            </span>
                        </td>
                    </tr>


                    <tr>
                        <th scope="row"><label for="display"><?php _e('Show/Hide',SPEAKER_SLUG);?></label></th>
                        <td class="">
                             <span style="display:block;">
                                <input name="heading_display" size="10" id="text_align" type="text" value="<?php echo (isset($settings['heading_display']) ? ($settings['heading_display'] ? $settings['heading_display'] : 'show') : 'show'); ?>">
                                <input name="desg_display" id="text_align" size="10" type="text" value="<?php echo (isset($settings['desg_display']) ? ($settings['desg_display'] ? $settings['desg_display'] : 'show') : 'show'); ?>">
                                <input name="org_display" id="text_align" size="10" type="text" value="<?php echo (isset($settings['org_display']) ? ($settings['org_display'] ? $settings['org_display'] : 'show') : 'show'); ?>">
                                <input name="text_display" id="text_align" size="10" type="text" value="<?php echo (isset($settings['text_display']) ? ($settings['text_display'] ? $settings['text_display'] : 'show') : 'show'); ?>">
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row"><label for="link_detail_page"><?php _e('Link To Detail Page',SPEAKER_SLUG);?></label></th>
                        <td class="">
                            <fieldset>
                                <legend class="screen-reader-text"><span>Link To Detail Page</span></legend>
                                <?php
                                $opt = array('yes'=>"Yes", 'no'=>"No");
                                $i = 0;
                                $pds = (isset($settings['link_detail_page']) ? ($settings['link_detail_page'] ? $settings['link_detail_page'] : 'yes') : 'yes');
                                foreach ($opt as $key => $value) {
                                    $select = (($pds == $key) ? 'checked="checked"' : null);
                                    echo "<label title='$value'><input type='radio' $select name='link_detail_page' value='$key' > $value</label>";
                                    if($i == 0) echo "<br>";
                                    $i++;
                                }
                                ?>
                            </fieldset>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row"><label for="grid"><?php _e('Grid Margin',SPEAKER_SLUG);?></label></th>
                        <td class="">
                            <input name="grid" id="grid" type="text" value="<?php echo (isset($settings['grid']) ? ($settings['grid'] ? sanitize_title_with_dashes($settings['grid']) : '15px' ) : '15px'); ?>" size="15" class="">
                            <p class="description"><?php _e('Grid Margin',SPEAKER_SLUG);?></p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row"><label for="css"><?php _e('Custom Css ',SPEAKER_SLUG);?></label></th>
                        <td>
                            <textarea name="custom_css" cols="40" rows="6"><?php echo (isset($settings['custom_css']) ? ($settings['custom_css'] ? $settings['custom_css'] : null) : null); ?></textarea>
                        </td>
                    </tr>

                </table>
                <p class="submit"><input type="submit" name="submit" id="tlpSaveButton" class="button button-primary" value="<?php _e('Save Changes', SPEAKER_SLUG); ?>"></p>

                <?php wp_nonce_field( $Speaker->nonceText(), 'speaker_nonce' ); ?>
            </form>

            <div id="response" class="updated"></div>
        </div>
    </div>

    <div class="tlp-help">
        <p style="font-weight: bold"><?php _e('Short Code', SPEAKER_SLUG );?> :</p>
        <p>[speakers col="2" speaker="4" orderby="organisation" order="ASC" layout="1"]</p><br>
        <p><?php _e('col = The number of column you want to create (1,2,3,4)', SPEAKER_SLUG );?></p>
        <p><?php _e('speaker = The number of the speaker, you want to display per page', SPEAKER_SLUG );?></p>
        <p><?php _e('orderby = Orderby (organisation , designation, Speaker_event, Speakerevent_date)', SPEAKER_SLUG );?></p>
        <p><?php _e('ordr = ASC, DESC', SPEAKER_SLUG );?></p>
        <p><?php _e('layout = 1,2,3,isotope,Carousel', SPEAKER_SLUG );?></p></br></br>

        <h3>For Specific Speaker or Event:</h3>
        <p>[speakerinfo col="2" speaker="Thomos" orderby="title" order="ASC" layout="1"]</p><br>
        <p><?php _e('col = The number of column you want to create (1,2,3,4)', SPEAKER_SLUG );?></p>
        <p><?php _e('speaker = The name of the speaker, you want to display | event= All speakers from specific event', SPEAKER_SLUG );?></p>
        <p><?php _e('layout = 1,2,3,isotope', SPEAKER_SLUG );?></p>
    </div>

    <div class="tlp-help">
        <p style="font-weight: bold"><?php _e('Getting Started:', AGENDA_SLUG); ?> :</p><br>
        <h3>Adding Speakers</h3>
        <p>Click the “Add Speaker” link in the left hand menu.  Add information and save.</p><br>
        <h3>Displaying your Speakers in a Post of Page</h3>
        <p>To display your speakers you will need to add a ‘shortcode’ to the page or post in the location where you want the speakers to show.  This short code will look something like this:</p>
        <code>[speaker]</code>
        <p>This will give you a basic display of all the speakers you have created.  However, you can refine the shortcode using some additional options to control the final display.  This is what your shortcode may look like once you have added these settings:</p>
        <code>[speaker col=”2” speaker=”4” orderby=”title” order=”ASC” layout=”1”]</code>
        <p>The shortcode contains a number of optional elements that allow you to control the appearance of the speakers section.  These options are:</p>
        <ul>
        <li>col = The number of columns you want to create (eg. 1, 2, 3, 4)</li>
        <li>speaker = The number of the speakers, you want to display (eg. 1, 5, 13 etc)</li>
        <li>orderby = Orderby (title , date, menu_order)</li>
        <li>ordr = ASC, DESC </li>
        <li>layout = the layout template you want to use.  By default you can choose from  “1”, “2”, “3” and “isotope” (1 is a portrait type display with pictures at the top, 2 is a landscape display with picture in a circle, 3 is a landscape display with square picture, isotope is displays pictures only with mouse over text appearing but the order can be sorted by options selected at the top of the page).  Options 2 and 3 also allow you to displat logos in addtion to the speaker’s picture.</li> </ul><br>

        <h3>Changing colours, fonts, etc. in your design template</h3>
        <p>On the ‘Settings’ tab in the left hand menu you can change the appearance of many elements of the speaker profiles.</p>  
        <ul>
        <li>Primary Colour:  Select from pallatte or imput a hex value.</li>
        <li>Square/Rounded Image:  Set a percentage eg 10% </li>
        <li>Image size: Imput pixel size required eg: 200 - note that in some templates the number of columns required may mean this setting is disregarded.</li> 
        <li>Image boder:  You can set the line type, pixel width and colour - eg “Solid 1pt grey” [what are the options?] </li>
        <li>Text options:  Select a colour, Size (eg. “12pt”) and alignment (eg. “left”, “right”, “center”, “none”)</li>
        <li>Show or hide text: toggle between the “show” and “hide” options for each element.</li>
        <li>Slug: speaker</li>
        <li>Link to Detail Page:  Enable links to full page biographical details from some templates </li>
        <li>Custom CSS: Add CSS part with classname you want.</li>
        <li>Save changes:  Don’t forget!</li>
        </ul>
    </div>

</div>
