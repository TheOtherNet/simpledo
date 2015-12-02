<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Estadisticas de acceso</title>
    <meta name="viewport" content="width=device-width">
    {{ Asset::container('bootstrapper')->styles(); }}
    {{ Asset::container('bootstrapper')->scripts(); }}
    <script src="/js/html5-canvas-bar-graph.js"></script>
</head>
<body>
<?php if ($titulo === true){?>
    <header style="text-align:center; margin-bottom:50px;">
        <h1> <a href="/"> {{ $site->name  }} </a></h1>
    </header>
<?php
        }
$classes = array ( 0, 1, 2);
foreach ($classes as $elem) {
?>
    <div class="container">
        <h2 style="text-transform:uppercase"><?php echo Estado::find($elem)->nombre; ?> </h2>
        <div class="span5">
            <h3> Estadisticas por dia </h3>
            <canvas id="days_<?php echo $elem;?>"></canvas>
        </div>
        <div class="span5">
            <h3> Estadisticas por hora </h3>
            <canvas id="hours_<?php echo $elem?>"></canvas>
        </div>
    </div>
<?php
$hours = array(
    "00" => 0,  "01" => 0,  "02" => 0,  "03" => 0,  "04" => 0,  "05" => 0,
    "06" => 0,  "07" => 0,  "08" => 0,  "09" => 0,  "10" => 0,  "11" => 0,
    "12" => 0,  "13" => 0,  "14" => 0,  "15" => 0,  "16" => 0,  "17" => 0,
    "18" => 0,  "19" => 0,  "20" => 0,  "21" => 0,  "22" => 0,  "23" => 0,
    "24" => 0
);
$days = array(
    '0' => 0, '1' => 0,
    '2' => 0, '3' => 0,
    '4' => 0, '5' => 0,
    '6' => 0
);

foreach ($accesses as $access) {
    if ($access->status == $elem) {
        $key = explode(':', explode(' ', $access->date)[1])[0];
        $hours[$key] +=1;
        $date = date('w', strtotime($access->date));
        $days[$date] += 1;
    }
}

?>
    <script>
        var ctx = document.getElementById("days_<?php echo $elem?>").getContext("2d");
        var graph = new BarGraph(ctx);
        graph.margin = 2;
        graph.colors = ["#fff"];
        graph.width = 450;
        graph.height = 150;
        graph.xAxisLabelArr = ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"];
        graph.update([<?php echo implode(',', $days); ?>]);

        var ctx = document.getElementById("hours_<?php echo $elem?>").getContext("2d");
        var graph = new BarGraph(ctx);
        graph.margin = 2;
        graph.colors = ["#fff"];
        graph.width = 450;
        graph.height = 150;
        graph.xAxisLabelArr = [<?php echo implode(',', array_keys($hours)); ?>];
        graph.update([<?php echo implode(',', $hours); ?>]);
    </script>
    <?php } ?>
</body>
</html>
