<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sensor Data Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Back Button Style */
        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .back-button:hover {
            background-color: #45a049;
        }

        .chart-container {
            display: inline-block;
            margin: 20px;
            padding: 10px;
            border: 2px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
            width: 400px; /* Increased width */
            height: 300px; /* Increased height */
        }

        canvas {
            display: block;
            margin: 0 auto;
            width: 100%; /* Full width of container */
            height: 100%; /* Full height of container */
        }

        .container {
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<!-- Back Button -->
<button class="back-button" onclick="window.history.back()">Back</button>

<div class="container">
    <h2>Real-Time Graphical Sensor Data</h2>

    <!-- Chart containers for each sensor -->
    <div class="chart-container">
        <canvas id="tdsChart"></canvas>
    </div>
    <div class="chart-container">
        <canvas id="temperatureChart"></canvas>
    </div>
    <div class="chart-container">
        <canvas id="humidityChart"></canvas>
    </div>
</div>

<script>
// Initialize empty datasets
const tdsData = [];
const temperatureData = [];
const humidityData = [];
const timestamps = [];

// Create Chart.js chart configurations
const tdsChart = new Chart(document.getElementById("tdsChart").getContext("2d"), {
    type: 'line',
    data: {
        labels: timestamps,
        datasets: [{
            label: 'TDS Level (ppm)',
            data: tdsData,
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 2,
            fill: false
        }]
    }
});

const temperatureChart = new Chart(document.getElementById("temperatureChart").getContext("2d"), {
    type: 'line',
    data: {
        labels: timestamps,
        datasets: [{
            label: 'Temperature (°C)',
            data: temperatureData,
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 2,
            fill: false
        }]
    }
});

const humidityChart = new Chart(document.getElementById("humidityChart").getContext("2d"), {
    type: 'line',
    data: {
        labels: timestamps,
        datasets: [{
            label: 'Humidity (%)',
            data: humidityData,
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 2,
            fill: false
        }]
    }
});

// Fetch data every 5 seconds
setInterval(fetchData, 5000);

function fetchData() {
    fetch('fetch_data.php?timestamp=' + new Date().getTime()) // Prevent caching with timestamp
        .then(response => response.json())
        .then(data => {
            console.log("Fetched data:", data); // Debugging log

            // Clear existing data
            tdsData.length = 0;
            temperatureData.length = 0;
            humidityData.length = 0;
            timestamps.length = 0;

            // Populate data arrays
            data.reverse().forEach(item => {
                timestamps.push(item.timestamp);
                tdsData.push(item.tds);
                temperatureData.push(item.temperature);
                humidityData.push(item.humidity);
            });

            // Update each chart
            tdsChart.update();
            temperatureChart.update();
            humidityChart.update();
        })
        .catch(error => console.error('Error fetching data:', error));
}
</script>

</body>
</html>
