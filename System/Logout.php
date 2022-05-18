<?php
if(session_id() == ''){
    session_start();
}
session_unset();
session_destroy();
echo(" <script> location.replace('index.php'); </script>");