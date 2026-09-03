<x-public-layout title="Kalender Event - EventHub">
    <div class="bg-white border-b border-neutral-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-2xl sm:text-3xl font-bold font-poppins text-neutral-text">Kalender Event</h1>
            <p class="text-sm text-neutral-muted mt-1">Lihat event dalam format kalender</p>
        </div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="calendar()" x-init="init()">
        <div class="flex items-center justify-between mb-6">
            <button @click="prevMonth()" class="px-4 py-2 text-sm font-semibold text-neutral-text border border-neutral-border rounded-xl hover:bg-neutral-bg transition-colors">&larr; Bulan Lalu</button>
            <h2 class="text-xl font-bold text-neutral-text font-poppins" x-text="monthName + ' ' + year"></h2>
            <button @click="nextMonth()" class="px-4 py-2 text-sm font-semibold text-neutral-text border border-neutral-border rounded-xl hover:bg-neutral-bg transition-colors">Bulan Depan &rarr;</button>
        </div>
        <div class="bg-white rounded-2xl border border-neutral-border shadow-sm overflow-hidden">
            <div class="grid grid-cols-7 bg-neutral-bg border-b border-neutral-border">
                <template x-for="day in ['Min','Sen','Sel','Rab','Kam','Jum','Sab']">
                    <div class="p-3 text-center text-xs font-semibold text-neutral-muted" x-text="day"></div>
                </template>
            </div>
            <div class="grid grid-cols-7">
                <template x-for="(day, index) in days" :key="index">
                    <div class="min-h-[80px] sm:min-h-[100px] p-2 border-b border-r border-neutral-border/50" :class="day.isCurrentMonth ? 'bg-white hover:bg-neutral-bg/50' : 'bg-neutral-bg/30'">
                        <span class="text-xs font-semibold" :class="day.isToday ? 'w-6 h-6 rounded-full bg-primary text-white flex items-center justify-center' : (day.isCurrentMonth ? 'text-neutral-text' : 'text-neutral-muted/50')" x-text="day.date"></span>
                        <div class="space-y-1 mt-1">
                            <template x-for="event in day.events.slice(0,2)" :key="event.id">
                                <a :href="'/events/'+event.slug" class="block px-1.5 py-0.5 rounded text-[10px] font-medium truncate bg-primary-light text-primary" x-text="event.title"></a>
                            </template>
                            <template x-if="day.events.length > 2">
                                <span class="text-[10px] text-primary font-semibold" x-text="'+'+(day.events.length-2)+' lagi'"></span>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </div>
        <div class="mt-10">
            <h2 class="text-xl font-bold text-neutral-text font-poppins mb-6">Event Mendatang</h2>
            @if(isset($upcomingEvents) && $upcomingEvents->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($upcomingEvents as $event)
                        <a href="{{ route('events.show', $event->slug) }}" class="group bg-white rounded-2xl border border-neutral-border p-5 hover:shadow-lg hover:border-primary/30 transition-all">
                            <h3 class="text-sm font-bold text-neutral-text truncate group-hover:text-primary transition-colors">{{ $event->title }}</h3>
                            <p class="text-xs text-neutral-muted mt-1">{{ $event->category->name ?? 'Event' }}</p>
                            <p class="text-xs text-neutral-muted">{{ $event->start_at ? $event->start_at->locale('id')->translatedFormat('d M Y, H:i') : '---' }}</p>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-2xl border border-neutral-border p-12 text-center"><p class="text-sm text-neutral-muted">Belum ada event mendatang.</p></div>
            @endif
        </div>
    </div>
    @push('scripts')
    <script>
    function calendar() {
        return {
            year: new Date().getFullYear(), month: new Date().getMonth(), days: [], monthName: '',
            events: @json($calendarEvents ?? []),
            init() { this.render(); },
            render() {
                var months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                this.monthName = months[this.month];
                var firstDay = new Date(this.year, this.month, 1).getDay();
                var daysInMonth = new Date(this.year, this.month+1, 0).getDate();
                var daysInPrev = new Date(this.year, this.month, 0).getDate();
                var today = new Date();
                this.days = [];
                for (var i = firstDay-1; i >= 0; i--) { this.days.push({date: daysInPrev-i, isCurrentMonth: false, isToday: false, events: []}); }
                for (var d = 1; d <= daysInMonth; d++) {
                    this.days.push({date: d, isCurrentMonth: true, isToday: d===today.getDate()&&this.month===today.getMonth()&&this.year===today.getFullYear(), events: this.getEvents(d)});
                }
                var rem = 42-this.days.length;
                for (var n = 1; n <= rem; n++) { this.days.push({date: n, isCurrentMonth: false, isToday: false, events: []}); }
            },
            getEvents(d) { return this.events.filter(e => { var dt = new Date(e.start_at); return dt.getDate()===d && dt.getMonth()===this.month && dt.getFullYear()===this.year; }); },
            prevMonth() { if(this.month===0){this.month=11;this.year--;}else{this.month--;} this.render(); },
            nextMonth() { if(this.month===11){this.month=0;this.year++;}else{this.month++;} this.render(); }
        }
    }
    </script>
    @endpush
</x-public-layout>