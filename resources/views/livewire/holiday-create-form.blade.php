<div>
    <form wire:submit.prevent="saveHolidays" method="post" novalidate>
        @include('partials.alerts')
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="m-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @foreach ($holidays as $i => $holiday)
        <div class="mb-3">
            <div class="w-100">
                <div class="mb-3">
                    <x-form-label id="title{{ $i }}" label='Nama Hari Libur' />
                    <x-form-input id="title{{ $i }}" name="title{{ $i }}" wire:model.defer="holidays.{{ $i }}.title" />
                </div>
                <div class="mb-3">
                    <x-form-label id="description{{ $i }}" label='Keterangan' />
                    <textarea id="description{{ $i }}" name="description{{ $i }}" class="form-control"
                        wire:model.defer="holidays.{{ $i }}.description"></textarea>
                </div>
                <div class="mb-3">
                    <x-form-label id="holiday_date{{ $i }}" label='Tanggal Hari Libur' />
                    <x-form-input type="date" id="holiday_date{{ $i }}" name="holiday_date{{ $i }}" class="form-control"
                        wire:model.defer="holidays.{{ $i }}.holiday_date" />
                    <small class="text-muted d-block mt-2">Perhatikan format tanggal d (Hari), m (Bulan) dan y
                        (Tahun)</small>
                </div>
            </div>
            @if ($i > 0)
            <button class="btn btn-sm btn-danger mt-2" wire:click="removeHolidayInput({{ $i }})"
                wire:target="removeHolidayInput({{ $i }})" type="button" wire:loading.attr="disabled">Hapus</button>
            @endif
        </div>
        <hr>
        @endforeach

        <div class="d-flex justify-content-between align-items-center mb-5">
            <button class="btn btn-primary">
                Simpan
            </button>
            <button class="btn btn-light" type="button" wire:click="addHolidayInput" wire:loading.attr="disabled">
                Tambah Input
            </button>
        </div>
    </form>
</div>