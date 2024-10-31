<!-- resources/views/components/head.blade.php -->
 <!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title> {{ $pageName }} </title>
  <link rel="icon" href="https://imagens.liveoficial.com.br/favicons/favicon-32x32.png">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2/dist/umd/popper.min.js"></script>
	<link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/echarts@5.5.0/dist/echarts.min.js"></script>
    <link href="{{ asset('styles.css') }}" rel="stylesheet">
    
    <!-- Correct way to load custom scripts using asset() -->
    <script src="{{ asset('script.js') }}" type="module" defer></script>
    <script src="{{ asset('echartOptions.js') }}" type="module" defer></script>
</head>