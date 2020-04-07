<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $subject }}</title>
    <!-- Designed by https://github.com/kaytcat -->
    <!-- Header image designed by Freepik.com -->


    <style type="text/css">
        /* Take care of image borders and formatting */

        img { max-width: 600px; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic;}
        a img { border: none; }
        table { border-collapse: collapse !important; }
        #outlook a { padding:0; }
        .ReadMsgBody { width: 100%; }
        .ExternalClass {width:100%;}
        .backgroundTable {margin:0 auto; padding:0; width:100% !important;}
        table td {border-collapse: collapse;}
        .ExternalClass * {line-height: 115%;}


        /* General styling */

        td {
            font-family: Arial, sans-serif;
        }

        body {
            -webkit-font-smoothing:antialiased;
            -webkit-text-size-adjust:none;
            width: 100%;
            height: 100%;
            color: #6f6f6f;
            font-weight: 400;
            font-size: 18px;
        }


        h1 {
            margin: 10px 0;
        }

        a {
            color: #27aa90;
            text-decoration: none;
        }

        .force-full-width {
            width: 100% !important;
        }


        .body-padding {
            padding: 0 75px;
        }


        .force-width-80 {
            width: 80% !important;
        }


    </style>

    <style type="text/css" media="screen">
        @media screen {
            @import url(http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,900);
            /* Thanks Outlook 2013! */
            * {
                font-family: 'Source Sans Pro', 'Helvetica Neue', 'Arial', 'sans-serif' !important;
            }
            .w280 {
                width: 280px !important;
            }

        }
    </style>

    <style type="text/css" media="only screen and (max-width: 480px)">
        /* Mobile styles */
        @media only screen and (max-width: 480px) {

            table[class*="w320"] {
                width: 320px !important;
            }

            td[class*="w320"] {
                width: 280px !important;
                padding-left: 20px !important;
                padding-right: 20px !important;
            }

            img[class*="w320"] {
                width: 250px !important;
                height: 67px !important;
            }

            td[class*="mobile-spacing"] {
                padding-top: 10px !important;
                padding-bottom: 10px !important;
            }

            *[class*="mobile-hide"] {
                display: none !important;
            }

            *[class*="mobile-br"] {
                font-size: 12px !important;
            }

            td[class*="mobile-w20"] {
                width: 20px !important;
            }

            img[class*="mobile-w20"] {
                width: 20px !important;
            }

            td[class*="mobile-center"] {
                text-align: center !important;
            }

            table[class*="w100p"] {
                width: 100% !important;
            }

            td[class*="activate-now"] {
                padding-right: 0 !important;
                padding-top: 20px !important;
            }

            td[class*="mobile-resize"] {
                font-size: 22px !important;
                padding-left: 15px !important;
            }

        }
    </style>
</head>
<body  offset="0" class="body" style="padding:0; margin:0; display:block; background:#eeebeb; -webkit-text-size-adjust:none" bgcolor="#eeebeb">
<table align="center" cellpadding="0" cellspacing="0" width="100%" height="100%">
    <tr>
        <td align="center" valign="top" style="background-color:#eeebeb" width="100%">
            <center>
                <table cellspacing="0" cellpadding="0" width="600" class="w320">
                    <tr>
                        <td align="center" valign="top">
                            <table cellspacing="0" cellpadding="0" width="100%" style="background-color:#3bcdb0;">
                                <tr>
                                    <td style="background-color:#3bcdb0;">
                                        <table cellspacing="0" cellpadding="0" width="100%">
                                            <tr>
                                                <td style="font-size:40px; font-weight: 600; color: #ffffff; text-align:center;" class="mobile-spacing">
                                                    <div class="mobile-br">&nbsp;</div>
                                                    Respuesta
                                                    <br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:20px; text-align:center; padding: 0 75px; color:#FFFFFF; text-transform: uppercase" class="w320 mobile-spacing; ">
                                                    {{ $stage }}
                                                </td>
                                            </tr>
                                        </table>

                                        <table cellspacing="0" cellpadding="0" width="100%">
                                            <tr>
                                                <td>
                                                    <img src="https://www.filepicker.io/api/file/4BgENLefRVCrgMGTAENj" style="max-width:100%; display:block;">
                                                </td>
                                            </tr>
                                        </table>

                                    </td>
                                </tr>
                            </table>

                            <table cellspacing="0" cellpadding="0" class="force-full-width" bgcolor="#ffffff" >
                                <tr>
                                    <td style="background-color:#ffffff;">
                                        <br>

                                        <div style="text-align: center">

                                            <table style="margin: 0 auto;" cellspacing="0" cellpadding="0" class="force-width-80">
                                                <tr>
                                                    <td style="text-align:justify; color: #6f6f6f; ">
                                                        <div style="max-width: 100%; margin: 20px auto 5px auto">
                                                            Estimado <strong>{{ $customerName }}</strong>:<br/>
                                                            Nos es grato dirigirnos a usted a fin de comunicarle que se
                                                            respondio su observación realizada sobre el punto
                                                            <strong style="text-transform: uppercase;">“{{ $stage }}”</strong>, a continuación se detalla la misma.
                                                        </div>
                                                        <div style="max-width: 100%; margin: 5px auto 5px auto">
                                                            <strong>Observación:</strong><br/>
                                                            {{ $observation }}
                                                        </div>
                                                        <div style="max-width: 100%; margin: 5px auto 5px auto">
                                                            <strong>Respuesta:</strong><br/>
                                                            {{ $reply }}
                                                        </div>
                                                        <div style="max-width: 100%; margin: 15px auto 20px auto">
                                                            Attentamente:<br/>
                                                            <div style="margin: 15px 0 10px auto; font-weight: bold; font-size: 14px;">DPINTART S.A.</div>
                                                            Calle 58 Urb el Pinar, Comas - Teléfono: (01) 615-1111.
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <table cellspacing="0" cellpadding="0" bgcolor="#363636"  class="force-full-width">
                                            <tr>
                                                <td style="background-color:#363636; text-align:center;">
                                                    <br>
                                                    <br>
                                                    <img width="68" height="56" src="https://www.filepicker.io/api/file/W6gXqm5BRL6qSvQRcI7u">
                                                    <img width="61" height="56" src="https://www.filepicker.io/api/file/eV9YfQkBTiaOu9PA9gxv">
                                                    <br>
                                                    <br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="color:#f0f0f0; font-size: 14px; text-align:center; padding-bottom:4px;">
                                                    © {{ date( 'Y' ) }} Todos los derechos reservados
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="color:#27aa90; font-size: 14px; text-align:center;">
                                                    <a href="{{ env( 'APP_URL' ) }}" target="_blank">Ver en el navegador</a> | <a href="#">Contacto</a> | <a href="#">Unsubscribe</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:12px;"></td>
                                            </tr>
                                        </table>

                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </center>
        </td>
    </tr>
</table>
</body>
</html>
