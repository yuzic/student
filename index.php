<?php
    header('Content-type: text/html; charset=utf-8');
    require_once 'config.php';
    require "Virtc/Virtc.php";
    Virtc::Run();
    FrontController::instance()->route();
?>
