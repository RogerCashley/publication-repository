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


    public static function encrypt($string, $key)
    {
        $result = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $char = $string[$i];
            $ascii = ord($char);
            $shift = ord($key[$i % strlen($key)]);
            $newAscii = ($ascii + $shift) % 256;
            $result .= chr($newAscii);
        }
        return base64_encode($result);
    }

    public static function decrypt($string, $key)
    {
        $result = '';
        $string = base64_decode($string);
        for ($i = 0; $i < strlen($string); $i++) {
            $char = $string[$i];
            $ascii = ord($char);
            $shift = ord($key[$i % strlen($key)]);
            $newAscii = ($ascii - $shift + 256) % 256;
            $result .= chr($newAscii);
        }
        return $result;
    }
}
