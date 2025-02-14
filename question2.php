<?php
// Read the CSV file
$data = [];
if (($handle = fopen("question2.csv", "r")) !== FALSE) {
    // Skip the header
    $header = fgetcsv($handle);
    
    // Read data into an array
    while (($row = fgetcsv($handle)) !== FALSE) {
        $data[] = [
            'x' => $row[0],
            'y' => $row[1]
        ];
    }
    fclose($handle);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scatter Plot</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="scatterPlot" width="400" height="400"></canvas>

    <script>
        // Get data from PHP
        var data = <?php echo json_encode($data); ?>;

        // Extract x and y values
        var xValues = data.map(function(item) { return item.x; });
        var yValues = data.map(function(item) { return item.y; });

        // Create the scatter plot
        var ctx = document.getElementById('scatterPlot').getContext('2d');
        var scatterPlot = new Chart(ctx, {
            type: 'scatter',
            data: {
                datasets: [{
                    label: 'Scatter Plot',
                    data: xValues.map(function(x, index) {
                        return {x: x, y: yValues[index]};
                    }),
                    backgroundColor: 'rgba(75, 192, 192, 1)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        type: 'linear',
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
</body>
</html>