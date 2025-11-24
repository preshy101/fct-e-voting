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
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #2563eb;
            margin: 0;
        }
        .token-box {
            background-color: #fff;
            border: 2px solid #2563eb;
            border-radius: 6px;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
        }
        .token {
            font-size: 32px;
            font-weight: bold;
            color: #2563eb;
            letter-spacing: 4px;
            font-family: 'Courier New', monospace;
        }
        .info {
            background-color: #fff;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Accreditation Token Generated</h1>
        </div>

        <p>Dear {{ $member->first_name }} {{ $member->last_name }},</p>

        <p>Your accreditation token has been successfully generated. Please use this token to access the voting system.</p>

        <div class="token-box">
            <p style="margin: 0; font-size: 14px; color: #666;">Your Accreditation Token:</p>
            <div class="token">{{ $accreditation->token }}</div>
        </div>

        <div class="info">
            <p><strong>Important Information:</strong></p>
            <ul>
                <li>Keep this token secure and confidential</li>
                <li>You will need this token to cast your vote</li>
                <li>Do not share this token with anyone</li>
                <li>This token is unique to you and can only be used once</li>
            </ul>
        </div>

        <p><strong>Member Details:</strong></p>
        <ul>
            <li>Practice ID: {{ $member->practice_ID }}</li>
            <li>Name: {{ $member->first_name }} {{ $member->last_name }}</li>
            <li>Email: {{ $member->email }}</li>
        </ul>

        <p>If you did not request this accreditation token, please contact the election administrator immediately.</p>

        <div class="footer">
            <p>This is an automated message. Please do not reply to this email.</p>
            <p>&copy; {{ date('Y') }} E-Voting System. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
