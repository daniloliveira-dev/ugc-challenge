<template>
    <div class="min-h-screen">
        <header class="site-header">
            <div class="max-w-6xl mx-auto px-6 py-6 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold">Marketing Diagnóstico</h1>
                    <p class="tagline">Responda algumas perguntas estratégicas e receba um plano prático de marketing com foco em UGC.</p>
                </div>
                <a href="https://crehub.app" target="_blank" rel="noreferrer" class="cta">Conheça CreHub.app</a>
            </div>
        </header>

        <main class="site-main">
            <div v-if="loading" class="loading-overlay">
                <div class="loading-box">
                    <div class="spinner" aria-hidden="true"></div>
                    <div class="loading-text">Generating</div>
                </div>
            </div>
            <div class="max-w-6xl mx-auto px-6 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Form (open modal to fill briefing) -->
                <section class="card">
                    <h2 class="text-xl font-semibold mb-4">Briefing rápido — Marketing</h2>

                    <p class="text-sm text-slate-500 mb-4" style="letter-spacing:0.5px;">Clique em "Abrir Briefing" para preencher as informações de forma clara e objetiva.</p>
                    <div>
                        <button @click="showBriefingModal = true" class="btn-primary">Abrir Briefing</button>
                    </div>

                    <!-- Briefing Modal -->
                    <div v-if="showBriefingModal" class="modal-backdrop">
                        <div class="modal">
                            <div class="modal-header">
                                <h3>Briefing rápido — Marketing</h3>
                                <button class="modal-close" @click="showBriefingModal = false">×</button>
                            </div>
                            <div class="modal-body">
                                <form @submit.prevent="submitAndClose" class="form-compact">
                                    <div>
                                        <label class="label">Tamanho da empresa</label>
                                        <select v-model="form.companySize" class="input">
                                            <option disabled value="">Selecione</option>
                                            <option>MEI</option>
                                            <option>Pequena Empresa</option>
                                            <option>Média Empresa</option>
                                            <option>Grande Empresa</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="label">Quanto investe (mês) em marketing?</label>
                                        <input v-model="form.marketingInvestment" placeholder="Ex: 0, 500, 2000" class="input" />
                                    </div>

                                    <div>
                                        <label class="label">Você conhece UGC?</label>
                                        <div class="radio-row">
                                            <label><input type="radio" value="Sim" v-model="form.knowsUGC"> Sim</label>
                                            <label><input type="radio" value="Não" v-model="form.knowsUGC"> Não</label>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="label">Objetivo principal</label>
                                        <select v-model="form.mainObjective" class="input">
                                            <option disabled value="">Selecione</option>
                                            <option>Aumentar Vendas</option>
                                            <option>Gerar Autoridade</option>
                                            <option>Aumentar Reconhecimento de Marca</option>
                                            <option>Melhorar Engajamento</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="label">Segmento de atuação</label>
                                        <input v-model="form.segment" placeholder="Ex: Moda, Alimentação, Saúde" class="input" />
                                    </div>

                                    <div>
                                        <label class="label">Maior desafio hoje</label>
                                        <textarea v-model="form.mainChallenge" rows="4" class="input" placeholder="Descreva o principal obstáculo"></textarea>
                                    </div>

                                    <div class="modal-actions">
                                        <button type="button" @click="submitAndClose" class="btn-primary">{{ loading ? 'Gerando...' : 'Gerar plano personalizado' }}</button>
                                        <button type="button" @click="showBriefingModal = false" class="btn-ghost">Cancelar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Result -->
                <aside class="card card-secondary">
                    <h2 class="text-xl font-semibold mb-4">Plano personalizado</h2>

                    <div v-if="!planGenerated" class="text-sm text-slate-500">Preencha o formulário e clique em "Gerar plano personalizado" para ver recomendações práticas e um roteiro de UGC.</div>

                    <div v-else>
                        <div class="mb-4">
                            <h3 class="font-semibold text-slate-700">Resumo</h3>
                            <pre class="plan-text text-sm mt-2">{{ plan.summary }}</pre>
                        </div>

                        <div class="mb-4">
                            <h3 class="font-semibold text-slate-700">Ações recomendadas</h3>
                            <ul class="list-disc pl-5 mt-2 text-sm text-slate-600">
                                <li v-for="(item, idx) in plan.actions" :key="idx">{{ item }}</li>
                            </ul>
                        </div>

                        <div class="mb-4">
                            <h3 class="font-semibold text-slate-700">Como o UGC ajuda</h3>
                            <p class="text-sm text-slate-600 mt-2">{{ plan.ugc }}</p>
                        </div>

                        <div class="mt-4">
                            <a :href="ctaUrl" target="_blank" rel="noreferrer" class="inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Conhecer criadores em CreHub.app</a>
                        </div>
                    </div>
                </aside>
                <!-- End marker for scroll detection -->
                <div id="end-marker" style="height:1px;width:100%"></div>
            </div>
            </div>

            <!-- CreHub Modal (appears when user reaches end) -->
            <div v-if="showCrehubModal" class="modal-backdrop">
                <div class="modal center-modal">
                    <div class="modal-header">
                        <h3>Gostaria de conhecer a CreHub.app?</h3>
                    </div>
                    <div class="modal-body">
                        <p style="margin-bottom:16px;">Conhecer a CreHub.app pode conectar você a criadores UGC para executar o plano gerado.</p>
                        <div style="display:flex; gap:12px; justify-content:center">
                            <button class="btn-primary" @click="handleCrehubYes">Sim, levar-me</button>
                            <button class="btn-ghost" @click="handleCrehubNo">Não, voltar</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script setup>
import { ref, onMounted, nextTick } from 'vue';

const form = ref({
    companySize: '',
    marketingInvestment: '',
    knowsUGC: '',
    mainObjective: '',
    segment: '',
    mainChallenge: ''
});

const planGenerated = ref(false);
const plan = ref({ summary: '', actions: [], ugc: '' });
const error = ref('');
const loading = ref(false);
const showBriefingModal = ref(false);
const showCrehubModal = ref(false);
const endMarker = ref(null);

const ctaUrl = 'https://crehub.app';

function validate() {
    error.value = '';
    if (!form.value.companySize) { error.value = 'Selecione o tamanho da empresa.'; return false; }
    if (!form.value.mainObjective) { error.value = 'Selecione o objetivo principal.'; return false; }
    if (!form.value.segment) { error.value = 'Informe o segmento de atuação.'; return false; }
    return true;
}

async function generatePlan() {
    if (!validate()) return;

    loading.value = true;
    error.value = '';
    planGenerated.value = false;

    // Map form fields to API expected keys
    const payload = {
        tamanhoEmpresa: form.value.companySize,
        investimento: form.value.marketingInvestment,
        objetivo: form.value.mainObjective,
        segmento: form.value.segment,
        problemaAtual: form.value.mainChallenge,
        conheceUGC: form.value.knowsUGC
    };

    try {
        const res = await fetch('/api/generate-marketing-plan', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });

        const json = await res.json();

        // Tratar erro de forma amigável quando API sinaliza falha
        if (!res.ok) {
            error.value = 'Não foi possível gerar o seu plano, tente novamente em alguns instantes';
            return;
        }

        if (!json.success) {
            error.value = 'Não foi possível gerar o seu plano, tente novamente em alguns instantes';
            return;
        }

        // Se o campo text estiver ausente ou vazio, mostrar mensagem amigável
        const text = json.data && typeof json.data.text === 'string' ? json.data.text.trim() : null;
        if (!text) {
            error.value = 'Não foi possível gerar o seu plano, tente novamente em alguns instantes';
            return;
        }

        plan.value.summary = text;
        plan.value.actions = [];
        plan.value.ugc = '';
        planGenerated.value = true;
    } catch (err) {
        error.value = err.message || String(err);
    } finally {
        loading.value = false;
    }
}

function resetForm() {
    form.value = { companySize: '', marketingInvestment: '', knowsUGC: '', mainObjective: '', segment: '', mainChallenge: '' };
    planGenerated.value = false;
    error.value = '';
}

function openBriefing() { showBriefingModal.value = true; }
function closeBriefing() { showBriefingModal.value = false; }

function handleCrehubYes() {
    window.location.href = ctaUrl;
}

function handleCrehubNo() {
    showCrehubModal.value = false;
    // scroll back to the plan content
    nextTick(() => {
        const el = document.querySelector('.card-secondary');
        if (el) el.scrollIntoView({ behavior: 'smooth', block: 'center' });
    });
}

function submitAndClose() {
    showBriefingModal.value = false;
    // call generatePlan afterwards
    generatePlan();
}

onMounted(() => {
    // Observe the end marker to show CreHub modal when user reaches the end
    const marker = document.getElementById('end-marker');
    if (!marker) return;
    const obs = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && planGenerated.value) {
                showCrehubModal.value = true;
            }
        });
    }, { threshold: 0.9 });
    obs.observe(marker);
});
</script>

<style>
/* Dark marketing theme fallback (used if Tailwind isn't loaded) */
body { background: radial-gradient(1200px 600px at 10% 10%, rgba(99,102,241,0.08), transparent), #0f172a; color: #e6eef8; font-family: Inter, ui-sans-serif, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; }
.site-header { background: linear-gradient(90deg,#0ea5a4 0%, #7c3aed 50%, #ef4444 100%); box-shadow: 0 6px 30px rgba(2,6,23,0.6); }
.site-header h1 { color: #ffffff; font-size: 1.9rem; margin: 0; text-shadow: 0 2px 10px rgba(0,0,0,0.4); }
.tagline { color: rgba(230,238,248,0.9); margin-top: 6px; }
.cta { background: linear-gradient(90deg,#06b6d4,#7c3aed); color: #fff; padding:8px 14px; border-radius:10px; text-decoration:none; box-shadow: 0 6px 18px rgba(124,58,237,0.25); }
.site-main { padding-top: 3rem; padding-bottom: 3rem; }
.max-w-6xl { max-width: 72rem; margin-left: auto; margin-right: auto; }
.px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
.py-6 { padding-top: 1.5rem; padding-bottom: 1.5rem; }
.py-12 { padding-top: 3rem; padding-bottom: 3rem; }
.card { background: linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01)); border: 1px solid rgba(255,255,255,0.04); border-radius: 12px; box-shadow: 0 8px 30px rgba(2,6,23,0.6); padding: 1.25rem; }
.card-secondary { background: linear-gradient(180deg, rgba(124,58,237,0.08), rgba(14,165,164,0.03)); border: 1px solid rgba(124,58,237,0.12); }
form label { display:block; font-size:0.95rem; color:rgba(230,238,248,0.9); margin-bottom:8px; }
form select, form input, form textarea { width:100%; padding:12px 14px; border:1px solid rgba(255,255,255,0.08); border-radius:10px; background: rgba(6,10,20,0.96); color: #e6eef8; font-size:0.95rem; }
form textarea { min-height:96px; }
button[type="submit"] { background: linear-gradient(90deg,#ff7a59,#ffb86b); color:#081124; padding:10px 14px; border-radius:10px; border:none; cursor:pointer; font-weight:600; box-shadow: 0 8px 30px rgba(255,122,89,0.18); }
button[ type="button"] { background: transparent; color: rgba(230,238,248,0.9); padding:8px 12px; border-radius:8px; border:1px solid rgba(255,255,255,0.06); cursor:pointer; }
.grid { display:grid; gap:1.5rem; }
@media(min-width:1024px){ .grid { grid-template-columns: 1fr 440px; } }
.text-sm { font-size:0.95rem; }
.text-slate-500 { color: rgba(230,238,248,0.7); }
.mb-4 { margin-bottom:1rem; }
.list-disc { color: #cfe9ff; }
.card h2, .card-secondary h2 { color: #ffffff; }
.card p, .card-secondary p, .card li { color: rgba(230,238,248,0.9); }
.cta:hover { transform: translateY(-2px); }

/* Loading overlay */
.loading-overlay { position: fixed; inset: 0; background: rgba(2,6,23,0.6); display:flex; align-items:center; justify-content:center; z-index:60; }
.loading-box { background: linear-gradient(180deg, rgba(255,255,255,0.03), rgba(255,255,255,0.02)); padding:24px 28px; border-radius:12px; display:flex; gap:12px; align-items:center; box-shadow:0 10px 40px rgba(0,0,0,0.6); }
.loading-text { color:#e6eef8; font-weight:700; font-size:1.05rem; }
.spinner { width:28px; height:28px; border-radius:50%; border:4px solid rgba(255,255,255,0.12); border-top-color: #ffb86b; animation:spin 1s linear infinite; }
@keyframes spin { to { transform: rotate(360deg); } }

.btn-primary { background: linear-gradient(90deg,#ff7a59,#ffb86b); color:#081124; padding:10px 14px; border-radius:10px; border:none; cursor:pointer; font-weight:600; box-shadow: 0 8px 30px rgba(255,122,89,0.18); }
.btn-primary[disabled] { opacity:0.6; cursor:not-allowed; }
.plan-text { white-space: pre-wrap; color: rgba(230,238,248,0.95); }

/* Modal styles */
.modal-backdrop { position: fixed; inset: 0; background: rgba(2,6,23,0.82); backdrop-filter: blur(6px) saturate(120%); display:flex; align-items:center; justify-content:center; z-index:120; }
.modal { width: min(820px, 96%); background: rgba(6,10,20,0.96); border-radius:14px; padding:22px; box-shadow: 0 18px 80px rgba(0,0,0,0.7); border:1px solid rgba(255,255,255,0.06); }
.center-modal { max-width:640px; }
.modal-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:14px; }
.modal-header h3 { margin:0; color:#fff; letter-spacing:1.4px; font-size:1.15rem; line-height:1.2; }
.modal-close { background:transparent; border:none; color:#f3f4f6; font-size:22px; cursor:pointer; opacity:0.9; }
.modal-body { color: #e6eef8; max-height: 60vh; overflow:auto; padding-right:6px; line-height:1.5; }
.modal-actions { display:flex; gap:12px; justify-content:flex-end; margin-top:16px; }
.btn-ghost { background: transparent; color: #e6eef8; padding:8px 12px; border-radius:8px; border:1px solid rgba(255,255,255,0.06); cursor:pointer; }
.label { display:block; color: rgba(230,238,248,0.9); margin-bottom:6px; letter-spacing:0.7px; }
.input { width:100%; padding:12px 14px; border-radius:10px; border:1px solid rgba(255,255,255,0.10); background: rgba(6,10,20,0.96); color:#e6eef8; }
.input:focus { background: rgba(6,10,20,0.98); }

/* Stronger select/option contrast for dropdowns */
select { color: #e6eef8; background: rgba(6,10,20,0.96); }
select:focus { outline: 3px solid rgba(99,102,241,0.18); }
select option { background: rgba(6,10,20,0.98); color: #e6eef8; }
.radio-row { display:flex; gap:14px; margin-top:6px; color:#e6eef8; }
.form-compact > div { margin-bottom:12px; }

/* Improve focus visibility for accessibility */
.modal :focus, .modal button:focus, .modal select:focus, .modal input:focus, .modal textarea:focus { outline: 3px solid rgba(99,102,241,0.18); outline-offset: 2px; box-shadow: 0 4px 20px rgba(2,6,23,0.6); }
</style>