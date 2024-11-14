<!-- resources/views/components/head.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ $pageName }}</title>
	<link rel="icon" href="https://imagens.liveoficial.com.br/favicons/favicon-32x32.png">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMU8OhKz4p3aZ1i0o/hMII1WgCLkGEZ5kg5c+1o" crossorigin="anonymous">
	<!-- Bootstrap CSS (latest stable version) -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- jQuery (for dropdown and datepicker functionality) -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<!-- Bootstrap JS Bundle with Popper (for dropdowns and other Bootstrap components) -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
	
	<!-- ECharts for data visualization -->
	<script src="https://cdn.jsdelivr.net/npm/echarts@5.5.0/dist/echarts.min.js"></script>

	<!-- Bootstrap Datepicker CSS and JS -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.pt-BR.min.js"></script>

	<!-- Custom CSS and JavaScript -->
	<link href="{{ asset('styles.css') }}" rel="stylesheet">
	<script src="{{ asset('script.js') }}" type="module" defer></script>
	<script src="{{ asset('echartOptions.js') }}" type="module" defer></script>
</head>
