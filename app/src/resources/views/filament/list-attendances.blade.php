<x-filament::page>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">

        <x-filament::card class="text-center">
            <div class="flex items-center justify-center space-x-2">
                <x-heroicon-o-user-group class="w-6 h-6 text-primary-500" />
                <span class="text-lg font-semibold text-gray-800">Absensi Mahasiswa</span>
            </div>

            <p class="mt-2 text-sm text-gray-600">
                Kelola data kehadiran seluruh mahasiswa.
            </p>

            <x-filament::button
                tag="a"
                href="{{ \App\Filament\Instructor\Resources\AttendanceResource::getUrl('student') }}"
                color="primary"
                class="mt-4"
            >
                Lihat Absensi Student
            </x-filament::button>
        </x-filament::card>

        <x-filament::card class="text-center">
            <div class="flex items-center justify-center space-x-2">
                <x-heroicon-o-academic-cap class="w-6 h-6 text-primary-500" />
                <span class="text-lg font-semibold text-gray-800">Cek Absensi Pengajar</span>
            </div>

            <p class="mt-2 text-sm text-gray-600">
                Untuk melihat absensi yang diisi oleh pengajar.
            </p>

            <x-filament::button
                tag="a"
                href="{{ \App\Filament\Instructor\Resources\AttendanceResource::getUrl('teacher') }}"
                color="primary"
                class="mt-4"
            >
                Lihat Absensi Teacher
            </x-filament::button>
        </x-filament::card>

    </div>
</x-filament::page>
