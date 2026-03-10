<?php

use App\Concerns\ProfileValidationRules;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Profile settings')] class extends Component {
    use ProfileValidationRules;

    public string $name = '';
    public string $email = '';

    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    public function updateAvatar(string $path): void
    {
        Auth::user()->update(['avatar' => $path]);
        $this->dispatch('profile-updated', name: Auth::user()->name);
        $this->redirect(route('profile.edit'), navigate: true);
    }

    public function updateProfileInformation(): void
    {
        $user = Auth::user();
        $validated = $this->validate($this->profileRules($user->id));
        $user->fill($validated);
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        $user->save();
        $this->dispatch('profile-updated', name: $user->name);
    }

    public function resendVerificationNotification(): void
    {
        $user = Auth::user();
        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));
            return;
        }
        $user->sendEmailVerificationNotification();
        Session::flash('status', 'verification-link-sent');
    }

    #[Computed]
    public function hasUnverifiedEmail(): bool
    {
        return Auth::user() instanceof MustVerifyEmail && !Auth::user()->hasVerifiedEmail();
    }

    #[Computed]
    public function showDeleteUser(): bool
    {
        return !Auth::user() instanceof MustVerifyEmail || (Auth::user() instanceof MustVerifyEmail && Auth::user()->hasVerifiedEmail());
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-pages::settings.layout :heading="__('Perfil')" :subheading="__('Modifica tu información de perfil y tu dirección de correo electrónico.')" class="mt-6">

        <div class="flex items-center gap-6 mb-8 mt-4">
            <flux:modal.trigger name="avatar-picker">
                <div class="group relative size-24 cursor-pointer">
                    <div
                        class="size-11 overflow-hidden rounded-full border-4 border-white shadow-md dark:border-zinc-800">
                        <img src="{{ auth()->user()->avatar_url }}"
                            class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110">
                    </div>

                    <div
                        class="absolute inset-0 flex flex-col items-center justify-center rounded-full bg-black/50 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                        <flux:icon name="pencil-square" variant="micro" class="text-white size-5 mb-0.5" />
                        <span class="text-white text-[10px] font-bold uppercase tracking-widest">Editar</span>
                    </div>
                </div>
            </flux:modal.trigger>

            <div>
                <flux:heading size="xl">{{ auth()->user()->name }}</flux:heading>
                <flux:text>{{ auth()->user()->email }}</flux:text>
                <flux:modal.trigger name="avatar-picker">
                    <flux:button variant="ghost" size="sm" class="mt-2">Cambiar foto de perfil</flux:button>
                </flux:modal.trigger>
            </div>
        </div>

        <flux:separator variant="subtle" />

        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            <flux:input wire:model="name" :label="__('Nombre')" required autofocus />
            <flux:input wire:model="email" :label="__('Email')" type="email" required />

            <div class="flex items-center gap-4">
                <flux:button variant="primary" type="submit">{{ __('Guardar') }}</flux:button>
                <x-action-message on="profile-updated">{{ __('Guardado.') }}</x-action-message>
            </div>
        </form>

        @if ($this->showDeleteUser)
            <livewire:pages::settings.delete-user-form />
        @endif

        <flux:modal name="avatar-picker" class="md:w-125 space-y-6">
            <div>
                <flux:heading size="lg">Elige un nuevo avatar</flux:heading>
                <flux:subheading>Selecciona una imagen</flux:subheading>
            </div>

            <div class="flex flex-row gap-3 overflow-x-auto pb-4 pt-1 px-1 items-center">
                @php
                    $dir = public_path('images/avatares');
                    $files = is_dir($dir) ? glob($dir . '/*.{png,jpg,jpeg,svg,webp}', GLOB_BRACE) : [];
                @endphp

                @foreach ($files as $file)
                    @php
                        $relPath = 'images/avatares/' . basename($file);
                        $active = auth()->user()->avatar === $relPath;
                    @endphp

                    <button type="button" wire:click="updateAvatar('{{ $relPath }}')"
                        class="relative shrink-0 transition-transform active:scale-90">
                        <div
                            class="size-10 overflow-hidden rounded-full border-2 transition-all 
                            {{ $active ? 'border-indigo-500 ring-2 ring-indigo-100' : 'border-zinc-200 dark:border-zinc-700 hover:border-zinc-400' }}">
                            <img src="{{ asset($relPath) }}" class="h-full w-full object-cover">
                        </div>

                        @if ($active)
                            <div
                                class="absolute -bottom-0.5 -right-0.5 flex size-3.5 items-center justify-center rounded-full bg-indigo-500 text-white border border-white dark:border-zinc-900">
                                <flux:icon name="check" variant="micro" class="size-2" />
                            </div>
                        @endif
                    </button>
                @endforeach
            </div>
        </flux:modal>
    </x-pages::settings.layout>
</section>
