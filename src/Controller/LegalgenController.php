<?php

namespace Drupal\legalgen\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class LegalgenController extends ControllerBase {

    public function content(Request $request) {

        // Create Response Object
        $response = new Response();

        // Get Query Strings (URL Parameters) from Request
        $lang = \Drupal::request()->query->get('lang');
        $page_name = \Drupal::request()->query->get('pn');

        // Check that Both Parameters Were Given in Query String
        if(empty($lang) and empty($page_name)){
            $response->setContent('Unfortunately an error ocurred: Page type and language not provided', 'status', TRUE);
            return $response;
        }
        if(empty($lang)){
            $response->setContent('Unfortunately an error ocurred: Page language not provided', 'status', TRUE);
            return $response;
        }
        if(empty($page_name)){
            $response->setContent('Unfortunately an error ocurred: Page type not provided', 'status', TRUE);
            return $response;
        }

        // Check that Parameters are Valid

        // Check if Page Name is Valid
        $required_key = \Drupal::service('legalgen.generator')->validatePage($page_name);
        // If Page Name NOT Valid Return Error Message
        if($required_key === NULL){
            // If Page Name NOT Valid Return Error Message
            $response->setContent('Unfortunately an error ocurred: Page type not available', 'status', TRUE);
            return $response;
        }

        // Check if Language is Valid
        $valid_lang = \Drupal::service('legalgen.generator')->validateLang($lang);
        // If Language NOT Valid Return Error Message
        if($valid_lang === 'Not configured' or $valid_lang === 'Empty'){
            $response->setContent('Unfortunately an error ocurred: Specified language not available', 'status', TRUE);
            return $response;
        }

        // Build Route to Send User Back to Form After Resetting to Default
        if($page_name === 'legal_notice'){
            $route = 'wisski.legalgen.legalnotice';
        } else if ($page_name === 'accessibility' or $page_name === 'privacy'){
            $route = 'wisski.legalgen.'.$page_name;
        }

        // Create Key to Access State Values Related to Correct Page
        $state_key = "legalgen.{$page_name}";

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
        \Drupal::messenger()->addStatus('Successfully reset values to default', 'status', TRUE);

        return self::redirect($route);
    }

    // Return User to Form They Started from and Display Status Message
    \Drupal::messenger()->addError('Values were already set to default', 'status', TRUE);
    return self::redirect($route);
    }
}