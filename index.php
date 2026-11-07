<?php
/**
 * System Awansów i Punktacji - Rodzina Maciura
 * Single-file PHP Web Application
 */

// Konfiguracja Rang
$ranks = [
    1 => ['title' => 'Newbie Maciura', 'badge' => 'NEWBIE', 'color' => 'bg-slate-700 text-slate-200 border-slate-500'],
    2 => ['title' => 'Trial Maciura', 'badge' => 'TRIAL', 'color' => 'bg-amber-900/60 text-amber-300 border-amber-600', 'req_pts' => 10],
    3 => ['title' => 'Recruit Maciura', 'badge' => 'RECRUIT', 'color' => 'bg-emerald-900/60 text-emerald-300 border-emerald-500', 'req_pts' => 25, 'dept' => true],
    4 => ['title' => 'Junior Maciura', 'badge' => 'JUNIOR', 'color' => 'bg-cyan-900/60 text-cyan-300 border-cyan-500', 'req_pts' => 40],
    5 => ['title' => 'Mid Maciura', 'badge' => 'MID', 'color' => 'bg-indigo-900/60 text-indigo-300 border-indigo-500', 'req_pts' => 50],
    6 => ['title' => 'High Maciura', 'badge' => 'HIGH', 'color' => 'bg-purple-900/60 text-purple-300 border-purple-500', 'req_pts' => 75, 'board' => true]
];

// Wydziały
$departments = ["Rekru", "Bojufka", "Event team"];

// Punktacja za aktywności
$tasks = [
    ['pts' => 3, 'desc' => 'Przyjście na zebranie bądź RG', 'icon' => 'fa-users', 'category' => 'Spotkania'],
    ['pts' => 2, 'desc' => 'Wykonanie kontraktu "Metalurgia I"', 'icon' => 'fa-hammer', 'category' => 'Kontrakty'],
    ['pts' => 2, 'desc' => 'Wprowadzenie i przeprowadzenie rozmowy z nowym rekrutem', 'icon' => 'fa-user-check', 'category' => 'Rekrutacja'],
    ['pts' => 1, 'desc' => 'Danie do magazynu 50 żelaza', 'icon' => 'fa-cubes', 'category' => 'Zasoby'],
    ['pts' => 1, 'desc' => 'Włożenie do magazynu 1kg dowolnej ryby na kontrakt "Dary morza I"', 'icon' => 'fa-fish', 'category' => 'Kontrakty'],
    ['pts' => 1, 'desc' => 'Dodanie nowego członka rodziny', 'icon' => 'fa-user-plus', 'category' => 'Rekrutacja']
];
?>
<!DOCTYPE html>
<html lang="pl" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Awansów - Rodzina Maciura</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        maciura: {
                            dark: '#0B0F17',
                            card: '#151C28',
                            accent: '#F59E0B',
                            purple: '#8B5CF6'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #080B11;
            color: #E2E8F0;
            background-image: 
                radial-gradient(at 0% 0%, rgba(245, 158, 11, 0.05) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(139, 92, 246, 0.05) 0px, transparent 50%);
        }
        .glass-panel {
            background: rgba(21, 28, 40, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.07);
        }
        .glow-amber {
            box-shadow: 0 0 25px -5px rgba(245, 158, 11, 0.3);
        }
    </style>
</head>
<body class="min-h-screen pb-12 font-sans antialiased selection:bg-amber-500 selection:text-black">

    <!-- Header Navigation -->
    <header class="border-b border-slate-800/80 bg-slate-950/80 sticky top-0 z-50 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-amber-600 to-amber-400 flex items-center justify-center font-black text-slate-950 shadow-lg shadow-amber-500/20 text-xl">
                    M
                </div>
                <div>
                    <h1 class="text-xl font-extrabold tracking-wider text-white uppercase flex items-center gap-2">
                        RODZINA MACIURA
                        <span class="text-xs px-2 py-0.5 rounded bg-amber-500/10 text-amber-400 border border-amber-500/20 font-semibold tracking-normal">SYSTEM AWANSÓW</span>
                    </h1>
                    <p class="text-xs text-slate-400">Portal zarządzania rangami i punktacją</p>
                </div>
            </div>

            <!-- Banner Sobotni -->
            <div class="hidden md:flex items-center gap-3 bg-slate-900/90 border border-amber-500/30 rounded-xl px-4 py-2">
                <div class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></div>
                <div class="text-xs">
                    <div class="text-slate-400 font-medium"> najbliższe Rozdawanie Awansów:</div>
                    <div class="text-amber-400 font-bold tracking-wide" id="headerCountdown">Wczytywanie...</div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Grid -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 space-y-10">

        <!-- Banner Informacyjny o Sobotnich Awansach -->
        <section class="glass-panel rounded-2xl p-6 relative overflow-hidden border-l-4 border-l-amber-500 glow-amber">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6 relative z-10">
                <div class="space-y-2 text-center md:text-left">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/10 text-amber-400 text-xs font-semibold uppercase tracking-wider">
                        <i class="fa-regular fa-clock"></i> Oficjalny Termin
                    </div>
                    <h2 class="text-2xl font-bold text-white">Rozdawanie Awansów & Premii</h2>
                    <p class="text-slate-300 max-w-2xl text-sm leading-relaxed">
                        Wszystkie złożone wnioski punktowe są weryfikowane, a awanse oraz premie finansowe i organizacyjne rozdawane są <strong class="text-amber-400">w każdą sobotę dokładnie o godzinie 18:00</strong>.
                    </p>
                </div>
                
                <!-- Licznik Na Żywo -->
                <div class="bg-slate-950/80 border border-slate-800 rounded-xl p-4 text-center min-w-[240px] w-full md:w-auto">
                    <span class="text-xs text-slate-400 uppercase font-semibold tracking-wider block mb-1">Czas do sobota 18:00</span>
                    <div id="mainCountdown" class="text-2xl font-black text-amber-400 tracking-wider font-mono">
                        00d 00h 00m 00s
                    </div>
                </div>
            </div>
        </section>

        <!-- Wymagania i Ścieżka Awansu -->
        <section class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                        <i class="fa-solid fa-layer-group text-amber-400"></i>
                        Drabina Rang i Wymagania
                    </h2>
                    <p class="text-slate-400 text-sm">Przegląd poziomów i kryteriów niezbędnych do podniesienia rangi</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <?php
                $rankSteps = [
                    ['from' => 1, 'to' => 2, 'pts' => 10, 'extra' => null],
                    ['from' => 2, 'to' => 3, 'pts' => 25, 'extra' => 'Wydział (Rekru / Bojufka / Event team)'],
                    ['from' => 3, 'to' => 4, 'pts' => 40, 'extra' => null],
                    ['from' => 4, 'to' => 5, 'pts' => 50, 'extra' => null],
                    ['from' => 5, 'to' => 6, 'pts' => 75, 'extra' => 'Decyzja Zarządu'],
                ];

                foreach ($rankSteps as $idx => $step):
                    $rFrom = $ranks[$step['from']];
                    $rTo = $ranks[$step['to']];
                ?>
                <div class="glass-panel rounded-xl p-5 flex flex-col justify-between hover:border-amber-500/40 transition-all group">
                    <div class="space-y-4">
                        <!-- Badges ze starym i nowym poziomem -->
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-1 rounded-md text-xs font-bold border <?php echo $rFrom['color']; ?>">
                                @<?php echo $step['from']; ?> <?php echo $rFrom['badge']; ?>
                            </span>
                            <i class="fa-solid fa-arrow-right text-slate-600 group-hover:text-amber-400 transition-colors"></i>
                            <span class="px-2.5 py-1 rounded-md text-xs font-bold border <?php echo $rTo['color']; ?>">
                                @<?php echo $step['to']; ?> <?php echo $rTo['badge']; ?>
                            </span>
                        </div>

                        <!-- Opis rangi docelowej -->
                        <div>
                            <div class="text-xs text-slate-400 uppercase font-bold tracking-wider">Awans Na</div>
                            <div class="text-lg font-bold text-white"><?php echo $rTo['title']; ?></div>
                        </div>

                        <!-- Wymagania w karcie -->
                        <div class="space-y-2 pt-2 border-t border-slate-800">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-400">Wymagane pkt:</span>
                                <span class="font-extrabold text-amber-400 bg-amber-500/10 px-2 py-0.5 rounded border border-amber-500/20">
                                    <?php echo $step['pts']; ?> PKT
                                </span>
                            </div>

                            <?php if ($step['extra']): ?>
                            <div class="text-xs bg-purple-950/40 border border-purple-800/40 text-purple-300 p-2 rounded-lg flex items-start gap-1.5 mt-2">
                                <i class="fa-solid fa-triangle-exclamation text-purple-400 mt-0.5"></i>
                                <span><strong>Wymóg specjalny:</strong> <?php echo $step['extra']; ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Dynamiczny Kalkulator Punktów i Postępu -->
        <section class="glass-panel rounded-2xl p-6 border border-amber-500/30">
            <div class="max-w-4xl mx-auto space-y-6">
                <div class="text-center space-y-2">
                    <h2 class="text-2xl font-bold text-white flex items-center justify-center gap-2">
                        <i class="fa-solid fa-calculator text-amber-400"></i>
                        Kalkulator & Symulator Awansu
                    </h2>
                    <p class="text-slate-400 text-sm">Sprawdź swoją obecną sytuację i policz, ile punktów brakuje Ci do kolejnej rangi</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-950/60 p-6 rounded-xl border border-slate-800">
                    <!-- Wybór obecnej rangi -->
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">Obecna Ranga:</label>
                        <select id="simCurrentRank" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-3 text-white focus:outline-none focus:border-amber-500">
                            <?php foreach ($ranks as $lvl => $r): ?>
                                <?php if ($lvl < 6): ?>
                                <option value="<?php echo $lvl; ?>">@<?php echo $lvl; ?> | <?php echo $r['title']; ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Posiadane Punkty -->
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">Liczba Zgromadzonych Punktów:</label>
                        <input type="number" id="simPoints" value="0" min="0" max="200" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-3 text-white focus:outline-none focus:border-amber-500">
                    </div>

                    <!-- Dodatkowe czynniki -->
                    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                        <label class="flex items-center space-x-3 bg-slate-900/80 p-3 rounded-lg border border-slate-800 cursor-pointer hover:border-slate-700">
                            <input type="checkbox" id="simDept" class="w-5 h-5 accent-amber-500 rounded">
                            <span class="text-sm text-slate-300">Należę do wydziału <span class="text-slate-500">(Rekru / Bojufka / Event team)</span></span>
                        </label>

                        <label class="flex items-center space-x-3 bg-slate-900/80 p-3 rounded-lg border border-slate-800 cursor-pointer hover:border-slate-700">
                            <input type="checkbox" id="simBoard" class="w-5 h-5 accent-amber-500 rounded">
                            <span class="text-sm text-slate-300">Posiadam pozytywną Decyzję Zarządu</span>
                        </label>
                    </div>
                </div>

                <!-- Wynik Kalkulatora -->
                <div id="simResultBox" class="p-5 rounded-xl bg-slate-900/90 border border-slate-800 space-y-4">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <span class="text-xs text-slate-400 uppercase font-semibold block">Cel awansu:</span>
                            <div class="text-lg font-bold text-white flex items-center gap-2">
                                Awans z <span id="simFromText" class="text-amber-400">@1 Newbie</span> do <span id="simToText" class="text-emerald-400">@2 Trial</span>
                            </div>
                        </div>

                        <div class="text-right">
                            <span class="text-xs text-slate-400 uppercase font-semibold block">Stan punktowy:</span>
                            <div class="text-xl font-extrabold text-amber-400">
                                <span id="simCurrentPts">0</span> / <span id="simTargetPts">10</span> PKT
                            </div>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="space-y-1">
                        <div class="w-full bg-slate-950 rounded-full h-4 overflow-hidden border border-slate-800 p-0.5">
                            <div id="simProgressBar" class="bg-gradient-to-r from-amber-500 to-emerald-500 h-full rounded-full transition-all duration-300" style="width: 0%"></div>
                        </div>
                        <div class="flex justify-between text-xs text-slate-400 pt-1">
                            <span id="simStatusMsg">Obliczanie...</span>
                            <span id="simPercent">0%</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tabela Punktów / Katalog Zadań -->
        <section class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                        <i class="fa-solid fa-list-check text-amber-400"></i>
                        Katalog Zadań i Punktacji
                    </h2>
                    <p class="text-slate-400 text-sm">Wykaz wszystkich oficjalnych aktywności nagradzanych punktami</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php foreach ($tasks as $task): ?>
                <div class="glass-panel p-5 rounded-xl flex items-start justify-between gap-4 border border-slate-800 hover:border-slate-700 transition-colors">
                    <div class="flex items-start gap-3.5">
                        <div class="w-10 h-10 rounded-lg bg-amber-500/10 border border-amber-500/20 text-amber-400 flex items-center justify-center shrink-0 text-lg">
                            <i class="fa-solid <?php echo $task['icon']; ?>"></i>
                        </div>
                        <div class="space-y-1">
                            <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-slate-800 text-slate-400 border border-slate-700">
                                <?php echo $task['category']; ?>
                            </span>
                            <p class="text-sm font-semibold text-white leading-snug pt-1">
                                <?php echo $task['desc']; ?>
                            </p>
                        </div>
                    </div>

                    <div class="text-right shrink-0">
                        <span class="text-lg font-black text-amber-400 bg-amber-500/10 border border-amber-500/20 px-3 py-1 rounded-lg inline-block">
                            +<?php echo $task['pts']; ?> <span class="text-xs font-normal">PKT</span>
                        </span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Sekcja Informacji o Wydziałach -->
        <section class="glass-panel p-6 rounded-2xl border border-slate-800">
            <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                <i class="fa-solid fa-sitemap text-amber-400"></i> Offiicjalne Wydziały Rodziny
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-slate-900/60 p-4 rounded-xl border border-slate-800">
                    <div class="font-bold text-amber-400 mb-1"><i class="fa-solid fa-user-plus mr-1"></i> Rekru</div>
                    <p class="text-xs text-slate-400">Wydział odpowiedzialny za przeprowadzanie rozmów rekrutacyjnych oraz wprowadzanie nowych członków do rodziny.</p>
                </div>
                <div class="bg-slate-900/60 p-4 rounded-xl border border-slate-800">
                    <div class="font-bold text-amber-400 mb-1"><i class="fa-solid fa-gun mr-1"></i> Bojufka</div>
                    <p class="text-xs text-slate-400">Jednostka bojowa dbająca o bezpieczeństwo stref, udział w bitwach oraz wsparcie operacyjne.</p>
                </div>
                <div class="bg-slate-900/60 p-4 rounded-xl border border-slate-800">
                    <div class="font-bold text-amber-400 mb-1"><i class="fa-solid fa-calendar-star mr-1"></i> Event team</div>
                    <p class="text-xs text-slate-400">Zespół organizujący wydarzenia wewnętrzne, imprezy integracyjne oraz udział w akcjach globalnych.</p>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="mt-16 border-t border-slate-800/60 py-8 text-center text-xs text-slate-500">
        <div class="max-w-7xl mx-auto px-4">
            <p>© <?php echo date('Y'); ?> Rodzina Maciura. Wszelkie prawa zastrzeżone.</p>
            <p class="mt-1 text-slate-600">Dedykowany panel awansów dla struktur RP i Gildii.</p>
        </div>
    </footer>

    <!-- JS Logic for Simulator and Live Countdown -->
    <script>
        // Dane rang z PHP do JS
        const ranksData = <?php echo json_encode($ranks); ?>;

        // Licznik do soboty 18:00
        function updateSaturdayCountdown() {
            const now = new Date();
            let target = new Date();
            
            // Znajdź najbliższą sobotę
            const dayOfWeek = now.getDay(); // 0 = niedziela, 6 = sobota
            let daysUntilSaturday = (6 - dayOfWeek + 7) % 7;
            
            // Jeśli jest sobota po 18:00, ustaw następną sobotę
            if (dayOfWeek === 6 && now.getHours() >= 18) {
                daysUntilSaturday = 7;
            }

            target.setDate(now.getDate() + daysUntilSaturday);
            target.setHours(18, 0, 0, 0);

            const diff = target - now;

            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
            const minutes = Math.floor((diff / 1000 / 60) % 60);
            const seconds = Math.floor((diff / 1000) % 60);

            const format = (n) => String(n).padStart(2, '0');

            const textCountdown = `${days}d ${format(hours)}h ${format(minutes)}m ${format(seconds)}s`;
            
            document.getElementById('mainCountdown').innerText = textCountdown;
            document.getElementById('headerCountdown').innerText = textCountdown;
        }

        setInterval(updateSaturdayCountdown, 1000);
        updateSaturdayCountdown();

        // Symulator awansu
        function calculateSimulation() {
            const currentRankLvl = parseInt(document.getElementById('simCurrentRank').value);
            const userPts = parseInt(document.getElementById('simPoints').value) || 0;
            const hasDept = document.getElementById('simDept').checked;
            const hasBoard = document.getElementById('simBoard').checked;

            const nextRankLvl = currentRankLvl + 1;
            const currentRank = ranksData[currentRankLvl];
            const nextRank = ranksData[nextRankLvl];

            if (!nextRank) return;

            document.getElementById('simFromText').innerText = `@${currentRankLvl} ${currentRank.badge}`;
            document.getElementById('simToText').innerText = `@${nextRankLvl} ${nextRank.badge}`;
            document.getElementById('simCurrentPts').innerText = userPts;
            document.getElementById('simTargetPts').innerText = nextRank.req_pts;

            let percentage = Math.min(100, Math.round((userPts / nextRank.req_pts) * 100));
            document.getElementById('simProgressBar').style.width = percentage + '%';
            document.getElementById('simPercent').innerText = percentage + '%';

            // Sprawdzanie wymagań dodatkowych
            let missingReqs = [];
            
            if (userPts < nextRank.req_pts) {
                missingReqs.push(`brakuje ${nextRank.req_pts - userPts} pkt`);
            }
            if (nextRank.dept && !hasDept) {
                missingReqs.push(`brak dołączenia do wydziału`);
            }
            if (nextRank.board && !hasBoard) {
                missingReqs.push(`brak zgody Zarządu`);
            }

            const statusEl = document.getElementById('simStatusMsg');
            if (missingReqs.length === 0) {
                statusEl.innerHTML = `<span class="text-emerald-400 font-bold"><i class="fa-solid fa-circle-check"></i> Spełniasz wszystkie wymagania do awansu!</span>`;
            } else {
                statusEl.innerHTML = `<span class="text-amber-400 font-medium"><i class="fa-solid fa-circle-info"></i> Do awansu: ${missingReqs.join(', ')}.</span>`;
            }
        }

        // Event Listenery dla Symulatora
        document.getElementById('simCurrentRank').addEventListener('change', calculateSimulation);
        document.getElementById('simPoints').addEventListener('input', calculateSimulation);
        document.getElementById('simDept').addEventListener('change', calculateSimulation);
        document.getElementById('simBoard').addEventListener('change', calculateSimulation);

        // Pierwsze uruchomienie
        calculateSimulation();
    </script>
</body>
</html>
