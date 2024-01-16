<?php

namespace Drupal\wisski_impressum\Generator;

use \Drupal\node\Entity\Node;
use Drupal\path_alias\Entity\PathAlias;
use \Drupal\Core\Language;
use \Drupal\Component\Render\MarkupInterface;
use \Drupal\Core\Messenger\Messenger;
use \Drupal\Core\Url;
use \Drupal\Core\Link;
use \Drupal\Core\StringTranslation\TranslatableMarkup;


class WisskiLegalGenerator {

  // Consant used in REQUIRED_DATA_ALL array for legal notice and privacy

  const REQUIRED_LEGAL_NOTICE_ALIAS_DE = 'impressum';

  const REQUIRED_LEGAL_NOTICE_ALIAS_EN = 'legalnotice';

  const REQUIRED_DATA_ALL = ['REQUIRED_LEGALNOTICE' => array('en' =>  array('title'             => 'Legal Notice',
                                                                            'alias'             => 'legalnotice',
                                                                            'project_name'      => '',
                                                                            'pub_institute'     => '',
                                                                            'pub_name'          => '',
                                                                            'pub_city'          => '',
                                                                            'contact_name'      => '',
                                                                            'sup_institute'     => '',
                                                                            'sup_staff_array'   => '',
                                                                            'auth_name'         => 'Bavarian State Ministry of Science and Art',
                                                                            'auth_city'         => 'Munich',
                                                                            ),
                                                             'de' =>  array('title'             => 'Impressum',
                                                                            'alias'             => 'impressum',
                                                                            'project_name'      => '',
                                                                            'pub_institute'     => '',
                                                                            'pub_name'          => '',
                                                                            'pub_city'          => '',
                                                                            'contact_name'      => '',
                                                                            'sup_institute'     => '',
                                                                            'sup_staff_array'   => '',
                                                                            'auth_name'         => 'Bayerisches Staatsministerium für Wissenschaft und Kunst',
                                                                            'auth_city'         => 'München',
                                                                           ),
                                                             'intl' => array('wisski_url'        => '',
                                                                             'pub_address'       => '',
                                                                             'pub_plz'           => '',
                                                                             'pub_email'         => '',
                                                                             'contact_phone'     => '',
                                                                             'contact_email'     => '',
                                                                             'sup_url'           => '',
                                                                             'sup_email'         => '',
                                                                             'auth_address'      => 'Salvatorstraße 2',
                                                                             'auth_plz'          => '80327',
                                                                             'auth_url'          => 'www.stmwk.bayern.de',
                                                                             'date'              => '',
                                                                            ),
                                                          	),
                                'REQUIRED_ACCESSIBILITY' => array('en' => array('title'                 => 'Accessibility',
                                                                                'alias'                 => 'accessibility',
                                                                                'status'                => array('Completely compliant',
                                                                                                                 'Partially compliant',
                                                                                                                ),
                                                                                'issues_array'          => '',
                                                                                'statement_array'       => '',
                                                                                'alternatives_array'    => '',
                                                                                'methodology'           => 'TEST',
                                                                                'contact_access_name'   => 'TEST',
                                                                                'sup_institute'         => 'TEST',
                                                                                'sup_city'              => 'TEST',
                                                                                'overs_name'            => 'Agency for Digitalisation, High-Speed Internet and Surveying',
                                                                                'overs_dept'            => 'IT Service Center of the Free State of Bavaria Enforcement and Monitoring Body for Barrier-free Information Technology',
                                                                                'overs_city'            => 'Munich',
                                                                               ),
                                                                  'de' =>  array('title'                => 'Barrierefreiheit',
                                                                                 'alias'                => 'barrierefreiheit',
                                                                                 'status'               => array('Completely compliant',
                                                                                                                 'Partially compliant',
                                                                                                            ),
                                                                                'issues_array'          => '',
                                                                                'statement_array'       => '',
                                                                                'alternatives_array'    => '',
                                                                                'methodology'           => '',
                                                                                'contact_access_name'   => '',
                                                                                'sup_institute'         => '',
                                                                                'sup_city'              => '',
                                                                                'overs_name'            => 'Landesamt für Digitalisierung, Breitband und Vermessung',
                                                                                'overs_dept'            => 'IT-Dienstleistungszentrum des Freistaats Bayern Durchsetzungs- und Überwachungsstelle für barrierefreie Informationstechnik',
                                                                                'overs_city'            => 'München',
                                                                                ),
                                                                  'intl' => array('wisski_url'            => 'TEST',
                                                                                  'creation_date'         => 'TEST',
                                                                                  'last_revis_date'       => 'TEST',
                                                                                  'contact_access_phone'  => 'TEST',
                                                                                  'contact_access_email'  => 'test@test.de',
                                                                                  'sup_url'               => 'TEST',
                                                                                  'sup_address'           => 'TEST',
                                                                                  'sup_plz'               => 'TEST',
                                                                                  'sup_email'             => 'test@test.de',
                                                                                  'overs_address'         => 'St.-Martin-Straße 47',
                                                                                  'overs_plz'             => '81541',
                                                                                  'overs_phone'           => '+49 89 2129-1111',
                                                                                  'overs_email'           => 'bitv@bayern.de',
                                                                                  'overs_url'             => 'https://www.ldbv.bayern.de/digitalisierung/bitv.html',
                                                                                  'date'                  => '',
                                                                                  ),
                                                                ),
                                  'REQUIRED_PRIVACY' => array('en' =>  array('title'               => 'Privacy',
                                                                             'alias'               => 'privacy',
                                                                             'legal_notice_url'    => self::REQUIRED_LEGAL_NOTICE_ALIAS_EN,
                                                                             'sec_off_title'       => 'Data Security Official of the FAU',
                                                                             'sec_off_name'        => 'Klaus Hoogestraat',
                                                                             'sec_off_add'         => 'c/o ITM Gesellschaft für IT-Management mbH',
                                                                             'sec_off_city'        => 'Dresden',
                                                                             'data_comm_title'     => 'Bavarian State Commissioner for Data Protection',
                                                                             'data_comm_city'      => 'Munich',
                                                                            ),
                                                               'de' =>  array('title'                 => 'Datenschutz',
                                                                              'alias'                 => 'datenschutz',
                                                                              'legal_notice_url'      => self::REQUIRED_LEGAL_NOTICE_ALIAS_DE,
                                                                              'sec_off_title'         => 'Datenschutzbeauftragter der FAU',
                                                                              'sec_off_name'          => 'Klaus Hoogestraat',
                                                                              'sec_off_add'           => 'c/o ITM Gesellschaft für IT-Management mbH',
                                                                              'sec_off_city'          => 'Dresden',
                                                                              'data_comm_title'       => 'der Bayerische Landesbeauftragte für den Datenschutz',
                                                                              'data_comm_city'        => 'München',
                                                                             ),
                                                               'intl' => array('wisski_url'            => '',
                                                                               'sec_off_address'       => 'Bürgerstraße 81',
                                                                               'sec_off_plz'           => '01127',
                                                                               'sec_off_phone'         => '+49 9131 85-25860',
                                                                               'sec_off_fax'           => '',
                                                                               'sec_off_email'         => 'datenschutzbeauftragter@fau.de',
                                                                               'data_comm_address'     => 'Wagmüllerstraße 18',
                                                                               'data_comm_plz'         => '80538',
                                                                               'date'                  => '',
                                                                               ),
                                                            ),
  ];

  public function validateDataBeforeGeneration(array $data, String $default_key, String $title, String $alias){

    // Check If All Required Keys Are in Data Array and Is NOT Empty + Title and Alias are not Empty

    $missingValues = [];

    $lang = $data['lang'];

    $required = WisskiLegalGenerator::REQUIRED_DATA_ALL[$default_key][$lang];

    // Loop over Required Array
    foreach ($required as $k => $v){

      // Required Key in Data?
      $requiredKeyInData = array_key_exists($k, $data);

      // Add to Missing Values if Key not in Data or Title or Alias OR if no Value
      if(($requiredKeyInData === FALSE and $k !== 'title' and $k !== 'alias') or empty($data[$k]) === 0 or empty($title) === 0 or empty($alias) === 0){

        if($k === 'issues_array' or $k === 'statement_array' or $k === 'alternatives_array'){

          if ($required['status'] === 'Completely compliant'){
            continue;
          }
        }
        array_push($missingValues, $k);
        continue;
      }

      continue;
    }

    // Convert Missing Values to String
    return implode(", ", $missingValues);
  }

  public $template;


  function generateNode($title, $alias, $body, $lang): Node {

    $node = Node::create([
        'type'    => 'page',
        'title'   => t($title),
        'activeLangcode' => $lang,
        'body'    => array(
          //'summary' => "this is the summary",
            'value'     => $body,
            'format'    => 'full_html',
          ),
        // set alias for page
        'path'     => array('alias' => "/$alias"),
      ]);

      $node->save();

      return $node;

  }

  function updateNode ($title, $alias, $body, $node): string {

    // Update Values for Body
    $node-> title =  $title;
    $node->set('body', array(
      'value' => $body,
      'format'  => 'full_html',
    ));

    // Update Value for Path
    $node->set('path', array(
      'alias' => "/$alias",
    ));

    $node->save();

    $node_id = $node->id();
    return $node_id;

  }




  function generateTranslation(string $title, string $alias, $body, string $lang, Node $node): string {

        // Create Non Default Language Page
        $node_trans = $node->addTranslation($lang);

        $node_trans->path->alias = $alias;
        $node_trans->title = $title;
        $node_trans->body->value = $body;
        $node_trans->body->format = 'full_html';


        //Save Translation to Node
        $node_trans->save();

        // Get Translation Created
        $exist_trans = $node->getTranslation($lang);

        // Update Path
        $exist_trans->set('path', array(
        'alias' => "/$alias",
        ));

        $exist_trans->save();

        // Get Node ID
        $node_id = $node->id();

      return $node_id;
  }

  function updateTranslation ($title, $alias, $body, $lang, $node): string {

      $exist_trans = $node->getTranslation($lang);

      // Update Body
      $exist_trans-> title =  $title;
      $exist_trans->set('body', array(
        'value' => $body,
        'format'  => 'full_html',
      ));

      // Update Path
      $exist_trans->set('path', array(
        'alias' => "/$alias",
      ));

      $exist_trans->save();

      $node_id = $exist_trans->id();

    return $node_id;
  }


  function checkPage ($title, $alias, $body, $lang, $overwrite, $node): array|NULL {

    // Get Default Language
    $default_lang =  \Drupal::languageManager()->getDefaultLanguage()->getId();

    $return_array = [];

    // 1) NO NODE

    if ($node === NULL){

      // A) Default Language
      if ($lang === $default_lang){

        $node_id = $this->generateNode($title, $alias, $body, $default_lang)->id();

        array_push($return_array, $node_id, '');

        // Return Node ID
        return $return_array;

      } else {

      // B) NOT Default Language

        // a) Generate Empty Default Lang

        $node = $this->generateNode($title, $alias, $body, $default_lang);


        // b) Generate Non Default Lang
        $this->generateTranslation($title, $alias, $body, $lang, $node);

        array_push($return_array, $node->id(), 'Empty Default', $default_lang);

        // Return Node ID
        return $return_array;

      }
    } else {

    // 2) NODE EXISTS

      // A) Overwrite NOT Ticked
      // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! Identical Operator and Other
      if ($overwrite == 0){

        array_push($return_array, NULL, 'No Overwrite');

        return $return_array;

      } else {

      // B) Overwrite Ticked

        // a) Default Language

        if ($lang === $default_lang){

          $node_id = $this->updateNode($title, $alias, $body, $node);

          array_push($return_array, $node_id, '');

          return $return_array;

        } else {

          // b) NOT Default Language

          $trans_exist = $node->hasTranslation($lang);


          // i) NO Translation Exists

          if(!$trans_exist){

            $node_id = $this->generateTranslation($title, $alias, $body, $lang, $node);

            array_push($return_array, $node_id, '');

            return $return_array;

          } else {

            // ii) Translation Exists

            $node_id = $this->updateTranslation($title, $alias, $body, $lang, $node);

            array_push($return_array, $node_id, '');

            return $return_array;
          }
        }
      }
    }
  }


  public function generatePage(array $data, string $title, string $alias, string $lang, string $required_key, string $page_name, array $state_keys_lang, array $state_keys_intl) {

    // Ad
    $validity = \Drupal::service('wisski_impressum.generator')->validateDataBeforeGeneration($data, $required_key, $title, $alias);


    if(empty($validity)){

      // Get Info from Config
      $config_langs = \Drupal::configFactory()->get('wisski_impressum.languages')->getRawData();

      // Get Template Name from Config
      $templ1 = $config_langs[$lang][$page_name];

      // Create Template from Form Data Array
      $template = ['#theme' => $templ1];
      foreach ($data as $key => $val) {
        $newKey = "#{$key}";
        $template[$newKey] = $val;
      }

      // Delete Language and Overwrite from Template
      unset($template['#lang']);
      unset($template['#overwrite']);

    $body = \Drupal::service('renderer')->renderPlain($template);


    // Get Node ID from State
    $state_of_page = 'wisski_impressum.'.$page_name;

    $state_vals = \Drupal::state()->get($state_of_page);

    if(!empty($state_vals)){
    $nid = $state_vals['node_id'];

    $node = Node::load((string)$nid);
    } else {
      $node = NULL;
    }

    $pageArray = $this->checkPage($title, $alias, $body, $lang, $data['overwrite_consent'], $node);

    $node_id = $pageArray[0];

    $userInfo = $pageArray[1];

    // Create Arrays to Store in State
    $to_store_in_state_lang = array($lang => $state_keys_lang);
    $to_store_in_state_intl = array('intl' => $state_keys_intl);
    $state_node = array('node_id' => $node_id);

    // Merge Lang and Intl Array
    $merged = array_merge($to_store_in_state_lang, $to_store_in_state_intl);

    foreach ($merged as $key => $val_array) {
      foreach ($merged[$key] as $k => $v){
        if($k === 'title'){
          $val_array[$k] = $title;

        }else if($k === 'alias'){
          $val_array[$k] = $alias;

        }else{
          $val_array[$k] = $data[$k];
        }
      }
      $merged[$key] = $val_array;
    }

    // Add Node ID to Values Array for State
    $valuesStoredInState = array_merge($merged, $state_node);

    // Check if Values in State
    if(!empty($state_vals)){

    $state_keys = array_replace($state_vals, $valuesStoredInState);
    } else {
      $state_keys = $valuesStoredInState;

    }

    $toSaveInState = array($state_of_page => $state_keys);

    // Store Current Language Specific Input in State:
    \Drupal::state()->setMultiple($toSaveInState);

    /* TEST STARTS HERE */




    /* TEST ENDS HERE */

    // Info to User
    if($userInfo === 'No Overwrite'){

      $text = 'Unfortunately an error ocurred: Page already exists and cannot be overwritten<br/>Overwriting was not permitted by user (overwrite checkbox at the end of the form NOT checked)';
      $rendered_text = \Drupal\Core\Render\Markup::create($text);
      $error_message = new TranslatableMarkup ('@message', array('@message' => $rendered_text));


      \Drupal::messenger()->addError($error_message, 'status', TRUE);


    } else {

        if($userInfo === 'Empty Default'){

          $domain = \Drupal::request()->getHost();
          $default_lang =  \Drupal::languageManager()->getDefaultLanguage()->getId();
          $url = \Drupal\Core\Url::fromUri('https://'.$domain.'/'.$default_lang.'/'.$alias)->toString();
          $message = t('<a href=":href">Empty default language page created</a> ('.$pageArray[2].') <b>Please ensure to manually generate this page again with all required values</b>', array(':href' => $url));

          \Drupal::messenger()->addStatus($message, 'status', TRUE);


    } else {

      // Generate Success Messages:
      $domain = \Drupal::request()->getHost();
      $url = \Drupal\Core\Url::fromUri('https://'.$domain.'/'.$lang.'/'.$alias)->toString();
      $message = t('<a href=":href">Page generated successfully</a>'.' ('.$lang.')', array(':href' => $url));

      \Drupal::messenger()->addStatus($message, 'status', TRUE);



    }
    }


  } else {
    // Info to User
    \Drupal::messenger()->addError('Unfortunately an error ocurred: Required values invalid', 'status', TRUE);
  }
  }
}