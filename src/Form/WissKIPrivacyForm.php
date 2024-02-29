<?php

namespace Drupal\legalgen\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\State\StateInterface;
use Drupal\legalgen\Generator\LegalGenerator;
use \Drupal\node\Entity\Node;
use \Drupal\Core\Language;
use \Drupal\Core\Url;
use \Drupal\Core\Link;
use \Drupal\Core\Entity;
use \Drupal\Core\StringTranslation\TranslatableMarkup;
use \Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Render\Element;
use Drupal\Core\Routing;
use Drupal\Core\Controller\ControllerBase;

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
   */
  public function buildForm(array $form, FormStateInterface $form_state){

    // Fields
    // Type of Render Array Element
    // See https://api.drupal.org/api/drupal/elements/8.2.x for Available Elements

    // Get State Values for Form
    $stored_values = $this->getStateValues();
    $default_values = LegalGenerator::REQUIRED_DATA_ALL['REQUIRED_PRIVACY'];
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
      '#title'         => t('Choose the language in which the privacy notice should be generated<br /><br />'),
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
      $unset_key = array('Title', 'Alias', 'Not_FAU', 'Legal_Notice_URL', 'Sec_Off_Title', 'Sec_Off_Name', 'Sec_Off_Add', 'Sec_Off_Address', 'Sec_Off_PLZ', 'Sec_Off_City', 'Sec_Off_Phone', 'Sec_Off_Fax', 'Sec_Off_Email', 'Third_Service_Provider', 'Third_Descr_Data_Coll', 'Third_Legal_Basis_Data_Coll', 'Third_Objection_Data_Coll', 'Data_Comm_Title', 'Data_Comm_Address', 'Data_Comm_PLZ', 'Data_Comm_City', 'Date', 'Overwrite_Consent');

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
          '#required'      => TRUE,
        );

        $form['Lang_Specific_Form']['General']['Alias'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Page Alias'),
          '#required'      => TRUE,
        );

        $form['Lang_Specific_Form']['General']['Not_FAU'] = array(
          '#type'          => 'textarea',
          '#title'         => t('Information Regarding the Representative Within the Meaning of the General Data Protection Regulation'),
          '#description'   => t('<i>REPLACES FAU-SPECIFIC TEXT. LEAVE EMPTY TO DISPLAY FAU-specific text</i>'),
          '#required'      => FALSE,
        );

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

        $form['Lang_Specific_Form']['Data_Security_Official']['Sec_Off_Title'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Title Security Official'),
          '#required'      => TRUE,
        );

        $form['Lang_Specific_Form']['Data_Security_Official']['Sec_Off_Name'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Name Data Security Official'),
          '#required'      => TRUE,
        );

        $form['Lang_Specific_Form']['Data_Security_Official']['Sec_Off_Add'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Name Line 2'),
          // Might Not be Required When Data Security Official Changes
          '#required'      => TRUE,
        );

        $form['Lang_Specific_Form']['Data_Security_Official']['Sec_Off_Address'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Street Name and House Number'),
          '#required'      => TRUE,
        );

        $form['Lang_Specific_Form']['Data_Security_Official']['Sec_Off_PLZ'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Postal Code'),
          '#required'      => TRUE,
        );

        $form['Lang_Specific_Form']['Data_Security_Official']['Sec_Off_City'] = array(
          '#type'          => 'textfield',
          '#title'         => t('City'),
          '#required'      => TRUE,
        );

        $form['Lang_Specific_Form']['Data_Security_Official']['Sec_Off_Phone'] = array(
          '#type'          => 'tel',
          '#title'         => t('Phone'),
          '#required'      => TRUE,
        );

        $form['Lang_Specific_Form']['Data_Security_Official']['Sec_Off_Fax'] = array(
          '#type'     => 'tel',
          '#title'    => t('Fax'),
          '#required' => FALSE,
        );

        $form['Lang_Specific_Form']['Data_Security_Official']['Sec_Off_Email'] = array(
          '#type'          => 'email',
          '#title'         => t('E-Mail Data Security Official'),
          '#required'      => TRUE,
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
          '#description'   => t('<i>LEAVE EMPTY TO NOT DISPLAY WHOLE SECTION</i>'),
          // Used for Condition
          '#id'            => 'third_party',
        );

        $form['Lang_Specific_Form']['Third_Party_Services']['Third_Descr_Data_Coll'] = array(
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

        $form['Lang_Specific_Form']['Third_Party_Services']['Third_Legal_Basis_Data_Coll'] = array(
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

        $form['Lang_Specific_Form']['Third_Party_Services']['Third_Objection_Data_Coll'] = array(
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

        $form['Lang_Specific_Form']['Data_Protection_Commissioner']['Data_Comm_Title'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Title Bavarian State Commissioner for Data Protection'),
          '#required'      => TRUE,
        );

        $form['Lang_Specific_Form']['Data_Protection_Commissioner']['Data_Comm_Address'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Street Name and House Number'),
          '#required'      => TRUE,
        );

        $form['Lang_Specific_Form']['Data_Protection_Commissioner']['Data_Comm_PLZ'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Postal Code'),
          '#required'      => TRUE,
        );

        $form['Lang_Specific_Form']['Data_Protection_Commissioner']['Data_Comm_City'] = array(
          '#type'          => 'textfield',
          '#title'         => t('City'),
          '#required'      => TRUE,
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
          '#required'      => TRUE,
        );


      // Disclaimer
      $form['Lang_Specific_Form']['Notice'] = array(
        '#type'   => 'item',
        '#prefix' => '<br /><p><strong>',
        '#suffix' => '</strong></p>',
        '#markup' => t('No liability is assumed for the correctness of the data entered.<br />
                        Please verify the accuracy of the generated pages.'),
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

      // Button: Reset Form Contents to Default
      $form['Lang_Specific_Form']['reset_button'] = array(
        '#class'  => 'button',
        '#type'   => 'submit',
        '#value'  => t('Reset to default'),
        '#submit' => [[$this, 'resetAllValues']],
      );


      // Populate Fields with Default Values
      $form['Lang_Specific_Form']['General']['Title']['#default_value'] = $stored_values[$lang]['title'] ?? $default_values[$lang]['title'];
      $form['Lang_Specific_Form']['General']['Alias']['#default_value'] = $stored_values[$lang]['alias'] ?? $default_values[$lang]['alias'];
      $form['Lang_Specific_Form']['General']['Not_FAU']['#default_value'] = $stored_values[$lang]['not_fau'] ?? t('');
      $form['Lang_Specific_Form']['General']['Legal_Notice_URL']['#default_value'] = $values_from_legalnotice[$lang]['alias'] ?? LegalGenerator::REQUIRED_LEGAL_NOTICE_ALIAS_DE;

      $form['Lang_Specific_Form']['Data_Security_Official']['Sec_Off_Title']['#default_value'] = $stored_values[$lang]['sec_off_title'] ?? $default_values[$lang]['sec_off_title'];
      $form['Lang_Specific_Form']['Data_Security_Official']['Sec_Off_Name']['#default_value'] = $stored_values[$lang]['sec_off_name'] ?? $default_values[$lang]['sec_off_name'];
      $form['Lang_Specific_Form']['Data_Security_Official']['Sec_Off_Add']['#default_value'] = $stored_values[$lang]['sec_off_add'] ?? $default_values[$lang]['sec_off_add'];
      $form['Lang_Specific_Form']['Data_Security_Official']['Sec_Off_Address']['#default_value'] = $stored_values['intl']['sec_off_address'] ?? $default_values['intl']['sec_off_address'];
      $form['Lang_Specific_Form']['Data_Security_Official']['Sec_Off_PLZ']['#default_value'] = $stored_values['intl']['sec_off_plz'] ?? $default_values['intl']['sec_off_plz'];
      $form['Lang_Specific_Form']['Data_Security_Official']['Sec_Off_City']['#default_value'] = $stored_values[$lang]['sec_off_city'] ?? $default_values[$lang]['sec_off_city'];
      $form['Lang_Specific_Form']['Data_Security_Official']['Sec_Off_Phone']['#default_value'] = $stored_values['intl']['sec_off_phone'] ?? $default_values['intl']['sec_off_phone'];
      $form['Lang_Specific_Form']['Data_Security_Official']['Sec_Off_Fax']['#default_value'] = $stored_values['intl']['sec_off_fax'] ?? t('');
      $form['Lang_Specific_Form']['Data_Security_Official']['Sec_Off_Email']['#default_value'] = $stored_values['intl']['sec_off_email'] ?? $default_values['intl']['sec_off_email'];

      $form['Lang_Specific_Form']['Third_Party_Services']['Third_Service_Provider']['#default_value'] = $stored_values[$lang]['third_service_provider'] ?? t('');
      $form['Lang_Specific_Form']['Third_Party_Services']['Third_Descr_Data_Coll']['#default_value'] = $stored_values[$lang]['third_descr_data_coll'] ?? t('');
      $form['Lang_Specific_Form']['Third_Party_Services']['Third_Legal_Basis_Data_Coll']['#default_value'] = $stored_values[$lang]['third_legal_basis_data_coll'] ?? t('');
      $form['Lang_Specific_Form']['Third_Party_Services']['Third_Objection_Data_Coll']['#default_value'] = $stored_values[$lang]['third_objection_data_coll'] ?? t('');


      $form['Lang_Specific_Form']['Data_Protection_Commissioner']['Data_Comm_Title']['#default_value'] = $stored_values[$lang]['data_comm_title'] ?? $default_values[$lang]['data_comm_title'];
      $form['Lang_Specific_Form']['Data_Protection_Commissioner']['Data_Comm_Address']['#default_value'] = $stored_values['intl']['data_comm_address'] ?? $default_values['intl']['data_comm_address'];
      $form['Lang_Specific_Form']['Data_Protection_Commissioner']['Data_Comm_PLZ']['#default_value'] = $stored_values['intl']['data_comm_plz'] ?? $default_values['intl']['data_comm_plz'];
      $form['Lang_Specific_Form']['Data_Protection_Commissioner']['Data_Comm_City']['#default_value'] = $stored_values[$lang]['data_comm_city'] ?? $default_values[$lang]['data_comm_city'];

      $form['Lang_Specific_Form']['Timestamp']['Date']['#default_value'] = $todays_date;

      $form['Lang_Specific_Form']['Overwrite']['Overwrite_Consent']['#default_value'] = FALSE;

      return $form;
   }
  }

  /**
   * Called when user selects language
   * {@inheritdoc}
   */
  public function ajaxCallback(array $form, FormStateInterface $form_state){

      return $form['Lang_Specific_Form'];
  }


  /**
   * Called when user hits reset button
   * Build Form with Default Values for Selected Language
   * {@inheritdoc}
   */
  public function resetAllValues(array &$values_stored_in_state, FormStateInterface $form_state){

    // Get Array from State
    $content_state = \Drupal::state()->get('legalgen.privacy');

    // Get Language Code Of Selected Form
    $language = $values_stored_in_state['Select_Language']['Chosen_Language'];

    $lang = $language['#value'];

    // Condition (Already Values Stored in State): Replace with Default Values
    if (!empty($content_state[$lang])) {

      unset($content_state[$lang]);

      if(!empty($content_state['intl'])){

        unset($content_state['intl']);

        $new_state_vars = array('legalgen.privacy' => $content_state);

        \Drupal::state()->setMultiple($new_state_vars);

      }
    }
  }


  /**
   * Called when the user hits submit button
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state){

    // Get Values Entered by User
    $values = $form_state->getValues();

    $lang                               = $values['Chosen_Language'];
    $title                              = $values['Title'];
    $alias                              = $values['Alias'];
    $not_fau                            = $values['Not_FAU'];
    $legal_notice_url                   = $values['Legal_Notice_URL'];
    $sec_off_title                      = $values['Sec_Off_Title'];
    $sec_off_name                       = $values['Sec_Off_Name'];
    $sec_off_add                        = $values['Sec_Off_Add'];
    $sec_off_address                    = $values['Sec_Off_Address'];
    $sec_off_plz                        = $values['Sec_Off_PLZ'];
    $sec_off_city                       = $values['Sec_Off_City'];
    $sec_off_phone                      = $values['Sec_Off_Phone'];
    $sec_off_fax                        = $values['Sec_Off_Fax'];
    $sec_off_email                      = $values['Sec_Off_Email'];
    $third_service_provider             = $values['Third_Service_Provider'];
    $third_descr_data_coll              = $values['Third_Descr_Data_Coll'];
    $third_legal_basis_data_coll        = $values['Third_Legal_Basis_Data_Coll'];
    $third_objection_data_coll          = $values['Third_Objection_Data_Coll'];
    $data_comm_title                    = $values['Data_Comm_Title'];
    $data_comm_address                  = $values['Data_Comm_Address'];
    $data_comm_plz                      = $values['Data_Comm_PLZ'];
    $data_comm_city                     = $values['Data_Comm_City'];
    $date                               = $values['Date'];
    $overwrite_consent                  = $values['Overwrite_Consent'];

    // Change Date Format
    $date = date('d.m.Y', strtotime($date));


    $data = [
      'lang'                           => $lang,
      'not_fau'                        => $not_fau,
      'legal_notice_url'               => $legal_notice_url,
      'sec_off_title'                  => $sec_off_title,
      'sec_off_name'                   => $sec_off_name,
      'sec_off_add'                    => $sec_off_add,
      'sec_off_address'                => $sec_off_address,
      'sec_off_plz'                    => $sec_off_plz,
      'sec_off_city'                   => $sec_off_city,
      'sec_off_phone'                  => $sec_off_phone,
      'sec_off_fax'                    => $sec_off_fax,
      'sec_off_email'                  => $sec_off_email,
      'third_service_provider'         => $third_service_provider,
      'third_descr_data_coll'          => $third_descr_data_coll,
      'third_legal_basis_data_coll'    => $third_legal_basis_data_coll,
      'third_objection_data_coll'      => $third_objection_data_coll,
      'data_comm_title'                => $data_comm_title,
      'data_comm_address'              => $data_comm_address,
      'data_comm_plz'                  => $data_comm_plz,
      'data_comm_city'                 => $data_comm_city,
      'date'                           => $date,
      'overwrite_consent'              => $overwrite_consent
    ];


    // Parameters to Call Service:

    // a) Key to Select Correct Template for Page Generation
    $page_name = 'privacy';

    // b) Keys to Use for Storage in State
    $state_keys_lang = array('title'                          => '',
                             'alias'                          => '',
                             'not_fau'                        => '',
                             'sec_off_title'                  => '',
                             'sec_off_name'                   => '',
                             'sec_off_add'                    => '',
                             'sec_off_city'                   => '',
                             'third_service_provider'         => '',
                             'third_descr_data_coll'          => '',
                             'third_legal_basis_data_coll'    => '',
                             'third_objection_data_coll'      => '',
                             'data_comm_title'                => '',
                             'data_comm_city'                 => '',
                             'overwrite_consent'              => '',
    	                      );

    // c) Keys to Use for Storage in State
    $state_keys_intl = array('sec_off_address'                => '',
                             'sec_off_plz'                    => '',
                             'sec_off_phone'                  => '',
                             'sec_off_fax'                    => '',
                             'sec_off_email'                  => '',
                             'data_comm_address'              => '',
                             'data_comm_plz'                  => '',
                             'date'                           => '',
  	                        );

    // Let Service Generate Page
    $success = \Drupal::service('legalgen.generator')->generatePage($data, $title, $alias, $page_name, $lang, $state_keys_lang, $state_keys_intl);

    // Display Success Message:
    if($success === 'success'){
      \Drupal::messenger()->addMessage('<a href="/'.$alias.'">Legal notice in '.$lang.'generated successfully</a>', 'status', TRUE);
    } else {
      if($success === 'invalid'){
        \Drupal::messenger()->addError('Unfortunately an error ocurred: Required Values Missing', 'status', TRUE);

      } else if ($success === 'unable') {
        \Drupal::messenger()->addError('Unfortunately an error ocurred: Unable to Generate Page for the Following Language: '.$lang, 'status', TRUE);
      }
    }
  }
}
