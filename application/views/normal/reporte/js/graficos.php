<script>
    Chart.register(ChartDataLabels);

    Chart.defaults.set('plugins.datalabels', {
        color: '#000000',
        font: {
            weight: 'bold',
            size: '12px'
        },
    });

    new Chart(document.getElementById("pie-chart-tematica"), {
        type: 'pie',
        data: {
          labels: <?php print_r($tematicas)?>,
          datasets: [{
            label: "Temas",
            backgroundColor: ["#4AC1E0", "#6D56A0", "#EA547C", "#4FB9A8", "#F9B154", "#009877", "#00ACD8", "#482778", "#784212", "#F18721", "#1E90FF","#2E8B57", "#ADFF2F", "#DC143C", "#BA55D3","#0000FF" ,"#FF00FF","#808000","#C0C0C0","#800000", "#00FFFF", "#A58FE3","#D68910","#F9E79F", "#00BCD4", "#27AE60" ,"#B2BABB","#34495E", "#AE1857", "#0097A7","#1A237E","#795548", "#283593","#AB47BC", "#A93226","#DE8D25", "#E2EC1F", "#86B918","#23B98E","#3FB7B0", "#3E5A7C", "#A353AF", "#D932BD", "#D93274","#ED3636", "#943126", "#8AEF40","#B3A844", "#E06C11","#DE7171", "#AF7474","#EF4040"],
            borderColor: "black",
            borderWidth: 1,
              //text-align: left,
            data: <?php print_r($not) ?>,
          }]
        },
        options: {
            title: {
                display: true,
                text: 'Frecuencia por Temática ',
                showAllTooltips: true
            },
            plugins: {
		            legend: {
		                display: true,
		                labels: {
		                    color: 'rgb(0, 0, 0)',
                        font: {
                          size: 10
                        }
		                },
		                position:'top',
                    align: 'start',

		            }
		        }
        }

    });

    new Chart(document.getElementById("bar-chart"), {
      type: 'bar',
      data: {
          labels: <?php print_r($tendencias) ?>,
          datasets: [{
              label: "Tipo de Tendencias",
              backgroundColor: ["#ea547c","#4AC1E0","#4fb9a8"],
              data: <?php print_r($notas_t) ?>
          }]
      },
      options: {
          legend: {
              display: false
          },
          title: {
              display: true,
              text: 'Casos Distribuidos por Tipos'
          }
      }
  });

  /*var dts = <?php //print_r($datasets); ?>

    new Chart(document.getElementById("bar-chart-grouped"), {
        type: 'bar',
        data: {
            labels: <?php //print_r($registroxfuncionario) ?>,
            datasets: dts
        },
        options: {
            title: {
                display: true,
                text: 'Population growth (millions)'
            }
        }
    });*/

</script>
