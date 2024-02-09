<?php
include_once 'functions/connection.php';

function yearly_chart()
{
  global $db;
  $sql = "SELECT YEAR(created_at) AS year, SUM(total) AS total_sales
    FROM payments
    WHERE YEAR(created_at) = YEAR(CURRENT_TIMESTAMP)
    GROUP BY YEAR(created_at)
    ORDER BY YEAR(created_at)";

  $stmt = $db->prepare($sql);
  $stmt->execute();

  $labels = [];
  $data = [];
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $labels[] = $row['year'];
    $data[] = $row['total_sales'];
  }
  $chartData = [
    'labels' => $labels,
    'datasets' => [
      [
        'label' => 'Yearly Earnings',
        'fill' => true,
        'data' => $data,
        'backgroundColor' => 'rgba(78, 115, 223, 0.05)',
        'borderColor' => 'rgba(78, 115, 223, 1)'
      ]
    ]
  ];

  $chartDataJson = json_encode($chartData);
?>
  <canvas data-bss-chart='{"type":"line","data":<?php echo $chartDataJson; ?>,"options":{"maintainAspectRatio":false,"legend":{"display":false,"labels":{"fontStyle":"normal"}},"title":{"fontStyle":"normal"},"scales":{"xAxes":[{"gridLines":{"color":"rgb(234, 236, 244)","zeroLineColor":"rgb(234, 236, 244)","drawBorder":false,"drawTicks":false,"borderDash":["2"],"zeroLineBorderDash":["2"],"drawOnChartArea":false},"ticks":{"fontColor":"#858796","fontStyle":"normal","padding":20}}],"yAxes":[{"gridLines":{"color":"rgb(234, 236, 244)","zeroLineColor":"rgb(234, 236, 244)","drawBorder":false,"drawTicks":false,"borderDash":["2"],"zeroLineBorderDash":["2"]},"ticks":{"fontColor":"#858796","fontStyle":"normal","padding":20}}]}}}'></canvas>
<?php
}


function month_chart()
{
  global $db;
  $sql = "SELECT YEAR(created_at) AS year, MONTH(created_at) AS month, SUM(total) AS total_sales
  FROM payments
  WHERE MONTH(created_at) = MONTH(CURRENT_TIMESTAMP)
  GROUP BY YEAR(created_at), MONTH(created_at)
  ORDER BY YEAR(created_at), MONTH(created_at)";

  $stmt = $db->prepare($sql);
  $stmt->execute();

  $labels = [];
  $data = [];
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $monthName = date("M", mktime(0, 0, 0, $row['month'], 10));
    $labels[] = $monthName . ' ' . $row['year'];
    $data[] = $row['total_sales'];
  }
  $chartData = [
    'labels' => $labels,
    'datasets' => [
      [
        'label' => 'Earnings',
        'fill' => true,
        'data' => $data,
        'backgroundColor' => 'rgba(78, 115, 223, 0.05)',
        'borderColor' => 'rgba(78, 115, 223, 1)'
      ]
    ]
  ];


  $chartDataJson = json_encode($chartData);
?>
  <canvas data-bss-chart='{"type":"line","data":<?php echo $chartDataJson; ?>,"options":{"maintainAspectRatio":false,"legend":{"display":false,"labels":{"fontStyle":"normal"}},"title":{"fontStyle":"normal"},"scales":{"xAxes":[{"gridLines":{"color":"rgb(234, 236, 244)","zeroLineColor":"rgb(234, 236, 244)","drawBorder":false,"drawTicks":false,"borderDash":["2"],"zeroLineBorderDash":["2"],"drawOnChartArea":false},"ticks":{"fontColor":"#858796","fontStyle":"normal","padding":20}}],"yAxes":[{"gridLines":{"color":"rgb(234, 236, 244)","zeroLineColor":"rgb(234, 236, 244)","drawBorder":false,"drawTicks":false,"borderDash":["2"],"zeroLineBorderDash":["2"]},"ticks":{"fontColor":"#858796","fontStyle":"normal","padding":20}}]}}}'></canvas>
<?php
}



function get_gender_piechart()
{
  global $db;
  $sql = "SELECT COUNT(CASE WHEN sex = 'Male' THEN 1 END) AS male_count,
          COUNT(CASE WHEN sex = 'Female' THEN 1 END) AS female_count,
          COUNT(CASE WHEN sex = 'Referral' THEN 1 END) AS referral_count
          FROM members";

  $stmt = $db->prepare($sql);
  $stmt->execute();

  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $maleCount = $row['male_count'];
  $femaleCount = $row['female_count'];
  $referralCount = $row['referral_count'];

  $chartData = [
    'type' => 'doughnut',
    'data' => [
      'labels' => ['Male', 'Female', 'Referral'],
      'datasets' => [
        [
          'label' => '',
          'backgroundColor' => ['#4e73df', '#1cc88a'],
          'borderColor' => ['#ffffff', '#ffffff'],
          'data' => [$maleCount, $femaleCount, $referralCount]
        ]
      ]
    ],
    'options' => [
      'maintainAspectRatio' => false,
      'legend' => [
        'display' => false,
        'labels' => [
          'fontStyle' => 'normal'
        ]
      ],
      'title' => [
        'fontStyle' => 'normal'
      ]
    ]
  ];

  $chartDataJson = json_encode($chartData);
?>
  <canvas data-bss-chart='<?php echo htmlspecialchars($chartDataJson); ?>'></canvas>
<?php
}
