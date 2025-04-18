<?php

namespace Drupal\legalgen\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use \Drupal\node\Entity\Node;
use \Drupal\Core\Url;
use Symfony\Component\Yaml\Yaml;
use \Drupal\Core\Ajax\AjaxResponse;
use \Drupal\Core\Ajax\OpenModalDialogCommand;

/**
 * Configure example settings for this site.
 */
class WissKIPrivacyForm extends FormBase{

  /**
   * @var \Drupal\legalgen\Generator\LegalGenerator
   */
  protected $generator;

  /**
   * {@inheritdoc}
   */
  public function __construct(){
    /** @var \Drupal\legalgen\Generator\LegalGenerator */
    $this->generator = \Drupal::service('legalgen.generator');
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(){
    return self::class;
  }

  /**
   * {@inheritdoc}
   */
  public function getState(){
    return \Drupal::state();
  }

  /**
   * {@inheritdoc}
   *
   * Gets Values Stored in State for this Page Type.
   */
  public function getStateValues(){
    if (!empty(\Drupal::state()->get('legalgen.privacy'))) {
      return \Drupal::state()->get('legalgen.privacy');
    } else {
      return NULL;
    }
  }


  /**
   * {@inheritdoc}
   *
   * Builds the Form to Generate an Accessibility Statement. When Clicking the 'Accessibility' Tab, at First only a Select Object will be displayed asking the User to Choose the Language for which
   * the Form should be displayed. This Selection does not Impact the Form Itself but the Values to be Displayed in the Fields as well as the Generation Upon Clicking "Generate".
   * The Values Shown in the Fields are Retrieved from the State in Case the Form has been Previously Submitted and Values were not Reset. If the State for this Page in the Specified Language is Empty
   * Default Values will be Loaded from required.and.email.yml where Available. All Other Fields will remain empty.
   * Values Required for Page Generation will be Marked as Such based on the required.and.email.yml file.
   *
   * Be Aware that for Some Fields Whether They are Required or not is Implemented Differently Either Through a Condition or #state Directly in the Form.
   *
   * Default Values as well as the State are Accessed Using Keys Hard Coded in this Function.
   *
   * @param array $form
   * @param FormStateInterface $form_state
   */
  public function buildForm(array $form, FormStateInterface $form_state){

    // Fields
    // Type of Render Array Element
    // See https://api.drupal.org/api/drupal/elements/8.2.x for Available Elements

    // Get State Values for Form
    $stored_values = $this->getStateValues();

    $file_path = dirname(__FILE__) . '/../../legalgen.required.and.email.yml';
    $file_contents = file_get_contents($file_path);
    $default_values_all = Yaml::parse($file_contents);
    $default_values = $default_values_all['REQUIRED_PRIVACY'];


    // Get Legal Notice URL from State
    $values_from_legalnotice = \Drupal::state()->get('legalgen.legal_notice');

    // Check if Node Already Exists (Condition for Overwrite Checkbox Display)
    $state_vals = \Drupal::state()->get('legalgen.privacy');

    if(!empty($state_vals)){
        $nid = (string) $state_vals['node_id'];

        $node = Node::load($nid);

    } else {

        $node = NULL;
    }

    $form = [];

    // Get Languages from Config
    $options = \Drupal::configFactory()->get('legalgen.languages')->getRawData();
    unset($options['_core']);

    $lang_options = array();

    foreach ($options as $key => $value) {
      $lang_options[$key] = $value['option'];
    }

    $options = array_merge(["0" => 'Please select'], $lang_options);

    // Field: Language Selector
    $form['Select_Language'] = array(
      '#type'        => 'details',
      '#title'       => t('Language'),
      '#open'        => TRUE,
    );

    $form['Select_Language']['Chosen_Language'] = array(
      '#type'          => 'select',
      '#title'         => t('Choose the language in which the privacy notice should be generated<br /><br />Please note:<br />Changes made here will NOT automatically be applied to already existing pages in other languages. Please make sure to generate them again<br /><br />'),
      '#options'       => $options,
      // Language Selection Triggers AJAX
      '#ajax'          => [
        'callback'        => '::ajaxCallback',
        'event'           => 'change',
        'wrapper'         => 'formDiv',
        'event'           => 'change',
      ],
    );

    // AJAX Form
    $form['Lang_Specific_Form'] = [
      '#type'  => 'item',
      '#prefix' => '<div id="formDiv">',
      '#suffix' => '</div>'
    ];

    $form_state->setRebuild(TRUE);

    $lang = $form_state->getValue('Chosen_Language');

    $input = $form_state->getUserInput();


      // Reset All Form Values EXCEPT Chosen_Language
      $unset_key = array('Title', 'Alias', 'Not_FAU', 'Legal_Notice_URL', 'Security_Official_Title', 'Security_Official_Name', 'Security_Official_Add', 'Security_Official_Address', 'Security_Official_PLZ', 'Security_Official_City', 'Security_Official_Phone', 'Security_Official_Fax', 'Security_Official_Email', 'Third_Service_Provider', 'Third_Service_Description_Data_Collection', 'Third_Service_Legal_Basis_Data_Collection', 'Third_Service_Objection_Data_Collection', 'Data_Commissioner_Title', 'Data_Commissioner_Address', 'Data_Commissioner_PLZ', 'Data_Commissioner_City', 'Date', 'Overwrite_Consent');

      foreach ($unset_key as $key) {
        unset($input[$key]);
      }

      $form_state->setUserInput($input);

      if (empty($lang)) {
        return $form;
      }

      // Error Message: Language Is not Installed in Drupal
      $all_langs = \Drupal::LanguageManager()->getLanguages();

      if(!array_key_exists($lang, $all_langs)){

        $path = '/admin/config/regional/language';

        $message = t('Error: Language not installed ('.$lang.')<br/>Please <a href=":href">go to language settings</a> and add the language to the list', array(':href' => $path));

        \Drupal::messenger()->addError($message, 'status', TRUE);

        return $form;


      } else {


      // Fields: General
      $form['Lang_Specific_Form']['General'] = array(
        '#type'  => 'details',
        '#title' => t('General'),
        '#open'  => TRUE,
      );

        $form['Lang_Specific_Form']['General']['Title'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Page Title'),
          '#id'            => 'title',
        );

        $form['Lang_Specific_Form']['General']['Alias'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Page Alias'),
        );

        $form['Lang_Specific_Form']['General']['Not_FAU'] = array(
          '#type'          => 'textarea',
          '#title'         => t('Information Regarding the Representative Within the Meaning of the General Data Protection Regulation'),
          '#description'   => t('<i>REPLACES FAU-SPECIFIC WITH CUSTOM TEXT. LEAVE EMPTY TO DISPLAY FAU-SPECIFIC TEXT</i>'),
        );

        //
        $form['Lang_Specific_Form']['General']['Legal_Notice_URL'] = array(
          '#type'          => 'hidden',
          '#title'         => t('Legal Notice URL'),
        );


      // Fields: Data Security Official
      $form['Lang_Specific_Form']['Data_Security_Official'] = array(
        '#type'  => 'details',
        '#title' => t('Data Security Official Responsible for the Institution (e.g. FAU)'),
        '#open'  => TRUE,
      );

        $form['Lang_Specific_Form']['Data_Security_Official']['Security_Official_Title'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Title Security Official'),
        );

        $form['Lang_Specific_Form']['Data_Security_Official']['Security_Official_Name'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Name Data Security Official'),
        );

        $form['Lang_Specific_Form']['Data_Security_Official']['Security_Official_Add'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Name Line 2'),
          // Might Not be Required When Data Security Official Changes
        );

        $form['Lang_Specific_Form']['Data_Security_Official']['Security_Official_Address'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Street Name and House Number'),
        );

        $form['Lang_Specific_Form']['Data_Security_Official']['Security_Official_PLZ'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Postal Code'),
        );

        $form['Lang_Specific_Form']['Data_Security_Official']['Security_Official_City'] = array(
          '#type'          => 'textfield',
          '#title'         => t('City'),
        );

        $form['Lang_Specific_Form']['Data_Security_Official']['Security_Official_Phone'] = array(
          '#type'          => 'tel',
          '#title'         => t('Phone'),
        );

        $form['Lang_Specific_Form']['Data_Security_Official']['Security_Official_Fax'] = array(
          '#type'     => 'tel',
          '#title'    => t('Fax'),
        );

        $form['Lang_Specific_Form']['Data_Security_Official']['Security_Official_Email'] = array(
          '#type'          => 'email',
          '#title'         => t('E-Mail Data Security Official'),
        );



      // Fields: Third Party Services
      $form['Lang_Specific_Form']['Third_Party_Services'] = array(
        '#type'  => 'details',
        '#title' => t('Third Party Services'),
        '#open'  => TRUE,
      );

        $form['Lang_Specific_Form']['Third_Party_Services']['Third_Service_Provider'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Name Third Party Service'),
          '#description'   => t('<i>LEAVE THIS FIELD EMPTY TO NOT DISPLAY WHOLE SECTION</i>'),
          // Used for Condition
          '#id'            => 'third_party',
        );

        $form['Lang_Specific_Form']['Third_Party_Services']['Third_Service_Description_Data_Collection'] = array(
          '#type'          => 'textarea',
          '#title'         => t('Description and Scope Data Processing'),
          // Condition (Third Party Service Provider Exists): Input Required
          '#states'        => [
            'required' => [
              [':input[id="third_party"]' => [
                '!value' => ''
                ],
              ],
            ],
          ],
        );

        $form['Lang_Specific_Form']['Third_Party_Services']['Third_Service_Legal_Basis_Data_Collection'] = array(
          '#type'          => 'textarea',
          '#title'         => t('Legal Basis for Processing of Personal Data'),
          // Condition (Third Party Service Provider Exists): Input Required
          '#states'        => [
            'required' => [
              [':input[id="third_party"]' => [
                '!value' => ''
                ],
              ],
            ],
          ],
        );

        $form['Lang_Specific_Form']['Third_Party_Services']['Third_Service_Objection_Data_Collection'] = array(
          '#type'          => 'textarea',
          '#title'         => t('Objection and Elimination'),
          // Condition (Third Party Service Provider Exists): Input Required
          '#states'        => [
            'required' => [
              [':input[id="third_party"]' => [
                '!value' => ''
                ],
              ],
            ],
          ],
        );


      // Fields: (Bavarian) Data Protection Commissioner
      $form['Lang_Specific_Form']['Data_Protection_Commissioner'] = array(
        '#type'  => 'details',
        '#title' => t('(Bavarian) Data Protection Commissioner'),
        '#open'  => TRUE,
      );

        $form['Lang_Specific_Form']['Data_Protection_Commissioner']['Data_Commissioner_Title'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Title Bavarian State Commissioner for Data Protection'),
        );

        $form['Lang_Specific_Form']['Data_Protection_Commissioner']['Data_Commissioner_Address'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Street Name and House Number'),
        );

        $form['Lang_Specific_Form']['Data_Protection_Commissioner']['Data_Commissioner_PLZ'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Postal Code'),
        );

        $form['Lang_Specific_Form']['Data_Protection_Commissioner']['Data_Commissioner_City'] = array(
          '#type'          => 'textfield',
          '#title'         => t('City'),
        );


      // Field: Timestamp
      $form['Lang_Specific_Form']['Timestamp'] = array(
        '#type'  => 'details',
        '#title' => t('Date of Page Generation'),
        '#open'  => TRUE,
      );

        // Get Today Time
        $current_timestamp = \Drupal::time()->getCurrentTime();
        $todays_date = \Drupal::service('date.formatter')->format($current_timestamp, 'custom', 'Y-m-d');

        $form['Lang_Specific_Form']['Timestamp']['Date'] = array(
          '#type'          => 'date',
          '#title'         => t('Date of Page Generation'),
        );


      // Disclaimer
      $form['Lang_Specific_Form']['Notice'] = array(
        '#type'   => 'item',
        '#prefix' => '<br /><p><strong>',
        '#suffix' => '</strong></p>',
        '#markup' => t('No liability is assumed for the correctness of the data entered or the legal statement generated.<br />
                        Please verify the accuracy of the generated page.'),
      );


      // Field: Consent Overwrite
      $form['Lang_Specific_Form']['Overwrite']['Overwrite_Consent'] = array(
        '#type'      => 'checkbox',
        '#prefix'    => '<p>',
        '#title'     => t('<strong>OVERWRITE existent privacy declaration</strong>'),
        '#suffix'    => '</p>',
        // Ensure Set to TRUE to Avoid Data Loss when Generate without Ticked Checkbox
        '#required'  => TRUE,
        );

      // Condition (Page Does NOT Exist Yet): Do Not Display Overwrite Checkbox
      // Node Does NOT Exist:
      if($node == NULL){

        // Do NOT Show Overwrite Checkbox
        $form['Lang_Specific_Form']['Overwrite']['Overwrite_Consent']['#type'] = 'value';

        // Overwrite Checkbox is NOT Required (Enable Submission Irrespective of Checkbox)
        $form['Lang_Specific_Form']['Overwrite']['Overwrite_Consent']['#required'] = FALSE;

        // Node Exists: Check if Translation Exists
      } else {

        $default_lang = \Drupal::languageManager()->getDefaultLanguage()->getId();
        $trans_exist = $node->hasTranslation($lang);

        // Page Language is NOT Default Language and Language Page Does NOT Exist:
        if($lang != $default_lang and !$trans_exist){

          // Do NOT Show Overwrite Checkbox
          $form['Lang_Specific_Form']['Overwrite']['Overwrite_Consent']['#type'] = 'value';

          // Overwrite Checkbox is NOT Required (Enable Submission Irrespective of Checkbox)
          $form['Lang_Specific_Form']['Overwrite']['Overwrite_Consent']['#required'] = FALSE;
        }
      }

      // Button: Submit Form and Populate Template
      $form['Lang_Specific_Form']['submit_button'] = array(
        '#type'   => 'submit',
        '#value'  => t('Generate'),
      );

      // Button: Opens Modal with Info on Reset to Default, 'Continue' Button and 'Return' Button
      $form['Lang_Specific_Form']['Modal_Reset_Button'] = array (
        '#class'  => 'button',
        '#type'   => 'button',
        '#value'  => t('Reset to Default'),
        // Ensure Reset Button Bypasses Required Values Validation
        '#limit_validation_errors' => array(),
        // AJAX Callback Handler on Button Click
        '#ajax' => array(
          'callback' => '::ajax_modal_popup',
        ),
      );



      // Populate Fields with Default Values
      $form['Lang_Specific_Form']['General']['Title']['#default_value'] = $stored_values[$lang]['title'] ?? $default_values[$lang]['title'];
      $form['Lang_Specific_Form']['General']['Alias']['#default_value'] = $stored_values[$lang]['alias'] ?? $default_values[$lang]['alias'];
      $form['Lang_Specific_Form']['General']['Not_FAU']['#default_value'] = $stored_values[$lang]['not_fau'] ?? t('');

      $form['Lang_Specific_Form']['General']['Legal_Notice_URL']['#default_value'] = $values_from_legalnotice[$lang]['alias'] ?? $default_values[$lang]['legal_notice_url']['name'];

      $form['Lang_Specific_Form']['Data_Security_Official']['Security_Official_Title']['#default_value'] = $stored_values[$lang]['security_official_title'] ?? $default_values[$lang]['security_official_title'];
      $form['Lang_Specific_Form']['Data_Security_Official']['Security_Official_Name']['#default_value'] = $stored_values[$lang]['security_official_name'] ?? $default_values[$lang]['security_official_name'];
      $form['Lang_Specific_Form']['Data_Security_Official']['Security_Official_Add']['#default_value'] = $stored_values[$lang]['security_official_add'] ?? $default_values[$lang]['security_official_add'];
      $form['Lang_Specific_Form']['Data_Security_Official']['Security_Official_Address']['#default_value'] = $stored_values['intl']['security_official_address'] ?? $default_values['intl']['security_official_address'];
      $form['Lang_Specific_Form']['Data_Security_Official']['Security_Official_PLZ']['#default_value'] = $stored_values['intl']['security_official_plz'] ?? $default_values['intl']['security_official_plz'];
      $form['Lang_Specific_Form']['Data_Security_Official']['Security_Official_City']['#default_value'] = $stored_values[$lang]['security_official_city'] ?? $default_values[$lang]['security_official_city'];
      $form['Lang_Specific_Form']['Data_Security_Official']['Security_Official_Phone']['#default_value'] = $stored_values['intl']['security_official_phone'] ?? $default_values['intl']['security_official_phone'];
      $form['Lang_Specific_Form']['Data_Security_Official']['Security_Official_Fax']['#default_value'] = $stored_values['intl']['security_official_fax'] ?? t('');
      $form['Lang_Specific_Form']['Data_Security_Official']['Security_Official_Email']['#default_value'] = $stored_values['intl']['security_official_email'] ?? $default_values['intl']['security_official_email'];

      $form['Lang_Specific_Form']['Third_Party_Services']['Third_Service_Provider']['#default_value'] = $stored_values[$lang]['third_service_provider'] ?? t('');
      $form['Lang_Specific_Form']['Third_Party_Services']['Third_Service_Description_Data_Collection']['#default_value'] = $stored_values[$lang]['third_service_description_data_collection'] ?? t('');
      $form['Lang_Specific_Form']['Third_Party_Services']['Third_Service_Legal_Basis_Data_Collection']['#default_value'] = $stored_values[$lang]['third_service_legal_basis_data_collection'] ?? t('');
      $form['Lang_Specific_Form']['Third_Party_Services']['Third_Service_Objection_Data_Collection']['#default_value'] = $stored_values[$lang]['third_service_objection_data_collection'] ?? t('');

      $form['Lang_Specific_Form']['Data_Protection_Commissioner']['Data_Commissioner_Title']['#default_value'] = $stored_values[$lang]['data_commissioner_title'] ?? $default_values[$lang]['data_commissioner_title'];
      $form['Lang_Specific_Form']['Data_Protection_Commissioner']['Data_Commissioner_Address']['#default_value'] = $stored_values['intl']['data_commissioner_address'] ?? $default_values['intl']['data_commissioner_address'];
      $form['Lang_Specific_Form']['Data_Protection_Commissioner']['Data_Commissioner_PLZ']['#default_value'] = $stored_values['intl']['data_commissioner_plz'] ?? $default_values['intl']['data_commissioner_plz'];
      $form['Lang_Specific_Form']['Data_Protection_Commissioner']['Data_Commissioner_City']['#default_value'] = $stored_values[$lang]['data_commissioner_city'] ?? $default_values[$lang]['data_commissioner_city'];

      $form['Lang_Specific_Form']['Timestamp']['Date']['#default_value'] = $todays_date;

      $form['Lang_Specific_Form']['Overwrite']['Overwrite_Consent']['#default_value'] = FALSE;


      // Set Fields to Required/NOT Required Dependent on required.yml
        // !!! 'Third_Party_Service' Managed Separately: Directly in Form Via #states
        // !!! 'Overwrite' Managed Separately: Directly in Form Via Condition

      // Get Required Values From YAML File (Default Values ≙ Required Values)
      $req_lang = $default_values[$lang];
      $req_intl = $default_values['intl'];

      // Join Lang and Intl Array
      $req_all = array_merge($req_lang, $req_intl);


      // Set Required Status
      $form['Lang_Specific_Form']['General']['Title']['#required'] = $this->isItRequired('title', $req_all);
      $form['Lang_Specific_Form']['General']['Alias']['#required'] = $this->isItRequired('alias', $req_all);
      $form['Lang_Specific_Form']['General']['Not_FAU']['#required'] = $this->isItRequired('not_fau', $req_all);

      $form['Lang_Specific_Form']['General']['Legal_Notice_URL']['#required'] = $this->isItRequired('legal_notice_url', $req_all);

      $form['Lang_Specific_Form']['Data_Security_Official']['Security_Official_Title']['#required'] = $this->isItRequired('security_official_title', $req_all);
      $form['Lang_Specific_Form']['Data_Security_Official']['Security_Official_Name']['#required'] = $this->isItRequired('security_official_name', $req_all);
      $form['Lang_Specific_Form']['Data_Security_Official']['Security_Official_Add']['#required'] = $this->isItRequired('security_official_add', $req_all);
      $form['Lang_Specific_Form']['Data_Security_Official']['Security_Official_Address']['#required'] = $this->isItRequired('security_official_address', $req_all);
      $form['Lang_Specific_Form']['Data_Security_Official']['Security_Official_PLZ']['#required'] = $this->isItRequired('security_official_plz', $req_all);
      $form['Lang_Specific_Form']['Data_Security_Official']['Security_Official_City']['#required'] = $this->isItRequired('security_official_city', $req_all);
      $form['Lang_Specific_Form']['Data_Security_Official']['Security_Official_Phone']['#required'] = $this->isItRequired('security_official_phone', $req_all);
      $form['Lang_Specific_Form']['Data_Security_Official']['Security_Official_Fax']['#required'] = $this->isItRequired('security_official_fax', $req_all);
      $form['Lang_Specific_Form']['Data_Security_Official']['Security_Official_Email']['#required'] = $this->isItRequired('security_official_email', $req_all);

      // 'Third_Party_Service' Managed Separately: Directly in Form Via #states

      $form['Lang_Specific_Form']['Data_Protection_Commissioner']['Data_Commissioner_Title']['#required'] = $this->isItRequired('data_commissioner_title', $req_all);
      $form['Lang_Specific_Form']['Data_Protection_Commissioner']['Data_Commissioner_Address']['#required'] = $this->isItRequired('data_commissioner_address', $req_all);
      $form['Lang_Specific_Form']['Data_Protection_Commissioner']['Data_Commissioner_PLZ']['#required'] = $this->isItRequired('data_commissioner_plz', $req_all);
      $form['Lang_Specific_Form']['Data_Protection_Commissioner']['Data_Commissioner_City']['#required'] = $this->isItRequired('data_commissioner_city', $req_all);

      $form['Lang_Specific_Form']['Timestamp']['Date']['#required'] = $this->isItRequired('date', $req_all);;

      // 'Overwrite' Managed Separately: Directly in Form Via Condition


    return $form;
   }
  }

  /**
   * Checks in YAML File if Value is Required.
   */
  function isItRequired($key, $req_all): bool {

    if(array_key_exists($key, $req_all)){
           return TRUE;
    } else {
      return false;
    }
  }

  /**
   * {@inheritdoc}
   * AJAX Callback Handler for Language Selection:
   * Called when the User Selects a Language.
   * Builds Form for the Language Selected by the User and Fills Fields either with Values from the State, Default Values or Leaves them Empty if Neither of Both is Available.
   */
  public function ajaxCallback(array $form, FormStateInterface $form_state){

      return $form['Lang_Specific_Form'];
  }


  /**
   * AJAX Callback Handler for Reset Modal:
   * Called when the User Clicks on the "Reset to Default"-Button.
   * Opens a Modal Informing the User About the Consequences of Resetting all Values to Default. Gives them the Option to Return to the Form Without Performing any Action or Proceding to Reset all Values
   * to Default. When the User clicks "Reset to Default" in the Modal, they will be Forwarded to the LegalgenController which Executes the Reset and Sends the User Back to the Form.
   */
  public function ajax_modal_popup($form, &$form_state){

    // Set Title and Size of Modal
    $title = t("Reset Values to Default");
    $options = [
      'width' => '70%'
    ];

    $content['#markup'] = "<br />Resetting values CANNOT be undone. Non language-specific values (such as phone numbers, postal codes, e-mail addresses etc.) will be reset for all other language versions of this form as well.<br />Already generated pages are NOT affected.<br /><br />Do you wish to continue?<br />";
    $content['Close_Button'] = array (
      '#class'  => 'button',
      '#type'   => 'button',
      '#value'  => t('Return to Form'),
      '#prefix' => '<br />',
      '#attributes' => [
        'onclick' => "Drupal.dialog(document.getElementById('drupal-modal')).close(); return false;",
      ],
    );

    // Build URL to Link to Controller with Query String
    $lang_name = $form_state->getValue('Chosen_Language');
    $page_type = 'privacy';
    $url = Url::fromRoute("wisski.legalgen.reset", array("lang" => $lang_name, "pt" => $page_type));

      // Button to Confirm Reset to Default
      // Links to Controller, Where Values are Reset and User is Sent back to Form They Came From
    $content['Controller_Reset_Button'] = array (
      '#type'   => 'link',
      '#title'  => $this->t('Reset to Default'),
      '#url'    => $url,
      '#attributes' => [
        'class' => [
          'button',
        ],
      ],
    );

    // Create Modal
    $response = new AjaxResponse();
    $response->addCommand(new OpenModalDialogCommand($title, $content, $options));

    return $response;
  }


  /**
   * {@inheritdoc}
   * Called When the User Hits the Submit Button.
   *
   * Creates Three Arrays, One Containing all Data As Submitted by the User ($data), One Containing all Keys Pertaining to the Language Dependent Values ($state_keys_lang), and One with all Keys for
   * Values that are not Language Dependent ($state_keys_intl). The Keys Arrays are Used to Store the Data with Which the Page was Successfully Generated in the State.
   *
   * One of the Values for the Data Array is adjusted:
   * - Format of the Date is Changed to the One Commonly Used in Germany.
   *
   * The String Indicating the Page Type is Hard Coded in this Function. This Information will be Passed on to the LegalGenerator of it to Chose the Correct Template for Generation.
   */
  public function submitForm(array &$form, FormStateInterface $form_state){

    // Get Values Entered by User
    $values = $form_state->getValues();

    $lang                                        = $values['Chosen_Language'];
    $title                                       = $values['Title'];
    $alias                                       = $values['Alias'];
    $not_fau                                     = $values['Not_FAU'];
    $legal_notice_url                            = $values['Legal_Notice_URL'];
    $security_official_title                     = $values['Security_Official_Title'];
    $security_official_name                      = $values['Security_Official_Name'];
    $security_official_add                       = $values['Security_Official_Add'];
    $security_official_address                   = $values['Security_Official_Address'];
    $security_official_plz                       = $values['Security_Official_PLZ'];
    $security_official_city                      = $values['Security_Official_City'];
    $security_official_phone                     = $values['Security_Official_Phone'];
    $security_official_fax                       = $values['Security_Official_Fax'];
    $security_official_email                     = $values['Security_Official_Email'];
    $third_service_provider                      = $values['Third_Service_Provider'];
    $third_service_description_data_collection   = $values['Third_Service_Description_Data_Collection'];
    $third_service_legal_basis_data_collection   = $values['Third_Service_Legal_Basis_Data_Collection'];
    $third_service_objection_data_collection     = $values['Third_Service_Objection_Data_Collection'];
    $data_commissioner_title                     = $values['Data_Commissioner_Title'];
    $data_commissioner_address                   = $values['Data_Commissioner_Address'];
    $data_commissioner_plz                       = $values['Data_Commissioner_PLZ'];
    $data_commissioner_city                      = $values['Data_Commissioner_City'];
    $date                                        = $values['Date'];
    $overwrite_consent                           = $values['Overwrite_Consent'];

    // Change Date Format
    $date = date('d.m.Y', strtotime($date));

    $data = [
      'lang'                                       => $lang,
      'not_fau'                                    => $not_fau,
      'legal_notice_url'                           => $legal_notice_url,
      'security_official_title'                    => $security_official_title,
      'security_official_name'                     => $security_official_name,
      'security_official_add'                      => $security_official_add,
      'security_official_address'                  => $security_official_address,
      'security_official_plz'                      => $security_official_plz,
      'security_official_city'                     => $security_official_city,
      'security_official_phone'                    => $security_official_phone,
      'security_official_fax'                      => $security_official_fax,
      'security_official_email'                    => $security_official_email,
      'third_service_provider'                     => $third_service_provider,
      'third_service_description_data_collection'  => $third_service_description_data_collection,
      'third_service_legal_basis_data_collection'  => $third_service_legal_basis_data_collection,
      'third_service_objection_data_collection'    => $third_service_objection_data_collection,
      'data_commissioner_title'                    => $data_commissioner_title,
      'data_commissioner_address'                  => $data_commissioner_address,
      'data_commissioner_plz'                      => $data_commissioner_plz,
      'data_commissioner_city'                     => $data_commissioner_city,
      'date'                                       => $date,
      'overwrite_consent'                          => $overwrite_consent
    ];


    // Parameters to Call Service:

    // a) Key to Select Correct Template for Page Generation
    $page_type = 'privacy';

    // b) Keys to Use for Storage in State
    $state_keys_lang = array('title'                                        => '',
                             'alias'                                        => '',
                             'legal_notice_url'                             => '',
                             'not_fau'                                      => '',
                             'security_official_title'                      => '',
                             'security_official_name'                       => '',
                             'security_official_add'                        => '',
                             'security_official_city'                       => '',
                             'third_service_provider'                       => '',
                             'third_service_description_data_collection'    => '',
                             'third_service_legal_basis_data_collection'    => '',
                             'third_service_objection_data_collection'      => '',
                             'data_commissioner_title'                      => '',
                             'data_commissioner_city'                       => '',
                             'overwrite_consent'                            => '',
    	                      );

    // c) Keys to Use for Storage in State
    $state_keys_intl = array('security_official_address'      => '',
                             'security_official_plz'          => '',
                             'security_official_phone'        => '',
                             'security_official_fax'          => '',
                             'security_official_email'        => '',
                             'data_commissioner_address'      => '',
                             'data_commissioner_plz'          => '',
                             'date'                           => '',
  	                        );

    // Let Service Generate Page
    \Drupal::service('legalgen.generator')->generatePage($data, $title, $alias, $page_type, $lang, $state_keys_lang, $state_keys_intl);
  }
}
