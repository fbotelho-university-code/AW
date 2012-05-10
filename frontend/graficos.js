function inTop10(valor, top) {
	min_id = 0;
	min_val = 999999999;

	if (top.length < 10) {
		top.push({
			nome : valor.nome,
			val : valor.val
		});
		// alert(valor.nome + '\n' + valor.val);
	} else {
		for (var i = 0; i < top.length; i++) {
			if (top[i].val < min_val) {
				min_id = i;
				min_val = top[i].val;
			}
		}

		if (valor.val > min_val) {
			top[min_id] = {
				nome : valor.nome,
				val : valor.val
			};
		}
	}

	return (top);
}

function getNomeArray(nomeCount) {
	var nomes = Array();

	for ( var i = 0; i < nomeCount.length; i++) {
		nomes[i] = nomeCount[i].nome;
	}
	return (nomes);
}

function getValArray(nomeCount) {
	var counts = Array();

	for ( var i = 0; i < nomeCount.length; i++) {
		counts[i] = nomeCount[i].val;
	}
	return (counts);
}

function drawLocais(div) {
	var top10 = new Array();
	var noticias_local = new Array();
	var nr_noticia_local = new Nr_noticia_local();

	nr_noticia_local.get(0, 0, function(result) {
		noticias_local = result;
	});

	if (noticias_local == null)
		return;

	for ( var i = 0; i < noticias_local.length; i++) {
		top10 = inTop10({
			nome : noticias_local[i].nome_local,
			val : noticias_local[i].nr_noticia
		}, top10);
	}

	// desenhar grafico
	var options = {
		chart : {
			renderTo : div,
			defaultSeriesType : 'bar'
		}
	};

	// title
	options.title = new Object();
	options.title.text = 'Top 10 locais com mais notícias';

	// x
	options.xAxis = new Object();
	options.xAxis.title = 'Local';
	options.xAxis.categories = new Array();
	options.xAxis.categories = getNomeArray(top10);

	// y
	options.yAxis = new Object();
	options.yAxis.title = '# notícias';

	// data
	options.series = new Array();
	options.series[0] = new Object();
	options.series[0].name = '# Notícias';
	options.series[0].data = new Array();
	options.series[0].data = getValArray(top10);

	chart1 = new Highcharts.Chart(options);

}

function drawClubes(div) {
	var top10 = new Array();
	var clubes = new Array();
	var noticia_x_clube = new Noticia_x_clube();

	noticia_x_clube.get(0, 0, function(result) {
		clubes = result;
	});

	if (clubes == null)
		return;

	for ( var i = 0; i < clubes.length; i++) {
		top10 = inTop10({
			nome : clubes[i].nome_oficial,
			val : clubes[i].nr_noticia
		}, top10);
	}

	// desenhar grafico
	var options = {
		chart : {
			renderTo : div,
			defaultSeriesType : 'bar'
		}
	};

	// title
	options.title = new Object();
	options.title.text = 'Top 10 clubes com mais notícias';

	// x
	options.xAxis = new Object();
	options.xAxis.title = 'Clube';
	options.xAxis.categories = new Array();
	options.xAxis.categories = getNomeArray(top10);

	// y
	options.yAxis = new Object();
	options.yAxis.title = '# notícias';

	// data
	options.series = new Array();
	options.series[0] = new Object();
	options.series[0].name = '# Notícias';
	options.series[0].data = new Array();
	options.series[0].data = getValArray(top10);

	chart1 = new Highcharts.Chart(options);
}

function drawIntegrantes(div) {
	var top10 = new Array();
	var integrantes = new Array();
	var nr_noticia_integrante = new Nr_noticia_integrante();

	nr_noticia_integrante.get(0, 0, function(result) {
		integrantes = result;
	});

	if (integrantes == null)
		return;

	for ( var i = 0; i < integrantes.length; i++) {
		top10 = inTop10({
			nome : integrantes[i].nome_integrante,
			val : integrantes[i].nr_noticia
		}, top10);
	}

	// desenhar grafico
	var options = {
		chart : {
			renderTo : div,
			defaultSeriesType : 'bar'
		}
	};

	// title
	options.title = new Object();
	options.title.text = 'Top 10 integrantes com mais notícias';

	// x
	options.xAxis = new Object();
	options.xAxis.title = 'Integrante';
	options.xAxis.categories = new Array();
	options.xAxis.categories = getNomeArray(top10);

	// y
	options.yAxis = new Object();
	options.yAxis.title = '# notícias';

	// data
	options.series = new Array();
	options.series[0] = new Object();
	options.series[0].name = '# Notícias';
	options.series[0].data = new Array();
	options.series[0].data = getValArray(top10);

	chart1 = new Highcharts.Chart(options);
}

function drawMes(div) {
	var top10 = new Array();
	var meses = new Array();
	var nr_noticia_data = new Nr_noticia_data();

	nr_noticia_data.get(0, 0, function(result) {
		meses = result;
	});

	if (meses == null)
		return;

	for ( var i = 0; i < meses.length; i++) {
		switch(meses[i].mes){
		case 1:
			meses[i].mes = 'Janeiro';
			break;
		case 2:
			meses[i].mes = 'Fevereiro';
			break;
		case 3:
			meses[i].mes = 'Março';
			break;
		case 4:
			meses[i].mes = 'Abril';
			break;
		case 5:
			meses[i].mes = 'Maio';
			break;
		case 6:
			meses[i].mes = 'Junho';
			break;
		case 7:
			meses[i].mes = 'Julho';
			break;
		case 8:
			meses[i].mes = 'Agosto';
			break;
		case 9:
			meses[i].mes = 'Setembro';
			break;
		case 10:
			meses[i].mes = 'Outubro';
			break;
		case 11:
			meses[i].mes = 'Novembro';
			break;
		case 12:
			meses[i].mes = 'Dezembro';
			break;
		}
		
		
		top10[i] = {
			nome : meses[i].mes,
			val : meses[i].nr_noticia
		};
	}

	// desenhar grafico
	var options = {
		chart : {
			renderTo : div,
			defaultSeriesType : 'bar'
		}
	};

	// title
	options.title = new Object();
	options.title.text = 'Notícias por mês';

	// x
	options.xAxis = new Object();
	options.xAxis.title = 'Mês';
	options.xAxis.categories = new Array();
	options.xAxis.categories = getNomeArray(top10);

	// y
	options.yAxis = new Object();
	options.yAxis.title = '# notícias';

	// data
	options.series = new Array();
	options.series[0] = new Object();
	options.series[0].name = '# Notícias';
	options.series[0].data = new Array();
	options.series[0].data = getValArray(top10);

	chart1 = new Highcharts.Chart(options);
}

function drawClubesLocal(div) {

	// get top 10 locais com mais noticias
	var top10 = new Array();
	var noticias_local = new Array();
	var nr_noticia_local = new Nr_noticia_local();
	var total_noticias = 0;

	nr_noticia_local.get(0, 0, function(result) {
		noticias_local = result;
	});

	if (noticias_local == null)
		return;

	for ( var i = 0; i < noticias_local.length; i++) {
		top10 = inTop10({
			nome : noticias_local[i].nome_local,
			val : noticias_local[i].nr_noticia
		}, top10);
	}

	// nr_noticia = getValArray(top10);
	// for(i=0; i<nr_noticia.length; i++)
	// total_noticias += nr_noticia[i];

	top10 = getNomeArray(top10);

	// le wild code hammer appears
	var nr_noticia_local_clube = new Nr_noticia_local_clube();
	var results = new Array();

	nr_noticia_local_clube.get(0, 0, function(result) {
		results = result;
	});

	// hammering begins
	var colors = Highcharts.getOptions().colors;
	estrutura = new Array();
	top102 = new Array();
	for ( var cor = 0, i = 0, tmp = results[i].nome_local; i < results.length;) {
		tmp = results[i].nome_local;

		// if in top10
		for ( var bool = false, z = 0; z < 10; z++)
			if (results[i].nome_local == top10[z]) {
				bool = true;
				break;
			}

		if (bool) {
			for ( var sum = 0, categories = new Array(), data = new Array(); i < results.length
					&& tmp == results[i].nome_local; i++) {
				categories.push(results[i].nome_oficial);
				data.push(results[i].nr_noticia);
				sum += results[i].nr_noticia;
			}

			estrutura.push({
				y : sum,
				color : colors[cor],
				drilldown : {
					name : tmp,
					categories : categories.slice(),
					data : data.slice(),
					color : colors[cor]
				}
			});

			total_noticias += sum;
			top102.push(tmp);
			// console.log('Local: '+tmp+'\nTotal: '+sum+'\nVal:
			// '+data.toString());
			cor++;
		} else
			i++;
	}

	// console.log(estrutura);

	categories = new Array();
	categories = top102.slice();
	data = new Array();
	data = estrutura.slice();

	// Build the data arrays
	var browserData = [];
	var versionsData = [];
	for (i = 0; i < data.length; i++) {

		// add browser data
		browserData.push({
			name : categories[i],
			y : data[i].y,
			color : data[i].color
		});

		// add version data
		for (var j = 0; j < data[i].drilldown.data.length; j++) {
			var brightness = 0.2 - (j / data[i].drilldown.data.length) / 5;
			versionsData.push({
				name : data[i].drilldown.categories[j],
				y : data[i].drilldown.data[j],
				color : Highcharts.Color(data[i].color).brighten(brightness)
						.get()
			});
		}
	}

	// Create the chart
	var chart = new Highcharts.Chart({
		chart : {
			renderTo : div,
			type : 'pie'
		},
		title : {
			text : 'Número de noticias de cada clube por local (Top 10)'
		},
		subtitle : {
			// align : "left",
			text : total_noticias + ' Notícias',
		// verticalAlign : "middle"
		},
		yAxis : {
			title : {
				text : '# notícias'
			}
		},
		plotOptions : {
			pie : {
				shadow : false
			}
		},
		tooltip : {
			formatter : function() {
				return '<b>' + this.point.name + '</b>: ' + this.y
						+ ' notícias';
			}
		},
		series : [
				{
					name : 'Locais',
					data : browserData,
					size : '60%',
					dataLabels : {
						formatter : function() {
							// return this.y > 5 ? this.point.name : null;
							return this.point.name;
						},
						color : 'white',
						distance : -30
					}
				},
				{
					name : 'Clubes',
					data : versionsData,
					innerSize : '60%',
					dataLabels : {
						formatter : function() {
							// display only if larger than 1
							// return this.y > 1 ? '<b>' + this.point.name +
							// ':</b> ' + this.percentage.toFixed(2) + '%' :
							// null;
							return '<b>' + this.point.name + ':</b> '
									+ this.percentage.toFixed(2) + '%';
						}
					}
				} ]
	});

}

function drawClubesMes(div) {

	var meses = new Array();
	var noticias_mes = new Array();
	var noticia_data_clube = new Noticia_data_clube();
	var total_noticias = 0;

	noticia_data_clube.get(0, 0, function(result) {
		noticias_mes = result;
	});

	if (noticias_mes == null)
		return;

	// hammering begins
	var colors = Highcharts.getOptions().colors;
	estrutura = new Array();
	for ( var cor = 0, i = 0, tmp = noticias_mes[i].mes; i < noticias_mes.length;) {
		tmp = noticias_mes[i].mes;

		for ( var sum = 0, categories = new Array(), data = new Array(); i < noticias_mes.length
				&& tmp == noticias_mes[i].mes; i++) {
			categories.push(noticias_mes[i].nome_oficial);
			data.push(noticias_mes[i].nr_noticia);
			sum += noticias_mes[i].nr_noticia;
		}

		estrutura.push({
			y : sum,
			color : colors[cor],
			drilldown : {
				name : tmp,
				categories : categories.slice(),
				data : data.slice(),
				color : colors[cor]
			}
		});

		total_noticias += sum;
		meses.push(tmp);
		// console.log('Local: '+tmp+'\nTotal: '+sum+'\nVal:
		// '+data.toString()+'\ni: '+i);
		cor++;
	}
	
	for(i=0; i<meses.length; i++){
		switch(meses[i]){
		case 1:
			meses[i] = 'Janeiro';
			break;
		case 2:
			meses[i] = 'Fevereiro';
			break;
		case 3:
			meses[i] = 'Março';
			break;
		case 4:
			meses[i] = 'Abril';
			break;
		case 5:
			meses[i] = 'Maio';
			break;
		case 6:
			meses[i] = 'Junho';
			break;
		case 7:
			meses[i] = 'Julho';
			break;
		case 8:
			meses[i] = 'Agosto';
			break;
		case 9:
			meses[i] = 'Setembro';
			break;
		case 10:
			meses[i] = 'Outubro';
			break;
		case 11:
			meses[i] = 'Novembro';
			break;
		case 12:
			meses[i] = 'Dezembro';
			break;
		}
	}

	// console.log(estrutura);

	categories = new Array();
	categories = meses.slice();
	data = new Array();
	data = estrutura.slice();

	// Build the data arrays
	var browserData = [];
	var versionsData = [];
	for (i = 0; i < data.length; i++) {

		// add browser data
		browserData.push({
			name : categories[i],
			y : data[i].y,
			color : data[i].color
		});

		// add version data
		for (var j = 0; j < data[i].drilldown.data.length; j++) {
			var brightness = 0.2 - (j / data[i].drilldown.data.length) / 5;
			versionsData.push({
				name : data[i].drilldown.categories[j],
				y : data[i].drilldown.data[j],
				color : Highcharts.Color(data[i].color).brighten(brightness)
						.get()
			});
		}
	}

	// Create the chart
	var chart = new Highcharts.Chart({
		chart : {
			renderTo : div,
			type : 'pie'
		},
		title : {
			text : 'Número de noticias de cada clube por mês'
		},
		subtitle : {
			// align : "left",
			text : total_noticias + ' Notícias',
		// verticalAlign : "middle"
		},
		yAxis : {
			title : {
				text : '# notícias'
			}
		},
		plotOptions : {
			pie : {
				shadow : false
			}
		},
		tooltip : {
			formatter : function() {
				return '<b>' + this.point.name + '</b>: ' + this.y
						+ ' notícias';
			}
		},
		series : [
				{
					name : 'Locais',
					data : browserData,
					size : '60%',
					dataLabels : {
						formatter : function() {
							// return this.y > 5 ? this.point.name : null;
							return this.point.name;
						},
						color : 'white',
						distance : -30
					}
				},
				{
					name : 'Clubes',
					data : versionsData,
					innerSize : '60%',
					dataLabels : {
						formatter : function() {
							// display only if larger than 1
							// return this.y > 1 ? '<b>' + this.point.name +
							// ':</b> ' + this.percentage.toFixed(2) + '%' :
							// null;
							return '<b>' + this.point.name + ':</b> '
									+ this.percentage.toFixed(2) + '%';
						}
					}
				} ]
	});

}