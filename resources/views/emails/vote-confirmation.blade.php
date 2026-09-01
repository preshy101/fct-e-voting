<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vote Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #008751 0%, #004d2e 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 12px 12px 0 0;
        }
        .content {
            background: #f9fbf9;
            padding: 30px;
            border: 1px solid #e2ece6;
            border-top: none;
            border-radius: 0 0 12px 12px;
        }
        .vote-card {
            background: white;
            border: 1px solid #d1fae5;
            border-radius: 8px;
            padding: 15px;
            margin: 15px 0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .vote-card h3 {
            margin: 0 0 8px 0;
            color: #0f172a;
        }
        .vote-card p {
            margin: 4px 0;
            color: #475569;
            font-size: 14px;
        }
        .success-icon {
            font-size: 44px;
            margin-bottom: 8px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            color: #64748b;
            font-size: 12px;
        }
        .info-box {
            background: #ecfdf5;
            border-left: 4px solid #008751;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .warning-box {
            background: #fffbeb;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="success-icon">✓</div>
        <h1 style="margin: 0; font-size: 24px;">Ballots Cast Successfully</h1>
        <p style="margin: 8px 0 0 0; opacity: 0.9; font-size: 14px;"> E-Voting Portal</p>
    </div>

    <div class="content">
        <p>Dear {{ $member->first_name }} {{ $member->last_name }},</p>

        <p>Thank you for exercising your voting rights. This email serves as official cryptographic confirmation that your votes have been cast and recorded.</p>

        <div class="info-box">
            <strong style="color: #008751;">Submission Summary</strong><br>
            <p style="margin: 8px 0 0 0; font-size: 14px;">
                <strong>Practice ID:</strong> {{ $member->staff_ID }}<br>
                <strong>Timestamp:</strong> {{ now()->format('F d, Y h:i A') }}<br>
                <strong>Contests Voted:</strong> {{ count($votes) }}
            </p>
        </div>

        <h2 style="font-size: 18px; color: #0f172a; margin-top: 25px;">Your Ballots:</h2>

        @foreach($votes as $vote)
        <div class="vote-card">
            <h3>{{ $vote['election_title'] }}</h3>
            <p><strong>Candidate:</strong> <span style="color: #008751; font-weight: bold;">{{ $vote['candidate_name'] }}</span></p>
            <p><strong>Vote Reference:</strong> <code style="background: #f1f5f9; padding: 2px 6px; border-radius: 4px; font-weight: bold;">{{ $vote['vote_token'] }}</code></p>
        </div>
        @endforeach

        <div class="warning-box">
            <strong style="color: #92400e;">Security Notice:</strong>
            <ul style="margin: 8px 0 0 0; padding-left: 20px; font-size: 13px; color: #78350f;">
                <li>Your vote is confidential and encrypted.</li>
                <li>Votes cannot be modified or re-cast once submitted.</li>
                <li>Retain this confirmation for your records.</li>
            </ul>
        </div>

        <p style="font-size: 13px; color: #64748b;">If you did not cast these votes or notice any discrepancy, please contact the election administration immediately.</p>

        <div class="footer">
            <p>&copy; {{ date('Y') }} E-Voting Portal. All rights reserved.</p>
            <p>This is an automated system confirmation.</p>
        </div>
    </div>
</body>
</html>
