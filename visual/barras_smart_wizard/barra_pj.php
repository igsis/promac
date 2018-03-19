<?php 
# 
$url = array(

);

for ($i = 0; $i < count($url); $i++) {
    if ($uri == $urlEventoPf[$i]) {
        if ($i == 0){
            $ativa1 = 'active loading';
        }elseif ($i == 1) {                
            $ativa2 = 'active loading';
        }


?>

 <!-- Pessoa Física      -->
        <div id="smartwizard">
            <ul>
                <li class="hidden">
                    <a href=""><br /></a>
                </li>
                <li class="<?php echo isset($ativa1) ? $ativa1 : 'clickable'; ?>">
                    <a onclick="location.href=''" href=""><br /><small>Informações Iniciais</small></a>
                </li> 
                <li class="<?php echo isset($ativa2) ? $ativa2 : 'clickable'; ?>">
                    <a onclick="location.href=''" href=""><br /><small>Arquivos da Pessoa</small></a>
                </li>          
            </ul> 
        </div>
<?php  
    
    }
}
?>