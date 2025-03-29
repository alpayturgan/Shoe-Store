<?php
session_start();
include_once 'includes/config.php';
$oid = intval($_GET['oid']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Order Tracking Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        #container {
            margin-left: 50px;
        }

        .header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        .status-delivered {
            color: green;
        }

        .status-pending {
            color: orange;
        }

        .status-shipped {
            color: blue;
        }

        hr {
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div id="container">
        <div class="header">
            <h2>Order Tracking Details</h2>
        </div>
        
        <table>
            <tr>
                <td><b>Order Id:</b></td>
                <td><?php echo $oid; ?></td>
            </tr>
            <?php
            $ret = mysqli_query($con, "SELECT * FROM ordertrackhistory WHERE orderId='$oid'");
            $num = mysqli_num_rows($ret);
            if ($num > 0) {
                while ($row = mysqli_fetch_array($ret)) {
                    ?>
                    <tr>
                        <td><b>At Date:</b></td>
                        <td><?php echo $row['postingDate']; ?></td>
                    </tr>
                    <tr>
                        <td><b>Status:</b></td>
                        <td class="status-<?php echo strtolower($row['status']); ?>"><?php echo $row['status']; ?></td>
                    </tr>
                    <tr>
                        <td><b>Remark:</b></td>
                        <td><?php echo $row['remark']; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2"><hr /></td>
                    </tr>
                <?php }
            } else {
                ?>
                <tr>
                    <td colspan="2">Order Not Processed Yet</td>
                </tr>
            <?php }
            $st = 'Delivered';
            $rt = mysqli_query($con, "SELECT * FROM orders WHERE id='$oid'");
            while ($num = mysqli_fetch_array($rt)) {
                $currentSt = $num['orderStatus'];
            }
            if ($st == $currentSt) { ?>
                <tr>
                    <td colspan="2"><b>Product Delivered successfully</b></td>
                </tr>
            <?php }
            ?>
        </table>
    </div>
</body>
</html>
