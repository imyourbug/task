<!DOCTYPE html>
<html>
<head>
<title>Convenience Store Order</title>
<style>
  body {
    font-family: sans-serif;
  }
  h1 {
    text-align: center;
  }
  table {
    width: 100%;
    border-collapse: collapse;
  }
  th, td {
    padding: 8px;
    text-align: left;
    border: 1px solid black;
  }
  .order-details {
    margin-bottom: 20px;
  }
  .barcode-image {
    display: block;
    margin: 0 auto;
  }
  .qr-image {
    position: fixed;
    bottom: 20px;
    left: 20px;
  }
  table th, td{
  	border: none;
  }
</style>
</head>
<body>

<h1>Convenience Store Order</h1>

<div class="order-details">
  <p><strong>Order Number:</strong> 12345</p>
  <p><strong>Order Date:</strong> 2024-01-06</p>
  <p><strong>Customer Name:</strong> John Doe</p>
</div>

<table>
  <thead>
    <tr>
      <th>Item</th>
      <th>Quantity</th>
      <th>Price</th>
      <th>Subtotal</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Coffee</td>
      <td>2</td>
      <td>$2.50</td>
      <td>$5.00</td>
    </tr>
    <tr>
      <td>Sandwich</td>
      <td>1</td>
      <td>$5.99</td>
      <td>$5.99</td>
    </tr>
    <tr>
      <td>Chips</td>
      <td>1</td>
      <td>$1.25</td>
      <td>$1.25</td>
    </tr>
  </tbody>
  <tfoot>
    <tr>
      <th colspan="3">Total</th>
      <td>$12.24</td>
    </tr>
  </tfoot>
</table>

<p><strong>Thank you for your order!</strong></p>
<img src="barcode.png" alt="Barcode" class="barcode-image">
<img src="qrcode.png" alt="QR Code" class="qr-image">
</body>
</html>
