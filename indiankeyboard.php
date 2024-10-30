<?php
   /*
   Plugin Name: Indian Keyboard
   Plugin URI: http://www.axonsoft.in/index.php/services/indian-keyboard-wp-plugin
   Description: This Indian Phonetic Keyboard is for WordPress, that enables you to easily type Indian languages with some other foreign languages in WordPress without installing Indian phonetic keyboard in your system. It supports Amharic, Arabic, Bengali, Chinese, Greek, Gujrati, Hindi, Canada, Malayalam, Marathi, Nepali, Odia, Persian, Punjabi, Russian, Sanskrit, Serbian, Sinhalese, Tamil, Telugu, Tigrinya and Urdu language.  
   Version: 1.0
   Author: Binod Narayan Sethi
   Author URI: #
   License: GPL2
   */

define( 'IK_URL', plugins_url( '', __FILE__ ) );

 class indian_keyboard {

  function __construct() {
    add_action( 'wp_loaded', array( $this, 'init') );
  } 

  public function init() {
    add_action( 'admin_init', array( $this, 'add_editor_buttons' ) );
    add_action( 'admin_footer', array( $this, 'popup' ) );
 
  }

   /*
   * Add buttons to TinyMCE
   */
  function add_editor_buttons() {
    // add shortcode button
    add_action( 'media_buttons', array( $this, 'add_keyboard' ), 10 );
  }

  /*
   * Add button to TinyMCE
   */

  public function add_keyboard( $page = null, $target = null ) {
    ?>
      <a href="#TB_inline?width=700&amp;height=600&amp;inlineId=bns-wrap" id="indian_keyboard" class="thickbox button" title="<?php _e( 'Indian Keyboard', IN_TEXTS); ?>" data-page="<?php echo $page; ?>" data-target="<?php echo $target; ?>">
        <img src="<?php echo IK_URL . "/assets/images/in-keyboard.png";?>" alt="" />
      </a> 
    <?php
  }

  /*
   * TB window Popup
   */

  public function popup() {
  ?>
    <div id="bns-wrap" style="display:none">
      <div class="bns">
        <html>
  <head>
  <title>Translation in Indian languages</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <header id="header" class="clearfix" role="banner">
	</header></div>
    <script type="text/javascript" src="https://www.google.com/jsapi">
    </script>
    <script type="text/javascript">
      // Load the Google Transliterate API
      google.load("elements", "1", {
            packages: "transliteration"
          });

      var transliterationControl;
      function onLoad() {
        var options = {
            sourceLanguage: 'en',
            destinationLanguage: ['ar','hi','kn','ml','ta','te'],
            transliterationEnabled: true,
            shortcutKey: 'ctrl+g'
        };
        // Create an instance on TransliterationControl with the required
        // options.
        transliterationControl =
          new google.elements.transliteration.TransliterationControl(options);

        // Enable transliteration in the textfields with the given ids.
        var ids = [ "transl1", "transl2" ];
        transliterationControl.makeTransliteratable(ids);

        // Add the STATE_CHANGED event handler to correcly maintain the state
        // of the checkbox.
        transliterationControl.addEventListener(
            google.elements.transliteration.TransliterationControl.EventType.STATE_CHANGED,
            transliterateStateChangeHandler);

        // Add the SERVER_UNREACHABLE event handler to display an error message
        // if unable to reach the server.
        transliterationControl.addEventListener(
            google.elements.transliteration.TransliterationControl.EventType.SERVER_UNREACHABLE,
            serverUnreachableHandler);

        // Add the SERVER_REACHABLE event handler to remove the error message
        // once the server becomes reachable.
        transliterationControl.addEventListener(
            google.elements.transliteration.TransliterationControl.EventType.SERVER_REACHABLE,
            serverReachableHandler);

        // Set the checkbox to the correct state.
        document.getElementById('checkboxId').checked =
          transliterationControl.isTransliterationEnabled();

        // Populate the language dropdown
        var destinationLanguage =
          transliterationControl.getLanguagePair().destinationLanguage;
        var languageSelect = document.getElementById('languageDropDown');
        var supportedDestinationLanguages =
          google.elements.transliteration.getDestinationLanguages(
            google.elements.transliteration.LanguageCode.ENGLISH);
        for (var lang in supportedDestinationLanguages) {
          var opt = document.createElement('option');
          opt.text = lang;
          opt.value = supportedDestinationLanguages[lang];
          if (destinationLanguage == opt.value) {
            opt.selected = true;
          }
          try {
            languageSelect.add(opt, null);
          } catch (ex) {
            languageSelect.add(opt);
          }
        }
      }

      // Handler for STATE_CHANGED event which makes sure checkbox status
      // reflects the transliteration enabled or disabled status.
      function transliterateStateChangeHandler(e) {
        document.getElementById('checkboxId').checked = e.transliterationEnabled;
      }

      // Handler for checkbox's click event.  Calls toggleTransliteration to toggle
      // the transliteration state.
      function checkboxClickHandler() {
        transliterationControl.toggleTransliteration();
      }

      // Handler for dropdown option change event.  Calls setLanguagePair to
      // set the new language.
      function languageChangeHandler() {
        var dropdown = document.getElementById('languageDropDown');
        transliterationControl.setLanguagePair(
            google.elements.transliteration.LanguageCode.ENGLISH,
            dropdown.options[dropdown.selectedIndex].value);
      }

      // SERVER_UNREACHABLE event handler which displays the error message.
      function serverUnreachableHandler(e) {
        document.getElementById("errorDiv").innerHTML =
            "Transliteration Server unreachable";
      }

      // SERVER_UNREACHABLE event handler which clears the error message.
      function serverReachableHandler(e) {
        document.getElementById("errorDiv").innerHTML = "";
      }
      google.setOnLoadCallback(onLoad);

    </script>
  </head>
  <body>
  <center><font face="Verdana"><b>
	Type in Indian languages (Press Ctrl+g to toggle between English and your 
	native language)</b></font></center>
    <div id='translControl'><p style="text-align: center;">
      <input type="checkbox" id="checkboxId" onclick="javascript:checkboxClickHandler()"></input>
      Type in <select id="languageDropDown" onchange="javascript:languageChangeHandler()"></select> 
     </p></div><p style="text-align: center;">
    Title : <input type='textbox' id="transl1"/>
    <br><b>Converted Text</b><br><textarea id="transl2" style="width:700px;height:180px"></textarea>
    <br><div id="errorDiv"></p></div>
  <h1 align="justify"><font face="Verdana" size="5">Typing in Indian Languages<br>
	</font><font size="5">&nbsp; </font>
	<span style="font-weight: 400"><font face="Verdana" size="3">Its very easy and simple to type in your native language using English. Just type the text in English in the given box and press space, it will convert the text in your native script. Click on a word to see more options. To switch between Indian Languages and English use ctrl + g. Now copy the text and use it anywhere.</font></span></h1>
  </body>
</html>
      </div>
    </div>

    <?php
  }

   /*
   * Plugin Setting (Information) page.
   */
    public function ik_indianwriting_adminpanel(){
  
  }

 public function ik_options_page(){
      ?>
           <?php 
  }

}

new indian_keyboard();