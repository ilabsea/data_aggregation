$(function () {
	
    $('#container').highcharts({
	
	    chart: {
	        type: 'gauge',
	        plotBackgroundColor: null,
	        plotBackgroundImage: null,
	        plotBorderWidth: 0,
	        plotShadow: false
	    },
	    
	    title: {
	        text: 'Speedometer'
	    },
	    
	    pane: {
	        startAngle: -90,
	        endAngle: 90,
            background: null
	    },
        
        plotOptions: {
            gauge: {
                dataLabels: {
                    enabled: false
            	},
	            dial: {
	                baseLength: '0%',
	                baseWidth: 10,
	                radius: '100%',
	                rearLength: '0%',
	                topWidth: 1
	            }
            }
        },
	       
	    // the value axis
	    yAxis: {
            labels: {
                enabled: false
            },
            minorTickLength: 0,
	        min: 0,
	        max: 100,
            tickLength: 0,
	        plotBands: [{
	            from: 0,
	            to: 25,
	            color: 'rgb(192, 0, 0)', // red
                thickness: '50%'
	        }, {
	            from: 25,
	            to: 75,
	            color: 'rgb(255, 192, 0)', // yellow
                thickness: '50%'
	        }, {
	            from: 75,
	            to: 100,
	            color: 'rgb(155, 187, 89)', // green
                thickness: '50%'
	        }]        
	    },
	
	    series: [{
	        name: 'Speed',
	        data: [80]
	    }]
	
	}, 
	// Add some life
	function (chart) {
		if (!chart.renderer.forExport) {
		    setInterval(function () {
		        var point = chart.series[0].points[0],
		            newVal,
		            inc = Math.round((Math.random() - 0.5) * 20);
		        
		        newVal = point.y + inc;
		        if (newVal < 0 || newVal > 100) {
		            newVal = point.y - inc;
		        }
		        
		        point.update(newVal);
		        
		    }, 3000);
		}
	});
});

$(function () {
	
    $('#container2').highcharts({
    chart: {
        type: 'areaspline'
    },
    title: {
        text: 'Average fruit consumption during one week'
    },
    legend: {
        layout: 'vertical',
        align: 'left',
        verticalAlign: 'top',
        x: 150,
        y: 100,
        floating: true,
        borderWidth: 1,
        backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
    },
    xAxis: {
        categories: [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
            'Sunday'
        ]
    },
    yAxis: {
        title: {
            text: 'Fruit units'
        },
        plotBands: [{ // visualize the weekend
            from: 4.5,
            to: 6.5,
            color: 'rgba(68, 170, 213, .2)'
        }]
    },
    tooltip: {
        shared: true,
        valueSuffix: ' units'
    },
    credits: {
        enabled: false
    },
    plotOptions: {
        areaspline: {
            fillOpacity: 0
        }
    },
    series: [{
        name: 'John',
        data: [3, 4, 3, 5, 4, 10, 12]
    }, {
        name: 'Jane',
        data: [1, 3, 4, 3, 3, 5, 4]
    }]
})
});

$(function () {
	
    $('#container3').highcharts({
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Stacked bar chart'
    },
    xAxis: {
        categories: ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas']
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total fruit consumption'
        }
    },
    legend: {
        reversed: true
    },
    plotOptions: {
        series: {
            stacking: 'normal'
        }
    },
    series: [{
        name: 'John',
        data: [5, 3, 4, 7, 2]
    }, {
        name: 'Jane',
        data: [2, 2, 3, 2, 1]
    }]
})
});