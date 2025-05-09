<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            padding: 20px;
        }
        .invoice-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .invoice-header {
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .invoice-status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 0.8em;
            font-weight: bold;
            background-color: #f8f9fa;
        }
        .status-waiting {
            background-color: #fff3cd;
            color: #856404;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Invoice List</h1>
    
    <?php if (empty($invoices)): ?>
        <p>No invoices found.</p>
    <?php else: ?>
        <?php foreach ($invoices as $invoice): ?>
            <div class="invoice-card">
                <div class="invoice-header">
                    <h2>Invoice #<?php echo htmlspecialchars($invoice->invoiceNumber); ?></h2>
                    <div class="invoice-status status-<?php echo strtolower($invoice->status); ?>">
                        <?php echo $invoice->status; ?>
                    </div>
                </div>
                
                <div class="invoice-body">
                    <p><strong>ID:</strong> <?php echo $invoice->id; ?></p>
                    <p><strong>Order Date:</strong> <?php echo date('F j, Y', strtotime($invoice->orderDate)); ?></p>
                    <p><strong>Uploaded At:</strong> <?php echo date('F j, Y g:i A', strtotime($invoice->uploadedAt)); ?></p>
                    <p><strong>Uploaded By:</strong> <?php echo $invoice->uploadedBy->username ?? 'N/A'; ?></p>
                    
                    <h3>Invoice Details</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Profession</th>
                                <th>Salary</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($invoice->invoiceDetails as $detail): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($detail->profession); ?></td>
                                    <td><?php echo htmlspecialchars($detail->salary); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>