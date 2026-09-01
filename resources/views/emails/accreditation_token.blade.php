<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accreditation Token</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            background-color: #f9fbf9;
            border-radius: 12px;
            padding: 30px;
            border: 1px solid #e2ece6;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
        }
        .header h1 {
            color: #008751;
            margin: 0;
            font-size: 24px;
        }
        .token-box {
            background-color: #ffffff;
            border: 2px solid #008751;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
        }
        .token {
            font-size: 32px;
            font-weight: bold;
            color: #008751;
            letter-spacing: 4px;
            font-family: 'Courier New', monospace;
        }
        .info {
            background-color: #ffffff;
            padding: 15px 20px;
            border-radius: 8px;
            margin: 20px 0;
            border: 1px solid #e2e8f0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #64748b;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1> E-Voting Accreditation</h1>
        </div>

        <p>Dear {{ $member->first_name }} {{ $member->last_name }},</p>

        <p>Your single-use accreditation token has been successfully generated. Please use this token to cast your vote on the voting portal.</p>

        <div class="token-box">
            <p style="margin: 0 0 8px 0; font-size: 13px; color: #64748b; text-transform: uppercase; font-weight: bold; letter-spacing: 1px;">Your Accreditation Token:</p>
            <div class="token">{{ $accreditation->token }}</div>
        </div>

        <div class="info">
            <p style="margin-top: 0; color: #008751; font-weight: bold;">Important Security Information:</p>
            <ul style="padding-left: 20px; margin-bottom: 0;">
                <li>Keep this token secure and confidential.</li>
                <li>You will need this token to cast your vote.</li>
                <li>Do not share this token with anyone.</li>
                <li>This token is unique to you and can only be used once.</li>
            </ul>
        </div>

        <p><strong>Member Details:</strong></p>
        <ul style="padding-left: 20px;">
            <li>Practice ID: {{ $member->staff_ID }}</li>
            <li>Name: {{ $member->first_name }} {{ $member->last_name }}</li>
            <li>Email: {{ $member->email }}</li>
        </ul>

        <p style="font-size: 13px; color: #64748b;">If you did not request this accreditation token, please contact the election administrator immediately.</p>

        <div class="footer">
            <p>This is an automated message from E-Voting Portal. Please do not reply.</p>
            <p>&copy; {{ date('Y') }} E-Voting Portal. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
