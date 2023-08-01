<?php

namespace Drupal\wisski_impressum\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
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



  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

  // Fields
  // type of render array element
  // see https://api.drupal.org/api/drupal/elements/8.2.x for available elements

    // Disclaimer
    $form['text_header'] = array(
      '#prefix' => '<p><strong>',
      '#suffix' => '</strong></p>',
      '#markup' => t('Das CDI ist nicht für die Korrektheit der eingegebenen Daten verantwortlich. Bitte überprüfen Sie nach der Generierung die erstellten Seiten auf Richtigkeit.'),
      '#weight' => -100,
      );

    // Fields: General
    $form['Fields'] = array(
      '#type'  => 'details',
      '#title' => t('Allgemein / General'),
      '#open'  => true,
      );

        $form['Fields']['table1'] = array(
          '#type'   => 'table',
          '#title'  => 'Fields',
          '#header' => array('German', 'English'),
        );

          $form['Fields']['table1']['R1.1']['title'] = array(
            '#type'          => 'textfield',
            '#title'         => t('Seitentitel'),
            '#default_value' => t('Datenschutz'),
            '#required'      => true,
            );

          $form['Fields']['table1']['R1.1']['Title_EN'] = array(
            '#type'          => 'textfield',
            '#title'         => t('Page title'),
            '#default_value' => t('Privacy'),
            '#required'      => true,
            );

          $form['Fields']['table1']['R1.2']['WissKI_URL'] = array(
            '#type'          => 'textfield',
            '#wrapper_attributes' => [
              'colspan' =>  2,
            ],
            '#title'         => t('WissKI URL'),
            '#default_value' => t('https://mehrdad.wisski.data.fau.de/'),
            '#required'      => true,
            );

            $form['Fields']['table1']['R1.3']['alias'] = array(
            '#type'          => 'textfield',
            '#title'         => t('Seiten-Alias'),
            '#default_value' => t('datenschutz'),
            '#required'      => true,
            );

          $form['Fields']['table1']['R1.3']['alias_EN'] = array(
            '#type'          => 'textfield',
            '#title'         => t('Site alias'),
            '#default_value' => t('privacy'),
            '#required'      => true,
            );

          $form['Fields']['table1']['R1.4']['Not_FAU_DE'] = array(
            '#type'          => 'textarea',
            '#title'         => t('Absätze zu verantwortlicher Person im Sinne der Datenschutz-Grundverordnung<br/>NUR AUSFÜLLEN, WENN GEWÜNSCHT: Ersetzen FAU-spezifischer Absätze durch diesen Text'),
            '#required'      => false,
            );

          $form['Fields']['table1']['R1.4']['Not_FAU_EN'] = array(
            '#type'          => 'textarea',
            '#title'         => t('Paragraphs on the person responsible within the meaning of the General Data Protection Regulation<br/>ONLY FILL IN IF YOU WANT TO: Replace FAU-specific text with custom text'),
            '#required'      => false,
            );


    // Fields: Data Security Official
    $form['Data_Security_Official'] = array(
      '#type'  => 'details',
      '#title' => t('Datenschutzbeauftragte* zuständig für Institution (z.B. FAU) / Data Security Official Responsible for the Institution (e.g. FAU)'),
      '#open'  => true,
      );

        $form['Data_Security_Official']['table2'] = array(
          '#type'   => 'table',
          '#title'  => 'Data security official',
          '#header' => array('German', 'English'),
        );

          $form['Data_Security_Official']['table2']['R2.1']['Sec_Off_Title_DE'] = array(
            '#type'          => 'textfield',
            '#title'         => t('Titel Beauftragte*'),
            '#default_value' => t('Datenschutzbeauftragter der FAU'),
            '#required'      => true,
            );

          $form['Data_Security_Official']['table2']['R2.1']['Sec_Off_Title_EN'] = array(
            '#type'          => 'textfield',
            '#title'         => t('Title Data Security Official'),
            '#default_value' => t('Data Security Official of the FAU'),
            '#required'      => true,
            );

          $form['Data_Security_Official']['table2']['R2.2']['Sec_Off_Name'] = array(
            '#type'          => 'textfield',
            '#wrapper_attributes' => [
              'colspan' =>  2,
            ],
            '#title'         => t('Name Beauftragte* / Name data security official'),
            '#default_value' => t('Klaus Hoogestraat'),
            '#required'      => true,
            );

          $form['Data_Security_Official']['table2']['R2.3']['Sec_Off_Add_DE'] = array(
            '#type'          => 'textfield',
            '#title'         => t('Zusatz Beauftragte*'),
            '#default_value' => t('c/o ITM Gesellschaft für IT-Management mbH'),
            '#required'      => false,
            );

          $form['Data_Security_Official']['table2']['R2.3']['Sec_Off_Add_EN'] = array(
            '#type'          => 'textfield',
            '#title'         => t('Name line 2'),
            '#default_value' => t('c/o ITM Gesellschaft für IT-Management mbH'),
            '#required'      => false,
            );

          $form['Data_Security_Official']['table2']['R2.4']['Sec_Off_Address'] = array(
            '#type'          => 'textfield',
            '#wrapper_attributes' => [
              'colspan' =>  2,
            ],
            '#title'         => t('Straße und Hausnummer / Street name and house number'),
            '#default_value' => t('Bürgerstraße 81'),
            '#required'      => true,
            );

          $form['Data_Security_Official']['table2']['R2.5']['Sec_Off_PLZ'] = array(
            '#type'          => 'textfield',
            '#wrapper_attributes' => [
              'colspan' =>  2,
            ],
            '#title'         => t('PLZ / Postal code'),
            '#default_value' => t('01127'),
            '#required'      => true,
            );

          $form['Data_Security_Official']['table2']['R2.6']['Sec_Off_City_DE'] = array(
            '#type'          => 'textfield',
            '#title'         => t('Ort'),
            '#default_value' => t('Dresden'),
            '#required'      => true,
            );

          $form['Data_Security_Official']['table2']['R2.6']['Sec_Off_City_EN'] = array(
            '#type'          => 'textfield',
            '#title'         => t('City'),
            '#default_value' => t('Dresden'),
            '#required'      => true,
            );

          $form['Data_Security_Official']['table2']['R2.7']['Sec_Off_Email'] = array(
            '#type'          => 'textfield',
            '#wrapper_attributes' => [
              'colspan' =>  2,
            ],
            '#title'         => t('E-Mail Datenschutzbeauftragte* / E-mail data security official'),
            '#default_value' => t('datenschutzbeauftragter@fau.de'),
            '#required'      => true,
            );

          $form['Data_Security_Official']['table2']['R2.8']['Sec_Off_Phone'] = array(
            '#type'          => 'textfield',
            '#wrapper_attributes' => [
              'colspan' =>  2,
            ],
            '#title'         => t('Telefon / Phone'),
            '#default_value' => t('+49 9131 85-25860'),
            '#required'      => true,
            );

          $form['Data_Security_Official']['table2']['R2.9']['Sec_Off_Fax'] = array(
            '#type'     => 'textfield',
            '#wrapper_attributes' => [
              'colspan' =>  2,
            ],
            '#title'    => t('Fax'),
            '#required' => false,
            );


    // Fields: Third Party Services
    $form['Third_Party_Services'] = array(
      '#type'  => 'details',
      '#title' => t('Externe Drittanbieter / Third Party Services'),
      '#open'  => true,
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
            '#required'      => false,
            );

          $form['Third_Party_Services']['table3']['R3.2']['Third_Descr_Data_Coll_DE'] = array(
            '#type'          => 'textarea',
            '#title'         => t('Beschreibung und Umfang der Datenverarbeitung'),
            '#default_value' => t('<<Beschreibung>>'),
            '#required'      => false,
            );

          $form['Third_Party_Services']['table3']['R3.2']['Third_Descr_Data_Coll_EN'] = array(
            '#type'          => 'textarea',
            '#title'         => t('Description and scope of data processing'),
            '#default_value' => t('<<Description>>'),
            '#required'      => false,
            );

          $form['Third_Party_Services']['table3']['R3.3']['Third_Legal_Basis_Data_Coll_DE'] = array(
            '#type'          => 'textarea',
            '#title'         => t('Rechtsgrundlage für Verarbeitung personenbezogener Daten'),
            '#default_value' => t('<<Text zur Rechtsgrundlage>>'),
            '#required'      => false,
            );

          $form['Third_Party_Services']['table3']['R3.3']['Third_Legal_Basis_Data_Coll_EN'] = array(
            '#type'          => 'textarea',
            '#title'         => t('Legal basis for the processing of personal data'),
            '#default_value' => t('<<Text on the legal basis of personal data processing>>'),
            '#required'      => false,
            );

          $form['Third_Party_Services']['table3']['R3.4']['Third_Objection_Data_Coll_DE'] = array(
            '#type'          => 'textarea',
            '#title'         => t('Widerspruchs- und Beseitigungsmöglichkeit'),
            '#default_value' => t('<<Text der Möglichkeiten>>'),
            '#optional'      => true,
            );

          $form['Third_Party_Services']['table3']['R3.4']['Third_Objection_Data_Coll_EN'] = array(
            '#type'          => 'textarea',
            '#title'         => t('Objection and elimination'),
            '#default_value' => t('<<Text on possibilities>>'),
            '#optional'      => true,
            );


    // Fields: (Bavarian) Data Protection Commissioner
    $form['Data_Protection_Commissioner'] = array(
      '#type'  => 'details',
      '#title' => t('(Bayerische) Landesbeauftragte* für den Datenschutz / (Bavarian) Data Protection Commissioner'),
      '#open'  => true,
      );

        $form['Data_Protection_Commissioner']['table4'] = array(
          '#type'   => 'table',
          '#title'  => 'Data Protection Commissioner',
          '#header' => array('German', 'English'),
        );

          $form['Data_Protection_Commissioner']['table4']['R4.1']['Data_Comm_Title_DE'] = array(
            '#type'          => 'textfield',
            '#title'         => t('Titel Landesbauftragte* (mit bestimmtem Artikel)'),
            '#default_value' => t('der Bayerische Landesbeauftragte für den Datenschutz'),
            '#required'      => true,
            );

          $form['Data_Protection_Commissioner']['table4']['R4.1']['Data_Comm_Title_EN'] = array(
            '#type'          => 'textfield',
            '#title'         => t('Title Bavarian State Commissioner for Data Protection (without definite article)'),
            '#default_value' => t('Bavarian State Commissioner for Data Protection'),
            '#required'      => true,
            );

          $form['Data_Protection_Commissioner']['table4']['R4.2']['Data_Comm_Address'] = array(
            '#type'          => 'textfield',
            '#wrapper_attributes' => [
              'colspan' =>  2,
            ],
            '#title'         => t('Straße und Hausnummer/ Street name and house number'),
            '#default_value' => t('Wagmüllerstraße 18'),
            '#required'      => true,
            );

          $form['Data_Protection_Commissioner']['table4']['R4.3']['Data_Comm_PLZ'] = array(
            '#type'          => 'textfield',
            '#wrapper_attributes' => [
              'colspan' =>  2,
            ],
            '#title'         => t('PLZ / Postal code'),
            '#default_value' => t('80538'),
            '#required'      => true,
            );

          $form['Data_Protection_Commissioner']['table4']['R4.4']['Data_Comm_City_DE'] = array(
            '#type'          => 'textfield',
            '#title'         => t('Ort'),
            '#default_value' => t('München'),
            '#required'      => true,
            );

          $form['Data_Protection_Commissioner']['table4']['R4.4']['Data_Comm_City_EN'] = array(
            '#type'          => 'textfield',
            '#title'         => t('City'),
            '#default_value' => t('Munich'),
            '#required'      => true,
            );


    // Field: Timestamp
    $form['Timestamp'] = array(
      '#type'  => 'details',
      '#title' => t('Erstellungsdatum  / Generation Date'),
      '#open'  => true,
      );

        $form['Timestamp']['Date'] = array(
          '#type'          => 'date',
          '#title'         => t('Erstellungsdatum / Generation Date'),
          '#default_value' => ('2023-06-23'),
          '#required'      => true,
          );


// Submit Form and Populate Template
    $form['submit_button'] = array(
      '#type'  => 'submit',
      '#value' => t('Erstellen / Generate'),
      );

    return $form;
  }


  /**
   * Called when the user hits submit button
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();

    $title_en                           = $values['table1']['R1.1']['Title_EN'];
    $title                              = $values['table1']['R1.1']['title'];
    $alias                              = $values['table1']['R1.3']['alias'];
    $alias_en                           = $values['table1']['R1.3']['alias_EN'];
    $not_fau_de                         = $values['table1']['R1.4']['Not_FAU_DE'];
    $not_fau_en                         = $values['table1']['R1.4']['Not_FAU_EN'];
    $wisski_url                         = $values['table1']['R1.2']['WissKI_URL'];
    $sec_off_title_de                   = $values['table2']['R2.1']['Sec_Off_Title_DE'];
    $sec_off_title_en                   = $values['table2']['R2.1']['Sec_Off_Title_EN'];
    $sec_off_name                       = $values['table2']['R2.2']['Sec_Off_Name'];
    $sec_off_add_de                     = $values['table2']['R2.3']['Sec_Off_Add_DE'];
    $sec_off_add_en                     = $values['table2']['R2.3']['Sec_Off_Add_EN'];
    $sec_off_address                    = $values['table2']['R2.4']['Sec_Off_Address'];
    $sec_off_plz                        = $values['table2']['R2.5']['Sec_Off_PLZ'];
    $sec_off_city_de                    = $values['table2']['R2.6']['Sec_Off_City_DE'];
    $sec_off_city_en                    = $values['table2']['R2.6']['Sec_Off_City_EN'];
    $sec_off_email                      = $values['table2']['R2.7']['Sec_Off_Email'];
    $sec_off_phone                      = $values['table2']['R2.8']['Sec_Off_Phone'];
    $sec_off_fax                        = $values['table2']['R2.9']['Sec_Off_Fax'];
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


    $template = [
      '#theme'                 => 'datenschutz_template',
      '#not_fau_de'                     => $not_fau_de,
      '#wisski_url'                     => $wisski_url,
      '#sec_off_title_de'               => $sec_off_title_de,
      '#sec_off_name'                   => $sec_off_name,
      '#sec_off_add_de'                 => $sec_off_add_de,
      '#sec_off_address'                => $sec_off_address,
      '#sec_off_plz'                    => $sec_off_plz,
      '#sec_off_city_de'                => $sec_off_city_de,
      '#sec_off_email'                  => $sec_off_email,
      '#sec_off_phone'                  => $sec_off_phone,
      '#sec_off_fax'                    => $sec_off_fax,
      '#third_service_provider'         => $third_service_provider,
      '#third_descr_data_coll_de'       => $third_descr_data_coll_de,
      '#third_legal_basis_data_coll_de' => $third_legal_basis_data_coll_de,
      '#third_objection_data_coll_de'   => $third_objection_data_coll_de,
      '#data_comm_title_de'             => $data_comm_title_de,
      '#data_comm_address'              => $data_comm_address,
      '#data_comm_plz'                  => $data_comm_plz,
      '#data_comm_city_de'              => $data_comm_city_de,
      '#date'                           => $date,

    ];

    $deleteQuery = \Drupal::database()->delete('path_alias');
    $deleteQuery->condition('alias', '/'.$alias);
    $deleteQuery->execute();

    $html = \Drupal::service('renderer')->renderPlain($template);

    $this->generateNode($title, $html, $alias);
    \Drupal::messenger()->addMessage($this->t('<a href="/'.$alias.'">German privacy declaration</a> created'), 'status', TRUE);

    $template_en = [
      '#theme'                 => 'privacy_template',
      '#not_fau_en'                     => $not_fau_en,
      '#wisski_url'                     => $wisski_url,
      '#sec_off_title_en'               => $sec_off_title_en,
      '#sec_off_name'                   => $sec_off_name,
      '#sec_off_add_en'                 => $sec_off_add_en,
      '#sec_off_address'                => $sec_off_address,
      '#sec_off_plz'                    => $sec_off_plz,
      '#sec_off_city_en'                => $sec_off_city_en,
      '#sec_off_email'                  => $sec_off_email,
      '#sec_off_phone'                  => $sec_off_phone,
      '#sec_off_fax'                    => $sec_off_fax,
      '#third_service_provider'         => $third_service_provider,
      '#third_descr_data_coll_en'       => $third_descr_data_coll_en,
      '#third_legal_basis_data_coll_en' => $third_legal_basis_data_coll_en,
      '#third_objection_data_coll_en'   => $third_objection_data_coll_en,
      '#data_comm_title_en'             => $data_comm_title_en,
      '#data_comm_address'              => $data_comm_address,
      '#data_comm_plz'                  => $data_comm_plz,
      '#data_comm_city_en'              => $data_comm_city_en,
      '#date'                           => $date,

    ];

    $deleteQuery = \Drupal::database()->delete('path_alias');
    $deleteQuery->condition('alias', '/'.$alias_en);
    $deleteQuery->execute();

    $html_en = \Drupal::service('renderer')->renderPlain($template_en);

    $this->generateNode($title_en, $html_en, $alias_en);
    \Drupal::messenger()->addMessage($this->t('<a href="/'.$alias_en.'">English privacy declaration</a> created'), 'status', TRUE);

  }

  function generateNode($title, $body, $alias){
    $node = Node::create([
        'type'    => 'page',
        'title'   => t($title),
        'body'    => array(
          //'summary' => "this is the summary",
            'value'     => $body,
            'format'    => 'full_html',
          ),
        // set alias for page
        'path'    => array('alias' => "/$alias"),
    ]);
    $node->save();
  }

}


