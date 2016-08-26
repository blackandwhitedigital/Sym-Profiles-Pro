<?php
global $Speaker;
$settings = get_option($Speaker->options['settings']);
?>
<style type="text/css">
.wrap .tlp-help h3 {
	color: #bf82b9;
	font-weight: bold;
}
</style>
<div class="wrap">  
    <div class="tlp-help">
        <p style="font-weight: bold">
          <?php _e('Getting Started:', AGENDA_SLUG); ?>
        </p>
        <br>
        <h3>1. Adding Speakers</h3>
        <p>Click the “Add Speaker” link in the left hand menu.  Add information and save.</p><br>
        <h3>2. Display your Speakers in a Post or Page with a Shortcode</h3>
        <p>To display your speakers you will need to add a ‘shortcode’ to the page or post in the location where you want the speakers to show.  This short code will look something like this:        </p>
        <p><code>[speaker]</code> </p>
        <p>This will give you a basic display of all the speakers you have created.  However, you can refine the shortcode using some additional options to control the final display.  This is what your shortcode may look like once you have added these settings:        </p>
        <p><code>[speaker col=”2” speaker=”4” orderby=”speaker” order=”ASC” layout=”1”]</code>
        </p>
        <p>The shortcode contains a number of optional elements that allow you to control the appearance of the speakers section.  These options are:</p>
        <ul>
        <li><strong>col</strong> = The number of columns you want to create (eg. 1, 2, 3, 4)</li>
        <li><strong>speaker</strong> = The quantity of speaker profiles you want to display (eg. 1, 5, 13 etc)</li>
        <li><strong>orderby</strong> = Orderby (speaker, date, menu_order, role, organisation,Speaker_event, Speakerevent_date)</li>
        <li><strong>ordr</strong> = ASC, DESC </li>
        <li><strong>layout</strong> = the layout template you want to use.  By default you can choose from  “1”, “2”, “3” and “isotope”
        <ul>
          <li>1 is a portrait type display with pictures at the top</li>
            <li>2 is a landscape display with picture in a circle</li>
            <li>3 is a landscape display with square picture</li>
            <li>isotope displays pictures only with mouse over text appearing. The order can be sorted by options selected at the top of the page.  </li>
          </ul>
        </li>
        </ul>
        <p>Options 2 and 3 also allow you to display logos, in addtition to the speaker's picture.</p>
        <p><a href="http://www.blackandwhitedigital.eu/symposium-speaker-profiles-free-template-samples/" target="_blank">You can see examples of each layout here.</a></p>
      <p>&nbsp;</p>
        <h3>3. Settings Options - changing colours, fonts, etc. in your live template</h3>
        <p>Once you have selected a template design you like and include this in the short code (above) you can tweak almost every aspect of this to fit your event's branding and color scheme.</p>
      <p>On the ‘Settings’ tab in the left hand menu you can change the appearance of many elements of the speaker profiles.</p>  
        <ul>
        <li><strong>Primary Color:</strong> Select from palette or imput a hex value.</li>
        <li><strong>Square/Rounded Image:</strong> Set a percentage eg 10% </li>
        <li><strong>Image Size:</strong> Imput pixel size required eg: 200 - note that in some templates the number of columns required may mean this setting is disregarded.</li> 
        <li><strong>Image Border:</strong> You can set the line type, pixel width and color - eg “Solid 1px grey” </li>
        <li><strong>Full Bio Button:</strong> Set the background color for the button</li>
        <li><strong>Text Element Options:</strong> (Speaker Name, Role, Organisation, Description)
          <ul>
            <li><strong>Text Color:</strong> Select a color</li>
            <li><strong>Text Size: </strong>(eg. “12pt”) </li>
            <li><strong>Text Alignment: </strong>(eg. “left”, “right”, “center”, “none”)</li>
            <li><strong>Text Style:</strong> (eg. “bold”, “italic”, “underline”)</li>
            <li><strong>Show or hide text:</strong> toggle between the “show” and “hide” options for each element.</li>
          </ul>
        </li>
        <li><strong>Slug:</strong> Default is &quot;speaker&quot; - used in the shortcode</li>
        <li><strong>Link to Detail Page:</strong> Enable links to full page biographical details from some templates </li>
        <li><strong>Custom CSS:</strong> Add CSS part with the classname you want.</li>
        <li><strong>Save changes:</strong> Don’t forget!</li>
        </ul>
    </div>
    
</div>