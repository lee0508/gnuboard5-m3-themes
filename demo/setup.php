<?php
// git clone 받은 사람이 자기 PC 에서 세 테마를 바로 보도록 그누보드 설치·테마 복사·예시 상품을 한 번에 준비하는 스크립트
//
// 사용:
//   php demo/setup.php                       처음 설치 (MySQL root, 비밀번호 없음 = XAMPP 기본)
//   php demo/setup.php --db-pass=1234        MySQL 비밀번호가 있을 때
//   php demo/setup.php --theme=jewelry       설치된 데모의 테마만 바꾸기 (dapanda | jewelry | medical)
//   php -S localhost:8000 -t demo/site        확인: http://localhost:8000
//
// 필요: PHP 8.0 이상(mysqli·gd 확장), MySQL 또는 MariaDB, git

const GNUBOARD_REPO   = 'https://github.com/gnuboard/gnuboard5.git';
// 테마를 만들고 시험한 그누보드 5.6.35 / 영카트 5.4.5.5.1 커밋. 다른 버전에서는 화면이 다를 수 있어 고정한다.
const GNUBOARD_COMMIT = '375a8336e8a9f136d1515a9ffb0c44dc268d9881';
const THEMES          = ['dapanda', 'jewelry', 'medical'];
const SITE_TITLES     = ['dapanda' => '다판다', 'jewelry' => '다있다 주얼리', 'medical' => 'ONCARE 의원'];

$opt = getopt('', ['db-host:', 'db-user:', 'db-pass:', 'db-name:', 'theme:', 'source:', 'admin-pass:']);
$db = [
    'host' => $opt['db-host'] ?? 'localhost',
    'user' => $opt['db-user'] ?? 'root',
    'pass' => $opt['db-pass'] ?? '',
    'name' => $opt['db-name'] ?? 'gnuboard_m3_demo',
];
$theme      = $opt['theme'] ?? 'medical';
$adminPass  = $opt['admin-pass'] ?? 'demo1234!';
$repoRoot   = dirname(__DIR__);
$site       = __DIR__ . '/site';

if (!in_array($theme, THEMES, true)) {
    fail("--theme 은 " . implode(' | ', THEMES) . " 중 하나여야 합니다. 받은 값: $theme");
}
foreach (['mysqli', 'gd'] as $ext) {
    if (!extension_loaded($ext)) fail("PHP 확장 '$ext' 가 필요합니다. php.ini 에서 extension=$ext 를 켜 주세요.");
}

$installed = is_file("$site/data/dbconfig.php");
if (!$installed) {
    step('1/5 그누보드 원본 준비');
    prepareGnuboard($site, $opt['source'] ?? null);
}
step('2/5 테마 복사');
foreach (THEMES as $t) copyDir("$repoRoot/themes/$t", "$site/theme/$t");

$link = connectDb($db);
if (!$installed) {
    step('3/5 그누보드 설치 (DB: ' . $db['name'] . ')');
    installGnuboard($site, $db, $adminPass);
    step('4/5 예시 분류·상품·배너 이미지');
    seedDemo($link, $site);
}
step("5/5 테마 적용: $theme");
$t = mysqli_real_escape_string($link, $theme);
$title = mysqli_real_escape_string($link, SITE_TITLES[$theme]);
mysqli_query($link, "UPDATE g5_config SET cf_theme='$t', cf_title='$title'") or fail(mysqli_error($link));

echo "\n완료했습니다. 아래 명령으로 띄운 뒤 http://localhost:8000 을 여세요.\n";
echo "  php -S localhost:8000 -t demo/site\n";
echo "관리자: admin / $adminPass  (테마 바꾸기: php demo/setup.php --theme=jewelry)\n";

// ---------------------------------------------------------------------------

function step(string $msg): void { echo "[setup] $msg\n"; }
function fail(string $msg): never { fwrite(STDERR, "[setup] 실패: $msg\n"); exit(1); }

function run(string $cmd): void {
    passthru($cmd, $code);
    if ($code !== 0) fail("명령 실패($code): $cmd");
}

// 공식 저장소에서 고정 커밋 하나만 받는다. --source=<폴더> 를 주면 그 폴더를 복사한다(오프라인용).
function prepareGnuboard(string $site, ?string $source): void {
    if ($source) {
        if (!is_file("$source/version.php")) fail("--source 폴더에 그누보드 version.php 가 없습니다: $source");
        copyDir($source, $site);
    } else {
        if (!is_dir($site)) mkdir($site, 0755, true);
        $s = escapeshellarg($site);
        run("git -C $s init -q");
        run("git -C $s fetch -q --depth 1 " . GNUBOARD_REPO . ' ' . GNUBOARD_COMMIT);
        run("git -C $s checkout -q FETCH_HEAD");
    }
    // data 폴더가 없으면 설치가 중간에 멈추고 테이블만 남는다
    if (!is_dir("$site/data")) mkdir("$site/data", 0707, true);
}

function connectDb(array $db): mysqli {
    mysqli_report(MYSQLI_REPORT_OFF);
    $link = @mysqli_connect($db['host'], $db['user'], $db['pass']);
    if (!$link) fail('MySQL 에 연결하지 못했습니다(' . mysqli_connect_error() . '). MySQL 이 켜져 있는지, --db-user·--db-pass 가 맞는지 확인하세요.');
    $name = mysqli_real_escape_string($link, $db['name']);
    mysqli_query($link, "CREATE DATABASE IF NOT EXISTS `$name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci") or fail(mysqli_error($link));
    mysqli_select_db($link, $db['name']);
    mysqli_set_charset($link, 'utf8mb4');
    return $link;
}

// 그누보드 설치 화면이 보내는 값과 같은 값을 넣어 install_db.php 를 그대로 실행한다
function installGnuboard(string $site, array $db, string $adminPass): void {
    $_POST = [
        'mysql_host' => $db['host'], 'mysql_user' => $db['user'], 'mysql_pass' => $db['pass'], 'mysql_db' => $db['name'],
        'table_prefix' => 'g5_', 'admin_id' => 'admin', 'admin_pass' => $adminPass, 'admin_name' => 'admin',
        'admin_email' => 'admin@example.com', 'g5_install' => 1, 'g5_shop_install' => 1, 'g5_shop_prefix' => 'yc5_',
    ];
    $_SERVER += ['HTTP_HOST' => 'localhost:8000', 'SCRIPT_NAME' => '/install/install_db.php', 'REQUEST_URI' => '/install/install_db.php', 'REMOTE_ADDR' => '127.0.0.1'];
    $cwd = getcwd();
    chdir("$site/install");
    // 설치 파일은 웹 화면용이라 header() 를 부른다. 명령줄에서는 의미가 없으므로 그 경고만 숨긴다
    set_error_handler(fn($no, $msg) => str_contains($msg, 'headers already sent'), E_WARNING);
    ob_start();
    (function () { include 'install_db.php'; })();
    $html = ob_get_clean();
    restore_error_handler();
    chdir($cwd);
    if (!is_file("$site/data/dbconfig.php")) {
        fail('그누보드 설치가 끝나지 않았습니다: ' . trim(preg_replace('/\s+/', ' ', strip_tags($html))));
    }
}

// 상품 사진은 저작권 걱정이 없도록 GD 로 그린 도형만 쓴다
function seedDemo(mysqli $l, string $site): void {
    mysqli_query($l, "SET sql_mode=''");
    foreach ([['10', '추천 상품'], ['20', '새 상품']] as [$id, $name]) {
        // 스킨·이미지 크기·목록 수를 비워 두면 list.php 에서 0 나누기 오류가 난다
        mysqli_query($l, "REPLACE INTO yc5_category SET ca_id='$id', ca_name='$name', ca_skin_dir='theme/basic', ca_mobile_skin_dir='theme/basic',
            ca_skin='list.10.skin.php', ca_mobile_skin='list.10.skin.php', ca_img_width=225, ca_img_height=225, ca_mobile_img_width=230,
            ca_mobile_img_height=230, ca_list_mod=4, ca_list_row=5, ca_mobile_list_mod=2, ca_mobile_list_row=5, ca_use=1, ca_stock_qty=99999") or fail(mysqli_error($l));
    }
    @mkdir("$site/data/item", 0707, true);
    $palette = [[[236, 240, 248], [22, 50, 92]], [[250, 241, 230], [176, 141, 87]], [[232, 246, 244], [32, 184, 173]], [[248, 236, 236], [203, 74, 0]]];
    $kinds = ['ring', 'gem', 'shirt', 'dot'];
    for ($i = 1; $i <= 8; $i++) {
        [$bg, $fg] = $palette[$i % 4];
        $file = "demo_$i.png";
        drawShape("$site/data/item/$file", 450, 450, $bg, $fg, $kinds[$i % 4]);
        $price = 19000 + $i * 7000;
        $cust = $i % 2 ? $price + 8000 : 0;
        $ca = $i <= 4 ? '10' : '20';
        [$odd, $even] = [$i % 2, ($i + 1) % 2];
        mysqli_query($l, sprintf("REPLACE INTO yc5_item SET it_id='9000000%03d', ca_id='%s', it_name='예시 상품 %d',
            it_basic='화면 확인용 예시 상품입니다. 실제 판매 상품이 아닙니다.', it_price=%d, it_cust_price=%d, it_use=1, it_stock_qty=99,
            it_img1='%s', it_type1=1, it_type2=%d, it_type3=1, it_type4=%d, it_type5=%d, it_time=NOW(), it_update_time=NOW(),
            it_explan='<p>예시 상품 설명</p>', it_order=%d", $i, $ca, $i, $price, $cust, $file, $even, $odd, $even, $i)) or fail(mysqli_error($l));
    }
    // 주얼리 테마 히어로 배너 3장 (data/common/hero_1~3.jpg)
    @mkdir("$site/data/common", 0707, true);
    foreach ([[[58, 46, 30], [176, 141, 87]], [[34, 34, 40], [232, 192, 134]], [[70, 52, 40], [210, 170, 120]]] as $n => [$bg, $fg]) {
        drawShape("$site/data/common/hero_" . ($n + 1) . '.jpg', 1200, 380, $bg, $fg, 'gem', true);
    }
}

function drawShape(string $path, int $w, int $h, array $bg, array $fg, string $kind, bool $jpg = false): void {
    $im = imagecreatetruecolor($w, $h);
    imagefill($im, 0, 0, imagecolorallocate($im, ...$bg));
    $c = imagecolorallocate($im, ...$fg);
    $cx = $jpg ? (int) ($w * 0.75) : intdiv($w, 2);
    $cy = intdiv($h, 2);
    match ($kind) {
        'ring'  => (function () use ($im, $cx, $cy, $c) { imagesetthickness($im, 14); imagearc($im, $cx, $cy, 150, 150, 0, 360, $c); })(),
        'gem'   => imagefilledpolygon($im, [$cx, $cy - 70, $cx + 60, $cy - 15, $cx, $cy + 75, $cx - 60, $cy - 15], $c),
        'shirt' => imagefilledpolygon($im, [$cx - 70, $cy - 60, $cx - 25, $cy - 75, $cx + 25, $cy - 75, $cx + 70, $cy - 60, $cx + 50, $cy - 20,
                    $cx + 35, $cy - 30, $cx + 35, $cy + 75, $cx - 35, $cy + 75, $cx - 35, $cy - 30, $cx - 50, $cy - 20], $c),
        default => imagefilledellipse($im, $cx, $cy, 150, 150, $c),
    };
    $jpg ? imagejpeg($im, $path, 85) : imagepng($im, $path);
    imagedestroy($im);
}

function copyDir(string $from, string $to): void {
    $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($from, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::SELF_FIRST);
    if (!is_dir($to)) mkdir($to, 0755, true);
    foreach ($it as $f) {
        $dest = $to . DIRECTORY_SEPARATOR . $it->getSubPathName();
        if ($f->isDir()) { if (!is_dir($dest)) mkdir($dest, 0755, true); }
        else copy($f->getPathname(), $dest);
    }
}
