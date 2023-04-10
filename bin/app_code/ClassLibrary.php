<?php

class ClassLibrary
{
    public static function increment_string_number($string, $default_string)
    {
        if ($string == null || trim($string) == "") {
            return $default_string;
        }

        preg_match('/(\d+)$/', $string, $matches); // extract the final most integer part of the string
        $number = $matches[1] + 1; // increment the extracted number
        $length = strlen($number);
        $result = substr($string, 0, -$length) . $number; // replace the final most integer part of the string with the incremented value
        return $result;
    }
}
