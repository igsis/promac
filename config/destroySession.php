<?php
session_start(['name' => 'cpc']);
session_destroy();
echo '<script> window.location.href="'. SERVERURL .'" </script>';