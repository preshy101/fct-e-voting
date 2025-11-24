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
            background: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f9fafb;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .vote-card {
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 15px;
            margin: 15px 0;
        }
        .vote-card h3 {
            margin: 0 0 10px 0;
            color: #1f2937;
        }
        .vote-card p {
            margin: 5px 0;
            color: #6b7280;
        }
        .success-icon {
            font-size: 48px;
            margin-bottom: 10px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
        .info-box {
            background: #dbeafe;
            border-left: 4px solid #2563eb;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .warning-box {
            background: #fef3c7;
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
        <h1 style="margin: 0;">Vote Successfully Cast!</h1>
        <p style="margin: 10px 0 0 0;">E-Vote Portal</p>
    </div>

    <div class="content">
        <p>Dear {{ $member->first_name }} {{ $member->last_name }},</p>

        <p>Thank you for participating in the democratic process. This email confirms that your votes have been successfully recorded.</p>

        <div class="info-box">
            <strong>Confirmation Details</strong><br>
            <p style="margin: 10px 0 0 0;">
                <strong>Voter ID:</strong> {{ $member->practice_ID }}<br>
                <strong>Submission Time:</strong> {{ now()->format('F d, Y h:i A') }}<br>
                <strong>Elections Voted:</strong> {{ count($votes) }}
            </p>
        </div>

        <h2>Your Votes:</h2>

        @foreach($votes as $vote)
        <div class="vote-card">
            <h3>{{ $vote['election_title'] }}</h3>
            <p><strong>Candidate:</strong> {{ $vote['candidate_name'] }}</p>
            <p><strong>Vote Reference:</strong> {{ $vote['vote_token'] }}</p>
        </div>
        @endforeach

        <div class="warning-box">
            <strong>Important Information:</strong>
            <ul style="margin: 10px 0 0 0; padding-left: 20px;">
                <li>Your vote is confidential and secure</li>
                <li>You cannot change your vote once submitted</li>
                <li>Keep this email for your records</li>
                <li>Your vote will be counted in the final results</li>
            </ul>
        </div>

        <p>If you did not cast these votes or have any concerns, please contact the election administrator immediately.</p>

        <div class="footer">
            <p>&copy; {{ date('Y') }} E-Vote Portal. All rights reserved.</p>
            <p>This is an automated message. Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>
