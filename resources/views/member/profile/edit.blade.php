@extends('layouts.member')
@php($activeNav = 'profile')
@php($pageTitle = 'Profil Saya')
@section('title', 'Profil Saya')
@section('content')

    <div class="bg-white border-b border-neutral-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-2xl font-bold font-poppins text-neutral-text">Profil Saya</h1>
            <p class="text-sm text-neutral-muted mt-1">Kelola informasi akun kamu</p>
        </div>
    </div>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        @if(session('success'))
            <x-alert type="success" dismissible="true">{{ session('success') }}</x-alert>
        @endif

        @if($errors->any())
            <x-alert type="error" dismissible="true">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </x-alert>
        @endif

        <form action="{{ route('member.profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PATCH')

            <!-- Profile Info -->
            <div class="bg-white rounded-2xl border border-neutral-border p-6 shadow-sm">
                <h2 class="text-lg font-bold text-neutral-text font-poppins mb-4">Informasi Profil</h2>

                <div class="space-y-4">
                    <!-- Avatar -->
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-16 h-16 rounded-2xl bg-primary text-white font-bold text-xl flex items-center justify-center shadow-md">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-neutral-text">{{ $user->name }}</p>
                            <p class="text-xs text-neutral-muted capitalize">{{ $user->role }}</p>
                        </div>
                    </div>

                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-semibold text-neutral-text mb-1.5">Nama <span class="text-error">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                            class="w-full rounded-xl border border-neutral-border bg-white px-4 py-3 text-sm text-neutral-text placeholder-neutral-muted focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-semibold text-neutral-text mb-1.5">Email <span class="text-error">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                            class="w-full rounded-xl border border-neutral-border bg-white px-4 py-3 text-sm text-neutral-text placeholder-neutral-muted focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block text-sm font-semibold text-neutral-text mb-1.5">Nomor Telepon <span class="text-neutral-muted font-normal">(opsional)</span></label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx"
                            class="w-full rounded-xl border border-neutral-border bg-white px-4 py-3 text-sm text-neutral-text placeholder-neutral-muted focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                    </div>
                </div>
            </div>

            <!-- Password Change -->
            <div class="bg-white rounded-2xl border border-neutral-border p-6 shadow-sm">
                <h2 class="text-lg font-bold text-neutral-text font-poppins mb-1">Ubah Password</h2>
                <p class="text-xs text-neutral-muted mb-4">Kosongkan jika tidak ingin mengubah password.</p>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-neutral-text mb-1.5">Password Saat Ini <span class="text-error">*</span></label>
                        <input type="password" name="current_password" placeholder="Masukkan password saat ini"
                            class="w-full rounded-xl border border-neutral-border bg-white px-4 py-3 text-sm text-neutral-text placeholder-neutral-muted focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-neutral-text mb-1.5">Password Baru</label>
                        <input type="password" name="password" placeholder="Minimal 8 karakter"
                            class="w-full rounded-xl border border-neutral-border bg-white px-4 py-3 text-sm text-neutral-text placeholder-neutral-muted focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-neutral-text mb-1.5">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" placeholder="Ulangi password baru"
                            class="w-full rounded-xl border border-neutral-border bg-white px-4 py-3 text-sm text-neutral-text placeholder-neutral-muted focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('member.dashboard') }}" class="px-5 py-2.5 text-sm font-semibold text-neutral-text rounded-xl hover:bg-neutral-bg transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary-hover shadow-sm transition-all">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

@endsection
