<!DOCTYPE html>
<html>
<head>
	<title>Balance Calculator</title>
</head>
<body>
	<h1>Balance Calculator</h1>

	<label for="amount">Enter Amount:</label>
	<input type="number" id="amount" name="amount"><br>

	<label for="payment">Payment:</label>
	<input type="number" id="payment" name="payment" value="50"><br>

	<button onclick="calculateBalance()">Calculate</button>

	<p id="result"></p>

	<script>
		function calculateBalance() {
			const amount = parseInt(document.getElementById("amount").value);
			const payment = parseInt(document.getElementById("payment").value);
			const balance = amount - payment;
			document.getElementById("result").innerHTML = `Balance: ${balance}`;
		}
	</script>
</body>
</html>
