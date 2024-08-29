<!-- resources/views/auth/token.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saving Token</title>
</head>
<body>
<form id="tokenForm" style="display:none;">
    <input type="hidden" id="bearerToken" value="{{ $bearerToken }}">
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var token = document.getElementById('bearerToken').value;
        localStorage.setItem('bearerToken', token);

        // Redirect to the desired route after saving the token
        window.location.href = '{{ route("customer.dashboard") }}';
    });
</script>
</body>
</html>
