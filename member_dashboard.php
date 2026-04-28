<?php
session_start();

if (!isset($_SESSION['member_id']) || $_SESSION['role'] !== 'member') {
    header('Location: ./index.php');
    exit();
}

include_once 'functions/connection.php';

$stmt = $db->prepare("SELECT * FROM members WHERE id = ?");
$stmt->execute([$_SESSION['member_id']]);
$member = $stmt->fetch(PDO::FETCH_ASSOC);

$start     = new DateTime($member['start_date']);
$today     = new DateTime();
$daysMap   = ['Monthly' => 30, 'Quarterly' => 90, 'Annual' => 365];
$days      = $daysMap[$member['type']] ?? 30;
$expiry    = (clone $start)->modify("+{$days} days");
$remaining = $today->diff($expiry)->days;
$isExpired = $today > $expiry;

$equipStmt = $db->query("SELECT * FROM equipment ORDER BY created_at DESC");
$equipList = $equipStmt->fetchAll(PDO::FETCH_ASSOC);

$page = $_GET['page'] ?? 'dashboard';

$schedule = [
    'Monday'    => ['focus' => 'Chest Day',    'icon' => '💪', 'color' => 'danger',   'exercises' => ['Bench Press', 'Push Ups', 'Chest Fly', 'Incline Press']],
    'Tuesday'   => ['focus' => 'Back Day',     'icon' => '🏋️', 'color' => 'primary',  'exercises' => ['Pull Ups', 'Deadlift', 'Bent Over Row', 'Lat Pulldown']],
    'Wednesday' => ['focus' => 'Leg Day',      'icon' => '🦵', 'color' => 'success',  'exercises' => ['Squats', 'Lunges', 'Leg Press', 'Calf Raises']],
    'Thursday'  => ['focus' => 'Shoulder Day', 'icon' => '🔝', 'color' => 'warning',  'exercises' => ['Shoulder Press', 'Lateral Raise', 'Front Raise', 'Shrugs']],
    'Friday'    => ['focus' => 'Arm Day',      'icon' => '💪', 'color' => 'info',     'exercises' => ['Bicep Curl', 'Tricep Dip', 'Hammer Curl', 'Skull Crushers']],
    'Saturday'  => ['focus' => 'Core Day',     'icon' => '🔥', 'color' => 'orange',   'exercises' => ['Plank', 'Crunches', 'Leg Raises', 'Russian Twist']],
    'Sunday'    => ['focus' => 'Rest Day',     'icon' => '😴', 'color' => 'secondary','exercises' => ['Light Stretching', 'Walking', 'Meditation']],
];
$todayName     = $today->format('l');
$todaySchedule = $schedule[$todayName];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GMS - Member Dashboard</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Nunito.css">
    <style>
        body { background: #f4f6f9; margin: 0; }
        .sidebar { width: 240px; min-height: 100vh; background: #1a233a; position: fixed; top: 0; left: 0; display: flex; flex-direction: column; z-index: 100; }
        .sidebar-brand { padding: 20px 16px; display: flex; align-items: center; gap: 10px; border-bottom: 1px solid rgba(255,255,255,0.08); }
        .sidebar-brand span { color: #fff; font-weight: 700; font-size: 18px; }
        .sidebar-nav { padding: 16px 0; flex: 1; }
        .nav-item { display: flex; align-items: center; gap: 12px; padding: 12px 20px; color: rgba(255,255,255,0.65); text-decoration: none; font-size: 14px; font-weight: 600; transition: all 0.2s; }
        .nav-item:hover { background: rgba(255,255,255,0.07); color: #fff; }
        .nav-item.active { background: rgba(25,135,84,0.25); color: #2ecc71; border-left: 3px solid #2ecc71; }
        .nav-item .nav-icon { font-size: 18px; width: 24px; text-align: center; }
        .main-content { margin-left: 240px; min-height: 100vh; display: flex; flex-direction: column; }
        .topbar { background: #1a233a; padding: 14px 24px; display: flex; align-items: center; justify-content: flex-end; gap: 16px; }
        .topbar span { color: #fff; font-size: 14px; }
        .content-area { padding: 28px; }
        .stat-card { border: none; border-radius: 14px; padding: 20px 24px; }
        .stat-card .label { font-size: 12px; font-weight: 600; color: #888; letter-spacing: 0.5px; text-transform: uppercase; }
        .stat-card .value { font-size: 26px; font-weight: 700; margin-top: 4px; }
        .avatar { width: 52px; height: 52px; border-radius: 50%; background: #198754; color: #fff; font-size: 20px; font-weight: 700; display: flex; align-items: center; justify-content: center; }
        .info-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f0f0f0; font-size: 14px; }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: #888; font-weight: 600; }
        .equip-card { border-radius: 12px; border: none; transition: transform 0.2s; }
        .equip-card:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(0,0,0,0.1) !important; }
        .equip-icon { width: 46px; height: 46px; border-radius: 12px; background: #e8f5e9; display: flex; align-items: center; justify-content: center; font-size: 22px; }
        .equip-badge { font-size: 11px; padding: 4px 10px; border-radius: 20px; font-weight: 600; }
        .exercise-tag { display: inline-block; background: #e8f5e9; color: #198754; border-radius: 20px; padding: 3px 12px; font-size: 12px; font-weight: 600; margin: 3px; }
        .trainer-card { border-radius: 14px; border: none; transition: transform 0.2s; }
        .trainer-card:hover { transform: translateY(-3px); }
        .trainer-avatar { width: 64px; height: 64px; border-radius: 50%; background: #1a233a; color: #fff; font-size: 24px; font-weight: 700; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-brand">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -32 576 576" width="1em" height="1em" fill="currentColor" class="text-success" style="font-size:28px">
            <path d="M173.2 0c-1.8 0-3.5 .7-4.8 2C138.5 32.3 120 74 120 120c0 26.2 6 50.9 16.6 73c-22 2.4-43.8 9.1-64.2 20.5C37.9 232.8 13.3 262.4 .4 296c-.7 1.7-.5 3.7 .5 5.2c2.2 3.7 7.4 4.3 10.6 1.3C64.2 254.3 158 245.1 205 324s-8.1 153.1-77.6 173.2c-4.2 1.2-6.3 5.9-4.1 9.6c1 1.6 2.6 2.7 4.5 3c36.5 5.9 75.2 .1 109.7-19.2c20.4-11.4 37.4-26.5 50.5-43.8c13.1 17.3 30.1 32.4 50.5 43.8c34.5 19.3 73.3 25.2 109.7 19.2c1.9-.3 3.5-1.4 4.5-3c2.2-3.7 .1-8.4-4.1-9.6C379.1 477.1 324 403 371 324s140.7-69.8 193.5-21.4c3.2 2.9 8.4 2.3 10.6-1.3c1-1.6 1.1-3.5 .5-5.2c-12.9-33.6-37.5-63.2-72.1-82.5c-20.4-11.4-42.2-18.1-64.2-20.5C450 170.9 456 146.2 456 120c0-46-18.5-87.7-48.4-118c-1.3-1.3-3-2-4.8-2c-5 0-8.4 5.2-6.7 9.9C421.7 80.5 385.6 176 288 176S154.3 80.5 179.9 9.9c1.7-4.7-1.6-9.9-6.7-9.9z"/>
        </svg>
        <span>GMS</span>
    </div>
    <nav class="sidebar-nav">
        <a href="?page=dashboard" class="nav-item <?php echo $page === 'dashboard' ? 'active' : ''; ?>"><span class="nav-icon">📊</span> Dashboard</a>
        <a href="?page=information" class="nav-item <?php echo $page === 'information' ? 'active' : ''; ?>"><span class="nav-icon">👤</span> My Information</a>
        <a href="?page=equipment" class="nav-item <?php echo $page === 'equipment' ? 'active' : ''; ?>"><span class="nav-icon">🏋️</span> Available Equipment</a>
        <a href="?page=trainers" class="nav-item <?php echo $page === 'trainers' ? 'active' : ''; ?>"><span class="nav-icon">🧑‍🏫</span> Available Trainers</a>
        <a href="?page=schedule" class="nav-item <?php echo $page === 'schedule' ? 'active' : ''; ?>"><span class="nav-icon">📅</span> Training Schedule</a>
        <a href="?page=body_schedule" class="nav-item <?php echo $page === 'body_schedule' ? 'active' : ''; ?>"><span class="nav-icon">💪</span> Body Schedule</a>
        <a href="functions/logout.php" class="nav-item"><span class="nav-icon">🚪</span> Logout</a>
    </nav>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="topbar">
        <span>Welcome, <strong><?php echo htmlspecialchars($member['fullname']); ?></strong></span>
        <a href="functions/logout.php" class="btn btn-outline-light btn-sm">Logout</a>
    </div>

    <div class="content-area">

        <?php if ($page === 'dashboard'): ?>
        <div class="d-flex align-items-center gap-3 mb-4">
            <div class="avatar"><?php echo strtoupper(substr($member['fullname'], 0, 1)); ?></div>
            <div>
                <h5 class="mb-0 fw-bold"><?php echo htmlspecialchars($member['fullname']); ?></h5>
                <small class="text-muted"><?php echo htmlspecialchars($member['email']); ?></small>
            </div>
            <div class="ms-auto">
                <?php $planColors = ['Monthly' => 'success', 'Quarterly' => 'primary', 'Annual' => 'warning']; $color = $planColors[$member['type']] ?? 'secondary'; ?>
                <span class="badge bg-<?php echo $color; ?> fs-6 px-3 py-2"><?php echo $member['type']; ?> Plan</span>
            </div>
        </div>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="stat-card bg-white shadow-sm">
                    <div class="label">Membership Status</div>
                    <div class="value <?php echo $isExpired ? 'text-danger' : 'text-success'; ?>"><?php echo $isExpired ? 'Expired' : 'Active'; ?></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card bg-white shadow-sm">
                    <div class="label">Days Remaining</div>
                    <div class="value text-primary"><?php echo $isExpired ? '0' : $remaining; ?> days</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card bg-white shadow-sm">
                    <div class="label">Expiry Date</div>
                    <div class="value text-dark" style="font-size:18px"><?php echo $expiry->format('M d, Y'); ?></div>
                </div>
            </div>
        </div>
        <div class="card border-0 shadow-sm mb-4" style="border-radius:14px; background: linear-gradient(135deg, #1a233a, #198754);">
            <div class="card-body p-4 text-white">
                <div class="d-flex align-items-center gap-3">
                    <div style="font-size:48px"><?php echo $todaySchedule['icon']; ?></div>
                    <div>
                        <p class="mb-0 opacity-75 small fw-bold">TODAY IS <?php echo strtoupper($todayName); ?></p>
                        <h4 class="mb-1 fw-bold"><?php echo $todaySchedule['focus']; ?></h4>
                        <div>
                            <?php foreach ($todaySchedule['exercises'] as $ex): ?>
                            <span style="background:rgba(255,255,255,0.2); border-radius:20px; padding:3px 12px; font-size:12px; margin:3px; display:inline-block;"><?php echo $ex; ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($isExpired): ?>
        <div class="alert alert-danger border-0 rounded-3">Your membership has expired. Please contact the gym admin to renew.</div>
        <?php elseif ($remaining <= 7): ?>
        <div class="alert alert-warning border-0 rounded-3">Your membership is expiring in <strong><?php echo $remaining; ?> days</strong>. Please contact the gym admin to renew.</div>
        <?php endif; ?>

        <?php elseif ($page === 'information'): ?>
        <h5 class="fw-bold mb-4">👤 My Information</h5>
        <div class="card border-0 shadow-sm" style="border-radius:14px">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="avatar" style="width:64px;height:64px;font-size:26px"><?php echo strtoupper(substr($member['fullname'], 0, 1)); ?></div>
                    <div>
                        <h5 class="mb-0 fw-bold"><?php echo htmlspecialchars($member['fullname']); ?></h5>
                        <small class="text-muted"><?php echo htmlspecialchars($member['email']); ?></small>
                    </div>
                </div>
                <div class="info-row"><span class="info-label">Full Name</span><span><?php echo htmlspecialchars($member['fullname']); ?></span></div>
                <div class="info-row"><span class="info-label">Email</span><span><?php echo htmlspecialchars($member['email']); ?></span></div>
                <div class="info-row"><span class="info-label">Phone</span><span><?php echo htmlspecialchars($member['phone']); ?></span></div>
                <div class="info-row"><span class="info-label">Sex</span><span><?php echo htmlspecialchars($member['sex']); ?></span></div>
                <div class="info-row"><span class="info-label">Birthdate</span><span><?php echo date('F d, Y', strtotime($member['birthdate'])); ?></span></div>
                <div class="info-row"><span class="info-label">Address</span><span><?php echo htmlspecialchars($member['address']); ?></span></div>
                <div class="info-row"><span class="info-label">Membership Type</span><span><?php echo htmlspecialchars($member['type']); ?></span></div>
                <div class="info-row"><span class="info-label">Status</span><span class="text-success fw-bold"><?php echo htmlspecialchars($member['status']); ?></span></div>
                <div class="info-row"><span class="info-label">Member Since</span><span><?php echo date('F d, Y', strtotime($member['start_date'])); ?></span></div>
                <div class="info-row"><span class="info-label">Expiry Date</span><span><?php echo $expiry->format('F d, Y'); ?></span></div>
            </div>
        </div>

        <?php elseif ($page === 'equipment'): ?>
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h5 class="fw-bold mb-0">🏋️ Available Gym Equipment</h5>
            <span class="badge bg-success fs-6 px-3"><?php echo count($equipList); ?> Equipment</span>
        </div>
        <?php if (count($equipList) > 0): ?>
        <div class="row g-3">
            <?php foreach ($equipList as $eq): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card equip-card shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="equip-icon">🏋️</div>
                            <div>
                                <h6 class="mb-0 fw-bold"><?php echo htmlspecialchars($eq['equipment_name']); ?></h6>
                                <small class="text-muted">Delivery: <?php echo date('M d, Y', strtotime($eq['delivery_date'])); ?></small>
                            </div>
                        </div>
                        <?php if (!empty($eq['description'])): ?>
                        <p class="text-muted small mb-2"><?php echo htmlspecialchars($eq['description']); ?></p>
                        <?php endif; ?>
                        <div class="d-flex flex-wrap gap-2 mt-2">
                            <?php if (!empty($eq['muscles_used'])): ?>
                            <span class="badge bg-primary bg-opacity-10 text-primary equip-badge">💪 <?php echo htmlspecialchars($eq['muscles_used']); ?></span>
                            <?php endif; ?>
                            <?php $qty = intval($eq['quantity'] ?? 0); $qtyColor = $qty > 5 ? 'success' : ($qty > 0 ? 'warning' : 'danger'); $qtyText = $qty > 0 ? $qty . ' Available' : 'Out of Stock'; ?>
                            <span class="badge bg-<?php echo $qtyColor; ?> equip-badge">🔢 <?php echo $qtyText; ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="card border-0 shadow-sm" style="border-radius:14px">
            <div class="card-body p-4 text-center text-muted">
                <div style="font-size:40px">🏋️</div>
                <p class="mt-2 mb-0">No equipment available yet.</p>
            </div>
        </div>
        <?php endif; ?>

        <?php elseif ($page === 'trainers'): ?>
        <h5 class="fw-bold mb-4">🧑‍🏫 Available Trainers</h5>
        <?php
        $trainerStmt = $db->query("SELECT id, fullname, gender, mobile, email FROM trainers ORDER BY created_at DESC");
        $trainers = $trainerStmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <div class="row g-3">
            <?php if (count($trainers) > 0): ?>
                <?php foreach ($trainers as $trainer): ?>
                <div class="col-md-4">
                    <div class="card trainer-card shadow-sm h-100">
                        <div class="card-body p-4 text-center">
                            <div class="trainer-avatar"><?php echo strtoupper(substr($trainer['fullname'], 0, 1)); ?></div>
                            <h6 class="fw-bold mb-2"><?php echo htmlspecialchars($trainer['fullname']); ?></h6>
                            <div class="d-flex flex-column gap-2 mt-2 text-start">
                                <p class="text-muted small mb-0"><strong>⚧ Gender:</strong> <?php echo htmlspecialchars($trainer['gender']); ?></p>
                                <p class="text-muted small mb-0"><strong>📞 Mobile:</strong> <?php echo htmlspecialchars($trainer['mobile']); ?></p>
                                <p class="text-muted small mb-0"><strong>✉️ Email:</strong> <?php echo htmlspecialchars($trainer['email']); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="card border-0 shadow-sm" style="border-radius:14px">
                        <div class="card-body p-4 text-center text-muted">
                            <div style="font-size:40px">🧑‍🏫</div>
                            <p class="mt-2 mb-0">No trainers available yet.</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <?php elseif ($page === 'schedule'): ?>
        <?php
        $schedStmt = $db->prepare("SELECT * FROM schedules WHERE member_id = ?");
        $schedStmt->execute([$_SESSION['member_id']]);
        $savedSchedules = $schedStmt->fetchAll(PDO::FETCH_ASSOC);
        $timeSlots = ['6:00 AM', '9:00 AM', '3:00 PM', '6:00 PM'];
        $scheduleDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $focusOptions = ['Chest', 'Back', 'Legs', 'Shoulders', 'Arms', 'Core', 'Cardio', 'Rest', 'Full Body'];
        $scheduleMap = [];
        foreach ($savedSchedules as $s) {
            $scheduleMap[$s['day']][$s['time_slot']] = $s['focus'];
        }
        $defaultFocus = [
            'Monday' => 'Chest', 'Tuesday' => 'Back', 'Wednesday' => 'Legs',
            'Thursday' => 'Shoulders', 'Friday' => 'Arms', 'Saturday' => 'Core'
        ];
        ?>
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h5 class="fw-bold mb-0">📅 My Training Schedule</h5>
            <button class="btn btn-success" onclick="saveSchedule()">💾 Save Schedule</button>
        </div>
        <div class="alert alert-info border-0 rounded-3 mb-3">
            <small>💡 Use the dropdowns to customize your training focus for each time slot then click Save!</small>
        </div>
        <div class="card border-0 shadow-sm" style="border-radius:14px">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <?php foreach ($scheduleDays as $day): ?>
                                <th><?php echo $day; ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($timeSlots as $time): ?>
                            <tr>
                                <td class="fw-bold"><?php echo $time; ?></td>
                                <?php foreach ($scheduleDays as $day): ?>
                                <?php $focus = $scheduleMap[$day][$time] ?? $defaultFocus[$day]; ?>
                                <td>
                                    <select class="form-select form-select-sm schedule-select"
                                            data-day="<?php echo $day; ?>"
                                            data-time="<?php echo $time; ?>">
                                        <?php foreach ($focusOptions as $opt): ?>
                                        <option value="<?php echo $opt; ?>" <?php echo $focus === $opt ? 'selected' : ''; ?>>
                                            <?php echo $opt; ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <?php endforeach; ?>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script>
        function saveSchedule() {
            const selects = document.querySelectorAll('.schedule-select');
            const schedules = [];
            selects.forEach(select => {
                schedules.push({
                    day: select.dataset.day,
                    time_slot: select.dataset.time,
                    focus: select.value
                });
            });
            fetch('api/schedule.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    member_id: <?php echo $_SESSION['member_id']; ?>,
                    schedules: schedules
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    swal("Saved!", "Your training schedule has been saved!", "success");
                } else {
                    swal("Error!", "Failed to save schedule.", "error");
                }
            })
            .catch(() => swal("Error!", "Something went wrong.", "error"));
        }
        </script>

        <?php elseif ($page === 'body_schedule'): ?>
        <h5 class="fw-bold mb-4">💪 Weekly Body Schedule</h5>
        <div class="card border-0 shadow-sm mb-4" style="border-radius:14px; background: linear-gradient(135deg, #1a233a, #198754);">
            <div class="card-body p-4 text-white">
                <p class="mb-1 opacity-75 small fw-bold">TODAY — <?php echo strtoupper($todayName); ?></p>
                <h3 class="fw-bold mb-2"><?php echo $todaySchedule['icon']; ?> <?php echo $todaySchedule['focus']; ?></h3>
                <div>
                    <?php foreach ($todaySchedule['exercises'] as $ex): ?>
                    <span style="background:rgba(255,255,255,0.2); border-radius:20px; padding:4px 14px; font-size:13px; margin:3px; display:inline-block;"><?php echo $ex; ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="row g-3">
            <?php foreach ($schedule as $day => $info): ?>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100 <?php echo $day === $todayName ? 'border border-success' : ''; ?>" style="border-radius:14px">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span style="font-size:24px"><?php echo $info['icon']; ?></span>
                            <div>
                                <p class="mb-0 text-muted small fw-bold"><?php echo strtoupper($day); ?></p>
                                <h6 class="mb-0 fw-bold"><?php echo $info['focus']; ?></h6>
                            </div>
                            <?php if ($day === $todayName): ?>
                            <span class="badge bg-success ms-auto">Today</span>
                            <?php endif; ?>
                        </div>
                        <div>
                            <?php foreach ($info['exercises'] as $ex): ?>
                            <span class="exercise-tag"><?php echo $ex; ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <?php endif; ?>

    </div>
</div>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/sweetalert.min.js"></script>
</body>
</html>