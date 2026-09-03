@extends('layouts.admin', ['activeNav' => 'users', 'pageTitle' => 'Edit Pengguna', 'breadcrumbs' => [['label' => 'Users', 'url' => route('admin.users.index')], ['label' => 'Edit User']]])

@section('title', 'Edit Pengguna — ' . $user->name)

@section('content')
    <div class="w-full min-w-0 max-w-none space-y-6">
        <!-- Flash Messages -->
        @if(session('error'))
            <x-alert type="error" dismissible="true" class="mb-6">
                {{ session('error') }}
            </x-alert>
        @endif

        @if(session('success'))
            <x-alert type="success" dismissible="true" class="mb-6">
                {{ session('success') }}
            </x-alert>
        @endif

        <div class="w-full min-w-0 max-w-2xl mx-auto">
            <div class="bg-white rounded-2xl border border-neutral-border shadow-sm p-6 sm:p-8">
                <div class="flex items-center gap-4 pb-6 mb-6 border-b border-neutral-border/60">
                    <div class="w-14 h-14 rounded-2xl bg-primary-light text-primary font-bold text-lg flex items-center justify-center border border-primary/20 shrink-0">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-neutral-text font-poppins">
                            Edit Data Pengguna
                        </h2>
                        <p class="text-xs text-neutral-muted mt-0.5">
                            ID Pengguna: #{{ $user->id }} &bull; Terdaftar sejak {{ $user->created_at ? $user->created_at->format('d M Y') : '—' }}
                        </p>
                    </div>
                </div>

                <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <!-- Nama -->
                    <x-input 
                        label="Nama Lengkap" 
                        name="name" 
                        placeholder="Nama lengkap pengguna" 
                        required="true"
                        value="{{ old('name', $user->name) }}"
                        :error="$errors->first('name')"
                    />

                    <!-- Email -->
                    <x-input 
                        label="Alamat Email" 
                        name="email" 
                        type="email"
                        placeholder="email@domain.com" 
                        required="true"
                        value="{{ old('email', $user->email) }}"
                        :error="$errors->first('email')"
                    />

                    <!-- Role Selection -->
                    <div class="space-y-1.5 w-full">
                        <label for="role" class="block text-sm font-medium text-neutral-text">
                            Peran / Role Pengguna <span class="text-error">*</span>
                        </label>
                        <select 
                            id="role" 
                            name="role" 
                            class="w-full rounded-xl border border-neutral-border bg-white px-3.5 py-2.5 text-sm text-neutral-text focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all duration-150 {{ $errors->has('role') ? 'border-error focus:border-error focus:ring-error/20' : '' }}"
                            required
                        >
                            <option value="member" {{ old('role', $user->role) === 'member' ? 'selected' : '' }}>Member (Pengguna Biasa)</option>
                            <option value="organizer" {{ old('role', $user->role) === 'organizer' ? 'selected' : '' }}>Organizer (Penyelenggara Event)</option>
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin (Administrator Sistem)</option>
                        </select>
                        @error('role')
                            <p class="text-xs text-error font-medium flex items-center gap-1 mt-1">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @else
                            <p class="text-xs text-neutral-muted mt-1">Role menentukan hak akses menu dan fungsi pengguna di EventHub.</p>
                        @enderror
                    </div>

                    <!-- Status Aktif (is_active) -->
                    <div class="p-4 rounded-xl bg-neutral-bg/60 border border-neutral-border/80 space-y-2">
                        <div class="flex items-start gap-3">
                            <input 
                                type="checkbox" 
                                id="is_active" 
                                name="is_active" 
                                value="1" 
                                class="mt-0.5 w-4 h-4 rounded text-primary focus:ring-primary border-neutral-border cursor-pointer"
                                {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                                {{ $user->id === auth()->id() ? 'disabled' : '' }}
                            />
                            <div class="flex-1">
                                <label for="is_active" class="text-sm font-semibold text-neutral-text cursor-pointer">
                                    Akun Aktif
                                </label>
                                <p class="text-xs text-neutral-muted mt-0.5">
                                    Pengguna nonaktif tidak akan dapat mengakses layanan atau melakukan aktivitas login di EventHub.
                                </p>
                            </div>
                        </div>

                        @if($user->id === auth()->id())
                            <!-- Hidden input because disabled checkbox won't send value -->
                            <input type="hidden" name="is_active" value="1" />
                            <div class="mt-2 p-2.5 rounded-lg bg-info-light text-info text-xs font-medium flex items-center gap-2">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>Anda sedang mengedit akun Anda sendiri. Akun admin sendiri tidak dapat dinonaktifkan.</span>
                            </div>
                        @endif
                    </div>

                    <!-- No-Show Info (for members/organizers) -->
                    @if(in_array($user->role, ['member', 'organizer']))
                    <div class="p-4 rounded-xl bg-warning-light/30 border border-warning/20 space-y-2">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-4 h-4 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                            <span class="text-sm font-semibold text-warning">No-Show Tracking</span>
                        </div>
                        <div class="grid grid-cols-2 gap-3 text-xs">
                            <div class="p-2 rounded-lg bg-white/60">
                                <p class="text-neutral-muted">No-Show Count</p>
                                <p class="text-lg font-bold text-neutral-text">{{ $user->no_show_count }}</p>
                            </div>
                            <div class="p-2 rounded-lg bg-white/60">
                                <p class="text-neutral-muted">Status</p>
                                <p class="text-lg font-bold {{ $user->is_restricted ? 'text-error' : 'text-success' }}">
                                    {{ $user->is_restricted ? 'Dibatasi' : 'Normal' }}
                                </p>
                            </div>
                        </div>
                        @if($user->is_restricted)
                            <div class="p-2 rounded-lg bg-error-light text-error text-xs font-medium">
                                Pengguna ini dibatasi karena melebihi batas no-show. Tidak dapat mendaftar event baru.
                            </div>
                        @endif
                    </div>
                    @endif

                    <!-- Form Footer Actions -->
                    <div class="pt-6 border-t border-neutral-border space-y-3">
                        <div class="flex items-center justify-between p-3.5 bg-neutral-bg rounded-xl border border-neutral-border/60">
                            <div>
                                <p class="text-xs font-semibold text-neutral-text">Status Saat Ini</p>
                                <p class="text-xs text-neutral-muted mt-0.5">Role: <span class="capitalize font-medium text-neutral-text">{{ $user->role }}</span></p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-medium {{ $user->is_active ? 'text-success' : 'text-error' }}">
                                    {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('admin.users.index') }}" class="px-4 py-2.5 text-sm font-semibold text-neutral-text rounded-xl hover:bg-neutral-bg transition-colors">
                                Batal
                            </a>
                            <button type="submit" class="px-5 py-2.5 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary-hover transition-all shadow-xs">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
