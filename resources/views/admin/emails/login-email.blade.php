<!DOCTYPE html>
<html>
<head>
    <title>Otp Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .header {
            background: #007bff;
            color: white;
            padding: 10px;
            border-radius: 10px 10px 0 0;
            font-size: 20px;
        }
        .content {
            padding: 20px;
            color: #333;
        }
        .highlight {
            font-weight: bold;
            color: #007bff;
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #28a745;
            color: white;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
        }
        .btn:hover {
            background: #218838;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Otp Verification Code for Login</div>
        <div class="content">
            <p>Hello <span class="highlight">{{ $data['name'] }}</span>,</p>
            <p>Your otp is : <span style="color: rgb(228, 9, 144);">{{ $data['otp'] }}</span></p>
            <!-- <a href="mailto:support@example.com" class="btn">Contact Support</a> -->
        </div>
        <div class="footer">Thank you for using our services!</div>
    </div>
</body>
</html>
