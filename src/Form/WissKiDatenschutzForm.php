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
class WissKiDatenschutzForm extends FormBase{

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
    if (!empty(\Drupal::state()->get('wisski_impressum.privacy'))) {
      return \Drupal::state()->get('wisski_impressum.privacy');
    } else {
      return NULL;
    }
  }


  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state){

    // Get info from config
    $config = array_keys(\Drupal::configFactory()->get('wisski_impressum.languages')->getRawData());
    unset($config['_core']);

    // Fields
    // type of render array element
    // see https://api.drupal.org/api/drupal/elements/8.2.x for available elements

    $storedValues = $this->getStateValues();

    $valuesFromLegalNotice = \Drupal::state()->get('wisski_impressum.legal_notice');

    $defaultValues = WisskiLegalGenerator::REQUIRED_DATA_ALL['REQUIRED_PRIVACY'];


    // Get languages from config
    $options = \Drupal::configFactory()->get('wisski_impressum.languages')->getRawData();
    unset($options['_core']);

    $langOptions = array();

    foreach ($options as $key => $value) {
      $langOptions[$key] = $value['option'];
    }

    $options = array_merge(["0" => 'Please select'], $langOptions);

    // Field: Language Selector
    $form['Select_Language'] = array(
      '#type'        => 'details',
      '#title'       => t('Language'),
      '#open'        => TRUE,
    );

    $form['Select_Language']['Chosen_Language'] = array(
      '#type'          => 'select',
      '#title'         => t('Choose the Language in Which the Privacy Notice Should Be Generated<br /><br />'),
      '#options'       => $options,
      '#ajax'          => [
        'callback'        => '::ajaxCallback',
        'event'           => 'change',
        'wrapper'         => 'formDiv',
        'event'           => 'change',
      ],
    );

    // Ajax Form
    $form['Lang_Specific_Form'] = [
      '#type'  => 'item',
      '#prefix' => '<div id="formDiv">',
      '#suffix' => '</div>'
    ];

    $form_state->setRebuild(TRUE);

    $lang = $form_state->getValue('Chosen_Language');

    $input = $form_state->getUserInput();

    // Reset all values for form keys but ensure that Chosen_Language is NOT reset
    $unsetKey = array('Title', 'WissKI_URL', 'Alias', 'Not_FAU', 'Legal_Notice_URL', 'Sec_Off_Title', 'Sec_Off_Name', 'Sec_Off_Add', 'Sec_Off_Address', 'Sec_Off_PLZ', 'Sec_Off_City', 'Sec_Off_Phone', 'Sec_Off_Fax', 'Sec_Off_Email', 'Third_Service_Provider', 'Third_Descr_Data_Coll', 'Third_Legal_Basis_Data_Coll', 'Third_Objection_Data_Coll', 'Data_Comm_Title', 'Data_Comm_Address', 'Data_Comm_PLZ', 'Data_Comm_City', 'Date', 'Overwrite_Consent');

    foreach ($unsetKey as $key) {
     unset($input[$key]);
    }

    $form_state->setUserInput($input);

    // !!!!!!!!!!!!!! Data Type and Identical Operator
    if ($lang == 0 || empty($lang)) {
      return $form;
    }

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

      $form['Lang_Specific_Form']['General']['WissKI_URL'] = array(
        '#type'          => 'textfield',
        '#title'         => t('WissKI URL'),
        '#required'      => TRUE,
      );

      $form['Lang_Specific_Form']['General']['Alias'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Page Alias'),
        '#required'      => TRUE,
      );

      $form['Lang_Specific_Form']['General']['Not_FAU'] = array(
        '#type'          => 'textarea',
        '#title'         => t('Paragraphs on the Person Responsible Within the Meaning of the General Data Protection Regulation<br/>ONLY FILL IN IF YOU WANT TO: Replace FAU-specific Text with Custom Text'),
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
        '#required'      => FALSE,
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
        '#title'         => t('E-mail Data Security Official'),
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
        '#required'      => FALSE,
      );

      $form['Lang_Specific_Form']['Third_Party_Services']['Third_Descr_Data_Coll'] = array(
        '#type'          => 'textarea',
        '#title'         => t('Description and Scope Data Processing'),
        '#required'      => FALSE,
      );

      $form['Lang_Specific_Form']['Third_Party_Services']['Third_Legal_Basis_Data_Coll'] = array(
        '#type'          => 'textarea',
        '#title'         => t('Legal Basis for Processing of Personal Data'),
        '#required'      => FALSE,
      );

      $form['Lang_Specific_Form']['Third_Party_Services']['Third_Objection_Data_Coll'] = array(
        '#type'          => 'textarea',
        '#title'         => t('Objection and Elimination'),
        '#optional'      => TRUE,
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
        '#title'         => t('Postal code'),
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
      '#type'          => 'checkbox',
      '#prefix' => '<p>',
      '#title'         => t('<strong>OVERWRITE existent privacy declaration</strong>'),
      '#suffix' => '</p>',
      '#required'      => FALSE,
      );


    // Submit Form and Populate Template
    $form['Lang_Specific_Form']['submit_button'] = array(
      '#type'  => 'submit',
      '#value' => t('Generate'),
    );


    // Reset Form Contents to Default
    $form['Lang_Specific_Form']['reset_button'] = array(
      '#class' => 'button',
      '#type' => 'submit',
      '#value' => t('Reset to default'),
      '#submit' => [[$this, 'resetAllValues']],
    );


    // Default Values
    $form['Lang_Specific_Form']['General']['Title']['#default_value'] = $storedValues[$lang]['title'] ?? $defaultValues[$lang]['title'];
    $form['Lang_Specific_Form']['General']['WissKI_URL']['#default_value'] = $storedValues['intl']['wisski_url'] ?? $defaultValues['intl']['wisski_url'];
    $form['Lang_Specific_Form']['General']['Alias']['#default_value'] = $storedValues[$lang]['alias'] ?? $defaultValues[$lang]['alias'];
    $form['Lang_Specific_Form']['General']['Not_FAU']['#default_value'] = $storedValues[$lang]['not_fau'] ?? t('');
    $form['Lang_Specific_Form']['General']['Legal_Notice_URL']['#default_value'] = $valuesFromLegalNotice[$lang]['alias'] ?? WisskiLegalGenerator::REQUIRED_LEGAL_NOTICE_ALIAS_DE;

    $form['Lang_Specific_Form']['Data_Security_Official']['Sec_Off_Title']['#default_value'] = $storedValues[$lang]['sec_off_title'] ?? $defaultValues[$lang]['sec_off_title'];
    $form['Lang_Specific_Form']['Data_Security_Official']['Sec_Off_Name']['#default_value'] = $storedValues[$lang]['sec_off_name'] ?? $defaultValues[$lang]['sec_off_name'];
    $form['Lang_Specific_Form']['Data_Security_Official']['Sec_Off_Add']['#default_value'] = $storedValues[$lang]['sec_off_add'] ?? $defaultValues[$lang]['sec_off_add'];
    $form['Lang_Specific_Form']['Data_Security_Official']['Sec_Off_Address']['#default_value'] = $storedValues['intl']['sec_off_address'] ?? $defaultValues['intl']['sec_off_address'];
    $form['Lang_Specific_Form']['Data_Security_Official']['Sec_Off_PLZ']['#default_value'] = $storedValues['intl']['sec_off_plz'] ?? $defaultValues['intl']['sec_off_plz'];
    $form['Lang_Specific_Form']['Data_Security_Official']['Sec_Off_City']['#default_value'] = $storedValues[$lang]['sec_off_city'] ?? $defaultValues[$lang]['sec_off_city'];
    $form['Lang_Specific_Form']['Data_Security_Official']['Sec_Off_Phone']['#default_value'] = $storedValues['intl']['sec_off_phone'] ?? $defaultValues['intl']['sec_off_phone'];
    $form['Lang_Specific_Form']['Data_Security_Official']['Sec_Off_Fax']['#default_value'] = $storedValues['intl']['sec_off_fax'] ?? t('');
    $form['Lang_Specific_Form']['Data_Security_Official']['Sec_Off_Email']['#default_value'] = $storedValues['intl']['sec_off_email'] ?? $defaultValues['intl']['sec_off_email'];

    $form['Lang_Specific_Form']['Third_Party_Services']['Third_Service_Provider']['#default_value'] = $storedValues[$lang]['third_service_provider'] ?? t('');
    $form['Lang_Specific_Form']['Third_Party_Services']['Third_Descr_Data_Coll']['#default_value'] = $storedValues[$lang]['third_descr_data_coll'] ?? t('');
    $form['Lang_Specific_Form']['Third_Party_Services']['Third_Legal_Basis_Data_Coll']['#default_value'] = $storedValues[$lang]['third_legal_basis_data_coll'] ?? t('');
    $form['Lang_Specific_Form']['Third_Party_Services']['Third_Objection_Data_Coll']['#default_value'] = $storedValues[$lang]['third_objection_data_coll'] ?? t('');


    $form['Lang_Specific_Form']['Data_Protection_Commissioner']['Data_Comm_Title']['#default_value'] = $storedValues[$lang]['data_comm_title'] ?? $defaultValues[$lang]['data_comm_title'];
    $form['Lang_Specific_Form']['Data_Protection_Commissioner']['Data_Comm_Address']['#default_value'] = $storedValues['intl']['data_comm_address'] ?? $defaultValues['intl']['data_comm_address'];
    $form['Lang_Specific_Form']['Data_Protection_Commissioner']['Data_Comm_PLZ']['#default_value'] = $storedValues['intl']['data_comm_plz'] ?? $defaultValues['intl']['data_comm_plz'];
    $form['Lang_Specific_Form']['Data_Protection_Commissioner']['Data_Comm_City']['#default_value'] = $storedValues[$lang]['data_comm_city'] ?? $defaultValues[$lang]['data_comm_city'];

    $form['Lang_Specific_Form']['Timestamp']['Date']['#default_value'] = $todays_date;

    $form['Lang_Specific_Form']['Overwrite']['Overwrite_Consent']['#default_value'] = FALSE;

    return $form;
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
   * {@inheritdoc}
   */
  public function resetAllValues(array &$valuesStoredInState, FormStateInterface $form_state){

    // Get State Array
    $content_state = \Drupal::state()->get('wisski_impressum.privacy');

    // Get Language Code Of Selected Form
    $language = $valuesStoredInState['Select_Language']['Chosen_Language'];

    $lang = $language['#value'];

    // If For Language Values are Stored in State
    if (!empty($content_state[$lang])) {

      unset($content_state[$lang]);

      if(!empty($content_state['intl'])){

        unset($content_state['intl']);

        $new_state_vars = array('wisski_impressum.privacy' => $content_state);

        \Drupal::state()->setMultiple($new_state_vars);

      }
    }
  }


  /**
   * Called when the user hits submit button
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state){

    $values = $form_state->getValues();

    $lang                               = $values['Chosen_Language'];
    $title                              = $values['Title'];
    $wisski_url                         = $values['WissKI_URL'];
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

    $data = [
      'lang'                           => $lang,
      'wisski_url'                     => $wisski_url,
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
    $page_name = 'privacy';
    $required_key = 'REQUIRED_PRIVACY';

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

    $state_keys_intl = array('wisski_url'                     => '',
                             'sec_off_address'                => '',
                             'sec_off_plz'                    => '',
                             'sec_off_phone'                  => '',
                             'sec_off_fax'                    => '',
                             'sec_off_email'                  => '',
                             'data_comm_address'              => '',
                             'data_comm_plz'                  => '',
                             'date'                           => '',
  	                        );

    $success =  \Drupal::service('wisski_impressum.generator')->generatePage($data, $title, $alias, $lang, $required_key, $page_name, $state_keys_lang, $state_keys_intl);

    if ($success === 'success'){
      // Get Language for Success Message
      \Drupal::messenger()->addStatus('<a href="/'.$alias.'">Privacy declaration in '.$lang.' generated successfully</a>', 'status', TRUE);
    } else {
      if($success === 'invalid'){
        \Drupal::messenger()->addError('Unfortunately an error ocurred: Required Values Missing', 'status', TRUE);

      } else if ($success === 'unable') {
        \Drupal::messenger()->addError('Unfortunately an error ocurred: Unable to Generate Page for the Following Language: '.$lang, 'status', TRUE);
      }
    }
  }
}
