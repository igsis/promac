<?php

require_once('include/phpmailer/src/PHPMailer.php');
require_once('include/phpmailer/src/SMTP.php');
require_once('include/phpmailer/src/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function enviaEmail($destinatario, $id, $tipo) {
    $mail = new PHPMailer();

    try {
        $mail->isSMTP();
        $mail->CharSet = "UTF-8";
        $mail->Host = 'smtp.gmail.com';
        $mail->setLanguage('pt');
        $mail->SMTPAuth = true;
        $mail->Username = "no.reply.smcsistemas@gmail.com";
        $mail->Password = "dec1935!";
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

//        DEBUG
//        $mail->SMTPDebug =  SMTP::DEBUG_SERVER;
//        $mail->SMTPDebug = 3;
//        $mail->Debugoutput = 'html';

        $mail->setFrom('no.reply.smcsistemas@gmail.com','PROMAC');
        $mail->addReplyTo('no-reply@promac.com.br');

        $mail->addAddress($destinatario);

        $mail->isHTML(true);
        $mail->Subject = "PROMAC - Recuperação de Senha";
        $mail->Body = gerarEmail($tipo, $id);

        if ($mail->send())
            return "<font color='#01DF3A'><strong>E-mail enviado com sucesso. Por favor verifique sua caixa de e-mail!</strong></font>";

        return "<font color='#ff0000'><strong>Erro durante envio do e-mail!</strong></font>";
    }catch (Exception $ex) {
        return "<font color='#ff0000'><strong>Erro durante envio do e-mail!</strong></font>";
    }
}

function gerarEmail($tipo, $id){

    $endereco = "http://localhost/promac/reset_senha.php?tipoPessoa={$tipo}&token={$id}";
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