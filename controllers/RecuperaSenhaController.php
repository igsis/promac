<?php

if ($pedidoAjax) {
    require_once "../models/RecuperaSenhaModel.php";
    require_once "../controllers/RecuperaSenhaController.php";
    require_once "../controllers/UsuarioController.php";
} else {
    require_once "./models/RecuperaSenhaModel.php";
    require_once "./controllers/RecuperaSenhaController.php";
    require_once "./controllers/UsuarioController.php";
}

require_once  "../views/plugins/phpmailer/src/PHPMailer.php";
require_once  "../views/plugins/phpmailer/src/SMTP.php";
require_once  "../views/plugins/phpmailer/src/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class RecuperaSenhaController extends RecuperaSenhaModel
{
    public function verificaEmail($email)
    {
        $usuario = new UsuarioController();
        $emailBD = $usuario->recuperaEmail($email);

        if ($emailBD->rowCount() == 1) {

            $token = $this->gerarToken();

            $dados = array(
                'email' => $email,
                'token' => $token,
            );

            if ($this->setToken($email, $token)) {
                $this->enviarEmail($email,$token);
                $alert = [
                    'alerta' => 'simples',
                    'titulo' => 'Resete enviado por e-mail',
                    'texto' => "Enviamos um email para <b>$email</b> para a reiniciarmos sua senha. <br> Por favor acesse seu email e clique no link recebido para cadastrar uma nova senha! (Lembre-se de verificar o spam)",
                    'tipo' => 'success',
                ];
            } else {
                $alert = [
                    'alerta' => 'simples',
                    'titulo' => 'Erro',
                    'texto' => "Erro ao tentar enviar e-mail, por favor tente novamente.",
                    'tipo' => 'error',
                ];
            }
        } else {
            $alert = [
                'alerta' => 'simples',
                'titulo' => 'Não tem email',
                'texto' => "E-mail não encontrado em nossa base de dados.",
                'tipo' => 'error',
            ];
        }

        return MainModel::sweetAlert($alert);
    }

    public function gerarToken()
    {
        return MainModel::encryption(random_bytes(50));
    }

    public function enviarEmail($endEmail,$token)
    {
        $email =  new PHPMailer();

        try{

            $email->isSMTP();
            $email->CharSet = "UTF-8";
            $email->Host = 'smtp.gmail.com';
            $email->SMTPAuth = true;
            $email->Username = SMTP;
            $email->Password = SENHASMTP;
            $email->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $email->Port = 587;

//            DEBUG
//            $email->SMTPDebug =  SMTP::DEBUG_SERVER;
//            $email->setLanguage('pt');
//            $email->SMTPDebug = 3;
//            $email->Debugoutput = 'html';

            $email->setFrom(SMTP);
            $email->FromName = "CAPAC";
            $email->addReplyTo('no-reply@capac.com.br');
            $email->addAddress($endEmail);

            $email->isHTML(true);
            $email->Subject = "CAPAC - Recuperação de Senha";
            $email->Body = $this->geraEmail($token);

            if ($email->send())
                return true;

            return false;

        } catch (Exception $e){
            MainModel::gravarLog("Erro ao enviar e-mail: {$email->ErrorInfo}");

            return false;
        }
    }

    public function geraEmail($token)
    {
        $endereco = SERVERURL . "resete_senha&tk=".$token;
        $html = "<!DOCTYPE html>
        <html style=\"padding: 0px; margin: 0px;\" lang=\"pt_br\">
           <head> 
               <meta charset=\"UTF-8\" />
                <style>
                   body{margin:
                        0;padding: 0;
                   }
                   @media only screen and (max-width:640px){
                       table, img[class=\"partial-image\"]{
                            width:100% !important;
                            height:auto !important;
                            min-width: 200px !important; 
                   }
              </style>
           </head>
        <body>
        <table style=\"border-collapse: collapse; border-spacing:
           0; min-height: 418px;\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" bgcolor=\"#f2f2f2\">
           <tbody>
              <tr>
                 <td align=\"center\" style=\"border-collapse: collapse;
                    padding-top: 30px; padding-bottom: 30px;\">
                    <table cellpadding=\"5\" cellspacing=\"5\" width=\"600\" bgcolor=\"white\" style=\"border-collapse: collapse;
                       border-spacing: 0;\">
                       <tbody>
                          <tr>
                             <td style=\"border-collapse: collapse; padding: 0px;
                                text-align: center; width: 600px;\">
                                <table style=\"border-collapse: collapse;
                                   border-spacing: 0; box-sizing: border-box;
                                   min-height: 40px; position: relative; width: 100%;
                                   font-family: Arial; font-size: 25px;
                                   padding-bottom: 20px; padding-top: 20px;
                                   text-align: center; vertical-align:
                                   middle;\">
                                   <tbody>
                                      <tr>
                                         <td style=\"border-collapse: collapse; font-family:
                                            Arial; padding: 10px 15px;\">
                                            <table width=\"100%\" style=\"border-collapse: collapse; border-spacing:
                                               0; font-family: Arial;\">
                                               <tbody>
                                                  <tr>
                                                     <td style=\"border-collapse: collapse;\">
                                                        <h2 style=\"font-weight: normal; margin: 0px; padding:
                                                           0px; color: #666; word-wrap: break-word;\"><a style=\"display: inline-block; text-decoration:
                                                           none; box-sizing: border-box; font-family: arial;
                                                           width: 100%; font-size: 25px; text-align: center;
                                                           word-wrap: break-word; color: rgb(102,102,102);
                                                           cursor: text;\" target=\"_blank\"><span style=\"font-size: inherit; text-align: center;
                                                           width: 100%; color: #666;\">Olá!</span></a>
                                                        </h2>
                                                     </td>
                                                  </tr>
                                               </tbody>
                                            </table>
                                         </td>
                                      </tr>
                                   </tbody>
                                </table>
                                <table style=\"border-collapse: collapse;
                                   border-spacing: 0; box-sizing: border-box;
                                   min-height: 40px; position: relative; width:
                                   100%;\">
                                   <tbody>
                                      <tr>
                                         <td style=\"border-collapse:
                                            collapse; font-family: Arial; padding: 10px
                                            15px;\">
                                            <table width=\"100%\" style=\"border-collapse: collapse; border-spacing:
                                               0; text-align: left; font-family:
                                               Arial;\">
                                               <tbody>
                                                  <tr>
                                                     <td style=\"border-collapse:
                                                        collapse;\">
                                                        <div style=\"font-family: Arial;
                                                           font-size: 15px; font-weight: normal; line-height:
                                                           170%; text-align: left; color: #666; word-wrap:
                                                           break-word;\">
                                                           <div style=\"text-align:
                                                              center;\">Recebemos sua solicitação de recuperação de senha. Caso tenha solicitado, clique no botão abaixo para continuar<span style=\"line-height: 0;
                                                                 display: none;\"></span><span style=\"line-height:
                                                                 0; display:
                                                                 none;\"></span>.
                                                           </div>
                                                        </div>
                                                     </td>
                                                  </tr>
                                               </tbody>
                                            </table>
                                         </td>
                                      </tr>
                                   </tbody>
                                </table>
                                <table style=\"border-collapse: collapse;
                                   border-spacing: 0; box-sizing: border-box;
                                   min-height: 40px; position: relative; width: 100%;
                                   padding-bottom: 10px; padding-top: 10px;
                                   text-align: center;\">
                                   <tbody>
                                      <tr>
                                         <td style=\"border-collapse: collapse; font-family:
                                            Arial; padding: 10px 15px;\">
                                            <div style=\"font-family: Arial; text-align:
                                               center;\">
                                               <table style=\"border-collapse:
                                                  collapse; border-spacing: 0; background-color:
                                                  rgb(0,123,255); border-radius: 10px; color:
                                                  rgb(255,255,255); display: inline-block;
                                                  font-family: Arial; font-size: 15px; font-weight:
                                                  bold; text-align: center;\">
                                                  <tbody style=\"display:
                                                     inline-block;\">
                                                     <tr style=\"display:
                                                        inline-block;\">
                                                        <td align=\"center\" style=\"border-collapse: collapse; display:
                                                           inline-block; padding: 15px 20px;\"><a target=\"_blank\" href='".$endereco."' style=\"display: inline-block;
                                                           text-decoration: none; box-sizing: border-box;
                                                           font-family: arial; color: #fff; font-size: 15px;
                                                           font-weight: bold; margin: 0px; padding: 0px;
                                                           text-align: center; word-wrap: break-word; width:
                                                           100%; cursor: text;\">Recupere Sua Senha Aqui</a>
                                                        </td>
                                                     </tr>
                                                  </tbody>
                                               </table>
                                            </div>
                                         </td>
                                      </tr>
                                   </tbody>
                                </table>
                                <table style=\"border-collapse: collapse;
                                   border-spacing: 0; box-sizing: border-box;
                                   min-height: 40px; position: relative; width:
                                   100%;\">
                                   <tbody>
                                   <tr>
                                      <td style=\"border-collapse:
                                            collapse; font-family: Arial; padding: 10px
                                            15px;\">
                                         <table width=\"100%\" style=\"border-collapse: collapse; border-spacing:
                                               0; text-align: left; font-family:
                                               Arial;\">
                                            <tbody>
                                            <tr>
                                               <td style=\"border-collapse:
                                                        collapse;\">
                                                  <div style=\"font-family: Arial;
                                                           font-size: 15px; font-weight: normal; line-height:
                                                           170%; text-align: left; color: #666; word-wrap:
                                                           break-word;\">
                                                     <div style=\"text-align:
                                                              center;\">Caso não tenha sido você, apenas ignore este e-mail e sua senha se manterá a mesma.<span style=\"line-height: 0;
                                                                 display: none;\"></span><span style=\"line-height:
                                                                 0; display:
                                                                 none;\"></span>
                                                     </div>
                                                  </div>
                                               </td>
                                            </tr>
                                            </tbody>
                                         </table>
                                      </td>
                                   </tr>
                                   </tbody>
                                </table>
        
                                <table style=\"border-collapse: collapse;
                                   border-spacing: 0; box-sizing: border-box;
                                   min-height: 40px; position: relative; width:
                                   100%;\">
                                   <tbody>
                                      <tr>
                                         <td style=\"border-collapse:
                                            collapse; font-family: Arial; padding: 10px
                                            15px;\">
                                            <table width=\"100%\" style=\"border-collapse: collapse; border-spacing:
                                               0; text-align: left; font-family:
                                               Arial;\">
                                               <tbody>
                                                  <tr>
                                                     <td style=\"border-collapse:
                                                        collapse;\">
                                                        <div style=\"font-family: Arial;
                                                           font-size: 15px; font-weight: normal; line-height:
                                                           170%; text-align: left; color: rgb(120,113,99);
                                                           word-wrap: break-word;\">
                                                           <div style=\"text-align:
                                                              center; color: rgb(120,113,99);\"><span style=\"line-height: 0; display: none; color:
                                                              rgb(120,113,99);\"></span><br/>Atenciosamente,<br/><br/><strong>SMC Sistemas</strong>
                                                           </div>
                                                        </div>
                                                     </td>
                                                  </tr>
                                                  <tr>
                                                     <td style=\"border-collapse:
                                                        collapse;\">
                                                        <div style=\"font-family: Arial;
                                                           font-size: 15px; font-weight: normal; line-height:
                                                           170%; text-align: left; color: rgb(120,113,99);
                                                           word-wrap: break-word;\">
                                                           <div style=\"text-align:
                                                              center; color: rgb(120,113,99);\"><span style=\"line-height: 0; display: none; color:
                                                              rgb(120,113,99);\"></span><br/><hr/><strong>Esta é uma mensagem automática. Por favor, não responda este e-mail.</strong>
                                                           </div>
                                                        </div>
                                                     </td>
                                                  </tr>
                                               </tbody>
                                            </table>
                                         </td>
                                      </tr>
                                   </tbody>
                                </table>
                             </td>
                          </tr>
                       </tbody>
                    </table>
                 </td>
              </tr>
           </tbody>
        </table>
        </body>
        </html>
            ";
        return $html;
    }

    public function novaSenha($senha, $token)
    {
        $query = "SELECT `email` FROM `capac_new`.`resete_senhas` WHERE token = '".$token."'";
        $resultado = DbModel::consultaSimples($query);
        if ($resultado->rowCount() == 1) {
            $email = $resultado->fetch(PDO::FETCH_COLUMN);
            $dado = array('senha' => MainModel::encryption($senha));
            DbModel::updateEspecial('usuarios', $dado, 'email', $email);
            if (DbModel::connection()->errorCode() == 0) {
                DbModel::deleteEspecial('resete_senhas', 'token', $token);
                if (DbModel::connection()->errorCode() == 0) {
                    $alert = [
                        'alerta' => 'sucesso',
                        'titulo' => 'Sucesso!',
                        'texto' => 'Senha altera com sucesso!',
                        'tipo' => 'success',
                        'location' => SERVERURL
                    ];
                } else {
                    $alert = $this->erroToken();
                }

            } else {
                $alert = $this->erroToken();
            }
        } else {
            $alert = $this->erroToken('Esse link já foi utilizado para trocar senha.<br>Faça uma nova solicitação para trocar senha.');
        }

        return MainModel::sweetAlert($alert);
    }

    private function erroToken($textErro = 'Erro ao tentar trocar senha. Tente novamente.')
    {
        return [
            'alerta' => 'simples',
            'titulo' => 'Erro',
            'texto' => $textErro,
            'tipo' => 'error',
        ];
    }


}