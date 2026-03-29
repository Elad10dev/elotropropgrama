<?php
session_start();
include "ambiente.php";

$conn = conectar();

// ✅ dominio VE
$_SESSION["seniat"] = (trim($_SERVER['HTTP_HOST']) === "ve.posup.app");

// Idioma
if (empty($_SESSION["IdiomaActual"])) $_SESSION["IdiomaActual"] = '';
if ($_SESSION["IdiomaActual"] === '') $_SESSION["IdiomaActual"] = $_COOKIE['idioma'] ?? '';

// GET autocompletar (compat)
$comercioelect = $_GET['comercio'] ?? '';
$loginGet = "";
$companyGet = "";
$passGet = "";
if (isset($_GET["login"], $_GET["Company"], $_GET["pass"])) {
  $loginGet = $_GET["login"];
  $companyGet = $_GET["Company"];
  $passGet = $_GET["pass"];
}

// Idiomas options
$IdiomasOption = "";
$IdiomasOption2 = "";
$q = "SELECT ID,Descrip,Flag FROM PosUpIdiomas ORDER BY Descrip";
if ($r = mysqli_query($conn, $q)) {
  while ($row = mysqli_fetch_assoc($r)) {
    $IdiomasOption  .= "<option value='".htmlspecialchars(trim($row['ID']),ENT_QUOTES,'UTF-8')."'>".htmlspecialchars(trim($row['Descrip']),ENT_QUOTES,'UTF-8')."</option>";
    $IdiomasOption2 .= "<option value='".htmlspecialchars(trim($row['ID']),ENT_QUOTES,'UTF-8')."'>".htmlspecialchars(trim($row['Flag']),ENT_QUOTES,'UTF-8')."</option>";
  }
  mysqli_free_result($r);
}

// Version
$VersionS = "";
$q = "SELECT VersionS FROM posup";
if ($r = mysqli_query($conn, $q)) {
  if ($row = mysqli_fetch_assoc($r)) $VersionS = $row["VersionS"];
  mysqli_free_result($r);
}

// ✅ si es VE o si viene ?comercio=... usamos comercioindex.php como hoy
if ($_SESSION["seniat"] === true) { include('comercioindex.php'); exit; }
if ($comercioelect !== '') { include('comercioindex.php'); exit; }

// helper lang() (si ya existe en tu proyecto, esto no molesta)
if (!function_exists('lang')) {
  function lang($t){ return $t; }
}
?>
<!doctype html>
<html lang="es" translate="no">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="google" content="notranslate" />
  <title>BlackbuckPOS • Login</title>

  <link rel="icon" href="/img/AZUL.png">
  <link rel="apple-touch-icon" href="/img/AZUL.png" sizes="180x180">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    :root{
      --glass: rgba(255,255,255,.10);
      --glass2: rgba(255,255,255,.08);
      --stroke: rgba(255,255,255,.18);
      --shadow: 0 20px 70px rgba(0,0,0,.40);
      --green1:#0b5d2a;
      --green2:#093d1f;
    }
    html,body{height:100%}
    body{
      font-family:Poppins,system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;
      background:
        radial-gradient(900px 600px at 10% 10%, rgba(255,255,255,.10), transparent 55%),
        radial-gradient(900px 600px at 90% 90%, rgba(255,255,255,.08), transparent 60%),
        linear-gradient(135deg, #2E7744 0%, #145c2e 45%, #0e3f22 100%);
      overflow-x:hidden;
    }
    .bubbles{position:fixed;inset:0;z-index:0;pointer-events:none;overflow:hidden;margin:0;padding:0;list-style:none}
    .bubbles li{
      position:absolute;bottom:-160px;border-radius:50%;
      background:rgba(9, 87, 3, .85);
      box-shadow:0 0 18px rgba(9, 87, 3, .55);
      animation:rise 18s infinite ease-in;
      filter:blur(.2px);
    }
    .bubbles li:nth-child(1){left:8%;width:28px;height:28px;animation-duration:22s}
    .bubbles li:nth-child(2){left:20%;width:14px;height:14px;animation-duration:17s}
    .bubbles li:nth-child(3){left:38%;width:46px;height:46px;animation-duration:26s}
    .bubbles li:nth-child(4){left:55%;width:18px;height:18px;animation-duration:19s}
    .bubbles li:nth-child(5){left:70%;width:60px;height:60px;animation-duration:30s}
    .bubbles li:nth-child(6){left:82%;width:20px;height:20px;animation-duration:21s}
    .bubbles li:nth-child(7){left:92%;width:34px;height:34px;animation-duration:28s}
    @keyframes rise{
      0%{transform:translateY(0) scale(1);opacity:.55}
      50%{opacity:.30}
      100%{transform:translateY(-1100px) scale(.35);opacity:0}
    }

    .wrap{
      min-height:100%;
      display:flex;
      align-items:center;
      justify-content:center;
      padding:28px 14px;
      position:relative;
      z-index:1;
    }
    .card-glass{
      width:100%;
      max-width:460px;
      border-radius:22px;
      background:linear-gradient(180deg,var(--glass),var(--glass2));
      border:1px solid var(--stroke);
      box-shadow:var(--shadow);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      overflow:hidden;
      transform:translateY(8px);
      animation:pop .55s ease forwards;
    }
    @keyframes pop{
      from{opacity:0;transform:translateY(22px) scale(.98)}
      to{opacity:1;transform:translateY(0) scale(1)}
    }
    .brandbar{
      padding:20px 22px 12px;
      display:flex;
      align-items:center;
      gap:12px;
    }
    .brandbar img{max-width:190px;height:auto}
    .sub{
      padding:0 22px 16px;
      color:rgba(255,255,255,.92);
      font-size:.92rem;
      line-height:1.35;
    }
    .inner{padding:18px 22px 22px}
    .form-control, .form-select{
      border-radius:14px;
      padding:12px 14px;
      border:1px solid rgba(255,255,255,.16);
      background:rgba(255,255,255,.94);
    }
    .input-group-text{
      border-radius:14px 0 0 14px;
      border:0;
      color:#fff;
      background:rgba(10, 90, 40, .92);
      padding:0 14px;
    }
    .btn-main{
      border-radius:14px;
      padding:12px 14px;
      font-weight:700;
      background:linear-gradient(135deg, #0d6efd, #0b5ed7);
      border:0;
      box-shadow:0 12px 28px rgba(0,0,0,.25);
    }
    .btn-main:hover{filter:brightness(1.05)}
    .smallmuted{color:rgba(255,255,255,.85);font-size:.85rem}
    .footerline{
      padding:12px 22px 18px;
      text-align:center;
      color:rgba(255,255,255,.85);
      font-size:.82rem;
    }
    .divider{
      height:1px;background:rgba(255,255,255,.10)
    }

    /* loader */
    #loading{
      position:fixed;inset:0;z-index:9999;
      display:none;align-items:center;justify-content:center;
      background:rgba(0,0,0,.70);
    }
    .caps{
      display:none;
      margin-top:8px;
      font-size:.85rem;
      color:#fff3cd;
    }
    .cookiebar{
      position:fixed;left:0;right:0;bottom:0;z-index:9998;
      background:rgba(33,37,41,.92);color:#fff;
      padding:16px 12px;display:none;
      border-top:1px solid rgba(255,255,255,.10);
    }
    .cookiebar a{color:#f8f9fa}

    /* ✅ transition overlay */
    #transitionOverlay{
      position:fixed; inset:0; z-index:10000;
      display:none;
      align-items:center; justify-content:center;
      background: radial-gradient(900px 500px at 20% 20%, rgba(255,255,255,.12), transparent 55%),
                  linear-gradient(135deg, #2E7744 0%, #145c2e 45%, #0e3f22 100%);
    }
    #transitionOverlay.show{ display:flex; animation:fadeIn .25s ease forwards; }
    @keyframes fadeIn{ from{opacity:0} to{opacity:1} }

    .transitionCard{
      width:min(520px, 92vw);
      border-radius:22px;
      padding:22px;
      background:rgba(255,255,255,.10);
      border:1px solid rgba(255,255,255,.18);
      backdrop-filter:blur(12px);
      box-shadow:0 24px 70px rgba(0,0,0,.45);
      text-align:center;
      color:#fff;
    }
    .progressLine{
      height:10px; border-radius:99px;
      background:rgba(255,255,255,.18);
      overflow:hidden;
      margin-top:14px;
    }
    .progressLine > div{
      height:100%;
      width:0%;
      background:rgba(255,255,255,.92);
      border-radius:99px;
      animation:loadLine .55s ease forwards;
    }
    @keyframes loadLine{ to{ width:100% } }
  </style>
</head>

<body>
<ul class="bubbles">
  <li></li><li></li><li></li><li></li><li></li><li></li><li></li>
</ul>

<div id="loading">
  <div class="text-center">
    <div class="spinner-border text-light" role="status"></div>
    <div class="mt-3 text-white">Validando credenciales…</div>
  </div>
</div>

<!-- compat GET -->
<span id="LoginForGet" class="d-none"><?php echo htmlspecialchars($loginGet,ENT_QUOTES,'UTF-8'); ?></span>
<span id="CompanyForGet" class="d-none"><?php echo htmlspecialchars($companyGet,ENT_QUOTES,'UTF-8'); ?></span>
<span id="passForGet" class="d-none"><?php echo htmlspecialchars($passGet,ENT_QUOTES,'UTF-8'); ?></span>

<div class="wrap">
  <div class="card-glass">
    <div class="brandbar">
      <img src="/img/BLANCO.png" alt="Logo">
    </div>

    <div class="sub">
      <div class="fw-semibold">Acceso seguro</div>
      <div class="opacity-75">Ingresa tu comercio, usuario y contraseña para continuar.</div>
    </div>

    <div class="divider"></div>

    <div class="inner">
      <div id="alerterror" class="alert alert-danger py-2 px-3 mb-3" style="display:none;">
        <i class="fa-solid fa-triangle-exclamation me-2"></i>
        <span id="sayerror"></span>
      </div>

      <form onsubmit="event.preventDefault(); ingresar();">
        <div class="input-group mb-3">
          <span class="input-group-text"><i class="fa-solid fa-store"></i></span>
          <input id="frontend_login_comercio" class="form-control" placeholder="ID Comercio (ej: 9999)" autocomplete="off" inputmode="numeric" autofocus>
        </div>

        <div class="input-group mb-3">
          <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
          <input id="frontend_login_email" class="form-control" placeholder="<?php echo htmlspecialchars(lang('Usuario'),ENT_QUOTES,'UTF-8'); ?>" autocomplete="username">
        </div>

        <div class="input-group mb-2">
          <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
          <input id="frontend_login_password" class="form-control" placeholder="••••••••" type="password" autocomplete="current-password">
          <button class="btn btn-light" type="button" onclick="togglePass()" style="border-radius:0 14px 14px 0;">
            <i id="eyeIcon" class="fa-regular fa-eye"></i>
          </button>
        </div>
        <div id="capsWarn" class="caps">
          <i class="fa-solid fa-lock me-2"></i>Caps Lock está activado.
        </div>

        <div class="d-flex align-items-center justify-content-between mt-3">
          <label class="d-flex align-items-center gap-2 smallmuted">
            <input type="checkbox" id="frontend_login_remember" class="form-check-input m-0">
            <?php echo htmlspecialchars(lang('Recordar'),ENT_QUOTES,'UTF-8'); ?>
          </label>

          <!-- Idioma (oculto pero funcional) -->
          <div style="display:none">
            <span id="flag" class="me-2"></span>
            <select id="Idioma" class="form-select form-select-sm" onchange="changIdioma2()">
              <?php echo $IdiomasOption; ?>
            </select>
            <select id="Idioma2" class="d-none">
              <?php echo $IdiomasOption2; ?>
            </select>
          </div>
        </div>

        <input type="hidden" id="cookieschecked" value="">

        <button class="btn btn-main w-100 mt-3" type="submit">
          <i class="fa-solid fa-right-to-bracket me-2"></i><?php echo htmlspecialchars(lang('Ingresar'),ENT_QUOTES,'UTF-8'); ?>
        </button>

        <div class="mt-3 smallmuted opacity-75">
          <i class="fa-solid fa-shield-halved me-2"></i>Conexión protegida         </div>
      </form>
    </div>

    <div class="footerline">
      BlackbuckPOS <?php echo date('Y'); ?> • &copy; <?php echo htmlspecialchars(lang('Todos los Derechos Reservados'),ENT_QUOTES,'UTF-8'); ?>
    </div>
  </div>
</div>

<div id="cookiebar" class="cookiebar">
  <div class="container d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
    <div>
      Este sitio utiliza cookies para mejorar tu experiencia. Lee la <a href="politica.html">política de privacidad</a>.
    </div>
    <div class="d-flex gap-2">
      <button class="btn btn-success btn-sm" onclick="aceptarCookies()">Sí</button>
      <button class="btn btn-danger btn-sm" onclick="negarCookies()">No</button>
    </div>
  </div>
</div>

<!-- ✅ overlay transición -->
<div id="transitionOverlay">
  <div class="transitionCard">
    <div class="fw-bold" style="font-size:1.1rem;">
      Entrando al sistema…
    </div>
    <div class="opacity-75 mt-1" style="font-size:.92rem;">
      Preparando tu sesión segura
    </div>
    <div class="progressLine"><div></div></div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  let comercio = "", login = "", password = "", idioma = "";

  // ✅ cookies helper
  function getCookie(name){
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
    return "";
  }

  function goToAppAnimated(){
    // apaga loading y muestra overlay
    try{ document.getElementById("loading").style.display = "none"; }catch(e){}
    const ov = document.getElementById("transitionOverlay");
    ov.classList.add("show");

    // ✅ delay para ver el efecto
    setTimeout(()=>{ window.location = "/app.php"; }, 2000);
  }

  function togglePass(){
    const inp = document.getElementById('frontend_login_password');
    const icon = document.getElementById('eyeIcon');
    const isPass = inp.type === 'password';
    inp.type = isPass ? 'text' : 'password';
    icon.className = isPass ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye';
  }

  // caps lock warning
  const passInput = document.getElementById('frontend_login_password');
  passInput.addEventListener('keyup', (e) => {
    const caps = e.getModifierState && e.getModifierState('CapsLock');
    document.getElementById('capsWarn').style.display = caps ? 'block' : 'none';
  });

  function changIdioma() {
    document.getElementById('Idioma2').value = document.getElementById('Idioma').value;
    const e = document.getElementById("Idioma2");
    const flagName = e.options[e.selectedIndex].text;
    document.getElementById('flag').innerHTML = '<img width="18" height="18" src="/img/' + flagName + '.png" alt="flag">';
  }

  function changIdioma2() {
    changIdioma();
    const lenguaje = document.getElementById('Idioma').value;
    $.ajax({
      type: "POST",
      url: "datahandlers/datahandleridioma.php",
      data: { lenguaje: lenguaje }
    }).done(function(){ location.reload(); });
  }

  // cookies consent
  function compruebaAceptaCookies() {
    const bar = document.getElementById('cookiebar');
    if (localStorage.aceptaCookies === 'true') {
      bar.style.display = 'none';
      document.getElementById("cookieschecked").value = '1';
      document.getElementById('frontend_login_remember').checked = true;
    } else {
      bar.style.display = 'block';
    }
  }
  function aceptarCookies() {
    localStorage.aceptaCookies = 'true';
    document.getElementById('cookiebar').style.display = 'none';
    document.getElementById("cookieschecked").value = '1';
  }
  function negarCookies() {
    localStorage.aceptaCookies = 'false';
    document.getElementById('cookiebar').style.display = 'none';
    document.getElementById("cookieschecked").value = '0';
  }

  // cargar valores recordados
  function prefill(){
    comercio  = getCookie('comercioposup');
    login     = getCookie('loginposup');
    password  = getCookie('passwposup');
    idioma    = getCookie('idioma');

    document.getElementById("frontend_login_comercio").value = comercio;
    document.getElementById("frontend_login_email").value = login;
    document.getElementById("frontend_login_password").value = password;

    // GET override
    const gLogin = document.getElementById("LoginForGet").innerHTML.trim();
    const gComp  = document.getElementById("CompanyForGet").innerHTML.trim();
    const gPass  = document.getElementById("passForGet").innerHTML.trim();
    if (gLogin !== "" && gComp !== "" && gPass !== "") {
      document.getElementById("frontend_login_comercio").value = gComp;
      document.getElementById("frontend_login_email").value = gLogin;
      document.getElementById("frontend_login_password").value = gPass;
    }

    if (idioma === '') idioma = 'ES-VE';

    <?php if ($_SESSION["IdiomaActual"] == '') { ?>
      document.getElementById("Idioma").value = idioma;
    <?php } else { ?>
      document.getElementById("Idioma").value = '<?php echo addslashes($_SESSION["IdiomaActual"]); ?>';
    <?php } ?>

    changIdioma();
  }

  // ✅ LOGIN AJAX
  function ingresar(){
    document.getElementById("loading").style.display = "flex";

    const id = document.getElementById('frontend_login_comercio').value.trim();
    const user = document.getElementById('frontend_login_email').value.trim();
    const passw = document.getElementById('frontend_login_password').value;
    const cookiessql = document.getElementById('cookieschecked').value;
    const cookiescreate = document.getElementById('frontend_login_remember').checked;
    const lenguaje = document.getElementById('Idioma').value;

    const checkeds = cookiescreate ? 'true' : 'false';

    // timestamp
    const now = new Date();
    const pad = (n)=> (n<10 ? '0'+n : n);
    const fecha = `${now.getFullYear()}-${pad(now.getMonth()+1)}-${pad(now.getDate())} ${pad(now.getHours())}:${pad(now.getMinutes())}:${pad(now.getSeconds())}`;

    $.ajax({
      type: "POST",
      url: "datahandlers/datahandlerlogin.php",
      data: {
        comercio: id,
        login: user,
        password: passw,
        cookieschecked: cookiessql,
        frontend_login_remember: checkeds,
        lenguaje: lenguaje,
        fecha: fecha
      }
    }).done(function(msg){
      if (msg !== 'failcredenciales') {
        document.getElementById('alerterror').style.display = 'none';
        ['frontend_login_password','frontend_login_email','frontend_login_comercio'].forEach(id=>{
          const el=document.getElementById(id);
          el.classList.remove('is-invalid');
          el.classList.add('is-valid');
        });
      }

      if (msg == 1) {
        if (cookiescreate === true) {
          document.cookie = "comercioposup=" + encodeURIComponent(document.getElementById('frontend_login_comercio').value) + "; path=/";
          document.cookie = "loginposup=" + encodeURIComponent(document.getElementById('frontend_login_email').value) + "; path=/";
          document.cookie = "passwposup=" + encodeURIComponent(document.getElementById('frontend_login_password').value) + "; path=/";
          document.cookie = "idioma=" + encodeURIComponent(document.getElementById('Idioma').value) + "; path=/";
        } else {
          document.cookie = "comercioposup=; Max-Age=0; path=/";
          document.cookie = "loginposup=; Max-Age=0; path=/";
          document.cookie = "passwposup=; Max-Age=0; path=/";
          document.cookie = "idioma=; Max-Age=0; path=/";
        }

        goToAppAnimated();
        return;
      }

      if (msg == 0.75) {
        document.getElementById("loading").style.display = "none";
        document.getElementById('alerterror').style.display = 'block';
        document.getElementById('sayerror').innerHTML = '<?php echo addslashes(lang('Licencia Expirada')); ?>.';
        ['frontend_login_password','frontend_login_email','frontend_login_comercio'].forEach(id=>{
          document.getElementById(id).classList.add('is-invalid');
        });
        return;
      }

      if (msg == 'failcredenciales') {
        document.getElementById("loading").style.display = "none";
        ['frontend_login_password','frontend_login_email','frontend_login_comercio'].forEach(id=>{
          document.getElementById(id).classList.add('is-invalid');
        });
        document.getElementById('alerterror').style.display = 'block';
        document.getElementById('sayerror').innerHTML = '<?php echo addslashes(lang('Acceso Denegado')); ?>.';
        return;
      }

      document.getElementById("loading").style.display = "none";
    }).fail(function(){
      document.getElementById("loading").style.display = "none";
      document.getElementById('alerterror').style.display = 'block';
      document.getElementById('sayerror').innerHTML = 'Error de red. Intenta de nuevo.';
    });
  }

  // init
  prefill();
  compruebaAceptaCookies();

  // si cambian campos, desmarca remember
  const c0 = document.getElementById("frontend_login_comercio");
  const c1 = document.getElementById("frontend_login_email");
  const c2 = document.getElementById("frontend_login_password");
  const remember = document.getElementById("frontend_login_remember");

  function offcheck(){ remember.checked = false; }
  c0.addEventListener('change', ()=> { if ((c0.value||'').trim() !== (decodeURIComponent(comercio||'')||'').trim()) offcheck(); });
  c1.addEventListener('change', ()=> { if ((c1.value||'').trim() !== (decodeURIComponent(login||'')||'').trim()) offcheck(); });
  c2.addEventListener('change', ()=> { if ((c2.value||'').trim() !== (decodeURIComponent(password||'')||'').trim()) offcheck(); });
</script>
</body>
</html>
<?php
session_destroy();
?>
