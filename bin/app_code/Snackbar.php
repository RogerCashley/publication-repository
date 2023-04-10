<?php

class Snackbar
{
  public static function showAlert($text, $position = 'bottom-center')
  {
    echo "<script>Snackbar.show({pos: '$position', text: '$text'});</script>";
  }

  public static function redirectAlert($text, $location, $position = 'top-center')
  {
    echo "<script>Snackbar.show({pos: '$position', text: '$text', onClose: () => { window.location.href = \"$location\"; }});</script>";
  }
}
