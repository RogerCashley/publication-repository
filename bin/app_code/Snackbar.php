<?php

class Snackbar {
  public static function showAlert($text) {
    echo "<script>Snackbar.show({pos: 'bottom-center', text: '$text'});</script>";
  }
}