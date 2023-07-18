<?php

namespace Drupal\wisski_impressum\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\wisski_impressum\Generator\WisskiLegalGenerator;


use \Drupal\node\Entity\Node;


/**
 * Configure example settings for this site.
 */
class WissKiAccessibilityForm extends FormBase {

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

    // Fields:
    // type of render array element
    // see https://api.drupal.org/api/drupal/elements/8.2.x for available elements


    // Disclaimer
    $form['text_header'] = array(
      '#prefix' => '<p><strong>',
      '#suffix' => '</strong></p>',
      '#markup' => t('Das CDI ist nicht für die Korrektheit der eingegebenen Daten verantwortlich. Bitte überprüfen Sie nach der Generierung die erstellten Seiten auf Richtigkeit.'),
      '#weight' => -100,
      );


    // Display Link to FAU Accessibility Guidelines (as reference)
    $form['Guidelines'] = array(
      '#type'  => 'details',
      '#title' => t('Leitfaden zur digitalen Barrierefreiheit für Hochschulen für Angewandte Wissenschaft in Bayern'),
      '#open'  => false,
      );

        $form['Guidelines']['Complete_Guidelines_WS'] = array(
          '#type'   => 'item',
          '#markup' => '<a href="https://www.wordpress.rrze.fau.de/tutorials/a11y/">Leitfaden zur digitalen Barrierefreiheit (FAU Webseite)</a>',
          );

        $form['Guidelines']['Complete_Guidelines_GH'] = array(
          '#type'   => 'item',
          '#markup' => '<a href="https://github.com/RZ-BY/Leitfaden-Barrierefreiheit/">Leitfaden zur digitalen Barrierefreiheit (RRZE GitHub)</a>',
          );


      // Fields: General
      $form['General'] = array(
          '#type'  => 'details',
          '#title' => t('Allgemein / General'),
          '#open'  => true,
          );

          $form['General']['table1'] = array(
            '#type'   => 'table',
            '#title'  => 'General',
            '#header' => array('German', 'English'),
          );

            $form['General']['table1']['R1.1']['title'] = array(
              '#type'          => 'textfield',
              '#title'         => t('Seitentitel'),
              '#default_value' => t('Barrierefreiheit'),
              '#required'      => true,
              );

            $form['General']['table1']['R1.1']['Title_EN'] = array(
              '#type'          => 'textfield',
              '#title'         => t('Page title'),
              '#default_value' => t('Accessibility'),
              '#required'      => true,
              );

            $form['General']['table1']['R1.2']['WissKI_URL'] = array(
              '#type'          => 'textfield',
              '#wrapper_attributes' => [
                'colspan' =>  2,
              ],
              '#title'         => t('WissKI URL'),
              '#default_value' => t('https://mehrdad.wisski.data.fau.de/'),
              '#required'      => true,
              );

            $form['General']['table1']['R1.3']['Leg_Notice_URL_DE'] = array(
              '#type'          => 'textfield',
              '#title'         => t('Impressum URL'),
              '#default_value' => t('https://mehrdad.wisski.data.fau.de/impressum'),
              '#required'      => true,
              );

            $form['General']['table1']['R1.3']['Leg_Notice_URL_EN'] = array(
              '#type'          => 'textfield',
              '#title'         => t('Legal Notice URL'),
              '#default_value' => t('https://mehrdad.wisski.data.fau.de/legalnotice'),
              '#required'      => true,
              );

            $form['General']['table1']['R1.4']['alias'] = array(
              '#type'          => 'textfield',
              '#title'         => t('Seiten-Alias'),
              '#default_value' => t('barrierefreiheit'),
              '#required'      => true,
              );

            $form['General']['table1']['R1.4']['alias_EN'] = array(
              '#type'          => 'textfield',
              '#title'         => t('Page alias'),
              '#default_value' => t('accessibility'),
              '#required'      => true,
              );


            $form['General']['table1']['R1.5']['Project_Name_DE'] = array(
              '#type'          => 'textfield',
              '#title'         => t('Projektname'),
              '#default_value' => t('Mehrdad'),
              '#required'      => true,
              );

            $form['General']['table1']['R1.5']['Project_Name_EN'] = array(
              '#type'          => 'textfield',
              '#title'         => t('Project name'),
              '#default_value' => t('Mehrdad'),
              '#required'      => true,
              );


    // Display Link to FAU Accessibility Guidelines for Tests (as reference)
    $form['Guidelines_Tests'] = array(
      '#type'  => 'details',
      '#title' => t('Leitfaden zu Tests der digitalen Barrierefreiheit'),
      '#open'  => false,
      );

        $form['Guidelines_Tests']['Complete_Guidelines'] = array(
          '#type'   => 'item',
          '#markup' => '<a href="https://www.wordpress.rrze.fau.de/tutorials/a11y/tests-der-barrierefreiheit/">Leitfaden der FAU zu Tests der digitalen Barrierefreiheit</a>',
          );



    // Fields: Conformity
    $form['Conformity'] = array(
      '#type'        => 'details',
      '#title'       => t('Konformität / Conformity'),
      '#open'        => true,
      );

      $form['Conformity']['table2'] = array(
        '#type' => 'table',
        '#title' => 'Conformity',
        '#header' => array('German', 'English'),
      );

        $form['Conformity']['table2']['R2.1']['Conformity_Status'] = array(
          '#type'         => 'select',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'        => t('Konformitätsstatus / Conformity status'),
          '#required'     => true,
          '#options'      => [
            'Completely compliant' => $this->t('Completely compliant'),
            'Partially compliant'   => $this->t('Partially compliant'),
          ],
          );


        $form['Conformity']['table2']['R2.2']['Assessment_Methodology_DE'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Methodik der Prüfung'),
          '#default_value' => t('Selbstbewertung'),
          '#required'      => true,
          );

        $form['Conformity']['table2']['R2.2']['Assessment_Methodology_EN'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Assessment methodology'),
          '#default_value' => t('Self-assessment'),
          '#required'      => true,
          );

        $form['Conformity']['table2']['R2.3']['Creation_Date'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('Erstellungsdatum Bericht / Report Creation Date'),
          '#default_value' => t('TT.MM.JJJJ'),
          '#required'      => true,
          );

        $form['Conformity']['table2']['R2.4']['Last_Revision_Date'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('Datum letzte Prüfung / Date of last revision'),
          '#default_value' => t('TT.MM.JJJJ'),
          '#required'      => true,
          );

        $form['Conformity']['table2']['R2.5']['Report_URL'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('Bericht URL / Report URL'),
          '#default_value' => t('https://wave.webaim.org/report#/cdi.fau.de'),
          '#required'      => false,
          );


    // Fields: Contents Not Accessible to All
    $form['Issues'] = array(
      '#type'        => 'details',
      '#title'       => t('Nicht barrierefrei zugängliche Inhalte / Contents Not Accessible to All'),
      '#open'        => true,
      );

      $form['Issues']['table3'] = array(
        '#type' => 'table',
        '#title' => 'Issues',
        '#header' => array('German', 'English'),
      );

        $form['Issues']['table3']['R3.1']['Known_Issues_DE'] = array(
          '#type'           => 'textarea',
          '#title'          => t('Nicht barrierefrei zugängliche Inhalte ("; " als Separator für Probleme)'),
          '#default_value'  => t('Aufzählung; von; nicht; barrierefreien; Inhalten'),
          '#required'       => false,
          );

        $form['Issues']['table3']['R3.1']['Known_Issues_EN'] = array(
          '#type'           => 'textarea',
          '#title'          => t('Content that is not accessible to all ("; " as separator for problems)'),
          '#default_value'  => t('List; of; contents; which; are; not; barrier-free'),
          '#required'       => false,
          );

        $form['Issues']['table3']['R3.2']['Justification_Statement_DE'] = array(
          '#type'           => 'textarea',
          '#title'          => t('Begründung ("; " als Separator für Unterpunkte)'),
          '#default_value'  => t('Aufzählung; verschiedener; Begründungen'),
          '#required'       => false,
          );

        $form['Issues']['table3']['R3.2']['Justification_Statement_EN'] = array(
          '#type'           => 'textarea',
          '#title'          => t('Justification ("; " as separator for subitems)'),
          '#default_value'  => t('list; of; individual; justifactions'),
          '#required'       => false,
          );

        $form['Issues']['table3']['R3.3']['Alternative_Access_DE'] = array(
          '#type'           => 'textarea',
          '#title'          => t('Alternative Zugangswege ("; " als Separator für Unterpunkte)'),
          '#default_value'  => t('Auflistung; von; Alternativen'),
          '#required'       => false,
          );

        $form['Issues']['table3']['R3.3']['Alternative_Access_EN'] = array(
          '#type'           => 'textarea',
          '#title'          => t('Alternative access paths ("; " as separator for subitems)'),
          '#default_value'  => t('List; of; alternatives'),
          '#required'       => false,
          );


    // Fields: Publisher
    $form['Publisher'] = array(
      '#type'  => 'details',
      '#title' => t('Herausgebende / Publisher'),
      '#open'  => true,
      );

      $form['Publisher']['table4'] = array(
        '#type' => 'table',
        '#title' => 'Publisher',
        '#header' => array('German', 'English'),
      );

        $form['Publisher']['table4']['R4.1']['Pub_Institute_DE'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Institut'),
          '#default_value' => t('Friedrich-Alexander-Universität Erlangen-Nürnberg, Institut'),
          '#required'      => true,
          );

        $form['Publisher']['table4']['R4.1']['Pub_Institute_EN'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Institute'),
          '#default_value' => t('Friedrich-Alexander-Universität Erlangen-Nürnberg, Institut'),
          '#required'      => true,
          );

        $form['Publisher']['table4']['R4.2']['Pub_Inst_URL'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('Homepage Institut / Homepage institute'),
          '#default_value' => t('https://www._.fau.de/'),
          '#required'      => true,
          );

        $form['Publisher']['table4']['R4.3']['Pub_Name'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Name Herausgebende / Name publisher'),
          '#default_value' => t('Prof. Dr. Herausgebende'),
          '#required'      => true,
          );

        $form['Publisher']['table4']['R4.4']['Pub_Address'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('Straße und Hausnummer / Street name and house number'),
          '#default_value' => t('Schlossgarten 1 - Orangerie'),
          '#required'      => true,
          );

        $form['Publisher']['table4']['R4.5']['Pub_PLZ'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('PLZ / Postal code'),
          '#default_value' => t('91054'),
          '#required'      => true,
          );

        $form['Publisher']['table4']['R4.6']['Pub_City_DE'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Ort'),
          '#default_value' => t('Erlangen'),
          '#required'      => true,
          );

        $form['Publisher']['table4']['R4.6']['Pub_City_EN'] = array(
          '#type'          => 'textfield',
          '#title'         => t('City'),
          '#default_value' => t('Erlangen'),
          '#required'      => true,
          );

        $form['Publisher']['table4']['R4.7']['Pub_Email'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('E-Mail Herausgebende / E-mail publisher'),
          '#default_value' => t('herausgebende@fau.de'),
          '#required'      => true,
          );

        $form['Publisher']['table4']['R4.8']['Pub_URL'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('Homepage Herausgebende / Homepage publisher'),
          '#default_value' => t('https://www._.fau.de/institut/team/name'),
          '#required'      => true,
          );

    // Fields: Suppport and Hosting
    $form['Support_and_Hosting'] = array(
      '#type'   => 'details',
      '#title'  => t('Betreuung und Hosting / Support and Hosting'),
      '#open'   => true,
      );

      $form['Support_and_Hosting']['table5'] = array(
        '#type' => 'table',
        '#title' => 'General',
        '#header' => array('German', 'English'),
      );

        $form['Support_and_Hosting']['table5']['R5.1']['Sup_Institute_DE'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Institut'),
          '#default_value' => t('FAU Competence Center for Research Data and Information'),
          '#required'      => true,
          );

        $form['Support_and_Hosting']['table5']['R5.1']['Sup_Institute_EN'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Institute'),
          '#default_value' => t('FAU Competence Center for Research Data and Information'),
          '#required'      => true,
          );

        $form['Support_and_Hosting']['table5']['R5.2']['Sup_Email'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('E-Mail Betreuung / E-mail support and hosting'),
          '#default_value' => t('cdi-wisski-support@fau.de'),
          '#required'      => true,
          );

        $form['Support_and_Hosting']['table5']['R5.3']['Sup_Address'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('Straße und Hausnummer / Street name and house number'),
          '#default_value' => t('Werner-von-Siemens-Straße 61'),
          '#required'      => true,
          );

        $form['Support_and_Hosting']['table5']['R5.4']['Sup_PLZ'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('PLZ / Postal code'),
          '#default_value' => t('91052'),
          '#required'      => true,
          );

        $form['Support_and_Hosting']['table5']['R5.5']['Sup_City_DE'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Ort'),
          '#default_value' => t('Erlangen'),
          '#required'      => true,
          );

        $form['Support_and_Hosting']['table5']['R5.5']['Sup_City_EN'] = array(
          '#type'          => 'textfield',
          '#title'         => t('City'),
          '#default_value' => t('Erlangen'),
          '#required'      => true,
          );

        $form['Support_and_Hosting']['table5']['R5.6']['Sup_URL'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('Homepage-Betreuung URL / URL support and hosting'),
          '#default_value' => t('https://www.cdi.fau.de/'),
          '#required'      => true,
          );


    // Fields: Enforcement Oversight Body
    $form['Oversight Body'] = array(
      '#type'   => 'details',
      '#title'  => t('Aufsichtsbehörde / Enforcement Oversight Body'),
      '#open'   => true,
      );

      $form['Oversight Body']['table6'] = array(
        '#type' => 'table',
        '#title' => 'General',
        '#header' => array('German', 'English'),
      );

        $form['Oversight Body']['table6']['R6.1']['Oversight_Agency_Name_DE'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Name der Behörde'),
          '#default_value' => t('Landesamt für Digitalisierung, Breitband und Vermessung'),
          '#required'      => true,
          );

        $form['Oversight Body']['table6']['R6.1']['Oversight_Agency_Name_EN'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Name of oversight agency'),
          '#default_value' => t('Agency for Digitalisation, High-Speed Internet and Surveying'),
          '#required'      => true,
          );

        $form['Oversight Body']['table6']['R6.2']['Oversight_Agency_Dept_DE'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Name der Abteilung'),
          '#default_value' => t('IT-Dienstleistungszentrum des Freistaats Bayern Durchsetzungs- und Überwachungsstelle für barrierefreie Informationstechnik'),
          '#required'      => true,
          );

        $form['Oversight Body']['table6']['R6.2']['Oversight_Agency_Dept_EN'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Name of department'),
          '#default_value' => t('IT Service Center of the Free State of Bavaria Enforcement and Monitoring Body for Barrier-free Information Technology'),
          '#required'      => true,
          );

        $form['Oversight Body']['table6']['R6.3']['Oversight_Address'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('Straße und Hausnummer / Street name and house number'),
          '#default_value' => t('St.-Martin-Straße 47'),
          '#required'      => true,
        );

        $form['Oversight Body']['table6']['R6.4']['Oversight_PLZ'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('PLZ / Postal Code'),
          '#default_value' => t('81541'),
          '#required'      => true,
          );

        $form['Oversight Body']['table6']['R6.5']['Oversight_City_DE'] = array(
          '#type'          => 'textfield',
          '#title'         => t('Ort'),
          '#default_value' => t('München'),
          '#required'      => true,
          );

        $form['Oversight Body']['table6']['R6.5']['Oversight_City_EN'] = array(
          '#type'          => 'textfield',
          '#title'         => t('City'),
          '#default_value' => t('Munich'),
          '#required'      => true,
          );

        $form['Oversight Body']['table6']['R6.6']['Oversight_Phone'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('Telefon Aufsichtsbehörde/ Phone oversight agency'),
          '#default_value' => t('+49 89 2129-1111'),
          '#required'      => true,
          );

        $form['Oversight Body']['table6']['R6.7']['Oversight_Email'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('E-Mail Aufsichtsbehörde / E-mail oversight agency'),
          '#default_value' => t('bitv@bayern.de'),
          '#required'      => true,
          );

        $form['Oversight Body']['table6']['R6.8']['Oversight_URL'] = array(
          '#type'          => 'textfield',
          '#wrapper_attributes' => [
            'colspan' =>  2,
          ],
          '#title'         => t('Webseite / Website '),
          '#default_value' => t('https://www.ldbv.bayern.de/digitalisierung/bitv.html'),
          '#required'      => true,
          );


    // Field: Timestamp
    $form['Timestamp'] = array(
      '#type'  => 'details',
      '#title' => t('Erstellungsdatum / Generation Date'),
      '#open'  => true,
      );

        $form['Timestamp']['Date'] = array(
          '#type'          => 'date',
          '#title'         => t(''),
          '#required'      => true,
          '#disabled'      => false,
          '#default_value' => ('2023-06-11'),
          );


// Submit Form Contents and Populate Template
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

    $title_en            = $values['table1']['R1.1']['Title_EN'];
    $title               = $values['table1']['R1.1']['title'];
    $alias               = $values['table1']['R1.4']['alias'];
    $alias_en            = $values['table1']['R1.4']['alias_EN'];
    $wisski_url          = $values['table1']['R1.2']['WissKI_URL'];
    $leg_notice_url_de   = $values['table1']['R1.3']['Leg_Notice_URL_DE'];
    $leg_notice_url_en   = $values['table1']['R1.3']['Leg_Notice_URL_EN'];
    $project_name_de     = $values['table1']['R1.5']['Project_Name_DE'];
    $project_name_en     = $values['table1']['R1.5']['Project_Name_EN'];
    $status              = $values['table2']['R2.1']['Conformity_Status'];
    $methodology_de      = $values['table2']['R2.2']['Assessment_Methodology_DE'];
    $methodology_en      = $values['table2']['R2.2']['Assessment_Methodology_EN'];
    $creation_date       = $values['table2']['R2.3']['Creation_Date'];
    $last_revis_date     = $values['table2']['R2.4']['Last_Revision_Date'];
    $report_url          = $values['table2']['R2.5']['Report_URL'];
    $known_issues_de     = $values['table3']['R3.1']['Known_Issues_DE'];
    $known_issues_en     = $values['table3']['R3.1']['Known_Issues_EN'];
    $statement_de        = $values['table3']['R3.2']['Justification_Statement_DE'];
    $statement_en        = $values['table3']['R3.2']['Justification_Statement_EN'];
    $alternatives_de     = $values['table3']['R3.3']['Alternative_Access_DE'];
    $alternatives_en     = $values['table3']['R3.3']['Alternative_Access_EN'];
    $pub_institute_de    = $values['table4']['R4.1']['Pub_Institute_DE'];
    $pub_institute_en    = $values['table4']['R4.1']['Pub_Institute_EN'];
    $pub_inst_url        = $values['table4']['R4.2']['Pub_Inst_URL'];
    $pub_name            = $values['table4']['R4.3']['Pub_Name'];
    $pub_address         = $values['table4']['R4.4']['Pub_Address'];
    $pub_plz             = $values['table4']['R4.5']['Pub_PLZ'];
    $pub_city_de         = $values['table4']['R4.6']['Pub_City_DE'];
    $pub_city_en         = $values['table4']['R4.6']['Pub_City_EN'];
    $pub_email           = $values['table4']['R4.7']['Pub_Email'];
    $pub_url             = $values['table4']['R4.8']['Pub_URL'];
    $sup_institute_de    = $values['table5']['R5.1']['Sup_Institute_DE'];
    $sup_institute_en    = $values['table5']['R5.1']['Sup_Institute_EN'];
    $sup_email           = $values['table5']['R5.2']['Sup_Email'];
    $sup_address         = $values['table5']['R5.3']['Sup_Address'];
    $sup_plz             = $values['table5']['R5.4']['Sup_PLZ'];
    $sup_city_de         = $values['table5']['R5.5']['Sup_City_DE'];
    $sup_city_en         = $values['table5']['R5.5']['Sup_City_EN'];
    $sup_url             = $values['table5']['R5.6']['Sup_URL'];
    $overs_name_de       = $values['table6']['R6.1']['Oversight_Agency_Name_DE'];
    $overs_name_en       = $values['table6']['R6.1']['Oversight_Agency_Name_EN'];
    $overs_dept_de       = $values['table6']['R6.2']['Oversight_Agency_Dept_DE'];
    $overs_dept_en       = $values['table6']['R6.2']['Oversight_Agency_Dept_EN'];
    $overs_address       = $values['table6']['R6.3']['Oversight_Address'];
    $overs_plz           = $values['table6']['R6.4']['Oversight_PLZ'];
    $overs_city_de       = $values['table6']['R6.5']['Oversight_City_DE'];
    $overs_city_en       = $values['table6']['R6.5']['Oversight_City_EN'];
    $overs_phone         = $values['table6']['R6.6']['Oversight_Phone'];
    $overs_email         = $values['table6']['R6.7']['Oversight_Email'];
    $overs_url           = $values['table6']['R6.8']['Oversight_URL'];
    $date                = $values['Date'];

    $issues_array_de = explode('; ', $known_issues_de);
    $alternatives_array_de = explode('; ', $alternatives_de);
    $statement_array_de = explode('; ', $statement_de);

    $issues_array_en = explode('; ', $known_issues_en);
    $alternatives_array_en = explode('; ', $alternatives_en);
    $statement_array_en = explode('; ', $statement_en);

    $template = [
      '#theme'                 => 'barrierefreiheit_template',
      '#wisski_url'               => $wisski_url,
      '#leg_notice_url_de'        => $leg_notice_url_de,
      '#project_name_de'          => $project_name_de,
      '#status'                   => $status,
      '#methodology_de'           => $methodology_de,
      '#creation_date'            => $creation_date,
      '#last_revis_date'          => $last_revis_date,
      '#report_url'               => $report_url,
      '#known_issues_de'          => $known_issues_de,
      '#issues_array_de'          => $issues_array_de,
      '#statement_de'             => $statement_de,
      '#statement_array_de'       => $statement_array_de,
      '#alternatives_de'          => $alternatives_de,
      '#alternatives_array_de'    => $alternatives_array_de,
      '#pub_institute_de'         => $pub_institute_de,
      '#pub_inst_url'             => $pub_inst_url,
      '#pub_name'                 => $pub_name,
      '#pub_address'              => $pub_address,
      '#pub_plz'                  => $pub_plz,
      '#pub_city_de'              => $pub_city_de,
      '#pub_email'                => $pub_email,
      '#pub_url'                  => $pub_url,
      '#sup_institute_de'         => $sup_institute_de,
      '#sup_email'                => $sup_email,
      '#sup_url'                  => $sup_url,
      '#sup_address'              => $sup_address,
      '#sup_plz'                  => $sup_plz,
      '#sup_city_de'              => $sup_city_de,
      '#overs_name_de'            => $overs_name_de,
      '#overs_dept_de'            => $overs_dept_de,
      '#overs_address'            => $overs_address,
      '#overs_plz'                => $overs_plz,
      '#overs_city_de'            => $overs_city_de,
      '#overs_phone'              => $overs_phone,
      '#overs_email'              => $overs_email,
      '#overs_url'                => $overs_url,
      '#date'                     => $date,
    ];

    $deleteQuery = \Drupal::database()->delete('path_alias');
    $deleteQuery->condition('alias', '/'.$alias);
    $deleteQuery->execute();

    $html = \Drupal::service('renderer')->renderPlain($template);

    $this->generateNode($title, $html, $alias);


    $template_en = [
      '#theme'                 => 'accessibility_template',
      '#wisski_url'               => $wisski_url,
      '#leg_notice_url_en'        => $leg_notice_url_en,
      '#project_name_en'          => $project_name_en,
      '#status'                   => $status,
      '#methodology_en'           => $methodology_en,
      '#creation_date'            => $creation_date,
      '#last_revis_date'          => $last_revis_date,
      '#report_url'               => $report_url,
      '#known_issues_en'          => $known_issues_en,
      '#issues_array_en'          => $issues_array_en,
      '#statement_en'             => $statement_en,
      '#statement_array_en'       => $statement_array_en,
      '#alternatives_en'          => $alternatives_en,
      '#alternatives_array_en'    => $alternatives_array_en,
      '#pub_institute_en'         => $pub_institute_en,
      '#pub_inst_url'             => $pub_inst_url,
      '#pub_name'                 => $pub_name,
      '#pub_address'              => $pub_address,
      '#pub_plz'                  => $pub_plz,
      '#pub_city_en'              => $pub_city_en,
      '#pub_email'                => $pub_email,
      '#pub_url'                  => $pub_url,
      '#sup_institute_en'         => $sup_institute_en,
      '#sup_email'                => $sup_email,
      '#sup_url'                  => $sup_url,
      '#sup_address'              => $sup_address,
      '#sup_plz'                  => $sup_plz,
      '#sup_city_en'              => $sup_city_en,
      '#overs_name_en'            => $overs_name_en,
      '#overs_dept_en'            => $overs_dept_en,
      '#overs_address'            => $overs_address,
      '#overs_plz'                => $overs_plz,
      '#overs_city_en'            => $overs_city_en,
      '#overs_phone'              => $overs_phone,
      '#overs_email'              => $overs_email,
      '#overs_url'                => $overs_url,
      '#date'                     => $date,
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
        'title'   => $title,
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


