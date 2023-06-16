// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// Area Chart Example
var ctx = document.getElementById("myAreaChart");
var myAreaChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: ["Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"], // Ay isimlerini buraya ekleyin
    datasets: [{
      label: "Randevu Sayısı", // Grafikte görünen veri setinin adını belirleyin
      lineTension: 0.3,
      backgroundColor: "rgba(2,117,216,0.2)",
      borderColor: "rgba(2,117,216,1)",
      pointRadius: 5,
      pointBackgroundColor: "rgba(2,117,216,1)",
      pointBorderColor: "rgba(255,255,255,0.8)",
      pointHoverRadius: 5,
      pointHoverBackgroundColor: "rgba(2,117,216,1)",
      pointHitRadius: 50,
      pointBorderWidth: 2,
      data: [10, 30, 26, 18, 18, 28, 31, 33, 25, 24, 32, 31], // Randevu sayılarını buraya ekleyin
    }],
  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'month' // Ay olarak birim olarak ayarlayın
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 12 // Maksimum gösterilecek ay sayısını ayarlayın
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: 40, // Y ekseninin maksimum değerini ayarlayın
          maxTicksLimit: 5
        },
        gridLines: {
          color: "rgba(0, 0, 0, .125)",
        }
      }],
    },
    legend: {
      display: false
    }
  }
});
