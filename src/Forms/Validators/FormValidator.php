<?php

declare(strict_types=1);

namespace App\Forms\Validators;

use FormRules;


/** 
 * This class validates forms passed to it. Uses passed data and
 * system of rules which are for validation
 * against given parameters or requirements 
 */

class FormValidator
{
    public $validatedData;
    private $errors = [];

    /**
     * @param array $data Data passed to the validator ($_POST for example)
     * @param array $rules Rules declared in Enum
     */
    public function validateForm(array $data, array $rules)
    {
        
        $dataKeys = array_keys($data);
        $rulesKeys = array_keys($rules);
       // dump($rules);
        foreach ($dataKeys as $key) {
            // dump($data[$key]);
            // get one, for example login
            // check if rules exists in $rules
            // if no, add it to return array
            // if yes, validate, generate error or not (add it to return array)
            if (array_key_exists($key, $rules)) {

                // get rules
                $keyRules = $rules[$key];
                foreach ($keyRules as $rule) {
        
                    // $data[key] is a value of key from data

                    // if $rule is not Enum FormRules it means
                    // it's array containing another array with Enum+param
                    // like Min/Max length

                    if (!($rule instanceof FormRules)) {
                        $ruleName = $rule[0];
                        $ruleParam = $rule[1];
                      

                        if ($ruleName === FormRules::MinLength ) {
                            if (strlen($data[$key]) < $ruleParam) {
                                $this->errors[] = ucFirst($key) . ' is too short.';
                            }
                        }
                        if ($ruleName === FormRules::MaxLength ) {
                            if (strlen($data[$key]) > $ruleParam) {
                                $this->errors[] = ucFirst($key) . ' is too long.';
                            }
                        }

                    }
                    if ($rule === FormRules::Required) {
                        if (empty($data[$key])) {
                            $this->errors[] = ucfirst($key) . ' cannot be empty';
                        }   // if empty


                        //$data[$key] 
                    } else if ($rule === FormRules::Email) {

                        // sanitize email first
                        $email = filter_var($data[$key], FILTER_SANITIZE_EMAIL);

                        // make sure it has email format
                        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            echo "";
                        } else {
                            $this->errors[] = 'Wrong email format';
                        }
                      
                    }
                }
            }
        } // foreach
        if (empty($this->errors)) {
            return [];
        }
       return $this->errors;
    }
    public function sanitizeData(string $text)
    {
        $sanitizedData = htmlspecialchars($text);
        return $sanitizedData;
    }
}
