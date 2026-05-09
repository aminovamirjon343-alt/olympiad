<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DocSign — Новый пароль</title>
    <link href="https://fonts.bunny.net/css?family=figtree:500;600;700&display=swap" rel="stylesheet">
    <style>
        :root{--p:#4f46e5;--a:#06b6d4;--bg:#0f172a;--card:rgba(30,41,59,.8);--txt:#f1f5f9;--muted:#94a3b8;--brd:rgba(148,163,184,.15)}
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Figtree',sans-serif;min-height:100vh;display:flex;align-items:center;justify-content:center;background:var(--bg);color:var(--txt);padding:20px}
        .lang{position:fixed;top:16px;right:16px;display:flex;gap:4px;background:rgba(15,23,42,.9);border:1px solid var(--brd);border-radius:10px;padding:4px;z-index:10}
        .lang button{padding:6px 12px;border:none;background:transparent;color:var(--muted);font:600 12px Figtree,sans-serif;border-radius:8px;cursor:pointer;transition:.2s}
        .lang button.active,.lang button:hover{background:var(--p);color:#fff}
        .bg{position:fixed;inset:0;z-index:0;overflow:hidden}
        .bg::before{content:'';position:absolute;top:-50%;left:-50%;width:200%;height:200%;background:radial-gradient(ellipse at 20% 50%,rgba(79,70,229,.15) 0%,transparent 50%),radial-gradient(ellipse at 80% 20%,rgba(6,182,212,.1) 0%,transparent 50%);animation:mv 15s infinite alternate}
        @keyframes mv{0%{transform:translate(0) rotate(0)}100%{transform:translate(-5%,-5%) rotate(3deg)}}
        .pts{position:fixed;inset:0;z-index:0;pointer-events:none}
        .pt{position:absolute;width:3px;height:3px;background:rgba(129,140,248,.5);border-radius:50%;animation:flt linear infinite}
        @keyframes flt{0%{transform:translateY(100vh) scale(0);opacity:0}10%{opacity:1}90%{opacity:1}100%{transform:translateY(-10vh) scale(1);opacity:0}}
        .card{width:100%;max-width:440px;background:var(--card);backdrop-filter:blur(20px);border:1px solid var(--brd);border-radius:20px;padding:32px 28px;box-shadow:0 20px 60px rgba(0,0,0,.4);position:relative;z-index:1}
        .card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#f59e0b,var(--p),var(--a));border-radius:20px 20px 0 0}
        .logo{text-align:center;margin-bottom:20px}
        .logo img{width:56px;height:56px;border-radius:14px;margin:0 auto 10px;display:block;box-shadow:0 8px 24px rgba(79,70,229,.3)}
        .logo h1{font:800 22px Figtree,sans-serif;letter-spacing:-.5px}
        .logo h1 span{background:linear-gradient(135deg,var(--p),var(--a));-webkit-background-clip:text;-webkit-text-fill-color:transparent}
        .logo p{font:500 10px Figtree,sans-serif;color:var(--muted);text-transform:uppercase;letter-spacing:2px;margin-top:4px}
        .field{margin-bottom:14px}
        .field label{display:block;font:600 12px Figtree,sans-serif;color:var(--muted);margin-bottom:5px}
        .input{position:relative}
        .input input{width:100%;padding:11px 12px 11px 38px;background:rgba(15,23,42,.6);border:1px solid var(--brd);border-radius:10px;color:var(--txt);font:500 14px Figtree,sans-serif;transition:.2s;outline:none}
        .input input:focus{border-color:var(--a);box-shadow:0 0 0 3px rgba(6,182,212,.15)}
        .input svg{position:absolute;left:12px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:var(--muted);pointer-events:none}
        .eye{position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--muted);cursor:pointer;padding:3px}
        .eye:hover{color:var(--txt)}
        .btn{width:100%;padding:12px;background:linear-gradient(135deg,#f59e0b,var(--p));border:none;border-radius:10px;color:#fff;font:700 14px Figtree,sans-serif;cursor:pointer;transition:.2s;display:flex;align-items:center;justify-content:center;gap:6px}
        .btn:hover{transform:translateY(-2px);box-shadow:0 8px 25px rgba(245,158,11,.3)}
        .back{text-align:center;margin-top:16px}
        .back a{font:500 13px Figtree,sans-serif;color:var(--muted);text-decoration:none;display:inline-flex;align-items:center;gap:5px;transition:.2s}
        .back a:hover{color:var(--a)}
        .badges{display:flex;justify-content:center;gap:16px;margin-top:20px;font:600 10px Figtree,sans-serif;color:var(--muted);opacity:.8}
        .badges svg{width:12px;height:12px;color:#f59e0b}
        .copy{text-align:center;margin-top:12px;font:500 11px Figtree,sans-serif;color:rgba(148,163,184,.5)}
        .err{font:500 11px Figtree,sans-serif;color:#ef4444;margin-top:4px}
        .input input.error{border-color:#ef4444;box-shadow:0 0 0 3px rgba(239,68,68,.15)}
        .str{height:2px;border-radius:2px;background:var(--brd);margin-top:6px;overflow:hidden}
        .str span{height:100%;display:block;width:0;transition:width .2s}
        .str .w{width:25%;background:#ef4444}.str .m{width:50%;background:#f59e0b}.str .s{width:75%;background:#10b981}
        @media(max-width:480px){.card{padding:24px 16px}.logo h1{font-size:18px}}
    </style>
</head>
<body>
<div class="bg"></div><div class="pts" id="pts"></div>
<div class="lang">
    <button class="active" data-lang="ru" onclick="L('ru')">🇺 РУ</button>
    <button data-lang="tj" onclick="L('tj')">🇹🇯 TJ</button>
    <button data-lang="en" onclick="L('en')">🇬🇧 EN</button>
</div>
<div class="card">
    <div class="logo">
        <img src="https://image.qwenlm.ai/public_source/5fabf35d-788a-476d-8837-6431dd4fb2c8/1bb634345-5339-4471-924b-764b665ee39d.png" alt="DocSign">
        <h1>Doc<span>Sign</span></h1>
        <p data-i18n="sub">Сброс пароля</p>
    </div>
    <form method="POST" action="{{ route('password.store') }}" onsubmit="return S(event)">
        @csrf<input type="hidden" name="token" value="{{ $request->route('token') }}">
        <div class="field">
            <label data-i18n="l1">Email</label>
            <div class="input">
                <input type="email" name="email" id="e" placeholder="name@company.com" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
            </div>@error('email')<div class="err">{{ $message }}</div>@enderror
        </div>
        <div class="field">
            <label data-i18n="l2">Новый пароль</label>
            <div class="input">
                <input type="password" name="password" id="p" placeholder="••••••••" required autocomplete="new-password" oninput="C(this.value)">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                <button type="button" class="eye" onclick="T('p','i1')"><svg id="i1" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg></button>
            </div><div class="str"><span id="sb"></span></div>@error('password')<div class="err">{{ $message }}</div>@enderror
        </div>
        <div class="field">
            <label data-i18n="l3">Подтвердите</label>
            <div class="input">
                <input type="password" name="password_confirmation" id="p2" placeholder="••••••••" required autocomplete="new-password">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                <button type="button" class="eye" onclick="T('p2','i2')"><svg id="i2" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg></button>
            </div>@error('password_confirmation')<div class="err">{{ $message }}</div>@enderror
        </div>
        <button class="btn" id="b"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"/></svg><span data-i18n="btn">Сбросить</span></button>
    </form>
    <div class="back"><a href="{{ route('login') }}"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5"/><path d="m12 19-7-7 7-7"/></svg><span data-i18n="bk">Назад</span></a></div>
</div>
<div class="badges">
    <div><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/></svg> SSL</div>
    <div><svg viewBox="0 0 24 24" fill="currentColor"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2z"/></svg> <span data-i18n="sec">Защита</span></div>
    <div><svg viewBox="0 0 24 24" fill="currentColor"><path d="M17 3H7c-1.1 0-2 .9-2 2v16l7-3 7 3V5c0-1.1-.9-2-2-2z"/></svg> <span data-i18n="sig">ЭЦП</span></div>
</div>
<p class="copy">© {{ date('Y') }} DocSign. <span data-i18n="cp">Все права защищены.</span></p>
<script>
    const Tl={ru:{sub:'Сброс пароля',l1:'Email',l2:'Новый пароль',l3:'Подтвердите',btn:'Сбросить',bk:'Назад',sec:'Защита',sig:'ЭЦП',cp:'Все права защищены.',er:'Пароли не совпадают'},tj:{sub:'Сбоси рамз',l1:'Email',l2:'Рамзи нав',l3:'Тасдиқ',btn:'Сбос',bk:'Бозгашт',sec:'Ҳифз',sig:'ЭИИ',cp:'Ҳуқуқҳо ҳифз.',er:'Рамзҳо мувофиқ нестанд'},en:{sub:'Reset Password',l1:'Email',l2:'New Password',l3:'Confirm',btn:'Reset',bk:'Back',sec:'Security',sig:'EDS',cp:'All rights reserved.',er:'Passwords do not match'}};let Lg='ru';
    function L(l){Lg=l;document.querySelectorAll('.lang button').forEach(b=>b.classList.toggle('active',b.dataset.lang===l));document.querySelectorAll('[data-i18n]').forEach(e=>{if(Tl[Lg][e.dataset.i18n])e.textContent=Tl[Lg][e.dataset.i18n]})}
    function T(id,ic){const i=document.getElementById(id),e=document.getElementById(ic);i.type=i.type==='password'?'text':'password';e.innerHTML=i.type==='text'?'<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/><line x1="1" y1="1" x2="23" y2="23"/>':'<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/>'}
    function C(v){const s=document.getElementById('sb');if(!v)s.className='';else if(v.length<6)s.className='w';else if(v.length<10)s.className='m';else s.className='s'}
    function S(e){const p=document.getElementById('p'),p2=document.getElementById('p2'),b=document.getElementById('btn');p.classList.remove('error');p2.classList.remove('error');if(p.value!==p2.value){p2.classList.add('error');alert(Tl[Lg].er);return false}b.disabled=true;b.style.opacity='.7';return true}
    (function(){const c=document.getElementById('pts');for(let i=0;i<15;i++){const d=document.createElement('div');d.className='pt';d.style.left=Math.random()*100+'%';d.style.animationDuration=(Math.random()*6+4)+'s';d.style.animationDelay=(Math.random()*3)+'s';d.style.width=d.style.height=(Math.random()*2+1)+'px';c.appendChild(d)}})();
</script>
</body>
</html>
