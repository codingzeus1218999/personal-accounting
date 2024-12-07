<!DOCTYPE html>
<html>
<head>
    <title>Transaction Notification</title>
</head>
<body>
    <h1>Transaction Created</h1>
    <p>A new transaction has been added:</p>
    <ul>
        <li>Title: {{ $transaction->title }}</li>
        <li>Amount: {{ $transaction->amount }}</li>
        <li>Date: {{ $transaction->created_at }}</li>
    </ul>
</body>
</html>
