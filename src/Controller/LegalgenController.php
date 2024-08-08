<?php

namespace Drupal\legalgen\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class LegalgenController extends ControllerBase {

    /**
     * Checks that the Values from the Query String were Passed Correctly and are Valid. If this is applicable the Values in the State will be Reset to Default.
     *
     * @param Request $request Request with Query Strings Containing Information on the Language and Page Type for which the Values Stored in the State Should be Reset to Default.
     *
     * @return Response or Redirect Either returns a Response with Information on why the Values Cannot be Reset or Resets the Values and Returns the User to the Form for which
     * the Chose Reset. In the Latter Case a Success Message is Displayed Indicating Whether the Reset was Successful or Unnecessary Given that the Values were Already set to
     * Default.
     */
    public function content(Request $request) {

        // Create Response Object
        $response = new Response();

        // Get Query Strings (URL Parameters) from Request
        $lang = \Drupal::request()->query->get('lang');
        $page_type = \Drupal::request()->query->get('pt');

        // Check that Both Parameters Were Given in Query String
        if(empty($lang) and empty($page_type)){
            $response->setContent('Unfortunately an error ocurred: Page type and language not provided', 'status', TRUE);
            return $response;
        }
        if(empty($lang)){
            $response->setContent('Unfortunately an error ocurred: Page language not provided', 'status', TRUE);
            return $response;
        }
        if(empty($page_type)){
            $response->setContent('Unfortunately an error ocurred: Page type not provided', 'status', TRUE);
            return $response;
        }

        // Check that Parameters are Valid

        // Check if Page Name is Valid
        $required_key = \Drupal::service('legalgen.generator')->validatePage($page_type);
        // If Page Name NOT Valid Return Error Message
        if($required_key === NULL){
            // If Page Name NOT Valid Return Error Message
            $response->setContent('Unfortunately an error ocurred: Page type not available ('.$lang.')', 'status', TRUE);
            return $response;
        }

        // Check if Language is Valid
        $valid_lang = \Drupal::service('legalgen.generator')->validateLang($lang);
        // If Language NOT Valid Return Error Message
        if($valid_lang === 'Not configured' or $valid_lang === 'Empty'){
            $response->setContent('Unfortunately an error ocurred: Specified language not available ('.$lang.')', 'status', TRUE);
            return $response;
        }

        // Build Route to Send User Back to Form After Resetting to Default
        if($page_type === 'legal_notice'){
            $route = 'wisski.legalgen.legalnotice';
        } else if ($page_type === 'accessibility' or $page_type === 'privacy'){
            $route = 'wisski.legalgen.'.$page_type;
        }

        // Create Key to Access State Values Related to Correct Page
        $state_key = "legalgen.{$page_type}";

        // Get Array from State
        $content_state = \Drupal::state()->get($state_key);

        // Condition (Values Already Stored in State): Replace with Default Values
        if(!empty($content_state[$lang])){

        unset($content_state[$lang]);

        if(!empty($content_state['intl'])){

            unset($content_state['intl']);

            $new_state_vars = array($state_key => $content_state);

            \Drupal::state()->setMultiple($new_state_vars);

        }

        // Return User to Form They Started from and Display Success Message
        \Drupal::messenger()->addStatus('Successfully reset values to default ('.$lang.')', 'status', TRUE);

        return self::redirect($route);
    }

    // Return User to Form They Started from and Display Status Message
    \Drupal::messenger()->addError('Values were already set to default ('.$lang.')', 'status', TRUE);
    return self::redirect($route);
    }
}