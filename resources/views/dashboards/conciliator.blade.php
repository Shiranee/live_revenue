<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conciliator Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.5.0/dist/echarts.min.js"></script>
    <script src="script.js" type="module" defer></script>
    <link href="styles.css" rel="stylesheet">
</head>
<body>
    <header class="header"></header>
    <div class='container'>
        <div id='gauges-container'>
            <div id="invoice-meter"></div>
            <div id="invoice-gauge"></div>
        </div>
        <div class='graph-container' id="divergences-chart" style="width: 60%; height: 100%;margin-left: 10px;"></div>
    </div>
    <div class='graph-container' id="invoices-bar" ></div>
    <div class='graph-container' id="divergences-bar"></div>
</body>
</html>
