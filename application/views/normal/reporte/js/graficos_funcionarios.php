<script>
    Chart.register(ChartDataLabels);

    Chart.defaults.set('plugins.datalabels', {
        color: '#000000',
        font: {
            weight: 'bold',
            size: '24px'
        },
    });



new Chart(document.getElementById("pie-chart-funcionario"), {
    type: 'pie',
    data: {
        labels: <?php print_r($funcionarios_array)?>,
        datasets: [{
            label: "Funcionarios",
              backgroundColor: ["#4AC1E0", "#6D56A0", "#EA547C", "#4FB9A8", "#F9B154", "#009877", "#00ACD8", "#482778", "#AE1857", "#F18721"],
            data: <?php print_r($cont_f) ?>,
        }]
    },
    options: {
        title: {
            display: true,
            text: 'Frecuencia por Funcionario',
            showAllTooltips: true
        },
    }
});

/*new Chart(document.getElementById("bar-chart"), {
  type: 'bar',
  data: {
      labels: <?php //print_r($tendencias) ?>,

      datasets: [{
          label: "Tipo de Tendencias",
          backgroundColor: ["#ea547c","#4AC1E0","#4fb9a8"],
          data: <?php //print_r($notas_t) ?>
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
