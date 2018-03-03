<?php
    require('../include/conecta_mysql.php');
    if( isset( $_REQUEST['keyword'] ) )
    {
 
        $keyword        =       $_REQUEST['keyword'];
        $query          =       "SELECT * from ig_usuarios WHERE nomeUsuario LIKE '$keyword%'";
        $result         =       mysql_query($query);
        $html           =       "";
        while ( $row    =       mysql_fetch_array($result,MYSQLI_ASSOC) )
        {
            $html   .='<li>'.$row['state'].'</li>';
        }
 
        echo $html;
 
    }
?>