<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Contraseña</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f3f4f6;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f3f4f6; padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    <tr>
                        <td style="background: linear-gradient(135deg, #0891b2, #1d4ed8); padding: 30px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 700;">Tendejón Azael</h1>
                            <p style="color: rgba(255,255,255,0.85); margin: 8px 0 0; font-size: 13px; letter-spacing: 0.5px;">Recuperación de contraseña</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 40px 30px;">
                            <h2 style="color: #1f2937; margin: 0 0 16px; font-size: 20px;">Hola, {{ $user->name }}</h2>
                            <p style="color: #4b5563; font-size: 15px; line-height: 1.6; margin: 0 0 24px;">
                                Hemos recibido una solicitud para restablecer tu contraseña. Tu nueva contraseña temporal es:
                            </p>
                            <div style="background-color: #f0f9ff; border: 2px solid #0891b2; border-radius: 8px; padding: 20px; text-align: center; margin: 0 0 24px;">
                                <p style="margin: 0 0 8px; color: #6b7280; font-size: 13px;">Tu nueva contraseña:</p>
                                <p style="margin: 0; color: #0891b2; font-size: 24px; font-weight: bold; letter-spacing: 2px;">{{ $password }}</p>
                            </div>
                            <p style="color: #4b5563; font-size: 15px; line-height: 1.6; margin: 0 0 16px;">
                                Te recomendamos cambiar esta contraseña una vez que inicies sesión, desde tu perfil de usuario.
                            </p>
                            <p style="color: #ef4444; font-size: 13px; line-height: 1.6; margin: 0;">
                                <strong>Importante:</strong> Si no solicitaste este cambio, contacta al administrador inmediatamente.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color: #f9fafb; padding: 20px 30px; text-align: center; border-top: 1px solid #e5e7eb;">
                            <p style="color: #9ca3af; font-size: 12px; margin: 0;">
                                &copy; {{ date('Y') }} Tendejón Azael. Todos los derechos reservados.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
