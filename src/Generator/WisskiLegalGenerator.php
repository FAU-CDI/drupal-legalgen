<?php

namespace Drupal\wisski_impressum\Generator;

use \Drupal\node\Entity\Node;

class WisskiLegalGenerator {


    public $template;


    public function generateImpressum(array $data, string $title, string $title_en, string $alias, string $alias_en): void {

        $template = [
            '#theme' => 'impressum_template',
            '#wisski_url'             => $data['wisski_url'],
            '#project_name_de'        => $data['project_name_de'],
            '#pub_institute_de'       => $data['pub_institute_de'],
            '#pub_name'               => $data['pub_name'],
            '#pub_address'            => $data['pub_address'],
            '#pub_plz'                => $data['pub_plz'],
            '#pub_city_de'            => $data['pub_city_de'],
            '#pub_email'              => $data['pub_email'],
            '#cust_legal_form_de'     => $data['cust_legal_form_de'],
            '#contact_name'           => $data['contact_name'],
            '#contact_phone'          => $data['contact_phone'],
            '#contact_email'          => $data['ontact_email'],
            '#sup_institute_de'       => $data['sup_institute_de'],
            '#sup_email'              => $data['sup_email'],
            '#sup_staff_array'        => $data['sup_staff_array'],
            '#sup_url'                => $data['sup_url'],
            '#auth_name_de'           => $data['auth_name_de'],
            '#auth_address'           => $data['auth_address'],
            '#auth_plz'               => $data['auth_plz'],
            '#auth_city_de'           => $data['auth_city_de'],
            '#auth_url'               => $data['auth_url'],
            '#licence_title_de'       => $data['licence_title_de'],
            '#licence_url'            => $data['licence_url'],
            '#use_fau_temp'           => $data['use_fau_temp'],
            '#no_default_txt'         => $data['no_default_txt'],
            '#cust_licence_txt_de'    => $data['cust_licence_txt_de'],
            '#cust_exclusion_de'      => $data['cust_exclusion_de'],
            '#show_disclaim_de'       => $data['show_disclaim_de'],
            '#cust_disclaim_de'       => $data['cust_disclaim_de'],
            '#date' => $data['date'],
          ];


          $deleteQuery = \Drupal::database()->delete('path_alias');
          $deleteQuery->condition('alias', '/'.$alias);
          $deleteQuery->execute();

          $html = \Drupal::service('renderer')->renderPlain($template);

          $this->generateNode($title, $html, $alias);


          $template_en = [
            '#theme' => 'legalnotice_template',
            '#wisski_url'             => $data['wisski_url'],
            '#project_name_en'        => $data['project_name_en'],
            '#pub_institute_en'       => $data['pub_institute_en'],
            '#pub_name'               => $data['pub_name'],
            '#pub_address'            => $data['pub_address'],
            '#pub_plz'                => $data['pub_plz'],
            '#pub_city_en'            => $data['pub_city_en'],
            '#pub_email'              => $data['pub_email'],
            '#cust_legal_form_en'     => $data['cust_legal_form_en'],
            '#contact_name'           => $data['contact_name'],
            '#contact_phone'          => $data['contact_phone'],
            '#contact_email'          => $data['contact_email'],
            '#sup_institute_en'       => $data['sup_institute_en'],
            '#sup_email'              => $data['sup_email'],
            '#sup_staff_array'        => $data['sup_staff_array'],
            '#sup_url'                => $data['sup_url'],
            '#auth_name_en'           => $data['auth_name_en'],
            '#auth_address'           => $data['auth_address'],
            '#auth_plz'               => $data['auth_plz'],
            '#auth_city_en'           => $data['auth_city_en'],
            '#auth_url'               => $data['auth_url'],
            '#licence_title_en'       => $data['licence_title_en'],
            '#licence_url'            => $data['licence_url'],
            '#use_fau_temp'           => $data['use_fau_temp'],
            '#no_default_txt'         => $data['no_default_txt'],
            '#cust_licence_txt_en'    => $data['cust_licence_txt_en'],
            '#cust_exclusion_en'      => $data['cust_exclusion_en'],
            '#show_disclaim'          => $data['show_disclaim'],
            '#cust_disclaim_en'       => $data['cust_disclaim_en'],
            '#date'                   => $data['date'],

          ];
          $deleteQuery = \Drupal::database()->delete('path_alias');
          $deleteQuery->condition('alias', '/'.$alias_en);
          $deleteQuery->execute();

          $html_en = \Drupal::service('renderer')->renderPlain($template_en);

          $this->generateNode($title_en, $html_en, $alias_en);

        }

    public function generateBarrierefreiheit(array $data, $title, $title_en, $alias, $alias_en): void {
      $template = [
        '#theme' => 'barrierefreiheit_template',
        '#wisski_url'             => $data['wisski_url'],
        '#leg_notice_url_de'      => $data['leg_notice_url_de'],
        '#project_name_de'        => $data['project_name_de'],
        '#status'                 => $data['status'],
        '#methodology_de'         => $data['methodology_de'],
        '#creation_date'          => $data['creation_date'],
        '#last_revis_date'        => $data['last_revis_date'],
        '#report_url'             => $data['report_url'],
        '#issues_array_de'        => $data['issues_array_de'],
        '#statement_array_de'     => $data['statement_array_de'],
        '#alternatives_array_de'  => $data['alternatives_array_de'],
        '#pub_institute_de'       => $data['pub_institute_de'],
        '#pub_inst_url'           => $data['pub_inst_url'],
        '#pub_name'               => $data['pub_name'],
        '#pub_address'            => $data['pub_address'],
        '#pub_plz'                => $data['pub_plz'],
        '#pub_city_de'            => $data['pub_city_de'],
        '#pub_email'              => $data['pub_email'],
        '#pub_url'                => $data['pub_url'],
        '#sup_institute_de'       => $data['sup_institute_de'],
        '#sup_email'              => $data['sup_email'],
        '#sup_address'            => $data['sup_address'],
        '#sup_plz'                => $data['sup_plz'],
        '#sup_city_de'            => $data['sup_city_de'],
        '#sup_url'                => $data['sup_url'],
        '#overs_name_de'          => $data['overs_name_de'],
        '#overs_dept_de'          => $data['overs_dept_de'],
        '#overs_address'          => $data['overs_address'],
        '#overs_plz'              => $data['overs_plz'],
        '#overs_city_de'          => $data['overs_city_de'],
        '#overs_phone'            => $data['overs_phone'],
        '#overs_email'            => $data['overs_email'],
        '#overs_url'              => $data['overs_url'],
        '#date'                   => $data['date'],
      ];

      $deleteQuery = \Drupal::database()->delete('path_alias');
      $deleteQuery->condition('alias', '/'.$alias);
      $deleteQuery->execute();

      $html = \Drupal::service('renderer')->renderPlain($template);

      $this->generateNode($title, $html, $alias);


      $template_en = [
        '#theme' => 'accessibility_template',
        '#wisski_url'             => $data['wisski_url'],
        '#leg_notice_url_en'      => $data['leg_notice_url_en'],
        '#project_name_en'        => $data['project_name_en'],
        '#status'                 => $data['status'],
        '#methodology_en'         => $data['methodology_en'],
        '#creation_date'          => $data['reation_date'],
        '#last_revis_date'        => $data['last_revis_date'],
        '#report_url'             => $data['report_url'],
        '#issues_array_en'        => $data['issues_array_en'],
        '#statement_array_en'     => $data['statement_array_en'],
        '#alternatives_array_en'  => $data['alternatives_array_en'],
        '#pub_institute_en'       => $data['pub_institute_en'],
        '#pub_inst_url'           => $data['pub_inst_url'],
        '#pub_name'               => $data['pub_name'],
        '#pub_address'            => $data['pub_address'],
        '#pub_plz'                => $data['pub_plz'],
        '#pub_city_en'            => $data['pub_city_en'],
        '#pub_email'              => $data['pub_email'],
        '#pub_url'                => $data['pub_url'],
        '#sup_institute_en'       => $data['sup_institute_en'],
        '#sup_email'              => $data['sup_email'],
        '#sup_address'            => $data['sup_address'],
        '#sup_plz'                => $data['sup_plz'],
        '#sup_city_en'            => $data['up_city_en'],
        '#sup_url'                => $data['sup_url'],
        '#overs_name_en'          => $data['overs_name_en'],
        '#overs_dept_en'          => $data['overs_dept_en'],
        '#overs_address'          => $data['overs_address'],
        '#overs_plz'              => $data['overs_plz'],
        '#overs_city_en'          => $data['overs_city_en'],
        '#overs_phone'            => $data['overs_phone'],
        '#overs_email'            => $data['overs_email'],
        '#overs_url'              => $data['overs_url'],
        '#date'                   => $data['date'],
      ];

      $deleteQuery = \Drupal::database()->delete('path_alias');
      $deleteQuery->condition('alias', '/'.$alias_en);
      $deleteQuery->execute();

      $html_en = \Drupal::service('renderer')->renderPlain($template_en);

      $this->generateNode($title_en, $html_en, $alias_en);
    }



    public function generateDatenschutz(array $data, string $title, string $title_en, string $alias, string $alias_en): void {

      $template = [
        '#theme' => 'datenschutz_template',
        '#wisski_url'                       => $data['wisski_url'],
        '#not_fau_de'                       => $data['not_fau_de'],
        '#sec_off_title_de'                 => $data['sec_off_title_de'],
        '#sec_off_name'                     => $data['sec_off_name'],
        '#sec_off_add_de'                   => $data['sec_off_add_de'],
        '#sec_off_address'                  => $data['sec_off_address'],
        '#sec_off_plz'                      => $data['sec_off_plz'],
        '#sec_off_city_de'                  => $data['sec_off_city_de'],
        '#sec_off_email'                    => $data['sec_off_email'],
        '#sec_off_phone'                    => $data['sec_off_phone'],
        '#sec_off_fax'                      => $data['sec_off_fax'],
        '#third_service_provider'           => $data['third_service_provider'],
        '#third_descr_data_coll_de'         => $data['third_descr_data_coll_de'],
        '#third_legal_basis_data_coll_de'   => $data['third_legal_basis_data_coll_de'],
        '#third_objection_data_coll_de'     => $data['third_objection_data_coll_de'],
        '#data_comm_title_de'               => $data['data_comm_title_de'],
        '#data_comm_address'                => $data['data_comm_address'],
        '#data_comm_plz'                    => $data['data_comm_plz'],
        '#data_comm_city_de'                => $data['data_comm_city_de'],
        '#date'                             => $data['date'],

      ];

      $deleteQuery = \Drupal::database()->delete('path_alias');
      $deleteQuery->condition('alias', '/'.$alias);
      $deleteQuery->execute();

      $html = \Drupal::service('renderer')->renderPlain($template);

      $this->generateNode($title, $html, $alias);


      $template_en = [
        '#theme' => 'privacy_template',
        '#wisski_url'                       => $data['wisski_url'],
        '#not_fau_en'                       => $data['not_fau_en'],
        '#sec_off_title_en'                 => $data['sec_off_title_en'],
        '#sec_off_name'                     => $data['sec_off_name'],
        '#sec_off_add_en'                   => $data['sec_off_add_en'],
        '#sec_off_address'                  => $data['sec_off_address'],
        '#sec_off_plz'                      => $data['sec_off_plz'],
        '#sec_off_city_en'                  => $data['sec_off_city_en'],
        '#sec_off_email'                    => $data['sec_off_email'],
        '#sec_off_phone'                    => $data['sec_off_phone'],
        '#sec_off_fax'                      => $data['sec_off_fax'],
        '#third_service_provider'           => $data['third_service_provider'],
        '#third_descr_data_coll_en'         => $data['third_descr_data_coll_en'],
        '#third_legal_basis_data_coll_en'   => $data['third_legal_basis_data_coll_en'],
        '#third_objection_data_coll_en'     => $data['third_objection_data_coll_en'],
        '#data_comm_title_en'               => $data['data_comm_title_en'],
        '#data_comm_address'                => $data['data_comm_address'],
        '#data_comm_plz'                    => $data['data_comm_plz'],
        '#data_comm_city_en'                => $data['data_comm_city_en'],
        '#date'                             => $data['date'],

      ];

      $deleteQuery = \Drupal::database()->delete('path_alias');
      $deleteQuery->condition('alias', '/'.$alias_en);
      $deleteQuery->execute();

      $html_en = \Drupal::service('renderer')->renderPlain($template_en);

      $this->generateNode($title_en, $html_en, $alias_en);

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