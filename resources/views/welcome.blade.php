<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EasyColoc</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-b from-cerulean-100 via-cerulean-50 to-cerulean-100 text-cerulean-900">
<main class="mx-auto flex min-h-screen w-full max-w-6xl items-center px-4 py-10 md:px-8">
    <section class="w-full rounded-3xl border border-cerulean-200/80 bg-white/95 p-6 shadow-2xl shadow-cerulean-900/10 md:p-10">
        <div class="mx-auto max-w-3xl text-center">
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-cerulean-600">EasyColoc</p>
            <h1 class="mt-3 text-4xl font-bold text-cerulean-900 md:text-5xl">Choose Your Next Step</h1>
            <p class="mt-4 text-sm text-cerulean-700 md:text-base">
                Start a new colocation group or join an existing one using an invitation link.
            </p>
        </div>

        <div class="mx-auto mt-10 grid max-w-4xl gap-5 md:grid-cols-2">
            <article class="rounded-2xl border border-cerulean-200 bg-cerulean-50 p-6">
                <span class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-cerulean-700 text-xl text-white">+</span>
                <h2 class="mt-5 text-2xl font-semibold text-cerulean-900">Create a Group</h2>
                <p class="mt-3 text-sm text-cerulean-700">
                    Create a new group, invite your roommates, and start tracking shared expenses.
                </p>
                <a href="{{ route('colocation.create') }}" class="mt-6 inline-flex rounded-xl bg-cerulean-700 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-cerulean-800">
                    Create Group
                </a>
            </article>

            <article class="rounded-2xl border border-cerulean-200 bg-cerulean-50 p-6">
                <span class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-cerulean-700 text-xl text-white">↗</span>
                <h2 class="mt-5 text-2xl font-semibold text-cerulean-900">Join by Link</h2>
                <p class="mt-3 text-sm text-cerulean-700">
                    Paste your invitation link and join an existing group in seconds.
                </p>
                <button
                    type="button"
                    id="open-join-modal"
                    class="mt-6 inline-flex rounded-xl bg-cerulean-700 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-cerulean-800"
                >
                    Join Group
                </button>
            </article>
        </div>
    </section>
</main>

<div id="join-group-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-cerulean-900/50 p-4">
    <div class="w-full max-w-md rounded-2xl border border-cerulean-200 bg-white p-5 shadow-xl">
        <div class="flex items-start justify-between gap-3">
            <div>
                <h3 class="text-lg font-semibold text-cerulean-800">Join Group</h3>
                <p class="mt-1 text-xs text-cerulean-600">Paste your invitation link.</p>
            </div>
            <button type="button" id="close-join-modal" class="rounded-lg p-2 text-cerulean-700 hover:bg-cerulean-100">X</button>
        </div>

        <form id="join-group-form" class="mt-4 space-y-3">
            <div>
                <label for="join-link-input" class="block text-xs font-medium text-cerulean-800">Invitation Link</label>
                <input
                    id="join-link-input"
                    type="url"
                    placeholder="https://..."
                    class="mt-2 block h-11 w-full rounded-xl border border-cerulean-200 bg-white px-3 text-sm text-cerulean-800 outline-none focus:border-cerulean-600"
                    required
                />
            </div>

            <div class="flex justify-end gap-2 pt-1">
                <button type="button" id="cancel-join-modal" class="rounded-xl border border-cerulean-300 px-4 py-2 text-sm font-semibold text-cerulean-700 hover:bg-cerulean-50">Cancel</button>
                <button type="submit" class="rounded-xl bg-cerulean-700 px-4 py-2 text-sm font-semibold text-white hover:bg-cerulean-800">Go</button>
            </div>
        </form>
    </div>
</div>

<script>
    (() => {
        const body = document.body;
        const modal = document.getElementById('join-group-modal');
        const openBtn = document.getElementById('open-join-modal');
        const closeBtn = document.getElementById('close-join-modal');
        const cancelBtn = document.getElementById('cancel-join-modal');
        const form = document.getElementById('join-group-form');
        const input = document.getElementById('join-link-input');

        if (!modal || !openBtn || !form || !input) return;

        const openModal = () => {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            body.classList.add('overflow-hidden');
            input.focus();
        };

        const closeModal = () => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            body.classList.remove('overflow-hidden');
        };

        openBtn.addEventListener('click', openModal);
        closeBtn?.addEventListener('click', closeModal);
        cancelBtn?.addEventListener('click', closeModal);

        modal.addEventListener('click', (event) => {
            if (event.target === modal) closeModal();
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') closeModal();
        });

        form.addEventListener('submit', (event) => {
            event.preventDefault();
            const link = input.value.trim();
            if (!link) return;
            window.location.href = link;
        });
    })();
</script>
</body>
</html>
