<?php

namespace Drupal\wisski_impressum\Generator;

use \Drupal\node\Entity\Node;

class WisskiLegalGenerator {

  // Consant used in REQUIRED_DATA_ALL array for legal notice and privacy
  const REQUIRED_LEGAL_NOTICE_ALIAS_DE = 'impressum';

  const REQUIRED_LEGAL_NOTICE_ALIAS_EN = 'legalnotice';


  const REQUIRED_DATA_ALL = ['REQUIRED_LEGALNOTICE' => array('title_de'           => 'Impressum',
                                                              'title_en'          => 'Legal Notice',
                                                              'alias_de'          => 'impressum',
                                                              'alias_en'          => 'legalnotice',
                                                              'wisski_url'        => '',
                                                              'project_name_de'   => '',
                                                              'project_name_en'   => '',
                                                              'pub_institute_de'  => '',
                                                              'pub_institute_en'  => '',
                                                              'pub_name'          => '',
                                                              'pub_address'       => '',
                                                              'pub_plz'           => '',
                                                              'pub_city_de'       => '',
                                                              'pub_city_en'       => '',
                                                              'pub_email'         => '',
                                                              'contact_name'      => '',
                                                              'contact_phone'     => '',
                                                              'contact_email'     => '',
                                                              'sup_institute_de'  => '',
                                                              'sup_institute_en'  => '',
                                                              'sup_url'           => '',
                                                              'sup_email'         => '',
                                                              'sup_staff_array'   => '',
                                                              'auth_name_de'      => 'Bayerisches Staatsministerium für Wissenschaft und Kunst',
                                                              'auth_name_en'      => 'Bavarian State Ministry of Science and Art',
                                                              'auth_address'      => 'Salvatorstraße 2',
                                                              'auth_plz'          => '80327',
                                                              'auth_city_de'      => 'München',
                                                              'auth_city_en'      => 'Munich',
                                                              'auth_url'          => 'www.stmwk.bayern.de',
                                                              'date'              => '',
                                                              ),
                                'REQUIRED_ACCESSIBILITY' => array('title_de'              => 'Barrierefreiheit',
                                                                  'title_en'              => 'Accessibility',
                                                                  'alias_de'              => 'barrierefreiheit',
                                                                  'alias_en'              => 'accessibility',
                                                                  'wisski_url'            => '',
                                                                  'status'                => array('Completely compliant' => '',
                                                                                                   'Partially compliant' => array('issues_array_de'       => '',
                                                                                                                                  'issues_array_en'       => '',
                                                                                                                                  'statement_array_de'    => '',
                                                                                                                                  'statement_array_en'    => '',
                                                                                                                                  'alternatives_array_de' => '',
                                                                                                                                  'alternatives_array_en' => '',
                                                                                                                                  ),
                                                                                                  ),
                                                                  'methodology_de'        => '',
                                                                  'methodology_en'        => '',
                                                                  'creation_date'         => '',
                                                                  'last_revis_date'       => '',
                                                                  'contact_access_name'   => '',
                                                                  'contact_access_phone'  => '',
                                                                  'contact_access_email'  => '',
                                                                  'sup_institute_de'      => '',
                                                                  'sup_institute_en'      => '',
                                                                  'sup_url'               => '',
                                                                  'sup_address'           => '',
                                                                  'sup_plz'               => '',
                                                                  'sup_city_de'           => '',
                                                                  'sup_city_en'           => '',
                                                                  'sup_email'             => '',
                                                                  'overs_name_de'         => 'Landesamt für Digitalisierung, Breitband und Vermessung',
                                                                  'overs_name_en'         => 'Agency for Digitalisation, High-Speed Internet and Surveying',
                                                                  'overs_dept_de'         => 'IT-Dienstleistungszentrum des Freistaats Bayern Durchsetzungs- und Überwachungsstelle für barrierefreie Informationstechnik',
                                                                  'overs_dept_en'         => 'IT Service Center of the Free State of Bavaria Enforcement and Monitoring Body for Barrier-free Information Technology',
                                                                  'overs_address'         => 'St.-Martin-Straße 47',
                                                                  'overs_plz'             => '81541',
                                                                  'overs_city_de'         => 'München',
                                                                  'overs_city_en'         => 'Munich',
                                                                  'overs_phone'           => '+49 89 2129-1111',
                                                                  'overs_email'           => 'bitv@bayern.de',
                                                                  'overs_url'             => 'https://www.ldbv.bayern.de/digitalisierung/bitv.html',
                                                                  'date'                  => '',
                                                                ),
                                  'REQUIRED_PRIVACY' => array('title_de'            => 'Datenschutz',
                                                              'title_en'            => 'Privacy',
                                                              'alias_de'            => 'datenschutz',
                                                              'alias_en'            => 'privacy',
                                                              'wisski_url'          => '',
                                                              'legal_notice_de'     => self::REQUIRED_LEGAL_NOTICE_ALIAS_DE,
                                                              'legal_notice_en'     => self::REQUIRED_LEGAL_NOTICE_ALIAS_EN,
                                                              'sec_off_title_de'    => 'Datenschutzbeauftragter der FAU',
                                                              'sec_off_title_en'    => 'Data Security Official of the FAU',
                                                              'sec_off_name'        => 'Klaus Hoogestraat',
                                                              'sec_off_add_de'      => 'c/o ITM Gesellschaft für IT-Management mbH',
                                                              'sec_off_add_en'      => 'c/o ITM Gesellschaft für IT-Management mbH',
                                                              'sec_off_address'     => 'Bürgerstraße 81',
                                                              'sec_off_plz'         => '01127',
                                                              'sec_off_city_de'     => 'Dresden',
                                                              'sec_off_city_en'     => 'Dresden',
                                                              'sec_off_phone'       => '+49 9131 85-25860',
                                                              'sec_off_fax'         => '',
                                                              'sec_off_email'       => 'datenschutzbeauftragter@fau.de',
                                                              'data_comm_title_de'  => 'der Bayerische Landesbeauftragte für den Datenschutz',
                                                              'data_comm_title_en'  => 'Bavarian State Commissioner for Data Protection',
                                                              'data_comm_address'   => 'Wagmüllerstraße 18',
                                                              'data_comm_plz'       => '80538',
                                                              'data_comm_city_de'   => 'München',
                                                              'data_comm_city_en'   => 'Munich',
                                                              'date'                => '',
                                                              ),
  ];

    public $template;

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
          'path'     => array('alias' => "/$alias"),
      ]);
      $node->save();
    }

    public function required_data($docKey){

  return REQUIRED_DATA_ALL[$docKey];
  }




    public function generateImpressum(array $data_ln, string $title_de, string $title_en, string $alias_de, string $alias_en){

        $template_de = [
            '#theme' => 'impressum_template',
            '#wisski_url'             => $data_ln['wisski_url'],
            '#project_name_de'        => $data_ln['project_name_de'],
            '#pub_institute_de'       => $data_ln['pub_institute_de'],
            '#pub_name'               => $data_ln['pub_name'],
            '#pub_address'            => $data_ln['pub_address'],
            '#pub_plz'                => $data_ln['pub_plz'],
            '#pub_city_de'            => $data_ln['pub_city_de'],
            '#pub_email'              => $data_ln['pub_email'],
            '#cust_legal_form_de'     => $data_ln['cust_legal_form_de'],
            '#contact_name'           => $data_ln['contact_name'],
            '#contact_phone'          => $data_ln['contact_phone'],
            '#contact_email'          => $data_ln['contact_email'],
            '#sup_institute_de'       => $data_ln['sup_institute_de'],
            '#sup_url'                => $data_ln['sup_url'],
            '#sup_email'              => $data_ln['sup_email'],
            '#sup_staff_array'        => $data_ln['sup_staff_array'],
            '#auth_name_de'           => $data_ln['auth_name_de'],
            '#auth_address'           => $data_ln['auth_address'],
            '#auth_plz'               => $data_ln['auth_plz'],
            '#auth_city_de'           => $data_ln['auth_city_de'],
            '#auth_url'               => $data_ln['auth_url'],
            '#licence_title_de'       => $data_ln['licence_title_de'],
            '#licence_url'            => $data_ln['licence_url'],
            '#use_fau_temp'           => $data_ln['use_fau_temp'],
            '#no_default_txt'         => $data_ln['no_default_txt'],
            '#cust_licence_txt_de'    => $data_ln['cust_licence_txt_de'],
            '#cust_exclusion_de'      => $data_ln['cust_exclusion_de'],
            '#show_disclaim'          => $data_ln['show_disclaim'],
            '#cust_disclaim_de'       => $data_ln['cust_disclaim_de'],
            '#date'                   => $data_ln['date'],
          ];


          $deleteQuery = \Drupal::database()->delete('path_alias');
          $deleteQuery->condition('alias', '/'.$alias_de);
          $deleteQuery->execute();

          $html_de = \Drupal::service('renderer')->renderPlain($template_de);

          $this->generateNode($title_de, $html_de, $alias_de);


          $template_en = [
            '#theme' => 'legalnotice_template',
            '#wisski_url'             => $data_ln['wisski_url'],
            '#project_name_en'        => $data_ln['project_name_en'],
            '#pub_institute_en'       => $data_ln['pub_institute_en'],
            '#pub_name'               => $data_ln['pub_name'],
            '#pub_address'            => $data_ln['pub_address'],
            '#pub_plz'                => $data_ln['pub_plz'],
            '#pub_city_en'            => $data_ln['pub_city_en'],
            '#pub_email'              => $data_ln['pub_email'],
            '#cust_legal_form_en'     => $data_ln['cust_legal_form_en'],
            '#contact_name'           => $data_ln['contact_name'],
            '#contact_phone'          => $data_ln['contact_phone'],
            '#contact_email'          => $data_ln['contact_email'],
            '#sup_institute_en'       => $data_ln['sup_institute_en'],
            '#sup_url'                => $data_ln['sup_url'],
            '#sup_email'              => $data_ln['sup_email'],
            '#sup_staff_array'        => $data_ln['sup_staff_array'],
            '#auth_name_en'           => $data_ln['auth_name_en'],
            '#auth_address'           => $data_ln['auth_address'],
            '#auth_plz'               => $data_ln['auth_plz'],
            '#auth_city_en'           => $data_ln['auth_city_en'],
            '#auth_url'               => $data_ln['auth_url'],
            '#licence_title_en'       => $data_ln['licence_title_en'],
            '#licence_url'            => $data_ln['licence_url'],
            '#use_fau_temp'           => $data_ln['use_fau_temp'],
            '#no_default_txt'         => $data_ln['no_default_txt'],
            '#cust_licence_txt_en'    => $data_ln['cust_licence_txt_en'],
            '#cust_exclusion_en'      => $data_ln['cust_exclusion_en'],
            '#show_disclaim'          => $data_ln['show_disclaim'],
            '#cust_disclaim_en'       => $data_ln['cust_disclaim_en'],
            '#date'                   => $data_ln['date'],

          ];

          $deleteQuery = \Drupal::database()->delete('path_alias');
          $deleteQuery->condition('alias', '/'.$alias_en);
          $deleteQuery->execute();

          $html_en = \Drupal::service('renderer')->renderPlain($template_en);

          $this->generateNode($title_en, $html_en, $alias_en);

          $valuesStoredInState = array('wisski_impressum.legalNotice' => array('title_de'              => $title_de,
                                                                               'title_en'              => $title_en,
                                                                               'wisski_url'            => $data_ln['wisski_url'],
                                                                               'alias_de'              => $alias_de,
                                                                               'alias_en'              => $alias_en,
                                                                               'project_name_de'       => $data_ln['project_name_de'],
                                                                               'project_name_en'       => $data_ln['project_name_en'],
                                                                               'pub_institute_de'      => $data_ln['pub_institute_de'],
                                                                               'pub_institute_en'      => $data_ln['pub_institute_en'],
                                                                               'pub_name'              => $data_ln['pub_name'],
                                                                               'pub_address'           => $data_ln['pub_address'],
                                                                               'pub_plz'               => $data_ln['pub_plz'],
                                                                               'pub_city_de'           => $data_ln['pub_city_de'],
                                                                               'pub_city_en'           => $data_ln['pub_city_en'],
                                                                               'pub_email'             => $data_ln['pub_email'],
                                                                               'cust_legal_form_de'    => $data_ln['cust_legal_form_de'],
                                                                               'cust_legal_form_en'    => $data_ln['cust_legal_form_en'],
                                                                               'contact_name'          => $data_ln['contact_name'],
                                                                               'contact_phone'         => $data_ln['contact_phone'],
                                                                               'contact_email'         => $data_ln['contact_email'],
                                                                               'sup_institute_de'      => $data_ln['sup_institute_de'],
                                                                               'sup_institute_en'      => $data_ln['sup_institute_en'],
                                                                               'sup_url'               => $data_ln['sup_url'],
                                                                               'sup_email'             => $data_ln['sup_email'],
                                                                               'sup_staff_array'       => $data_ln['sup_staff_array'],
                                                                               'auth_name_de'          => $data_ln['auth_name_de'],
                                                                               'auth_name_en'          => $data_ln['auth_name_en'],
                                                                               'auth_address'          => $data_ln['auth_address'],
                                                                               'auth_plz'              => $data_ln['auth_plz'],
                                                                               'auth_city_de'          => $data_ln['auth_city_de'],
                                                                               'auth_city_en'          => $data_ln['auth_city_en'],
                                                                               'auth_url'              => $data_ln['auth_url'],
                                                                               'licence_title_de'      => $data_ln['licence_title_de'],
                                                                               'licence_title_en'      => $data_ln['licence_title_en'],
                                                                               'licence_url'           => $data_ln['licence_url'],
                                                                               'use_fau_temp'          => $data_ln['use_fau_temp'],
                                                                               'no_default_txt'        => $data_ln['no_default_txt'],
                                                                               'cust_licence_txt_de'   => $data_ln['cust_licence_txt_de'],
                                                                               'cust_licence_txt_en'   => $data_ln['cust_licence_txt_en'],
                                                                               'cust_exclusion_de'     => $data_ln['cust_exclusion_de'],
                                                                               'cust_exclusion_en'     => $data_ln['cust_exclusion_en'],
                                                                               'show_disclaim'         => $data_ln['show_disclaim'],
                                                                               'cust_disclaim_de'      => $data_ln['cust_disclaim_de'],
                                                                               'cust_disclaim_en'      => $data_ln['cust_disclaim_en'],
                                                                               'date'                  => $data_ln['date'],
                                                                               ),
            );

          // Store current German and English input in state:
          \Drupal::state()->setMultiple($valuesStoredInState);

          return TRUE;
        }

    public function generateBarrierefreiheit(array $data_a, $title_de, $title_en, $alias_de, $alias_en){
      $template_de = [
        '#theme' => 'barrierefreiheit_template',
        '#wisski_url'             => $data_a['wisski_url'],
        '#status'                 => $data_a['status'],
        '#methodology_de'         => $data_a['methodology_de'],
        '#creation_date'          => $data_a['creation_date'],
        '#last_revis_date'        => $data_a['last_revis_date'],
        '#report_url'             => $data_a['report_url'],
        '#issues_array_de'        => $data_a['issues_array_de'],
        '#statement_array_de'     => $data_a['statement_array_de'],
        '#alternatives_array_de'  => $data_a['alternatives_array_de'],
        '#contact_access_name'    => $data_a['contact_access_name'],
        '#contact_access_phone'   => $data_a['contact_access_phone'],
        '#contact_access_email'   => $data_a['contact_access_email'],
        '#sup_institute_de'       => $data_a['sup_institute_de'],
        '#sup_url'                => $data_a['sup_url'],
        '#sup_address'            => $data_a['sup_address'],
        '#sup_plz'                => $data_a['sup_plz'],
        '#sup_city_de'            => $data_a['sup_city_de'],
        '#sup_email'              => $data_a['sup_email'],
        '#overs_name_de'          => $data_a['overs_name_de'],
        '#overs_dept_de'          => $data_a['overs_dept_de'],
        '#overs_address'          => $data_a['overs_address'],
        '#overs_plz'              => $data_a['overs_plz'],
        '#overs_city_de'          => $data_a['overs_city_de'],
        '#overs_phone'            => $data_a['overs_phone'],
        '#overs_email'            => $data_a['overs_email'],
        '#overs_url'              => $data_a['overs_url'],
        '#date'                   => $data_a['date'],
      ];

      $deleteQuery = \Drupal::database()->delete('path_alias');
      $deleteQuery->condition('alias', '/'.$alias_de);
      $deleteQuery->execute();

      $html_de = \Drupal::service('renderer')->renderPlain($template_de);

      $this->generateNode($title_de, $html_de, $alias_de);


      $template_en = [
        '#theme' => 'accessibility_template',
        '#wisski_url'             => $data_a['wisski_url'],
        '#status'                 => $data_a['status'],
        '#methodology_en'         => $data_a['methodology_en'],
        '#creation_date'          => $data_a['creation_date'],
        '#last_revis_date'        => $data_a['last_revis_date'],
        '#report_url'             => $data_a['report_url'],
        '#issues_array_en'        => $data_a['issues_array_en'],
        '#statement_array_en'     => $data_a['statement_array_en'],
        '#alternatives_array_en'  => $data_a['alternatives_array_en'],
        '#contact_access_name'    => $data_a['contact_access_name'],
        '#contact_access_phone'   => $data_a['contact_access_phone'],
        '#contact_access_email'   => $data_a['contact_access_email'],
        '#sup_institute_en'       => $data_a['sup_institute_en'],
        '#sup_url'                => $data_a['sup_url'],
        '#sup_address'            => $data_a['sup_address'],
        '#sup_plz'                => $data_a['sup_plz'],
        '#sup_city_en'            => $data_a['sup_city_en'],
        '#sup_email'              => $data_a['sup_email'],
        '#overs_name_en'          => $data_a['overs_name_en'],
        '#overs_dept_en'          => $data_a['overs_dept_en'],
        '#overs_address'          => $data_a['overs_address'],
        '#overs_plz'              => $data_a['overs_plz'],
        '#overs_city_en'          => $data_a['overs_city_en'],
        '#overs_phone'            => $data_a['overs_phone'],
        '#overs_email'            => $data_a['overs_email'],
        '#overs_url'              => $data_a['overs_url'],
        '#date'                   => $data_a['date'],
      ];

      $deleteQuery = \Drupal::database()->delete('path_alias');
      $deleteQuery->condition('alias', '/'.$alias_en);
      $deleteQuery->execute();

      $html_en = \Drupal::service('renderer')->renderPlain($template_en);

      $this->generateNode($title_en, $html_en, $alias_en);


      $valuesStoredInState = array('wisski_impressum.accessibility' => array('title_de'            => $title_de,
                                                                           'title_en'              => $title_en,
                                                                           'wisski_url'            => $data_a['wisski_url'],
                                                                           'alias_de'              => $alias_de,
                                                                           'alias_en'              => $alias_en,
                                                                           'status'                => $data_a['status'],
                                                                           'methodology_de'        => $data_a['methodology_de'],
                                                                           'methodology_en'        => $data_a['methodology_en'],
                                                                           'creation_date'         => $data_a['creation_date'],
                                                                           'last_revis_date'       => $data_a['last_revis_date'],
                                                                           'report_url'            => $data_a['report_url'],
                                                                           'issues_array_de'       => $data_a['issues_array_de'],
                                                                           'issues_array_en'       => $data_a['issues_array_en'],
                                                                           'statement_array_de'    => $data_a['statement_array_de'],
                                                                           'statement_array_en'    => $data_a['statement_array_en'],
                                                                           'alternatives_array_de' => $data_a['alternatives_array_de'],
                                                                           'alternatives_array_en' => $data_a['alternatives_array_en'],
                                                                           'contact_access_name'   => $data_a['contact_access_name'],
                                                                           'contact_access_phone'  => $data_a['contact_access_phone'],
                                                                           'contact_access_email'  => $data_a['contact_access_email'],
                                                                           'sup_institute_de'      => $data_a['sup_institute_de'],
                                                                           'sup_institute_en'      => $data_a['sup_institute_en'],
                                                                           'sup_url'               => $data_a['sup_url'],
                                                                           'sup_address'           => $data_a['sup_address'],
                                                                           'sup_plz'               => $data_a['sup_plz'],
                                                                           'sup_city_de'           => $data_a['sup_city_de'],
                                                                           'sup_city_en'           => $data_a['sup_city_en'],
                                                                           'sup_email'             => $data_a['sup_email'],
                                                                           'overs_name_de'         => $data_a['overs_name_de'],
                                                                           'overs_name_en'         => $data_a['overs_name_en'],
                                                                           'overs_dept_de'         => $data_a['overs_dept_de'],
                                                                           'overs_dept_en'         => $data_a['overs_dept_en'],
                                                                           'overs_address'         => $data_a['overs_address'],
                                                                           'overs_plz'             => $data_a['overs_plz'],
                                                                           'overs_city_de'         => $data_a['overs_city_de'],
                                                                           'overs_city_en'         => $data_a['overs_city_en'],
                                                                           'overs_phone'           => $data_a['overs_phone'],
                                                                           'overs_email'           => $data_a['overs_email'],
                                                                           'overs_url'             => $data_a['overs_url'],
                                                                           'date'                  => $data_a['date'],

    )
    );

      // Store current German and English input in state:
      \Drupal::state()->setMultiple($valuesStoredInState);


      return TRUE;
    }



    public function generateDatenschutz(array $data_p, string $title_de, string $title_en, string $alias_de, string $alias_en){

      $template_de = ['#theme' => 'datenschutz_template'];
      foreach ($data_p as $key => $value) {
        $newKey = "#{$key}";
        $template_de[$newKey] = $value;
      }
      $template_de = [
        '#theme' => 'datenschutz_template',
        '#wisski_url'                       => $data_p['wisski_url'],
        '#not_fau_de'                       => $data_p['not_fau_de'],
        '#legal_notice_url_de'              => $data_p['legal_notice_url_de'],
        '#sec_off_title_de'                 => $data_p['sec_off_title_de'],
        '#sec_off_name'                     => $data_p['sec_off_name'],
        '#sec_off_add_de'                   => $data_p['sec_off_add_de'],
        '#sec_off_address'                  => $data_p['sec_off_address'],
        '#sec_off_plz'                      => $data_p['sec_off_plz'],
        '#sec_off_city_de'                  => $data_p['sec_off_city_de'],
        '#sec_off_phone'                    => $data_p['sec_off_phone'],
        '#sec_off_fax'                      => $data_p['sec_off_fax'],
        '#sec_off_email'                    => $data_p['sec_off_email'],
        '#third_service_provider'           => $data_p['third_service_provider'],
        '#third_descr_data_coll_de'         => $data_p['third_descr_data_coll_de'],
        '#third_legal_basis_data_coll_de'   => $data_p['third_legal_basis_data_coll_de'],
        '#third_objection_data_coll_de'     => $data_p['third_objection_data_coll_de'],
        '#data_comm_title_de'               => $data_p['data_comm_title_de'],
        '#data_comm_address'                => $data_p['data_comm_address'],
        '#data_comm_plz'                    => $data_p['data_comm_plz'],
        '#data_comm_city_de'                => $data_p['data_comm_city_de'],
        '#date'                             => $data_p['date'],

      ];


      $deleteQuery = \Drupal::database()->delete('path_alias');
      $deleteQuery->condition('alias', '/'.$alias_de);
      $deleteQuery->execute();

      $html_de = \Drupal::service('renderer')->renderPlain($template_de);

      $this->generateNode($title_de, $html_de, $alias_de);


      $template_en = [
        '#theme' => 'privacy_template',
        '#wisski_url'                       => $data_p['wisski_url'],
        '#not_fau_en'                       => $data_p['not_fau_en'],
        '#legal_notice_url_en'              => $data_p['legal_notice_url_en'],
        '#sec_off_title_en'                 => $data_p['sec_off_title_en'],
        '#sec_off_name'                     => $data_p['sec_off_name'],
        '#sec_off_add_en'                   => $data_p['sec_off_add_en'],
        '#sec_off_address'                  => $data_p['sec_off_address'],
        '#sec_off_plz'                      => $data_p['sec_off_plz'],
        '#sec_off_city_en'                  => $data_p['sec_off_city_en'],
        '#sec_off_phone'                    => $data_p['sec_off_phone'],
        '#sec_off_fax'                      => $data_p['sec_off_fax'],
        '#sec_off_email'                    => $data_p['sec_off_email'],
        '#third_service_provider'           => $data_p['third_service_provider'],
        '#third_descr_data_coll_en'         => $data_p['third_descr_data_coll_en'],
        '#third_legal_basis_data_coll_en'   => $data_p['third_legal_basis_data_coll_en'],
        '#third_objection_data_coll_en'     => $data_p['third_objection_data_coll_en'],
        '#data_comm_title_en'               => $data_p['data_comm_title_en'],
        '#data_comm_address'                => $data_p['data_comm_address'],
        '#data_comm_plz'                    => $data_p['data_comm_plz'],
        '#data_comm_city_en'                => $data_p['data_comm_city_en'],
        '#date'                             => $data_p['date'],

      ];


      $deleteQuery = \Drupal::database()->delete('path_alias');
      $deleteQuery->condition('alias', '/'.$alias_en);
      $deleteQuery->execute();

      $html_en = \Drupal::service('renderer')->renderPlain($template_en);

      $this->generateNode($title_en, $html_en, $alias_en);

      $valuesStoredInState = array('wisski_impressum.privacy' => array('title_de'                       => $title_de,
                                                                       'title_en'                       => $title_en,
                                                                       'wisski_url'                     => $data_p['wisski_url'],
                                                                       'alias_de'                       => $alias_de,
                                                                       'alias_en'                       => $alias_en,
                                                                       'not_fau_de'                     => $data_p['not_fau_de'],
                                                                       'not_fau_en'                     => $data_p['not_fau_en'],
                                                                       'sec_off_title_de'               => $data_p['sec_off_title_de'],
                                                                       'sec_off_title_en'               => $data_p['sec_off_title_en'],
                                                                       'sec_off_name'                   => $data_p['sec_off_name'],
                                                                       'sec_off_add_de'                 => $data_p['sec_off_add_de'],
                                                                       'sec_off_add_en'                 => $data_p['sec_off_add_en'],
                                                                       'sec_off_address'                => $data_p['sec_off_address'],
                                                                       'sec_off_plz'                    => $data_p['sec_off_plz'],
                                                                       'sec_off_city_de'                => $data_p['sec_off_city_de'],
                                                                       'sec_off_city_en'                => $data_p['sec_off_city_en'],
                                                                       'sec_off_phone'                  => $data_p['sec_off_phone'],
                                                                       'sec_off_fax'                    => $data_p['sec_off_fax'],
                                                                       'sec_off_email'                  => $data_p['sec_off_email'],
                                                                       'third_service_provider'         => $data_p['third_service_provider'],
                                                                       'third_descr_data_coll_de'       => $data_p['third_descr_data_coll_de'],
                                                                       'third_descr_data_coll_en'       => $data_p['third_descr_data_coll_en'],
                                                                       'third_legal_basis_data_coll_de' => $data_p['third_legal_basis_data_coll_de'],
                                                                       'third_legal_basis_data_coll_en' => $data_p['third_legal_basis_data_coll_en'],
                                                                       'third_objection_data_coll_de'   => $data_p['third_objection_data_coll_de'],
                                                                       'third_objection_data_coll_en'   => $data_p['third_objection_data_coll_en'],
                                                                       'data_comm_title_de'             => $data_p['data_comm_title_de'],
                                                                       'data_comm_title_en'             => $data_p['data_comm_title_en'],
                                                                       'data_comm_address'              => $data_p['data_comm_address'],
                                                                       'data_comm_plz'                  => $data_p['data_comm_plz'],
                                                                       'data_comm_city_de'              => $data_p['data_comm_city_de'],
                                                                       'data_comm_city_en'              => $data_p['data_comm_city_en'],
                                                                       'date'                           => $data_p['date'],
                                                                        ),
      );

      // Store current German and English input in state:
      \Drupal::state()->setMultiple($valuesStoredInState);

      return TRUE;

    }
}