#PHP graphs

A PHP library to cast a collection of data into a graph object which your favourite js graph library can convert into a beautiful graph for your application.

##Requirements

* PHP 5.5.9 or greater

##Supported javascript libraries

Current JS implementations:
* Chart.js (http://www.chartjs.org/)
* morris.js (http://morrisjs.github.io/morris.js/)

##Implementation

###App

```

use koenster\PHPGraphs\contract\ChartContract;
use koenster\PHPGraphs\PHPChart;

$chart = new PHPChart(PHPChart::IMPLEMENTATION_CHART_JS);

$graph = $chart->add(PHPChart::TYPE_LINE, 'results', ['width' => 400, 'height' => 400]);
$graph->setLine([100,75,50,75,50,75,100], ['label' => 'Costs'])
    ->setLine([90,65,40,65,40,65,150], ['label' => 'Revenue'])
    ->setDimensions(['2006', '2007', '2008', '2009', '2010', '2011', '2012']);

```

###View

```

<!doctype html>
<html>
<head>
    <!-- This is optional -->
    <?php foreach ($chart->getFactory()->getCss() as $css) : ?>
    <link rel="stylesheet" href="{{ $css }}">
    <?php endforeach; ?>

    <!-- This is optional -->
    <?php foreach ($chart->getFactory()->getJs() as $js) : ?>
    <script src="<?php echo $js; ?>"></script>
    <?php endforeach; ?>
</head>
<body>

<!-- This will generate the HTML code -->
<?php echo $graph->generate(); ?>

<script>
    // This will gather all charts and activate the JS library to convert the provided JSON to a Graph
    <?php echo $chart->getFactory()->getJsPartial(); ?>
</script>

```

For the full implementation (line, area, pie's etc.), see the examples directory.

##Contributing
Feel free to edit and/or improve the code to make a better PHP Graph library.

##Todo's (in random order)

* More detailed wiki/documentation
* More implementations
* More configuration per implementation (add more config variables)
* Better validation

##Future implementations

* Chrtits.js -> https://gionkunz.github.io/chartist-js/
* jQuery flot -> http://www.flotcharts.org/

##License

This PHP Graph library is open-sourced software licensed under the MIT license.