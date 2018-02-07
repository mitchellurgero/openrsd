<?php
if (!isset($_SESSION)) {
    session_start();
}
session_unset();
session_destroy();
session_start();
session_regenerate_id(true);
header("Location: ./");
die();
