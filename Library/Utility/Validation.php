<?php
namespace MyMVC\Library\Utility;

class Validation
{

    private $rules = [];

    private $errors = [];

    /**
     *
     * @param multitype $value
     * @param string $rule
     * @param multitype $params
     * @param string $errorMsg
     * @return \MyMVC\Library\Utility\Validation
     */
    public function setRule($value, $rule, $params = [], $errorMsg = null)
    {
        $this->rules[] = [
	       'value' => $value,
	       'rule' => $rule,
	       'params' => $params,
	       'error' => $errorMsg
        ];

        return $this;
    }

    /**
     *
     * @return boolean
     */
    public function validate()
    {
        //$this->errors = [];
        foreach ($this->rules as $rule) {
            $condition = self::{$rule['rule']}($rule['value'], $rule['params']);

            if (!$condition) {
                if ($rule['error'] != null) {
                    $this->errors[] = $rule['error'];
                } else {
                    $this->errors[] = $rule['rule'];
                }
            }
        }

        return count($this->errors) == 0;
    }

    public function __call($name, $arguments)
    {
        throw new \Exception('Invalid validation rule ' . $name, 500);

    }

    public function getErrors()
    {
        return $this->errors;
    }

    public static function required($value)
    {
        if (is_array($value)) {
            return !empty($value);
        } else {
            $str = str_replace(' ', '', $value);

            return strlen($str) != 0;
        }
    }

    public static function email($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function matched($first, $second)
    {
        return $first == $second;
    }

    public static function notContains($haystack, $needle)
    {
        return strrpos($haystack, $needle) === false;
    }
}