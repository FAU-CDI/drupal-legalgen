<?php

namespace Drupal\legalgen\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\State\StateInterface;
use Drupal\legalgen\Generator\LegalGenerator;
use \Drupal\node\Entity\Node;
use \Drupal\Core\Language;

/**
 * Configure example settings for this site.
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
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    // Fields:
    // type of render array element
    // see https://api.drupal.org/api/drupal/elements/8.2.x for available elements

    // Get State Values for Form
    $storedValues = $this->getStateValues();
    $defaultValues = LegalGenerator::REQUIRED_DATA_ALL['REQUIRED_ACCESSIBILITY'];

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
        '#title'         => t('Choose the language in which the accessibility notice should be generated<br /><br />'),
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
    $unset_key = array('Title', 'WissKI_URL', 'Alias', 'Conformity_Status', 'Assessment_Methodology', 'Creation_Date', 'Last_Revision_Date', 'Report_URL', 'Known_Issues', 'Justification_Statement', 'Alternative_Access', 'Contact_Access_Name', 'Contact_Access_Phone', 'Contact_Access_Email', 'Sup_Institute', 'Sup_URL', 'Sup_Address', 'Sup_PLZ', 'Sup_City', 'Sup_Email', 'Oversight_Agency_Name', 'Oversight_Agency_Dept', 'Oversight_Address', 'Oversight_PLZ', 'Oversight_City', 'Oversight_Phone', 'Oversight_Email', 'Oversight_URL', 'Date', 'Overwrite_Consent');

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
            '#required'      => TRUE,
            );

          $form['Lang_Specific_Form']['General']['WissKI_URL'] = array(
            '#type'          => 'textfield',
            '#title'         => t('Accessibility Statement Applies to Content Under the Following Domain(s)'),
            '#required'      => TRUE,
            );


          $form['Lang_Specific_Form']['General']['Alias'] = array(
            '#type'          => 'textfield',
            '#title'         => t('Page Alias'),
            '#required'      => TRUE,
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
        '#required'      => TRUE,
        '#id'          => 'conformity_status',
        '#options'       => [
          'Completely compliant' => 'Completely compliant',
          'Partially compliant'   => 'Partially compliant',
        ],
        );

      $form['Lang_Specific_Form']['Conformity']['Assessment_Methodology'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Assessment Methodology'),
        '#required'      => TRUE,
        );

      $form['Lang_Specific_Form']['Conformity']['Creation_Date'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Report Creation Date'),
        '#required'      => TRUE,
        );

      $form['Lang_Specific_Form']['Conformity']['Last_Revision_Date'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Last Revision Date'),
        '#required'      => TRUE,
        );

      $form['Lang_Specific_Form']['Conformity']['Report_URL'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Report URL'),
        '#required'      => FALSE,
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
        '#description'    => t('Using "; " as separator - e.g. "Issue 1; Issue 2;..." - will create an unordered list'),
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
        '#description'    => t('Using "; " as separator - e.g. "Justification 1; Justification 2;..." - will create an unordered list'),

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
        '#description'    => t('Using "; " as separator - e.g. "Alternative 1; Alternative 2;..." - will create an unordered list'),
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

      $form['Lang_Specific_Form']['Contact_Accessibility']['Contact_Access_Name'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Name Contact Person'),
        '#required'      => TRUE,
        );

      $form['Lang_Specific_Form']['Contact_Accessibility']['Contact_Access_Phone'] = array(
        '#type'          => 'tel',
        '#title'         => t('Phone Contact Person'),
        '#required'      => TRUE,
      );

      $form['Lang_Specific_Form']['Contact_Accessibility']['Contact_Access_Email'] = array(
        '#type'          => 'email',
        '#title'         => t('E-Mail Contact Person'),
        '#required'      => TRUE,
        );


    // Fields: Suppport and Hosting
    $form['Lang_Specific_Form']['Support_and_Hosting'] = array(
      '#type'   => 'details',
      '#title'  => t('Support and Hosting'),
      '#open'   => TRUE,
      );

      $form['Lang_Specific_Form']['Support_and_Hosting']['Sup_Institute'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Institute'),
        '#required'      => TRUE,
        );

        $form['Lang_Specific_Form']['Support_and_Hosting']['Sup_URL'] = array(
          '#type'          => 'textfield',
          '#title'         => t('URL Support and Hosting'),
          '#required'      => TRUE,
          );

        $form['Lang_Specific_Form']['Support_and_Hosting']['Sup_Address'] = array(
          '#type'          => 'textfield',
        '#title'         => t('Street Name and House Number'),
        '#required'      => TRUE,
        );

      $form['Lang_Specific_Form']['Support_and_Hosting']['Sup_PLZ'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Postal Code'),
        '#required'      => TRUE,
        );

      $form['Lang_Specific_Form']['Support_and_Hosting']['Sup_City'] = array(
        '#type'          => 'textfield',
        '#title'         => t('City'),
        '#required'      => TRUE,
      );

      $form['Lang_Specific_Form']['Support_and_Hosting']['Sup_Email'] = array(
        '#type'          => 'email',
        '#title'         => t('E-Mail Support and Hosting'),
        '#required'      => TRUE,
        );


    // Fields: Enforcement Oversight Body
    $form['Lang_Specific_Form']['Oversight Body'] = array(
      '#type'   => 'details',
      '#title'  => t('Enforcement Oversight Body'),
      '#open'   => TRUE,
      );

      $form['Lang_Specific_Form']['Oversight Body']['Oversight_Agency_Name'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Name Oversight Agency'),
        '#required'      => TRUE,
        );

      $form['Lang_Specific_Form']['Oversight Body']['Oversight_Agency_Dept'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Name Department'),
        '#required'      => TRUE,
        );

      $form['Lang_Specific_Form']['Oversight Body']['Oversight_Address'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Street Name and House Number'),
        '#required'      => TRUE,
      );

      $form['Lang_Specific_Form']['Oversight Body']['Oversight_PLZ'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Postal Code'),
        '#required'      => TRUE,
        );

      $form['Lang_Specific_Form']['Oversight Body']['Oversight_City'] = array(
        '#type'          => 'textfield',
        '#title'         => t('City'),
        '#required'      => TRUE,
        );

      $form['Lang_Specific_Form']['Oversight Body']['Oversight_Phone'] = array(
        '#type'          => 'tel',
        '#title'         => t('Phone Oversight Agency'),
        '#required'      => TRUE,
        );

      $form['Lang_Specific_Form']['Oversight Body']['Oversight_Email'] = array(
        '#type'          => 'email',
        '#title'         => t('E-Mail Oversight Agency'),
        '#required'      => TRUE,
        );

      $form['Lang_Specific_Form']['Oversight Body']['Oversight_URL'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Website Oversight Agency '),
        '#required'      => TRUE,
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


// Button: Reset Form Contents to Default
$form['Lang_Specific_Form']['reset_button'] = array(
  '#class' => 'button',
  '#type' => 'submit',
  '#value' => t('Reset to default'),
  '#submit' => [[$this, 'resetAllValues']],
  );


// Populate Fields with Default Values
$form['Lang_Specific_Form']['General']['Title']['#default_value'] = $storedValues[$lang]['title']?? $defaultValues[$lang]['title'];
$form['Lang_Specific_Form']['General']['WissKI_URL']['#default_value'] = $storedValues['intl']['wisski_url']?? \Drupal::request()->getSchemeAndHttpHost();
$form['Lang_Specific_Form']['General']['Alias']['#default_value'] = $storedValues[$lang]['alias']?? $defaultValues[$lang]['alias'];

$form['Lang_Specific_Form']['Conformity']['Conformity_Status']['#default_value'] = $storedValues[$lang]['status']?? $defaultValues[$lang]['status'];
$form['Lang_Specific_Form']['Conformity']['Assessment_Methodology']['#default_value'] = $storedValues[$lang]['methodology']?? $defaultValues[$lang]['methodology'];
$form['Lang_Specific_Form']['Conformity']['Creation_Date']['#default_value'] = $storedValues['intl']['creation_date']?? $defaultValues['intl']['creation_date'];
$form['Lang_Specific_Form']['Conformity']['Last_Revision_Date']['#default_value'] = $storedValues['intl']['last_revis_date']?? $defaultValues['intl']['last_revis_date'];
$form['Lang_Specific_Form']['Conformity']['Report_URL']['#default_value'] = $storedValues['intl']['report_url']?? t('');

$form['Lang_Specific_Form']['Issues']['Known_Issues']['#default_value']  = $storedValues[$lang]['issues_array']?? t('');
$form['Lang_Specific_Form']['Issues']['Justification_Statement']['#default_value']  = $storedValues[$lang]['statement_array']?? t('');
$form['Lang_Specific_Form']['Issues']['Alternative_Access']['#default_value']  = $storedValues[$lang]['alternatives_array']?? t('');

$form['Lang_Specific_Form']['Contact_Accessibility']['Contact_Access_Name']['#default_value'] = $storedValues[$lang]['contact_access_name']?? $defaultValues[$lang]['contact_access_name'];
$form['Lang_Specific_Form']['Contact_Accessibility']['Contact_Access_Phone']['#default_value'] = $storedValues['intl']['contact_access_phone']?? $defaultValues['intl']['contact_access_phone'];
$form['Lang_Specific_Form']['Contact_Accessibility']['Contact_Access_Email']['#default_value'] = $storedValues['intl']['contact_access_email']?? $defaultValues['intl']['contact_access_email'];

$form['Lang_Specific_Form']['Support_and_Hosting']['Sup_Institute']['#default_value'] = $storedValues[$lang]['sup_institute']?? $defaultValues[$lang]['sup_institute'];
$form['Lang_Specific_Form']['Support_and_Hosting']['Sup_URL']['#default_value'] = $storedValues['intl']['sup_url']?? $defaultValues['intl']['sup_url'];
$form['Lang_Specific_Form']['Support_and_Hosting']['Sup_Address']['#default_value'] = $storedValues['intl']['sup_address']?? $defaultValues['intl']['sup_address'];
$form['Lang_Specific_Form']['Support_and_Hosting']['Sup_PLZ']['#default_value'] = $storedValues['intl']['sup_plz']?? $defaultValues['intl']['sup_plz'];
$form['Lang_Specific_Form']['Support_and_Hosting']['Sup_City']['#default_value'] = $storedValues[$lang]['sup_city']?? $defaultValues[$lang]['sup_city'];
$form['Lang_Specific_Form']['Support_and_Hosting']['Sup_Email']['#default_value'] = $storedValues['intl']['sup_email']?? $defaultValues['intl']['sup_email'];

$form['Lang_Specific_Form']['Oversight Body']['Oversight_Agency_Name']['#default_value'] = $storedValues[$lang]['overs_name']?? $defaultValues[$lang]['overs_name'];
$form['Lang_Specific_Form']['Oversight Body']['Oversight_Agency_Dept']['#default_value'] = $storedValues[$lang]['overs_dept']?? $defaultValues[$lang]['overs_dept'];
$form['Lang_Specific_Form']['Oversight Body']['Oversight_Address']['#default_value'] = $storedValues['intl']['overs_address']?? $defaultValues['intl']['overs_address'];
$form['Lang_Specific_Form']['Oversight Body']['Oversight_PLZ']['#default_value'] = $storedValues['intl']['overs_plz']?? $defaultValues['intl']['overs_plz'];
$form['Lang_Specific_Form']['Oversight Body']['Oversight_City']['#default_value'] = $storedValues[$lang]['overs_city']?? $defaultValues[$lang]['overs_city'];
$form['Lang_Specific_Form']['Oversight Body']['Oversight_Phone']['#default_value'] = $storedValues['intl']['overs_phone']?? $defaultValues['intl']['overs_phone'];
$form['Lang_Specific_Form']['Oversight Body']['Oversight_Email']['#default_value'] = $storedValues['intl']['overs_email']?? $defaultValues['intl']['overs_email'];
$form['Lang_Specific_Form']['Oversight Body']['Oversight_URL']['#default_value'] = $storedValues['intl']['overs_url']?? $defaultValues['intl']['overs_url'];

$form['Lang_Specific_Form']['Timestamp']['Date']['#default_value'] = $todays_date;

$form['Lang_Specific_Form']['Overwrite']['Overwrite_Consent']['#default_value'] = FALSE;

return $form;
 }
}


/**
 * Called when user selects language
 * Build Form with Default Values for Selected Language
 * {@inheritdoc}
 */
public function ajaxCallback(array $form, FormStateInterface $form_state){
  return $form['Lang_Specific_Form'];
}


/**
 * Called when user hits reset button
 * {@inheritdoc}
 */
public function resetAllValues(array &$values_stored_in_state, FormStateInterface $form_state) {

  // Get Array from State
  $content_state = \Drupal::state()->get('legalgen.accessibility');

  // Get Language Code Of Selected Form
  $language = $values_stored_in_state['Select_Language']['Chosen_Language'];

  $lang = $language['#value'];

  // Condition (Already Values Stored in State): Replace with Default Values
  if(!empty($content_state[$lang])){

    unset($content_state[$lang]);

    if(!empty($content_state['intl'])){

      unset($content_state['intl']);

      $new_state_vars = array('legalgen.accessibility' => $content_state);

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

    $lang                  = $values['Chosen_Language'];
    $title                 = $values['Title'];
    $wisski_url            = $values['WissKI_URL'];
    $alias                 = $values['Alias'];
    $status                = $values['Conformity_Status'];
    $methodology           = $values['Assessment_Methodology'];
    $creation_date         = $values['Creation_Date'];
    $last_revis_date       = $values['Last_Revision_Date'];
    $report_url            = $values['Report_URL'];
    $known_issues          = $values['Known_Issues'];
    $statement             = $values['Justification_Statement'];
    $alternatives          = $values['Alternative_Access'];
    $contact_access_name   = $values['Contact_Access_Name'];
    $contact_access_phone  = $values['Contact_Access_Phone'];
    $contact_access_email  = $values['Contact_Access_Email'];
    $sup_institute         = $values['Sup_Institute'];
    $sup_url               = $values['Sup_URL'];
    $sup_address           = $values['Sup_Address'];
    $sup_plz               = $values['Sup_PLZ'];
    $sup_city              = $values['Sup_City'];
    $sup_email             = $values['Sup_Email'];
    $overs_name            = $values['Oversight_Agency_Name'];
    $overs_dept            = $values['Oversight_Agency_Dept'];
    $overs_address         = $values['Oversight_Address'];
    $overs_plz             = $values['Oversight_PLZ'];
    $overs_city            = $values['Oversight_City'];
    $overs_phone           = $values['Oversight_Phone'];
    $overs_email           = $values['Oversight_Email'];
    $overs_url             = $values['Oversight_URL'];
    $date                  = $values['Date'];
    $overwrite_consent     = $values['Overwrite_Consent'];

    // Convert Info in String to Array to Display as Unordered List on Page
    $issues_array = explode('; ', $known_issues);
    $statement_array = explode('; ', $statement);
    $alternatives_array = explode('; ', $alternatives);

    // Change Date Format
    $date = date('d.m.Y', strtotime($date));


    $data = [
      'lang'                     => $lang,
      'wisski_url'               => $wisski_url,
      'status'                   => $status,
      'methodology'              => $methodology,
      'creation_date'            => $creation_date,
      'last_revis_date'          => $last_revis_date,
      'report_url'               => $report_url,
      'issues_array'             => $issues_array,
      'statement_array'          => $statement_array,
      'alternatives_array'       => $alternatives_array,
      'contact_access_name'      => $contact_access_name,
      'contact_access_phone'     => $contact_access_phone,
      'contact_access_email'     => $contact_access_email,
      'sup_institute'            => $sup_institute,
      'sup_url'                  => $sup_url,
      'sup_address'              => $sup_address,
      'sup_plz'                  => $sup_plz,
      'sup_city'                 => $sup_city,
      'sup_email'                => $sup_email,
      'overs_name'               => $overs_name,
      'overs_dept'               => $overs_dept,
      'overs_address'            => $overs_address,
      'overs_plz'                => $overs_plz,
      'overs_city'               => $overs_city,
      'overs_phone'              => $overs_phone,
      'overs_email'              => $overs_email,
      'overs_url'                => $overs_url,
      'date'                     => $date,
      'overwrite_consent'        => $overwrite_consent
    ];

    // Parameters to Call Service:

    // a) Key to Select Correct Template for Page Generation
    $page_name = 'accessibility';

    // b) Keys to Use for Storage in State
    $state_keys_lang = array('title'                 => '',
                             'alias'                 => '',
                             'status'                => '',
                             'methodology'           => '',
                             'issues_array'          => '',
                             'statement_array'       => '',
                             'alternatives_array'    => '',
                             'contact_access_name'   => '',
                             'sup_institute'         => '',
                             'sup_city'              => '',
                             'overs_name'            => '',
                             'overs_dept'            => '',
                             'overs_city'            => '',
                             'overwrite_consent'     => '',
    );

    // c) Keys to Use for Storage in State
    $state_keys_intl = array('wisski_url'            => '',
                             'creation_date'         => '',
                             'last_revis_date'       => '',
                             'report_url'            => '',
                             'contact_access_phone'  => '',
                             'contact_access_email'  => '',
                             'sup_url'               => '',
                             'sup_address'           => '',
                             'sup_plz'               => '',
                             'sup_email'             => '',
                             'overs_address'         => '',
                             'overs_plz'             => '',
                             'overs_phone'           => '',
                             'overs_email'           => '',
                             'overs_url'             => '',
                             'date'                  => '',
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


