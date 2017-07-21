<?php
// GESTION DES FLASHBAGS

function setFlashbag($state, $message) {
  // if (isset($_SESSION['flashbag'])) {
  //
  // }

  array_push($_SESSION['flashbag'], [
    "state" => $state,
    "message" => $message,
  ]);
}
