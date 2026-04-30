<div class="min-h-screen bg-paper text-ink">
    <section class="py-16 bg-gradient-to-r from-ink to-slate-800 text-paper">
        <div class="max-w-7xl mx-auto px-6">
            <p class="text-gold uppercase text-sm tracking-widest mb-3">Contacto</p>
            <h1 class="text-5xl font-serif font-bold mb-4">Asesoria Inmobiliaria en Tiempo Real</h1>
            <p class="max-w-3xl text-paper/80">Envia tus dudas y nuestro equipo te responde en vivo con un widget de chat SSE sin dependencias externas.</p>
        </div>
    </section>

    <section class="py-14">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 bg-white border border-rule rounded-xl p-6">
                <h2 class="text-2xl font-serif font-bold mb-4">Canales de Atencion</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <article class="p-4 border border-rule rounded-lg bg-slate-50">
                        <p class="font-semibold">Ventas Premium</p>
                        <p class="text-muted">+52 55 4169 8259</p>
                    </article>
                    <article class="p-4 border border-rule rounded-lg bg-slate-50">
                        <p class="font-semibold">Inversionistas</p>
                        <p class="text-muted">invest@havre-estates.com</p>
                    </article>
                    <article class="p-4 border border-rule rounded-lg bg-slate-50">
                        <p class="font-semibold">WhatsApp</p>
                        <p class="text-muted">Atencion 24/7 para prospectos</p>
                    </article>
                    <article class="p-4 border border-rule rounded-lg bg-slate-50">
                        <p class="font-semibold">Oficinas</p>
                        <p class="text-muted">CDMX · Medellin · Santiago</p>
                    </article>
                </div>
            </div>

            <aside class="bg-white border border-rule rounded-xl p-6">
                <h3 class="text-xl font-serif font-bold mb-4">Chat SSE</h3>

                <div id="chatBox" class="h-72 overflow-y-auto border border-rule rounded-lg p-3 bg-slate-50 text-sm space-y-2"></div>

                <form id="chatForm" class="mt-4 space-y-3">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($chat_csrf_token ?? ''); ?>" />
                    <input type="hidden" name="recaptcha_token" id="recaptchaToken" value="" />
                    <input id="chatName" name="name" placeholder="Tu nombre" class="w-full px-3 py-2 border border-rule rounded" />
                    <textarea id="chatMessage" name="message" rows="3" placeholder="Escribe tu mensaje" class="w-full px-3 py-2 border border-rule rounded"></textarea>
                    <div class="hidden" aria-hidden="true">
                        <label for="website">No llenar</label>
                        <input id="website" type="text" name="website" tabindex="-1" autocomplete="off" />
                    </div>
                    <button class="w-full py-2 bg-ink text-paper rounded font-semibold">Enviar mensaje</button>
                </form>
            </aside>
        </div>
    </section>
</div>

<?php if (!empty($recaptcha_enabled) && !empty($recaptcha_site_key)): ?>
<script src="https://www.google.com/recaptcha/api.js?render=<?php echo urlencode((string) $recaptcha_site_key); ?>"></script>
<?php endif; ?>

<script>
(function () {
    const chatBox = document.getElementById('chatBox');
    const chatForm = document.getElementById('chatForm');
    const chatName = document.getElementById('chatName');
    const chatMessage = document.getElementById('chatMessage');
    const recaptchaTokenInput = document.getElementById('recaptchaToken');
    const recaptchaEnabled = <?php echo !empty($recaptcha_enabled) ? 'true' : 'false'; ?>;
    const recaptchaSiteKey = <?php echo json_encode($recaptcha_site_key ?? ''); ?>;

    if (!chatBox || !chatForm || !chatName || !chatMessage) {
        return;
    }

    let lastTs = 0;

    function addItem(item) {
        const row = document.createElement('div');
        row.className = 'p-2 bg-white border border-rule rounded';
        row.innerHTML = '<strong>' + escapeHtml(item.name || 'Visitante') + '</strong>: ' + escapeHtml(item.message || '');
        chatBox.appendChild(row);
        chatBox.scrollTop = chatBox.scrollHeight;

        if (item.ts && Number(item.ts) > lastTs) {
            lastTs = Number(item.ts);
        }
    }

    function connectStream() {
        const stream = new EventSource('/contacto/stream?since=' + String(lastTs));

        stream.addEventListener('message', function (event) {
            try {
                const payload = JSON.parse(event.data);
                addItem(payload);
            } catch (e) {
                console.error('Invalid SSE payload', e);
            }
        });

        stream.onerror = function () {
            stream.close();
            setTimeout(connectStream, 3000);
        };
    }

    chatForm.addEventListener('submit', async function (e) {
        e.preventDefault();

        if (recaptchaEnabled && window.grecaptcha && recaptchaSiteKey) {
            try {
                const token = await window.grecaptcha.execute(recaptchaSiteKey, { action: 'contact_send' });
                if (recaptchaTokenInput) {
                    recaptchaTokenInput.value = token;
                }
            } catch (err) {
                console.error('reCAPTCHA error', err);
            }
        }

        const formData = new FormData(chatForm);
        try {
            const response = await fetch('/contacto/send', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const payload = await response.json();
            if (payload.ok && payload.item) {
                addItem(payload.item);
                chatMessage.value = '';
                if (payload.csrf_token) {
                    const csrfInput = chatForm.querySelector('input[name="csrf_token"]');
                    if (csrfInput) {
                        csrfInput.value = payload.csrf_token;
                    }
                }
            } else if (payload.error) {
                alert(payload.error);
            }
        } catch (err) {
            console.error('No se pudo enviar el mensaje', err);
        }
    });

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    connectStream();
})();
</script>
