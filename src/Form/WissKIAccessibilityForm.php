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
 * Configures example settings for this site.
 */
class WissKIAccessibilityForm extends FormBase {

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
    if (!empty(\Drupal::state()->get('legalgen.accessibility'))) {
      return \Drupal::state()->get('legalgen.accessibility');
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
  public function buildForm(array $form, FormStateInterface $form_state) {

    // Fields:
    // type of render array element
    // see https://api.drupal.org/api/drupal/elements/8.2.x for available elements

    // Get State Values for Form
    $stored_values = $this->getStateValues();

    $file_path = dirname(__FILE__) . '/../../legalgen.required.and.email.yml';
    $file_contents = file_get_contents($file_path);
    $default_values_all = Yaml::parse($file_contents);
    $default_values = $default_values_all['REQUIRED_ACCESSIBILITY'];


    // Check if Node Already Exists (Condition for Overwrite Checkbox Display)
    $state_vals = \Drupal::state()->get('legalgen.accessibility');

    if(!empty($state_vals)){
        $nid = (string) $state_vals['node_id'];

        $node = Node::load($nid);

    } else {

        $node = NULL;
    }

    $form = [];

    // Display Link to FAU Accessibility Guidelines (as reference)
    $form['Guidelines'] = array(
      '#type'  => 'details',
      '#title' => t('Digital Accessibility Guidelines for Universities of Applied Sciences in Bavaria (Written in German)'),
      '#open'  => FALSE,
      );

        $form['Guidelines']['Complete_Guidelines_WS'] = array(
          '#type'   => 'item',
          '#markup' => '<a href="https://www.wordpress.rrze.fau.de/tutorials/a11y/" target="_blank" rel="noopener noreferer">Digital Accessibility Guide (FAU Webseite)</a>',
          );

        $form['Guidelines']['Complete_Guidelines_GH'] = array(
          '#type'   => 'item',
          '#markup' => '<a href="https://github.com/RZ-BY/Leitfaden-Barrierefreiheit/" target="_blank" rel="noopener noreferer">Digital Accessibility Guide (RRZE GitHub)</a>',
          );

    // Get languages from config
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
        '#title'         => t('Choose the language in which the accessibility notice should be generated<br /><br />Please note:<br />Changes made here will NOT automatically be applied to already existing pages in other languages. Please make sure to generate them again<br /><br />'),
        '#options'       => $options,
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
    $unset_key = array('Title', 'WissKI_URL', 'Alias', 'Conformity_Status', 'Assessment_Methodology', 'Creation_Date', 'Last_Revision_Date', 'Report_URL', 'Known_Issues', 'Justification_Statement', 'Alternative_Access', 'Contact_Accessibility_Name', 'Contact_Accessibility_Phone', 'Contact_Accessibility_Email', 'Support_Institute', 'Support_URL', 'Support_Address', 'Support_PLZ', 'Support_City', 'Support_Email', 'Oversight_Name', 'Oversight_Dept', 'Oversight_Address', 'Oversight_PLZ', 'Oversight_City', 'Oversight_Phone', 'Oversight_Email', 'Oversight_URL', 'Date', 'Overwrite_Consent');

    foreach ($unset_key as $key) {
      unset($input[$key]);
    }

    $form_state->setUserInput($input);

    if(empty($lang)){
      return $form;
    }

    // Error Message: Language Is not Installed
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
            '#title'         => t('Accessibility Statement Applies to Content Under the Following URL(s)'),
            );


          $form['Lang_Specific_Form']['General']['Alias'] = array(
            '#type'          => 'textfield',
            '#title'         => t('Page Alias'),
            );


    // Fields: Conformity
    $form['Lang_Specific_Form']['Conformity'] = array(
      '#type'        => 'details',
      '#title'       => t('Conformity'),
      '#open'        => TRUE,
      );

      $form['Lang_Specific_Form']['Conformity']['Test_Guidelines'] = array(
        '#type'   => 'item',
        '#markup' => '<a href="https://www.wordpress.rrze.fau.de/tutorials/a11y/tests-der-barrierefreiheit/" target="_blank" rel="noopener noreferer">FAU Guide to Digital Accessibility Testing (Written in German)</a>',
        );

      $form['Lang_Specific_Form']['Conformity']['Conformity_Status'] = array(
        '#type'          => 'select',
        '#title'         => t('Conformity Status'),
        '#id'          => 'conformity_status',
        '#options'       => [
          'Completely compliant' => 'Completely compliant',
          'Partially compliant'   => 'Partially compliant',
        ],
        );

      $form['Lang_Specific_Form']['Conformity']['Assessment_Methodology'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Assessment Methodology'),
        );

      $form['Lang_Specific_Form']['Conformity']['Creation_Date'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Report Creation Date'),
        );

      $form['Lang_Specific_Form']['Conformity']['Last_Revision_Date'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Last Revision Date'),
        );

      $form['Lang_Specific_Form']['Conformity']['Report_URL'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Report URL'),
        );


    // Fields: Contents Not Accessible to All
    $form['Lang_Specific_Form']['Issues'] = array(
      '#type'        => 'details',
      '#title'       => t('Contents Not Accessible to All'),
      '#open'        => TRUE,
      // Condition (Conformity Status == Completely Compliant): Fields Visible and Required
      '#states' => [
        'visible' => [
          ':input[id="conformity_status"]' => [
            '!value' => 'Completely compliant',
          ],
          'and',
          '#required' => TRUE,
        ],
      ],
      );

      $form['Lang_Specific_Form']['Issues']['Known_Issues'] = array(
        '#type'           => 'textarea',
        '#title'          => t('Content That Is Not Accessible to All'),
        '#description'    => t('Using ";" as separator - e.g. "Issue 1; Issue 2;..." - will create an unordered list'),
        // Condition (Conformity Status == Completely Compliant): Field Visible and Required
        '#states' => [
          'visible' => [
            ':input[id="conformity_status"]' => [
              '!value' => 'Completely compliant',
            ],
          ],
          'required' => [
            [':input[id="conformity_status"]' => [
              '!value' => 'Completely compliant'
              ],
            ],
          ],
        ],
        );

      $form['Lang_Specific_Form']['Issues']['Justification_Statement'] = array(
        '#type'           => 'textarea',
        '#title'          => t('Justification'),
        '#description'    => t('Using ";" as separator - e.g. "Justification 1; Justification 2;..." - will create an unordered list'),

        '#states' => [
          'visible' => [
            ':input[id="conformity_status"]' => [
              '!value' => 'Completely compliant',
            ],
          ],
          'required' => [
          [':input[id="conformity_status"]' => [
            '!value' => 'Completely compliant'
            ],
          ],
        ],
        ],
        );

      $form['Lang_Specific_Form']['Issues']['Alternative_Access'] = array(
        '#type'           => 'textarea',
        '#title'          => t('Alternative Ways of Access'),
        '#description'    => t('Using ";" as separator - e.g. "Alternative 1; Alternative 2;..." - will create an unordered list'),
       // Condition (Conformity Status == Completely Compliant): Field Visible and Required
        '#states' => [
          'visible' => [
            ':input[id="conformity_status"]' => [
              '!value' => 'Completely compliant',
            ],
          ],
          'required' => [
          [':input[id="conformity_status"]' => [
            '!value' => 'Completely compliant'
            ],
          ],
        ],
        ],
        );


    // Fields: Contact Person
    $form['Lang_Specific_Form']['Contact_Accessibility'] = array(
      '#type'  => 'details',
      '#title' => t('Contact Person'),
      '#open'  => TRUE,
      );

      $form['Lang_Specific_Form']['Contact_Accessibility']['Contact_Accessibility_Name'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Name Contact Person'),
        );

      $form['Lang_Specific_Form']['Contact_Accessibility']['Contact_Accessibility_Phone'] = array(
        '#type'          => 'tel',
        '#title'         => t('Phone Contact Person'),
      );

      $form['Lang_Specific_Form']['Contact_Accessibility']['Contact_Accessibility_Email'] = array(
        '#type'          => 'email',
        '#title'         => t('E-Mail Contact Person'),
        );


    // Fields: Suppport and Hosting
    $form['Lang_Specific_Form']['Support_and_Hosting'] = array(
      '#type'   => 'details',
      '#title'  => t('Support and Hosting'),
      '#open'   => TRUE,
      );

      $form['Lang_Specific_Form']['Support_and_Hosting']['Support_Institute'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Institute'),
        );

        $form['Lang_Specific_Form']['Support_and_Hosting']['Support_URL'] = array(
          '#type'          => 'textfield',
          '#title'         => t('URL Support and Hosting'),

          );

        $form['Lang_Specific_Form']['Support_and_Hosting']['Support_Address'] = array(
          '#type'          => 'textfield',
        '#title'         => t('Street Name and House Number'),
        );

      $form['Lang_Specific_Form']['Support_and_Hosting']['Support_PLZ'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Postal Code'),
        );

      $form['Lang_Specific_Form']['Support_and_Hosting']['Support_City'] = array(
        '#type'          => 'textfield',
        '#title'         => t('City'),
      );

      $form['Lang_Specific_Form']['Support_and_Hosting']['Support_Email'] = array(
        '#type'          => 'email',
        '#title'         => t('E-Mail Support and Hosting'),
        );


    // Fields: Enforcement Oversight Body
    $form['Lang_Specific_Form']['Oversight Body'] = array(
      '#type'   => 'details',
      '#title'  => t('Enforcement Oversight Body'),
      '#open'   => TRUE,
      );

      $form['Lang_Specific_Form']['Oversight Body']['Oversight_Name'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Name Oversight Agency'),
        );

      $form['Lang_Specific_Form']['Oversight Body']['Oversight_Dept'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Name Department'),
        );

      $form['Lang_Specific_Form']['Oversight Body']['Oversight_Address'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Street Name and House Number'),
      );

      $form['Lang_Specific_Form']['Oversight Body']['Oversight_PLZ'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Postal Code'),
        );

      $form['Lang_Specific_Form']['Oversight Body']['Oversight_City'] = array(
        '#type'          => 'textfield',
        '#title'         => t('City'),
        );

      $form['Lang_Specific_Form']['Oversight Body']['Oversight_Phone'] = array(
        '#type'          => 'tel',
        '#title'         => t('Phone Oversight Agency'),
        );

      $form['Lang_Specific_Form']['Oversight Body']['Oversight_Email'] = array(
        '#type'          => 'email',
        '#title'         => t('E-Mail Oversight Agency'),
        );

      $form['Lang_Specific_Form']['Oversight Body']['Oversight_URL'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Website Oversight Agency '),
        );


    // Field: Timestamp
    $form['Lang_Specific_Form']['Timestamp'] = array(
      '#type'  => 'details',
      '#title' => t('Date of Page Generation'),
      '#open'  => TRUE,
      );

        // Get Today Date
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
  '#title'     => t('<strong>OVERWRITE existent accessibility declaration</strong>'),
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

// Button: Submit Form Contents and Populate Template
    $form['Lang_Specific_Form']['submit_button'] = array(
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
$form['Lang_Specific_Form']['General']['WissKI_URL']['#default_value'] = $stored_values['intl']['wisski_url']?? \Drupal::request()->getSchemeAndHttpHost();
$form['Lang_Specific_Form']['General']['Alias']['#default_value'] = $stored_values[$lang]['alias']?? $default_values[$lang]['alias'];

$form['Lang_Specific_Form']['Conformity']['Conformity_Status']['#default_value'] = $stored_values['intl']['status']?? $default_values['intl']['status'];
$form['Lang_Specific_Form']['Conformity']['Assessment_Methodology']['#default_value'] = $stored_values[$lang]['methodology']?? $default_values[$lang]['methodology'];
$form['Lang_Specific_Form']['Conformity']['Creation_Date']['#default_value'] = $stored_values['intl']['creation_date']?? $default_values['intl']['creation_date'];
$form['Lang_Specific_Form']['Conformity']['Last_Revision_Date']['#default_value'] = $stored_values['intl']['last_revision_date']?? $default_values['intl']['last_revision_date'];
$form['Lang_Specific_Form']['Conformity']['Report_URL']['#default_value'] = $stored_values['intl']['report_url']?? t('');

$form['Lang_Specific_Form']['Issues']['Known_Issues']['#default_value']  = $stored_values[$lang]['issues_array']?? t('');
$form['Lang_Specific_Form']['Issues']['Justification_Statement']['#default_value']  = $stored_values[$lang]['justification_array']?? t('');
$form['Lang_Specific_Form']['Issues']['Alternative_Access']['#default_value']  = $stored_values[$lang]['alternatives_array']?? t('');

$form['Lang_Specific_Form']['Contact_Accessibility']['Contact_Accessibility_Name']['#default_value'] = $stored_values[$lang]['contact_accessibility_name']?? $default_values[$lang]['contact_accessibility_name'];
$form['Lang_Specific_Form']['Contact_Accessibility']['Contact_Accessibility_Phone']['#default_value'] = $stored_values['intl']['contact_accessibility_phone']?? $default_values['intl']['contact_accessibility_phone'];
$form['Lang_Specific_Form']['Contact_Accessibility']['Contact_Accessibility_Email']['#default_value'] = $stored_values['intl']['contact_accessibility_email']?? $default_values['intl']['contact_accessibility_email'];

$form['Lang_Specific_Form']['Support_and_Hosting']['Support_Institute']['#default_value'] = $stored_values[$lang]['support_institute']?? $default_values[$lang]['support_institute'];
$form['Lang_Specific_Form']['Support_and_Hosting']['Support_URL']['#default_value'] = $stored_values['intl']['support_url']?? $default_values['intl']['support_url'];
$form['Lang_Specific_Form']['Support_and_Hosting']['Support_Address']['#default_value'] = $stored_values['intl']['support_address']?? $default_values['intl']['support_address'];
$form['Lang_Specific_Form']['Support_and_Hosting']['Support_PLZ']['#default_value'] = $stored_values['intl']['support_plz']?? $default_values['intl']['support_plz'];
$form['Lang_Specific_Form']['Support_and_Hosting']['Support_City']['#default_value'] = $stored_values[$lang]['support_city']?? $default_values[$lang]['support_city'];
$form['Lang_Specific_Form']['Support_and_Hosting']['Support_Email']['#default_value'] = $stored_values['intl']['support_email']?? $default_values['intl']['support_email'];

$form['Lang_Specific_Form']['Oversight Body']['Oversight_Name']['#default_value'] = $stored_values[$lang]['oversight_name']?? $default_values[$lang]['oversight_name'];
$form['Lang_Specific_Form']['Oversight Body']['Oversight_Dept']['#default_value'] = $stored_values[$lang]['oversight_dept']?? $default_values[$lang]['oversight_dept'];
$form['Lang_Specific_Form']['Oversight Body']['Oversight_Address']['#default_value'] = $stored_values['intl']['oversight_address']?? $default_values['intl']['oversight_address'];
$form['Lang_Specific_Form']['Oversight Body']['Oversight_PLZ']['#default_value'] = $stored_values['intl']['oversight_plz']?? $default_values['intl']['oversight_plz'];
$form['Lang_Specific_Form']['Oversight Body']['Oversight_City']['#default_value'] = $stored_values[$lang]['oversight_city']?? $default_values[$lang]['oversight_city'];
$form['Lang_Specific_Form']['Oversight Body']['Oversight_Phone']['#default_value'] = $stored_values['intl']['oversight_phone']?? $default_values['intl']['oversight_phone'];
$form['Lang_Specific_Form']['Oversight Body']['Oversight_Email']['#default_value'] = $stored_values['intl']['oversight_email']?? $default_values['intl']['oversight_email'];
$form['Lang_Specific_Form']['Oversight Body']['Oversight_URL']['#default_value'] = $stored_values['intl']['oversight_url']?? $default_values['intl']['oversight_url'];

$form['Lang_Specific_Form']['Timestamp']['Date']['#default_value'] = $todays_date;

$form['Lang_Specific_Form']['Overwrite']['Overwrite_Consent']['#default_value'] = FALSE;


// Set Fields to Required/NOT Required Dependent on required.yml
  // !!! 'Known_Issues', 'Justification_Statement', and 'Alternative_Access' Managed Separately: Directly in Form Via #states
  // !!! 'Overwrite' Managed Separately: Directly in Form Via Condition

// Get Required Values From YAML File (Default Values ≙ Required Values)
$req_lang = $default_values[$lang];
$req_intl = $default_values['intl'];

// Join Lang and Intl Array
$req_all = array_merge($req_lang, $req_intl);

// Set Mandatory Fields to Required
$form['Lang_Specific_Form']['General']['Title']['#required'] = $this->isItRequired('title', $req_all);
$form['Lang_Specific_Form']['General']['WissKI_URL']['#required'] = $this->isItRequired('wisski_url', $req_all);
$form['Lang_Specific_Form']['General']['Alias']['#required'] = $this->isItRequired('alias', $req_all);

$form['Lang_Specific_Form']['Conformity']['Conformity_Status']['#required'] = $this->isItRequired('status', $req_all);
$form['Lang_Specific_Form']['Conformity']['Assessment_Methodology']['#required'] = $this->isItRequired('methodology', $req_all);
$form['Lang_Specific_Form']['Conformity']['Creation_Date']['#required'] = $this->isItRequired('creation_date', $req_all);
$form['Lang_Specific_Form']['Conformity']['Last_Revision_Date']['#required'] = $this->isItRequired('last_revision_date', $req_all);
$form['Lang_Specific_Form']['Conformity']['Report_URL']['#required'] = $this->isItRequired('report_url', $req_all);

// 'Known_Issues', 'Justification_Statement', and 'Alternative_Access' Managed Separately: Directly in Form Via #states

$form['Lang_Specific_Form']['Contact_Accessibility']['Contact_Accessibility_Name']['#required'] = $this->isItRequired('contact_accessibility_name', $req_all);
$form['Lang_Specific_Form']['Contact_Accessibility']['Contact_Accessibility_Phone']['#required'] = $this->isItRequired('contact_accessibility_phone', $req_all);
$form['Lang_Specific_Form']['Contact_Accessibility']['Contact_Accessibility_Email']['#required'] = $this->isItRequired('contact_accessibility_email', $req_all);

$form['Lang_Specific_Form']['Support_and_Hosting']['Support_Institute']['#required'] = $this->isItRequired('support_institute', $req_all);
$form['Lang_Specific_Form']['Support_and_Hosting']['Support_URL']['#required'] = $this->isItRequired('support_url', $req_all);
$form['Lang_Specific_Form']['Support_and_Hosting']['Support_Address']['#required'] = $this->isItRequired('support_address', $req_all);
$form['Lang_Specific_Form']['Support_and_Hosting']['Support_PLZ']['#required'] = $this->isItRequired('support_plz', $req_all);
$form['Lang_Specific_Form']['Support_and_Hosting']['Support_City']['#required'] = $this->isItRequired('support_city', $req_all);
$form['Lang_Specific_Form']['Support_and_Hosting']['Support_Email']['#required'] = $this->isItRequired('support_email', $req_all);

$form['Lang_Specific_Form']['Oversight Body']['Oversight_Name']['#required'] = $this->isItRequired('oversight_name', $req_all);
$form['Lang_Specific_Form']['Oversight Body']['Oversight_Dept']['#required'] = $this->isItRequired('oversight_dept', $req_all);
$form['Lang_Specific_Form']['Oversight Body']['Oversight_Address']['#required'] = $this->isItRequired('oversight_address', $req_all);
$form['Lang_Specific_Form']['Oversight Body']['Oversight_PLZ']['#required'] = $this->isItRequired('oversight_plz', $req_all);
$form['Lang_Specific_Form']['Oversight Body']['Oversight_City']['#required'] = $this->isItRequired('oversight_city', $req_all);
$form['Lang_Specific_Form']['Oversight Body']['Oversight_Phone']['#required'] = $this->isItRequired('oversight_phone', $req_all);
$form['Lang_Specific_Form']['Oversight Body']['Oversight_Email']['#required'] = $this->isItRequired('oversight_email', $req_all);
$form['Lang_Specific_Form']['Oversight Body']['Oversight_URL']['#required'] = $this->isItRequired('oversight_url', $req_all);

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
  $page_type = 'accessibility';
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
   * - Information on Accessibility Issues, the Respective Justification and Alternative Ways of Access is Converted to an Array to then Display them in Form of a List on the Page.
   *
   * The String Indicating the Page Type is Hard Coded in this Function. This Information will be Passed on to the LegalGenerator of it to Chose the Correct Template for Generation.
   */
  public function submitForm(array &$form, FormStateInterface $form_state){

    // Get Values Entered by User
    $values = $form_state->getValues();

    $lang                         = $values['Chosen_Language'];
    $title                        = $values['Title'];
    $wisski_url                   = $values['WissKI_URL'];
    $alias                        = $values['Alias'];
    $status                       = $values['Conformity_Status'];
    $methodology                  = $values['Assessment_Methodology'];
    $creation_date                = $values['Creation_Date'];
    $last_revision_date           = $values['Last_Revision_Date'];
    $report_url                   = $values['Report_URL'];
    $known_issues                 = $values['Known_Issues'];
    $justification                = $values['Justification_Statement'];
    $alternatives                 = $values['Alternative_Access'];
    $contact_accessibility_name   = $values['Contact_Accessibility_Name'];
    $contact_accessibility_phone  = $values['Contact_Accessibility_Phone'];
    $contact_accessibility_email  = $values['Contact_Accessibility_Email'];
    $support_institute            = $values['Support_Institute'];
    $support_url                  = $values['Support_URL'];
    $support_address              = $values['Support_Address'];
    $support_plz                  = $values['Support_PLZ'];
    $support_city                 = $values['Support_City'];
    $support_email                = $values['Support_Email'];
    $oversight_name               = $values['Oversight_Name'];
    $oversight_dept               = $values['Oversight_Dept'];
    $oversight_address            = $values['Oversight_Address'];
    $oversight_plz                = $values['Oversight_PLZ'];
    $oversight_city               = $values['Oversight_City'];
    $oversight_phone              = $values['Oversight_Phone'];
    $oversight_email              = $values['Oversight_Email'];
    $oversight_url                = $values['Oversight_URL'];
    $date                         = $values['Date'];
    $overwrite_consent            = $values['Overwrite_Consent'];

    // Convert Info in String to Array to Display as Unordered List on Page
    $issues_array = explode(';', $known_issues);
    var_dump($issues_array);
    $issues_array = array_map('trim', $issues_array);

    $justification_array = explode(';', $justification);
    var_dump($justification_array);
    $justification_array = array_map('trim', $justification_array);

    $alternatives_array = explode(';', $alternatives);
    var_dump($alternatives_array);
    $alternatives_array = array_map('trim', $alternatives_array);

    // Change Date Format
    $date = date('d.m.Y', strtotime($date));


    $data = [
      'lang'                            => $lang,
      'wisski_url'                      => $wisski_url,
      'status'                          => $status,
      'methodology'                     => $methodology,
      'creation_date'                   => $creation_date,
      'last_revision_date'              => $last_revision_date,
      'report_url'                      => $report_url,
      'issues_array'                    => $issues_array,
      'justification_array'             => $justification_array,
      'alternatives_array'              => $alternatives_array,
      'contact_accessibility_name'      => $contact_accessibility_name,
      'contact_accessibility_phone'     => $contact_accessibility_phone,
      'contact_accessibility_email'     => $contact_accessibility_email,
      'support_institute'               => $support_institute,
      'support_url'                     => $support_url,
      'support_address'                 => $support_address,
      'support_plz'                     => $support_plz,
      'support_city'                    => $support_city,
      'support_email'                   => $support_email,
      'oversight_name'                  => $oversight_name,
      'oversight_dept'                  => $oversight_dept,
      'oversight_address'               => $oversight_address,
      'oversight_plz'                   => $oversight_plz,
      'oversight_city'                  => $oversight_city,
      'oversight_phone'                 => $oversight_phone,
      'oversight_email'                 => $oversight_email,
      'oversight_url'                   => $oversight_url,
      'date'                            => $date,
      'overwrite_consent'               => $overwrite_consent
    ];

    // Parameters to Call Service:

    // a) Key to Select Correct Template for Page Generation
    $page_type = 'accessibility';

    // b) Keys to Use for Storage in State
    $state_keys_lang = array('title'                        => '',
                             'alias'                        => '',
                             'methodology'                  => '',
                             'issues_array'                 => '',
                             'justification_array'          => '',
                             'alternatives_array'           => '',
                             'contact_accessibility_name'   => '',
                             'support_institute'            => '',
                             'support_city'                 => '',
                             'oversight_name'               => '',
                             'oversight_dept'               => '',
                             'oversight_city'               => '',
                             'overwrite_consent'            => '',
                            );


    // c) Keys to Use for Storage in State
    $state_keys_intl = array('wisski_url'                   => '',
                             'status'                       => '',
                             'creation_date'                => '',
                             'last_revision_date'           => '',
                             'report_url'                   => '',
                             'contact_accessibility_phone'  => '',
                             'contact_accessibility_email'  => '',
                             'support_url'                  => '',
                             'support_address'              => '',
                             'support_plz'                  => '',
                             'support_email'                => '',
                             'oversight_address'            => '',
                             'oversight_plz'                => '',
                             'oversight_phone'              => '',
                             'oversight_email'              => '',
                             'oversight_url'                => '',
                             'date'                         => '',
    );

    // Let Service Generate Page
    \Drupal::service('legalgen.generator')->generatePage($data, $title, $alias, $page_type, $lang, $state_keys_lang, $state_keys_intl);
  }
}


