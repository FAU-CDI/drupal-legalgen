<?php

namespace Drupal\wisski_impressum\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\State\StateInterface;
use Drupal\wisski_impressum\Generator\WisskiLegalGenerator;

use \Drupal\node\Entity\Node;

/**
 * Configure example settings for this site.
 */
class WissKiDatenschutzForm extends FormBase {

  /**
   * @var \Drupal\wisski_impressum\Generator\WisskiLegalGenerator
   */
  protected $generator;

  public function __construct()
  {
    /** @var \Drupal\wisski_impressum\Generator\WisskiLegalGenerator */
    $this->generator = \Drupal::service('wisski_impressum.generator');
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return self::class;
  }

  public function getState(){
    return \Drupal::state();
  }


  public function getStateValues(){
    if(!empty(\Drupal::state()->get('wisski_impressum.privacy'))){
      return \Drupal::state()->get('wisski_impressum.privacy');
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

  $storedValues = $this->getStateValues();

  $valuesFromLegalNotice = \Drupal::state()->get('wisski_impressum.legalNotice');

  $defaultValues = WisskiLegalGenerator::REQUIRED_DATA_ALL['REQUIRED_PRIVACY'];


    // Fields: General
    $form['General'] = array(
      '#type'  => 'details',
      '#title' => t('Allgemein / General'),
      '#open'  => TRUE,
      );

        $form['General']['table1'] = array(
          '#type'   => 'table',
          '#title'  => 'Fields',
          '#header' => array('German', 'English'),
        );

          $form['General']['table1']['R1.1']['Title_DE'] = array(
            '#type'          => 'textfield',
            '#title'         => t('Seitentitel'),
            '#default_value' => $storedValues['title_de']?? $defaultValues['title_de'],
            '#required'      => TRUE,
            );

          $form['General']['table1']['R1.1']['Title_EN'] = array(
            '#type'          => 'textfield',
            '#title'         => t('Page title'),
            '#default_value' => $storedValues['title_en']?? $defaultValues['title_en'],
            '#required'      => TRUE,
            );

          $form['General']['table1']['R1.2']['WissKI_URL'] = array(
            '#type'          => 'textfield',
            '#wrapper_attributes' => [
              'colspan' =>  2,
            ],
            '#title'         => t('WissKI URL'),
            '#default_value' => $storedValues['wisski_url']?? $defaultValues['wisski_url'],
            '#required'      => TRUE,
            );

            $form['General']['table1']['R1.3']['Alias_DE'] = array(
            '#type'          => 'textfield',
            '#title'         => t('Seiten-Alias'),
            '#default_value' => $storedValues['alias_de']?? $defaultValues['alias_de'],
            '#required'      => TRUE,
            );

          $form['General']['table1']['R1.3']['Alias_EN'] = array(
            '#type'          => 'textfield',
            '#title'         => t('Site alias'),
            '#default_value' => $storedValues['alias_en']?? $defaultValues['alias_en'],
            '#required'      => TRUE,
            );

          $form['General']['table1']['R1.4']['Not_FAU_DE'] = array(
            '#type'          => 'textarea',
            '#title'         => t('Absätze zu verantwortlicher Person im Sinne der Datenschutz-Grundverordnung<br/>NUR AUSFÜLLEN, WENN GEWÜNSCHT: Ersetzen FAU-spezifischer Absätze durch diesen Text'),
            '#required'      => FALSE,
            '#default_value' => $storedValues['not_fau_de']?? t(''),
            );

          $form['General']['table1']['R1.4']['Not_FAU_EN'] = array(
            '#type'          => 'textarea',
            '#title'         => t('Paragraphs on the person responsible within the meaning of the General Data Protection Regulation<br/>ONLY FILL IN IF YOU WANT TO: Replace FAU-specific text with custom text'),
            '#required'      => FALSE,
            '#default_value' => $storedValues['not_fau_en']?? t(''),
            );

          $form['General']['table1']['R1.5']['Legal_Notice_URL_DE'] = array(
            '#type'          => 'hidden',
            '#title'         => t('Legal notice URL'),
            '#default_value' => $valuesFromLegalNotice['alias_de']?? WisskiLegalGenerator::REQUIRED_LEGAL_NOTICE_ALIAS_DE,
          );

          $form['General']['table1']['R1.5']['Legal_Notice_URL_EN'] = array(
            '#type'          => 'hidden',
            '#title'         => t('Legal notice URL'),
            '#default_value' => $valuesFromLegalNotice['alias_en']?? WisskiLegalGenerator::REQUIRED_LEGAL_NOTICE_ALIAS_EN,
          );


    // Fields: Data Security Official
    $form['Data_Security_Official'] = array(
      '#type'  => 'details',
      '#title' => t('Datenschutzbeauftragte* zuständig für Institution (z.B. FAU) / Data Security Official Responsible for the Institution (e.g. FAU)'),
      '#open'  => TRUE,
      );

        $form['Data_Security_Official']['table2'] = array(
          '#type'   => 'table',
          '#title'  => 'Data security official',
          '#header' => array('German', 'English'),
        );

          $form['Data_Security_Official']['table2']['R2.1']['Sec_Off_Title_DE'] = array(
            '#type'          => 'textfield',
            '#title'         => t('Titel Beauftragte*'),
            '#default_value' => $storedValues['sec_off_title_de']?? $defaultValues['sec_off_title_de'],
            '#required'      => TRUE,
            );

          $form['Data_Security_Official']['table2']['R2.1']['Sec_Off_Title_EN'] = array(
            '#type'          => 'textfield',
            '#title'         => t('Title Data Security Official'),
            '#default_value' => $storedValues['sec_off_title_en']?? $defaultValues['sec_off_title_en'],
            '#required'      => TRUE,
            );

          $form['Data_Security_Official']['table2']['R2.2']['Sec_Off_Name'] = array(
            '#type'          => 'textfield',
            '#wrapper_attributes' => [
              'colspan' =>  2,
            ],
            '#title'         => t('Name Beauftragte* / Name data security official'),
            '#default_value' => $storedValues['sec_off_name']?? $defaultValues['sec_off_name'],
            '#required'      => TRUE,
            );

          $form['Data_Security_Official']['table2']['R2.3']['Sec_Off_Add_DE'] = array(
            '#type'          => 'textfield',
            '#title'         => t('Zusatz Beauftragte*'),
            '#default_value' => $storedValues['sec_off_add_de']?? $defaultValues['sec_off_add_de'],
            '#required'      => FALSE,
            );

          $form['Data_Security_Official']['table2']['R2.3']['Sec_Off_Add_EN'] = array(
            '#type'          => 'textfield',
            '#title'         => t('Name line 2'),
            '#default_value' => $storedValues['sec_off_add_en']?? $defaultValues['sec_off_add_de'],
            '#required'      => FALSE,
            );

          $form['Data_Security_Official']['table2']['R2.4']['Sec_Off_Address'] = array(
            '#type'          => 'textfield',
            '#wrapper_attributes' => [
              'colspan' =>  2,
            ],
            '#title'         => t('Straße und Hausnummer / Street name and house number'),
            '#default_value' => $storedValues['sec_off_address']?? $defaultValues['sec_off_address'],
            '#required'      => TRUE,
            );

          $form['Data_Security_Official']['table2']['R2.5']['Sec_Off_PLZ'] = array(
            '#type'          => 'textfield',
            '#wrapper_attributes' => [
              'colspan' =>  2,
            ],
            '#title'         => t('PLZ / Postal code'),
            '#default_value' => $storedValues['sec_off_plz']?? $defaultValues['sec_off_plz'],
            '#required'      => TRUE,
            );

          $form['Data_Security_Official']['table2']['R2.6']['Sec_Off_City_DE'] = array(
            '#type'          => 'textfield',
            '#title'         => t('Ort'),
            '#default_value' => $storedValues['sec_off_city_de']?? $defaultValues['sec_off_city_de'],
            '#required'      => TRUE,
            );

          $form['Data_Security_Official']['table2']['R2.6']['Sec_Off_City_EN'] = array(
            '#type'          => 'textfield',
            '#title'         => t('City'),
            '#default_value' => $storedValues['sec_off_city_en']?? $defaultValues['sec_off_city_en'],
            '#required'      => TRUE,
            );

          $form['Data_Security_Official']['table2']['R2.7']['Sec_Off_Phone'] = array(
            '#type'          => 'tel',
            '#wrapper_attributes' => [
              'colspan' =>  2,
            ],
            '#title'         => t('Telefon / Phone'),
            '#default_value' => $storedValues['sec_off_phone']?? $defaultValues['sec_off_phone'],
            '#required'      => TRUE,
            );

          $form['Data_Security_Official']['table2']['R2.8']['Sec_Off_Fax'] = array(
            '#type'     => 'tel',
            '#wrapper_attributes' => [
              'colspan' =>  2,
            ],
            '#title'    => t('Fax'),
            '#default_value' => $storedValues['sec_off_fax']?? t(''),
            '#required' => FALSE,
            );

          $form['Data_Security_Official']['table2']['R2.9']['Sec_Off_Email'] = array(
            '#type'          => 'email',
            '#wrapper_attributes' => [
              'colspan' =>  2,
            ],
            '#title'         => t('E-Mail Datenschutzbeauftragte* / E-mail data security official'),
            '#default_value' => $storedValues['sec_off_email']?? $defaultValues['sec_off_email'],
            '#required'      => TRUE,
            );



    // Fields: Third Party Services
    $form['Third_Party_Services'] = array(
      '#type'  => 'details',
      '#title' => t('Externe Drittanbieter / Third Party Services'),
      '#open'  => TRUE,
      );

        $form['Third_Party_Services']['table3'] = array(
          '#type'   => 'table',
          '#title'  => 'Third party services',
          '#header' => array('German', 'English'),
        );

          $form['Third_Party_Services']['table3']['R3.1']['Third_Service_Provider'] = array(
            '#type'          => 'textfield',
            '#wrapper_attributes' => [
              'colspan' =>  2,
            ],
            '#title'         => t('Name'),
            '#default_value' => $storedValues['third_service_provider']?? t(''),
            '#required'      => FALSE,
            );

          $form['Third_Party_Services']['table3']['R3.2']['Third_Descr_Data_Coll_DE'] = array(
            '#type'          => 'textarea',
            '#title'         => t('Beschreibung und Umfang der Datenverarbeitung'),
            '#default_value' => $storedValues['third_descr_data_coll_de']?? t(''),
            '#required'      => FALSE,
            );

          $form['Third_Party_Services']['table3']['R3.2']['Third_Descr_Data_Coll_EN'] = array(
            '#type'          => 'textarea',
            '#title'         => t('Description and scope of data processing'),
            '#default_value' => $storedValues['third_descr_data_coll_en']?? t(''),
            '#required'      => FALSE,
            );

          $form['Third_Party_Services']['table3']['R3.3']['Third_Legal_Basis_Data_Coll_DE'] = array(
            '#type'          => 'textarea',
            '#title'         => t('Rechtsgrundlage für Verarbeitung personenbezogener Daten'),
            '#default_value' => $storedValues['third_legal_basis_data_coll_de']?? t(''),
            '#required'      => FALSE,
            );

          $form['Third_Party_Services']['table3']['R3.3']['Third_Legal_Basis_Data_Coll_EN'] = array(
            '#type'          => 'textarea',
            '#title'         => t('Legal basis for the processing of personal data'),
            '#default_value' => $storedValues['third_legal_basis_data_coll_en']?? t(''),
            '#required'      => FALSE,
            );

          $form['Third_Party_Services']['table3']['R3.4']['Third_Objection_Data_Coll_DE'] = array(
            '#type'          => 'textarea',
            '#title'         => t('Widerspruchs- und Beseitigungsmöglichkeit'),
            '#default_value' => $storedValues['third_objection_data_coll_de']?? t(''),
            '#optional'      => TRUE,
            );

          $form['Third_Party_Services']['table3']['R3.4']['Third_Objection_Data_Coll_EN'] = array(
            '#type'          => 'textarea',
            '#title'         => t('Objection and elimination'),
            '#default_value' => $storedValues['third_objection_data_coll_en']?? t(''),
            '#optional'      => TRUE,
            );


    // Fields: (Bavarian) Data Protection Commissioner
    $form['Data_Protection_Commissioner'] = array(
      '#type'  => 'details',
      '#title' => t('(Bayerische) Landesbeauftragte* für den Datenschutz / (Bavarian) Data Protection Commissioner'),
      '#open'  => TRUE,
      );

        $form['Data_Protection_Commissioner']['table4'] = array(
          '#type'   => 'table',
          '#title'  => 'Data Protection Commissioner',
          '#header' => array('German', 'English'),
        );

          $form['Data_Protection_Commissioner']['table4']['R4.1']['Data_Comm_Title_DE'] = array(
            '#type'          => 'textfield',
            '#title'         => t('Titel Landesbauftragte* (mit bestimmtem Artikel)'),
            '#default_value' => $storedValues['data_comm_title_de']?? $defaultValues['data_comm_title_de'],
            '#required'      => TRUE,
            );

          $form['Data_Protection_Commissioner']['table4']['R4.1']['Data_Comm_Title_EN'] = array(
            '#type'          => 'textfield',
            '#title'         => t('Title Bavarian State Commissioner for Data Protection (without definite article)'),
            '#default_value' => $storedValues['data_comm_title_en']?? $defaultValues['data_comm_title_en'],
            '#required'      => TRUE,
            );

          $form['Data_Protection_Commissioner']['table4']['R4.2']['Data_Comm_Address'] = array(
            '#type'          => 'textfield',
            '#wrapper_attributes' => [
              'colspan' =>  2,
            ],
            '#title'         => t('Straße und Hausnummer/ Street name and house number'),
            '#default_value' => $storedValues['data_comm_address']?? $defaultValues['data_comm_address'],
            '#required'      => TRUE,
            );

          $form['Data_Protection_Commissioner']['table4']['R4.3']['Data_Comm_PLZ'] = array(
            '#type'          => 'textfield',
            '#wrapper_attributes' => [
              'colspan' =>  2,
            ],
            '#title'         => t('PLZ / Postal code'),
            '#default_value' => $storedValues['data_comm_plz']?? $defaultValues['data_comm_plz'],
            '#required'      => TRUE,
            );

          $form['Data_Protection_Commissioner']['table4']['R4.4']['Data_Comm_City_DE'] = array(
            '#type'          => 'textfield',
            '#title'         => t('Ort'),
            '#default_value' => $storedValues['data_comm_city_de']?? $defaultValues['data_comm_city_de'],
            '#required'      => TRUE,
            );

          $form['Data_Protection_Commissioner']['table4']['R4.4']['Data_Comm_City_EN'] = array(
            '#type'          => 'textfield',
            '#title'         => t('City'),
            '#default_value' => $storedValues['data_comm_city_en']?? $defaultValues['data_comm_city_en'],
            '#required'      => TRUE,
            );


    // Field: Timestamp
    $form['Timestamp'] = array(
      '#type'  => 'details',
      '#title' => t('Erstellungsdatum  / Generation Date'),
      '#open'  => TRUE,
      );

        $current_timestamp = \Drupal::time()->getCurrentTime();
        $todays_date = \Drupal::service('date.formatter')->format($current_timestamp, 'custom', 'Y-m-d');

        $form['Timestamp']['Date'] = array(
          '#type'          => 'date',
          '#title'         => t('Erstellungsdatum / Generation Date'),
          '#default_value' => $todays_date,
          '#required'      => TRUE,
        );

    // Disclaimer
    $form['notice'] = array(
      '#type'   => 'item',
      '#prefix' => '<br /><p><strong>',
      '#suffix' => '</strong></p><br />',
      '#markup' => t('Es wird keine Haftung für die Korrektheit der eingegebenen Daten übernommen. / No liability is assumed for the correctness of the data entered.<br />
                      Bitte überprüfen Sie nach der Generierung die erstellten Seiten auf Richtigkeit. / Please verify the accuracy of the generated pages.'),
      );

// Submit Form and Populate Template
    $form['submit_button'] = array(
      '#type'  => 'submit',
      '#value' => t('Erstellen / Generate'),
      );

// Reset Form Contents to Default
    $form['reset_button'] = array(
      '#class' => 'button',
      '#type' => 'submit',
      '#value' => t('Zurücksetzen / Reset to default'),
      '#submit' => [[$this, 'resetAllValues']],
      );

    return $form;
  }


  /**
   * Called when user hits reset button
   * {@inheritdoc}
   */
  public function resetAllValues(array &$valuesStoredInState, FormStateInterface $form_state) {
    if(!empty(\Drupal::state()->get('wisski_impressum.privacy'))){
      \Drupal::state()->delete('wisski_impressum.privacy');
    }
  }


  /**
   * Called when the user hits submit button
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();

    $title_de                           = $values['table1']['R1.1']['Title_DE'];
    $title_en                           = $values['table1']['R1.1']['Title_EN'];
    $wisski_url                         = $values['table1']['R1.2']['WissKI_URL'];
    $alias_de                           = $values['table1']['R1.3']['Alias_DE'];
    $alias_en                           = $values['table1']['R1.3']['Alias_EN'];
    $not_fau_de                         = $values['table1']['R1.4']['Not_FAU_DE'];
    $not_fau_en                         = $values['table1']['R1.4']['Not_FAU_EN'];
    $legal_notice_url_de                = $values['table1']['R1.5']['Legal_Notice_URL_DE'];
    $legal_notice_url_en                = $values['table1']['R1.5']['Legal_Notice_URL_EN'];
    $sec_off_title_de                   = $values['table2']['R2.1']['Sec_Off_Title_DE'];
    $sec_off_title_en                   = $values['table2']['R2.1']['Sec_Off_Title_EN'];
    $sec_off_name                       = $values['table2']['R2.2']['Sec_Off_Name'];
    $sec_off_add_de                     = $values['table2']['R2.3']['Sec_Off_Add_DE'];
    $sec_off_add_en                     = $values['table2']['R2.3']['Sec_Off_Add_EN'];
    $sec_off_address                    = $values['table2']['R2.4']['Sec_Off_Address'];
    $sec_off_plz                        = $values['table2']['R2.5']['Sec_Off_PLZ'];
    $sec_off_city_de                    = $values['table2']['R2.6']['Sec_Off_City_DE'];
    $sec_off_city_en                    = $values['table2']['R2.6']['Sec_Off_City_EN'];
    $sec_off_phone                      = $values['table2']['R2.7']['Sec_Off_Phone'];
    $sec_off_fax                        = $values['table2']['R2.8']['Sec_Off_Fax'];
    $sec_off_email                      = $values['table2']['R2.9']['Sec_Off_Email'];
    $third_service_provider             = $values['table3']['R3.1']['Third_Service_Provider'];
    $third_descr_data_coll_de           = $values['table3']['R3.2']['Third_Descr_Data_Coll_DE'];
    $third_descr_data_coll_en           = $values['table3']['R3.2']['Third_Descr_Data_Coll_EN'];
    $third_legal_basis_data_coll_de     = $values['table3']['R3.3']['Third_Legal_Basis_Data_Coll_DE'];
    $third_legal_basis_data_coll_en     = $values['table3']['R3.3']['Third_Legal_Basis_Data_Coll_EN'];
    $third_objection_data_coll_de       = $values['table3']['R3.4']['Third_Objection_Data_Coll_DE'];
    $third_objection_data_coll_en       = $values['table3']['R3.4']['Third_Objection_Data_Coll_EN'];
    $data_comm_title_de                 = $values['table4']['R4.1']['Data_Comm_Title_DE'];
    $data_comm_title_en                 = $values['table4']['R4.1']['Data_Comm_Title_EN'];
    $data_comm_address                  = $values['table4']['R4.2']['Data_Comm_Address'];
    $data_comm_plz                      = $values['table4']['R4.3']['Data_Comm_PLZ'];
    $data_comm_city_de                  = $values['table4']['R4.4']['Data_Comm_City_DE'];
    $data_comm_city_en                  = $values['table4']['R4.4']['Data_Comm_City_EN'];
    $date                               = $values['Date'];


    $data= [
      'wisski_url'                     => $wisski_url,
      'not_fau_de'                     => $not_fau_de,
      'not_fau_en'                     => $not_fau_en,
      'legal_notice_url_de'            => $legal_notice_url_de,
      'legal_notice_url_en'            => $legal_notice_url_en,
      'sec_off_title_de'               => $sec_off_title_de,
      'sec_off_title_en'               => $sec_off_title_en,
      'sec_off_name'                   => $sec_off_name,
      'sec_off_add_de'                 => $sec_off_add_de,
      'sec_off_add_en'                 => $sec_off_add_en,
      'sec_off_address'                => $sec_off_address,
      'sec_off_plz'                    => $sec_off_plz,
      'sec_off_city_de'                => $sec_off_city_de,
      'sec_off_city_en'                => $sec_off_city_en,
      'sec_off_phone'                  => $sec_off_phone,
      'sec_off_fax'                    => $sec_off_fax,
      'sec_off_email'                  => $sec_off_email,
      'third_service_provider'         => $third_service_provider,
      'third_descr_data_coll_de'       => $third_descr_data_coll_de,
      'third_descr_data_coll_en'       => $third_descr_data_coll_en,
      'third_legal_basis_data_coll_de' => $third_legal_basis_data_coll_de,
      'third_legal_basis_data_coll_en' => $third_legal_basis_data_coll_en,
      'third_objection_data_coll_de'   => $third_objection_data_coll_de,
      'third_objection_data_coll_en'   => $third_objection_data_coll_en,
      'data_comm_title_de'             => $data_comm_title_de,
      'data_comm_title_en'             => $data_comm_title_en,
      'data_comm_address'              => $data_comm_address,
      'data_comm_plz'                  => $data_comm_plz,
      'data_comm_city_de'              => $data_comm_city_de,
      'data_comm_city_en'              => $data_comm_city_en,
      'date'                           => $date,
    ];


    // Call Service:
    $success =  \Drupal::service('wisski_impressum.generator')->generateDatenschutz($data, $title_de, $title_en, $alias_de, $alias_en);

    if($success){
      \Drupal::messenger()->addMessage($this->t('<a href="/'.$alias_de.'">Deutsche Datenschutzerklärung erstellt / German privacy declaration generated successfully</a>'), 'status', TRUE);
      \Drupal::messenger()->addMessage($this->t('<a href="/'.$alias_en.'">Englische Datenschutzerklärung erfolgreich erstellt / English privacy declaration generated successfully</a>'), 'status', TRUE);
    } else{
      \Drupal::messenger()->addMessage($this->t('Leider ist ein Fehler aufgetreten'), 'status', TRUE);
    }
  }
}


