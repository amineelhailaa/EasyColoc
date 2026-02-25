<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyColoc Invitation</title>
</head>
<body style="margin:0;padding:0;background-color:#eef4f7;font-family:Arial,sans-serif;color:#101e23;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#eef4f7;padding:24px 12px;">
    <tr>
        <td align="center">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:600px;background:#ffffff;border:1px solid #bad5de;border-radius:16px;overflow:hidden;">
                <tr>
                    <td style="padding:28px 28px 16px 28px;text-align:center;background:linear-gradient(180deg,#eef4f7 0%,#ffffff 100%);">
                        <p style="margin:0 0 10px 0;font-size:12px;letter-spacing:2px;text-transform:uppercase;color:#41778b;font-weight:700;">EasyColoc</p>
                        <h1 style="margin:0;font-size:26px;line-height:1.3;color:#213c45;">You're Invited to Join a Colocation Group</h1>
                    </td>
                </tr>
                <tr>
                    <td style="padding:8px 28px 28px 28px;">
                        <p style="margin:0 0 20px 0;font-size:15px;line-height:1.6;color:#315968;">
                            You received an invitation to join a group on EasyColoc. Click the button below to accept and continue.
                        </p>

                        <table role="presentation" cellpadding="0" cellspacing="0" style="margin:0 0 20px 0;">
                            <tr>
                                <td style="border-radius:10px;background-color:#41778b;">
                                    <a href="{{ $url }}" style="display:inline-block;padding:12px 20px;font-size:14px;font-weight:700;color:#ffffff;text-decoration:none;border-radius:10px;">
                                        Accept Invitation
                                    </a>
                                </td>
                            </tr>
                        </table>

                        <p style="margin:0 0 8px 0;font-size:13px;color:#315968;">If the button doesn't work, use this link:</p>
                        <p style="margin:0;word-break:break-all;font-size:13px;line-height:1.5;">
                            <a href="{{ $url }}" style="color:#41778b;text-decoration:underline;">{{ $url }}</a>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="padding:16px 28px 24px 28px;border-top:1px solid #dceaef;">
                        <p style="margin:0;font-size:12px;line-height:1.5;color:#5295ad;">
                            If you were not expecting this invitation, you can safely ignore this email.
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
