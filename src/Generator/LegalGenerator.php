<?php

namespace Drupal\legalgen\Generator;

use \Drupal\node\Entity\Node;
use \Drupal\Core\StringTranslation\TranslatableMarkup;
use Symfony\Component\Yaml\Yaml;


class LegalGenerator {

   /**
   * Checks if All Values Required for Page Generation Were Passed and are Valid
   *
   * @param array $data An Array containing all Key Value Pairs as Handed Over During Form Submission.
   * @param string $title Title of the Page to be Generated.
   * @param string $alias URL Alias for the Page to be Generated.
   * @param string $page_type The type of Page (either 'legal_notice', 'accessibility' or 'privacy').
   * @param string $lang Language in which the Page should be Generated.
   * @param array $state_keys_lang Array with the Keys for all Language Specific Values.
   * @param array $state_keys_intl Array Containing Solely the Keys for All not Language Specific Values.
   *
   * @return string or NULL An Error Message Specifying why the Page Cannot be Generated.
   *
   */
  public function validateBeforeGeneration(array $data, string $title, string $alias, string $page_type, string $lang, array $state_keys_lang, array $state_keys_intl): string|NULL {

    // Check That Title and Alias Are NOT Empty
    if($title === ''){
      return 'No title specified';

    } else if ($alias === ''){
      return 'No alias specified';
    }

    // Validate Language
    $valid_lang = \Drupal::service('legalgen.generator')->validateLang($lang);

    // If Language is NOT Valid Return Error Message
    if($valid_lang === 'Not configured'){
      return 'Generation for this Language NOT configured';
    } else if ($valid_lang === 'Empty') {
      return 'NO language specified';
    }


    // If Page Name Is Valid Return Required Key to Check Arrays
    $required_key = \Drupal::service('legalgen.generator')->validatePage($page_type);

    // If Page Name NOT Valid Return Error Message
    if($required_key === NULL){
        return 'Page type NOT available';
    }


    // If Template Does NOT Exist Return Error Message
    $template_exists = \Drupal::service('legalgen.generator')->validateTemplate($page_type, $lang);
    if($template_exists === FALSE ){
        return 'Template NOT available';
    }


    // If One or More Keys Invalid Return Names of Those Keys
    $invalid_keys = \Drupal::service('legalgen.generator')->validateKeys($required_key, $lang, $state_keys_lang, $state_keys_intl);
    if(!empty($invalid_keys)){
        return 'Required key(s) missing from state_keys array(s): '.$invalid_keys;
    }


    // If Values in Data Array Invalid Return Keys for Those Values
    $invalid_data = \Drupal::service('legalgen.generator')->validateData($data, $required_key, $title, $alias, $page_type, $lang);
    if(!empty($invalid_data)){
        return $invalid_data;
    }

    return NULL;
  }

  /**
   * Checks Whether All Email Addresses are Formatted Correctly.
   *
   * @param array $data
   * @param string $page_type Type of the Page to be Generated.
   *
   * @return string Either an Error Message Indicating the Email Addresses with Incorrect Format or an Empty String in Case All Emails are Fromatted Correctly.
   *
   */
  function validateEmail(array $data, string $page_type): string {

    $file_path = dirname(__FILE__) . '/../../legalgen.required.and.email.yml';
    $file_contents = file_get_contents($file_path);
    $ymldata = Yaml::parse($file_contents);

    $email_keys = $ymldata['KEYS_EMAIL_VALUES'];

    $to_check = $email_keys[$page_type];

    $wrong_email = [];

    for($i = 0; $i < count($to_check); $i++){

      $mail_current = $to_check[$i];

      $mail_value = $data[$mail_current];

      if(!filter_var($mail_value, FILTER_VALIDATE_EMAIL)) {
          array_push($wrong_email, $mail_current);
      };
    }

    if(!empty($wrong_email)){

      return 'Format for e-mail(s) incorrect: '.(implode(", ", $wrong_email));
    } else {
      return '';
    }

  }


  /**
   * Checks if a Valid Language was Passed.
   *
   * @param string $lang The Language in Which the Page Should be Generated.
   *
   * @return string Either a String Informing the User that the Language has not been Configured or an Empty String in Case the Language is Valid.
   */
  function validateLang(string $lang): string {

    // 1) Ensure Language is NOT Empty
    if(empty($lang)){
      return 'Empty';
    }


    // 2) Ensure that Language is Defined in Config
    // Get Languages from Config
    $options = \Drupal::configFactory()->get('legalgen.languages')->getRawData();

    // Remove '_core' from Array
    unset($options['_core']);

    // Check if Language is Configured
    $key_exists = array_key_exists($lang, $options);

    // Condition(Language NOT Specified in Config: Return Error Message Generation for Language NOT Possible
    if(!$key_exists){
        return 'Not configured';
    } else {
        return '';
    }
  }


  /**
   * Checks if a Valid Page Type is Used for Generation.
   *
   * @param string $page_type Type of Page to be Generated.
   *
   * @return string or NULL In Case the Page Type is Valid, the Key to Access the Respective Required Values Array, Else Returns NULL.
   */
  function validatePage(string $page_type): string|NULL {

    // 1) Check if Page Name is Valid
    // Get Key to Access Required Data and Default Data for Page Type
    if($page_type === 'legal_notice'){
        return 'REQUIRED_LEGALNOTICE';

    } else if ($page_type === 'accessibility'){
        return'REQUIRED_ACCESSIBILITY';

    } else if ($page_type === 'privacy'){
        return 'REQUIRED_PRIVACY';

    } else {
        // No Such Page Available
        return NULL;
    }
  }


  /**
   * Checks if Template for Page to be Generated Exits in Language Specified.
   *
   * @param string $page_type Type of the Page to be Generated.
   * @param string $lang Language of the Page to be Generated.
   *
   * @return bool Either TRUE if Template Exits or FALSE if it does not exist.
   */
  function validateTemplate(string $page_type, string $lang): bool {


    // Get Languages from Config
    $options = \Drupal::configFactory()->get('legalgen.languages')->getRawData();

    // Get Template File Name from Config
    $template_name = $options[$lang][$page_type];

    // Switch _ with -
    $templ_name = str_replace('_', '-', $template_name);

    // Check if File Exits in Templates Folder
    $file_exists = file_exists(dirname(__FILE__) . '/../../templates/'.$templ_name.'.html.twig');

    // Condition(Template File Does NOT Exist): Return Egror Message Template NOT Available
    if(!$file_exists){

        // Clear File Status Cache if Entered Condition
        clearstatcache();

        return FALSE;

    } else {

        // Clear File Status Cache if Did not Enter Condition Above
        clearstatcache();
        return TRUE;
    }
  }


  /**
   * Checks if All Keys Required for Page Generation Were Passed.
   *
   * @param string $required_key Key to Access Array Specifying which Values are Required for Page Generation.
   * @param string $lang Language in which the Page Should be Generated.
   * @param array $state_keys_lang Contains the Keys for all Language Specific Values.
   * @param array $state_keys_intl Contains the Keys for all non Language Specific Values.
   *
   * @return string Either a String containing all Required Keys Missing in the Key Arrays or an Empty String in Case all required Keys are Available.
   */
  function validateKeys(string $required_key, string $lang, array $state_keys_lang, array $state_keys_intl): string {

    // Get Required Keys from YAML File
    $file_path = dirname(__FILE__) . '/../../legalgen.required.and.email.yml';
    $file_contents = file_get_contents($file_path);
    $ymldata = Yaml::parse($file_contents);

    $required_lang = $ymldata[$required_key][$lang];
    $required_intl = $ymldata[$required_key]['intl'];


    // Empty Array to Store Missing/Empty Required Values
    $missing_keys = [];

    // 1) Lang Array
    foreach ($required_lang as $req_k => $va){
      $required_key_in_lang = array_key_exists($req_k, $state_keys_lang);

      if($required_key_in_lang === FALSE){
      }



        if($required_key_in_lang === FALSE and $req_k !== 'title' and $req_k !== 'alias'){
            array_push($missing_keys, $req_k);
        }
    }

    // 2) Intl Array
    foreach ($required_intl as $req_key => $var){
      $required_key_in_intl = array_key_exists($req_key, $state_keys_intl);

    if($required_key_in_intl === FALSE and $req_key !== 'title' and $req_key !== 'alias'){
        array_push($missing_keys, $req_key);
        }
    }

    return implode(", ", $missing_keys);
  }


  /**
   * Checks if All Values Required for Page Generation Were Passed and Are Valid.
   *
   * @param array $data Contains all Data Submitted During Form Submission.
   * @param string $required_key Key to Access the Array with All Required Keys.
   * @param string $title Title of the Page to be Generated.
   * @param string $alias URL Alias for the Page to be Generated.
   * @param string $page_type Type of the Page to be Generated.
   * @param string $lang Language in which the Page Should be Generated.
   *
   * @return string
   */
  function validateData(array $data, string $required_key, string $title, string $alias, string $page_type, string $lang) : string {

    // Empty Array to Store Missing/Empty Required Values
    $missing_values = [];

    $missing_keys = [];

    // Get Required Keys from YAML File
    $file_path = dirname(__FILE__) . '/../../legalgen.required.and.email.yml';
    $file_contents = file_get_contents($file_path);
    $ymldata = Yaml::parse($file_contents);

    $required_lang = $ymldata[$required_key][$lang];
    $required_intl = $ymldata[$required_key]['intl'];

    // Merge Language-Specific and International Array
    $required = array_merge($required_lang, $required_intl);

    // Loop Over Required Array: Check if Value Exists and Not Empty
    foreach ($required as $k => $v){

      $required_key_in_data = array_key_exists($k, $data);

      // Add to Missing Values if Key from Required Array not in Data and is NOT Title and is NOT Alias
      if($required_key_in_data === FALSE and $k !== 'title' and $k !== 'alias'){

        // Condition( Status = "Completely compliant"): Skip Issues, Statement and Alternatives, as Those Arrays Do NOT Need to Contain Information in This Case
        if($page_type === 'accessibility'){

          if($k === 'issues_array' or $k === 'justification_array' or $k === 'alternatives_array'){

            if ($required['status'] === 'Completely compliant'){
              continue;
            }
          }
        }
        // Add Empty/Missing to Array
        array_push($missing_keys, $k);
        continue;
      } else if ($required_key_in_data === TRUE){

        if(empty($data[$k])){
          array_push($missing_values, $k);
          continue;
        }
      }

      continue;
    }


    // Check if All Conditionally Required Values Are Provided

    // For Legal Notice
    if($page_type === 'legal_notice'){

      // Condition (Default Text Should NOT Be Displayed && Custom Text Empty)
      if ($data['no_default_txt'] == TRUE and $data['custom_licence_txt'] === '') {
        array_push($missing_values, 'custom_licence_txt');
      }

      // Condition (Licence URL Given but NO Licence Title)
      if (!empty($data['licence_url']) and empty($data['licence_title'])) {
        array_push($missing_values, 'licence_title');
      }
    }

    // For Privacy
    if($page_type === 'privacy'){

      // Condition (3rd Party Service Provider is Named): Legal Information on Data Collection is Provided
      if(!empty($data['third_service_provider'])){

        // List of Keys for Required Values if 3rd Party Service Provider
        $required_vals = ['third_service_description_data_collection', 'third_service_legal_basis_data_collection', 'third_service_objection_data_collection'];

        foreach ($required_vals as $k){

          // Check if Required Key in Data Array
          $required_key_in_data = array_key_exists($k, $data);

          // Key NOT in Data Array
          if($required_key_in_data === FALSE){

            array_push($missing_values, $k);

          // Key IS in Data Array but has NO Value
          } else {
            if(empty($data[$k])){
              array_push($missing_values, $k);
            }
          }
        }
      }
    }
    // Convert Missing Keys to String and Add Error Message
    if(!empty($missing_keys)){
      $missingData = 'Required key value pair(s) missing from data array: '.implode(", ", $missing_keys).'. ';
    } else {
      $missingData = '';
    }

    // Convert Missing Values to String and Add Error Message
    if(!empty($missing_values)){
      $missingData = $missingData.'Required value(s) empty in data array: '.implode(", ", $missing_values).'.';
    } else {
      $missingData = $missingData.'';
    }

    return $missingData;
  }



  public $template;


  /**
   * Generates Node if None Exists Yet.
   *
   * @param string $title Title of the Page to be Generated.
   * @param string $alias URL Alias for the Page to be Generated.
   * @param object $body Rendered Page Body.
   * @param string $lang Language in which the Page Should be Generated.
   *
   * @return Node Node Generated with Data Received Upon Submit.
   */
  function generateNode(string $title, string $alias, object $body, string $lang): Node {

    $node = Node::create([
        'type'    => 'page',
        'title'   => t($title),
        'activeLangcode' => $lang,
        'body'    => array(
            'value'     => $body,
            'format'    => 'full_html',
          ),
        // Set Alias for Page
        'path'     => array('alias' => "/$alias"),
      ]);

      // Save and Pass on Changes
      $node->save();
      return $node;

  }


  /**
   * Updates an Already Existing Node.
   *
   * @param string $title Title for the Page to be Updated.
   * @param string $alias URL Alias for the Page to be Updated.
   * @param object $body Rendered Page Body.
   * @param Node $node Node after Updating the Default Language Page.
   *
   * @return string
   */
  function updateNode (string $title, string $alias, object $body, Node $node): string {


    // Update Values for Body
    $node-> title =  $title;
    $node->set('body', array(
      'value' => $body,
      'format'  => 'full_html',
    ));
    
    // Update Value for Path
    $node->set('path', array(
      'alias' => "/$alias",
    ));
    
    // Save and Pass on Changes
    $node->save();
    $node_id = $node->id();
    return $node_id;

  }


  /**
   * Generates a Translation for Already Existing Node that Does Not Have a Translation in the Specified Language Yet.
   *
   * @param string $title Title of the Page to be Generated
   * @param string $alias URL Alias for the Page to be Generated.
   * @param object $body Rendered Page Body.
   * @param string $lang Language for the Translation to be Generated.
   * @param Node $node Node After Specified Translation was Generated.
   *
   * @return string
   */
  function generateTranslation(string $title, string $alias, object $body, string $lang, Node $node): string {

        // Create Non Default Language Page
        $node_trans = $node->addTranslation($lang);

        $node_trans->path->alias = $alias;
        $node_trans->title = $title;
        $node_trans->body->value = $body;
        $node_trans->body->format = 'full_html';


        //Save Translation to Node
        $node_trans->save();

        // Get Translation Created
        $exist_trans = $node->getTranslation($lang);

        // Update Path
        $exist_trans->set('path', array(
        'alias' => "/$alias",
        ));

        // Save and Pass on Changes
        $exist_trans->save();
        $node_id = $node->id();

      return $node_id;
  }

  /**
   * Updates an Already Existing Translation in the Specified Language.
   *
   * @param string $title Title of the Page to be Updated.
   * @param string $alias URL Alias for the Page to be Updated.
   * @param object $body Rendered Page Body.
   * @param string $lang Language of the Page to be Updated.
   * @param Node $node Node After Updating the Translation Specified.
   *
   * @return string
   */
  function updateTranslation (string $title, string $alias, object $body, string $lang, Node $node): string {

      // Access Available Translation in Specified Language
      $exist_trans = $node->getTranslation($lang);

      // Update Body
      $exist_trans-> title =  $title;
      $exist_trans->set('body', array(
        'value' => $body,
        'format'  => 'full_html',
      ));

      // Update Path
      $exist_trans->set('path', array(
        'alias' => "/$alias",
      ));

      // Save and Pass on Changes
      $exist_trans->save();
      $node_id = $exist_trans->id();

    return $node_id;
  }


  /**
   * Generates an Empty Default Language Page in Order to Allow for a Translation in the Specified Language to be Generated. This "Placeholder" Page will Display Information as Specified in the Config Letting the
   * User Know that a Page in this Language Does Currently not Exist.
   *
   * @param string $default_lang Language Code for the Default Language.
   * @param string $required_key Key to Access the Array with all Keys for Required Values.
   * @param string $page_type Type of the Page to be Generated (either 'legal_notice', 'accessibility', or 'privacy').
   *
   * @return Node The Default Language Node on which the Translation Will be Saved.
   */
  function generateEmptyDefault(string $default_lang, string $required_key, string $page_type): Node {

    // Access Data from Config
    $config = \Drupal::configFactory()->get('legalgen.languages')->getRawData();

    // Get "Empty" Text from Config
    $text = $config[$default_lang]['empty_text'];

    // Get Required Values from State
    $state_key = 'legalgen.'.$page_type;
    $stored_values = \Drupal::state()->get($state_key);

    // Get Default Values from YAML File
    $file_path = dirname(__FILE__) . '/../../legalgen.required.and.email.yml';
    $file_contents = file_get_contents($file_path);
    $ymldata = Yaml::parse($file_contents);

    $default_values = $ymldata[$required_key][$default_lang];

    $title = $stored_values[$default_lang]['title'] ?? $default_values['title'];

    // Alias is Stored in Subarray in YAML File ($default_values), Ensure to only get String for Page Generation
    $alias = $stored_values[$default_lang]['alias'] ?? $default_values['alias']['name'];

    // Generate Page Displaying "Empty" Info
    $node = Node::create([
      'type'    => 'page',
      'title'   => t($title),
      'activeLangcode' => $default_lang,
      'body'    => array(
          //'summary' => "this is the summary",
          'value'     => $text,
          'format'    => 'full_html',
        ),
      // Set Alias for Page
      'path'     => array('alias' => "/$alias']"),
    ]);

    // Save Changes and Pass on ID
    $node->save();

    return $node;

  }


  /**
   * Checks if the Node Already Exists and Generates the Respective Page(s) Calling the Appropriate Functions Specified in this File.
   *
   * @param string $title Title of the Page to be Generated.
   * @param string $alias URL Alias for the Page to be Generated.
   * @param object $body Rendered Page Body.
   * @param string $lang Language in which the Page Should be Generated.
   * @param string $overwrite Value Indicating whether the "Allow Overwriting Existing Page" Checkbox is Ticked.
   * @param string $page_type Type of the Page to be Generated.
   * @param $node Node for which to Check whether the Spacified Page Does Exist.
   *
   * @return array or NULL In Case the Generation/Update of the Page was Successful, an Array Containing the Node ID and an Empty String, Else the Node ID and a String Indicating the Reason why the Generation/Update was not
   * Successful.
   */
  function checkPage (string $title, string $alias, object $body, string $lang, string $overwrite, string $page_type, $node): array|NULL {

    // Get Default Language
    $default_lang =  \Drupal::languageManager()->getDefaultLanguage()->getId();


    // 1) NO NODE

    if ($node === NULL){

      // A) Generate Default Language Page
      if ($lang === $default_lang){

        $node_id = $this->generateNode($title, $alias, $body, $default_lang)->id();

        // Return Node ID and Info for User Message
        return [$node_id, ''];

      } else {

      // B) Generate NON Default Language

        // a) Generate Empty Default Lang
        $required_key = \Drupal::service('legalgen.generator')->validatePage($page_type);

        $node = $this->generateEmptyDefault($default_lang, $required_key, $page_type);


        // b) Generate Non Default Lang
        $this->generateTranslation($title, $alias, $body, $lang, $node);

        // Return Node ID and Info for User Message
        return [$node->id(), 'Empty Default'];

      }
    } else {
  
    // 2) NODE EXISTS

      // A) Overwrite NOT Ticked
      if ($overwrite == FALSE){

        if($lang === $default_lang){

          // Return Node ID and Info for User Message
          return [$node->id(), 'No Overwrite'];

        } else {

          $trans_exist = $node->hasTranslation($lang);
          // a) Translation Exists
          if($trans_exist){

            // Return Node ID and Info for User Message
            return [$node->id(), 'No Overwrite'];

          // b) Translation Does NOT Exist
          } else {

            // Generate Translation
            $node_id = $this->generateTranslation($title, $alias, $body, $lang, $node);

            // Return Node ID and Info for User Message
            return [$node_id, ''];
          }
        }

      } else {

      // B) Overwrite Ticked

        // a) Default Language

        if ($lang === $default_lang){

          $node_id = $this->updateNode($title, $alias, $body, $node);

          // Return Node ID and Info for User Message
          return [$node_id, ''];

        } else {

          // b) NOT Default Language

          $trans_exist = $node->hasTranslation($lang);


          // i) NO Translation Exists

          if(!$trans_exist){

            $node_id = $this->generateTranslation($title, $alias, $body, $lang, $node);

            // Return Node ID and Info for User Message
            return [$node_id, ''];

          } else {

            // ii) Translation Exists

            $node_id = $this->updateTranslation($title, $alias, $body, $lang, $node);

            // Return Node ID and Info for User Message
            return [$node_id, ''];
          }
        }
      }
    }
  }


  /**
   * Checks the Validity of the Values Passed from the Form and if Valid Prepares the Body, Generates the Page and Stores the Passed Values in State. Thereinafter Displays a Status or Error Message to
   * the User. In Case at Least One Value Passed is not Valid, Generation will be not be Executed and an Error Message Indicating the Issues is displayed to the User.
   *
   * @param array $data Contains all Data as Recorded and Submitted by the User.
   * @param string $title Title of the Page to be Generated.
   * @param string $alias URL Alias for the Page to be Generated.
   * @param string $page_type Type of the Page to be Generated.
   * @param string $lang Language in which the Page Should be Generated.
   * @param array $state_keys_lang Contains all Keys Pertaining to Language Specific Values.
   * @param array $state_keys_intl Contains all Keys for Non Language Specific Values.
   */
  public function generatePage(array $data, string $title, string $alias, string $page_type, string $lang, array $state_keys_lang, array $state_keys_intl) {

    // Check That All Required Values Are Available
    $validated = \Drupal::service('legalgen.generator')->validateBeforeGeneration($data, $title, $alias, $page_type, $lang, $state_keys_lang, $state_keys_intl);

    if($validated == NULL){

      // Get Info from Config
      $config_langs = \Drupal::configFactory()->get('legalgen.languages')->getRawData();

      // Get Template Name from Config
      $templ1 = $config_langs[$lang][$page_type];

      // Populate Template with Form Data from Data Array
      $template = ['#theme' => $templ1];
      foreach ($data as $key => $val) {
        $new_key = "#{$key}";
        $template[$new_key] = $val;
      }

      // Delete Language and Overwrite from Template
      unset($template['#lang']);
      unset($template['#overwrite']);

      // Render Page Body
      $body = \Drupal::service('renderer')->renderPlain($template);

      // Access Page Info from State
      $state_of_page = 'legalgen.'.$page_type;
      $state_vals = \Drupal::state()->get($state_of_page);

      // Get Node ID from State if Available
      if(!empty($state_vals)){

        $nid = (string) $state_vals['node_id'];

        $node = Node::load($nid);

        } else {
          $node = NULL;
      }

      // Generate or Update Page According to Circumstances
      $pageArray = $this->checkPage($title, $alias, $body, $lang, $data['overwrite_consent'], $page_type, $node);

      // Store Info from Page Generation in Variables to Later Display to User
      $node_id = $pageArray[0];
      $userInfo = $pageArray[1];

      // Create Arrays to Store in State
      $to_store_in_state_lang = array($lang => $state_keys_lang);
      $to_store_in_state_intl = array('intl' => $state_keys_intl);
      $state_node = array('node_id' => $node_id);

      // Join Lang and Intl Array (Each is Subarray to Merged Array)
      $merged = array_merge($to_store_in_state_lang, $to_store_in_state_intl);

      // Add Values to Merged Array for Storage in State
      foreach ($merged as $key => $val_array) {
        foreach ($merged[$key] as $k => $v){
          if($k === 'title'){

            // Add Title Value from Variable to Array
            $val_array[$k] = $title;

          }else if($k === 'alias'){

            // Add Alias Value from Variable to Array
            $val_array[$k] = $alias;

          } else if($k === 'support_staff_array'){

            // For Legal Notice: Change Staff Member List Back to String to Correctly Display in Form
            $val_array[$k] = implode("; ", $data[$k]);

          } else if ($k === 'issues_array' or $k === 'justification_array' or $k === 'alternatives_array'){

            // For Accessibility Statement: Change Respective List Back to String to Correctly Display in Form
            $val_array[$k] = implode("; ", $data[$k]);

          }else{
            // Add Value to Sub Array (Either $lang or 'intl')
            $val_array[$k] = $data[$k];
          }
        }
        // Add Values from Subarray (Either $lang or 'intl') to Merged Array
        $merged[$key] = $val_array;
      }

      // Add Node ID to Values Array for State
      $values_stored_in_state = array_merge($merged, $state_node);

      // Condition (Values in State): Combine New Values from User with Values on Other Language Page from State
      if(!empty($state_vals)){

        $state_keys = array_replace($state_vals, $values_stored_in_state);

        // Only Use Values from User (Specific to $lang page)
      } else {

        $state_keys = $values_stored_in_state;

      }

      // Create Multidimensional Array with Page Type Key and Merged Array as Key to Add to State
      $toSaveInState = array($state_of_page => $state_keys);

      // Store Current Language Specific Input in State:
      \Drupal::state()->setMultiple($toSaveInState);


      // Condition (Checkbox Overwrite Was Not Checked): Error Message to User 'Cannot be Overwritten'
      if($userInfo === 'No Overwrite'){

        $text = 'Unfortunately an error ocurred: Page already exists and cannot be overwritten<br/>Overwriting was not permitted by user (Checkbox above "Generate" button NOT checked)';
        $rendered_text = \Drupal\Core\Render\Markup::create($text);
        $error_message = new TranslatableMarkup ('@message', array('@message' => $rendered_text));


        \Drupal::messenger()->addError($error_message, 'status', TRUE);


      } else {

        $node = Node::load($node_id);

        // Condition (Empty Default Page was Generated): Status Message to User 'Empty Page'
        if($userInfo === 'Empty Default'){

          $default_lang =  \Drupal::languageManager()->getDefaultLanguage()->getId();

          $url_object = $node->toUrl();
          $url_string = $url_object->toString();

          $message = t('<a href=":href" target="_blank" rel="noopener noreferer">Empty default language page created</a> ('.$default_lang.') <b>Please ensure to manually generate this page again after entering all required values</b>', array(':href' => $url_string));

          \Drupal::messenger()->addStatus($message, 'status', TRUE);

        }

        // Display Success Messages:
        $lang_object = $node->getTranslation($lang);

        $url_object = $lang_object->toUrl();
        $url_string = $url_object->toString();

        $message = t('<a href=":href" target="_blank" rel="noopener noreferer">Page generated successfully</a>'.' ('.$lang.')', array(':href' => $url_string));

        \Drupal::messenger()->addStatus($message, 'status', TRUE);

    }

  } else {
    // Error Message to User: Invalid Value(s) Given
    \Drupal::messenger()->addError('Unable to generate page! '.$validated, 'status', TRUE);
  }
  }
}