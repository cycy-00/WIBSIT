<?php
session_start();
session_destroy();
header("Location: ../HOMEPAGE/index.php");
exit();