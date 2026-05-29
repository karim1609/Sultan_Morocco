{{-- ═══════════════════════════════════════════════════════════════════
     Sultan Hybrid Chatbot  —  rule-based + OpenAI fallback
     Usage:  <x-chatbot />  (add once before </body> on any page)
═══════════════════════════════════════════════════════════════════ --}}

<style>
/* ── Animations ─────────────────────────────────────────────────── */
@keyframes cb-slide-up   { from{opacity:0;transform:translateY(24px) scale(.96)} to{opacity:1;transform:translateY(0) scale(1)} }
@keyframes cb-slide-down { from{opacity:1;transform:translateY(0) scale(1)} to{opacity:0;transform:translateY(24px) scale(.96)} }
@keyframes cb-bounce-in  { 0%{opacity:0;transform:translateY(10px)} 60%{transform:translateY(-4px)} 100%{opacity:1;transform:translateY(0)} }
@keyframes cb-dot        { 0%,80%,100%{transform:translateY(0)} 40%{transform:translateY(-5px)} }
@keyframes cb-shake      { 0%,100%{transform:rotate(0)} 20%{transform:rotate(-12deg)} 40%{transform:rotate(12deg)} 60%{transform:rotate(-8deg)} 80%{transform:rotate(8deg)} }
@keyframes cb-pulse-ring { 0%{box-shadow:0 0 0 0 rgba(0,38,26,.45)} 70%{box-shadow:0 0 0 12px rgba(0,38,26,0)} 100%{box-shadow:0 0 0 0 rgba(0,38,26,0)} }
@keyframes cb-card-in    { from{opacity:0;transform:translateY(8px)} to{opacity:1;transform:translateY(0)} }

/* ── FAB ────────────────────────────────────────────────────────── */
#cb-fab {
    position:fixed; bottom:24px; right:24px; z-index:9998;
    width:56px; height:56px; border-radius:50%;
    background:linear-gradient(135deg,#00261a,#0f3d2e);
    border:none; cursor:pointer;
    display:flex; align-items:center; justify-content:center;
    box-shadow:0 6px 24px rgba(0,38,26,.42),0 2px 8px rgba(0,0,0,.16);
    transition:transform .25s cubic-bezier(.22,1,.36,1),box-shadow .25s;
    animation:cb-pulse-ring 2.8s ease-in-out 1.5s 3;
}
#cb-fab:hover { transform:scale(1.1); box-shadow:0 10px 32px rgba(0,38,26,.48); }
#cb-fab svg  { transition:transform .3s; }
#cb-fab.open svg.icon-chat { display:none; }
#cb-fab.open svg.icon-close { display:block !important; }
#cb-badge {
    position:absolute; top:-4px; right:-4px;
    width:20px; height:20px; border-radius:50%;
    background:#e11d48; color:#fff; font-size:10px; font-weight:800;
    display:flex; align-items:center; justify-content:center;
    border:2px solid #fff; box-shadow:0 2px 6px rgba(225,29,72,.4);
    transition:transform .2s; display:none;
}

/* ── Chat window ─────────────────────────────────────────────────── */
#cb-window {
    position:fixed; bottom:90px; right:24px; z-index:9997;
    width:370px; height:560px; max-height:calc(100vh - 120px);
    border-radius:20px; overflow:hidden;
    background:#fcf9f4;
    box-shadow:0 28px 60px rgba(0,0,0,.22),0 8px 20px rgba(0,0,0,.1);
    border:1px solid rgba(0,0,0,.07);
    display:flex; flex-direction:column;
    transform-origin:bottom right;
    transition:transform .35s cubic-bezier(.22,1,.36,1),opacity .28s ease;
    transform:scale(.82) translateY(12px); opacity:0; pointer-events:none;
}
#cb-window.open { transform:scale(1) translateY(0); opacity:1; pointer-events:all; }

/* ── Header ──────────────────────────────────────────────────────── */
#cb-header {
    background:linear-gradient(135deg,#00261a 0%,#0f3d2e 100%);
    padding:14px 16px; display:flex; align-items:center; gap:10px; flex-shrink:0;
}
#cb-avatar {
    width:36px; height:36px; border-radius:50%; flex-shrink:0;
    background:rgba(255,255,255,.14); border:2px solid rgba(255,255,255,.25);
    display:flex; align-items:center; justify-content:center; font-size:18px;
}
.cb-online-dot {
    width:8px; height:8px; border-radius:50%; background:#4ade80;
    box-shadow:0 0 6px #4ade80; flex-shrink:0;
}
#cb-close-btn {
    width:28px; height:28px; border-radius:50%; border:none; cursor:pointer;
    background:rgba(255,255,255,.12); color:#fff;
    display:flex; align-items:center; justify-content:center; font-size:18px; line-height:1;
    transition:background .2s; margin-left:auto;
}
#cb-close-btn:hover { background:rgba(255,255,255,.22); }

/* ── Messages ────────────────────────────────────────────────────── */
#cb-messages {
    flex:1; overflow-y:auto; padding:14px 14px 8px;
    scrollbar-width:thin; scrollbar-color:#c0c8c3 transparent;
    scroll-behavior:smooth;
}
#cb-messages::-webkit-scrollbar { width:4px; }
#cb-messages::-webkit-scrollbar-thumb { background:#c0c8c3; border-radius:4px; }

/* ── Message bubbles ─────────────────────────────────────────────── */
.cb-row { display:flex; margin-bottom:12px; animation:cb-bounce-in .32s cubic-bezier(.22,1,.36,1) both; }
.cb-row.user  { justify-content:flex-end; }
.cb-row.bot   { align-items:flex-end; gap:8px; }
.cb-bot-avatar {
    width:28px; height:28px; border-radius:50%; flex-shrink:0;
    background:linear-gradient(135deg,#00261a,#0f3d2e);
    display:flex; align-items:center; justify-content:center;
    font-size:13px; font-weight:700; color:#fff;
    box-shadow:0 2px 6px rgba(0,38,26,.3);
}
.cb-bubble-user {
    max-width:78%; padding:10px 14px;
    border-radius:18px 18px 4px 18px;
    background:linear-gradient(135deg,#00261a,#0f3d2e);
    color:#fff; font-size:13px; line-height:1.5;
    box-shadow:0 3px 10px rgba(0,38,26,.22);
    font-family:'Inter',sans-serif;
}
.cb-bubble-bot {
    max-width:88%; padding:10px 14px;
    border-radius:18px 18px 18px 4px;
    background:#fff; border:1px solid rgba(0,0,0,.07);
    color:#1c1c19; font-size:13px; line-height:1.6;
    box-shadow:0 2px 8px rgba(0,0,0,.06);
    font-family:'Inter',sans-serif;
}
.cb-bubble-bot strong { font-weight:700; color:#00261a; }

/* ── Cards grid ──────────────────────────────────────────────────── */
.cb-cards { display:grid; grid-template-columns:1fr 1fr; gap:8px; max-width:310px; }
.cb-card {
    border-radius:12px; overflow:hidden; background:#fff;
    border:1px solid rgba(0,0,0,.07);
    box-shadow:0 2px 8px rgba(0,0,0,.07);
    cursor:pointer; animation:cb-card-in .35s ease both;
    transition:transform .22s cubic-bezier(.22,1,.36,1), box-shadow .22s;
}
.cb-card:hover { transform:translateY(-4px) scale(1.02); box-shadow:0 10px 24px rgba(0,0,0,.14); }
.cb-card-img  { width:100%; height:80px; object-fit:cover; display:block; transition:transform .4s; }
.cb-card:hover .cb-card-img { transform:scale(1.07); }
.cb-card-body { padding:7px 8px 9px; }
.cb-card-tag  {
    display:inline-block; padding:2px 7px; border-radius:20px; margin-bottom:4px;
    background:#00261a; color:#fff; font-size:9px; font-weight:700; text-transform:uppercase; letter-spacing:.04em;
}
.cb-card-name { font-family:'Noto Serif',serif; font-size:11px; font-weight:700; color:#1c1c19; margin-bottom:2px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.cb-card-loc  { font-size:9px; color:#717974; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; margin-bottom:5px; }
.cb-card-foot { display:flex; align-items:center; justify-content:space-between; }
.cb-card-rating { background:#00261a; color:#fff; font-size:9px; font-weight:800; padding:2px 5px; border-radius:5px; }
.cb-card-btn {
    font-size:9px; font-weight:700; color:#fff;
    background:linear-gradient(135deg,#00261a,#0f3d2e);
    padding:3px 8px; border-radius:20px; text-decoration:none;
    transition:opacity .15s;
}
.cb-card-btn:hover { opacity:.82; }

/* ── Quick buttons ───────────────────────────────────────────────── */
.cb-options { display:flex; flex-wrap:wrap; gap:5px; margin-top:8px; }
.cb-opt-btn {
    padding:5px 11px; border-radius:20px;
    border:1.5px solid #00261a; background:#fff; color:#00261a;
    font-size:11px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif;
    transition:all .18s; white-space:nowrap;
}
.cb-opt-btn:hover { background:#00261a; color:#fff; }

/* ── Typing indicator ────────────────────────────────────────────── */
#cb-typing { display:none; margin-bottom:12px; }
#cb-typing.show { display:flex; align-items:flex-end; gap:8px; }
.cb-typing-bubble {
    padding:10px 14px; border-radius:18px 18px 18px 4px;
    background:#fff; border:1px solid rgba(0,0,0,.07); display:flex; gap:5px; align-items:center;
}
.cb-dot { width:7px; height:7px; border-radius:50%; background:#c0c8c3; }
.cb-dot:nth-child(1) { animation:cb-dot 1.2s ease-in-out infinite 0ms; }
.cb-dot:nth-child(2) { animation:cb-dot 1.2s ease-in-out infinite 200ms; }
.cb-dot:nth-child(3) { animation:cb-dot 1.2s ease-in-out infinite 400ms; }

/* ── Quick suggestions bar ───────────────────────────────────────── */
#cb-suggestions {
    padding:0 12px 10px; flex-shrink:0;
    border-top:1px solid rgba(0,0,0,.05); background:#fcf9f4;
}
#cb-suggestions p { font-size:10px; color:#a0a09a; margin:8px 0 5px; font-family:'Inter',sans-serif; }
.cb-sug-scroll { display:flex; gap:5px; overflow-x:auto; scrollbar-width:none; padding-bottom:2px; }
.cb-sug-scroll::-webkit-scrollbar { display:none; }
.cb-sug-btn {
    padding:5px 12px; border-radius:20px; border:1.5px solid rgba(0,38,26,.35);
    background:rgba(0,38,26,.05); color:#00261a; font-size:11px; font-weight:600;
    cursor:pointer; white-space:nowrap; font-family:'Inter',sans-serif;
    transition:all .18s; flex-shrink:0;
}
.cb-sug-btn:hover { background:#00261a; color:#fff; border-color:#00261a; }

/* ── Input row ───────────────────────────────────────────────────── */
#cb-input-row {
    display:flex; gap:8px; align-items:flex-end; padding:10px 12px 14px;
    background:#fff; border-top:1px solid rgba(0,0,0,.07); flex-shrink:0;
}
#cb-input {
    flex:1; border:1.5px solid #e5e2dd; border-radius:20px; padding:9px 14px;
    font-size:13px; color:#1c1c19; background:#f6f3ee; outline:none;
    font-family:'Inter',sans-serif; resize:none; max-height:80px; line-height:1.4;
    transition:border-color .2s;
}
#cb-input:focus { border-color:#00261a; }
#cb-send {
    width:38px; height:38px; border-radius:50%; flex-shrink:0; border:none; cursor:pointer;
    background:linear-gradient(135deg,#00261a,#0f3d2e); color:#fff;
    display:flex; align-items:center; justify-content:center;
    box-shadow:0 3px 10px rgba(0,38,26,.3);
    transition:transform .18s,opacity .18s;
}
#cb-send:hover { transform:scale(1.1); }
#cb-send:disabled { opacity:.4; transform:none; cursor:default; background:#c0c8c3; box-shadow:none; }

/* ── Mobile ──────────────────────────────────────────────────────── */
@media(max-width:420px) {
    #cb-window { width:calc(100vw - 16px); right:8px; bottom:80px; }
}
</style>

{{-- ── FAB ──────────────────────────────────────────────────────────── --}}
<button id="cb-fab" aria-label="Open Sultan chatbot">
    <span id="cb-badge">1</span>
    <svg class="icon-chat" width="26" height="26" viewBox="0 0 24 24" fill="#fff">
        <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/>
    </svg>
    <svg class="icon-close" width="22" height="22" viewBox="0 0 24 24" fill="#fff" style="display:none">
        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
    </svg>
</button>

{{-- ── Chat window ──────────────────────────────────────────────────── --}}
<div id="cb-window" role="dialog" aria-label="Sultan travel chatbot">

    {{-- Header --}}
    <div id="cb-header">
        <div id="cb-avatar">🌟</div>
        <div style="flex:1;min-width:0;">
            <p style="font-family:'Noto Serif',serif;font-size:15px;font-weight:700;color:#fff;margin:0;line-height:1.2;">Sultan</p>
            <p style="font-size:11px;color:rgba(255,255,255,.7);margin:0;">Morocco & Spain Travel Guide</p>
        </div>
        <div class="cb-online-dot"></div>
        <span style="font-size:10px;color:rgba(255,255,255,.55);margin-right:6px;font-family:'Inter',sans-serif;">Online</span>
        <button id="cb-close-btn" aria-label="Close chat">×</button>
    </div>

    {{-- Messages --}}
    <div id="cb-messages">
        {{-- Typing indicator (hidden by default) --}}
        <div id="cb-typing">
            <div class="cb-bot-avatar">S</div>
            <div class="cb-typing-bubble">
                <div class="cb-dot"></div>
                <div class="cb-dot"></div>
                <div class="cb-dot"></div>
            </div>
        </div>
    </div>

    {{-- Quick suggestions (hidden after first message) --}}
    <div id="cb-suggestions">
        <p>✨ Quick suggestions:</p>
        <div class="cb-sug-scroll">
            <button class="cb-sug-btn" data-msg="🏄 Best surf spots">🏄 Surf spots</button>
            <button class="cb-sug-btn" data-msg="🍽️ Top restaurants">🍽️ Restaurants</button>
            <button class="cb-sug-btn" data-msg="🏨 Hotels in Morocco">🏨 Hotels</button>
            <button class="cb-sug-btn" data-msg="🗺️ Plan a trip">🗺️ Plan a trip</button>
            <button class="cb-sug-btn" data-msg="🌤️ Best time to visit">🌤️ Weather</button>
        </div>
    </div>

    {{-- Input --}}
    <div id="cb-input-row">
        <textarea id="cb-input" rows="1" placeholder="Ask about Morocco & Spain…" aria-label="Message input"></textarea>
        <button id="cb-send" aria-label="Send message" disabled>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
            </svg>
        </button>
    </div>
</div>

<script>
(function () {
'use strict';

/* ════════════════════════════════════════════════════════════════════
   CONFIG
════════════════════════════════════════════════════════════════════ */
var CSRF  = '{{ csrf_token() }}';
var suggestionsHidden = false;

/* ════════════════════════════════════════════════════════════════════
   INTENT DETECTION
════════════════════════════════════════════════════════════════════ */
var INTENTS = {
    greeting:    ['hello','hi','hey','bonjour','salut','marhaba','salam'],
    restaurants: ['restaurant','food','eat','dining','cafe','cuisine','tagine','couscous','meal','lunch','dinner'],
    hotels:      ['hotel','stay','accommodation','riad','resort','room','sleep','lodge'],
    surf:        ['surf','windsurf','wave','kite','kiteboard','dakhla','essaouira','tarifa'],
    itinerary:   ['trip','itinerary','plan','visit','tour','schedule','days','week','route'],
    weather:     ['weather','temperature','climate','rain','sunny','best time','when to go'],
    help:        ['help','what can','assist','capabilities'],
};

function detectIntent(msg) {
    var m = msg.toLowerCase();
    for (var intent in INTENTS) {
        var kws = INTENTS[intent];
        for (var i = 0; i < kws.length; i++) {
            if (m.indexOf(kws[i]) !== -1) return intent;
        }
    }
    return 'ai';
}

/* ════════════════════════════════════════════════════════════════════
   RULE-BASED RESPONSES
════════════════════════════════════════════════════════════════════ */
var RULES = {
    greeting: {
        type:'text',
        reply:"Marhaba! 🌟 I'm **Sultan**, your personal guide to Morocco & Spain.\n\nI can help you discover hotels, restaurants, surf spots, or plan your perfect itinerary. What are you looking for?",
        options:['🏄 Best surf spots','🍽️ Top restaurants','🏨 Hotels in Morocco','🗺️ Plan a trip'],
    },
    help: {
        type:'buttons',
        reply:"Here's everything I can help you with:",
        options:['🏄 Surf & Windsurf','🍽️ Restaurants','🏨 Hotels & Riads','🗺️ Plan itinerary','🌤️ Best time to visit','💎 Hidden gems'],
    },
    surf: {
        type:'cards',
        reply:'🏄 Top surf & windsurf destinations:',
        items:[
            {name:'Dakhla Lagoon',   location:'Dakhla, Morocco',   rating:4.9, image:'https://images.unsplash.com/photo-1502680390469-be75c86b636f?w=400&auto=format', tag:'Windsurf'},
            {name:'Essaouira Beach', location:'Essaouira, Morocco', rating:4.7, image:'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=400&auto=format', tag:'Surf'},
            {name:'Sidi Kaouki',     location:'Near Essaouira',    rating:4.6, image:'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=400&auto=format', tag:'Kite'},
            {name:'Tarifa Beach',    location:'Tarifa, Spain',     rating:4.8, image:'https://images.unsplash.com/photo-1519046904884-53103b34b206?w=400&auto=format', tag:'Windsurf'},
        ],
        options:['Best season to surf','Gear rental info','Book surf lessons'],
    },
    restaurants: {
        type:'cards',
        reply:'🍽️ Must-try restaurants in Morocco:',
        items:[
            {name:'Nomad',         location:'Marrakech Medina', rating:4.8, image:'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=400&auto=format', tag:'Moroccan'},
            {name:'Le Jardin',     location:'Marrakech',        rating:4.7, image:'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=400&auto=format', tag:'Mediterranean'},
            {name:'Nur Restaurant',location:'Fes',              rating:4.6, image:'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=400&auto=format', tag:'Fine Dining'},
            {name:"Rick's Café",   location:'Casablanca',       rating:4.5, image:'https://images.unsplash.com/photo-1466978913421-dad2ebd01d17?w=400&auto=format', tag:'Classic'},
        ],
        options:['Vegetarian options','Best street food','Rooftop restaurants'],
    },
    hotels: {
        type:'cards',
        reply:'🏨 Top-rated stays in Morocco:',
        items:[
            {name:'La Mamounia',           location:'Marrakech',        rating:4.9, image:'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=400&auto=format', tag:'Luxury'},
            {name:'Riad Yasmine',          location:'Marrakech Medina', rating:4.8, image:'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=400&auto=format', tag:'Riad'},
            {name:'Royal Mansour',         location:'Marrakech',        rating:5.0, image:'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?w=400&auto=format', tag:'Palace'},
            {name:'Sofitel Fes Palais Jamai',location:'Fes',            rating:4.7, image:'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=400&auto=format', tag:'Resort'},
        ],
        options:['Budget riads','Luxury resorts','Beach hotels'],
    },
    itinerary: {
        type:'text',
        reply:"✈️ **Suggested 5-Day Morocco Itinerary:**\n\n📅 **Day 1** — Arrive Marrakech · Explore Medina & Jemaa el-Fna\n📅 **Day 2** — Atlas Mountains day trip · Berber villages\n📅 **Day 3** — Drive to Essaouira · Surf & fresh seafood\n📅 **Day 4** — Dakhla · World-class windsurfing\n📅 **Day 5** — Casablanca · Hassan II Mosque · Departure\n\nWant me to customise this for your dates?",
        options:['Customise this trip','Hotels for this route','Best time to visit'],
    },
    weather: {
        type:'text',
        reply:"🌤️ **Best times to visit Morocco:**\n\n🌸 **Spring (Mar–May)** — Perfect weather 20–25°C, ideal for cities & Atlas\n🏄 **Summer (Jun–Aug)** — Hot inland, perfect winds for Dakhla & Essaouira\n🍂 **Autumn (Sep–Nov)** — Best overall: great surf, fewer crowds\n❄️ **Winter (Dec–Feb)** — Mild cities, Atlas skiing, Sahara magic",
        options:['Plan spring trip','Summer surf guide','Winter in the Sahara'],
    },
};

/* ════════════════════════════════════════════════════════════════════
   DOM HELPERS
════════════════════════════════════════════════════════════════════ */
var fab      = document.getElementById('cb-fab');
var win      = document.getElementById('cb-window');
var msgs     = document.getElementById('cb-messages');
var input    = document.getElementById('cb-input');
var sendBtn  = document.getElementById('cb-send');
var typingEl = document.getElementById('cb-typing');
var badge    = document.getElementById('cb-badge');
var sugg     = document.getElementById('cb-suggestions');
var isOpen   = false;
var unread   = 0;

function escHtml(s) {
    return String(s)
        .replace(/&/g,'&amp;').replace(/</g,'&lt;')
        .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

/* Markdown-lite: **bold** + newlines */
function renderText(text) {
    var escaped = escHtml(text);
    var bolded  = escaped.replace(/\*\*(.*?)\*\*/g,'<strong>$1</strong>');
    return bolded.replace(/\n/g,'<br>');
}

function scrollBottom() {
    setTimeout(function(){ msgs.scrollTop = msgs.scrollHeight; }, 50);
}

/* ════════════════════════════════════════════════════════════════════
   OPEN / CLOSE
════════════════════════════════════════════════════════════════════ */
function openChat() {
    isOpen = true;
    win.classList.add('open');
    fab.classList.add('open');
    unread = 0;
    badge.style.display = 'none';
    setTimeout(function(){ input.focus(); }, 300);
    scrollBottom();
}

function closeChat() {
    isOpen = false;
    win.classList.remove('open');
    fab.classList.remove('open');
}

fab.addEventListener('click', function(){ isOpen ? closeChat() : openChat(); });
document.getElementById('cb-close-btn').addEventListener('click', closeChat);

/* ════════════════════════════════════════════════════════════════════
   APPEND MESSAGES
════════════════════════════════════════════════════════════════════ */
function appendUserMsg(text) {
    var row = document.createElement('div');
    row.className = 'cb-row user';
    row.innerHTML = '<div class="cb-bubble-user">' + escHtml(text) + '</div>';
    msgs.insertBefore(row, typingEl);
    scrollBottom();
}

function appendBotMsg(data) {
    var row = document.createElement('div');
    row.className = 'cb-row bot';

    var content = '';

    /* Text bubble */
    if (data.reply || (data.type === 'text' && !data.items)) {
        content += '<div class="cb-bubble-bot">' + renderText(data.reply || data.content || '') + '</div>';
    }

    /* Cards */
    if (data.type === 'cards' && data.items && data.items.length) {
        if (data.reply) {
            content += '<div style="display:flex;flex-direction:column;gap:8px;">';
            content += '<div class="cb-bubble-bot">' + escHtml(data.reply) + '</div>';
            content += '<div class="cb-cards">';
        } else {
            content += '<div class="cb-cards">';
        }
        data.items.forEach(function(item, i) {
            content += '<div class="cb-card" style="animation-delay:' + (i * 70) + 'ms">';
            content += '<div style="overflow:hidden;height:80px;">';
            content += '<img class="cb-card-img" src="' + escHtml(item.image || '') + '" alt="' + escHtml(item.name) + '" loading="lazy" onerror="this.style.display=\'none\'">';
            content += '</div>';
            content += '<div class="cb-card-body">';
            content += '<span class="cb-card-tag">' + escHtml(item.tag || '') + '</span>';
            content += '<div class="cb-card-name">' + escHtml(item.name) + '</div>';
            content += '<div class="cb-card-loc">📍 ' + escHtml(item.location || '') + '</div>';
            content += '<div class="cb-card-foot">';
            content += '<span class="cb-card-rating">⭐ ' + (item.rating || '') + '</span>';
            content += '<a class="cb-card-btn" href="' + escHtml(item.url || '#') + '" target="_blank" rel="noopener">View ↗</a>';
            content += '</div>';
            content += '</div>';
            content += '</div>';
        });
        content += '</div>';
        if (data.reply) content += '</div>';
    }

    /* Buttons-only type */
    if (data.type === 'buttons' && data.reply) {
        content += '<div class="cb-bubble-bot">' + renderText(data.reply) + '</div>';
    }

    /* Quick-reply options */
    if (data.options && data.options.length) {
        content += '<div class="cb-options">';
        data.options.forEach(function(opt) {
            content += '<button class="cb-opt-btn">' + escHtml(opt) + '</button>';
        });
        content += '</div>';
    }

    row.innerHTML = '<div class="cb-bot-avatar">S</div><div style="max-width:88%;">' + content + '</div>';

    /* Wire option buttons */
    row.querySelectorAll('.cb-opt-btn').forEach(function(btn) {
        btn.addEventListener('click', function() { handleSend(btn.textContent); });
    });

    msgs.insertBefore(row, typingEl);
    scrollBottom();

    if (!isOpen) { unread++; badge.textContent = unread > 9 ? '9+' : unread; badge.style.display = 'flex'; }
}

/* ════════════════════════════════════════════════════════════════════
   TYPING INDICATOR
════════════════════════════════════════════════════════════════════ */
function showTyping()  { typingEl.classList.add('show');    msgs.appendChild(typingEl); scrollBottom(); }
function hideTyping()  { typingEl.classList.remove('show'); }

/* ════════════════════════════════════════════════════════════════════
   SEND HANDLER
════════════════════════════════════════════════════════════════════ */
function handleSend(textOverride) {
    var text = typeof textOverride === 'string' ? textOverride.trim() : input.value.trim();
    if (!text) return;
    input.value = '';
    sendBtn.disabled = true;

    /* Hide suggestions after first message */
    if (!suggestionsHidden) { sugg.style.display = 'none'; suggestionsHidden = true; }

    appendUserMsg(text);

    /* Front-end intent detection */
    var intent = detectIntent(text);

    if (intent !== 'ai' && RULES[intent]) {
        showTyping();
        setTimeout(function() {
            hideTyping();
            appendBotMsg(RULES[intent]);
        }, 600 + Math.random() * 500);
        return;
    }

    /* AI fallback */
    showTyping();
    fetch('/api/chat', {
        method: 'POST',
        headers: {
            'Content-Type':     'application/json',
            'X-CSRF-TOKEN':     CSRF,
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({ message: text }),
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        hideTyping();
        appendBotMsg(data);
    })
    .catch(function() {
        hideTyping();
        appendBotMsg({
            type: 'text',
            reply: "I'm having a little trouble connecting. Try again in a moment! 🙏",
            options: ['🏄 Surf spots', '🍽️ Restaurants', '🏨 Hotels'],
        });
    });
}

/* ════════════════════════════════════════════════════════════════════
   INPUT EVENTS
════════════════════════════════════════════════════════════════════ */
input.addEventListener('input', function() {
    sendBtn.disabled = input.value.trim() === '';
    /* Auto-grow textarea */
    input.style.height = 'auto';
    input.style.height = Math.min(input.scrollHeight, 80) + 'px';
});

input.addEventListener('keydown', function(e) {
    if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); handleSend(); }
});

sendBtn.addEventListener('click', function() { handleSend(); });

/* ════════════════════════════════════════════════════════════════════
   SUGGESTION BUTTONS
════════════════════════════════════════════════════════════════════ */
document.querySelectorAll('.cb-sug-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
        openChat();
        handleSend(btn.dataset.msg);
    });
});

/* ════════════════════════════════════════════════════════════════════
   WELCOME MESSAGE  (shown on first open)
════════════════════════════════════════════════════════════════════ */
var welcomed = false;
fab.addEventListener('click', function() {
    if (!welcomed) {
        welcomed = true;
        setTimeout(function() {
            appendBotMsg({
                type:'text',
                reply:"Marhaba! 🌟 I'm **Sultan**, your AI guide to Morocco & Spain.\n\nAsk me about surf spots, restaurants, hotels, itineraries, or anything travel-related!",
                options:['🏄 Best surf spots','🍽️ Top restaurants','🏨 Hotels in Morocco','🗺️ Plan a trip'],
            });
        }, 400);
    }
});

/* ════════════════════════════════════════════════════════════════════
   SHAKE FAB after 6 s to draw attention (first visit only)
════════════════════════════════════════════════════════════════════ */
if (!sessionStorage.getItem('cb_visited')) {
    sessionStorage.setItem('cb_visited','1');
    setTimeout(function() {
        if (!isOpen) {
            fab.style.animation = 'cb-shake .6s ease';
            setTimeout(function(){ fab.style.animation = ''; }, 700);
            /* Show badge with 1 */
            unread = 1;
            badge.textContent = '1';
            badge.style.display = 'flex';
        }
    }, 6000);
}

})();
</script>
