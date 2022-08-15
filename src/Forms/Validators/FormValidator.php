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
    private $dataToValidate;
    private $errors = [];

    /**
     * @param array $data Data passed to the validator ($_POST for example)
     * @param array $rules Rules declared in Enum
     */
    public function validateForm(array $data, array $rules)
    {
        $dataKeys = array_keys($data);
        $rulesKeys = array_keys($rules);
        dump($rules);
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
                    if ($rule === FormRules::Required) {
                        if (empty($data[$key])) {
                            $this->errors[] = ucfirst($key) . ' cannot be empty';
                        }   // if empty


                        //$data[$key] 
                    } else if ($rule === FormRules::Email) {
                        if (filter_var($data[$key], FILTER_VALIDATE_EMAIL)) {
                            echo "";
                        } else {
                            $this->errors[] = 'Wrong email format';
                        }
                        // if rule ===
                    }
                }
            }
        } // foreach
        dump($this->errors);
    }
}
