<?php
session_start();
session_destroy();
header('Location: tic_tac_toe.php');
exit();
