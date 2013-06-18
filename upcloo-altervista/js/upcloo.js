google.load("visualization", "1", {
	packages : [ "corechart" ]
});
google.setOnLoadCallback(drawChart);
function drawChart() {
	var data = google.visualization.arrayToDataTable([ 
        [ 'Day', 'Impressions' ],
		[ '-30', 1000 ], 
		[ '-29', 1170 ],
		[ '-28', 660 ], 
		[ '-27', 1030 ],
		[ '-26', 900 ], 
		[ '-25', 870 ],
		[ '-24', 1200 ], 
		[ '-23', 780 ],
		[ '-22', 1200 ], 
		[ '-21', 1902 ],
		[ '-20', 1700 ], 
		[ '-19', 1250 ],
		[ '-18', 900 ], 
		[ '-17', 800 ],
		[ '-16', 1200 ], 
		[ '-15', 800 ],
		[ '-14', 910 ], 
		[ '-13', 710 ],
		[ '-12', 120 ], 
		[ '-11', 300 ],
		[ '-10', 1000 ], 
		[ '-9', 1170 ],
		[ '-8', 660 ], 
		[ '-7', 1030 ],
		[ '-6', 1000 ], 
		[ '-5', 1170 ],
		[ '-4', 660 ], 
		[ '-3', 930 ],
		[ '-2', 1350 ], 
		[ '-1', 1170 ],
    ]);

	var options = {
		title : 'UpCloo Impressions',
		colors: ['#3399FF']
	};

	var chart = new google.visualization.LineChart(document
			.getElementById('chart_div_impressions'));
	chart.draw(data, options);
	
	var data_clicks = google.visualization.arrayToDataTable([ 
        [ 'Day', 'Clicks' ],
        [ '-30', 100 ], 
		[ '-29', 110 ],
		[ '-28', 66 ], 
		[ '-27', 130 ],
		[ '-26', 90 ], 
		[ '-25', 80 ],
		[ '-24', 100 ], 
		[ '-23', 70 ],
		[ '-22', 100 ], 
		[ '-21', 102 ],
		[ '-20', 100 ], 
		[ '-19', 150 ],
		[ '-18', 90 ], 
		[ '-17', 80 ],
		[ '-16', 100 ], 
		[ '-15', 80 ],
		[ '-14', 90 ], 
		[ '-13', 70 ],
		[ '-12', 10 ], 
		[ '-11', 30 ],
		[ '-10', 100 ], 
		[ '-9', 110 ],
		[ '-8', 66 ], 
		[ '-7', 100 ],
		[ '-6', 100 ], 
		[ '-5', 110 ],
		[ '-4', 66 ], 
		[ '-3', 93 ],
		[ '-2', 130 ], 
		[ '-1', 110 ],
    ]);

  	var options = {
  		title : 'UpCloo Clicks',
  		colors: ['green']
  	};
	
	var chart = new google.visualization.LineChart(document
			.getElementById('chart_div_clicks'));
	chart.draw(data_clicks, options);
}
