<?php

namespace Drupal\legalgen\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use \Drupal\node\Entity\Node;
use Symfony\Component\Yaml\Yaml;
use \Drupal\Core\Url;
use \Drupal\Core\Ajax\AjaxResponse;
use \Drupal\Core\Ajax\OpenModalDialogCommand;



/**
 * Configure example settings for this site.
 */
class WissKILegalnoticeForm extends FormBase {

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
    if(!empty(\Drupal::state()->get('legalgen.legal_notice'))){
      return \Drupal::state()->get('legalgen.legal_notice');
    }else{
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
  public function buildForm(array $form, FormStateInterface $form_state) {

  // Fields
  // type of render array element
  // see https://api.drupal.org/api/drupal/elements/8.2.x for available elements

  // Get State Values for Form
  // 1) Get Values From State
  $stored_values = $this->getStateValues();

  // 2) Get Default Values from YAML File
  $file_path = dirname(__FILE__) . '/../../legalgen.required.and.email.yml';
  $file_contents = file_get_contents($file_path);
  $default_values_all = Yaml::parse($file_contents);
  $default_values = $default_values_all['REQUIRED_LEGALNOTICE'];


  // Check if Node Already Exists (Condition for Overwrite Checkbox Display)
  $state_vals = \Drupal::state()->get('legalgen.legal_notice');

  if(!empty($state_vals)){
      $nid = (string) $state_vals['node_id'];

      $node = Node::load($nid);

  } else {

      $node = NULL;
  }

  $form = [];

  // Get Languages from Config
  $options = \Drupal::configFactory()->get('legalgen.languages')->getRawData();

  // Remove '_core' from Array
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
      '#title'         => t('Choose the language in which the legal notice should be generated<br /><br />Please note:<br />Changes made here will NOT automatically be applied to already existing pages in other languages. Please make sure to generate them again<br /><br />'),
      '#options'       => $options,
      // Language Selection Triggers AJAX
      '#ajax'          => [
        'callback'        => '::ajaxCallback',
        'event'           => 'change',
        'wrapper'         => 'formDiv',
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
  $unset_key = array('Title', 'WissKI_URL', 'Alias', 'Project_Name', 'Publisher_Institute', 'Publisher_Name', 'Publisher_Address', 'Publisher_PLZ', 'Publisher_City', 'Publisher_Email', 'Custom_Legal_Form', 'Contact_Name', 'Contact_Phone', 'Contact_Email', 'Support_Institute', 'Support_URL', 'Support_Email', 'Support_Staff', 'Authority_Name', 'Authority_Address', 'Authority_PLZ', 'Authority_City', 'Authority_URL', 'VAT_Number', 'Tax_Number','DUNS_Number','EORI_Number', 'Licence_Title', 'Licence_URL', 'Use_FAU_Design_Template', 'No_Default_Text', 'Custom_Licence_Text', 'Custom_Exclusion_Liab', 'Hide_Disclaimer', 'Custom_Disclaimer', 'Date', 'Overwrite_Consent');

  foreach ($unset_key as $key) {
    unset($input[$key]);
  }

  $form_state->setUserInput($input);

  if(empty($lang)){
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
      );

    $form['Lang_Specific_Form']['General']['WissKI_URL'] = array(
      '#type'          => 'textfield',
      '#title'         => t('Legal Notice Applies to Content Under the Following URL'),
      );

    $form['Lang_Specific_Form']['General']['Alias'] = array(
      '#type'          => 'textfield',
      '#title'         => t('Page Alias'),
      );

    $form['Lang_Specific_Form']['General']['Project_Name'] = array(
      '#type'          => 'textfield',
      '#title'         => t('Project Name'),
      );


    // Fields: Publisher
    $form['Lang_Specific_Form']['Publisher'] = array(
      '#type'  => 'details',
      '#title' => t('Publisher'),
      '#open'  => TRUE,
      );

      $form['Lang_Specific_Form']['Publisher']['Publisher_Institute'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Institute'),
        );

      $form['Lang_Specific_Form']['Publisher']['Publisher_Name'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Name Publisher'),
        );

      $form['Lang_Specific_Form']['Publisher']['Publisher_Address'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Street Name and House Number'),
        );

      $form['Lang_Specific_Form']['Publisher']['Publisher_PLZ'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Postal Code'),
        );

      $form['Lang_Specific_Form']['Publisher']['Publisher_City'] = array(
        '#type'          => 'textfield',
        '#title'         => t('City'),
        );

      $form['Lang_Specific_Form']['Publisher']['Publisher_Email'] = array(
        '#type'          => 'email',
        '#title'         => t('E-Mail Publisher'),
        );

    // Fields: Legal Form and Representation
    $form['Lang_Specific_Form']['Legal_Form_and_Representation'] = array(
      '#type'  => 'details',
      '#title' => t('Legal Form and Representation'),
      '#open'  => TRUE,
      );

      $form['Lang_Specific_Form']['Legal_Form_and_Representation']['Custom_Legal_Form'] = array(
        '#type'          => 'textarea',
        '#title'         => t('Custom Information'),
        '#description'   => t('<i>REPLACES FAU SPECIFIC DEFAULT TEXT. LEAVE EMPTY TO DISPLAY DEFAULT TEXT</i>'),
        );



    // Fields: Contact Person Content
    $form['Lang_Specific_Form']['Contact_Content'] = array(
      '#type'  => 'details',
      '#title' => t('Contact Person Content'),
      '#open'  => TRUE,
      );

      $form['Lang_Specific_Form']['Contact_Content']['Contact_Name'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Name Contact Person'),
        );

      $form['Lang_Specific_Form']['Contact_Content']['Contact_Phone'] = array(
        '#type'          => 'tel',
        '#title'         => t('Phone Contact Person'),
      );

      $form['Lang_Specific_Form']['Contact_Content']['Contact_Email'] = array(
        '#type'          => 'email',
        '#title'         => t('E-Mail Contact Person'),
        );


    // Fields: Support and Hosting
    $form['Lang_Specific_Form']['Support_and_Hosting'] = array(
      '#type'  => 'details',
      '#title' => t('Support and Hosting'),
      '#open'  => TRUE,
      );

        $form['Lang_Specific_Form']['Support_and_Hosting']['Support_Institute'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Institute'),
          );

        $form['Lang_Specific_Form']['Support_and_Hosting']['Support_URL'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Homepage Support and Hosting'),
          );

        $form['Lang_Specific_Form']['Support_and_Hosting']['Support_Email'] = array(
          '#type'          => 'email',
          '#title'         => t('E-Mail Support and Hosting'),
          );

        $form['Lang_Specific_Form']['Support_and_Hosting']['Support_Staff'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Staff'),
          '#description'   => t('USE ";" AS SEPARATOR - E.G. "Eda Employee;Sujin Staff;..."'),
          );


    // Fields: Supervisory Authority
    $form['Lang_Specific_Form']['Supervisory_Authority'] = array(
      '#type'  => 'details',
      '#title' => t('Supervisory Authority'),
      '#open'  => TRUE,
      );

      $form['Lang_Specific_Form']['Supervisory_Authority']['Authority_Name'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Name Supervisory Authority'),
        );

      $form['Lang_Specific_Form']['Supervisory_Authority']['Authority_Address'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Street Name and House Number'),
        );

      $form['Lang_Specific_Form']['Supervisory_Authority']['Authority_PLZ'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Postal Code'),
        );

      $form['Lang_Specific_Form']['Supervisory_Authority']['Authority_City'] = array(
        '#type'          => 'textfield',
        '#title'         => t('City'),
        );

      $form['Lang_Specific_Form']['Supervisory_Authority']['Authority_URL'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Supervisory Authority URL'),
        );

    // Fields: ID Numbers
    $form['Lang_Specific_Form']['ID_Numbers'] = array(
      '#type'   => 'details',
      '#title'  =>  t('Identification Numbers'),
      '#open'   =>  TRUE,
      );

      $form['Lang_Specific_Form']['ID_Numbers']['VAT_Number'] = array(
        '#type'       => 'textfield',
        '#title'      => 'VAT Registration Number',
      );

      $form['Lang_Specific_Form']['ID_Numbers']['Tax_Number'] = array(
        '#type'       => 'textfield',
        '#title'      => 'Tax Number',
      );

      $form['Lang_Specific_Form']['ID_Numbers']['DUNS_Number'] = array(
        '#type'       => 'textfield',
        '#title'      => 'DUNS Number',
      );

      $form['Lang_Specific_Form']['ID_Numbers']['EORI_Number'] = array(
        '#type'       => 'textfield',
        '#title'      => 'EORI Number',
      );


    // Fields: Copyright
    $form['Lang_Specific_Form']['Copyright'] = array(
      '#type'  => 'details',
      '#title' => t('Copyright / Urheberrecht'),
      '#open'  => TRUE,
      );

        $form['Lang_Specific_Form']['Copyright']['Licence_Title'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Licence Title'),
          '#description'   => t('<i>USE ONLY IF PREDOMINANTLY THE SAME OR ONLY ONE LICENCE<br />ELSE CONSIDER USING THE CUSTOM INFORMATION FIELD BELOW</i>'),
          // Condition: Input Required if Licence URL Entered by User
          '#states' => [
            'required' => [
            [':input[id="licence_url"]' => [
              '!value' => ''
              ],
            ],
          ],
          ],
          '#required'      => FALSE,
          );

        $form['Lang_Specific_Form']['Copyright']['Licence_URL'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Licence URL'),
          '#id'            => 'licence_url',
          );

        $form['Lang_Specific_Form']['Copyright']['Use_FAU_Design_Template'] = array(
          '#type'          => 'checkbox',
          '#title'         => t('Use of FAU Corporate Design'),
          '#description'   => t('<i>IF USED EITHER WITH OR WITHOUT MODIFICATIONS</i>'),
          );

        $form['Lang_Specific_Form']['Copyright']['Custom_Licence_Text'] = array(
            '#type'          => 'textarea',
            '#title'         => t('Custom Information On Licence(s)'),
            '#description'   => t('<i>CONTENT DISPLAYED IN ADDITION TO DEFAULT TEXT. LEAVE EMPTY TO ONLY DISPLAY DEFAULT TEXT</i>'),
            // Condition (Checkbox 'No Default Text' is Checked): Input Required
            '#states' => [
              'required' => [
              [':input[id="no_default_txt"]' => [
                'checked' => TRUE,
                ],
              ],
            ],
            ],
            '#required'      => FALSE,
            );

        $form['Lang_Specific_Form']['Copyright']['No_Default_Text'] = array(
          '#type'          => 'checkbox',
          '#title'         => t('Display text \'Custom Information On Licence(s)\' instead of default text in section \'Copyright\''),
          '#description'   => t('<i>REPLACES ALL TEXT ON LICENCES EXCEPT ON private use AND ON content not protected by copyright law</i>'),
          // Used for Condition
          '#id'            => 'no_default_txt',
          );


    // Field: Exclusion of Liability
    $form['Lang_Specific_Form']['Exclusion_Liab'] = array(
      '#type'  => 'details',
      '#title' => t('Exclusion of Liability'),
      '#open'  => TRUE,
      );

        $form['Lang_Specific_Form']['Exclusion_Liab']['Custom_Exclusion_Liab'] = array(
          '#type'          => 'textarea',
          '#title'         => t('Custom Information On Liability Exclusion'),
          '#description'   => t('<i>CONTENT ADDED AFTER DEFAULT TEXT. LEAVE EMPTY TO ONLY DISPLAY DEFAULT TEXT</i>'),
          );


    // Field and Checkbox: Diclaimer External Links
    $form['Lang_Specific_Form']['Disclaimer'] = array(
      '#type'  => 'details',
      '#title' => t('Disclaimer External Links'),
      '#open'  => TRUE,
      );

        $form['Lang_Specific_Form']['Disclaimer']['Hide_Disclaimer'] = array(
          '#type'          => 'checkbox',
          '#title'         => t('No external links are used'),
          '#description'   => t('<i>IF CHECKED THE WHOLE SECTION WILL BE HIDDEN.<br />NEITHER DEFAULT TEXT NOR CUSTOM TEXT FROM TEXTAREA BELOW WILL BE DISPLAYED</i>'),
          );

        $form['Lang_Specific_Form']['Disclaimer']['Custom_Disclaimer'] = array(
          '#type'          => 'textarea',
          '#title'         => t('Add Custom Information on Liability For links'),
          '#description'   => t('<i>CONTENT REPLACES DEFAULT TEXT. LEAVE EMPTY TO DISPLAY DEFAULT TEXT</i>'),
          );


    // Field: Timestamp
    $form['Lang_Specific_Form']['Timestamp'] = array(
      '#type'  => 'details',
      '#title' => t('Generation Date'),
      '#open'  => TRUE,
      );

        // Get Today Time
        $current_timestamp = \Drupal::time()->getCurrentTime();
        $todays_date = \Drupal::service('date.formatter')->format($current_timestamp, 'custom', 'Y-m-d');

        $form['Lang_Specific_Form']['Timestamp']['Date'] = array(
          '#type'          => 'date',
          '#title'         => t('Generation Date'),
        );


  // Disclaimer
  $form['Lang_Specific_Form']['Notice'] = array(
    '#type'   => 'item',
    '#prefix' => '<br / ><p><strong>',
    '#suffix' => '</strong></p>',
    '#markup' => t('No liability is assumed for the correctness of the data entered or the legal statement generated.<br />
                    Please verify the accuracy of the generated page.'),
    );


    // Field: Consent Overwrite
    $form['Lang_Specific_Form']['Overwrite']['Overwrite_Consent'] = array(
      '#type'     => 'checkbox',
      '#prefix'   => '<p>',
      '#title'    => t('<strong>OVERWRITE existent legal notice</strong>'),
      '#suffix'   => '</p>',
      // Ensure Set to TRUE to Avoid Data Loss when Generate without Ticked Checkbox
      '#required' => TRUE,
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

    // Button: Sumbit Form and Populate Template
    $form['Lang_Specific_Form']['Submit_Button'] = array(
        '#type'  => 'submit',
        '#value' => t('Generate'),
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
    $form['Lang_Specific_Form']['General']['Title']['#default_value'] = $stored_values[$lang]['title']?? $default_values[$lang]['title'];
    $form['Lang_Specific_Form']['General']['WissKI_URL']['#default_value'] = $stored_values['intl']['wisski_url'] ?? \Drupal::request()->getSchemeAndHttpHost();
    $form['Lang_Specific_Form']['General']['Alias']['#default_value'] = $stored_values[$lang]['alias']?? $default_values[$lang]['alias'];
    $form['Lang_Specific_Form']['General']['Project_Name']['#default_value'] = $stored_values[$lang]['project_name']?? $default_values[$lang]['project_name'];

    $form['Lang_Specific_Form']['Publisher']['Publisher_Institute']['#default_value'] = $stored_values[$lang]['publisher_institute']?? t('');
    $form['Lang_Specific_Form']['Publisher']['Publisher_Name']['#default_value'] = $stored_values[$lang]['publisher_name']?? $default_values[$lang]['publisher_name'];
    $form['Lang_Specific_Form']['Publisher']['Publisher_Address']['#default_value'] = $stored_values['intl']['publisher_address']?? $default_values['intl']['publisher_address'];
    $form['Lang_Specific_Form']['Publisher']['Publisher_PLZ']['#default_value'] = $stored_values['intl']['publisher_plz']?? $default_values['intl']['publisher_plz'];
    $form['Lang_Specific_Form']['Publisher']['Publisher_City']['#default_value'] = $stored_values[$lang]['publisher_city']?? $default_values[$lang]['publisher_city'];
    $form['Lang_Specific_Form']['Publisher']['Publisher_Email']['#default_value'] = $stored_values['intl']['publisher_email']?? $default_values['intl']['publisher_email'];

    $form['Lang_Specific_Form']['Legal_Form_and_Representation']['Custom_Legal_Form']['#default_value'] = $stored_values[$lang]['custom_legal_form']?? t('');

    $form['Lang_Specific_Form']['Contact_Content']['Contact_Name']['#default_value'] = $stored_values[$lang]['contact_name']?? $default_values[$lang]['contact_name'];
    $form['Lang_Specific_Form']['Contact_Content']['Contact_Phone']['#default_value'] = $stored_values['intl']['contact_phone']?? $default_values['intl']['contact_phone'];
    $form['Lang_Specific_Form']['Contact_Content']['Contact_Email']['#default_value'] = $stored_values['intl']['contact_email']?? $default_values['intl']['contact_email'];

    $form['Lang_Specific_Form']['Support_and_Hosting']['Support_Institute']['#default_value'] = $stored_values[$lang]['support_institute']?? $default_values[$lang]['support_institute'];
    $form['Lang_Specific_Form']['Support_and_Hosting']['Support_URL']['#default_value'] = $stored_values['intl']['support_url']?? $default_values['intl']['support_url'];
    $form['Lang_Specific_Form']['Support_and_Hosting']['Support_Email']['#default_value'] = $stored_values['intl']['support_email']?? $default_values['intl']['support_email'];
    $form['Lang_Specific_Form']['Support_and_Hosting']['Support_Staff']['#default_value'] =  $stored_values[$lang]['support_staff_array']?? t('');

    $form['Lang_Specific_Form']['Supervisory_Authority']['Authority_Name']['#default_value'] = $stored_values[$lang]['authority_name']?? $default_values[$lang]['authority_name'];
    $form['Lang_Specific_Form']['Supervisory_Authority']['Authority_Address']['#default_value'] = $stored_values['intl']['authority_address']?? $default_values['intl']['authority_address'];
    $form['Lang_Specific_Form']['Supervisory_Authority']['Authority_PLZ']['#default_value'] = $stored_values['intl']['authority_plz']?? $default_values['intl']['authority_plz'];
    $form['Lang_Specific_Form']['Supervisory_Authority']['Authority_City']['#default_value'] = $stored_values[$lang]['authority_city']?? $default_values[$lang]['authority_city'];
    $form['Lang_Specific_Form']['Supervisory_Authority']['Authority_URL']['#default_value'] = $stored_values['intl']['authority_url']?? $default_values['intl']['authority_url'];

    $form['Lang_Specific_Form']['ID_Numbers']['VAT_Number']['#default_value'] = $stored_values['intl']['id_vat']?? $default_values['intl']['id_vat'];
    $form['Lang_Specific_Form']['ID_Numbers']['Tax_Number']['#default_value'] = $stored_values['intl']['id_tax']?? $default_values['intl']['id_tax'];
    $form['Lang_Specific_Form']['ID_Numbers']['DUNS_Number']['#default_value'] = $stored_values['intl']['id_duns']?? $default_values['intl']['id_duns'];
    $form['Lang_Specific_Form']['ID_Numbers']['EORI_Number']['#default_value'] = $stored_values['intl']['id_eori']?? $default_values['intl']['id_eori'];

    $form['Lang_Specific_Form']['Copyright']['Licence_Title']['#default_value'] = $stored_values[$lang]['licence_title']?? t('');
    $form['Lang_Specific_Form']['Copyright']['Licence_URL']['#default_value'] = $stored_values['intl']['licence_url']?? t('');
    $form['Lang_Specific_Form']['Copyright']['Use_FAU_Design_Template']['#default_value'] = $stored_values[$lang]['uses_fau_design']?? (FALSE);
    $form['Lang_Specific_Form']['Copyright']['Custom_Licence_Text']['#default_value'] = $stored_values[$lang]['custom_licence_txt']?? t('');
    $form['Lang_Specific_Form']['Copyright']['No_Default_Text']['#default_value'] = $stored_values[$lang]['no_default_txt']?? (FALSE);

    $form['Lang_Specific_Form']['Exclusion_Liab']['Custom_Exclusion_Liab']['#default_value'] = $stored_values[$lang]['custom_exclusion']?? t('');

    $form['Lang_Specific_Form']['Disclaimer']['Hide_Disclaimer']['#default_value'] = $stored_values['intl']['hide_disclaimer']?? t('');
    $form['Lang_Specific_Form']['Disclaimer']['Custom_Disclaimer']['#default_value'] = $stored_values[$lang]['custom_disclaimer']?? t('');

    $form['Lang_Specific_Form']['Timestamp']['Date']['#default_value'] = $todays_date;

    $form['Lang_Specific_Form']['Overwrite']['Overwrite_Consent']['#default_value'] = FALSE;


    // Set Fields to Required/NOT Required Dependent on required.yml
      // !!! 'Licence_Title' and 'Custom_Licence_Text' Managed Separately: Directly in Form Via #states
      // !!! 'Overwrite' Managed Separately: Directly in Form Via Condition

    // Get Required Values From YAML File (Default Values ≙ Required Values)
    $req_lang = $default_values[$lang];
    $req_intl = $default_values['intl'];

    // Join Lang and Intl Array
    $req_all = array_merge($req_lang, $req_intl);

    // Set Required Status
    $form['Lang_Specific_Form']['General']['Title']['#required'] = $this->isItRequired('title', $req_all);
    $form['Lang_Specific_Form']['General']['WissKI_URL']['#required'] = $this->isItRequired('wisski_url', $req_all);
    $form['Lang_Specific_Form']['General']['Alias']['#required'] = $this->isItRequired('alias', $req_all);
    $form['Lang_Specific_Form']['General']['Project_Name']['#required'] = $this->isItRequired('project_name', $req_all);

    $form['Lang_Specific_Form']['Publisher']['Publisher_Institute']['#required'] = $this->isItRequired('publisher_institute', $req_all);
    $form['Lang_Specific_Form']['Publisher']['Publisher_Name']['#required'] = $this->isItRequired('publisher_name', $req_all);
    $form['Lang_Specific_Form']['Publisher']['Publisher_Address']['#required'] = $this->isItRequired('publisher_address', $req_all);
    $form['Lang_Specific_Form']['Publisher']['Publisher_PLZ']['#required'] = $this->isItRequired('publisher_plz', $req_all);
    $form['Lang_Specific_Form']['Publisher']['Publisher_City']['#required'] = $this->isItRequired('publisher_city', $req_all);
    $form['Lang_Specific_Form']['Publisher']['Publisher_Email']['#required'] = $this->isItRequired('publisher_email', $req_all);

    $form['Lang_Specific_Form']['Legal_Form_and_Representation']['Custom_Legal_Form']['#required'] = $this->isItRequired('custom_legal_form', $req_all);

    $form['Lang_Specific_Form']['Contact_Content']['Contact_Name']['#required'] = $this->isItRequired('contact_name', $req_all);
    $form['Lang_Specific_Form']['Contact_Content']['Contact_Phone']['#required'] = $this->isItRequired('contact_phone', $req_all);
    $form['Lang_Specific_Form']['Contact_Content']['Contact_Email']['#required'] = $this->isItRequired('contact_email', $req_all);

    $form['Lang_Specific_Form']['Support_and_Hosting']['Support_Institute']['#required'] = $this->isItRequired('support_institute', $req_all);
    $form['Lang_Specific_Form']['Support_and_Hosting']['Support_URL']['#required'] = $this->isItRequired('support_url', $req_all);
    $form['Lang_Specific_Form']['Support_and_Hosting']['Support_Email']['#required'] = $this->isItRequired('support_email', $req_all);
    $form['Lang_Specific_Form']['Support_and_Hosting']['Support_Staff']['#required'] =  $this->isItRequired('support_staff_array', $req_all);

    $form['Lang_Specific_Form']['Supervisory_Authority']['Authority_Name']['#required'] = $this->isItRequired('authority_name', $req_all);
    $form['Lang_Specific_Form']['Supervisory_Authority']['Authority_Address']['#required'] = $this->isItRequired('authority_address', $req_all);
    $form['Lang_Specific_Form']['Supervisory_Authority']['Authority_PLZ']['#required'] = $this->isItRequired('authority_plz', $req_all);
    $form['Lang_Specific_Form']['Supervisory_Authority']['Authority_City']['#required'] = $this->isItRequired('authority_city', $req_all);
    $form['Lang_Specific_Form']['Supervisory_Authority']['Authority_URL']['#required'] = $this->isItRequired('authority_url', $req_all);

    $form['Lang_Specific_Form']['ID_Numbers']['VAT_Number']['#required'] = $this->isItRequired('id_vat', $req_all);
    $form['Lang_Specific_Form']['ID_Numbers']['Tax_Number']['#required'] = $this->isItRequired('id_tax', $req_all);
    $form['Lang_Specific_Form']['ID_Numbers']['DUNS_Number']['#required'] = $this->isItRequired('id_duns', $req_all);
    $form['Lang_Specific_Form']['ID_Numbers']['EORI_Number']['#required'] = $this->isItRequired('id_eori', $req_all);

    // 'Licence_Title' and 'Custom_Licence_Text' Managed Separately: Directly in Form Via #states
    $form['Lang_Specific_Form']['Copyright']['Licence_URL']['#required'] = $this->isItRequired('licence_url', $req_all);
    $form['Lang_Specific_Form']['Copyright']['Use_FAU_Design_Template']['#required'] = $this->isItRequired('uses_fau_design', $req_all);
    $form['Lang_Specific_Form']['Copyright']['No_Default_Text']['#required'] = $this->isItRequired('no_default_txt', $req_all);

    $form['Lang_Specific_Form']['Exclusion_Liab']['Custom_Exclusion_Liab']['#required'] = $this->isItRequired('custom_exclusion', $req_all);

    $form['Lang_Specific_Form']['Disclaimer']['Hide_Disclaimer']['#required'] = $this->isItRequired('hide_disclaimer', $req_all);
    $form['Lang_Specific_Form']['Disclaimer']['Custom_Disclaimer']['#required'] = $this->isItRequired('custom_disclaimer', $req_all);

    $form['Lang_Specific_Form']['Timestamp']['Date']['#required'] = $this->isItRequired('date', $req_all);

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
      return FALSE;
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
        $page_type = 'legal_notice';
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
   * Some of the Values for the Data Array are adjusted:
   * - Format of the Date is Changed to the One Commonly Used in Germany.
   * - Information on Staff in Charge is Converted to an Array to then Display them in Form of a List on the Page.
   *
   * The String Indicating the Page Type is Hard Coded in this Function. This Information will be Passed on to the LegalGenerator of it to Chose the Correct Template for Generation.
   */
  public function submitForm(array &$form, FormStateInterface $form_state){

    // Get Values Entered by User
    $values = $form_state->getValues();

    $lang                 = $values['Chosen_Language'];
    $title                = $values['Title'];
    $wisski_url           = $values['WissKI_URL'];
    $project_name         = $values['Project_Name'];
    $alias                = $values['Alias'];
    $publisher_institute  = $values['Publisher_Institute'];
    $publisher_name       = $values['Publisher_Name'];
    $publisher_address    = $values['Publisher_Address'];
    $publisher_plz        = $values['Publisher_PLZ'];
    $publisher_city       = $values['Publisher_City'];
    $publisher_email      = $values['Publisher_Email'];
    $custom_legal_form    = $values['Custom_Legal_Form'];
    $contact_name         = $values['Contact_Name'];
    $contact_phone        = $values['Contact_Phone'];
    $contact_email        = $values['Contact_Email'];
    $support_institute    = $values['Support_Institute'];
    $support_url          = $values['Support_URL'];
    $support_email        = $values['Support_Email'];
    $support_staff        = $values['Support_Staff'];
    $authority_name       = $values['Authority_Name'];
    $authority_address    = $values['Authority_Address'];
    $authority_plz        = $values['Authority_PLZ'];
    $authority_city       = $values['Authority_City'];
    $authority_url        = $values['Authority_URL'];
    $id_vat               = $values['VAT_Number'];
    $id_tax               = $values['Tax_Number'];
    $id_duns              = $values['DUNS_Number'];
    $id_eori              = $values['EORI_Number'];
    $licence_title        = $values['Licence_Title'];
    $licence_url          = $values['Licence_URL'];
    $uses_fau_design      = $values['Use_FAU_Design_Template'];
    $custom_licence_txt   = $values['Custom_Licence_Text'];
    $no_default_txt       = $values['No_Default_Text'];
    $custom_exclusion     = $values['Custom_Exclusion_Liab'];
    $hide_disclaimer      = $values['Hide_Disclaimer'];
    $custom_disclaimer    = $values['Custom_Disclaimer'];
    $date                 = $values['Date'];
    $overwrite_consent    = $values['Overwrite_Consent'];

    // Convert Staff Info in String to Array to Display as Unordered List on Page
    $support_staff_array = explode(';', $support_staff);
    var_dump($support_staff_array);
    $support_staff_array = array_map('trim', $support_staff_array);

    // Change Date Format
    $date = date('d.m.Y', strtotime($date));


    $data = [
              'wisski_url'             => $wisski_url,
              'project_name'           => $project_name,
              'publisher_institute'    => $publisher_institute,
              'publisher_name'         => $publisher_name,
              'publisher_address'      => $publisher_address,
              'publisher_plz'          => $publisher_plz,
              'publisher_city'         => $publisher_city,
              'publisher_email'        => $publisher_email,
              'custom_legal_form'      => $custom_legal_form,
              'contact_name'           => $contact_name,
              'contact_phone'          => $contact_phone,
              'contact_email'          => $contact_email,
              'support_institute'      => $support_institute,
              'support_url'            => $support_url,
              'support_email'          => $support_email,
              'support_staff_array'    => $support_staff_array,
              'authority_name'         => $authority_name,
              'authority_address'      => $authority_address,
              'authority_plz'          => $authority_plz,
              'authority_city'         => $authority_city,
              'authority_url'          => $authority_url,
              'id_vat'                 => $id_vat,
              'id_tax'                 => $id_tax,
              'id_duns'                => $id_duns,
              'id_eori'                => $id_eori,
              'licence_title'          => $licence_title,
              'licence_url'            => $licence_url,
              'uses_fau_design'        => $uses_fau_design,
              'custom_licence_txt'     => $custom_licence_txt,
              'no_default_txt'         => $no_default_txt,
              'custom_exclusion'       => $custom_exclusion,
              'hide_disclaimer'        => $hide_disclaimer,
              'custom_disclaimer'      => $custom_disclaimer,
              'date'                   => $date,
              'overwrite_consent'      => $overwrite_consent
    ];


    // Parameters to Call Service:

    // a) Key to Select Correct Template for Page Generation
    $page_type = 'legal_notice';

    // b) Keys to Use for Storage in State
    $state_keys_lang = array('title'                 => '',
                             'alias'                 => '',
                             'project_name'          => '',
                             'publisher_institute'   => '',
                             'publisher_name'        => '',
                             'publisher_city'        => '',
                             'custom_legal_form'     => '',
                             'contact_name'          => '',
                             'support_institute'     => '',
                             'support_staff_array'   => '',
                             'authority_name'        => '',
                             'authority_city'        => '',
                             'licence_title'         => '',
                             'uses_fau_design'       => '',
                             'custom_licence_txt'    => '',
                             'no_default_txt'        => '',
                             'custom_exclusion'      => '',
                             'custom_disclaimer'     => '',
                             'overwrite_consent'     => '',
    );

    // c) Keys to Use for Storage in State
    $state_keys_intl = array('wisski_url'            => '',
                             'publisher_address'     => '',
                             'publisher_plz'         => '',
                             'publisher_email'       => '',
                             'contact_phone'         => '',
                             'contact_email'         => '',
                             'support_url'           => '',
                             'support_email'         => '',
                             'licence_url'           => '',
                             'authority_address'     => '',
                             'authority_plz'         => '',
                             'authority_url'         => '',
                             'id_vat'                => '',
                             'id_tax'                => '',
                             'id_duns'               => '',
                             'id_eori'               => '',
                             'hide_disclaimer'       => '',
                             'date'                  => '',
    );


    // Let Service Generate Page
    \Drupal::service('legalgen.generator')->generatePage($data, $title, $alias, $page_type, $lang, $state_keys_lang, $state_keys_intl);
  }
}