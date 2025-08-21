<?php
session_start();
require_once __DIR__ . '/db.php';

header('X-Frame-Options: DENY');
header("Content-Security-Policy: default-src 'self' 'unsafe-inline' data:");

// ----- Helpers -----
function ensure_database_installed(): void {
	global $conn;
	if (!$conn) {
		echo '<!doctype html><meta charset="utf-8"><style>body{font-family:system-ui;padding:24px}</style>';
		echo '<h1>Database not initialized</h1>';
		echo '<p>Please run <code>install.php</code> to create the database and tables.</p>';
		echo '<p><a href="install.php">Initialize now</a></p>';
		exit;
	}
}

function current_user(): ?array {
	return isset($_SESSION['user']) ? $_SESSION['user'] : null;
}

function require_login(?array $roles = null): void {
	$user = current_user();
	if (!$user) {
		header('Location: app.php?route=login');
		exit;
	}
	if ($roles && !in_array($user['user_type'], $roles, true)) {
		header('HTTP/1.1 403 Forbidden');
		echo 'Forbidden';
		exit;
	}
}

function fetch_one(mysqli_stmt $stmt): ?array {
	$stmt->execute();
	$result = $stmt->get_result();
	return $result && $result->num_rows ? $result->fetch_assoc() : null;
}

function fetch_all(mysqli_stmt $stmt): array {
	$stmt->execute();
	$result = $stmt->get_result();
	$rows = [];
	if ($result) {
		while ($row = $result->fetch_assoc()) { $rows[] = $row; }
	}
	return $rows;
}

function render_head(string $title = 'FlashLearn'): void {
	echo '<!doctype html><html lang="en"><head><meta charset="utf-8">';
	echo '<meta name="viewport" content="width=device-width,initial-scale=1">';
	echo '<meta name="theme-color" content="#0ea5e9">';
	echo '<link rel="manifest" href="manifest.webmanifest">';
	echo '<title>' . htmlspecialchars($title) . '</title>';
	echo '<style>';
	echo file_get_contents(__DIR__ . '/inline.css');
	echo '</style>';
	echo '</head><body>';
}

function render_footer(): void {
	echo '<script>if("serviceWorker" in navigator){navigator.serviceWorker.register("/ads/service-worker.js").catch(()=>{});} </script>';
	echo '</body></html>';
}

function render_topnav(): void {
	$user = current_user();
	echo '<header class="topbar"><div class="brand">FlashLearn</div>';
	if ($user) {
		echo '<div class="spacer"></div><nav class="top-actions">';
		echo '<span class="user-pill">' . htmlspecialchars($user['full_name']) . '</span>';
		echo '<a class="btn small" href="app.php?route=logout">Logout</a>';
		echo '</nav>';
	}
	echo '</header>';
}

function render_sidebar(): void {
	$user = current_user();
	if (!$user) return;
	$role = $user['user_type'];
	echo '<aside class="sidebar">';
	if ($role === 'A') {
		echo '<a href="app.php?route=admin/dashboard">Dashboard</a>';
		echo '<a href="app.php?route=admin/students">Students</a>';
		echo '<a href="app.php?route=admin/teachers">Teachers</a>';
		echo '<a href="app.php?route=admin/subjects">Subjects</a>';
	}
	if ($role === 'T') {
		echo '<a href="app.php?route=teacher/profile">Profile</a>';
		echo '<a href="app.php?route=teacher/cards">Your Cards</a>';
		echo '<a href="app.php?route=teacher/recent">Recent</a>';
		echo '<a href="app.php?route=teacher/subjects">Your Subjects</a>';
		echo '<a href="app.php?route=teacher/settings">Settings</a>';
	}
	if ($role === 'S') {
		echo '<a href="app.php?route=student/profile">Profile</a>';
		echo '<a href="app.php?route=student/cards">Your Cards</a>';
		echo '<a href="app.php?route=student/recent">Recent</a>';
		echo '<a href="app.php?route=student/subjects">Your Subjects</a>';
		echo '<a href="app.php?route=student/friends">Your Friends</a>';
		echo '<a href="app.php?route=student/settings">Settings</a>';
	}
	echo '</aside>';
}

// ----- Routing -----
$route = $_GET['route'] ?? 'home';

// Public: login
if ($route === 'login' || $route === 'home') {
	ensure_database_installed();
	$user = current_user();
	if ($user) {
		if ($user['user_type'] === 'A') { header('Location: app.php?route=admin/dashboard'); exit; }
		if ($user['user_type'] === 'T') { header('Location: app.php?route=teacher/cards'); exit; }
		if ($user['user_type'] === 'S') { header('Location: app.php?route=student/cards'); exit; }
	}
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
		$password = $_POST['password'] ?? '';
		$login_time = date('Y-m-d H:i:s');
		$userRow = null;
		$stmt = db()->prepare('SELECT user_info_id, full_name, e_mail, pass_word, contact_no, course, user_type, user_status FROM user_info WHERE e_mail = ?');
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$res = $stmt->get_result();
		if ($res && $res->num_rows === 1) {
			$row = $res->fetch_assoc();
			if (password_verify($password, $row['pass_word'])) {
				$_SESSION['user'] = [
					'user_info_id' => $row['user_info_id'],
					'full_name' => $row['full_name'],
					'e_mail' => $row['e_mail'],
					'contact_no' => $row['contact_no'],
					'course' => $row['course'],
					'user_type' => $row['user_type'],
					'user_status' => $row['user_status'],
				];
				$stmt2 = db()->prepare('INSERT INTO login_logs (user_info_id, date_login) VALUES (?, ?)');
				$stmt2->bind_param('is', $row['user_info_id'], $login_time);
				$stmt2->execute();
				if ($row['user_type'] === 'A') { header('Location: app.php?route=admin/dashboard'); exit; }
				if ($row['user_type'] === 'T') { header('Location: app.php?route=teacher/cards'); exit; }
				if ($row['user_type'] === 'S') { header('Location: app.php?route=student/cards'); exit; }
			}
			// fallthrough: invalid password
		}
		// Log failed login
		$null = null;
		$stmt3 = db()->prepare('INSERT INTO login_logs (user_info_id, date_login) VALUES (?, ?)');
		$stmt3->bind_param('is', $null, $login_time);
		$stmt3->execute();
		$err = 'Invalid email or password';
	}
	render_head('Login • FlashLearn');
	echo '<main class="auth-wrap">';
	echo '<form class="card auth" method="post" action="app.php?route=login">';
	echo '<h1>Login</h1>';
	echo !empty($err) ? '<div class="error">' . htmlspecialchars($err) . '</div>' : '';
	echo '<label>Email<input type="email" name="email" required></label>';
	echo '<label>Password<input type="password" name="password" required></label>';
	echo '<button class="btn primary" type="submit">Log in</button>';
	echo '<div class="muted">New here? <a href="app.php?route=signup">Create an account</a></div>';
	echo '</form></main>';
	render_footer();
	exit;
}

// Public: signup
if ($route === 'signup') {
	ensure_database_installed();
	$success = false; $message = '';
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$full_name = trim($_POST['fullname'] ?? '');
		$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
		$contact = trim($_POST['contact'] ?? '');
		$password = (string)($_POST['password'] ?? '');
		$password2 = (string)($_POST['password2'] ?? '');
		$user_type_input = $_POST['user_type'] ?? '';
		$course = $_POST['course'] ?? '';
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $message = 'Invalid email format.'; }
		elseif ($password !== $password2) { $message = 'Passwords do not match.'; }
		else {
			$user_type = $user_type_input === 'student' ? 'S' : ($user_type_input === 'teacher' ? 'T' : '');
			if (!$user_type) { $message = 'Invalid user type.'; }
			else {
				if ($user_type === 'T') { $course = 'N/A'; }
				$stmt = db()->prepare('SELECT user_info_id FROM user_info WHERE e_mail = ?');
				$stmt->bind_param('s', $email);
				$stmt->execute();
				$stmt->store_result();
				if ($stmt->num_rows > 0) { $message = 'Email already registered.'; }
				else {
					$hash = password_hash($password, PASSWORD_BCRYPT);
					$stmt2 = db()->prepare('INSERT INTO user_info (full_name, e_mail, contact_no, pass_word, course, user_type, user_status, date_created, date_updated) VALUES (?, ?, ?, ?, ?, ?, "A", NOW(), NOW())');
					$stmt2->bind_param('ssssss', $full_name, $email, $contact, $hash, $course, $user_type);
					$stmt2->execute();
					$success = true;
					$message = 'Signup successful. You can log in now.';
				}
			}
		}
	}
	render_head('Sign up • FlashLearn');
	echo '<main class="auth-wrap">';
	echo '<form class="card auth" method="post" action="app.php?route=signup">';
	echo '<h1>Sign up</h1>';
	echo $message ? '<div class="'.($success?'notice':'error').'">' . htmlspecialchars($message) . '</div>' : '';
	echo '<label>Full name<input type="text" name="fullname" required></label>';
	echo '<label>Email<input type="email" name="email" required></label>';
	echo '<label>Contact no.<input type="text" name="contact" required></label>';
	echo '<label>Password<input type="password" name="password" required></label>';
	echo '<label>Re-type password<input type="password" name="password2" required></label>';
	echo '<fieldset class="choice"><legend>I am a:</legend>';
	echo '<label><input type="radio" name="user_type" value="student" required> Student</label>';
	echo '<label><input type="radio" name="user_type" value="teacher" required> Teacher</label>';
	echo '</fieldset>';
	echo '<div id="courseWrap"><label>Course<select name="course"><option value="BSED">Bachelor in Secondary Education</option><option value="BEED">Bachelor in Elementary Education</option><option value="BSCS">Computer Science</option><option value="BSIT">Information Technology</option><option value="BSIS">Information Systems</option></select></label></div>';
	echo '<button class="btn primary" type="submit">Create account</button>';
	echo '<div class="muted">Already a user? <a href="app.php?route=login">Log in</a></div>';
	echo '</form></main>';
	echo '<script>const courseWrap=document.getElementById("courseWrap");document.addEventListener("change",(e)=>{if(e.target.name==="user_type"){courseWrap.style.display=(e.target.value==="student")?"block":"none";}});</script>';
	render_footer();
	exit;
}

// Logout
if ($route === 'logout') {
	session_destroy();
	header('Location: app.php?route=login');
	exit;
}

// Admin dashboard
if ($route === 'admin/dashboard') {
	require_login(['A']);
	$stmtU = db()->prepare('SELECT COUNT(*) c FROM user_info');
	$stmtU->execute(); $totalUsers = $stmtU->get_result()->fetch_assoc()['c'] ?? 0;
	$stmtS = db()->prepare("SELECT COUNT(*) c FROM user_info WHERE user_type='S'");
	$stmtS->execute(); $totalStudents = $stmtS->get_result()->fetch_assoc()['c'] ?? 0;
	$stmtT = db()->prepare("SELECT COUNT(*) c FROM user_info WHERE user_type='T'");
	$stmtT->execute(); $totalTeachers = $stmtT->get_result()->fetch_assoc()['c'] ?? 0;
	$stmtSub = db()->prepare('SELECT COUNT(*) c FROM subjects');
	$stmtSub->execute(); $totalSubjects = $stmtSub->get_result()->fetch_assoc()['c'] ?? 0;
	render_head('Admin • Dashboard');
	render_topnav();
	echo '<div class="layout">';
	render_sidebar();
	echo '<main class="content"><h1>Overview</h1><div class="kpis">';
	echo '<div class="kpi"><div class="kpi-num">' . (int)$totalUsers . '</div><div class="kpi-label">Total users</div></div>';
	echo '<div class="kpi"><div class="kpi-num">' . (int)$totalStudents . '</div><div class="kpi-label">Students</div></div>';
	echo '<div class="kpi"><div class="kpi-num">' . (int)$totalTeachers . '</div><div class="kpi-label">Teachers</div></div>';
	echo '<div class="kpi"><div class="kpi-num">' . (int)$totalSubjects . '</div><div class="kpi-label">Subjects</div></div>';
	echo '</div>';
	echo '<section class="panel"><h2>Recent logins</h2>';
	$rows = fetch_all(db()->prepare('SELECT ll.date_login, u.full_name, u.user_type FROM login_logs ll LEFT JOIN user_info u ON u.user_info_id = ll.user_info_id ORDER BY ll.date_login DESC LIMIT 10'));
	echo '<table class="table"><thead><tr><th>Date</th><th>User</th><th>Role</th></tr></thead><tbody>';
	foreach ($rows as $r) {
		echo '<tr><td>'.htmlspecialchars($r['date_login']).'</td><td>'.htmlspecialchars($r['full_name'] ?? 'Unknown').'</td><td>'.htmlspecialchars($r['user_type'] ?? '-').'</td></tr>';
	}
	echo '</tbody></table></section>';
	echo '</main></div>';
	render_footer();
	exit;
}

// Admin: users list helper
function admin_render_user_list(string $roleCode, string $title, array $cols): void {
	render_head('Admin • ' . $title);
	render_topnav();
	echo '<div class="layout">';
	render_sidebar();
	$q = trim($_GET['q'] ?? '');
	echo '<main class="content"><h1>'.$title.'</h1>';
	echo '<form class="toolbar" method="get" action="app.php">';
	echo '<input type="hidden" name="route" value="'.($roleCode==='S'?'admin/students':'admin/teachers').'">';
	echo '<input class="search" type="text" name="q" placeholder="Search name or email" value="'.htmlspecialchars($q).'">';
	echo '<button class="btn" type="submit">Search</button>';
	echo '</form>';
	$sql = 'SELECT user_info_id, photo, full_name, e_mail, course FROM user_info WHERE user_type = ?';
	$params = [$roleCode];
	if ($q !== '') { $sql .= ' AND (full_name LIKE CONCAT("%", ?, "%") OR e_mail LIKE CONCAT("%", ?, "%"))'; $params[]=$q; $params[]=$q; }
	$sql .= ' ORDER BY full_name ASC LIMIT 100';
	$stmt = db()->prepare($sql);
	$types = $q!=='' ? 'sss' : 's';
	$stmt->bind_param($types, ...$params);
	$rows = fetch_all($stmt);
	echo '<table class="table"><thead><tr>';
	foreach ($cols as $c) echo '<th>'.$c.'</th>';
	echo '<th>Actions</th></tr></thead><tbody>';
	foreach ($rows as $r) {
		echo '<tr>';
		echo '<td><div class="avatar" style="background-image:url('.htmlspecialchars($r['photo'] ?: '') .')"></div></td>';
		echo '<td>'.htmlspecialchars($r['full_name']).'</td>';
		if ($roleCode==='S') echo '<td>'.htmlspecialchars($r['course']).'</td>';
		if ($roleCode==='T') echo '<td>'.htmlspecialchars($r['e_mail']).'</td>';
		echo '<td><a class="link" href="app.php?route=admin/user/view&uid='.$r['user_info_id'].'">View</a> · <a class="link" href="app.php?route=admin/user/edit&uid='.$r['user_info_id'].'">Edit</a> · <a class="link danger" href="app.php?route=admin/user/delete&uid='.$r['user_info_id'].'" onclick="return confirm(\'Delete this user?\')">Delete</a></td>';
		echo '</tr>';
	}
	echo '</tbody></table>';
	echo '</main></div>';
	render_footer();
}

if ($route === 'admin/students') { require_login(['A']); admin_render_user_list('S', 'Students', ['Photo','Full name','Course']); exit; }
if ($route === 'admin/teachers') { require_login(['A']); admin_render_user_list('T', 'Teachers', ['Photo','Full name','Email']); exit; }

// Admin: subjects list
if ($route === 'admin/subjects') {
	require_login(['A']);
	render_head('Admin • Subjects');
	render_topnav();
	echo '<div class="layout">';
	render_sidebar();
	$q = trim($_GET['q'] ?? '');
	echo '<main class="content"><h1>Subjects</h1>';
	echo '<form class="toolbar" method="get" action="app.php">';
	echo '<input type="hidden" name="route" value="admin/subjects">';
	echo '<input class="search" type="text" name="q" placeholder="Search subject or teacher" value="'.htmlspecialchars($q).'">';
	echo '<button class="btn" type="submit">Search</button>';
	echo '</form>';
	$sql = 'SELECT s.subject_id, s.subject_name, s.subject_photo_url, u.full_name AS teacher_name, (SELECT COUNT(*) FROM enrollments e WHERE e.subject_id = s.subject_id AND e.status = "ACCEPTED") AS enrolled FROM subjects s LEFT JOIN user_info u ON u.user_info_id = s.owner_teacher_user_id';
	if ($q !== '') { $sql .= ' WHERE s.subject_name LIKE CONCAT("%", ?, "%") OR u.full_name LIKE CONCAT("%", ?, "%")'; }
	$sql .= ' ORDER BY s.subject_name ASC LIMIT 100';
	$stmt = db()->prepare($sql);
	if ($q !== '') { $stmt->bind_param('ss', $q, $q); }
	$rows = fetch_all($stmt);
	echo '<table class="table"><thead><tr><th>Photo</th><th>Subject</th><th>Enrolled</th><th>Teacher</th><th>Actions</th></tr></thead><tbody>';
	foreach ($rows as $r) {
		echo '<tr>';
		echo '<td><div class="avatar" style="background-image:url('.htmlspecialchars($r['subject_photo_url'] ?: '') .')"></div></td>';
		echo '<td>'.htmlspecialchars($r['subject_name']).'</td>';
		echo '<td>'.(int)$r['enrolled'].'</td>';
		echo '<td>'.htmlspecialchars($r['teacher_name'] ?? '-').'</td>';
		echo '<td><a class="link" href="app.php?route=admin/subject/view&sid='.$r['subject_id'].'">View</a> · <a class="link" href="app.php?route=admin/subject/edit&sid='.$r['subject_id'].'">Edit</a> · <a class="link danger" href="app.php?route=admin/subject/delete&sid='.$r['subject_id'].'" onclick="return confirm(\'Delete this subject?\')">Delete</a></td>';
		echo '</tr>';
	}
	echo '</tbody></table>';
	echo '</main></div>';
	render_footer();
	exit;
}

// Admin: view user
if ($route === 'admin/user/view') { require_login(['A']); $uid=(int)($_GET['uid']??0); $u=fetch_one((function() use ($uid){$stmt=db()->prepare('SELECT * FROM user_info WHERE user_info_id=?');$stmt->bind_param('i',$uid);return $stmt;})()); if(!$u){header('HTTP/1.1 404 Not Found');echo 'User not found';exit;} render_head('Admin • View user'); render_topnav(); echo '<div class="layout">'; render_sidebar(); echo '<main class="content"><h1>'.htmlspecialchars($u['full_name']).'</h1><div class="panel"><div>Email: '.htmlspecialchars($u['e_mail']).'</div><div>Role: '.htmlspecialchars($u['user_type']).'</div><div>Status: '.htmlspecialchars($u['user_status']).'</div><div>Course: '.htmlspecialchars($u['course']).'</div></div><a class="btn" href="app.php?route=admin/user/edit&uid='.$uid.'">Edit</a></main></div>'; render_footer(); exit; }

// Admin: edit user
if ($route === 'admin/user/edit') { require_login(['A']); $uid=(int)($_GET['uid']??0); $u=fetch_one((function() use ($uid){$stmt=db()->prepare('SELECT * FROM user_info WHERE user_info_id=?');$stmt->bind_param('i',$uid);return $stmt;})()); if(!$u){header('HTTP/1.1 404 Not Found');echo 'User not found';exit;} if($_SERVER['REQUEST_METHOD']==='POST'){ $name=trim($_POST['full_name']??$u['full_name']); $status=$_POST['user_status']??$u['user_status']; $course=trim($_POST['course']??($u['course']??'')); $stmt=db()->prepare('UPDATE user_info SET full_name=?, user_status=?, course=?, date_updated=NOW() WHERE user_info_id=?'); $stmt->bind_param('sssi',$name,$status,$course,$uid); $stmt->execute(); header('Location: app.php?route=admin/user/view&uid='.$uid); exit; } render_head('Admin • Edit user'); render_topnav(); echo '<div class="layout">'; render_sidebar(); echo '<main class="content"><h1>Edit user</h1><form class="panel" method="post"><label>Full name<input type="text" name="full_name" value="'.htmlspecialchars($u['full_name']).'" required></label><label>Status<select name="user_status"><option '.($u['user_status']==='A'?'selected':'').' value="A">Active</option><option '.($u['user_status']==='IA'?'selected':'').' value="IA">Inactive</option></select></label><label>Course<input type="text" name="course" value="'.htmlspecialchars($u['course']??'').'"></label><button class="btn">Save</button></form></main></div>'; render_footer(); exit; }

// Admin: delete user
if ($route === 'admin/user/delete') { require_login(['A']); $uid=(int)($_GET['uid']??0); if($uid){ $stmt=db()->prepare('DELETE FROM user_info WHERE user_info_id=?'); $stmt->bind_param('i',$uid); $stmt->execute(); } header('Location: app.php?route=admin/students'); exit; }

// Admin: view subject
if ($route === 'admin/subject/view') { require_login(['A']); $sid=(int)($_GET['sid']??0); $s=fetch_one((function() use ($sid){$stmt=db()->prepare('SELECT s.*, u.full_name teacher_name FROM subjects s LEFT JOIN user_info u ON u.user_info_id=s.owner_teacher_user_id WHERE s.subject_id=?');$stmt->bind_param('i',$sid);return $stmt;})()); if(!$s){header('HTTP/1.1 404 Not Found');echo 'Subject not found';exit;} render_head('Admin • View subject'); render_topnav(); echo '<div class="layout">'; render_sidebar(); echo '<main class="content"><h1>'.htmlspecialchars($s['subject_name']).'</h1><div class="panel"><div>Teacher: '.htmlspecialchars($s['teacher_name']??'-').'</div><div>Code: '.htmlspecialchars($s['subject_code']).'</div></div><a class="btn" href="app.php?route=admin/subject/edit&sid='.$sid.'">Edit</a></main></div>'; render_footer(); exit; }

// Admin: edit subject
if ($route === 'admin/subject/edit') { require_login(['A']); $sid=(int)($_GET['sid']??0); $s=fetch_one((function() use ($sid){$stmt=db()->prepare('SELECT * FROM subjects WHERE subject_id=?');$stmt->bind_param('i',$sid);return $stmt;})()); if(!$s){header('HTTP/1.1 404 Not Found');echo 'Subject not found';exit;} if($_SERVER['REQUEST_METHOD']==='POST'){ $name=trim($_POST['subject_name']??$s['subject_name']); $photo=trim($_POST['subject_photo_url']??($s['subject_photo_url']??'')); $stmt=db()->prepare('UPDATE subjects SET subject_name=?, subject_photo_url=?, date_updated=NOW() WHERE subject_id=?'); $stmt->bind_param('ssi',$name,$photo,$sid); $stmt->execute(); header('Location: app.php?route=admin/subject/view&sid='.$sid); exit; } render_head('Admin • Edit subject'); render_topnav(); echo '<div class="layout">'; render_sidebar(); echo '<main class="content"><h1>Edit subject</h1><form class="panel" method="post"><label>Name<input type="text" name="subject_name" value="'.htmlspecialchars($s['subject_name']).'" required></label><label>Photo URL<input type="url" name="subject_photo_url" value="'.htmlspecialchars($s['subject_photo_url']??'').'"></label><button class="btn">Save</button></form></main></div>'; render_footer(); exit; }

// Admin: delete subject
if ($route === 'admin/subject/delete') { require_login(['A']); $sid=(int)($_GET['sid']??0); if($sid){ $stmt=db()->prepare('DELETE FROM subjects WHERE subject_id=?'); $stmt->bind_param('i',$sid); $stmt->execute(); } header('Location: app.php?route=admin/subjects'); exit; }

// Teacher: profile
if ($route === 'teacher/profile') {
	require_login(['T']);
	$user = current_user();
	$subjects = fetch_all(db()->prepare('SELECT subject_id, subject_name FROM subjects WHERE owner_teacher_user_id = '.$user['user_info_id'].' ORDER BY date_created DESC'));
	render_head('Teacher • Profile');
	render_topnav();
	echo '<div class="layout">';
	render_sidebar();
	echo '<main class="content">';
	echo '<h1>Profile</h1>';
	echo '<section class="panel"><div class="profile">';
	echo '<div class="avatar lg"></div>';
	echo '<div><div class="title">'.htmlspecialchars($user['full_name']).'</div><div>'.htmlspecialchars($user['e_mail']).'</div><button class="btn">Edit profile</button></div>';
	echo '</div></section>';
	echo '<section class="panel"><h2>Your subjects</h2><ul class="list">';
	foreach ($subjects as $s) echo '<li><a class="link" href="app.php?route=teacher/subject&sid='.$s['subject_id'].'">'.htmlspecialchars($s['subject_name']).'</a></li>';
	echo '</ul></section>';
	echo '</main></div>';
	render_footer();
	exit;
}

// Teacher: cards
if ($route === 'teacher/cards') {
	require_login(['T']);
	$user = current_user();
	$decks = fetch_all(db()->prepare('SELECT deck_id, title, color, game_mode, date_updated FROM card_decks WHERE owner_user_id = '.$user['user_info_id'].' ORDER BY date_updated DESC'));
	render_head('Teacher • Your Cards');
	render_topnav();
	echo '<div class="layout">';
	render_sidebar();
	echo '<main class="content">';
	echo '<div class="toolbar"><h1>Your cards</h1><button class="btn primary" onclick="openWizard()">Create new</button></div>';
	echo '<div class="grid">';
	foreach ($decks as $d) {
		echo '<div class="deck" style="--card:#'.htmlspecialchars($d['color'] ?: '0ea5e9').'"><div class="deck-title">'.htmlspecialchars($d['title']).'</div><div class="deck-meta">'.htmlspecialchars($d['game_mode']).' · '.htmlspecialchars($d['date_updated']).'</div><div class="deck-actions"><a class="btn small" href="app.php?route=deck/edit&did='.$d['deck_id'].'">Edit</a></div></div>';
	}
	echo '</div>';
	echo '</main></div>';
	echo '<div id="wizard" class="modal hidden"><div class="modal-card"><div id="wizStep"></div><div class="modal-actions"><button class="btn" onclick="prevStep()">Back</button><button class="btn primary" onclick="nextStep()">Next</button><button class="btn" onclick="closeWizard()">Close</button></div></div></div>';
	echo '<script>'; echo file_get_contents(__DIR__ . '/wizard.js'); echo '</script>';
	render_footer();
	exit;
}

// Teacher: recent
if ($route === 'teacher/recent') {
    require_login(['T']); $user=current_user();
    $recent = fetch_all((function() use ($user){$stmt=db()->prepare('SELECT d.deck_id, d.title, d.color, rd.accessed_at FROM recent_decks rd JOIN card_decks d ON d.deck_id=rd.deck_id WHERE rd.user_id=? ORDER BY rd.accessed_at DESC LIMIT 50');$stmt->bind_param('i',$user['user_info_id']);return $stmt;})());
    render_head('Teacher • Recent'); render_topnav(); echo '<div class="layout">'; render_sidebar(); echo '<main class="content">';
    echo '<h1>Recent decks</h1><div class="grid">'; foreach($recent as $d){ echo '<div class="deck" style="--card:#'.htmlspecialchars($d['color'] ?: '0ea5e9').'"><div class="deck-title">'.htmlspecialchars($d['title']).'</div><div class="deck-meta">'.htmlspecialchars($d['accessed_at']).'</div><div class="deck-actions"><a class="btn small" href="app.php?route=deck/edit&did='.$d['deck_id'].'">Open</a></div></div>'; } echo '</div>';
    echo '</main></div>'; render_footer(); exit;
}

// Teacher: settings (placeholder)
if ($route === 'teacher/settings') {
    require_login(['T']); $user=current_user();
    if($_SERVER['REQUEST_METHOD']==='POST'){
        $name=trim($_POST['full_name']??$user['full_name']); $contact=trim($_POST['contact_no']??($user['contact_no']??''));
        $stmt=db()->prepare('UPDATE user_info SET full_name=?, contact_no=?, date_updated=NOW() WHERE user_info_id=?'); $stmt->bind_param('ssi',$name,$contact,$user['user_info_id']); $stmt->execute();
        $_SESSION['user']['full_name']=$name; $_SESSION['user']['contact_no']=$contact; header('Location: app.php?route=teacher/settings'); exit;
    }
    render_head('Teacher • Settings'); render_topnav(); echo '<div class="layout">'; render_sidebar(); echo '<main class="content">';
    echo '<h1>Settings</h1><form class="panel" method="post"><label>Full name<input type="text" name="full_name" value="'.htmlspecialchars($user['full_name']).'" required></label><label>Contact no.<input type="text" name="contact_no" value="'.htmlspecialchars($user['contact_no']??'').'"></label><button class="btn">Save</button></form>';
    echo '</main></div>'; render_footer(); exit;
}

// Teacher: subjects list and create
if ($route === 'teacher/subjects') {
	require_login(['T']);
	$user = current_user();
	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subject_name'])) {
		$name = trim($_POST['subject_name']);
		$photo = trim($_POST['subject_photo_url'] ?? '');
		$code = substr(bin2hex(random_bytes(4)), 0, 8);
		$stmt = db()->prepare('INSERT INTO subjects (owner_teacher_user_id, subject_name, subject_photo_url, subject_code, date_created, date_updated) VALUES (?, ?, ?, ?, NOW(), NOW())');
		$stmt->bind_param('isss', $user['user_info_id'], $name, $photo, $code);
		$stmt->execute();
		header('Location: app.php?route=teacher/subjects');
		exit;
	}
	$subjects = fetch_all(db()->prepare('SELECT subject_id, subject_name, subject_code FROM subjects WHERE owner_teacher_user_id = '.$user['user_info_id'].' ORDER BY date_created DESC'));
	render_head('Teacher • Your Subjects');
	render_topnav();
	echo '<div class="layout">';
	render_sidebar();
	echo '<main class="content"><div class="toolbar"><h1>Your subjects</h1><button class="btn" onclick="document.getElementById(\'addSub\').classList.remove(\'hidden\')">Add subject</button></div>';
	echo '<ul class="list">';
	foreach ($subjects as $s) echo '<li><a class="link" href="app.php?route=teacher/subject&sid='.$s['subject_id'].'">'.htmlspecialchars($s['subject_name']).'</a> <span class="badge">Code: '.htmlspecialchars($s['subject_code']).'</span></li>';
	echo '</ul>';
	echo '</main></div>';
	echo '<div id="addSub" class="modal hidden"><div class="modal-card"><h3>Add subject</h3><form method="post"><label>Name<input type="text" name="subject_name" required></label><label>Photo URL (optional)<input type="url" name="subject_photo_url"></label><div class="modal-actions"><button class="btn" type="button" onclick="this.closest(\'.modal\').classList.add(\'hidden\')">Cancel</button><button class="btn primary" type="submit">Create</button></div></form></div></div>';
	render_footer();
	exit;
}

// Teacher: subject detail (upload decks, enroll requests, analytics)
if ($route === 'teacher/subject') {
	require_login(['T']);
	$user = current_user();
	$sid = (int)($_GET['sid'] ?? 0);
	$subject = fetch_one((function() use ($sid, $user){ $stmt=db()->prepare('SELECT * FROM subjects WHERE subject_id=? AND owner_teacher_user_id = ?'); $stmt->bind_param('ii',$sid,$user['user_info_id']); return $stmt; })());
	if (!$subject) { header('HTTP/1.1 404 Not Found'); echo 'Subject not found'; exit; }
	// handle enrollment accept/decline
	if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['enrollment_id'], $_POST['action'])) {
		$eid=(int)$_POST['enrollment_id']; $action=$_POST['action']==='accept'?'ACCEPTED':'DECLINED';
		$stmt=db()->prepare('UPDATE enrollments SET status=? WHERE enrollment_id=? AND subject_id=?');
		$stmt->bind_param('sii',$action,$eid,$sid); $stmt->execute();
		header('Location: app.php?route=teacher/subject&sid='.$sid); exit;
	}
	$pending = fetch_all((function() use ($sid){ $stmt=db()->prepare('SELECT e.enrollment_id, u.full_name FROM enrollments e JOIN user_info u ON u.user_info_id=e.student_user_id WHERE e.subject_id=? AND e.status="PENDING"'); $stmt->bind_param('i',$sid); return $stmt; })());
	$enrolled = fetch_all((function() use ($sid){ $stmt=db()->prepare('SELECT e.enrollment_id, u.full_name FROM enrollments e JOIN user_info u ON u.user_info_id=e.student_user_id WHERE e.subject_id=? AND e.status="ACCEPTED"'); $stmt->bind_param('i',$sid); return $stmt; })());
	$subjectDecks = fetch_all((function() use ($sid){ $stmt=db()->prepare('SELECT sd.id, d.title FROM subject_decks sd JOIN card_decks d ON d.deck_id=sd.deck_id WHERE sd.subject_id=?'); $stmt->bind_param('i',$sid); return $stmt; })());
	render_head('Teacher • Subject');
	render_topnav();
	echo '<div class="layout">';
	render_sidebar();
	echo '<main class="content">';
	echo '<h1>'.htmlspecialchars($subject['subject_name']).'</h1>';
	echo '<section class="panel"><h2>Upload deck to subject</h2><form method="post" action="app.php?route=subject/upload">';
	echo '<input type="hidden" name="subject_id" value="'.$sid.'">';
	echo '<label>Choose one of your decks<select name="deck_id">';
	$myDecks = fetch_all(db()->prepare('SELECT deck_id, title FROM card_decks WHERE owner_user_id='.$user['user_info_id'].' ORDER BY title'));
	foreach ($myDecks as $d) echo '<option value="'.$d['deck_id'].'">'.htmlspecialchars($d['title']).'</option>';
	echo '</select></label><button class="btn" type="submit">Upload</button></form></section>';
	echo '<section class="panel"><h2>Decks in this subject</h2><ul class="list">';
	foreach ($subjectDecks as $sd) echo '<li>'.htmlspecialchars($sd['title']).'</li>';
	echo '</ul></section>';
	echo '<section class="panel"><h2>Enrollment requests</h2>';
	if (!$pending) echo '<div class="muted">No pending requests</div>';
	foreach ($pending as $p) {
		echo '<form method="post" class="row"><div>'.htmlspecialchars($p['full_name']).'</div>';
		echo '<input type="hidden" name="enrollment_id" value="'.$p['enrollment_id'].'">';
		echo '<button class="btn small" name="action" value="accept">Accept</button>';
		echo '<button class="btn small" name="action" value="decline">Decline</button></form>';
	}
	echo '</section>';
	echo '<section class="panel"><h2>Enrolled students</h2><ul class="list">';
	foreach ($enrolled as $en) echo '<li>'.htmlspecialchars($en['full_name']).'</li>';
	echo '</ul></section>';
	echo '</main></div>';
	render_footer();
	exit;
}

// Subject deck upload handler
if ($route === 'subject/upload') {
	require_login(['T']);
	$user=current_user();
	if ($_SERVER['REQUEST_METHOD']==='POST'){
		$subject_id=(int)($_POST['subject_id']??0);
		$deck_id=(int)($_POST['deck_id']??0);
		// ensure subject ownership
		$ok=fetch_one((function() use ($subject_id,$user){$stmt=db()->prepare('SELECT subject_id FROM subjects WHERE subject_id=? AND owner_teacher_user_id=?');$stmt->bind_param('ii',$subject_id,$user['user_info_id']);return $stmt;})());
		if($ok){$stmt=db()->prepare('INSERT INTO subject_decks (subject_id, deck_id) VALUES (?, ?)');$stmt->bind_param('ii',$subject_id,$deck_id);$stmt->execute();}
		header('Location: app.php?route=teacher/subject&sid='.$subject_id); exit;
	}
	header('Location: app.php'); exit;
}

// Deck edit
if ($route === 'deck/edit') {
	require_login(['T','S']);
	$user=current_user();
	$did=(int)($_GET['did']??0);
	$deck=fetch_one((function() use ($did,$user){$stmt=db()->prepare('SELECT * FROM card_decks WHERE deck_id=? AND owner_user_id=?');$stmt->bind_param('ii',$did,$user['user_info_id']);return $stmt;})());
	if(!$deck){header('HTTP/1.1 404 Not Found');echo 'Deck not found';exit;}
	if($_SERVER['REQUEST_METHOD']==='POST'){
		if(isset($_POST['add_card'])){
			$front=trim($_POST['front']??'');$back=trim($_POST['back']??'');
			$ord=(int)(($_POST['order_index']??0));
			$stmt=db()->prepare('INSERT INTO cards (deck_id, front_text, back_text, order_index) VALUES (?, ?, ?, ?)');
			$stmt->bind_param('issi',$did,$front,$back,$ord);$stmt->execute();
		}
		if(isset($_POST['delete_card_id'])){
			$cid=(int)$_POST['delete_card_id'];
			$stmt=db()->prepare('DELETE FROM cards WHERE card_id=? AND deck_id=?');$stmt->bind_param('ii',$cid,$did);$stmt->execute();
		}
		if(isset($_POST['title'])){
			$title=trim($_POST['title']);$color=trim($_POST['color']);$mode=trim($_POST['game_mode']);
			$stmt=db()->prepare('UPDATE card_decks SET title=?, color=?, game_mode=?, date_updated=NOW() WHERE deck_id=?');
			$stmt->bind_param('sssi',$title,$color,$mode,$did);$stmt->execute();
		}
		header('Location: app.php?route=deck/edit&did='.$did); exit;
	}
	$cards=fetch_all((function() use ($did){$stmt=db()->prepare('SELECT * FROM cards WHERE deck_id=? ORDER BY order_index ASC, card_id ASC');$stmt->bind_param('i',$did);return $stmt;})());
	// record as recent deck for current user
	$stmtR=db()->prepare('INSERT INTO recent_decks (user_id, deck_id, accessed_at) VALUES (?, ?, NOW()) ON DUPLICATE KEY UPDATE accessed_at=NOW()');
	$stmtR->bind_param('ii',$user['user_info_id'],$did); $stmtR->execute();
	render_head('Edit deck • '.htmlspecialchars($deck['title']));
	render_topnav();
	echo '<div class="layout">';render_sidebar();echo '<main class="content">';
	echo '<h1>Edit deck</h1>';
	echo '<form class="panel" method="post"><div class="row"><label>Title<input type="text" name="title" value="'.htmlspecialchars($deck['title']).'" required></label><label>Color<input type="text" name="color" value="'.htmlspecialchars($deck['color']).'" placeholder="e.g., 0ea5e9"></label><label>Game mode<select name="game_mode"><option '.($deck['game_mode']==='classic'?'selected':'').' value="classic">Classic</option><option '.($deck['game_mode']==='quiz'?'selected':'').' value="quiz">Quiz</option></select></label><button class="btn" type="submit">Save</button></div></form>';
	echo '<section class="panel"><h2>Cards</h2>';
	echo '<table class="table"><thead><tr><th>#</th><th>Front</th><th>Back</th><th>Actions</th></tr></thead><tbody>';
	foreach($cards as $i=>$c){
		echo '<tr><td>'.($i+1).'</td><td>'.htmlspecialchars($c['front_text']).'</td><td>'.htmlspecialchars($c['back_text']).'</td><td><form method="post" style="display:inline"><input type="hidden" name="delete_card_id" value="'.$c['card_id'].'"><button class="btn small danger">Delete</button></form></td></tr>';
	}
	echo '</tbody></table>';
	echo '<form class="row" method="post"><input type="hidden" name="add_card" value="1"><label>Order<input type="number" name="order_index" value="'.(count($cards)+1).'" min="1"></label><label>Front<input type="text" name="front" required></label><label>Back<input type="text" name="back" required></label><button class="btn" type="submit">Add</button></form>';
	echo '</section>';
	echo '</main></div>'; render_footer(); exit;
}

// Student sections (mirror teacher where applicable)
if ($route === 'student/profile') {
	require_login(['S']);
	$user=current_user();
	$deckStats=fetch_all(db()->prepare('SELECT d.title, COALESCE(p.correct_count,0) correct, COALESCE(p.total_answered,0) total FROM card_decks d LEFT JOIN deck_progress p ON p.deck_id=d.deck_id AND p.user_id='.$user['user_info_id'].' WHERE d.owner_user_id='.$user['user_info_id'].' ORDER BY d.date_updated DESC'));
	render_head('Student • Profile'); render_topnav(); echo '<div class="layout">'; render_sidebar(); echo '<main class="content">';
	echo '<h1>Profile</h1><section class="panel"><div class="profile"><div class="avatar lg"></div><div><div class="title">'.htmlspecialchars($user['full_name']).'</div><div>'.htmlspecialchars($user['e_mail']).'</div><div>'.htmlspecialchars($user['course']).'</div><button class="btn">Edit profile</button></div></div></section>';
	echo '<section class="panel"><h2>Your analytics</h2><table class="table"><thead><tr><th>Deck</th><th>Correct</th><th>Total</th></tr></thead><tbody>';
	foreach($deckStats as $st){ echo '<tr><td>'.htmlspecialchars($st['title']).'</td><td>'.(int)$st['correct'].'</td><td>'.(int)$st['total'].'</td></tr>'; }
	echo '</tbody></table></section>';
	echo '</main></div>'; render_footer(); exit;
}

if ($route === 'student/cards') {
	require_login(['S']);
	$user=current_user();
	$decks = fetch_all(db()->prepare('SELECT deck_id, title, color, game_mode, date_updated FROM card_decks WHERE owner_user_id = '.$user['user_info_id'].' ORDER BY date_updated DESC'));
	render_head('Student • Your Cards'); render_topnav(); echo '<div class="layout">'; render_sidebar(); echo '<main class="content">';
	echo '<div class="toolbar"><h1>Your cards</h1><button class="btn primary" onclick="openWizard()">Create new</button></div><div class="grid">';
	foreach ($decks as $d) echo '<div class="deck" style="--card:#'.htmlspecialchars($d['color'] ?: '0ea5e9').'"><div class="deck-title">'.htmlspecialchars($d['title']).'</div><div class="deck-meta">'.htmlspecialchars($d['game_mode']).' · '.htmlspecialchars($d['date_updated']).'</div><div class="deck-actions"><a class="btn small" href="app.php?route=deck/edit&did='.$d['deck_id'].'">Edit</a></div></div>';
	echo '</div></main></div><div id="wizard" class="modal hidden"><div class="modal-card"><div id="wizStep"></div><div class="modal-actions"><button class="btn" onclick="prevStep()">Back</button><button class="btn primary" onclick="nextStep()">Next</button><button class="btn" onclick="closeWizard()">Close</button></div></div></div>';
	echo '<script>'; echo file_get_contents(__DIR__ . '/wizard.js'); echo '</script>';
	render_footer(); exit;
}

// Student: recent
if ($route === 'student/recent') {
    require_login(['S']); $user=current_user();
    $recent = fetch_all((function() use ($user){$stmt=db()->prepare('SELECT d.deck_id, d.title, d.color, rd.accessed_at FROM recent_decks rd JOIN card_decks d ON d.deck_id=rd.deck_id WHERE rd.user_id=? ORDER BY rd.accessed_at DESC LIMIT 50');$stmt->bind_param('i',$user['user_info_id']);return $stmt;})());
    render_head('Student • Recent'); render_topnav(); echo '<div class="layout">'; render_sidebar(); echo '<main class="content">';
    echo '<h1>Recent decks</h1><div class="grid">'; foreach($recent as $d){ echo '<div class="deck" style="--card:#'.htmlspecialchars($d['color'] ?: '0ea5e9').'"><div class="deck-title">'.htmlspecialchars($d['title']).'</div><div class="deck-meta">'.htmlspecialchars($d['accessed_at']).'</div><div class="deck-actions"><a class="btn small" href="app.php?route=deck/edit&did='.$d['deck_id'].'">Open</a></div></div>'; } echo '</div>';
    echo '</main></div>'; render_footer(); exit;
}

// Student: settings
if ($route === 'student/settings') {
    require_login(['S']); $user=current_user();
    if($_SERVER['REQUEST_METHOD']==='POST'){
        $name=trim($_POST['full_name']??$user['full_name']); $contact=trim($_POST['contact_no']??($user['contact_no']??'')); $course=trim($_POST['course']??($user['course']??''));
        $stmt=db()->prepare('UPDATE user_info SET full_name=?, contact_no=?, course=?, date_updated=NOW() WHERE user_info_id=?'); $stmt->bind_param('sssi',$name,$contact,$course,$user['user_info_id']); $stmt->execute();
        $_SESSION['user']['full_name']=$name; $_SESSION['user']['contact_no']=$contact; $_SESSION['user']['course']=$course; header('Location: app.php?route=student/settings'); exit;
    }
    render_head('Student • Settings'); render_topnav(); echo '<div class="layout">'; render_sidebar(); echo '<main class="content">';
    echo '<h1>Settings</h1><form class="panel" method="post"><label>Full name<input type="text" name="full_name" value="'.htmlspecialchars($user['full_name']).'" required></label><label>Contact no.<input type="text" name="contact_no" value="'.htmlspecialchars($user['contact_no']??'').'"></label><label>Course<input type="text" name="course" value="'.htmlspecialchars($user['course']??'').'"></label><button class="btn">Save</button></form>';
    echo '</main></div>'; render_footer(); exit;
}

if ($route === 'student/subjects') {
	require_login(['S']); $user=current_user();
	if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['subject_code'])){
		$code=trim($_POST['subject_code']);
		$subject=fetch_one((function() use ($code){$stmt=db()->prepare('SELECT subject_id FROM subjects WHERE subject_code=?');$stmt->bind_param('s',$code);return $stmt;})());
		if($subject){$sid=(int)$subject['subject_id'];$stmt=db()->prepare('INSERT INTO enrollments (subject_id, student_user_id, status, date_created) VALUES (?, ?, "PENDING", NOW())');$stmt->bind_param('ii',$sid,$user['user_info_id']);$stmt->execute();}
		header('Location: app.php?route=student/subjects'); exit;
	}
	$my=fetch_all((function() use ($user){$stmt=db()->prepare('SELECT s.subject_name, s.subject_id, e.status FROM enrollments e JOIN subjects s ON s.subject_id=e.subject_id WHERE e.student_user_id=? ORDER BY s.subject_name');$stmt->bind_param('i',$user['user_info_id']);return $stmt;})());
	render_head('Student • Your Subjects'); render_topnav(); echo '<div class="layout">'; render_sidebar(); echo '<main class="content">';
	echo '<div class="toolbar"><h1>Your subjects</h1><button class="btn" onclick="document.getElementById(\'enroll\').classList.remove(\'hidden\')">Add subject</button></div>';
	echo '<ul class="list">'; foreach($my as $s) echo '<li>'.htmlspecialchars($s['subject_name']).' <span class="badge">'.htmlspecialchars($s['status']).'</span></li>'; echo '</ul>';
	echo '</main></div><div id="enroll" class="modal hidden"><div class="modal-card"><h3>Enroll to subject</h3><form method="post"><label>Subject code<input type="text" name="subject_code" required></label><div class="modal-actions"><button type="button" class="btn" onclick="this.closest(\'.modal\').classList.add(\'hidden\')">Cancel</button><button class="btn primary">Send request</button></div></form></div></div>';
	render_footer(); exit;
}

if ($route === 'student/friends') {
	require_login(['S']); $user=current_user();
	render_head('Student • Friends'); render_topnav(); echo '<div class="layout">'; render_sidebar(); echo '<main class="content">';
	echo '<h1>Your friends</h1><div class="tabs"><button class="tab active" onclick="switchTab(\'friends\')">Friends</button><button class="tab" onclick="switchTab(\'search\')">Search</button><button class="tab" onclick="switchTab(\'requests\')">Requests</button></div>';
	echo '<section id="friends" class="panel tab-panel">';
	$friends=fetch_all((function() use ($user){$stmt=db()->prepare('SELECT u.user_info_id, u.full_name FROM friends f JOIN user_info u ON u.user_info_id = IF(f.user_one=?, f.user_two, f.user_one) WHERE f.user_one=? OR f.user_two=?');$stmt->bind_param('iii',$user['user_info_id'],$user['user_info_id'],$user['user_info_id']);return $stmt;})());
	if(!$friends) echo '<div class="muted">No friends yet.</div>';
	foreach($friends as $fr){ echo '<div class="row"><div>'.htmlspecialchars($fr['full_name']).'</div><div><a class="btn small" href="#">View</a> <a class="btn small" href="#">Remove</a> <a class="btn small" href="app.php?route=coop/create&uid='.$fr['user_info_id'].'">Invite to co-op</a></div></div>'; }
	echo '</section>';
	echo '<section id="search" class="panel tab-panel hidden">';
	$q=trim($_GET['q']??'');
	echo '<form class="toolbar" method="get"><input type="hidden" name="route" value="student/friends"><input class="search" name="q" placeholder="Search students" value="'.htmlspecialchars($q).'"><button class="btn">Search</button></form>';
	if($q!==''){ $results=fetch_all((function() use ($q,$user){$stmt=db()->prepare('SELECT user_info_id, full_name FROM user_info WHERE user_type="S" AND user_info_id<>? AND full_name LIKE CONCAT("%", ?, "%") ORDER BY full_name LIMIT 50');$stmt->bind_param('is',$user['user_info_id'],$q);return $stmt;})()); foreach($results as $r){ echo '<div class="row"><div>'.htmlspecialchars($r['full_name']).'</div><form method="post" action="app.php?route=friend/request"><input type="hidden" name="receiver" value="'.$r['user_info_id'].'"><button class="btn small">Add friend</button></form></div>'; } }
	echo '</section>';
	echo '<section id="requests" class="panel tab-panel hidden">';
	$reqs=fetch_all((function() use ($user){$stmt=db()->prepare('SELECT fr.fr_id, u.full_name, u.user_info_id FROM friends_requests fr JOIN user_info u ON u.user_info_id=fr.sender WHERE fr.receiver=?');$stmt->bind_param('i',$user['user_info_id']);return $stmt;})());
	if(!$reqs) echo '<div class="muted">No requests.</div>';
	foreach($reqs as $rq){ echo '<div class="row"><div>'.htmlspecialchars($rq['full_name']).'</div><form method="post" action="app.php?route=friend/act"><input type="hidden" name="fr_id" value="'.$rq['fr_id'].'"><button class="btn small" name="act" value="accept">Accept</button><button class="btn small" name="act" value="decline">Decline</button></form></div>'; }
	echo '</section>';
	echo '<script>function switchTab(id){document.querySelectorAll(".tab-panel").forEach(e=>e.classList.add("hidden"));document.getElementById(id).classList.remove("hidden");document.querySelectorAll(".tab").forEach(e=>e.classList.remove("active"));}</script>';
	echo '</main></div>'; render_footer(); exit;
}

if ($route === 'friend/request') {
	require_login(['S']); $user=current_user(); if($_SERVER['REQUEST_METHOD']==='POST'){ $recv=(int)$_POST['receiver']; $stmt=db()->prepare('INSERT INTO friends_requests (sender, receiver) VALUES (?, ?)'); $stmt->bind_param('ii',$user['user_info_id'],$recv); $stmt->execute(); } header('Location: app.php?route=student/friends'); exit;
}

if ($route === 'friend/act') {
	require_login(['S']); $user=current_user(); if($_SERVER['REQUEST_METHOD']==='POST'){ $fr=(int)$_POST['fr_id']; $act=$_POST['act']==='accept'; $req=fetch_one((function() use ($fr,$user){$stmt=db()->prepare('SELECT sender FROM friends_requests WHERE fr_id=? AND receiver=?');$stmt->bind_param('ii',$fr,$user['user_info_id']);return $stmt;})()); if($req){ if($act){ $stmt=db()->prepare('INSERT INTO friends (user_one, user_two) VALUES (?, ?)'); $stmt->bind_param('ii',$user['user_info_id'],$req['sender']); $stmt->execute(); } $stmt=db()->prepare('DELETE FROM friends_requests WHERE fr_id=?'); $stmt->bind_param('i',$fr); $stmt->execute(); } } header('Location: app.php?route=student/friends'); exit;
}

// Co-op lobby scaffold
if ($route === 'coop/create') {
	require_login(['S']); $user=current_user();
	$lobbyCode = strtoupper(substr(bin2hex(random_bytes(3)),0,6));
	$stmt=db()->prepare('INSERT INTO coop_lobbies (host_user_id, lobby_code, created_at) VALUES (?, ?, NOW())'); $stmt->bind_param('is',$user['user_info_id'],$lobbyCode); $stmt->execute();
	$lid=db()->insert_id; $stmt=db()->prepare('INSERT INTO coop_members (lobby_id, user_id) VALUES (?, ?)'); $stmt->bind_param('ii',$lid,$user['user_info_id']); $stmt->execute();
	header('Location: app.php?route=coop/lobby&lid='.$lid); exit;
}

if ($route === 'coop/lobby') {
	require_login(['S']); $user=current_user(); $lid=(int)($_GET['lid']??0);
	$lobby=fetch_one((function() use ($lid){$stmt=db()->prepare('SELECT * FROM coop_lobbies WHERE lobby_id=?');$stmt->bind_param('i',$lid);return $stmt;})());
	$members=fetch_all((function() use ($lid){$stmt=db()->prepare('SELECT u.full_name FROM coop_members m JOIN user_info u ON u.user_info_id=m.user_id WHERE m.lobby_id=?');$stmt->bind_param('i',$lid);return $stmt;})());
	render_head('Co-op Lobby'); render_topnav(); echo '<div class="layout">'; render_sidebar(); echo '<main class="content">';
	echo '<h1>Co-op Lobby</h1><div class="panel"><div>Lobby code: <strong>'.htmlspecialchars($lobby['lobby_code']??'').'</strong></div><div>Members:</div><ul class="list">'; foreach($members as $m) echo '<li>'.htmlspecialchars($m['full_name']).'</li>'; echo '</ul><div class="row"><label>Upload deck<select><option>Choose a deck...</option></select></label><button class="btn">Start game</button></div><div class="muted">Scoreboard will update live here.</div></div>';
	echo '</main></div>'; render_footer(); exit;
}

// Document to flashcards conversion stub (placeholder)
if ($route === 'api/convert' && $_SERVER['REQUEST_METHOD']==='POST') {
	header('Content-Type: application/json'); echo json_encode(['status'=>'ok','cards'=>[['front'=>'Sample Q1','back'=>'Sample A1'],['front'=>'Sample Q2','back'=>'Sample A2']]]); exit;
}

// Fallback
header('Location: app.php?route=login');
exit;


