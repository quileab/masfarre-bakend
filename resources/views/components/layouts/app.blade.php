<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- load scripts from js/tinymce/tinymce.min.js --}}
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
</head>

<body class="min-h-screen font-sans antialiased bg-base-200">

    {{-- NAVBAR mobile only --}}
    <x-nav sticky class="lg:hidden">
        <x-slot:brand>
            <x-app-brand />
        </x-slot:brand>
        <x-slot:actions>
            <label for="main-drawer" class="lg:hidden me-3">
                <x-icon name="o-bars-3" class="cursor-pointer" />
            </label>
        </x-slot:actions>
    </x-nav>

    {{-- MAIN --}}
    <x-main>
        {{-- SIDEBAR --}}
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100 lg:bg-inherit">

            {{-- BRAND --}}
            <x-app-brand class="px-5 pt-4" />

            {{-- MENU --}}
            <x-menu activate-by-route>

                {{-- User --}}
                @if($user = auth()->user())
                    <x-menu-separator />

                    <x-list-item :item="$user" value="name" sub-value="email" no-separator no-hover
                        class="-mx-2 !-my-2 rounded">
                        <x-slot:actions>
                            <x-button icon="o-power" class="btn-circle btn-ghost btn-xs" tooltip-left="logoff"
                                no-wire-navigate link="/logout" />
                        </x-slot:actions>
                    </x-list-item>

                    <x-menu-separator />
                    <livewire:bookmarks />
                @endif
                @if(auth()->user()->role == 'admin')
                <x-menu-item title="Dashboard" icon="o-sparkles" link="/" />
                <x-menu-item title="Usuarios" icon="o-users" link="/users" />
                <x-menu-item title="Productos" icon="o-cube" link="/products" />
                <x-menu-item title="Categorias" icon="o-users" link="/categories" />
                <x-menu-item title="Presupuestos" icon="o-document-currency-dollar" link="/budgets" />
                <x-menu-item title="Noticias" icon="o-newspaper" link="/posts" />
                @else
                <x-menu-item title="Presupuestos" icon="o-document-currency-dollar" link="/budgets" />
                @endif

            </x-menu>
        </x-slot:sidebar>

        {{-- The `$slot` goes here --}}
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>

        @stack('scripts')
    </x-main>

    {{-- TOAST area --}}
    <x-toast />
</body>

</html>