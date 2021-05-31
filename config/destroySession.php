<?php
session_start(['name' => 'prmc']);
session_destroy();
echo '<script> window.location.href="'. SERVERURL .'" </script>';