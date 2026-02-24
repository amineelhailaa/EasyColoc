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
                <a href="#" class="mt-6 inline-flex rounded-xl bg-cerulean-700 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-cerulean-800">
                    Create Group
                </a>
            </article>

            <article class="rounded-2xl border border-cerulean-200 bg-cerulean-50 p-6">
                <span class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-cerulean-700 text-xl text-white">↗</span>
                <h2 class="mt-5 text-2xl font-semibold text-cerulean-900">Join by Link</h2>
                <p class="mt-3 text-sm text-cerulean-700">
                    Paste your invitation link and join an existing group in seconds.
                </p>
                <a href="#" class="mt-6 inline-flex rounded-xl bg-cerulean-700 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-cerulean-800">
                    Join Group
                </a>
            </article>
        </div>
    </section>
</main>
</body>
</html>
