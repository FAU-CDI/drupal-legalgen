<?php

namespace Drupal\wisski_impressum\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\State\StateInterface;
use Drupal\wisski_impressum\Generator\WisskiLegalGenerator;
use \Drupal\node\Entity\Node;
use \Drupal\Core\Language;

/**
 * Configure example settings for this site.
 */
class WissKiImpressumForm extends FormBase {

  /**
   * @var \Drupal\wisski_impressum\Generator\WisskiLegalGenerator
   */
  protected $generator;

  /**
   * {@inheritdoc}
   */
  public function __construct(){
    /** @var \Drupal\wisski_impressum\Generator\WisskiLegalGenerator */
    $this->generator = \Drupal::service('wisski_impressum.generator');
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
    if(!empty(\Drupal::state()->get('wisski_impressum.legal_notice'))){
      return \Drupal::state()->get('wisski_impressum.legal_notice');
    }else{
      return NULL;
    }
  }


  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

  // Fields
  // type of render array element
  // see https://api.drupal.org/api/drupal/elements/8.2.x for available elements

  // Get State Values for Form
  $storedValues = $this->getStateValues();
  $defaultValues = WisskiLegalGenerator::REQUIRED_DATA_ALL['REQUIRED_LEGALNOTICE'];

  // Check if Node Already Exists (Condition for Overwrite Checkbox Display)
  $state_vals = \Drupal::state()->get('wisski_impressum.legal_notice');

  if(!empty($state_vals)){
      $nid = (string) $state_vals['node_id'];

      $node = Node::load($nid);

  } else {

      $node = NULL;
  }

  $form = [];

  // Get Languages from Config
  $options = \Drupal::configFactory()->get('wisski_impressum.languages')->getRawData();
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
      '#title'         => t('Choose the language in which the legal notice should be generated<br /><br />'),
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
  $unset_key = array('Title', 'WissKI_URL', 'Alias', 'Project_Name', 'Pub_Institute', 'Pub_Name', 'Pub_Address', 'Pub_PLZ', 'Pub_City', 'Pub_Email', 'Custom_Legal_Form', 'Contact_Name', 'Contact_Phone', 'Contact_Email', 'Sup_Institute', 'Sup_URL', 'Sup_Email', 'Sup_Staff', 'Auth_Name', 'Auth_Address', 'Auth_PLZ', 'Auth_City', 'Auth_URL', 'VAT_Number', 'Tax_Number','DUNS_Number','EORI_Number', 'Licence_Title_Metadata', 'Licence_URL_Metadata', 'Licence_Title_Images', 'Licence_URL_Images', 'Use_FAU_Design_Template', 'No_Default_Text', 'Custom_Licence_Text', 'Custom_Exclusion_Liab', 'Hide_Disclaimer', 'Custom_Disclaimer', 'Date', 'Overwrite_Consent');

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
      '#required'      => TRUE,
      );

    $form['Lang_Specific_Form']['General']['WissKI_URL'] = array(
      '#type'          => 'textfield',
      '#title'         => t('Legal Notice Applies to Content Under the Following Domain(s)'),
      '#required'      => TRUE,
      );

    $form['Lang_Specific_Form']['General']['Alias'] = array(
      '#type'          => 'textfield',
      '#title'         => t('Page Alias'),
      '#required'      => TRUE,
      );

    $form['Lang_Specific_Form']['General']['Project_Name'] = array(
      '#type'          => 'textfield',
      '#title'         => t('Project Name'),
      '#required'      => TRUE,
      );


    // Fields: Publisher
    $form['Lang_Specific_Form']['Publisher'] = array(
      '#type'  => 'details',
      '#title' => t('Publisher'),
      '#open'  => TRUE,
      );

      $form['Lang_Specific_Form']['Publisher']['Pub_Institute'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Institute'),
        '#required'      => FALSE,
        );

      $form['Lang_Specific_Form']['Publisher']['Pub_Name'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Name Publisher'),
        '#required'      => TRUE,
        );

      $form['Lang_Specific_Form']['Publisher']['Pub_Address'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Street Name and House Number'),
        '#required'      => TRUE,
        );

      $form['Lang_Specific_Form']['Publisher']['Pub_PLZ'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Postal Code'),
        '#required'      => TRUE,
        );

      $form['Lang_Specific_Form']['Publisher']['Pub_City'] = array(
        '#type'          => 'textfield',
        '#title'         => t('City'),
        '#required'      => TRUE,
        );

      $form['Lang_Specific_Form']['Publisher']['Pub_Email'] = array(
        '#type'          => 'email',
        '#title'         => t('E-Mail Publisher'),
        '#required'      => TRUE,
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
        '#description'   => t('<i>REPLACES DEFAULT TEXT. LEAVE EMPTY TO DISPLAY DEFAULT TEXT</i>'),
        '#required'      => FALSE,
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
        '#required'      => TRUE,
        );

      $form['Lang_Specific_Form']['Contact_Content']['Contact_Phone'] = array(
        '#type'          => 'tel',
        '#title'         => t('Phone Contact Person'),
        '#required'      => TRUE,
      );

      $form['Lang_Specific_Form']['Contact_Content']['Contact_Email'] = array(
        '#type'          => 'email',
        '#title'         => t('E-Mail Contact Person'),
        '#required'      => TRUE,
        );


    // Fields: Support and Hosting
    $form['Lang_Specific_Form']['Support_and_Hosting'] = array(
      '#type'  => 'details',
      '#title' => t('Support and Hosting'),
      '#open'  => TRUE,
      );

        $form['Lang_Specific_Form']['Support_and_Hosting']['Sup_Institute'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Institute'),
          '#required'      => TRUE,
          );

        $form['Lang_Specific_Form']['Support_and_Hosting']['Sup_URL'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Hompage Support and Hosting'),
          '#required'      => TRUE,
          );

        $form['Lang_Specific_Form']['Support_and_Hosting']['Sup_Email'] = array(
          '#type'          => 'email',
          '#title'         => t('E-Mail Support and Hosting'),
          '#required'      => TRUE,
          );

        $form['Lang_Specific_Form']['Support_and_Hosting']['Sup_Staff'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Staff'),
          '#description'   => t('"; " As Separator - e.g. "Eda Employee; Sujin Staff;..."'),
          '#required'      => TRUE,
          );


    // Fields: Supervisory Authority
    $form['Lang_Specific_Form']['Supervisory_Authority'] = array(
      '#type'  => 'details',
      '#title' => t('Supervisory Authority'),
      '#open'  => TRUE,
      );

      $form['Lang_Specific_Form']['Supervisory_Authority']['Auth_Name'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Name Supervisory Authority'),
        '#required'      => TRUE,
        );

      $form['Lang_Specific_Form']['Supervisory_Authority']['Auth_Address'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Street Name and House Number'),
        '#required'      => TRUE,
        );

      $form['Lang_Specific_Form']['Supervisory_Authority']['Auth_PLZ'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Postal Code'),
        '#required'      => TRUE,
        );

      $form['Lang_Specific_Form']['Supervisory_Authority']['Auth_City'] = array(
        '#type'          => 'textfield',
        '#title'         => t('City'),
        '#required'      => TRUE,
        );

      $form['Lang_Specific_Form']['Supervisory_Authority']['Auth_URL'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Supervisory Authority URL'),
        '#required'      => TRUE,
        );

    // Fields: ID Numbers
    $form['Lang_Specific_Form']['ID_Numbers'] = array(
      '#type'   => 'details',
      '#title'  =>  t(''),
      '#open'   =>  TRUE,
      );

      $form['Lang_Specific_Form']['ID_Numbers']['VAT_Number'] = array(
        '#type'       => 'textfield',
        '#title'      => 'VAT Registration Number',
        '#required'   => TRUE,
      );

      $form['Lang_Specific_Form']['ID_Numbers']['Tax_Number'] = array(
        '#type'       => 'textfield',
        '#title'      => 'Tax Number',
        '#required'   => TRUE,
      );

      $form['Lang_Specific_Form']['ID_Numbers']['DUNS_Number'] = array(
        '#type'       => 'textfield',
        '#title'      => 'DUNS Number',
        '#required'   => TRUE,
      );

      $form['Lang_Specific_Form']['ID_Numbers']['EORI_Number'] = array(
        '#type'       => 'textfield',
        '#title'      => 'EORI Number',
        '#required'   => TRUE,
      );


    // Fields: Copyright
    $form['Lang_Specific_Form']['Copyright'] = array(
      '#type'  => 'details',
      '#title' => t('Copyright / Urheberrecht'),
      '#open'  => TRUE,
      );

        $form['Lang_Specific_Form']['Copyright']['Licence_Title_Metadata'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Metadata Licence Title'),
          // Condition: Input Required if Licence URL Entered by User
          '#states' => [
            'required' => [
            [':input[id="licence_url_meta"]' => [
              '!value' => ''
              ],
            ],
          ],
          ],
          '#required'      => FALSE,
          );

        $form['Lang_Specific_Form']['Copyright']['Licence_URL_Metadata'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Metadata Licence URL'),
          '#id'            => 'licence_url_meta',
          '#required'      => FALSE,
          );

          $form['Lang_Specific_Form']['Copyright']['Licence_Title_Images'] = array(
            '#type'          => 'textfield',
            '#title'         => t('Images Licence Title'),
            '#description'   => t('<i>ONLY USE IF MAJORITY OR ALL IMAGES HAVE/HAS SAME LICENCE</i>'),
            // Condition: Input Required if Licence URL Entered by User
            '#states' => [
              'required' => [
              [':input[id="licence_url_imgs"]' => [
                '!value' => ''
                ],
              ],
            ],
            ],
            '#required'      => FALSE,
            );

          $form['Lang_Specific_Form']['Copyright']['Licence_URL_Images'] = array(
            '#type'          => 'textfield',
            '#title'         => t('Images Licence URL'),
            '#id'            => 'licence_url_imgs',
            '#required'      => FALSE,
            );

        $form['Lang_Specific_Form']['Copyright']['Use_FAU_Design_Template'] = array(
          '#type'          => 'checkbox',
          '#title'         => t('Use Of FAU Corporate Design (with or Without Modifications)'),
          '#required'      => FALSE,
          );

        $form['Lang_Specific_Form']['Copyright']['Custom_Licence_Text'] = array(
            '#type'          => 'textarea',
            '#title'         => t('Custom Information On Licence(s)'),
            '#description'   => t('<i>DISPLAYED IN ADDITION TO DEFAULT TEXT. LEAVE EMPTY TO ONLY DISPLAY DEFAULT TEXT</i>'),
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
          '#title'         => t('Display text in textarea \'Custom Information On Licence(s)\' instead of default text in section \'Copyright\''),
          '#description'   => t('<i>REPLACES ALL EXCEPT INFO ON private use AND ON content not protected by copyright law</i>'),
          '#required'      => FALSE,
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
          '#description'   => t('<i>ADDED AFTER DEFAULT TEXT. LEAVE EMPTY TO ONLY DISPLAY DEFAULT TEXT</i>'),
          '#required'      => FALSE,
          );


    // Field and Checkbox: Diclaimer External Links
    $form['Lang_Specific_Form']['Disclaimer'] = array(
      '#type'  => 'details',
      '#title' => t('Disclaimer External Links'),
      '#open'  => TRUE,
      );

        $form['Lang_Specific_Form']['Disclaimer']['Hide_Disclaimer'] = array(
          '#type'          => 'checkbox',
          '#title'         => t('No External Links Are Used'),
          '#description'   => t('<i>WHOLE SECTION WILL BE HIDDEN. NEITHER DEFAULT TEXT NOR CUSTOM TEXT FROM TEXTAREA BELOW WILL BE DISPLAYED</i>'),
          '#required'      => FALSE,
          );

        $form['Lang_Specific_Form']['Disclaimer']['Custom_Disclaimer'] = array(
          '#type'          => 'textarea',
          '#title'         => t('Add Custom Information on Liability For links'),
          '#description'   => t('<i>REPLACES DEFAULT TEXT. LEAVE EMPTY TO DISPLAY DEFAULT TEXT</i>'),
          '#required'      => FALSE,
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
          '#required'      => TRUE,
        );


  // Disclaimer
  $form['Lang_Specific_Form']['Notice'] = array(
    '#type'   => 'item',
    '#prefix' => '<br / ><p><strong>',
    '#suffix' => '</strong></p>',
    '#markup' => t('No liability is assumed for the correctness of the data entered.<br />
                    Please verify the accuracy of the generated pages.'),
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
    $form['Lang_Specific_Form']['submit_button'] = array(
        '#type'  => 'submit',
        '#value' => t('Generate'),
        );

    // Button: Reset Form Contents to Default
    $form['Lang_Specific_Form']['reset_button'] = array(
      '#class'  => 'button',
      '#type'   => 'submit',
      '#value'  => t('Reset to Default'),
      '#submit' => [[$this, 'resetAllValues']],
      );


    // Populate Fields with Default Values
    $form['Lang_Specific_Form']['General']['Title']['#default_value'] = $storedValues[$lang]['title']?? $defaultValues[$lang]['title'];
    $form['Lang_Specific_Form']['General']['WissKI_URL']['#default_value'] = $storedValues['intl']['wisski_url'] ?? \Drupal::request()->getSchemeAndHttpHost();
    $form['Lang_Specific_Form']['General']['Alias']['#default_value'] = $storedValues[$lang]['alias']?? $defaultValues[$lang]['alias'];
    $form['Lang_Specific_Form']['General']['Project_Name']['#default_value'] = $storedValues[$lang]['project_name']?? $defaultValues[$lang]['project_name'];

    $form['Lang_Specific_Form']['Publisher']['Pub_Institute']['#default_value'] = $storedValues[$lang]['pub_institute']?? $defaultValues[$lang]['pub_institute'];
    $form['Lang_Specific_Form']['Publisher']['Pub_Name']['#default_value'] = $storedValues[$lang]['pub_name']?? $defaultValues[$lang]['pub_name'];
    $form['Lang_Specific_Form']['Publisher']['Pub_Address']['#default_value'] = $storedValues['intl']['pub_address']?? $defaultValues['intl']['pub_address'];
    $form['Lang_Specific_Form']['Publisher']['Pub_PLZ']['#default_value'] = $storedValues['intl']['pub_plz']?? $defaultValues['intl']['pub_plz'];
    $form['Lang_Specific_Form']['Publisher']['Pub_City']['#default_value'] = $storedValues[$lang]['pub_city']?? $defaultValues[$lang]['pub_city'];
    $form['Lang_Specific_Form']['Publisher']['Pub_Email']['#default_value'] = $storedValues['intl']['pub_email']?? $defaultValues['intl']['pub_email'];

    $form['Lang_Specific_Form']['Legal_Form_and_Representation']['Custom_Legal_Form']['#default_value'] = $storedValues[$lang]['cust_legal_form']?? t('');

    $form['Lang_Specific_Form']['Contact_Content']['Contact_Name']['#default_value'] = $storedValues[$lang]['contact_name']?? $defaultValues[$lang]['contact_name'];
    $form['Lang_Specific_Form']['Contact_Content']['Contact_Phone']['#default_value'] = $storedValues['intl']['contact_phone']?? $defaultValues['intl']['contact_phone'];
    $form['Lang_Specific_Form']['Contact_Content']['Contact_Email']['#default_value'] = $storedValues['intl']['contact_email']?? $defaultValues['intl']['contact_email'];

    $form['Lang_Specific_Form']['Support_and_Hosting']['Sup_Institute']['#default_value'] = $storedValues[$lang]['sup_institute']?? $defaultValues[$lang]['sup_institute'];
    $form['Lang_Specific_Form']['Support_and_Hosting']['Sup_URL']['#default_value'] = $storedValues['intl']['sup_url']?? $defaultValues['intl']['sup_url'];
    $form['Lang_Specific_Form']['Support_and_Hosting']['Sup_Email']['#default_value'] = $storedValues['intl']['sup_email']?? $defaultValues['intl']['sup_email'];
    $form['Lang_Specific_Form']['Support_and_Hosting']['Sup_Staff']['#default_value'] =  $storedValues[$lang]['sup_staff_array']?? t('');

    $form['Lang_Specific_Form']['Supervisory_Authority']['Auth_Name']['#default_value'] = $storedValues[$lang]['auth_name']?? $defaultValues[$lang]['auth_name'];
    $form['Lang_Specific_Form']['Supervisory_Authority']['Auth_Address']['#default_value'] = $storedValues['intl']['auth_address']?? $defaultValues['intl']['auth_address'];
    $form['Lang_Specific_Form']['Supervisory_Authority']['Auth_PLZ']['#default_value'] = $storedValues['intl']['auth_plz']?? $defaultValues['intl']['auth_plz'];
    $form['Lang_Specific_Form']['Supervisory_Authority']['Auth_City']['#default_value'] = $storedValues[$lang]['auth_city']?? $defaultValues[$lang]['auth_city'];
    $form['Lang_Specific_Form']['Supervisory_Authority']['Auth_URL']['#default_value'] = $storedValues['intl']['auth_url']?? $defaultValues['intl']['auth_url'];

    $form['Lang_Specific_Form']['ID_Numbers']['VAT_Number']['#default_value'] = $storedValues['intl']['id_vat']?? $defaultValues['intl']['id_vat'];
    $form['Lang_Specific_Form']['ID_Numbers']['Tax_Number']['#default_value'] = $storedValues['intl']['id_tax']?? $defaultValues['intl']['id_tax'];
    $form['Lang_Specific_Form']['ID_Numbers']['DUNS_Number']['#default_value'] = $storedValues['intl']['id_duns']?? $defaultValues['intl']['id_duns'];
    $form['Lang_Specific_Form']['ID_Numbers']['EORI_Number']['#default_value'] = $storedValues['intl']['id_eori']?? $defaultValues['intl']['id_eori'];

    $form['Lang_Specific_Form']['Copyright']['Licence_Title_Metadata']['#default_value'] = $storedValues[$lang]['licence_title_metadata']?? t('');
    $form['Lang_Specific_Form']['Copyright']['Licence_URL_Metadata']['#default_value'] = $storedValues['intl']['licence_url_metadata']?? t('');
    $form['Lang_Specific_Form']['Copyright']['Licence_Title_Pictures']['#default_value'] = $storedValues[$lang]['licence_title_pictures']?? t('');
    $form['Lang_Specific_Form']['Copyright']['Licence_URL_Pictures']['#default_value'] = $storedValues['intl']['licence_url_pictures']?? t('');
    $form['Lang_Specific_Form']['Copyright']['Use_FAU_Design_Template']['#default_value'] = $storedValues[$lang]['use_fau_temp']?? (FALSE);
    $form['Lang_Specific_Form']['Copyright']['Custom_Licence_Text']['#default_value'] = $storedValues[$lang]['cust_licence_txt']?? t('');
    $form['Lang_Specific_Form']['Copyright']['No_Default_Text']['#default_value'] = $storedValues[$lang]['no_default_txt']?? (FALSE);

    $form['Lang_Specific_Form']['Exclusion_Liab']['Custom_Exclusion_Liab']['#default_value'] = $storedValues[$lang]['cust_exclusion']?? t('');

    $form['Lang_Specific_Form']['Disclaimer']['Hide_Disclaimer']['#default_value'] = $storedValues['intl']['hide_disclaim']?? t('');
    $form['Lang_Specific_Form']['Disclaimer']['Custom_Disclaimer']['#default_value'] = $storedValues[$lang]['cust_disclaim']?? t('');

    $form['Lang_Specific_Form']['Timestamp']['Date']['#default_value'] = $todays_date;

    $form['Lang_Specific_Form']['Overwrite']['Overwrite_Consent']['#default_value'] = FALSE;

    return $form;
  }
  }


  /**
   * Called When User Selects Language
   * Build Form with Default Values for Selected Language
   * {@inheritdoc}
   */
  public function ajaxCallback(array $form, FormStateInterface $form_state){
    return $form['Lang_Specific_Form'];
  }


  /**
   * Called When User Hits Reset Button
   * {@inheritdoc}
   */
  public function resetAllValues(array &$values_stored_in_state, FormStateInterface $form_state) {

    // Get Array from State
    $content_state = \Drupal::state()->get('wisski_impressum.legal_notice');


    // Get Language Code Of Selected Form
    $language = $values_stored_in_state['Select_Language']['Chosen_Language'];

    $lang = $language['#value'];

    // Condition (Already Values Stored in State): Replace with Default Values
    if(!empty($content_state[$lang])){

      unset($content_state[$lang]);

      if(!empty($content_state['intl'])){

        unset($content_state['intl']);

        $new_state_vars = array('wisski_impressum.legal_notice' => $content_state);

        \Drupal::state()->setMultiple($new_state_vars);

      }
    }
  }


  /**
   * Called When User Hits Submit Button
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state){

    // Get Values Entered by User
    $values = $form_state->getValues();

    $lang                 = $values['Chosen_Language'];
    $title                = $values['Title'];
    $wisski_url           = $values['WissKI_URL'];
    $project_name         = $values['Project_Name'];
    $alias                = $values['Alias'];
    $pub_institute        = $values['Pub_Institute'];
    $pub_name             = $values['Pub_Name'];
    $pub_address          = $values['Pub_Address'];
    $pub_plz              = $values['Pub_PLZ'];
    $pub_city             = $values['Pub_City'];
    $pub_email            = $values['Pub_Email'];
    $cust_legal_form      = $values['Custom_Legal_Form'];
    $contact_name         = $values['Contact_Name'];
    $contact_phone        = $values['Contact_Phone'];
    $contact_email        = $values['Contact_Email'];
    $sup_institute        = $values['Sup_Institute'];
    $sup_url              = $values['Sup_URL'];
    $sup_email            = $values['Sup_Email'];
    $sup_staff            = $values['Sup_Staff'];
    $auth_name            = $values['Auth_Name'];
    $auth_address         = $values['Auth_Address'];
    $auth_plz             = $values['Auth_PLZ'];
    $auth_city            = $values['Auth_City'];
    $auth_url             = $values['Auth_URL'];
    $id_vat               = $values['VAT_Number'];
    $id_tax               = $values['Tax_Number'];
    $id_duns              = $values['DUNS_Number'];
    $id_eori              = $values['EORI_Number'];
    $licence_title_meta   = $values['Licence_Title_Metadata'];
    $licence_url_meta     = $values['Licence_URL_Metadata'];
    $licence_title_imgs   = $values['Licence_Title_Images'];
    $licence_url_imgs     = $values['Licence_URL_Images'];
    $use_fau_temp         = $values['Use_FAU_Design_Template'];
    $cust_licence_txt     = $values['Custom_Licence_Text'];
    $no_default_txt       = $values['No_Default_Text'];
    $cust_exclusion       = $values['Custom_Exclusion_Liab'];
    $hide_disclaim        = $values['Hide_Disclaimer'];
    $cust_disclaim        = $values['Custom_Disclaimer'];
    $date                 = $values['Date'];
    $overwrite_consent    = $values['Overwrite_Consent'];

    // Convert Staff Info in String to Array to Display as Unordered List on Page
    $sup_staff_array = explode('; ', $sup_staff);

    // Change Date Format
    $date = date('d.m.Y', strtotime($date));


    $data = [
              'lang'                   => $lang,
              'wisski_url'             => $wisski_url,
              'project_name'           => $project_name,
              'pub_institute'          => $pub_institute,
              'pub_name'               => $pub_name,
              'pub_address'            => $pub_address,
              'pub_plz'                => $pub_plz,
              'pub_city'               => $pub_city,
              'pub_email'              => $pub_email,
              'cust_legal_form'        => $cust_legal_form,
              'contact_name'           => $contact_name,
              'contact_phone'          => $contact_phone,
              'contact_email'          => $contact_email,
              'sup_institute'          => $sup_institute,
              'sup_url'                => $sup_url,
              'sup_email'              => $sup_email,
              'sup_staff_array'        => $sup_staff_array,
              'auth_name'              => $auth_name,
              'auth_address'           => $auth_address,
              'auth_plz'               => $auth_plz,
              'auth_city'              => $auth_city,
              'auth_url'               => $auth_url,
              'id_vat'                 => $id_vat,
              'id_tax'                 => $id_tax,
              'id_duns'                => $id_duns,
              'id_eori'                => $id_eori,
              'licence_title_meta'     => $licence_title_meta,
              'licence_url_meta'       => $licence_url_meta,
              'licence_title_imgs'     => $licence_title_imgs,
              'licence_url_imgs'       => $licence_url_imgs,
              'use_fau_temp'           => $use_fau_temp,
              'cust_licence_txt'       => $cust_licence_txt,
              'no_default_txt'         => $no_default_txt,
              'cust_exclusion'         => $cust_exclusion,
              'hide_disclaim'          => $hide_disclaim,
              'cust_disclaim'          => $cust_disclaim,
              'date'                   => $date,
              'overwrite_consent'      => $overwrite_consent
    ];


    // Parameters to Call Service:

    // a) Key to Select Correct Template for Page Generation
    $page_name = 'legal_notice';

    // b) Keys to Use for Storage in State
    $state_keys_lang = array('title'                 => '',
                             'alias'                 => '',
                             'project_name'          => '',
                             'pub_institute'         => '',
                             'pub_name'              => '',
                             'pub_city'              => '',
                             'cust_legal_form'       => '',
                             'contact_name'          => '',
                             'sup_institute'         => '',
                             'sup_staff_array'       => '',
                             'auth_name'             => '',
                             'auth_city'             => '',
                             'licence_title_meta'    => '',
                             'licence_title_imgs'    => '',
                             'use_fau_temp'          => '',
                             'cust_licence_txt'      => '',
                             'no_default_txt'        => '',
                             'cust_exclusion'        => '',
                             'cust_disclaim'         => '',
                             'overwrite_consent'     => '',
    );

    // c) Keys to Use for Storage in State
    $state_keys_intl = array('wisski_url'            => '',
                             'pub_address'           => '',
                             'pub_plz'               => '',
                             'pub_email'             => '',
                             'contact_phone'         => '',
                             'contact_email'         => '',
                             'sup_url'               => '',
                             'sup_email'             => '',
                             'licence_url_meta'      => '',
                             'licence_url_imgs'      => '',
                             'auth_address'          => '',
                             'auth_plz'              => '',
                             'auth_url'              => '',
                             'id_vat'                => '',
                             'id_tax'                => '',
                             'id_duns'               => '',
                             'id_eori'               => '',
                             'hide_disclaim'         => '',
                             'date'                  => '',
    );

    // Let Service Generate Page
    $success =  \Drupal::service('wisski_impressum.generator')->generatePage($data, $title, $alias, $lang, $page_name, $state_keys_lang, $state_keys_intl);

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