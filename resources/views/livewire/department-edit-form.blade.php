<div>
    <form wire:submit.prevent="saveDepartments" method="POST">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="m-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @foreach ($departments as $department)
        <div class="mb-3 department-relative">
            <x-form-label id="name{{ $department['id'] }}"
                label="Nama Jabatan {{ $loop->iteration }} (ID: {{ $department['id'] }})" />
            <div class="d-flex align-items-center">
                <x-form-input id="name{{ $department['id'] }}" name="name{{ $department['id'] }}"
                    wire:model.defer="departments.{{ $loop->index }}.name" value="{{ $department['name'] }}" />
            </div>
        </div>
        @endforeach

        <div class="d-flex justify-content-between align-items-center">
            <button class="btn btn-primary">
                Simpan
                <div wire:loading>
                    ...
                </div>
            </button>
        </div>
    </form>
</div>